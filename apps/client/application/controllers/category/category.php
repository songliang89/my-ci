<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/10
 * Time: 下午5:27
 */
class Category extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('category/district_model');
	}

	function district()
	{
		$data = $this->district_model->getTopCategoryList();
		print_r($data);
	}
}