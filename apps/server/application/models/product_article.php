<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/1/27
 * Time: 下午5:33
 */
class Product_article Extends MY_Model
{
	/**
	 * 主键
	 */
	public function primaryKey()
	{
		return 'id';
	}
	/**
	 * 表名称
	 */
	public function tableName()
	{
		return 'product_article';
	}

	function getInfo($id)
	{
		return $this->findByPk($id);
	}

}
/* End of file test_model.php */
/* Location: ./application/models/test_model.php */