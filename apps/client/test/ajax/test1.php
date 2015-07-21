<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/21
 * Time: 下午3:00
 */

$redis = new Redis();
$redis->connect("127.0.0.1","6379");

$vote_num = $redis->get("my_vote");
$flag= $redis->incr("my_vote");

// 例如204状态码，当浏览器收到204时，页面不跳转。
header("HTTP/1.1 204 No Content");