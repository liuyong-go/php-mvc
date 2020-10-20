<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/7
 * Time: 下午4:18
 */

namespace App\Models\Home;


use App\Models\BaseModel;

class RegisterModel extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 获取省份
     * @return array|static[]
     */
    public function getlist(){
        return DB()->from('server_register')->select('server_name','address')->get();
    }


}