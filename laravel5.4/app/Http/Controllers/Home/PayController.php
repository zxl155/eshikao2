<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\User;

class PayController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-25
     * 前台支付张晓龙
     */
	public function index()
	{
		$data = Input::all();
		return view('home/pay/alipayapi',['data'=>$data]);
	}
	//异步
	public function asynchronous()
	{
		/*$data = Input::all();
		print_r($data);*/
		return view('home/pay/return_url');
	}
	//支付成功回调页面
	public function apiSuccess()
	{
		echo "成功页面的吗";
	}
}