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
		$this->load->view('user/login');
	}
}