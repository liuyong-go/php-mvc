<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/11
 * Time: 下午2:27
 */

namespace App\Library;


class BaseLibrary
{

    /**
     * 服务对象静态实例
     *
     * @var static
     */
    protected static $container=[];

    public function __construct(){

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