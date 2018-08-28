<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Order;
use Gregwar\Captcha\SmsDemo;

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
		$order = new Order;
		$arr = $order->quantity($data['WIDout_trade_no'],$data['WIDtotal_fee']);
		if ($arr) {
			session(['order_number'=>$data['WIDout_trade_no']]);
			return view('home/wxpay/example/native',['data'=>$data]);
		} else {
			echo "应付价格与真实价格不符合请从新下单";die;
		}
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
				/*支付成功发送短信*/
					if ($data[0]->is_goods == 1) {
						$ins = new SmsDemo;
						$ins->sendSms("SMS_142949618",$data[0]->address_tel,'',$data[0]->curriculum_name);
					} else {
						$ins = new SmsDemo;
						$ins->sendSms("SMS_142954379",$data[0]->address_tel,'',$data[0]->curriculum_name);
					}
				/*支付成功发送短信*/
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