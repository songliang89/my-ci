<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once '/Users/smzdm/www/my-ci/apps/client/application/third_party/jsonRpc/client/RpcClient.php';

class Welcome extends CI_Controller {

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
	public function index()
	{

		$address_array = array(
			'tcp://127.0.0.1:2015',
			'tcp://127.0.0.1:2015'
		);
// 配置服务端列表
		RpcClient::config($address_array);

		$uid = 567;

// User对应applications/JsonRpc/Services/User.php 中的User类
		//$user_client = RpcClient::instance('User');
		$user_client = RpcClient::instance('Article');

// getInfoByUid对应User类中的getInfoByUid方法
		//$ret_sync = $user_client->getInfoByUid($uid);
		$ret_sync = $user_client->getInfo($uid);
		print_r($ret_sync);

			$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */