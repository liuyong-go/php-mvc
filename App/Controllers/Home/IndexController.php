<?php
namespace App\Controllers\Home;
use App\Controllers\BaseController;
use App\Library\Result;
use App\Models\Home\UserModel;
use Core\Base\Request;

/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午1:57
 */
class IndexController extends BaseController{

    public function __construct(){

    }
    public function index(){
       echo 'index';
    }

}