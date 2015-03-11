<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/4
 * Time: 下午2:58
 */

/**
 * 获取制定位数的随机字符串.
 *
 * @param int $length
 *
 * @return string
 */
function getRandomStr($length = 6)
{
	$randomStr = "";
	$ordinaryStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789";
	$specialStr = '{[!@#$%^&*()]}_=';
	$ordinaryOrspecial = array('ordinaryStr','specialStr');
	for ($i=1;$i<=$length;$i++) {
		if ('ordinaryStr' == $ordinaryOrspecial[rand(0,1)]) {
			$randomStr .= $ordinaryStr[rand(0,(strlen($ordinaryStr))-1)];
		} else {
			$randomStr .= $specialStr[rand(0,(strlen($specialStr)-1))];
		}
	}
	return $randomStr;
}

/**
 *  生成用户密码
 *
 * @param $password
 * @param $randomStr
 *
 * @return string
 */
function getUserPassword($password,$randomStr)
{
	return md5(md5($password).$randomStr);
}

/**
 * 记录登录用户cookie
 *
 * @param $userid
 * @param $username
 * @param $password
 */
function saveUserCookie($userid,$username,$password)
{
	if ($userid && $username && $password) {
		setcookie("userid",$userid,(time()+3600*24*7),'/','',false,false);
		$token = md5(md5($userid).$password);
		setcookie("username",$username,(time()+3600*24*7),'/','',false,false);
		setcookie("user_hash",$token,(time()+3600*24*7),'/','',false,true);
	}
}

if (!function_exists("isLogin")) {
	function isLogin($url = "")
	{
		$userid = isset($_COOKIE['userid']) ? (int)$_COOKIE['userid'] : 0;
		$userName = isset($_COOKIE['username']) ? $_COOKIE['username'] :"";
		if (!$userid || !$userName) {
			redirect("login?url=".$url);
		}
		return $userid;
	}
}