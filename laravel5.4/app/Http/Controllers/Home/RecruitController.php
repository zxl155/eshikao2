<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Gregwar\Captcha\SmsDemo;
use Illuminate\Support\Facades\Input;
use App\Models\home\Qualifications;
use App\Models\home\Admin;


class RecruitController extends Controller
{	
	
	/**
     * @张小龙
     * @DateTime  2018-06-14
     * 前台招聘
     */
	public function index(){
		$qualifications = new Qualifications;
		$cattype = $qualifications->catType();//笔试面试类型
		$gradetype = $qualifications->gradeType();//年级
		$subjecttype = $qualifications->subjectType();//学科
		$region = $qualifications->region();//地区

		$curriculum = $qualifications->curriculums();
		$user = new Admin;
		$admin = $user->searchTeachers(); //admin教师的数据
		$qualification = $qualifications->qualifications();
		$teacher = $qualifications->teacher(); //获取教师与课程的管理数据
		$admin = $qualifications->admin($admin,$teacher);
		return view('home/recruit/recruitment',[
			'cattype' => $cattype,
			'gradetype' => $gradetype,
			'subjecttype' => $subjecttype,
			'region' => $region,
			'curriculum' => $curriculum,
			'admin' => $admin,
		]);
	}
	/**
	 * 前台招聘搜索
	 */
	public function recruitSearch()
	{
		$data = Input::all();
		$qualifications = new Qualifications;
		$recruitsearch = $qualifications ->recruitSearch($data);
		if (empty($recruitsearch)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $recruitsearch;
		}
		return json_encode($data);
	}
}