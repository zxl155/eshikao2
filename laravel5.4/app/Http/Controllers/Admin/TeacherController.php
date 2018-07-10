<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Curriculum;
use App\Admin\Models\Pplive;

class TeacherController extends CommonController
{	
	public function teacherLive()
	{
		$admin_id = session('data')['admin_id'];
		$pplive = new Pplive;
		$data = $pplive ->admin_pplive($admin_id);
		return view('admin/teacher/teacherLive',[
			'data'=>$data,
		]);
	}
	//助教入口
	public function Assistant()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$arr = $pplive->Assistant($pplive_id);
	}
	//老师直播
	public function teacherLives()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$arr = $pplive->teacherShow($pplive_id);
	}
	//直播回放
	public function playback()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$pplive->playback($pplive_id);
	}
}