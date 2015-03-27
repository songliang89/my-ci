<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/26
 * Time: 下午2:59
 */

$config = [
    'redis_cache' => [
            'default' => [
                'host' => '127.0.0.1',
                'username' => '',
                'password' => '',
                'database' => '',
                'port' => 6379,
                'timeout' => 5
            ],
            'write' => [
                'host' => '127.0.0.1',
                'username' => '',
                'password' => '',
                'database' => '',
                'port' => 6379,
                'timeout' => 5
            ],
            'read' => [
                [
                    'host' => '127.0.0.1',
                    'username' => '',
                    'password' => '',
                    'database' => '',
                    'port' => 6379,
                    'timeout' => 6
                ],
                [
                    'host' => '127.0.0.1',
                    'username' => '',
                    'password' => '',
                    'database' => '',
                    'port' => 6379,
                    'timeout' => 7
                ],
                [
                    'host' => '127.0.0.1',
                    'username' => '',
                    'password' => '',
                    'database' => '',
                    'port' => 6379,
                    'timeout' => 8
                ]
            ],
            'cache' =>[
                'host' => '127.0.0.1',
                'username' => '',
                'password' => '',
                'database' => '',
                'port' => 6379,
                'timeout' => 5
            ],
        ]
];