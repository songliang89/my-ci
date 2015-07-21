<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/8
 * Time: 上午11:02
 */

$http = new swoole_http_server('0.0.0.0',9501);
$http->on('request', function(swoole_http_request $request, swoole_http_response $response){
        /*print_r($request);
        $response->status(404); #返回状态码
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");*/
    $pathinfo = $request->server['PATH_INFO'];
    $filename = __DIR__.$pathinfo;
    if(is_file($filename)) {

        $ext = pathinfo($request->server['PATH_INFO'],PATHINFO_EXTENSION);
        if ('php' == $ext) {  //动态请求
            ob_start();
            include_once $filename;
            $content = ob_get_contents();
            ob_end_clean();
            $response->end($content);

        } else {
            $content = file_get_contents($filename);
            $response->end($content);
        }

    } else {
        $response->status(404); #返回状态码
        $response->end("not found");
    }
});
$http->start();