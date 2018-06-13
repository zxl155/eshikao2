<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use App\Region;
use App\Category;
use App\Grade;
use App\Subject;


class QualificationsController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-08
     * 前台教师资格
     */
	public function qualifications(){
		$cate = new Category;
		$grade = new Grade;
		$subject = new Subject;
		$cate = $cate->get();
		$grade = $grade->get();
		$subject = $subject->get();	
		$data = DB::table('curriculum')->Join('teacher', 'curriculum.tea_id', '=', 'teacher.tea_id')->in('curriculum.tea_id')->get();
		dd($data);die;
		return view('home/qualifications/qualifications',[
			'cate' =>$cate,
			'grade' =>$grade,
			'subject' =>$subject,
			'data' =>$data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-08
     * 前台教师资格
     */
	public function viewdetails(){
		$curriculum = new Curriculum;
		$teacher = new Teacher;
		$teacher = $teacher->get();
		$curriculum = $curriculum->get();
		return view('home/qualifications/viewdetails',[
			'curriculum' =>$curriculum,
			'teacher' =>$teacher
		]);
	}
}