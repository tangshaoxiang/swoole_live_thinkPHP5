<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/4/2
 * Time: 上午11:47
 */
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架里面的文件
//require __DIR__ . '/../thinkphp/base.php';
require __DIR__ . '/../thinkphp/start.php';

app\common\lib\redis\Predis::getInstance()->sRem('call1', 'singwa1');