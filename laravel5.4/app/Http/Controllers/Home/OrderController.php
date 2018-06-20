<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Admin;
use App\Home\Models\Curriculum;

class OrderController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-20
     * 前台订单张晓龙
     */
	public function index()
	{
		
		return view('home/order/userOrder');
	}
}