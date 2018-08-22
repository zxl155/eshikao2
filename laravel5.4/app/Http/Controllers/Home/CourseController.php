<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Course;
use App\Home\Models\Order;
use App\Home\Models\Curriculum;
class CourseController extends Controller
{
	//查询课程包
	public function package()
	{
		$user_id = Input::get('user_id');
		session(['sales_user_id' => $user_id]);
		//session()->forget('sales_user_id');  删除session
		$course = new Course;
		$data = $course->package($user_id);
		return view('home/course/course',['data'=>$data]);
	}
	//代理查询订单
	public function orderSearch()
	{
		$search = Input::get('search');
		if ($search != "") {
			$order = new Order;
			$order = $order->orderSearch($search);
		} else {
			$order = '';
		}
		return view('home/course/orderSearch',['order'=>$order]);
	}
	//课程包详情
	public function courselist()
	{
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->courselist($curriculum_id);
		$curriculum = $curriculum->oneCurriculum($curriculum_id);
		return view('home/course/courselist',['data'=>$data,'curriculum'=>$curriculum]);
	}
}