<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/13
 * Time: 下午8:23
 */

namespace Core\Base;

/**
 *
 * Class View
 * @package Core\Base
 */
class View
{
    /**
     * 保存view中传递的参数
     * @var array
     */
    private $_viewParams=[];


    private static $instance=null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function views($file,$data=[]){
        if($data){
            $this->_viewParams = $data;
        }else{
            $data = $this->_viewParams;
        }
        extract($data);
        ob_start();
        $viewPath = APPPATH.'/Views/'.$file.'.php';
        include($viewPath);
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }
}