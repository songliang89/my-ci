<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/12
 * Time: 下午1:33
 */

// sudo tcpdump -iany tcp port 9501
date_default_timezone_set('PRC');

$client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);


$client->on("connect",function($cli){
	echo "Connected\n";
});

$client->on("receive",function($cli,$data){
	echo "Reviced:$data \n";
	sleep(1);
	$cli->send("fuck\n");
});

$client->on("close",function($cli) {
	echo "Closed\n";
});

$client->on("error",function($cli){
	echo "Connect fail:\n";
});

$client->connect("127.0.0.1", 9501);

