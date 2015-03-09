<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/9
 * Time: 下午7:03
 */
class Common extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('authcode');
        $this->load->library('session');
    }

    function auth_code()
    {
        return $this->authcode->show();
    }
}