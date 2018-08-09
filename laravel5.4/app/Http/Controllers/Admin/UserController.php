<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\User;
use App\Admin\Models\Order;

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
			echo "<script>alert('添加成功');location.href='manualUser';</script>";
		} else {
			echo "添加新用户失败";
		}
	}
	//手动注册的用户
	public function manualUser()
	{
		$user = new User;
		$data = $user->manualUser();
		return view('admin/user/manualUser',['data'=>$data]);
	}
	//注册用户
	public function registerUser()
	{
		$user = new User;
		$data = $user->registerUser();
		return view('admin/user/registerUser',['data'=>$data]);
	}
	//用户对应的购买课程
	public function userCurriculum()
	{
		$user = new User;
		$data = $user->userCurriculum();
		return view('admin/user/userCurriculum',['data'=>$data]);
	}
	//用户对应的发货单号
	public function invoice()
	{
		$data = Input::all();
		$order = new Order;
		$arr = $order->invoice($data);
		return json_encode($arr);
	}
	//用户对应的发货快递公司
	public function invoices()
	{
		$data = Input::all();
		$order = new Order;
		$arr = $order->invoices($data);
		return json_encode($arr);
	}
}