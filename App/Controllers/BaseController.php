<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午1:58
 */
use App\Library\Result;
class BaseController{

    protected $rs;
    public function __contruct(){
        $this->rs = new Result();
    }
}