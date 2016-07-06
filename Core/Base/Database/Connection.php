<?php
namespace Core\Base\Database;
/**
 * 可连多数据库
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/6
 * Time: 下午6:10
 */
class Connection
{
    protected  $pdo = [];

    protected  $readPdo = [];

    protected  $database = [];

    protected  $connect = [];

    /**
     * 创建连接
     * @param $database
     */
    public  function setDb($database){

        if(!in_array($database,$this->connect[$database])){
            $database_config = load_config('database');
            $datainfo = $database_config[$database];
            $this->pdo[$database] = new \PDO('mysql:host='.$datainfo['write']['host'].';dbname='.$datainfo['database'].';port='.$datainfo['write']['port'],
                $datainfo['write']['username'],$datainfo['write']['password']);

            if(isset($datainfo['read'])){
                $this->readPdo[$database] = new \PDO('mysql:host='.$datainfo['read']['host'].';dbname='.$datainfo['database'].';port='.$datainfo['read']['port'],
                    $datainfo['read']['username'],$datainfo['read']['password']);
            }else{
                $this->readPdo[$database] = $this->pdo[$database];
            }
            $this->connect[] = $database;
        }
    }


}