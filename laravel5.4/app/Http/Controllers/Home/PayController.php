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
		$order = new Order;
		$arr = $order->quantity($data['WIDout_trade_no'],$data['WIDtotal_fee']);
		if ($arr) {
			session(['order_number'=>$data['WIDout_trade_no']]);
			return view('home/pay/alipayapi',['data'=>$data]);
		} else {
			echo "应付价格与真实价格不符合请从新下单";die;
		}
		
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
	//移动跳转支付宝
	public function movezfbpay()
	{
		
		$data = Input::all();
		$data['user_id'] = session('user_id');
		$data['order_number'] = substr(time().$data['curriculum_id'].$data['user_id'].rand(11111111,99999999),0,18);//订单
		$order = new Order;
		//判断当前用户是否次商品订单
		$arr = $order->selects($data['user_id'],$data['curriculum_id']);
		if (empty($arr)) {  
			$order_number = $order->movezfbpay($data);//生成订单
			//通过订单号查询课程
			$datas = $order->movecurriculum($order_number);
		}else {
			//有订单
			$datas = $order->movecurriculum($arr[0]->order_number);
		}
		return view('home/zfbpay/wappay/pay',['data'=>$datas]);

	}
}