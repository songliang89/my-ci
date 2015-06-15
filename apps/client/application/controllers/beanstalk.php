<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/6/15
 * Time: 下午4:48
 */

class beanstalk extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $beanstalk = new \Pheanstalk\Pheanstalk('127.0.0.1');
        $beanstalk->useTube("testtube");
        $beanstalk->put("job payload goes heres\n");

        $job = $beanstalk->watch("testtube")->reserve();

        echo $job->getData();
    }
}