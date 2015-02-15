<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 14/12/29
 * Time: 下午2:37
 */

class My_Input extends CI_Input
{
	/**
	 * 值得买GET
	 * @param type 查找的key,如果null返回全部
	 * @param type key不存在的默认返回值
	 * @param type $xss_clean
	 * @return type
	 */
	function zget($key = null, $default = null, $xss_clean = false) {
		if (null === $key && !empty($_GET)) {
			$get = array();
			$keys = array_keys($_GET);
			foreach ($keys as $key) {
				$get[$key] = $this->_fetch_from_array($_GET, $key, $xss_clean, $default);
			}
			return $get;
		}
		return $this->_fetch_from_array($_GET, $key, $xss_clean, $default);
	}

	/**
	 * 获取指定的多个变量
	 * @return type
	 */
	public function zgets(){
		$params = func_get_args();
		$return = array();
		foreach ($params as $param) {
			$return[$param] = $this->zget($param);
		}
		return $return;
	}

	/**
	 * 值得买POST
	 * @param type 查找的key,如果null返回全部
	 * @param type key不存在的默认返回值
	 * @param type $xss_clean
	 * @return type
	 */
	function zpost($key = null, $default = null, $xss_clean = false) {
		if (null === $key && !empty($_POST)) {
			$post = array();
			$keys = array_keys($_POST);
			foreach ($keys as $key) {
				$post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean, $default);
			}
			return $post;
		}
		return $this->_fetch_from_array($_POST, $key, $xss_clean, $default);
	}

	/**
	 * 获取指定的多个变量
	 * @return type
	 */
	public function zposts(){
		$params = func_get_args();
		$return = array();
		foreach ($params as $param) {
			$return[$param] = $this->zpost($param);
		}
		return $return;
	}

	/**
	 * 装换为整数，如果转换结果为零，则返回$def指定的值
	 * @param type $val
	 * @param type $def
	 * @return type
	 */
	public function zintval($val,$def = 1) {
		$def = intval($def);
		$val = intval($val);
		if(empty($val)) {
			return $def;
		}else{
			return $val;
		}
	}

	function zget_post($index = '', $default = null, $xss_clean = FALSE) {
		if (!isset($_POST[$index])) {
			return $this->zget($index, $default, $xss_clean);
		} else {
			return $this->zpost($index, $default, $xss_clean);
		}
	}

	/**
	 * 值得买REQUEST
	 * @param type 查找的key,如果null返回全部
	 * @param type key不存在的默认返回值
	 * @param type $xss_clean
	 * @return type
	 */
	function zrequest($key = '', $default = null, $xss_clean = FALSE) {
		if (null === $key && !empty($_REQUEST)) {
			$request = array();
			$keys = array_keys($_REQUEST);
			foreach ($keys as $key) {
				$request[$key] = $this->_fetch_from_array($_REQUEST, $key, $xss_clean, $default);
			}
			return $request;
		}
		return $this->_fetch_from_array($_REQUEST, $key, $xss_clean, $default);
	}

	/**
	 * 值得买COOKIE
	 * @param type 查找的key,如果null返回全部
	 * @param type key不存在的默认返回值
	 * @param type $xss_clean
	 * @return type
	 */
	function zcookie($key = null, $default = null, $xss_clean = false) {
		if (null === $key && !empty($_COOKIE)) {
			$cookie = array();
			$keys = array_keys($_COOKIE);
			foreach ($keys as $key) {
				$cookie[$key] = $this->_fetch_from_array($_COOKIE, $key, $xss_clean, $default);
			}
			return $cookie;
		}
		return $this->_fetch_from_array($_COOKIE, $key, $xss_clean, $default);
	}
}