<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/4
 * Time: 下午2:52
 */
class Web_user extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function register()
	{
		$postData = $this->input->post();
		
	}
}