<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Teacher;

class TeacherController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-08
     * 教师添加
     */
	public function addtea(){
		return view('admin/teacher/addtea');
	}

	/**
     * @李一明
     * @DateTime  2018-06-08
     * 教师添加
     */
	public function dotea(){
		$tea_name = Input::get('tea_name');
		$tea_title = Input::get('tea_title');
		$tea_desc = Input::get('tea_desc');
		$teacher = new Teacher;
	}
	/**
     * @李一明
     * @DateTime  2018-06-08
     * 教师列表
     */
	public function listtea(){
		return view('admin/teacher/listtea');
	}
	/**
     * @李一明
     * @DateTime  2018-06-08
     * 教师修改
     */
	public function updtea(){
		return view('admin/teacher/updtea');
	}
	/**
     * @李一明
     * @DateTime  2018-06-08
     * 教师删除
     */
	public function deltea(){
		return view('admin/teacher/deltea');
	}
}