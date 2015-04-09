<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/4/8
 * Time: 下午1:44
 */
class Zdm_dy extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('es');
        $this->load->helper('url');
        $this->load->library('My_Redis_Cache',array("connect" => "default"),'redis_cache');
    }

    public $subscribe_index = array(
        'index' => 'zdm_subscribe',
        'body' => array(
            'settings' => array(
                'number_of_shards' => 10,
                'number_of_replicas' => 1,
                'refresh_interval' => 10
            ),
            'mappings' => array(
                'zdm_article' => array(
                    '_routing' => array(
                        'required' => true,
                        'path' => 'article_id'
                    ),
                ),
                'properties' => array(
                    //文章id
                    'article_id' => array(
                        'type' => 'integer',
                        'index' => 'article_type'
                    ),
                    'article_tittle' => array(
                        'type'           => 'string',
                        'index_analyzer' => 'index_ansj',
                        'search_analyzer' => 'query_ansj',
                        'include_in_all' => false,
                    ),
                    //文章内容
                    'article_content' => array(
                        'type'           => 'string',
                        'index_analyzer' => 'index_ansj',
                        'search_analyzer' => 'query_ansj',
                        'include_in_all' => false,
                    ),
                    //文章标题 ik 分词
                    'article_title_ik' => array(
                        'type'           => 'string',
                        'indexAnalyzer' => 'ik',
                        'searchAnalyzer' => 'ik',
                        'term_vector' => 'with_positions_offsets',
                        'include_in_all' => false,
                        'boost' => '5'
                    ),
                    //文章内容 ik 分词
                    'article_content_ik' => array(
                        'type'           => 'string',
                        'indexAnalyzer' => 'ik',
                        'searchAnalyzer' => 'ik',
                        'term_vector' => 'with_positions_offsets',
                        'include_in_all' => false,
                    ),
                    //文章发布时间
                    'article_publish_time' => array(
                        'type' => 'date',
                        'store' => 'yes',
                        'format' => 'yyyy-MM-dd HH:mm:ss'
                    ),
                    //文章关联的商场
                    'article_mall' => array(
                        'type' => 'string',
                        'index'=>'not_analyzed'
                    ),
                    'article_type' => array(
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ),
                    'article_tag' => array(
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ),
                    'article_category' => array(
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ),
                ),
            ),
        ),
    );

    public $article_type = ['youhui','haitao','yuanchuang','news','zhongce','faxian'];
    public $keywords = [
        '神价格','iphone','iphone 4s','手机','笔记本电脑','只能手机','相机','键盘','鼠标',
        '双11','佳能','尼康','ps3','ps4','电动剃须刀','飞利浦','奔腾','苹果','macbook',""
    ];
    public $keywords2 = [
        "神","价格","笔","笔记","记","本","电","脑","笔记本","笔记本电","电脑","本电脑","奔","腾","奔腾",
        "mac","book","macbook","飞","利","飞利浦","飞利","利浦"
    ];

    public function create_dy_data()
    {
        ini_set('max_execution_time', '0');
        $this->load->helper('file');
        $path = APPPATH . "data/keywords";
        $keywords = read_file($path);
        $keywords_arr = explode("\n", $keywords);
        $keyword_count = count($keywords_arr);
        $article_type_count = count($this->article_type);
        for($i = 1; $i <= 100000;$i++) {
            $keyword = $keywords_arr[rand(0,$keyword_count-1)];
            if ($keyword == "") {
                continue;
            }
            $article_type = $this->article_type[rand(0,$article_type_count-1)];
            $dy_id = $i."-"."关键词-".$this->deal_special_characters(addslashes(rtrim(ltrim($keyword))))."-频道-".$article_type;
            $index_params = array(
                'index' => 'smzdm_article_index_v5' ,
                'type'  => '.percolator',
                'id'    => $dy_id,
                'body'  => array(
                    'query' => array(
                        'bool' => array(
                            'must' => array(
                                array(
                                    'term' => array(
                                        'article.article_type'=>$article_type
                                    ),
                                ),
                                array(
                                    'query_string' => array(
                                        'default_field' => 'article.article_title',
                                        'analyzer' => 'keyword',
                                        'default_operator' => 'and',
                                        'query' => $this->deal_special_characters(addslashes(rtrim(ltrim($keyword))))
                                    ),
                                )
                            ),
                        ),
                    ),
                ),
            );
            $ret = $this->es->index($index_params);
            if(!empty($ret['error_msg'])) {
                echo "ERROR".PHP_EOL.$keyword.PHP_EOL;
            } else {
                echo "success".PHP_EOL.$this->deal_special_characters(addslashes(rtrim(ltrim($keyword)))).PHP_EOL;
            }
            #if ($i == 10) break;
        }

    }

    public  $category_list = [
                "个护化妆","食品保健","图书音像","电子书刊","音像制品","文艺书刊","社会科学","经济管理","母婴少儿",
                "科普教育","进口图书","辞典与工具书","家用电器","大家电","生活电器","厨房电器","个护健康","家居家装","家装主材",
                "卫浴产品","宠物用品","五金电工","厨房用具","住宅家具","灯具灯饰","家纺布艺","生活用品","服饰鞋包","男装","女装",
                "男鞋","女鞋","童装","服装配饰","内衣","运动服饰","母婴用品"
    ];
    public function create_dy_category_data()
    {
        ini_set('max_execution_time', '0');
        $category_count = count($this->category_list);
        $article_type_count = count($this->article_type);
        for($i = 1; $i <= 100000;$i++) {
            $category = $this->category_list[rand(0,$category_count-1)];
            $article_type = $this->article_type[rand(0,$article_type_count-1)];
            $dy_id = $i."%(^_^)%"."分类%(^_^)%".$category."%(^_^)%频道%(^_^)%".$article_type;
            $index_params = array(
                'index' => 'smzdm_article_index_v5' ,
                'type'  => '.percolator',
                'id'    => $dy_id,
                'body'  => array(
                    'query' => array(
                        'bool' => array(
                            'must' => array(
                                /*array(
                                    'term' => array(
                                        'article.article_type'=>$article_type
                                    ),
                                ),*/
                                array(
                                    'term' => array(
                                        'article_category_names' => $category
                                    ),
                                )
                            ),
                        ),
                    ),
                ),
            );
            $ret = $this->es->index($index_params);
            var_dump($ret);
            #if ($i == 10) break;
        }

    }
    private function deal_special_characters($keywords)
    {
        $filters = array(
            '(','+','&','&&','|','||','!','{','}','[',']','^','"','~','*','?',':',')','/'
        );
        if (!empty($filters)) {
            foreach ($filters as $key => $val) {
                if (stripos($keywords,$val) !== false) {
                    $keywords = str_replace($val,'\\'.$val,$keywords);
                }
            }
        }
        return $keywords;
    }

}