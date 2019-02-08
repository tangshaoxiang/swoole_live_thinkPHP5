<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/27
 * Time: 上午12:50
 */
namespace server;
class Websocket {
    CONST HOST = "0.0.0.0";
    CONST PORT = 8811;

    public $http = null;
    public function __construct() {
        $this->http = new \swoole_websocket_server(self::HOST, self::PORT);

        $this->http->set(
            [
                'enable_static_handler' => true,
                'document_root' => "/home/wwwroot/www.darian.xin/swoole_live_thinkPHP5/public/static",
                'worker_num' => 4,
                'task_worker_num' => 4,
            ]
        );


        $this->http->on("workerstart", [$this, 'onWorkerStart']);
        $this->http->on("request", [$this, 'onRequest']);
        $this->http->on("open", [$this, 'onOpen']);
        $this->http->on("message", [$this, 'onMessage']);
        $this->http->on("task", [$this, 'onTask']);
        $this->http->on("finish", [$this, 'onFinish']);
        $this->http->on("close", [$this, 'onClose']);

        $this->http->start();
    }


    /**
     * onOpen
     */
    public function onOpen($http, $request) {
        // fd redis [1]
        \home\wwwroot\www.'.'.darian.'.'.xin\swoole_live_thinkPHP5\server\Tredis::getInstance()->test(config('redis.live_game_key'), $request->fd);
        var_dump($request->fd);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($http, $frame) {
        echo "ser-push-message:{$frame->data}\n";
        $http->push($frame->fd, "server-push:".date("Y-m-d H:i:s"));
    }

    /**
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server,  $worker_id) {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');
        // 加载框架里面的文件
        require __DIR__ . '/../thinkphp/base.php';
//        require __DIR__ . '/../thinkphp/start.php';
    }

    /**
     * request回调
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response) {
        $_SERVER  =  [];
        if(isset($request->server)) {
            foreach($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if(isset($request->header)) {
            foreach($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        $_GET = [];
        if(isset($request->get)) {
            foreach($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }
        $_POST = [];
        if(isset($request->post)) {
            foreach($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }

        $_POST['http_server'] = $this->http;

        ob_start();
        // 执行应用并响应
        try {
            think\Container::get('app',[defined('APP_PATH') ? APP_PATH : ''])
                ->run()
                ->send();
        }catch (\Exception $e) {
            // todo
        }

        $res = ob_get_contents();
        ob_end_clean();
        $response->end($res);
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     */
    public function onTask($serv, $taskId, $workerId, $data) {

        // 分发 task 任务机制，让不同的任务 走不同的逻辑
        $obj = new \app\common\lib\task\Task;

        $method = $data['method'];
        $flag = $obj->$method($data['data']);
        /*$obj = new app\common\lib\ali\Sms();
        try {
            $response = $obj::sendSms($data['phone'], $data['code']);
        }catch (\Exception $e) {
            // todo
            echo $e->getMessage();
        }*/

        return $flag; // 告诉worker
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-sucess:{$data}\n";
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
                \app\common\lib\redis\Predis::getInstance()->sRem(config('redis.live_game_key'), $fd);

        echo "clientid:{$fd}\n";
    }
}

new Websocket();