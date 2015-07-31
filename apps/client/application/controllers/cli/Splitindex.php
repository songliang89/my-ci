<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/30
 * Time: 上午9:39
 */
class Splitindex extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("tools");
        $this->load->library('elasticsearch');
        $this->load->library('curl');
    }

    function create_index($num = 15)
    {
        $index_params = array();
        for ($i=0;$i<=15;$i++) {
            $index_name = get_index_name($i);
            $index_params = array(
                'index' => $index_name,
                'body' => Config::$subscribe_article_structure['body']
            );
            if ($this->elasticsearch->client->indices()->exists(array('index'=>$index_name))) {
                echo "this $index_name is exists";
                exit;
            }
            $flag = $this->elasticsearch->create_index($index_params);
            sleep(1);
            $index_params2 = array(
                'index' => $index_name,
                'type' => '.percolator',
                'body' => Config::$index_percolator_mappings['body']
            );
            $data = $this->elasticsearch->put_index_mapping($index_params2);
            print_r($data);
        }
    }

    function run_data($old_index = "percolate_index_v6", $page = 1, $size = 1000)
    {
        ini_set("memory_limit","20480M");
        $search_params = array(
            'index' => $old_index,
            'type' => ".percolator",
            'size' => $size,
            'from' => ($page-1)*$size
        );
        $search_data = $this->elasticsearch->search($search_params);
        if (empty($search_data['data']['hits']['hits'])) {
            echo "no data";
            exit;
        }
        $i =1;
        foreach ($search_data['data']['hits']['hits'] as $key => $val) {
            $uid = $val['_source']['uid'];
            $new_index = get_index_name($uid);
            $import_data['index'] = $new_index;
            $import_data['type'] = ".percolator";
            $import_data['id'] = strtolower($val['_id']);
            $import_data['body']['query'] = $val['_source']['query'];
            $import_data['body']['uid'] = $val['_source']['uid'];
            $import_data['body']['keyword'] = strtolower($val['_source']['keyword']);
            $import_data['body']['dy_type'] = $val['_source']['dy_type'];
            $import_data['body']['quite_time'] = $val['_source']['quite_time'];
            $import_data['body']['is_push'] = $val['_source']['is_push'];
            $import_data['body']['mrjx'] = $val['_source']['mrjx'];
            $import_data['body']['open_quite_time'] = $val['_source']['open_quite_time'];
            $import_data['body']['channel'] = $val['_source']['channel'];
            $import_data['body']['add_time'] = $val['_source']['add_time'];
            $import_data['body']['article_type'] = $val['_source']['channel'];
            $flag = $this->elasticsearch->index($import_data);
            if (empty($flag['error_msg'])) {
                echo "success ({$i}/{$size}) \n";
            } else {
                echo "error ({$i}/{$size}) \n";
                #print_r($flag['error_msg']);
            }
            $i++;
            unset($search_data['data']['hits']['hits'][$key]);
        }
        unset($search_data);
    }


    function subscribe_run()
    {
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->pconnect($redis_config['write']['hostname'], $redis_config['write']['port']);
        while(true) {
            try{
                $data = $redis->lPop(Config::$subscribe_queue_redis_key);
                if ($data) {
                    $redis->incr("dy_lzl_success");
                    $path = __DIR__;
                    $app_path = FCPATH;
                    $cmd = "/bin/sh ".$path."/push.sh '$app_path' '$data' ";
                    $redis->set("cmd",$cmd);
                    @system($cmd, $return);
                }
            } catch(Exception $e) {
                $redis->incr("dy_lzl_error");
            }
        }
    }

    function push($article_redis_key = "", $index_num=0)
    {
        if (!$article_redis_key) {
            return false;
        }
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->pconnect($redis_config['write']['hostname'], $redis_config['write']['port']);
        $article_info = $redis->get($article_redis_key);
        if (empty($article_info)) {
            return false;
        }
        $article_info = json_decode($article_info, true);
        // 我的订阅列表相关处理(包括写全部用户redis队列,用户规则redis,调用用户列表)
        $this->search_all_user($article_info,$index_num);

        $this->search_push_user($article_info, $index_num);

    }

    protected function search_push_user($article_info = array(), $index_num = 0)
    {
        if (empty($article_info)) {
            return false;
        }

        $doc = array(
            'article_tag_names' => isset($article_info['article_tag_names']) ? $article_info['article_tag_names'] : array(),
            'article_brand_ids' => isset($article_info['article_brand_ids']) ? $article_info['article_brand_ids'] : array(),
            'article_mall' => isset($article_info['article_mall']) ? $article_info['article_mall'] : array(),
            'article_type' => isset($article_info['msg_type']) ? $article_info['msg_type'] : "",
            'article_title_ik' => isset($article_info['msg_title']) ? strtolower($article_info['msg_title']) : "",
            'article_title' => isset($article_info['msg_title']) ? strtolower($article_info['msg_title']) : "",
            'article_category_names' => isset($article_info['article_category_names']) ? $article_info['article_category_names'] : array(),
        );
        $index_name = Config::$index_prefix."_".$index_num;
        $search_params = array();
        // 从文章发布时间中取出小时 用于安静时间的判断.
        $quite_time = intval(date("H", strtotime($article_info["push_time"])));
        $query = $this->get_search_push_query($quite_time);

        #$index_name = "smzdm_article_index_v5";
        // 每日精选特殊判断.
        if (isset($article_info['msg_push_type']) && $article_info['msg_push_type'] == 3) {
            $doc["mrjx"] = 1;
            $search_params = array(
                "index" => $index_name,
                "type" => ".percolator",
                "body" => array(
                    "doc" => $doc,
                    "query" => $query
                ),
            );
        } else {
            $search_params = array(
                "index" => $index_name,
                "type" => "article",
                "body" => array(
                    "doc" => $doc,
                    "query" => $query
                ),
            );
        }
        $search_data = $this->elasticsearch->percolate($search_params);
        if (!empty($search_data["error_msg"])) {
            // todo send email
            return $search_data["error_msg"];
        }
        if (!empty($search_data["data"]["matches"])) {
            $match_push_user = $search_data["data"]["matches"];
            $push_user_ids = array();
            foreach($match_push_user as $match_key => $match_val) {
                $push_matches_info = explode("||", $match_val);
                $push_user_ids[] = $push_matches_info['0'];
            }
        }
        // 写推送用户的redis
        $push_redis_key = "DY_".$article_info['msg_type']."_".$article_info['msg_id']."_push_".$index_num;
        $this->write_push_user_redis($push_user_ids, $article_info, $push_redis_key);
        // 请求推送接口.
        $this->curl_push($push_redis_key);
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->pconnect($redis_config['write']['hostname'], $redis_config['write']['port']);
        $redis->set($index_name."_".$article_info["msg_id"]."pushaaa", "push_success");

    }

    /**
     *  写推送用户的redis.
     *
     * @param array $user_ids  用户id列表.
     * @param array $article_info  文章信息.
     * @param string $push_redis_key    推送redis key.
     */
    protected function write_push_user_redis($user_ids= array(),$article_info, $push_redis_key)
    {
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->connect($redis_config['write']['hostname'], $redis_config['write']['port']);
        if (!empty($user_ids)) {
            $user_ids = array_unique($user_ids);
            shuffle($user_ids);
            $push_arr = array(
                'uid_list' => $user_ids,
                'article_info' => array(
                    'msg_id' => isset($article_info['msg_id']) ? $article_info['msg_id'] : '',
                    'msg_title' => isset($article_info['msg_title']) ? $article_info['msg_title'] : '',
                    'msg_pic_url' => isset($article_info['msg_pic_url']) ? $article_info['msg_pic_url'] :'',
                    'msg_full_title' => isset($article_info['msg_title']) ? $article_info['msg_title'] :'',
                    'msg_mall' => isset($article_info['article_mall']) ? $article_info['article_mall'][0] : '',
                    'msg_type' => isset($article_info['msg_type']) ? $article_info['msg_type'] : 'youhui',
                    'msg_content' => isset($article_info['msg_content']) ? $article_info['msg_content'] : "",
                    'msg_push_type' => isset($article_info['msg_push_type']) ? $article_info['msg_push_type'] : 1
                ),
            );
            $redis->set($push_redis_key, json_encode($push_arr));
        }
        $redis->close();
    }

    /**
     * curl 推送接口.
     *
     * @param $push_uid_redis_key
     */
    protected function curl_push($push_uid_redis_key)
    {
        $url = Config::$push_user_api;
        $url .="/push?push_uid_redis_key=".$push_uid_redis_key;
        $this->curl->simple_get($url, array(), array(CURLOPT_TIMEOUT => 15));
    }
    /**
     *获取筛选推送用户的query.
     * 一些查询规则什么的，当开启安静时间选项时,文章的发布时间不在安静时间段中才会被筛选出来.
     *
     * @param $quite_time
     *
     * @return array
     */
    protected function get_search_push_query($quite_time )
    {
        $query = array(
            'bool' => array(
                'must' => array(
                    array(
                        "term" => array(
                            "is_push" => false
                        )
                    ),
                    /*array(
                        "term"=> array(
                            "mrjx" => 1
                        )
                    ),*/
                    array(
                        "bool" => array(
                            "should" => array(
                                array(
                                    "term" => array(
                                        "open_quite_time" => 0
                                    )
                                ),
                                array(
                                    "bool" => array(
                                        "must" => array(
                                            array(
                                                "term" => array(
                                                    "open_quite_time" => 1
                                                )
                                            ),
                                            array(
                                                "bool" => array(
                                                    "must_not" => array(
                                                        array(
                                                            "term" => array(
                                                                "quite_time" => $quite_time
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );
        return $query;
    }

    /**
     *  反查全部用户.(包括写全部用户redis队列,用户规则redis,调用用户列表)
     *
     * @param array $article_info
     * @param int   $index_num
     *
     * @return bool
     */
    function search_all_user($article_info = array(), $index_num = 0)
    {
        if (empty($article_info)) {
            return false;
        }
        $doc = array(
            'article_tag_names' => isset($article_info['article_tag_names']) ? $article_info['article_tag_names'] : array(),
            'article_brand_ids' => isset($article_info['article_brand_ids']) ? $article_info['article_brand_ids'] : array(),
            'article_mall' => isset($article_info['article_mall']) ? $article_info['article_mall'] : array(),
            'article_type' => isset($article_info['msg_type']) ? $article_info['msg_type'] : "",
            'article_title_ik' => isset($article_info['msg_title']) ? strtolower($article_info['msg_title']) : "",
            'article_title' => isset($article_info['msg_title']) ? strtolower($article_info['msg_title']) : "",
            'article_category_names' => isset($article_info['article_category_names']) ? $article_info['article_category_names'] : array(),
        );
        $search_params = array(
            "index" => Config::$index_prefix."_".$index_num,
            "type" => 'article',
            'body' => array(
                'doc' => $doc
            )
        );
        $search_data = $this->elasticsearch->percolate($search_params);
        if (!empty($search_data["error_msg"])) {
            //todo email 报错
            return $search_data["error_msg"];
        }
        if (!empty($search_data["data"]["matches"])) {
            $match_all_users = array();
            $matches = $search_data["data"]["matches"];
            foreach ($matches as $match_key => $match_val) {
                $match_info = explode("||", $match_val);
                $match_all_users[] = $match_info[0];
                if (in_array($match_info['2'], Config::$allow_channel_list)) {
                    $matches_info['2'] = 'title';
                }
                $matches_dingyue_rules[$match_info['0']][$match_key] = array(
                    'keyword' => $match_info['1'],
                    'type' => $matches_info['2'],
                    'es_id' => $match_val
                );
                unset($matches[$match_key]);
            }
            unset($matches);
        }
        // 写全部用户redis 队列
        $all_user_redis_key = "DY_".$article_info["article_type"]."_".$article_info["msg_id"];
        $this->write_all_user_redis($match_all_users, $all_user_redis_key);
        $rules_hset_key = $article_info["msg_id"]."_".$article_info["article_type"];
        // 写用户redis 规则.
        $this->write_user_matches_rules($matches_dingyue_rules,$rules_hset_key);
        // curl 调用我的订阅接口.
        $this->curl_my_dingyue(array('id' => $article_info['msg_id'], 'type' => $article_info['article_type']));


        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->pconnect($redis_config['write']['hostname'], $redis_config['write']['port']);
        $redis->set("searchaaaa_".$index_num."_".$article_info["msg_id"], "search_success");

    }

    /**
     *  全部用户写入redis队列.
     *
     * @param array  $user_ids
     * @param string $redis_key
     */
    protected function write_all_user_redis($user_ids = array(), $redis_key = "")
    {
        $user_ids = array_unique($user_ids);
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->connect($redis_config['write']['hostname'], $redis_config['write']['port']);
        if (!empty($user_ids)) {
            $redis->pipeline();
            foreach ($user_ids as $user_key => $user_val) {
                $redis->lPush($redis_key, $user_val);
            }
            $redis->exec();
        }
        $redis->close();
    }

    /**
     * 写用户规则.
     *
     * @param array  $matches_arr
     * @param string $hset_key
     */
    protected function write_user_matches_rules($matches_arr = array(), $hset_key="")
    {
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->connect($redis_config['write']['hostname'], $redis_config['write']['port']);
        if (!empty($matches_arr)) {
            $redis->pipeline();
            foreach ($matches_arr as $match_key => $matches_val) {
                sort($matches_val);
                $rules_redis_key = "DY_matches_rules:".$match_key.":";
                $redis->hSet($rules_redis_key, $hset_key, json_encode($matches_val));
            }
            $redis->exec();
        }
        $redis->close();
    }

    /**
     *  curl 调用我的订阅接口.
     *
     * @param array $post_data
     */
    function curl_my_dingyue($post_data = array())
    {
        if (empty($post_data)) {
            $url = Config::$my_dingyue_api;
            $this->curl->simple_post($url, $post_data);
        }
    }

    function test()
    {
        $this->load->config('redis');
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        $redis->pconnect($redis_config['write']['hostname'], $redis_config['write']['port']);
        $count = $redis->get("dy_lzl_success");
        $redis->set("lzl_shell", $count);
    }
}