<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Curriculum;
use App\Home\Models\Pplive;

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
		$curriculum_content = $curriculum->coursedetails($curriculum_id);
		$regihtcontent = $curriculum->regihtContent($curriculum_id);

		$pplive = new Pplive;
		$pplive_content = $pplive ->shows($curriculum_id);
		//print_r($arr);die;
		return view('home/coursedetails/viewdetails',[
			'curriculum_content' => $curriculum_content,
			'pplive_content' => $pplive_content,
			'regihtcontent' => $regihtcontent,
		]);
	}
}