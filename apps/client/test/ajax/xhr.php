<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/28
 * Time: 下午2:12
 */

sleep(10);

if (rand(1, 10) < 4) {
    echo '-1';
} else {
    $redis = new Redis();
    $redis->connect("127.0.0.1", "6379");

    $vote_num = $redis->get("my_vote");
    $flag     = $redis->incr("my_vote");
    echo $flag;
}