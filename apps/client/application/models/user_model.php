<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/15
 * Time: 下午5:23
 */
class User_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 主键
	 */
	public function primaryKey()
	{
		return 'user_id';
	}
	/**
	 * 表名称
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * 获取用户列表
	 *
	 * @param int $offset
	 * @param int $limit
	 *
	 * @return array
	 */
	function userSearch($offset = 0, $limit = 10)
	{
		$sql = "
				SELECT
					u.user_name,u.user_id,r.role_name
				FROM
					user as u
				left join
					role as r
				on u.role_id = r.role_id
				limit {$offset}, {$limit}
		";
		$data = $this->query($sql);
		return $data;
	}


}