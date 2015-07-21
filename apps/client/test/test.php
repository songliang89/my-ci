<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/14
 * Time: 上午10:12
 */

$str = implode($_POST, "\n");

file_put_contents("./post.txt",$str);
echo "write ok";