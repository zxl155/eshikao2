<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Admin;
use App\Home\Models\Order;
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
		$order = new Order;
		$order_content = $order->oneOrder();
		//print_r($order_content);die;
		return view('home/order/userOrder',[
			'order_content'=>$order_content,
		]);
	}

	//查询用户是否购买了本商品
	public function isOrder()
	{
		$order_number = Input::get('order_number');
		$order = new Order;
		$order_content = $order->isOrder($order_number);
		if($order_content){
			$data = "有数据";
		} else {
			$data = "无数据";
		}
		echo json_encode($data);
	}
	//移动订单展示
	public function moveOrder()
	{
		$order = new Order;
		$order_content = $order->oneOrder();
		return view('home/order/moveOrder',[
			'order_content'=>$order_content,
		]);
	}
}