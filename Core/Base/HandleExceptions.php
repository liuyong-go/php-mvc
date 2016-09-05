<?php
namespace Core\Base;
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午2:40
 */
class HandleExceptions{
    public function __construct(){

    }
    public  function bootstrap(){
        error_reporting(-1);
        set_error_handler([$this,'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
        ini_set('display_errors', 'Off');
    }

    /**
     * 还不知什么场景触发
     * @param $level
     * @param $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = []){
        throw new \ErrorException($message, 0, $level, $file, $line);
    }

    public function handleException(){
        if(DEBUG){
            echo '<pre>';
            $traces = debug_backtrace();
            print_r($traces);
        }else{
            show_error('程序出现异常');
        }
    }

    public function handleShutdown(){
        if(error_get_last()){
            if(DEBUG) {
                echo '<pre>';
                print_r(error_get_last());
            }else{
                show_error('程序意外终止');
            }
        }

    }
}