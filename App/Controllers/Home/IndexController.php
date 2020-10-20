<?php
namespace App\Controllers\Home;
use App\Controllers\BaseController;
use App\Library\Result;
use App\Models\Home\RegisterModel;
use App\Models\Home\UserModel;
use App\Service\Home\IndexService;
use Core\Base\Request;

/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/4
 * Time: 下午1:57
 */
class IndexController extends BaseController{

    public function __construct(){
        $this->rs = new Result();
    }

    /**
     * @return false|string
     */
    public function index(){
        $res = IndexService::getInstance()->TestHello();
        return $this->rs->setCode(Result::CODE_SUCCESS)->setData($res)->toJson();
    }

}