<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Course;
use App\Admin\Models\Curriculum;
class CourseController extends CommonController
{	
	//课程包展示
	public function package()
	{
		$course = new Course;
		$data = $course->package();
		return view('admin/course/package',['data'=>$data]);
	}
	//添加课程包
	public function addPackage()
	{
		$curriculum = new Curriculum;
		$data = $curriculum->selects();
		return view('admin/course/addPackage',['data'=>$data]);
	}
	//执行添加课程包
	public function addPackages()
	{
		$data = Input::all();
		$course = new Course;
		$data = $course->addPackages($data);
		if ($data) {
			return redirect('admin/package');
		} else {
			echo "添加失败";
		}
	}
	//删除课程包
	public function delPackage()
	{
		$course_id = Input::get('course_id');
		$course = new Course;
		$arr = $course ->delPackage($course_id);
		if ($arr) {
			return redirect('admin/package');
		} else {
			echo "删除失败";
		}
	}
	//修改课程包
	public function updatePackage()
	{
		$course_id = Input::get('course_id');
		$course = new Course;
		$course = $course ->updatePackage($course_id);
		$curriculum = new Curriculum;
		$data = $curriculum->selects();
		return view('admin/course/updatePackage',['course'=>$course,'data'=>$data]);
	}
	//执行修改
	public function updatePackages()
	{
		$data = Input::all();
		$course = new Course;
		$arr = $course->updatePackages($data);
		if ($arr) {
			return redirect('admin/package');
		} else {
			echo "修改失败";
		}
	}
}