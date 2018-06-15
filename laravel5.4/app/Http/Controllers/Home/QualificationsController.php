<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Qualifications;
use App\Models\Admin;

class QualificationsController extends Controller
{
	/**
     * @张小龙
     * @DateTime  2018-06-14
     * 前台教师资格
     */
	public function qualifications(){
		$qualifications = new qualifications;
		$cattype = $qualifications->catType();//笔试面试类型
		$gradetype = $qualifications->gradeType();//年级
		$subjecttype = $qualifications->subjectType();//学科
		$curriculum = $qualifications->curriculum();
		
		$user = new Admin;
		$admin = $user->searchTeachers(); //admin教师的数据
		$qualification = $qualifications->qualifications();
		$teacher = $qualifications->teacher(); //获取教师与课程的管理数据
		$admin = $qualifications->admin($admin,$teacher);
		return view('home/qualifications/qualifications',[
			'cattype' => $cattype,
			'gradetype' => $gradetype,
			'subjecttype' => $subjecttype,
			'curriculum' => $curriculum,
			'admin' => $admin,
		]);
	}
	/**
	 * 搜索
	 */
	public function quaSearch()
	{
		$data = Input::all();
		$qualifications = new Qualifications;
		$quasearch = $qualifications ->quaSearch($data);
		if (empty($quasearch)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $quasearch;
		}
		return json_encode($data);
	}
}