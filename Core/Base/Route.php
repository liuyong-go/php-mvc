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
    public function __construct(){

    }

    /**
     * 根据路由执行控制器方法
     */
    public function run(){
        $path = $this->_parseRoutes();
        $this->_runController($path);
    }

    /**
     * 匹配路由
     */
    protected  function _parseRoutes(){
        $routes = load_config('routes');
        $request_uri = $_SERVER['REQUEST_URI'];
        if($request_uri == '/'){
            return $routes['default_route'];
        }
        $uri_arr = explode('/',ltrim($request_uri,'/'));
        $controller_path = '';
        //遍历控制器，
        if(isset($routes['controller_route'][$uri_arr[0]])){
            $controller_path = $routes['controller_route'][$uri_arr[0]];
        }else{//无则遍历正则
            foreach($routes['preg_route'] as $key=>$val){
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
        echo $path;
        $pathParam = explode('/',$path);
        $namespace = ucfirst($pathParam[0]);
        $controller = ucfirst($pathParam[1]).'Controller';
        $action = $pathParam[2];
        $params = array_slice($pathParam,3);

    }
    /**
     * 设置请求
     */
    protected function _setRequest(Request $request){

    }

}