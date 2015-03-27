<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/26
 * Time: 下午2:46
 */

class My_Redis_Cache
{
    private $_ci;
    public $_redis;
    private $_redis_config = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'timeout' => 5
    );

    function __construct($conn = array())
    {
        $this->_ci = & get_instance();
        $this->_ci->config->load('redis_cache');
        $config = $this->_ci->config->item('redis_cache');
        $this->_redis = new Redis();
        $connect = isset($conn['connect']) ? $conn['connect'] : "default";
        if ("write" == $connect) {
            $this->_redis_config['host'] = $config["$connect"]['host'];
            $this->_redis_config['port'] = $config["$connect"]['port'];
            $this->_redis_config['timeout'] = $config["$connect"]['timeout'];
        } else if ("read" == $connect) {
            $read_count = count($config[$connect]);
            $rand_mumber = rand(0,$read_count-1);
            $this->_redis_config['host'] = $config["$connect"]["$rand_mumber"]['host'];
            $this->_redis_config['port'] = $config["$connect"]["$rand_mumber"]['port'];
            $this->_redis_config['timeout'] = $config["$connect"]["$rand_mumber"]['timeout'];
        }
        $this->_redis->connect($this->_redis_config['host'],$this->_redis_config['port'],$this->_redis_config['timeout']);
    }

    

}