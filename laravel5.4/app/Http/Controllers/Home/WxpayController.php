<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Order;

class WxpayController extends Controller
{
	/**
     * @
     * @DateTime  2018-07-09
     * 前台微信支付张晓龙
     */
	public function index()
	{
		$data = Input::all();
		session(['order_number'=>$data['WIDout_trade_no']]);
		return view('home/wxpay/example/native',['data'=>$data]);
	}
	//生成图片
	public function pirctures()
	{
		$data = Input::get('data');
		return view('home/wxpay/example/qrcode',['data'=>$data]);
	}
	//成功 查询订单是否成功
	public function notify()
	{
		return view('home/wxpay/example/notify');
	}
	//读秒
	public function orderquery()
	{
		$out_trade_no = Input::get('out_trade_no');
		return view('home/wxpay/example/orderquery',['out_trade_no'=>$out_trade_no]);
	}
	//微信成功
	public function wxSuccess()
	{

		$order_number = session('order_number');
		$order = new Order;
		$data = $order->noaddress($order_number); //通过订单查询的订单数据
		$data = $order->curriuclumName($data[0]->curriculum_id,$data);
		if ($data) {
			$order_id =  $order->orderPays($data[0]->order_id);
			if ($order_id) {
				return view('home/pay/paySuccess',[
					'data'=>$data,
				]);
			} else {
				echo "修改订单状态失败";die;
			}
			
		} else {
			echo "没有订单数据";die;
		}
		//return view('home/wxpay/example/success');
	}
}