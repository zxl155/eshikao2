<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\User;

class MyclassController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台个人中心我的课程
     */
	public function index(){
		return view('home/personal/personal');
	}
}