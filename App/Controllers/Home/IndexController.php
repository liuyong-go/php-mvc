<?php
namespace App\Controllers\Home;
use App\Controllers\BaseController;
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午1:57
 */
class IndexController extends BaseController{

    public function __construct(){

    }
    public function test(){
        dd();
        echo 'test';
    }
    public function user(){
        echo 'user';
    }
}