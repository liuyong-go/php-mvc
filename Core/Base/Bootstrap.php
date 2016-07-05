<?php
namespace Core\Base;
use App\Controllers\Home\IndexController;

/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午1:47
 */
class Bootstrap{
    public function __construct(){

    }
    public function run(){
        spl_autoload_register([$this,'autoload']);
        $exception = new HandleExceptions();
        $exception->bootstrap();
        $route = new Route();
        $route->run();

    }

    /**
     * 自动加载方法
     * @param $classname
     */
    public function autoload($className){
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName = BASEPATH . DIRECTORY_SEPARATOR . $fileName . $className . '.php';

        if (file_exists($fileName)) {
            require $fileName;
            return true;
        }

        return false;
    }

}