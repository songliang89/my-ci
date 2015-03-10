<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/4
 * Time: 上午11:21
 */
class User extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('tools');
	}

	public function register()
	{
		$this->load->view('user/register');
	}

	public function login()
	{
		$url = urldecode($this->input->get("url"));
		$data = array(
			'url' => $url
		);
		$this->load->view('user/login',$data);
	}

	public function index($userid)
	{

	}

	/**
	 * 退出登录.
	 */
	public function logout()
	{
		$url = urldecode($this->input->get("url"));
		setcookie("userid","",(time()+3600*24*7),'/','',false,false);
		setcookie("username","",(time()+3600*24*7),'/','',false,false);
		setcookie("user_hash","",(time()+3600*24*7),'/','',false,true);
		redirect($url);
	}
}