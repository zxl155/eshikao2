<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Gregwar\Captcha\SmsDemo;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Qualifications;
use App\Home\Models\Admin;
use App\Home\Models\Curriculum;

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
	    $curriculum = new Curriculum;
		$recruits = $curriculum ->recruits(); //教师招聘
		return view('home/recruit/Recruitment',[
			'cattype' => $cattype,
			'gradetype' => $gradetype,
			'subjecttype' => $subjecttype,
			'region' => $region,
			'recruits' => $recruits,
		]);
	}
	/**
	 * 前台招聘搜索
	 */
	public function recruitSearch()
	{
		$data = Input::all();
		//print_r($data);die;
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