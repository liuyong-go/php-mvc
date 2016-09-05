<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/5
 * Time: 上午10:56
 */

namespace Core\Base;


class Request
{
    private $_request=[];

    private $_routePath = [];

    private static $instance=null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * 记录请求参数
     */
    public function setRequest(){
        $request = $_REQUEST;
        $this->xssFilter($request);
        $this->_request = $request;
    }
    /**
     * 获取请求参数
     */
    public function getRequest(){
        return $this->_request;
    }

    /**
     * 获取某个键值
     * @param $key
     * @return bool
     */
    public function value($key,$xss = false){
        return isset($this->_request[$key]) ? $this->_request[$key] : false;
    }

    /**
     * XSS过滤
     * @param $value
     */
    public  function xssFilter (&$arr)
    {
        $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/',
            '/javascript/','/vbscript/','/expression/','/applet/',
            '/meta/','/xml/','/blink/','/link/','/style/','/embed/',
            '/object/','/frame/','/layer/','/title/','/bgsound/','/base/',
            '/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/',
            '/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/',
            '/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/',
            '/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');

            if (is_array($arr))
           {
             foreach ($arr as $key => $value) 
             {
                if (!is_array($value))
                {
                    if(is_string($value)){
                          if (!get_magic_quotes_gpc())             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                          {
                             $value  = addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
                          }
                          $value       = preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
                          $arr[$key]     = htmlentities($value); //去除 HTML 和 PHP 标记并转换为 HTML 实体
                    }
                }
                else
                {
                  $this->xssFilter($arr[$key]);
                }
             }
           }
    }
    /**
     * 设置请求的命名空间和方法
     */
    public function setRoutePath($data){
        $this->_routePath = $data;
    }
    /**
     * 获取请求的命名空间和方法
     */
    public function getRoutePath(){
        return $this->_routePath;
    }

}