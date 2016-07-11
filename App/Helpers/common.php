<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/11
 * Time: 下午2:50
 */
function ip(){
    $realip = '0.0.0.0';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($arr AS $ip) {
            $ip = trim($ip);
            if ($ip != 'unknown') {
                $realip = $ip;
                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
        $realip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $realip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    }
    return $realip;
}
