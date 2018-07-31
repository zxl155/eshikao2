<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Course;

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
}