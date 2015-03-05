<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/4
 * Time: 下午2:42
 *
 *
 *
 * CREATE TABLE `web_user` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_name` varchar(45) NOT NULL DEFAULT '' COMMENT '用户名',
	`email` varchar(200) NOT NULL DEFAULT '' COMMENT '用户邮箱',
	`nick_name` varchar(45) NOT NULL DEFAULT '' COMMENT '用户昵称',
	`password` varchar(45) NOT NULL,
	`is_deleted` tinyint(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否被删除0:未被删除1:已删除',
	`status` tinyint(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态',
	`ip` varchar(50) NOT NULL DEFAULT '' COMMENT '注册ip',
	`salt` varchar(10) NOT NULL DEFAULT '' COMMENT '密码延长字符串加密用',
	`phone` varchar(50) NOT NULL DEFAULT '' COMMENT '手机号',
	`register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
	PRIMARY KEY (`id`),
	UNIQUE KEY `idx_user_name` (`user_name`) USING BTREE,
	UNIQUE KEY `idx_email` (`email`) USING BTREE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8
 */

/**
 * Class Web_user
 */
class Web_user_model extends MY_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function tableName()
	{
		return 'web_user';
	}

	public function primaryKey()
	{
		return 'id';
	}

	/**
	 * 添加用户.
	 *
	 * @param array $data
	 *
	 * @return bool|int
	 */
	public function addUser(array $data = array())
	{
		$userId = 0;
		if (!is_array($data) || empty($data)) {
			return $userId;
		}
		return $this->save($data);
	}

    public function isExistUser($userName)
    {
	    if ("" == $userName) {
		    return false;
	    }
		$whereArray = array(
			'user_name' => $userName,
		);
	    $userInfo = $this->findByAttributes($whereArray);
	    print_r($userInfo);
    }
}