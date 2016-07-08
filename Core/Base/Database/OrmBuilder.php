<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/8
 * Time: 上午11:09
 */

namespace Core\Base\Database;


class OrmBuilder
{
    protected $connect;

    protected $database='defalut';

    private static $instance=null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function __construct(){

    }
    /**
     * 设置连接
     */
    public function connect($database){
        $this->connect = Connection::getInstance();
        $this->connect->setDb($database);
    }



}