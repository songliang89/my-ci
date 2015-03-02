<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/27
 * Time: 上午11:34
 */

class Esdemo extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		//$this->load->library('es');
	}

	function index()
	{
		echo "xxx";

	}



	function create_index()
	{
		$params = array(
			'index' => 'percolate2',
			//'type' => 'my_percolator_type',
			'body' => array(
				/*'settings' => array(
					'number_of_shards' => 10,
					'number_of_replicas' => 1,
					'refresh_interval' => 10
				),*/
				'mappings' => array(
					'percolate_type2' => array(
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

	function insert_data()
	{
		$id = 122554;
		while ($id < 200000) {
			$index_options = array(
				'index' => 'percolate2',
				'type'  => 'percolate_type2',
				'id'    => $id,
				'body'  => array(
					'pro_id' => $id,
					'price' => rand(0,999)
				)
			);
			$ret = $this->es->index($index_options);
			$id++ ;
			var_dump($ret);
			//break;
		}
	}

	function percolate_data()
	{
		for ($i = 34;$i<=35;$i++){

			/*$index_options = array(
				'index' => 'percolate',
				'type'  => '.percolator',
				'id'    => $i,
				'body'  => array(
					'query' => array(
						'term' => array(
							'price' => 1
						)
					)
				)
			);*/
			/*$index_options = array(
				'index' => 'percolate',
				'type'  => '.percolator',
				'id'    => $i,
				'body' => array(

					'query' => array(
						'range'=> array(
							'price' => array(
								'from' => 8988,
								'to' => 9990
							),
						),
						'term'=>array(
							'pro_id' => 888
						),
					),
				),
			);*/
			$index_options = array(
				'index' => 'percolate2',
				'type'  => '.percolator2',
				'id'    => $i,
				'body' => array(
					'query' => array(
						'bool' => array(
						'must' => array(
							array(
								'range' => array(
									'price' => array(
										'gt' => 9990,
										'to' => 9999
									)
								),
							),
							array(
								'term'=>array(
									'pro_id' => 2330
								)
							),
						),
					),
					)
				)
			);

			$ret = $this->es->index($index_options);
			var_dump($ret);
		}

	}

	function percolate()
	{
		$index_options = array(
			'index' => 'percolate',
			'type'  => 'percolate_type',
			'body' => array(
				'doc'=>array(
					'price' => 9991,
					'pro_id' => 2330
				),
			),
		);
		$ret = $this->es->percolate($index_options);
		echo "<pre>";
		var_dump($ret);
	}


	function create_percolate()
	{
		$user_id = 1;
		while($user_id <= 1000) {
			$pro_id = rand(0,199999);
			$pro_id = 117;
			$id = $user_id."_".$pro_id;
			$index_options = array(
				'index' => 'percolate2',
				'type'  => '.percolator2',
				'id'    => $id,
				'body' => array(
					'query' => array(
						'bool' => array(
							'must' => array(
								array(
									'range' => array(
										'price' => array(
											'gt' => 0,
											'to' => rand(0,485)
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
}