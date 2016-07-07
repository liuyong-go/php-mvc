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
        $sql = "select * from crm_clue where id in (?,?)";
        $binds = [52,9];
        return $this->db->get($sql,$binds);
    }
}