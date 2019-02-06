<?php
/**
 * Created by PhpStorm.
 * User: Ty_Ro
 * Date: 2018/7/5
 * Time: 0:24
 */
$http = new swoole_http_server("0.0.0.0", 8811);

$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/home/wwwroot/default/thinkPHPs/public/static",
        'worker_num' => 5,
    ]
);
$http->on('request', function($request, $response) {

    $response->cookie("singwa", "xsssss", time() + 1800);
    $response->end("sss". json_encode($request->get));
});

$http->start();