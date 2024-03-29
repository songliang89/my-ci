<?php
namespace App\Controller;
use Swoole;
use App;

class Page extends Swoole\Controller
{
    //hello world
    function index()
    {
	    $user = new APP\DAO\User(1);
	    $info = $user->get();
	    var_dump($info);
        return "default page";
    }

    function detail()
    {
        var_dump($_GET);
    }

    //数据库测试
    function db_test()
    {
        $result = $this->db->query("show tables");
        var_dump($result->fetchall());
    }

    //缓存获取
    function cache_get()
    {
        $result = $this->redis->get("swoole_var_1");
        var_dump($result);
    }

    //缓存设置
    function cache_set()
    {
        $result = $this->redis->set("swoole_var_1", "swoole");
        if($result)
        {
            echo "cache set success. Key=swoole_var_1";
        }
        else
        {
            echo "cache set failed.";
        }
    }

    //使用smarty引擎
    function tpl_test()
    {
        $this->tpl->assign('my_var', 'swoole use smarty');
        $this->tpl->display('tpl_test.html');
    }

    function session_test()
    {
        $this->session->start();
        $_SESSION['hello'] = 'swoole';
    }

    function redirect()
    {
        $this->http->redirect('http://www.baidu.com');
        $_SESSION['hello'] = 'swoole';
    }

    function http_header()
    {
        $this->http->status(302);
        $this->http->header('Location', 'http://www.baidu.com');
        $_SESSION['hello'] = 'swoole';
    }

    function session_read()
    {
        $this->session->start();
        var_dump($_SESSION);
    }

    //使用php直接作为模板
    function view_test()
    {
        $this->assign('my_var', 'swoole view');
        $this->display('view_test.tpl.php');
    }

    function vcode()
    {
        $this->session->start();
        $this->http->header('Content-Type', 'image/jpeg');
        Swoole\Image::verifycode_gd();
    }

    //class autoload
    function class_load()
    {
        App\Test::hello();
    }

    function post()
    {
        var_dump($_POST);
    }

    //exit or die
    function exit_php()
    {
        $this->http->finish("die.");
    }

    function model_test()
    {
        $model = model('User');
        $user1 = $model->get(1); //id = 1
        var_dump($user1->get());

        /**
         * ORM接口
         */
        $user1->name = "hantianfeng";
        $user1->level = 99;
        $user1->mobile = "13999998888";
        /**
         * 如果id=1存在，则是Update，不存在是insert
         */
        $user1->save();
        /**
         * 删除此数据
         */
        $user1->delete();

        /**
         * 查找level = 99 and name = hantianfeng 的记录
         */
        $users = $model->gets(array('level' => 99, 'name' => 'hantianfeng'));
        var_dump($users);

        $model->del(2); //delete id = 2

        /**
         * 删除所有level > 10的记录
         */
        $model->dels(array('where' => 'level > 10',));

        //插入单条数据
        $model->put(array('name' => 'wahaha', 'mobile' => '13000009966'));

        //分页
        $model->gets(array('page' => 1, 'pagesize' => 10, 'level' => 99), $pager);
        var_dump($pager->render());
    }

    function upload()
    {
        if ($_FILES)
        {
            //需要生成缩略图
            $this->upload->thumb_width = 136; //缩略图宽度
            $this->upload->thumb_height = 136; //缩略图高度
            $this->upload->thumb_qulitity = 100; //缩略图质量

            //自动压缩图片
            $this->upload->max_width = 600; //约定图片的最大宽度
            $this->upload->max_height = 600; //约定图片的最大高度
            $this->upload->max_qulitity = 90; //图片压缩的质量

            $up_pic = $this->upload->save('Filedata');
            if (empty($up_pic))
            {
                echo '上传失败，请重新上传！ Error:' . $this->upload->error_msg;
            }
            echo json_encode($up_pic);
        }
        else
        {
            echo "Bad Request\n";
        }
    }
}