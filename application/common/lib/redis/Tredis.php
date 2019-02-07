<?php
/**
 * Created by PhpStorm.
 * User: Ty_Ro
 * Date: 2019/2/8
 * Time: 0:54
 */
namespace application\common\lib\redis;
class  Tredis {
    public $redis = "";
    /**
     * 定义单例模式的变量
     * @var null
     */
    private static $_instance = null;

    public static function getInstance() {
//        if(empty(self::$_instance)) {
            self::$_instance = new self();
//        }
        return self::$_instance;
    }

    private function __construct() {
    }

    public function test($key){
        return 11111111111;
    }
}