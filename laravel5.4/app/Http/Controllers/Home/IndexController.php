<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\Admin;
use App\Models\Curriculum;

class IndexController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台首页张晓龙
     */
	public function index()
	{
		$user = new Admin;
		$admin = $user->searchTeachers(); //admin教师的数据
		//查询教师资格数据
		$curriculum = new Curriculum;
		$qualifications = $curriculum->qualifications();
		$teacher = $curriculum->teachera(); //获取教师与课程的管理数据
		$admin = $curriculum->admina($admin,$teacher);
		//
		$qualification = $curriculum->qualification();
		$teachers = $curriculum->teachers(); //获取教师与课程的管理数据
		$admins = $curriculum->admins($admin,$teachers);
		return view('home/index/index',['qualifications' => $qualifications,'admin' => $admin,'qualification' => $qualification,'admins' => $admins]);

	}
}