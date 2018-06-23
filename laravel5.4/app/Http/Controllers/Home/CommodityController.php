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
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->coursedetails($curriculum_id);
		$teacher = $curriculum->oneTeacher($data[0]->curriculum_id);
		$pplive = new Pplive;
		$pplive = $pplive->shows($curriculum_id);
		$address = new GoodsAddress;
		$goodsaddress = $address ->select();
		return view('home/commodity/commoditygoods',['data' => $data,'pplive'=>$pplive,'teacher'=>$teacher,'goodsaddress'=>$goodsaddress]);
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台支付提交张晓龙
     */
	public function CommodityPay()
	{
		$order_number = session('order_number');
		$order = new Order;
		$address = $order->address($order_number);

		$curriculum_id = $address[0]->curriculum_id;
		$curriculum = new Curriculum;
		$data = $curriculum->coursedetails($curriculum_id);
		$teacher = $curriculum->oneTeacher($data[0]->curriculum_id);
		$pplive = new Pplive;
		$pplive = $pplive->shows($curriculum_id);
		$addresss = new GoodsAddress;
		$goodsaddress = $addresss ->select();
		return view('home/commodity/commoditypay',['address'=>$address,'data' => $data,'pplive'=>$pplive,'teacher'=>$teacher,'goodsaddress'=>$goodsaddress]);
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
			return redirect("home/CommodityGoods?curriculum_id=$curriculum_id");
		} else {
			return redirect('home/CommodityGoods');
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
   		$order_number = substr(time().$data['curriculum_id'].$user_id.rand(11111111,99999999),0,18);//订单
		$order->order_number = $order_number;
		$order->curriculum_id = $data['curriculum_id'];
		$order->order_time = date('Y-m-d H:i:s');
		$order->address_id = $data['address_id'];
		$order->order_money = $data['money'];
		$order->user_id = $user_id;
		$arr = $order->save();
		if ($arr) {
			session(['order_number'=>$order_number]);
			$error['error'] = '成功';
		} else {
			$error['error'] = '失败';
		}
		return json_encode($error);
	}
}