<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/3
 * Time: 上午10:08
 */

class Zdm_product extends CI_Controller
{

	public $product_index = array(
		'index' => 'product',
		'body' => array(
			'settings' => array(
				'number_of_shards' => 10,
				'number_of_replicas' => 1,
				'refresh_interval' => 10
			),
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
							'type' => 'double'
						),
					),
				),
			),
		),
	);

	public $product_alter_mappings = array(
		'index' => 'product',
		'type' => '.percolator',
		'body' => array(
			'mappings' => array(
				'.percolator' => array(
					'_routing' => array(
						'required' => true,
						'path' => 'pro_id'
					),
				)
			)
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->load->library('es');
	}


	/**
	 * 创建产品索引
	 */
	function create_product_index()
	{
		for ($i=1;$i<=60;$i++) {
			$idx_name = "product_".$i;
			$idx_params = array(
				'index' => $idx_name,
				'body' => array(
					'settings' => array(
						'number_of_shards' => 3,
						'number_of_replicas' => 1,
						'refresh_interval' => 10
					),
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
									'type' => 'double'
								),
							),
						),
					),
				),
			);
			$ret = $this->es->create_index($idx_params);
			print_r($ret);
		}


	}

	/**
	 *  导入产品测试数据
	 */
	function import_product_data()
	{
		ini_set('max_execution_time', '0');
		$id = 1;
		while($id < 600000) {
			$idx = ceil($id/10000);
			$index_name = "product_".$idx;
			$index_params = array(
				'index' => $index_name,
				'type' => 'price',
				'id' => $id,
				'body' => array(
					'pro_id' => $id,
					'price'  => rand(0,9999).".".rand(0,99)
				),
			);
			$ret = $this->es->index($index_params);
			$id++;
			print_r($ret);
		}
	}

	/**
	 *  这个貌似有问题.
	 */
	function put_product_alter_mappings()
	{
		$ret = $this->es->put_index_mapping($this->product_alter_mappings);
		print_r($ret);
	}

	/**
	 * 导入query
	 */
	function import_alter_data()
	{
		ini_set('max_execution_time', '0');
		$user_id = 1;
		while ($user_id < 200000) {
			$pro_id = rand(1,599999);
			$idx = ceil($pro_id/10000);
			$index_name = "product_".$idx;
			$uid = $user_id."_".$pro_id;
			$index_params = array(
				'index' => $index_name ,
				'type'  => '.percolator',
				'id'    => $uid,
				'body' => array(
					'query' => array(
						'bool' => array(
							'must' => array(
								array(
									'range' => array(
										'price' => array(
											'lte' => rand(0,9999).".".rand(0,99)
										),
									)
								),
								array(
									'term' => array(
										'pro_id' => $pro_id
									),
								),
							),
						),
					),
				),
			);
			$user_id++;
			$ret = $this->es->index($index_params);
			var_dump($ret);
		}
	}

}