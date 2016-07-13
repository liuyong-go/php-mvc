<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/5
 * Time: 下午2:54
 */
/**
 * 加载配置文件
 * @param $path
 * @return mixed
 */
function loadConfig($path){
    return require APPPATH.'/Config/'.$path.'.php';
}
function loadHelper($path){
    return require_once APPPATH.'/Helpers/'.$path.'.php';
}

/**
 * 加载视图文件
 * @param $file
 * @param array $data
 * @param bool|false $_return
 * @return string
 */
function views($file,$data=[]){
    return \Core\Base\View::getInstance()->views($file,$data);
}

/**
 * 打印错误
 * @param $message
 */
function show_error($message){
    views('core/show_error',['message'=>$message]);
    exit;
}

