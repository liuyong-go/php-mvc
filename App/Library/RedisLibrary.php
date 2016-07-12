<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/11
 * Time: 下午4:00
 */

namespace App\Library;


class RedisLibrary
{

    private static $redis=[];

    public function __construct(){

    }

    /**
     * RedisLibrary::getRedis('default')
     * @param string $db
     * @return \Redis
     */
    public static function getRedis($db='default'){
        if(!isset(self::$redis[$db])){
            self::$redis[$db] = new \Redis();
            $config = loadConfig('database');
            $redis_config = $config['redis'][$db];
            self::$redis[$db]->connect($redis_config['host'],$redis_config['port']);
            self::$redis[$db]->select($redis_config['database']);
        }
        return self::$redis[$db];
    }

}