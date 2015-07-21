<?php
namespace BL;

class Test
{
    static function test1($str)
    {
        return "hello-soa-finish: $str";
    }

    static function hello()
    {
        return array('key1' => 'A', 'key2' => 'B');
    }

    static function test3()
    {
        #return array('111','2222','4444');
        return array('key1' => 'A', 'key2' => 'B');
    }
}