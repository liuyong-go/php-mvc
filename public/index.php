<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/1
 * Time: 下午5:49
 */
define('BASEPATH',dirname(dirname(__FILE__)));

define('COREPATH',BASEPATH.'/Core');

define('APPPATH',BASEPATH.'/App');

header("Content-type: text/html; charset=utf-8");

require COREPATH.'/Base/CommonFunc.php';

$app_config = require APPPATH.'/Config/app.php';

define('DEBUG',$app_config['debug']);

date_default_timezone_set($app_config['timezone']);

require COREPATH.'/Base/Bootstrap.php';

$app = new \Core\Base\Bootstrap();

$app->run();

