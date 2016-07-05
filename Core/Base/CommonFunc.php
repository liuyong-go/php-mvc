<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/5
 * Time: 下午2:54
 */
function load_config($path){
    return require_once APPPATH.'/Config/'.$path.'.php';
}