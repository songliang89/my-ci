<?php
/**
 *  测试
 * @author walkor <worker-man@qq.com>
 */

class User_model extends Illuminate\Database\Eloquent\Model
{
   protected $table = 'web_user';

}

class User
{
	static function getUser()
	{
		//return "aaa";
		$data = User_model::all();
		return $data;
	}

	static function getUserById($id)
	{
		return User_model::find($id);
	}
}
