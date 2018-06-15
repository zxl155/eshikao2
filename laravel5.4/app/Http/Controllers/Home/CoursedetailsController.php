<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\Curriculum;
use App\Models\Pplive;

class CoursedetailsController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台课程详情张晓龙
     */
	public function index()
	{
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->coursedetails($curriculum_id);
		$teacher = $curriculum->oneTeacher($data[0]->curriculum_id);
		$pplive = new Pplive;
		$pplive = $pplive->shows($curriculum_id);
		return view('home/coursedetails/viewdetails',['data' => $data,'pplive'=>$pplive,'teacher'=>$teacher]);
	}
}