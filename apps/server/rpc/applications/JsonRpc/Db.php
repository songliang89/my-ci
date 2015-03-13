<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/3/13
 * Time: 下午5:04
 */

require_once ROOT_DIR . '/Database/vendor/autoload.php';

$capsule = new Capsule();
$dataConfig = array(
	'driver' => 'mysql',
	'host'  => 'localhost',
	'database' => 'my_ci',
	'username' => 'root',
	'password' =>'123456',
	'charset' => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix'    => ''
);
$capsule->addConnection($dataConfig);
$capsule->bootEloquent();
