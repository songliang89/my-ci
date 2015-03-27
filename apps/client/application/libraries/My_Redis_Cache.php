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
    public $redis;
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
        $this->redis = new Redis();
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
        } else {
            $this->_redis_config['host'] = $config["default"]['host'];
            $this->_redis_config['port'] = $config["default"]['port'];
            $this->_redis_config['timeout'] = $config["default"]['timeout'];
        }
        $this->redis->connect($this->_redis_config['host'],$this->_redis_config['port'],$this->_redis_config['timeout']);
    }

    /**
     * 缓存模型结果.
     *
     * @param       $model 模型
     * @param       $method  方法名
     * @param array $arguments
     * @param null  $ttl
     *
     * @return mixed|void
     */
    public function model($model, $method, $arguments = array(), $ttl = NULL)
    {
        if (!class_exists(ucfirst($model))) {
            $this->_ci->load->model($model);
        }
        return $this->_call($model, $method, $arguments, $ttl);
    }

    public function library($library, $method, $arguments = array(), $ttl = NULL)
    {
        if (!class_exists(ucfirst($library))) {
            $this->_ci->load->library($library);
        }
        return $this->_call($library, $method, $arguments, $ttl);
    }
    /**
     *
     *
     * @param       $property
     * @param       $method
     * @param array $arguments
     * @param null  $ttl
     *
     * @return mixed|void
     */
    private function _call($property, $method, $arguments = array(), $ttl = NULL)
    {
        $this->_ci->load->helper('security');
        if (!is_array($arguments)) {
            $arguments = (array) $arguments;
        }
        $arguments = array_values($arguments);
        $cache_redis_key = $property."-".$method.":".do_hash($method.serialize($arguments),'sha1');
        if ($ttl >= 0) {
            $cache_response = $this->redis->get($cache_redis_key);
        } else {
            $this->redis->del($cache_redis_key);
            return;
        }
        if ($cache_response !== false && $cache_response !== null) {
            return unserialize($cache_response);
        } else {
            $new_response = call_user_func_array(array($this->_ci->$property,$method),$arguments);
            $this->redis->setex($cache_redis_key,$ttl, serialize($new_response));
            return $new_response;
        }
    }

}