<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Curriculum;
use App\Home\Models\Pplive;

class CommodityController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-20
     * 前台支付首页张晓龙
     */
	public function CommodityGoods()
	{
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->coursedetails($curriculum_id);
		$teacher = $curriculum->oneTeacher($data[0]->curriculum_id);
		$pplive = new Pplive;
		$pplive = $pplive->shows($curriculum_id);
		return view('home/commodity/commoditygoods',['data' => $data,'pplive'=>$pplive,'teacher'=>$teacher]);
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台支付提交张晓龙
     */
	public function CommodityPay()
	{
		return view('home/commodity/commoditypay');
	}
}