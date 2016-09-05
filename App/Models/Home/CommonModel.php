<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/7
 * Time: 下午4:18
 */

namespace App\Models\Home;


use App\Models\BaseModel;

class CommonModel extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 获取省份
     * @return array|static[]
     */
    public function stateList(){
        return DB()->from('city')->select('state_name','state_code')->groupBy('state_code')->get();
    }
    /**
     * 根据城市ID获取城市信息
     * @param int $cityid
     * @return array|static[]
     */
    public function getCityById($cityid){
        return DB()->from('city')->where('id',$cityid)->first();
    }

    /**
     * 根据id集合获取城市信息
     * @param $cityarr
     * @return array|static[]
     */
    public function getCityByIds($cityarr){
        return DB()->from('city')->whereIn('id',$cityarr)->get();
    }

    /**
     * 根据省份获取城市列表
     * @param $stateid
     * @return array|static[]
     */
    public function getCityByStateId($stateid){
        return DB()->from('city')->where('state_code',$stateid)->get();
    }

}