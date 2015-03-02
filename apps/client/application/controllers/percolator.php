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

	function create_index1()
	{
		$params = array(
			'index' => 'product',
			//'type' => 'my_percolator_type',
			'body' => array(
				/*'settings' => array(
					'number_of_shards' => 10,
					'number_of_replicas' => 1,
					'refresh_interval' => 10
				),*/
				'mappings' => array(
					'price' => array(
						'_routing' => array(
							'required' => true,
							'path' => 'pro_id'
						),
						'properties' => array(
							'pro_id' => array(
								'type' => 'integer'
							),
							'price' => array(
								'type' => 'long'
							),
						),
					),
				),
			),
		);
		$status = $this->es->create_index($params);
		var_dump($status);
	}

	function create_index()
	{
		$id = 100000;
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
		while ($id < 200000) {
			$index_options = array(
				'index' => 'product',
				'type'  => 'price',
				'id'    => $id,
				'body'  => array(
					'pro_id' => $id,
					'price' => rand(0,9999),
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
		$user_id = 200000;
		while($user_id <= 400000) {
			$pro_id = rand(0,9999);
			//$pro_id = 1589;
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
										'price' => array(
											'gt' => 1,
											'to' => 9999
										)
									),
								),
								array(
									'term'=>array(
										'pro_id' => $pro_id
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