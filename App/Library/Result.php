<?php
/**
 *返回结果通用类
 * User: jiangtiezhu
 * Date: 15/10/23
 * Time: 上午10:46
 */
namespace App\Library;

class Result
{

    /**
     *
     * 更新缓存数据
     */
    const CODE_SUCCESS = 1;
    /**
     * 请求失败
     */
    const CODE_ERROR = -1;
    /**
     * 更新数据缓存
     */
    const CODE_UPDATE = 2;
    /**
     * 没有权限
     */
    const CODE_NOAUTH = -402;
    /**
     * 下载最新app
     */
    const CODE_DOWNLOAD_APP = -405;
    /**
     * 未登录或者登陆失效
     */
    const CODE_NO_LOGIN = -401;
    /**
     * 地址要临时转移到指定页面
     */
    const  CODE_REDIRECT = 302;
    /**
     * 禁止访问
     */
    const  CODE_FORBIDDEN = 403;


    private $reslut_arr = [
        'code' => -1,
        'msg' => '',
        'data' => '',
        'cnt' => 0,
        'version'=>'',
    ];

    public function __construct()
    {
        $this->_code = -1;
    }

    /**
     * 初始化
     *
     * @param
     *            $code
     * @param string $msg
     * @param string $data
     * @param int $cnt
     */
    public function init($code, $msg = '', $data = '', $cnt = 0)
    {
        $this->reslut_arr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'cnt' => $cnt
        ];
    }

    /**
     *
     * @param $code Result::CODE_SUCCESS
     */
    public function setCode($code)
    {
        $this->reslut_arr['code'] = $code;
        return $this;
    }
    public function getCode()
    {
        return $this->reslut_arr['code'];
    }

    /**
     *
     * @param $msg 原因
     */
    public function setMsg($msg)
    {
        $this->reslut_arr['msg'] = $msg;
        return $this;
    }
    public function getMsg()
    {
        return $this->reslut_arr['msg'] ;
    }

    /**
     *
     * @param $data object
     *            数据
     */
    public function setData($data)
    {
        $this->reslut_arr['data'] = $data;
        return $this;
    }
    public function getData()
    {
        return  $this->reslut_arr['data'];
    }

    /**
     *
     * @param $version 接口版本号
     */
    public function setVersion($version)
    {
        $this->reslut_arr['version'] = $version;
        return $this;
    }
    public function getVersion()
    {
        return $this->reslut_arr['version'];
    }

    /**
     *
     * @return array 输出数组
     */
    public function toArray()
    {
        return $this->reslut_arr;
    }

    /**
     * 规范化的json
     *
     * @param int $code （-1:失败
     *            1：成功 2：更新 -401:没有权限）
     * @param string $msg
     * @param string $data
     * @param int $cnt （data
     *            数组个数）
     */
    public function toJson()
    {
        //header("Content-type: application/json; charset=utf-8");
        return json_encode($this->reslut_arr);
    }
}