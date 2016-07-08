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
                'host' => $_SERVER['DB_XIN_HOST'],
                'username' => $_SERVER['DB_XIN_USER'],
                'password' => $_SERVER['DB_XIN_PASS'],
                'port'=>3306,
            ],
            'write' => [
                'host' => $_SERVER['DB_XIN_HOST_W'],
                'username' => $_SERVER['DB_XIN_USER_W'],
                'password' => $_SERVER['DB_XIN_PASS_W'],
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