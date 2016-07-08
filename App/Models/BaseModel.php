<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/7
 * Time: 下午4:09
 */

namespace App\Models;


use Core\Base\Database\Connection;
use Core\Base\Database\OrmBuilder;

class BaseModel
{
    /**
     * 服务对象静态实例
     *
     * @var static
     */
    protected static $container=[];

    protected $db;

    public function __construct(){
        $this->db = OrmBuilder::getInstance();
        $this->db->connect('default');
    }
    /**
     * 服务对象实例（单例模式）
     * @return static
     */
    public static function getInstance()
    {

        if(!isset(static::$container[static::class]) ||  empty(static::$container[static::class]))
        {
            static::$container[static::class] =new static();
        }
        return static::$container[static::class];
    }

}