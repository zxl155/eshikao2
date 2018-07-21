<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Curriculum;
use App\Home\Models\Pplive;
use App\Home\Models\GoodsAddress;
use App\Home\Models\Order;

class CommodityController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-20
     * 前台支付首页张晓龙
     */
	public function CommodityGoods()
	{
		$user_id = session('user_id');
		if ($user_id == '') {
			return redirect('home/login.html');die;
		}
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$curriculum_content = $curriculum -> coursedetails($curriculum_id);
		$goodsaddress = new GoodsAddress;
		$good_content = $goodsaddress->select();
		if($curriculum_content[0]->is_goods == 2){
			//有收货地址
			return view('home/commodity/commoditygoods',[
				'curriculum_content'=>$curriculum_content,
				'good_content'=>$good_content,
			]);
		} else {
		    if($curriculum_content[0]->original_price == 0){
		    	//价格为0
		    	return view('home/commodity/nocommoditygoods',[
					'curriculum_content'=>$curriculum_content,
			    ]);
		    } else {
		    	//无收货地址
		    	return view('home/commodity/nocommoditygoods',[
				'curriculum_content'=>$curriculum_content,
			  ]);
		    }
		}
		
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台支付提交张晓龙
     */
	public function CommodityPay()
	{
		$order_number = Input::get('order_number');
		if ($order_number == '') {
			$order_number = session('order_number');
		}
		$order = new Order;
		$address = $order->address($order_number);
		if(!empty($address)){
			//有收获地址的
			$curriculum_id = $address[0]->curriculum_id;
			$curriculum = new Curriculum;
			$data = $curriculum->coursedetails($curriculum_id);
			return view('home/commodity/commoditypay',[
				'address'=>$address,
				'data'=>$data,
			]);
		} else {
			$address = $order->noaddress($order_number);
			if ($address[0]->order_money == 0) {
				//0元的课程
				$order_id = $address[0]->order_id;
				$arr = $order->orderPay($order_id);
				$data = $order->noaddress($order_number); //通过订单查询的订单数据
				$data = $order->curriuclumName($data[0]->curriculum_id,$data);
				if ($arr == true) {
					return view('home/pay/paySuccess',[
						'data'=>$data,
					]);
				} else {
					echo "支付失败";
				}
			}else {
				//不需要收货地址的课程
				$curriculum_id = $address[0]->curriculum_id;
				$curriculum = new Curriculum;
				$data = $curriculum->coursedetails($curriculum_id);
				return view('home/commodity/nocommoditypay',[
					'data'=>$data,
					'address'=>$address,
				]);
			}
			
		}
		
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台删除收货地址张晓龙
     */
	public function addressDelete()
	{
		$address_id = Input::get('address_id');
		$curriculum_id = Input::get('curriculum_id');
		$goods = new GoodsAddress;
		$arr = $goods->deletes($address_id);
		if ($arr) {
			return redirect("home/CommodityGoods.html?curriculum_id=$curriculum_id");
		} else {
			return redirect('home/CommodityGoods.html');
		}
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台订单入库
     */
	public function orderAdd()
	{
		$data = Input::all();
		$order = new Order;
		$user_id = session('user_id');
		$selects = $order ->selects($user_id,$data['curriculum_id']);
		if ($selects) {
			session(['order_number'=>$selects[0]->order_number]);
			$error['error'] = '已有订单';
		} else {
			$order_number = substr(time().$data['curriculum_id'].$user_id.rand(11111111,99999999),0,18);//订单
			$order->order_number = $order_number;
			$order->curriculum_id = $data['curriculum_id'];
			$order->order_time = date('Y-m-d H:i:s');
			$order->address_id = $data['address_id'];
			$order->order_money =  $data['money'];
			$order->user_id = $user_id;
			$arr = $order->save();
			if ($arr) {
				session(['order_number'=>$order_number]);
				$error['error'] = '成功';
			} else {
				$error['error'] = '失败';
			}
		}
   		
		return json_encode($error);
	}
	//查询商品数量
	public function orderNumber()
	{
	  $order_number = Input::get('order_number');
	  $order = new Order;
	  $data = $order->orderNumber($order_number);
	  echo json_encode($data);
	}
	//移动购买
	public function moveCoursedetails()
	{
		$user_id = session('user_id');
		if ($user_id == '') {
			return redirect('home/userlist');die;
		}
		$curriculum_id = Input::get('curriculum_id'); 
		$curriculum = new Curriculum;
		$curriculum_content = $curriculum->coursedetails($curriculum_id);
		$goodsaddress = new GoodsAddress;
		$goodsaddress = $goodsaddress->details($user_id); //查询默认收货地址
		if($curriculum_content[0]->is_goods == 2){ 
			//有收货地址
			return view('home/commodity/movecommoditypay',[
				'curriculum_content'=>$curriculum_content,
				'goodsaddress' => $goodsaddress,
			]);
		} else {
			//无收货地址
			return view('home/commodity/nomovecommoditypay',[
				'curriculum_content'=>$curriculum_content,
			]);
		}
	}
}