<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/1/27
 * Time: 下午5:46
 */
class Article
{
	private static  $_ci;

	function __construct()
	{
		self::$_ci = &get_instance();
		self::$_ci->load->model('product_article');
		print_r(self::$_ci);
	}

	static function getInfo($id)
	{
		$data = self::$_ci->product_article->getInfo($id);
		print_r($data);
		return self::$_ci->product_article->getInfo($id);
	}
}