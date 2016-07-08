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
        $sql = 'select * from crm_clue where id in (?,?)';
        $binds = [52,9];
        return $this->db->get($sql,$binds);
    }
    public function test_insert(){
        $arr['clueid'] =54;
        $arr['dealer_mobile'] ='15313277715';
        $arr['dealerid'] =52;
        $arr['dealername'] ='ceshi';
        return $this->db->insertLastId('crm_clue_extention',$arr);
    }
    public function test_update(){
        $arr['dealer_mobile'] ='10000000000';
        return $this->db->update('crm_clue_extention',$arr,'clueid=?',[52],true);
    }
    public function test_delete(){
        return $this->db->delete('crm_clue_extention','clueid in(?,?)',[53,54],true);
    }
}