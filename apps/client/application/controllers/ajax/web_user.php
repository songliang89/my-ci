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
		$this->load->helper('tools');
		$this->load->model('user/web_user_model');
		if (!$this->input->is_ajax_request()) {
			$jsonData = array(
				'code' => -1,
				'msg'  => "非法请求"
			);
			echo json_encode($jsonData);
			exit;
		}
	}

	public function register()
	{
		if (!$this->input->is_ajax_request()) {
			$jsonData = array(
				'code' => -1,
				'msg'  => "非法请求"
			);
			echo json_encode($jsonData);
			exit;
		}
		// 用户名
		$userName = $this->input->post('user_name');
		if ("" == $userName) {
			$jsonData = array(
				'code' => -2,
				'msg'  => '用户名不能为空'
			);
			echo json_encode($jsonData);
			exit;
		}
		//todo 验证用户名是否存在
		//todo 验证邮箱是否存在
		// 邮箱
		$email = $this->input->post('email');
		if ("" == $email) {
			$jsonData = array(
				'code' => -3,
				'msg' => '邮箱不能为空'
			);
			echo json_encode($jsonData);
			exit;
		}

		// 密码
		$password = $this->input->post('password');
		if ("" == $password) {
			$jsonData = array(
				'code' => -4,
				'msg' => '密码不能为空'
			);
			echo json_encode($jsonData);
			exit;
		}

		// saveData
		$randomStr = getRandomStr();
		$saveData = array(
			'user_name' => $userName,
			'email' => $email,
			'password' => getUserPassword($password,$randomStr),
			'salt' => $randomStr,
			'ip'   => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ""
		);
		if ($this->web_user_model->addUser($saveData)) {
			$jsonData = array(
				'code' => 1,
				'msg' => '注册成功'
			);
			echo json_encode($jsonData);
			exit;
		} else {
			$jsonData = array(
				'code' => 0,
				'msg' => '注册失败'
			);
			echo json_encode($jsonData);
			exit;
		}
	}

	/**
	 * 判断用户名是否存在.
	 */
	function is_exist_user()
	{
		$userName = trim($this->input->post("user_name"));
		$isExist = $this->web_user_model->isExistUser($userName);
		if ($isExist) {
			$json_data = array(
				'code' => 1,
				'msg' => '用户名已经被占用'
			);
			echo json_encode($json_data);
			exit;
		} else {
			$json_data = array(
				'code' => 0,
				'msg' => ''
			);
			echo json_encode($json_data);
			exit;
		}
	}

	/**
	 * 判断邮箱是否被占用
	 *
	 */
	function is_exist_email()
	{
		$email = trim($this->input->post("email"));
		$isExist = $this->web_user_model->isExistEmail($email);
		if ($isExist) {
			$json_data = array(
				'code' => 1,
				'msg' => '邮箱已经被占用'
			);
			echo json_encode($json_data);
			exit;
		} else {
			$json_data = array(
				'code' => 0,
				'msg' => ''
			);
			echo json_encode($json_data);
			exit;
		}
	}
}