<?php
namespace app\index\controller;
use app\common\lib\Util;
class Chart
{
    public function index()
    {
        // 登录
        if(empty($_POST['game_id'])) {
            return Util::show(config('code.error'), 'error');
        }
        if(empty($_POST['content'])) {
            return Util::show(config('code.error'), 'error');
        }

        $data = [
            'user' => "用户".rand(0, 2000),
            'content' => $_POST['content'],
        ];
        //  todo
        foreach($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($data));
        }

        return Util::show(config('code.success'), 'ok', $data);
    }


}
