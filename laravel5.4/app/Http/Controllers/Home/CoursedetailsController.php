<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Curriculum;
use App\Home\Models\UserCurriculum;
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
		$is_buy = $curriculum -> is_curriculum($curriculum_id);
		if (!empty($is_buy)) {
			header("location:coursedetail.html?curriculum_id=$curriculum_id");die;
		}
		$curriculum_content = $curriculum->coursedetails($curriculum_id);
		$usercurriculum = new UserCurriculum;
		$isPurchase = $usercurriculum->isPurchase($curriculum_content[0]->curriculum_id);//查询是否购买了本课程
		if ($isPurchase) {
			$isPurchase = 1;
		} else {
			$isPurchase = 0;
		}
		$regihtcontent = $curriculum->regihtContent($curriculum_id);
		$pplive = new Pplive;
		$pplive_content = $pplive ->shows($curriculum_id);
		//免费课程
		$free = $pplive->is_free($curriculum_id);
		return view('home/coursedetails/viewdetails',[
			'curriculum_content' => $curriculum_content,
			'pplive_content' => $pplive_content,
			'regihtcontent' => $regihtcontent,
			'isPurchase' => $isPurchase,
			'free' => $free,
		]);
	}

	//购买之后的课程详情
	public function coursedetail()
	{
		$curriculum_id = Input::get('curriculum_id');
		//判断是否购买该课程
		$curriculum = new Curriculum;
		$is_buy = $curriculum -> is_curriculum($curriculum_id);
		if (empty($is_buy)) {
			echo "无购买本课程";die;
		}
		$curriculum_content = $curriculum->coursedetails($curriculum_id);
		$regihtcontent = $curriculum->regihtContent($curriculum_id);
		$pplive = new Pplive;
		$pplive_content = $pplive ->shows($curriculum_id);
		return view('home/coursedetails/coursedetails',[
			'curriculum_content' => $curriculum_content,
			'pplive_content' => $pplive_content,
			'regihtcontent' => $regihtcontent,
		]);
	}
	//查看直播
	public function coursedetailShow()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$pplive->coursedetailShow($pplive_id);
	}
	//查看回放
	public function playback()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$pplive ->playback($pplive_id);
	}
}