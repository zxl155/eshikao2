<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\User;
class UserController extends CommonController
{	
	//添加用户
	public function addUser()
	{
		return view('admin/user/addUser');
	}
	//执行添加
	public function addUsers()
	{
		$data = Input::all();
		$user = new User;
		$arr = $user->addUsers($data);
		if ($arr) {
			echo "<script>alert('添加成功');location.href='addUser';</script>";
		} else {
			echo "添加新用户失败";
		}
	}
}