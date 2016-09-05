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
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => '123',
                'port'=>3306,
            ],
            'write' => [
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => '123',
                'port'=>3306,
            ],
            'database' => 'market',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ]
    ],
    'redis'=>[
        'default'=>[
            'host' => '127.0.0.1',
            'port' => '6379',
            'database'=>'0'
        ],
        'default1'=>[
            'host' => '127.0.0.1',
            'port' => '6379',
            'database'=>'1'
        ],
    ]
];