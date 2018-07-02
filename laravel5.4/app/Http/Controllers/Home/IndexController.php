<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Admin;
use App\Home\Models\Curriculum;
use App\Home\Models\Broadcast;

class IndexController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台首页张晓龙
     */
	public function index()
	{
		//首页轮播图
		$broadcast = new Broadcast;
		$broadcast_content = $broadcast ->index(); 
		//首页教师资格证
		$curriculum = new Curriculum;
		$qualifications  = $curriculum->qualifications();
		//首页招聘
		$recruit = $curriculum->recruit();
		return view('home/index/index',[
			'broadcast_content' => $broadcast_content,
			'qualifications' => $qualifications,
			'recruit' => $recruit,
		]);

	}
	//用户协议
	public function agreement()
	{
		return view('home/index/agreement');
	}
	//前天关于我们
	public function about()
	{
		return view('home/index/about');
	}
}