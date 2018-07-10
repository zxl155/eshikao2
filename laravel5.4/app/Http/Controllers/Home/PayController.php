<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Order;

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
		session(['order_number'=>$data['WIDout_trade_no']]);
		return view('home/pay/alipayapi',['data'=>$data]);
	}
	//异步
	public function asynchronous()
	{
		$data = Input::all();
		return view('home/pay/notify_url',['data'=>$data]);
	}
	//支付成功回调页面
	public function apiSuccess()
	{
		$data = Input::all();
		return view('home/pay/return_url',['data'=>$data]);
	}
	//自己家的成功页面
	public function Success()
	{
		$order_number = session('order_number');
		$order = new Order;
		$data = $order->noaddress($order_number); //通过订单查询的订单数据
		$data = $order->curriuclumName($data[0]->curriculum_id,$data);
		if ($data) {
			$order_id =  $order->orderPay($data[0]->order_id);
			if ($order_id) {
				return view('home/pay/paySuccess',[
					'data'=>$data,
				]);
			} else {
				echo "修改订单状态失败";
			}
			
		} else {
			echo "没有订单数据";
		}
		
	}
}