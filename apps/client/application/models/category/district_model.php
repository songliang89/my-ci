<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/10
 * Time: 下午5:31
 */
class District_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function tableName()
	{
		return 'category_district';
	}

	public function primaryKey()
	{
		return 'id';
	}

	/**
	 * 获取地区列表.
	 *
	 * @return array
	 */
	function getDistrictAllList()
	{
		$sql = "
				SELECT
						parentid,category_name,category_order
				FROM
						{$this->tableName()}
				WHERE
						is_delete = 0
				ORDER BY
						category_order DESC
		";
		return $this->query($sql);
	}

	/**
	 * 获取顶级分类列表.
	 * @return array
	 */
	function getTopCategoryList()
	{
		$sql = "
				SELECT
						parentid,category_name,category_order
				FROM
						{$this->tableName()}
				WHERE
						is_delete = 0 and parentid=0
				ORDER BY
						category_order DESC
		";
		return $this->query($sql);
	}
}