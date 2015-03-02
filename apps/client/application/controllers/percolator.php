<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/2
 * Time: 上午11:30
 */
class Percolator extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('es');
	}

	function create_index()
	{
		$id = 30000;
		$name = array(
			"松下",
			"小米",
			"三星",
			"苹果",
			"华为",
			"魅族",
			"国产山寨",
			"索尼",
			"北京",
			"上海",
			"广州",
			"京东",
			"亚马逊",
			"易迅"
		);
		while ($id < 99999) {
			$index_options = array(
				'index' => 'product',
				'type'  => 'price',
				'id'    => $id,
				'body'  => array(
					'pro_id' => $id,
					'price' => rand(0,999),
					'name' => "my".$name[rand(0,13)]."tv"
				)
			);
			$ret = $this->es->index($index_options);
			$id++ ;
			var_dump($ret);
			//break;
		}
	}

	function create_price_alert()
	{
		$user_id = 1;
		while($user_id <= 1000) {
			$pro_id = rand(0,2000);
			$pro_id = 2181;
			$index_name = "alert_".$this->get_alert_id($pro_id);
			$id = $user_id."_".$pro_id;
			$index_options = array(
				'index' => "product",
				'type'  => '.percolator',
				'id'    => $id,
				'body' => array(
					'query' => array(
						'bool' => array(
							'must' => array(
								array(
									'range' => array(
										'product.price' => array(
											'gt' => 0,
											'to' => rand(0,485)
										)
									),
								),
								array(
									'term'=>array(
										'product.pro_id' => $pro_id
									)
								),
							),
						),
					)
				)
			);
			$user_id++;
			$ret = $this->es->index($index_options);
			var_dump($ret);
		}
	}

	function get_alert_id($pro_id)
	{
		return ceil($pro_id/1000);
	}
}