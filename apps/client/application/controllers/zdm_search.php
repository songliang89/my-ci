<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/2/28
 * Time: 下午1:18
 */
class Zdm_search extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('es');
		$this->load->helper('url');
        $this->load->library('My_Redis_Cache',array("connect" => "default"),'redis_cache');
	}

	function index()
	{
        $postData = $this->input->post();
        $data = array();
        if (!empty($postData)) {
            $keyword = $postData['s'];
            $pindao = $postData['c'];
            $time = $postData['t'];
            $order = $postData['o'];
            $param = array(
                'index'    => 'smzdm_article_index',
                'type'     => 'article',
                'channel'  => $pindao,
                'from'     => 0,
                'size'     => 1000,
                'timeout'  => 30000,
                //'facets'   => array('channel_statistics' => 'article_type','category3_cn_statistics'=>'article_category_3_name','category4_cn_statistics'=>'article_category_4_name','mall_statistics'=>'article_mall'),
                'fields'   => array('article_id', 'article_title', 'article_publish_time'),
                'filter' => array('article_type' => $pindao),
                //'highlight' => array('pre_tags' => array("<tag1>","<tag2>"),'post_tags'=>array("</tag1>","</tag2>"),'fields'=>array('article_content'=>array('fragment_size'=>100),'article_title'=>array('fragment_size'=>100))),
            );
            //$param['query_string'] = array('keyword' => $keyword,'fields'=> array('article_title','article_title_ik','article_content','article_content_ik'),'default_operator'=>'and','analyzer'=>'query_ansj');
            $param['order'] = array('article_publish_time' => $order);
            if ($keyword) {
            $param['bool'] = array(
                'must' => array(
                    array(
                        'range' => array(
                            'article_publish_time' => array(
                                'from' => '2011-01-01 00:00:00',
                                'to'   => '2015-01-01 00:00:00'
                            )
                        )
                    ),
                    array(
                        'query_string' => array('query' => $keyword,'fields'=> array('article_title','article_title_ik','article_content','article_content_ik'),'default_operator'=>'and','analyzer'=>'query_ansj')
                    )
                ),
            );
            } else {
                $param['bool'] = array(
                    'must' => array(
                        array(
                            'range' => array(
                                'article_publish_time' => array(
                                    'from' => '2011-01-01 00:00:00',
                                    'to'   => '2015-01-01 00:00:00'
                                )
                            )
                        ),
                    ),
                );
            }
            $search_query = $this->es->get_search_query($param);
            //$data = $this->es->search($search_query);
            $data = $this->redis_cache->library("es",'search',array($search_query),10000);
            print_r($data);
        }
        $view_data = array(
            'data' => $data
        );
		$this->load->view('zdm_search',$view_data);
	}
}