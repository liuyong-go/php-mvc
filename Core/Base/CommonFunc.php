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
 * @param string $pos
 * @return mixed
 */
function loadConfig($path,$pos=''){
    $data = require APPPATH.'/Config/'.$path.'.php';
    return $pos ? $data[$pos] : $data;
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
function show_error($message,$url=''){
    echo views('core/show_error',['message'=>$message,'url'=>$url]);
    exit;
}

/**
 * 页面未找到
 */
function show_404(){
    echo views('core/show_404');
    exit;
}

/**
 * 提醒并跳转
 */
function show_tip($message,$url=''){
    echo views('core/tip',['message'=>$message,'url'=>$url]);
    exit;
}
/**
 * 判断请求是异步还是正常访问
 * 针对jqurey 发起异步请求
 */
function isAjax(){
    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
        return true;
    }else{
        return false;
    }
}
/**
 * 获取数据库连接
 */
function DB($database='default'){
    $DB = new \Core\Base\Database\OrmBuilder();
    $DB->connect($database);
    return $DB;
}
/**
 * 中断显示信息
 */
function dd($object){
    echo '<pre>';
    var_dump($object);
    exit;
}

/**
 * @param int $page 当前页
 * @param int  $pages 总页数
 * @param string $url 链接
 * @param int $_pageNum 分页大小
 */
function getPageHtml($page, $total,$pagesize,$is_ajax=0,$ajax_func=''){
    $pages = ceil($total/$pagesize);
    $url = $_SERVER['REQUEST_URI'];
    $page_param = mb_strpos($url,'&page');
    if($page_param !== false){
        $url = mb_substr($url,0,$page_param);
    }
    if(strpos($url,'?') === false){
        $url = $url.'?';
    }
    $_pageNum=5;
    //最多显示多少个页码
    //当前页面小于1 则为1
    $page = $page< 1 ? 1 : $page;
    //当前页大于总页数 则为总页数
    $page = $page > $pages ? $pages : $page;
    //页数小当前页 则为当前页
    $pages = $pages < $page ? $page : $pages;

    //计算开始页
    $_start = $page - floor($_pageNum/2);
    $_start = $_start<1 ? 1 : $_start;
    //计算结束页
    $_end = $page + floor($_pageNum/2);
    $_end = $_end>$pages? $pages : $_end;

    //当前显示的页码个数不够最大页码数，在进行左右调整
    $_curPageNum = $_end-$_start+1;
    //左调整
    if($_curPageNum<$_pageNum && $_start>1){
        $_start = $_start - ($_pageNum-$_curPageNum);
        $_start = $_start<1 ? 1 : $_start;
        $_curPageNum = $_end-$_start+1;
    }
    //右边调整
    if($_curPageNum<$_pageNum && $_end<$pages){
        $_end = $_end + ($_pageNum-$_curPageNum);
        $_end = $_end>$pages? $pages : $_end;
    }
    if($is_ajax){
        return ajaxPage($page,$_start,$_end,$ajax_func);
    }else{
        return htmlPage($page,$_start,$_end,$url);
    }
}
function ajaxPage($page,$_start,$_end,$func){
    $_pageHtml = '<ul class="pagination">';
    if($page>1){
        $_pageHtml .= '<li><a  title="上一页" href="javascript:'.$func.'('.($page-1).')">«</a></li>';
    }
    for ($i = $_start; $i <= $_end; $i++) {
        if($i == $page){
            $_pageHtml .= '<li class="active"><a>'.$i.'</a></li>';
        }else{
            $_pageHtml .= '<li><a href="javascript:'.$func.'('.$i.')">'.$i.'</a></li>';
        }
    }
    if($page<$_end){
        $_pageHtml .= '<li><a  title="下一页" href="javascript:'.$func.'('.($page+1).')">»</a></li>';
    }
    $_pageHtml .= '</ul>';
    return $_pageHtml;
}
function htmlPage($page,$_start,$_end,$url){
    $_pageHtml = '<ul class="pagination">';
    /*if($_start == 1){
     $_pageHtml .= '<li><a title="第一页">«</a></li>';
    }else{
     $_pageHtml .= '<li><a  title="第一页" href="'.$url.'&page=1">«</a></li>';
    }*/
    if($page>1){
        $_pageHtml .= '<li><a  title="上一页" href="'.$url.'&page='.($page-1).'">«</a></li>';
    }
    for ($i = $_start; $i <= $_end; $i++) {
        if($i == $page){
            $_pageHtml .= '<li class="active"><a>'.$i.'</a></li>';
        }else{
            $_pageHtml .= '<li><a href="'.$url.'&page='.$i.'">'.$i.'</a></li>';
        }
    }
    /*if($_end == $pages){
     $_pageHtml .= '<li><a title="最后一页">»</a></li>';
    }else{
     $_pageHtml .= '<li><a  title="最后一页" href="'.$url.'&page='.$pages.'">»</a></li>';
    }*/
    if($page<$_end){
        $_pageHtml .= '<li><a  title="下一页" href="'.$url.'&page='.($page+1).'">»</a></li>';
    }
    $_pageHtml .= '</ul>';
    return $_pageHtml;
}

