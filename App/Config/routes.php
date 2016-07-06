<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/5
 * Time: 上午11:04
 */
return [
    'default_route'=>'home/index',
    'controller_route'=>[
        'index'=>'home/index',
        'test'=>'home/test'
    ],
    'preg_route'=>[
        'u_([0-9]+)_([0-9]+)'=>'home/index/user/$1/$2',
    ],
    /**
     * 前置中间件
     */
    'pre_middleware'=>[
        'Home\IndexController'=>['LegalCheck','LoginCheck']
    ],
    /**
     * 后置中间件
     */
    'suffix_middleware'=>[
        'Home\IndexController'=>['OverDo']
    ]
];