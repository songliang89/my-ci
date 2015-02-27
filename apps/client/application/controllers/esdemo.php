<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/27
 * Time: 上午11:34
 */

class Esdemo extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('es');
	}

	function index()
	{
		var_dump($this->es->ping());
	}

	function create_index()
	{
		$params = array(
			'index' => 'my_percolator',
			//'type' => 'my_percolator_type',
			'body' => array(
				'mappings' => array(
					'my_percolator_type' => array(
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
		$id = 0;
		while ($id < 100000) {
			$index_options = array(
				'index' => 'my_percolator',
				'type'  => 'my_percolator_type',
				'id'    => $id,
				'body'  => array(
					'pro_id' => $id,
					'price' => rand(1000,9999)
				)
			);
			$ret = $this->es->index($index_options);
			$id++ ;
			var_dump($ret);
			//break;
		}
	}

	function percolate()
	{
		$percolate_params = array(
			'index' => 'my_percolator',
			'type' => 'my_percolator_type',
			'id' => 1,
			'body' => array(
				'query' => array(
					'term' => array(
						'price' =>140
					)
				)
			)
		);
		$ret = $this->es->percolate($percolate_params);
		var_dump($ret);
	}

}