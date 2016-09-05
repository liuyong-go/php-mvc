<?php
namespace App\Middleware;
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/6
 * Time: 下午4:00
 */
use App\Library\Result;
use Core\Base\Request;
class LoginCheck
{
    public function __construct(){

    }

    /**
     * @param Request() $request
     */
    public function handle(){
        
        return true;
    }
}