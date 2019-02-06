<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/26
 * Time: 上午3:52
 */
namespace app\common\lib\redis;
class Predis {
    public $redis = "";
    /**
     * 定义单例模式的变量
     * @var null
     */
    private static $_instance = null;

    public static function getInstance() {
        if(empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->redis = new \Redis();
        $result = $this->redis->connect(config('redis.host'), config('redis.port'), config('redis.timeOut'));
        if($result === false) {
            throw new \Exception('redis connect error');
        }
    }

    /**
     * set
     * @param $key
     * @param $value
     * @param int $time
     * @return bool|string
     */
    public function set($key, $value, $time = 0 ) {
        if(!$key) {
            return '';
        }
        if(is_array($value)) {
            $value = json_encode($value);
        }
        if(!$time) {
            return $this->redis->set($key, $value);
        }

        return $this->redis->setex($key, $time, $value);
    }

    /**
     * get
     * @param $key
     * @return bool|string
     */
    public function get($key) {
        if(!$key) {
            return '';
        }

        return $this->redis->get($key);
    }

    /**
     * @param $key
     * @return array
     */
    public function sMembers($key) {
        return $this->redis->sMembers($key);
    }

    /**
     * @param $name
     * @param $arguments
     * @return array
     */
//    public function __call($name, $arguments) {
//        //echo $name.PHP_EOL;
//        //print_r($arguments);
//        if(count($arguments) != 2) {
//            return '';
//        }
//        $this->redis->$name($arguments[0], $arguments[1]);
//    }

/**
 * redis增加有序集合的值
 */
    public function sAdd($key,$val){
        return $this->redis->sAdd($key,$val);
    }

    /**
     * redis删除有序集合的值
     */
    public function sRem($key,$val){
        return $this->redis->sRem($key,$val);
    }

    /**
     * 删除key
     */
    public function del($key){
        return $this->redis->del($key);
    }

}