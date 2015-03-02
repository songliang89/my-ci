<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/28
 * Time: 下午1:18
 */
class Zdm_search extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('es');
		$this->load->helper('url');
	}

	function index()
	{
		$this->load->view('zdm_search');
	}
}