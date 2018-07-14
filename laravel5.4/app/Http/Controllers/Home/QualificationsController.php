<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Home\Models\Qualifications;
use App\Home\Models\Curriculum;
use App\Home\Models\Admin;

class QualificationsController extends Controller
{
	/**
     * @张小龙
     * @DateTime  2018-06-14
     * 前台教师资格
     */
	public function qualifications(){
		$qualifications = new Qualifications;
		$cattype = $qualifications->catType();//笔试面试类型
		$gradetype = $qualifications->gradeType();//年级
		$subjecttype = $qualifications->subjectType();//学科
		$curriculum = new Curriculum;
		$qualifications = $curriculum ->qualificationss(); //教师资格证
		return view('home/qualifications/qualifications',[
			'cattype' => $cattype,
			'gradetype' => $gradetype,
			'subjecttype' => $subjecttype,
			'qualifications' => $qualifications,
		]);
	}
	/**
	 * 搜索
	 */
	public function quaSearch()
	{
		$data = Input::all();
		$qualifications = new Qualifications;
		$qualifications = $qualifications ->quaSearch($data);
		//print_r($qualifications);die;
		if (empty($qualifications)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $qualifications;
		}
		return json_encode($data);
	}
	/**
	 * 通过教师资格证人气搜索
	 */
	public function popularity()
	{
		$qualifications = new Qualifications;
		$qualifications = $qualifications->popularity();
		if (empty($qualifications)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $qualifications;
		}
		return json_encode($data);
	}
	/**
	 * 通过教师资格证价格搜索
	 */
	public function moneys()
	{
		$moneys = Input::get('moneys');
		$qualifications = new Qualifications;
		$qualifications = $qualifications->moneys($moneys);
		if (empty($qualifications)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $qualifications;
		}
		return json_encode($data);
	}
	/**
	 * 通过教师招聘人气搜索
	 */
	public function popularitys()
	{
		$qualifications = new Qualifications;
		$qualifications = $qualifications->popularitys();
		if (empty($qualifications)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $qualifications;
		}
		return json_encode($data);
	}
	/**
	 * 通过教师招聘价格搜索
	 */
	public function moneyss()
	{
		$moneys = Input::get('moneys');
		$qualifications = new Qualifications;
		$qualifications = $qualifications->moneyss($moneys);
		if (empty($qualifications)) {
			$data['empty'] = 'empty';
		}else {
			$data['data'] = $qualifications;
		}
		return json_encode($data);
	}
}