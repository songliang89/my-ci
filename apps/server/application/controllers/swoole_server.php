<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/12
 * Time: 上午11:35
 */

$server = new swoole_server('127.0.0.1','9501');


$server->on('connect',function($serv,$fd,$from_id){
	echo "connect\n";
	$serv->send($fd,"Hello");
});

$server->on('receive',function(swoole_server $serv,$fd,$from_id,$data){
	echo "receive: $data\n";
	$serv->send($fd,"SERVER:$data");
});

$server->on('close',function($serv,$fd,$from_id){
	echo "close\n";
});

$server->start();