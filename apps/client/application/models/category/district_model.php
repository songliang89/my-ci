<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/10
 * Time: 下午5:31
 */

/**
 *
 * CREATE TABLE `category_district` (
 *      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 *      `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类id',
 *      `category_name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
 *      `category_order` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
 *      `is_delete` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
 *      `level` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
 *      PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=538 DEFAULT CHARSET=utf8
 *
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
						id,parentid,category_name,category_order
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
						id,parentid,category_name,category_order
				FROM
						{$this->tableName()}
				WHERE
						is_delete = 0 and parentid=0
				ORDER BY
						category_order DESC
		";
		return $this->query($sql);
	}

	/**
	 * 通过父级id 获取子级列表.
	 *
	 * @param $pid
	 *
	 * @return array
	 */
	function getChildListByPid($pid)
	{
		$data = array();
		if ("" == $pid) {
			return $data;
		}
		$where = array(
			'is_delete' => 0,
			'parentid' => $pid
		);
		$data = $this->findAll($where,0,0,"category_order desc");
		return $data;
	}

	/**
	 *  更新
	 *
	 * @param $data
	 *
	 * @return boolean
	 */
	function updateDistrict($data)
	{
		if (empty($data)) {
			return false;
		}
		return $this->updateByPk($data["id"],$data);
	}

	/**
	 *
	 * 获取地区详情.
	 * @param $id
	 *
	 * @return array
	 */
	function getInfo($id)
	{
		$data = array();
		if ("" == $id) {
			return $data;
		}
		$data = $this->findByPk($id);
		return $data;
	}
}