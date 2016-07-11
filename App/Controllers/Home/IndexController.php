<?php
namespace App\Controllers\Home;
use App\Controllers\BaseController;
use App\Library\Result;
use App\Models\Home\HomeModel;
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
        $rs = HomeModel::getInstance()->test_delete();
        print_r($rs);
    }
    public function test(){
        $result = new Result();
        echo $result->setCode(Result::CODE_SUCCESS)->setMsg('操作成功')->setData(['123','456'])->toJson();
    }
    public function user(){
        echo 'user';
    }
}