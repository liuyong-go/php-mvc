<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 2020-10-20
 * Time: 19:36
 */

namespace App\Service\Home;
use App\Models\Home\RegisterModel;
use App\Service\BaseService;

class IndexService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }
    public function TestHello(){
        $res = RegisterModel::getInstance()->getlist();
        return $res;
    }

}