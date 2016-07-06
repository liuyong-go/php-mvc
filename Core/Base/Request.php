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
        $this->_request = $this->_filterRequest($request);
    }
    private function _filterRequest($request){
        if(is_array($request)){
            foreach($request as $key=>$val){
                if(is_array($val)){
                    $request[$key] = $this->_filterRequest($val);
                }else{
                    $request[$key] = $this->_filterParam($val);
                }
            }
            return $request;
        }else{
            return $this->_filterParam($request);
        }
    }
    /**
     * 过滤输入参数
     */
    private function _filterParam($request){
        return trim(htmlspecialchars($request));
    }
    /**
     * 获取请求参数
     */
    public function getRequest(){
        return $this->_request;
    }

}