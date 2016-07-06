<?php
/**
 * 数据库配置
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/6
 * Time: 下午5:40
 */
return [
    'connections'=>[
        'default'=>[
            'read' => [
                'host' => '172.16.98.12',
                'username' => 'xin',
                'password' => '123456',
                'port'=>3306,
            ],
            'write' => [
                'host' => '172.16.98.12',
                'username' => 'xin',
                'password' => '123456',
                'port'=>3306,
            ],
            'database' => 'xin',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ]
    ]
];