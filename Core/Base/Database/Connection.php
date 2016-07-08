<?php
namespace Core\Base\Database;
use PDO;
use Closure;
/**
 * 可连多数据库
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/6
 * Time: 下午6:10
 */
class Connection
{
    /**
     * The active PDO connection.
     *
     * @var PDO
     */
    protected  $pdo;
    /**
     * The active PDO connection.
     *
     * @var PDO
     */
    protected  $readPdo;

    protected $transactions=0;

    private static $instance=null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    /**
     * 创建连接
     * @param $database
     */
    public function setDb($database){
            $database_config = load_config('database');
            $datainfo = $database_config['connections'][$database];
            $this->pdo = new \PDO('mysql:host='.$datainfo['write']['host'].';dbname='.$datainfo['database'].';port='.$datainfo['write']['port'],
                $datainfo['write']['username'],$datainfo['write']['password']);

            if(isset($datainfo['read'])){
                $this->readPdo = new \PDO('mysql:host='.$datainfo['read']['host'].';dbname='.$datainfo['database'].';port='.$datainfo['read']['port'],
                    $datainfo['read']['username'],$datainfo['read']['password']);
            }else{
                $this->readPdo = $this->pdo;
            }
    }
    public function getPdo($sql){
        return $this->transactions>0 ? $this->pdo : ($this->is_write_type($sql) ? $this->pdo : $this->readPdo);
    }

    /**
     * @param $sql
     * @param array $bind
     * @return \PDOStatement
     */
    public function query($sql,$bind=[],$useWritePdo=false){
        $pdo = $useWritePdo ? $this->pdo : $this->getPdo($sql);
        $sth = $pdo->prepare($sql);
        $sth->execute($bind);
        return $sth;
    }
    /**
     * 获取多条记录
     */
    public function select($sql,$bind=[],$useWritePdo = false){
        $result = $this->query($sql,$bind,$useWritePdo);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * 获取一条记录
     */
    public function selectOne($sql,$bind=[],$useWritePdo = true){
        $result = $this->query($sql,$bind,$useWritePdo);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 判断sql 为写
     *
     * @param	string	An SQL query string
     * @return	bool
     */
    public function is_write_type($sql)
    {
        return (bool) preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD|COPY|ALTER|RENAME|GRANT|REVOKE|LOCK|UNLOCK|REINDEX)\s/i', strtoupper($sql));
    }

    /**
     * 执行一个sql 返回true 或false $affect 为true 返回影响的行数
     * @param $sql
     * @param array $bind
     * @return bool
     */
    public function statement($sql,$bind=[],$affect = false,$useWritePdo=true){
        $pdo = $useWritePdo ? $this->pdo : $this->getPdo($sql);
        $sth = $pdo->prepare($sql);
        $rs = $sth->execute($bind);
        return $affect ? $sth->rowCount() : $rs;
    }


    /**
     * 插入记录
     * @param $table
     * @param $values
     */
    public function insert($table,$values,$affect = false){
        list($values,$binds) = $this->toBind($values);
        $fields = implode(',',array_keys($values));
        $value = implode(',',array_values($values));
        $sql = 'insert into '.$table.' ('.$fields.') values ('.$value.')';
        return $this->statement($sql,$binds,$affect);
    }
    /**
     *
     */
    public function insertLastId($table,$values){
        try{
            $this->insert($table,$values);
        }catch (\Exception $e){
            throw $e;
        }
        return $this->pdo->lastInsertId();
    }

    /**
     * 更新
     * @param $table
     * @param $value
     * @param $where
     */
    public function update($table,$values,$where,$whereBinds=[],$affect = false){
        if(!$values){
            throw new \Exception('ivalid field');
        }
        list($values,$binds) = $this->toBind($values);
        foreach($values as $key=>$val){
            $valstr[] = $key.' = '.$val;
        }
        $sql = 'update '.$table.' set '.implode(',',$valstr).' where '.$where;
        return $this->statement($sql,array_merge($binds,$whereBinds),$affect);
    }

    /**
     * 删除
     * @param $table
     * @param $where
     */
    public function delete($table,$where,$whereBinds=[],$affect = false){
        $sql = 'delete from '.$table.' where '.$where;
        return $this->statement($sql,$whereBinds,$affect);
    }
    /**
     * 数组直接转换成 key:? [value]格式
     */
    public function toBindParam($values,$prefix='field'){
        $value = $binds = [];
        foreach($values as $key=>$val){
            $bindkey = ':'.$prefix.$key;
            $value[$key] = $bindkey;
            $binds[$bindkey] = $val;
        }
        return [$value,$binds];
    }
    /**
     * 数组直接转换成 key:? [value]格式
     */
    public function toBind($values,$prefix='field'){
        $value = $binds = [];
        foreach($values as $key=>$val){
            $value[$key] = '?';
            $binds[] = $val;
        }
        return [$value,$binds];
    }
    /**
     * 闭包执行一个事务
     *
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Throwable
     */
    public function transaction(Closure $callback)
    {
        $this->beginTransaction();

        try {
            $result = $callback($this);

            $this->commit();
        }

        catch (\Exception $e) {
            $this->rollBack();

            throw $e;
        } catch (\Throwable $e) {
            $this->rollBack();

            throw $e;
        }

        return $result;
    }

    /**
     * 启动事务
     *
     * @return void
     */
    public function beginTransaction()
    {
        ++$this->transactions;

        if ($this->transactions == 1) {
            $this->pdo->beginTransaction();
        }
    }

    /**
     * 提交事务
     *
     * @return void
     */
    public function commit()
    {
        if ($this->transactions == 1) {
            $this->pdo->commit();
        }
        --$this->transactions;
    }

    /**
     * 回滚
     *
     * @return void
     */
    public function rollBack()
    {
        if ($this->transactions == 1) {
            $this->transactions = 0;
            $this->pdo->rollBack();
        }else{
            --$this->transactions;
        }
    }

    /**
     * 获取当前启动的事务数量
     *
     * @return int
     */
    public function transactionLevel()
    {
        return $this->transactions;
    }






}