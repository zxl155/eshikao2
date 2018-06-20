<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Curriculum;
use App\Home\Models\Pplive;

class CouponController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台优惠券张晓龙
     */
	public function index()
	{
		return view('home/coupon/coupon');
	}
}