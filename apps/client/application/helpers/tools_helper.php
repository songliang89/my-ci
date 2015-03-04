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
	$specialStr = '{[!@#$%^&*()]}';
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