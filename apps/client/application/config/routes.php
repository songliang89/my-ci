<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';

/**
 * 用户注册
 */
$route['register'] = 'user/user/register';

/**
 * 用户登录
 */
$route['login'] = 'user/user/login';

/**
 *  用户注册ajax 提交
 */
$route['register_ajax_submit'] = 'ajax/web_user/register';

/**
 *  用户登录ajax 提交
 */
$route['login_ajax_submit'] = 'ajax/web_user/login';


/**
 *  判断用户名是否存在
 */
$route['register_is_exist_username'] = 'ajax/web_user/is_exist_user';

/**
 * 判断注册邮箱是否存在
 */
$route['register_is_exist_email'] = 'ajax/web_user/is_exist_email';


/**
 *  验证码
 */
$route['authcode'] = 'public/common/auth_code';

/**
 *  检验验证码ajax
 */
$route['check_authcode'] = 'public/common/check_auth_code';

/**
 * 退出
 */
$route['logout'] = 'user/user/logout';

/**
 *  用户资料设置
 */
$route['base_info'] = 'user/user/base_info';

/**
 *  地区列表页
 */
$route['district'] = 'category/category/district';

/**
 *  获取子级地区列表ajax
 */
$route['district_child_list'] = 'ajax/category_ajax/get_district_child_list';

/**
 *  地区编辑页
 */
$route['district_edit/([0-9]+)?'] = 'category/category/edit/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
