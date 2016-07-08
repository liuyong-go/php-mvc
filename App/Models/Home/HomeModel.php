<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/7
 * Time: 下午4:18
 */

namespace App\Models\Home;


use App\Models\BaseModel;

class HomeModel extends BaseModel
{
    public function __construct(){
        parent::__construct();
    }
    public function test_query(){
        return $this->db->from('crm_clue')->select('crm_clue.id','crm_clue_user.name')
            ->leftJoin('crm_clue_user','crm_clue_user.id','=','crm_clue.user_id')
            ->whereIn('crm_clue.id',[9,52])->where(function($query){
                $query->where('clue_type',4)->orWhere('crm_clue.create_from',1);
            })
            ->orderBy('crm_clue.id','desc')
            ->get();
    }
    public function test_insert(){
        $arr['clueid'] =53;
        $arr['dealer_mobile'] ='15313277715';
        $arr['dealerid'] =52;
        $arr['dealername'] ='ceshi';
        return $this->db->from('crm_clue_extention')->insertGetId($arr);
    }
    public function test_update(){
        $arr['dealer_mobile'] ='10000000000';
        return $this->db->from('crm_clue_extention')->where('clueid',52)->update($arr);
    }
    public function test_delete(){
        return $this->db->from('crm_clue_extention')->whereIn('clueid',[52,53,54])->delete();
    }
}