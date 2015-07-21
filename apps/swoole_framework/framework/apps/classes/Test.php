<?php
namespace App;

use Swoole\Model;

class Test
{
    static function hello()
    {
        echo __CLASS__.": load.\n";
    }

    /**
     * for SOA Server
     * @return array
     */
    static function test1()
    {
        return array('file' => __FILE__, 'method' => __METHOD__);
    }

    static function test2()
    {
        $model = Model('User');
        $user = $model->get(1);
        return $user;
    }
}