<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 14-10-10
 * Time: 上午11:57
 */

require_once APPPATH . 'third_party/elasticsearch/vendor/autoload.php';

class Es
{
	public $client = NULL;
	public $result_data = array(
		'error_msg' => '',
		'data'      => ''
	);
	private $search_query = array();

	function __construct()
	{
		$ci = & get_instance();
		$ci->config->load('es');
		// 加载配置信息
		$es_params    = $ci->config->item('es');
		$this->client = new Elasticsearch\Client($es_params);
	}

	public function ping()
	{
		try {
			$this->result_data['data'] = $this->client->ping();
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	public function info()
	{
		try {
			$this->result_data['data'] = $this->client->info();
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 创建索引.
	 *
	 * @param array $index_params
	 *                          $index_params['index'] = '索引名称' (必须)
	 *                          $index_params['body']['settings']['number_of_shards'] = 5;集群片什么的相关 默认是5
	 *                          $index_params['body']['settings']['number_of_replicas'] = 1;集群片什么的相关 默认是1
	 *                          $index_params['body']['mappings']['索引名称'] = array(
	 *                          '_source' => array(
	 *                          'enabled' => true,
	 *                          ),
	 *                          //字段属性设置
	 *                          'properties' => array(
	 *                          'pro_id' => array(
	 *                          'type' => 'integer',
	 *                          ),
	 *                          'pro_name' => array(
	 *                          'type'           => 'string',
	 *                          "store"          => "no",
	 *                          "term_vector"    => "with_positions_offsets",
	 *                          "indexAnalyzer"  => "ik",
	 *                          "searchAnalyzer" => "ik",
	 *                          "include_in_all" => "true",
	 *                          "boost"          => 8
	 *                          ),
	 *                          .....
	 *                          ),
	 *                          );
	 *
	 *
	 * @return array
	 */
	public function create_index($index_params = array())
	{
		$index_options = array(
			'index' => '',
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->create($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 删除索引.
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须)
	 *
	 * @return array
	 */
	public function delete_index($index_params = array())
	{
		$index_options = array(
			'index' => '',
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->delete($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 获取索引设置.
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须) 可以是数组返回多个索引的设置信息.
	 *
	 * @return array
	 */
	public function get_index_settings($index_params = array())
	{
		$index_options = array(
			'index' => '',
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->getSettings($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 修改索引设置.
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须)
	 *
	 * @return array
	 */
	public function put_index_settings($index_params = array())
	{
		$index_options = array(
			'index' => '',
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->putSettings($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 获取索引的mapping
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须) 可以是数组返回多个索引的设置信息.
	 *
	 * @return array
	 */
	public function get_index_mapping($index_params = array())
	{
		$index_options = array(
			'index' => ''
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->getMapping($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 修改mapping.
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须)
	 *
	 * @return array
	 */
	public function put_index_mapping($index_params = array())
	{
		$index_options = array(
			'index' => '',
			'type'  => ''
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->indices()->putMapping($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 创建文档.
	 *
	 * @param array $index_params
	 *              $index_params['index'] = '索引名称' (必须)
	 *              $index_params['type'] = '索引类型' (必须)
	 *
	 * @return array
	 */
	public function index($index_params = array())
	{
		$index_options = array(
			'index' => '',
			'type'  => '',
			'id'    => '',
			'body'  => ''
		);
		if (is_array($index_params))
			$index_options = array_merge($index_options, $index_params);
		extract($index_options);
		try {
			$this->result_data['data'] = $this->client->index($index_options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 通过id获取文档信息 包括_index,_type 等等.
	 *
	 * @param array $params ['id']              = (string) The document ID (Required)
	 *                      ['index']           = (string) The name of the index (Required)
	 *                      ['type']            = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
	 *                      ['_source']         = (list) True or false to return the _source field or not, or a list of fields to return
	 *                      ['fields']          = (list) A comma-separated list of fields to return in the response
	 *                      ['refresh']         = (boolean) Refresh the shard containing the document before performing the operation
	 *                      ['parent']         = (string) The ID of the parent document
	 *                      ['preference']     = (string) Specify the node or shard the operation should be performed on (default: random)
	 *
	 * @return array
	 */
	public function get_doc($params = array())
	{
		$options = array(
			'index'    => '',
			'id'       => '',
			'refresh'  => TRUE,
			'type'     => '_all',
			'_source'  => TRUE,
			'realtime' => FALSE,
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->get($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 通过id获取文档信息 不包括_index,_type 等等.
	 *
	 * @param array $params ['id']              = (string) The document ID (Required)
	 *                      ['index']           = (string) The name of the index (Required)
	 *                      ['type']            = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
	 *
	 * @return array
	 */
	public function get_doc_source($params = array())
	{
		$options = array(
			'index'    => '',
			'id'       => '',
			'refresh'  => TRUE,
			'type'     => '_all',
			'realtime' => TRUE
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->getSource($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 删除文档.
	 *
	 * $params['id']           = (string) The document ID (Required)
	 *        ['index']        = (string) The name of the index (Required)
	 *        ['type']         = (string) The type of the document (Required)
	 *        ['consistency']  = (enum) Specific write consistency setting for the operation
	 *        ['parent']       = (string) ID of parent document
	 *        ['refresh']      = (boolean) Refresh the index after performing the operation
	 *        ['replication']  = (enum) Specific replication type
	 *        ['routing']      = (string) Specific routing value
	 *        ['timeout']      = (time) Explicit operation timeout
	 *        ['version_type'] = (enum) Specific version type
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function delete_doc($params = array())
	{
		$options = array(
			'index' => '',
			'id'    => '',
			'type'  => '_all',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->delete($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 基于查询删除索引；
	 * $params[''] @todo finish the rest of these params
	 *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
	 *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
	 *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function delete_doc_by_query($params = array())
	{
		$options = array(
			'index' => '',
			'type'  => '',
			'body'  => '',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->deleteByQuery($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 获取符合条件的文档总数.
	 *
	 * $params['index']              = (list) A comma-separated list of indices to restrict the results
	 *        ['type']               = (list) A comma-separated list of types to restrict the results
	 *        ['min_score']          = (number) Include only documents with a specific `_score` value in the result
	 *        ['preference']         = (string) Specify the node or shard the operation should be performed on (default: random)
	 *        ['routing']            = (string) Specific routing value
	 *        ['source']             = (string) The URL-encoded query definition (instead of using the request body)
	 *        ['body']               = (array) A query to restrict the results (optional)
	 *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
	 *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
	 *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function get_doc_count($params = array())
	{
		$options = array(
			'index' => '',
			'type'  => '',
			'body'  => ''
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->count($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * $params['index']                    = (list) A comma-separated list of index names to search; use `_all` or empty string to perform the operation on all indices
	 *        ['type']                     = (list) A comma-separated list of document types to search; leave empty to perform the operation on all types
	 *        ['analyzer']                 = (string) The analyzer to use for the query string
	 *        ['analyze_wildcard']         = (boolean) Specify whether wildcard and prefix queries should be analyzed (default: false)
	 *        ['default_operator']         = (enum) The default operator for query string query (AND or OR)
	 *        ['df']                       = (string) The field to use as default where no field prefix is given in the query string
	 *        ['explain']                  = (boolean) Specify whether to return detailed information about score computation as part of a hit
	 *        ['fields']                   = (list) A comma-separated list of fields to return as part of a hit
	 *        ['from']                     = (number) Starting offset (default: 0)
	 *        ['ignore_indices']           = (enum) When performed on multiple indices, allows to ignore `missing` ones
	 *        ['indices_boost']            = (list) Comma-separated list of index boosts
	 *        ['lenient']                  = (boolean) Specify whether format-based query failures (such as providing text to a numeric field) should be ignored
	 *        ['lowercase_expanded_terms'] = (boolean) Specify whether query terms should be lowercased
	 *        ['preference']               = (string) Specify the node or shard the operation should be performed on (default: random)
	 *        ['q']                        = (string) Query in the Lucene query string syntax
	 *        ['routing']                  = (list) A comma-separated list of specific routing values
	 *        ['scroll']                   = (duration) Specify how long a consistent view of the index should be maintained for scrolled search
	 *        ['search_type']              = (enum) Search operation type
	 *        ['size']                     = (number) Number of hits to return (default: 10)
	 *        ['sort']                     = (list) A comma-separated list of <field>:<direction> pairs
	 *        ['source']                   = (string) The URL-encoded request definition using the Query DSL (instead of using request body)
	 *        ['_source']                  = (list) True or false to return the _source field or not, or a list of fields to return
	 *        ['_source_exclude']          = (list) A list of fields to exclude from the returned _source field
	 *        ['_source_include']          = (list) A list of fields to extract and return from the _source field
	 *        ['stats']                    = (list) Specific 'tag' of the request for logging and statistical purposes
	 *        ['suggest_field']            = (string) Specify which field to use for suggestions
	 *        ['suggest_mode']             = (enum) Specify suggest mode
	 *        ['suggest_size']             = (number) How many suggestions to return in response
	 *        ['suggest_text']             = (text) The source text for which the suggestions should be returned
	 *        ['timeout']                  = (time) Explicit operation timeout
	 *        ['version']                  = (boolean) Specify whether to return document version as part of a hit
	 *        ['body']                     = (array|string) The search definition using the Query DSL
	 *
	 *      1.Request Body
	 *          $params['index'] = 'my_product';
	 *          $params['type'] = 'product';
	 *          $params['body']['query']['term']['pro_name'] = '京东';
	 *          $params['body']['query']['term']['pro_url'] = 'jd';
	 *          $params['timeout'] = ;
	 *          $params['from'] = 0; 默认0
	 *          $params['size'] = 10; 默认10
	 *
	 *      2.URI Request
	 *          $params['index'] = 'my_product';
	 *          $params['type'] = 'product';
	 *          $params['q']['pro_name'] = '苹果';
	 *          $params['q']['pro_url'] = 'jd';
	 *          $params['df'] = ''; //The default field to use when no field prefix is defined within the query.
	 *          $params['analyzer'] = ''; //The analyzer name to be used when analyzing the query string..
	 *          $params['default_operator'] = 'AND' //  'AND'或是'OR' 默认是'OR'
	 *          $params['explain'] = 'true' //true 或是false For each hit, contain an explanation of how scoring of the hits was computed.
	 *          $params['fields'] = array('pro_name','pro_url'); //需要返回的查询字段 ,不设置则返回全部
	 *
	 *          $params['from'] = 0; 默认0
	 *          $params['size'] = 10; 默认10
	 *          $params['search_type'] = The type of the search operation to perform. Can be dfs_query_then_fetch, dfs_query_and_fetch, query_then_fetch, query_and_fetch. Defaults to query_then_fetch.
	 *          $params['lowercase_expanded_terms'] = Should terms be automatically lowercased or not. Defaults to true.
	 *          $params['analyze_wildcard'] = Should wildcard and prefix queries be analyzed or not. Defaults to false.
	 *
	 *      3.Filter
	 *          $params['index'] = 'my_product';
	 *          $params['type'] = 'product';
	 *          $params['body']['query']['term']['message'] = 'something';
	 *          $params['body']['filter']['term']['tag'] = 'green';
	 *          $params['body']['facets']['tag']['terms']['field'] = 'tag';
	 *
	 *      4.Sort
	 *          $params['index'] = 'my_product';
	 *          $params['type'] = 'product';
	 *          $params['body']['query']['term']['message'] = 'iphone';
	 *          $params['body']['sort']['pro_id']['order'] = 'desc';
	 *
	 *      5.Highlighting
	 *          详见 http://www.elasticsearch.cn/guide/reference/api/search/highlighting.html
	 *          $params['index'] = 'my_product';
	 *          $params['type'] = 'product';
	 *          $params['body']['query']['term']['message'] = 'iphone';
	 *          //高亮
	 *          $params['body']['highlight']['fields'] = array('pro_name'=>array('fragment_size'=>150));
	 *          $params['body']['highlight']['pre_tags'] = array("<tag1>","<tag2>");
	 *          $params['body']['highlight']['post_tags'] = array("</tag1>","</tag2>");
	 *
	 *      6.Fields
	 *         详见 http://www.elasticsearch.cn/guide/reference/api/search/fields.html
	 *         $params['index'] = 'my_product';
	 *         $params['type'] = 'product';
	 *         $params['body']['query']['term']['message'] = 'iphone';
	 *         $params['body']['fields'] = array('pro_name','pro_id');
	 *
	 *
	 *      7.Preference
	 *         详见:http://www.elasticsearch.cn/guide/reference/api/search/preference.html
	 *
	 *      8.Filters
	 *        详见:http://www.elasticsearch.cn/guide/reference/api/search/named-filters.html
	 *
	 *      9.Search Type
	 *        详见:http://www.elasticsearch.cn/guide/reference/api/search/search-type.html
	 *
	 *      10.explain
	 *          详见:http://www.elasticsearch.cn/guide/reference/api/search/explain.html
	 *
	 *      $params['index'] = 'my_product';
	 *         $params['type'] = 'product';
	 *         $params['body']['query']['term']['message'] = 'iphone';
	 *         $params['body']['explain'] = true;
	 *
	 *      11.version
	 *          详见:http://www.elasticsearch.cn/guide/reference/api/search/version.html
	 *          $params['type'] = 'product';
	 *          $params['body']['query']['term']['message'] = 'iphone';
	 *          $params['body']['version'] = true;
	 *
	 *
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function search($params = array())
	{
		$options = array(
			'index' => '',
			'type'  => '',
			'body'  => ''
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->search($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 详见:http://www.elasticsearch.cn/guide/reference/api/percolate.html
	 *
	 * $params['index']        = (string) The name of the index with a registered percolator query (Required)
	 *        ['type']         = (string) The document type (Required)
	 *        ['prefer_local'] = (boolean) With `true`, specify that a local shard should be used if available, with `false`, use a random shard (default: true)
	 *        ['body']         = (array) The document (`doc`) to percolate against registered queries; optionally also a `query` to limit the percolation to specific registered queries
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function percolate($params = array())
	{
		$options = array(
			'index' => '',
			'type'  => '',
			'body'  => ''
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->percolate($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 这个还暂时不知道怎么用.
	 * $params['index']       = (string) Default index for items which don't provide one
	 *        ['type']        = (string) Default document type for items which don't provide one
	 *        ['consistency'] = (enum) Explicit write consistency setting for the operation
	 *        ['refresh']     = (boolean) Refresh the index after performing the operation
	 *        ['replication'] = (enum) Explicitly set the replication type
	 *        ['body']        = (string) Default document type for items which don't provide one
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function bulk($params = array())
	{
		$options = array(
			'index'   => '',
			'type'    => '',
			'body'    => '',
			'refresh' => FALSE,
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->bulk($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 创建索引别名.
	 *  详见:http://www.elasticsearch.cn/guide/reference/api/admin-indices-aliases.html
	 * $params['index']   = (string) The name of the index with an alias
	 *        ['name']    = (string) The name of the alias to be created or updated
	 *        ['timeout'] = (time) Explicit timestamp for the document
	 *        ['body']    = (time) Explicit timestamp for the document
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function put_alias($params = array())
	{
		$options = array(
			'index' => '',
			'name'  => '',
			'body'  => ''
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->indices()->putAlias($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 详见:http://www.elasticsearch.cn/guide/reference/api/admin-indices-aliases.html
	 *
	 * $params['local']   = (bool) Return local information, do not retrieve the state from master node (default: false)
	 *        ['timeout'] = (time) Explicit timestamp for the document
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function get_aliases($params = array())
	{
		$options = array(
			'index' => '',
			'name'  => '',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->indices()->getAliases($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 详见:http://www.elasticsearch.cn/guide/reference/api/admin-indices-aliases.html
	 *
	 * $params['name']           = (list) A comma-separated list of alias names to return (Required)
	 *        ['index']          = (list) A comma-separated list of index names to filter aliases
	 *        ['ignore_indices'] = (enum) When performed on multiple indices, allows to ignore `missing` ones
	 *        ['name']           = (list) A comma-separated list of alias names to return
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function get_alias($params)
	{
		$options = array(
			'index' => '',
			'name'  => '',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->indices()->getAlias($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 删除别名.
	 *  详见:http://www.elasticsearch.cn/guide/reference/api/admin-indices-aliases.html
	 * $params['index']   = (string) The name of the index with an alias (Required)
	 *        ['name']    = (string) The name of the alias to be deleted (Required)
	 *        ['timeout'] = (time) Explicit timestamp for the document
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function delete_index_alias($params = array())
	{
		$options = array(
			'index' => '',
			'name'  => '',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->indices()->deleteAlias($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 判断别名是否存在.
	 *      详见:http://www.elasticsearch.cn/guide/reference/api/admin-indices-aliases.html
	 * $params['name']               = (list) A comma-separated list of alias names to return (Required)
	 *        ['index']              = (list) A comma-separated list of index names to filter aliases
	 *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
	 *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
	 *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
	 *
	 * @param $params array Associative array of parameters
	 *
	 * @return array
	 */
	public function exists_alias($params = array())
	{
		$options = array(
			'index' => '',
			'name'  => '',
		);
		if (is_array($params))
			$options = array_merge($options, $params);
		extract($options);
		try {
			$this->result_data['data'] = $this->client->indices()->existsAlias($options);
		} catch (Exception $e) {
			$this->result_data['error_msg'] = $e->getMessage();
		}

		return $this->result_data;
	}

	/**
	 * 处理搜索条件 返回搜索query
	 *
	 * @param array $params
	 *              $param = array(
	 *              'index'    => 'smzdm_article_index',
	 *              'type'     => 'article',
	 *              'channel'  => $channel,
	 *              'order'     => array('article_publish_time' => 'desc','_score' => 'desc','article_id'=>'asc'),
	 *              'from'     => 0,
	 *              'size'     => 10,
	 *              'timeout'  => 30000,
	 *              'facets'   => array('channel_statistics' => 'article_type','category3_cn_statistics'=>'article_category_3_name','category4_cn_statistics'=>'article_category_3_name','mall_statistics'=>'article_mall'),
	 *              'fields'   => array('article_id', 'article_title', 'article_publish_time'),
	 *              'filter' => array('article_type' => $channel),
	 *              'highlight' => array('pre_tags' => array("<tag1>","<tag2>"),'post_tags'=>array("</tag1>","</tag2>"),'fields'=>array('article_content'=>array('fragment_size'=>100),'article_title'=>array('fragment_size'=>100))),
	 *              'query_string' => array('keyword' => "白菜特价",'fields'=> array('article_title','article_content'),'default_operator'=>'and','analyzer'=>'ik_smart'),
	 *              );
	 *
	 * @return array
	 */
	public function get_search_query($params = array())
	{
		$default_params = array(
			'index'    => '',           //索引
			'type'     => '',           //类型
			'order'    => array(),      //排序
			'from'     => '',            //从那条开始
			'size'     => '',          //查询条数
			'timeout'  => 30000,        //超时时间
			'facets'   => array(),      //聚合
			'keywords' => '',           //关键字
			'fields'   => array(),      //需要返回的字段
			'filter' => array(),        //筛选
			'highlight' => array(),     //高亮
			'query_string' => array(),

		);
		if (is_array($params))
			$default_params = array_merge($default_params, $params);
		extract($default_params);
		$search_query = array(
			'index' => $index,
			'type' => $type,
		);
		if ($from) {
			$search_query['from'] = $from;
		}
		if ($size) {
			$search_query['size'] = $size;
		}
		//返回字段
		$fields_query = $this->get_fields_query($fields);
		if (!empty($fields_query)) {
			$search_query['body']['fields'] = $fields_query;
		}

		//排序
		$order_query = $this->get_order_query($order);
		if (!empty($order_query)) {
			$search_query['body']['sort'] = $order_query;
		}

		//filter 限制频道
		$filter_query = $this->get_filter_query($filter);
		if (!empty($filter_query)) {
			$search_query['body']['filter'] = $filter_query;
		}

		//高亮
		$highlight_query = $this->get_highlight_query($highlight);
		if (!empty($highlight_query)) {
			$search_query['body']['highlight'] = $highlight_query;
		}

		//聚合
		$facets_query = $this->get_facets_query($facets);
		if (!empty($facets_query)) {
			$search_query['body']['facets'] = $facets_query;
		}

        //获取query_string
        $query_string = $this->get_query_string_query($query_string);
        if (!empty($query_string)){
            $search_query['body']['query']['query_string'] = $query_string;
        }elseif (!empty($term)){
            $search_query['body']['query']['term'] = $term;
        }elseif(!empty($bool)){
            $search_query['body']['query']['bool'] = $bool;
        }elseif (!empty($range)){
            $search_query['body']['query']['range'] = $range;
        }
		return $search_query;
	}

	private function get_bool_query($bool_query = array())
	{
		$query = array();
		if (is_array($bool_query) && !empty($bool_query)) {
			if (isset($bool_query['minimum_should_match'])) {
				$query['minimum_should_match'] = $bool_query['minimum_should_match'];
			} else {
				$query['minimum_should_match'] = 1;
			}
			if (isset($bool_query['should']) && !empty($bool_query['should'])) {

			}
		}
	}

	/**
	 * 获取query_string
	 *
	 * @param array $query_string  array('keyword' => "白菜特价",'fields'=> array('article_title','article_content'),'default_operator'=>'and','analyzer'=>'ik_smart'),
	 *
	 * @return array
	 */
	private function get_query_string_query($query_string = array())
	{
		$query = array();
		if (is_array($query_string) && !empty($query_string)) {
			if (isset($query_string['fields']) && !empty($query_string)) {
				$query['fields'] = $query_string['fields'];
			} else {
				$query['fields'] = array("_all");
			}
			if (isset($query_string['default_operator']) && !empty($query_string['default_operator'])) {
				$query['default_operator'] = $query_string['default_operator'];
			}
			if (isset($query_string['analyzer']) && !empty($query_string['analyzer'])) {
				$query['analyzer'] = $query_string['analyzer'];
			}
			if (isset($query_string['keyword']) && $query_string['keyword'] != "") {
				$query['query'] = $this->deal_special_characters(strtolower($query_string['keyword']));
			}
		}
		return $query;
	}

	/**
	 * @param $keywords
	 */
	private function deal_special_characters($keywords)
	{
		$filters = Config::$search_special_characters;
		if (!empty($filters)) {
			foreach ($filters as $key => $val) {
				if (stripos($keywords,$val) !== false) {
					$keywords = str_replace($val,'\\'.$val,$keywords);
				}
			}
		}
		return $keywords;
	}

	/**
	 * 获取聚合的query
	 *
	 * @param array $facets array('channel_statistics' => 'article_type','category3_cn_statistics'=>'article_category_3_name','category4_cn_statistics'=>'article_category_3_name','mall_statistics'=>'article_mall'),
	 *                         channel_statistics: "聚合的名称"
	 *                         article_type ："需要聚合的字段"
	 *
	 * @return array
	 */
	private function get_facets_query($facets = array())
	{
		$query = array();
		if (is_array($facets) && !empty($facets)) {
			foreach ($facets as $facets_name => $facets_val) {
				$query["$facets_name"]['terms']['field'] = $facets_val;
			}
		}
		return $query;
	}
	/**
	 * 获取高亮query
	 *
	 * @param array $highlight array('pre_tags' => array("<tag1>","<tag2>"),'post_tags'=>array("</tag1>","</tag2>"),'fields'=>array('article_content'=>array('fragment_size'=>100),'article_title'=>array('fragment_size'=>100))),
	 *              fragment_size :控制高亮片段中得字符数量(默认100)
	 *              number_of_fragments ：最大返回的片段数(默认5)
	 * @return array
	 */
	private function get_highlight_query($highlight = array())
	{
		$query = array();
		if (is_array($highlight) && !empty($highlight)) {
			if (isset($highlight['pre_tags']) && !empty($highlight['pre_tags'])) {
				$query['pre_tags'] = $highlight['pre_tags'];
			}
			if (isset($highlight['post_tags']) && !empty($highlight['post_tags'])) {
				$query['post_tags'] = $highlight['post_tags'];
			}
			if (isset($highlight['fields']) && !empty($highlight['fields'])) {
				foreach ($highlight['fields'] as $fields => $fields_val) {
					if (isset($fields_val['fragment_size']) && !empty($fields_val['fragment_size'])) {
						$query['fields']["$fields"]['fragment_size'] = $fields_val['fragment_size'];
					}
					if (isset($fields_val['number_of_fragments']) && !empty($fields_val['number_of_fragments'])) {
						$query['fields']["$fields"]['number_of_fragments'] = $fields_val['number_of_fragments'];
					}
				}
			}
		}
		return $query;
	}

	/**
	 * 获取返回 所需查询字段query
	 *
	 * @param array $fields   array('article_id', 'article_title', 'article_publish_time'),
	 *
	 * @return array
	 */
	private function get_fields_query($fields = array())
	{
		$query = array();
		if (is_array($fields) && !empty($fields)) {
			$query = $fields;
		}
		return $query;
	}
	/**
	 * 获取搜索筛选 query
	 *
	 * @param array $filter  array('article_type' => 'youhui')
	 *
	 * @return array
	 */
	private function get_filter_query($filter = array())
	{
		$query = array();
		if (is_array($filter) && !empty($filter)) {
			foreach ($filter as $filter_key => $filter_val) {
				$query['term']["$filter_key"] = $filter_val;
			}
		}
		return $query;
	}

	/**
	 * 获取搜索排序 query
	 *
	 * @param array $order array('article_publish_time' => 'desc','_score' => 'desc','article_id'=>'asc'),
	 *
	 * @return array
	 */
	private function get_order_query($order = array())
	{
		$query = array();
		if (is_array($order) && !empty($order)) {
			foreach ($order as $order_key =>$sort) {
				$query["$order_key"]['order'] = $sort;

			}
		}
		return $query;
	}
}