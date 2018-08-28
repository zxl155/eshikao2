<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Order;
use Gregwar\Captcha\SmsDemo;

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
				/*支付成功发送短信*/
					/*if ($data[0]->is_goods == 1) {
						$ins = new SmsDemo;
						$ins->sendSms("SMS_142949618",$data[0]->address_tel,'',$data[0]->curriculum_name);
					} else {
						$ins = new SmsDemo;
						$ins->sendSms("SMS_142954379",$data[0]->address_tel,'',$data[0]->curriculum_name);
					}*/
				/*支付成功发送短信*/
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
		if($datas[0]->order_money == 0){
			return redirect("home/moveUpdateOrder?order_number=".$datas[0]->order_number);
		} else {
			return view('home/zfbpay/wappay/pay',['data'=>$datas]);
		}
		

	}
	//移动支付宝异步回调
	public function moveNotify()
	{
		$data = Input::all();
		return view('home/zfbpay/notify_url',['data'=>$data]);
	}
	//移动支付宝成功回调
	public function moveSuccess()
	{
		$data = Input::all();
		return view('home/zfbpay/return_url',['data'=>$data]);
	}
	//移动支付完成修改订单
	public function moveUpdateOrder()
	{
		$order_number = Input::get('order_number');
		$order = new Order;
		$data = $order->dunxin($order_number);
		$arr = $order->moveUpdateOrder($order_number);
		if ($arr) {
			/*支付成功发送短信*/
				/*if ($data[0]->is_goods == 1) {
					$ins = new SmsDemo;
					$ins->sendSms("SMS_142949618",$data[0]->address_tel,'',$data[0]->curriculum_name);
				} else {
					$ins = new SmsDemo;
					$ins->sendSms("SMS_142954379",$data[0]->address_tel,'',$data[0]->curriculum_name);
				}*/
			/*支付成功发送短信*/
			return redirect('home/myclass.html');
		} else {
			echo "修改状态失败，请截图联系客服";
		}
	}
	//移动跳转微信
	public function movewxpay()
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
			$order_id= $datas[0]->order_id;
			$datas = $order->moveUpdate($order_id,$data['order_number']);
		}
		$datas = $order->curriculum($datas);
		if($datas[0]->order_money == 0){
			return redirect("home/moveUpdateOrder?order_number=".$datas[0]->order_number);
		} else {
			// 我们判断HTTP_USER_AGENT中是否有MicroMessenger即可
			if(strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")){//微信内部打开
				if(strpos($_SERVER['HTTP_USER_AGENT'], 'miniprogram') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'miniProgram') !== false){
		               echo "小程序支付暂未开通,请到易师考官网进行购买:www.eshikao.com";//小程序
		           }else{
		               return view('home/wxpay/example/jsapi',['data'=>$datas]);//微信公众号
		           }
			}else{
				return view('home/wxpay/wx',['data'=>$datas]);
			}

		}
	}
	//查询订单接口
	public function moveWx()
	{	
		$out_trade_no = Input::get('out_trade_no');
		return view('home/wxpay/notify_url',['out_trade_no'=>$out_trade_no]);
	}
	//修改微信支付状态
	public function moveWxSuccess()
	{
		$order_number = Input::get('out_trade_no');
		$order = new Order;
		$data = $order->dunxin($order_number);
		$arr = $order->moveUpdateOrderWx($order_number);
		if ($arr) {
			/*支付成功发送短信*/
				/*if ($data[0]->is_goods == 1) {
					$ins = new SmsDemo;
					$ins->sendSms("SMS_142949618",$data[0]->address_tel,'',$data[0]->curriculum_name);
				} else {
					$ins = new SmsDemo;
					$ins->sendSms("SMS_142954379",$data[0]->address_tel,'',$data[0]->curriculum_name);
				}*/
			/*支付成功发送短信*/
			return redirect('home/myclass.html');
		} else {
			echo "修改状态失败，请截图联系客服";
		}
	}
	//微信公众号支付
	public function publiCpayment()
	{
		// 我们判断HTTP_USER_AGENT中是否有MicroMessenger即可
		/*if(strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")){
			echo '微信浏览器';
		}else{
			echo '别的浏览器';
		}*/
		return view('home/wxpay/example/a');
	}
}