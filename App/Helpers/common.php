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

//加密
function setCode($cookies){
    $auth_key = $cookies."&1000";
    return sys_auth($auth_key,'ENCODE');
}
//解密
function getCode($str){
    $auth_key = sys_auth($str,'DECODE');
    $rt = explode("&",$auth_key);
    if(isset($rt[1]) && ($rt[1] === '1000')){
        return $rt[0];
    }else{
        return false;
    }
}
/**
 * 字符串加密、解密函数
 * @param	string	$txt		字符串
 * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
 * @param	string	$key		密钥：数字、字母、下划线
 * @return	string
 */
function sys_auth($txt, $operation = 'ENCODE', $key = '')
{
    $auth = loadConfig('auth');
    $key	= $key ? $key : $auth['cookie_auth_key'];
    $txt	= $operation == 'ENCODE' ? (string)$txt : base64_decode($txt);
    $len	= strlen($key);
    $code	= '';
    for($i=0; $i<strlen($txt); $i++)
    {
        $k		= $i % $len;
        $code  .= $txt[$i] ^ $key[$k];
    }
    $code = $operation == 'DECODE' ? $code : base64_encode($code);
    return $code;
}

//验证手机格式
function isMobile($mobile){
    if(!$mobile){
        return false;
    }
    $pattern = "/^[1]{1}[0-9]{1}[0-9]{9}$/";
    if(!preg_match($pattern,$mobile)){
        return false;
    }
    return true;
}
//验证邮箱
function isEmail($email){
    if(!$email){
        return false;
    }
    $pattern = "/^([a-zA-Z0-9]+[_|\_|\.\-]?)*[a-zA-Z0-9]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,8}$/";
    if(!preg_match($pattern,$email)){
        return false;
    }
    return true;
}
