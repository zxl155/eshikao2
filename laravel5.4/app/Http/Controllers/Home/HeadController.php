<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\home\User;

class HeadController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台首页张晓龙
     */
	public function index(){
		$user_id = session('user_id');
		echo $user_id;die;
	}
}