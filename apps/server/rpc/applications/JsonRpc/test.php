<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/1/27
 * Time: 下午2:55
 */
date_default_timezone_set('PRC');
include_once "Clients/RpcClient.php";

$address_array = array(
	'tcp://127.0.0.1:2015',
	'tcp://127.0.0.1:2015'
);
// 配置服务端列表
RpcClient::config($address_array);

$uid = 567;

// User对应applications/JsonRpc/Services/User.php 中的User类
$user_client = RpcClient::instance('User');

$ret_sync = $user_client->test();
print_r($ret_sync);
exit;
// getInfoByUid对应User类中的getInfoByUid方法
#$ret_sync = $user_client->getUser();
$i = 1;
while($i<1000) {
    $ret_sync = $user_client->getUser();
    $i++;
}
print_r($ret_sync);