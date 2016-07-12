<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/5
 * Time: 上午10:22
 */

namespace Core\Base;


class Route
{

    protected $controller;

    protected $action;

    public $config_routes=[];

    public function __construct(){

    }

    /**
     * 根据路由执行控制器方法
     */
    public function run(){
        $this->config_routes = loadConfig('routes');
        $path = $this->_parseRoutes();
        Request::getInstance()->setRequest();
        $this->_runController($path);
    }

    /**
     * 匹配路由
     */
    protected  function _parseRoutes(){
        $request_uri = $_SERVER['REQUEST_URI'];
        $rs_uri_arr = explode('?',$request_uri);
        $request_uri = $rs_uri_arr[0];
        if($request_uri == '/'){
            return $this->config_routes['default_route'];
        }
        $uri_arr = explode('/',ltrim($request_uri,'/'));
        $controller_path = '';
        //遍历控制器，
        if(isset($this->config_routes['controller_route'][$uri_arr[0]])){
            $controller_path = $this->config_routes['controller_route'][$uri_arr[0]];
            array_shift($uri_arr);
            $controller_path .= '/'.implode('/',$uri_arr);
            return $controller_path;
        }else{//无则遍历正则
            foreach($this->config_routes['preg_route'] as $key=>$val){
                if (preg_match('#^/'.$key.'$#', $request_uri, $matches))
                {
                    if(strpos($val,'$') !== false && strpos($key,'(') !== false){
                        $val = preg_replace('#^/'.$key.'$#', $val, $request_uri);
                        return $val;
                    }
                }
            }
        }
        if($controller_path == ''){
            show_error('没有找到控制器');
        }
    }
    /**
     * $path namespace/controller/action/p/p...
     * 运行控制器
     */
    protected function _runController($path){
        $pathParam = explode('/',$path);
        $namespace = ucfirst($pathParam[0]);
        $controller = ucfirst($pathParam[1]).'Controller';
        $this->action = isset($pathParam[2]) && $pathParam[2] ? $pathParam[2] : 'index';
        $params = array_slice($pathParam,3);
        $this->controller = $namespace.'\\'.$controller;
        $classname =   'App\Controllers\\'.$namespace.'\\'.$controller;
        $this->_preMiddleWare();
        $classReflection = new \ReflectionClass($classname);
        $class = $classReflection->newInstance();
        $result = call_user_func_array([$class,$this->action],$params);
        echo $result;
        $this->_suffixMiddleWare();
        exit;
    }

    /**
     * 执行控制前执行
     */
    protected function _preMiddleWare(){
        $pre_middle = $this->config_routes['pre_middleware'];
        if(isset($pre_middle[$this->controller])){
            foreach($pre_middle[$this->controller] as $mid){
                $classname =   'App\Middleware\\'.$mid;
                $classReflection = new \ReflectionClass($classname);
                $class = $classReflection->newInstance();
                $class->handle(Request::getInstance()->getRequest());
            }
        }
    }

    /**
     * 执行完控制器后执行
     */
    protected function _suffixMiddleWare(){
        $suffix_middle = $this->config_routes['suffix_middleware'];
        if(isset($suffix_middle[$this->controller])){
            foreach($suffix_middle[$this->controller] as $mid){
                $classname =   'App\Middleware\\'.$mid;
                $classReflection = new \ReflectionClass($classname);
                $class = $classReflection->newInstance();
                $class->handle(Request::getInstance()->getRequest());
            }
        }
    }

}