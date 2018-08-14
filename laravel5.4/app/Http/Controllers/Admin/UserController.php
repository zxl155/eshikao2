<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\User;
use App\Admin\Models\Order;
use App\Admin\Models\Curriculum;

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
		$user_tel = Input::get('user_tel');
		$need = Input::get('need');
		$user = new User;
		$data = $user->userCurriculum($user_tel,$need);
		return view('admin/user/userCurriculum',['data'=>$data,'user_tel'=>$user_tel,'need'=>$need]);
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
	//给用户添加对应的课程
	public function userCurriculumAdd()
	{
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->curriculum_name();
		return view('admin/user/userCurriculumAdd',['data'=>$data,'curriculum_id'=>$curriculum_id]);
	}
	//给用户添加对应的课程执行添加
	public function userCurriculumAdds()
	{
		$data = Input::all();
		$order = new Order;
		$arr = $order->userCurriculumAdds($data);
		if ($arr) {
			return redirect('admin/userCurriculum');
		} else {
			echo "添加用户对应课程失败";
		}
	}
}