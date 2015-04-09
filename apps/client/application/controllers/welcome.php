<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function index()
	{
		/*$this->load->library('authcode');
		$this->load->library('session');*/
		$this->load->library('My_Redis_Cache',array("connect" => "default"),'redis_cache');
        $this->load->model('user/web_user_model','web_user_model');
        $data = $this->redis_cache->model('web_user_model','getInfoByName',array('admin'),1000);
        print_r($data);

		//echo $this->authcode->show();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */