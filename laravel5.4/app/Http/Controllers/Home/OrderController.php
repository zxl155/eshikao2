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
		foreach ($order_content as $key => $value) {
			$data = $this->query($value->invoice,$value->invoice_number);
			$value->data = $data;
		}
		return view('home/order/moveOrder',[
			'order_content'=>$order_content,
		]);
	}
	//物流信息
	public function logistics()
	{
		$order_id = Input::get('order_id');
		$order = new Order;
		$order = $order->logistics($order_id);
		$data = $this->query($order[0]->invoice,$order[0]->invoice_number);
		$data = $data['data'];
		return view('home/order/logistics',['order'=>$order,'data'=>$data]);
	}
	//查询物流信息
	public function query($name,$number)
	{
		//参数设置
	    $post_data = array();
	    $post_data["customer"] = 'E28BEA2501CE9D8ED8C03F08C4F4D51D';
	    $key= 'AiMthbvw2167' ;
		
		$data['com']=$name;  //查询的快递公司的编码， 一律用小写字母
		$data['num']=$number;  //查询的快递单号， 单号的最大长度是32个字符 358263398950
	    $post_data["param"] =json_encode($data);
	 
	    $url='http://poll.kuaidi100.com/poll/query.do';
	    $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
	    $post_data["sign"] = strtoupper($post_data["sign"]);
	    $o="";
	    foreach ($post_data as $k=>$v)
	    {
	        $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
	    }
	    $post_data=substr($o,0,-1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
		curl_setopt($ch, CURLOPT_TIMEOUT,3);
		$result = curl_exec($ch);	
		//$data = str_replace("\"",'"',$result );
		$data = json_decode($result,true);
		return $data;
	}
}