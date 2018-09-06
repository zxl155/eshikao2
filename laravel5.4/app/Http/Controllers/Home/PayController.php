<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Order;
use App\Home\Models\Paylog;
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
		$appid = "wxb7c95914eaa62229";//微信给的
        $mch_id = "1508009641";//微信官方的
        $key = "371325198602104558jiayanqing088x";//自己设置的微信商家key
        $out_trade_no=$out_trade_no;//订单号
        $nonce_str=MD5($out_trade_no);//随机字符串
       	$signA="appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&out_trade_no=$out_trade_no";
	    $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 
        $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
        $post_data = "<xml>
					   <appid>$appid</appid>
					   <mch_id>$mch_id</mch_id>
					   <nonce_str>$nonce_str</nonce_str>
					   <out_trade_no>$out_trade_no</out_trade_no>
					   <sign>$sign</sign>
					</xml>";//拼接成XML 格式
        $url = "https://api.mch.weixin.qq.com/pay/orderquery";//微信传参地址
        $dataxml = $this->http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
        file_put_contents("../resources/views/home/wxpay/testfile.txt",$dataxml,FILE_APPEND);
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        /*
		 * 微信支付日志
        */
        $this->payLog($objectxml,$dataxml);
        //file_put_contents("../resources/views/home/wxpay/testfile.txt",$dataxml,FILE_APPEND);
         if ($objectxml['return_code']=='SUCCESS'&$objectxml['result_code']=='SUCCESS'&$objectxml['trade_state']=="SUCCESS") {
         	$this->moveWxSuccess($out_trade_no);
         	
         // header("location:moveWxSuccess?out_trade_no=$out_trade_no");
        } else {
                 echo $objectxml['trade_state_desc'];die;
        }

	}
	//修改微信支付状态
	public function moveWxSuccess($order_number='')
	{
		if ($order_number == '') {
			$order_number = Input::get('out_trade_no');

		}
		$order = new Order;
		$data = $order->dunxin($order_number);
		$arr = $order->moveUpdateOrderWx($order_number);
		if ($arr) {
			echo "<xml>
				    <return_code><![CDATA[SUCCESS]]></return_code>
				    <return_msg><![CDATA[OK]]></return_msg>
				  </xml>";
			//return redirect('home/myclass.html');
		} else {
			echo "修改状态失败，请截图联系客服";
		}
	}
	//支付
	public function http_post($url, $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
    }
    //微信支付日志
    public function payLog($objectxml,$dataxml)
    {
    	$LogType = 2; 												//记录第三方值
    	$LogMark = "PayOrderLog";									//支付日志
  		$Key1 = session('user_id'); 								//用户id
  		$Key2 = $objectxml['out_trade_no'];							//商户订单号
  		if(empty($objectxml['transaction_id'])) {
  			$Key3 = "";
  		} else {
  			$Key3 = $objectxml['transaction_id'];					//第三方订单号
  		}		
  		$Key4 = "www.eshikao.com".\Request::getRequestUri();   		//支付地址
  		$ResponseBody = $dataxml;									//第三方响应消息结构
  		if ($objectxml['trade_state_desc'] == "支付成功") {
  			$Status = 1;											//订单已支付
  		} else if($objectxml['trade_state_desc'] == "订单未支付") {
  			$Status = 2;											//订单未支付
  		}
  		$Paylog = new Paylog;
  		$is_log = $Paylog->payLog($LogType,$LogMark,$Key1,$Key2,$Key3,$Key4,$ResponseBody,$Status);
    }
    //公众号回调地址
    public function wxNotify()
    {
 		$dataxml = file_get_contents("php://input");
 		$objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
		$appid = "wxb7c95914eaa62229";//微信给的
        $mch_id = "1508009641";//微信官方的
        $key = "371325198602104558jiayanqing088x";//自己设置的微信商家key
        $out_trade_no=$objectxml['out_trade_no'];//订单号
        $nonce_str=MD5($out_trade_no);//随机字符串
       	$signA="appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&out_trade_no=$out_trade_no";
	    $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 
        $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
        $post_data = "<xml>
					   <appid>$appid</appid>
					   <mch_id>$mch_id</mch_id>
					   <nonce_str>$nonce_str</nonce_str>
					   <out_trade_no>$out_trade_no</out_trade_no>
					   <sign>$sign</sign>
					</xml>";//拼接成XML 格式
        $url = "https://api.mch.weixin.qq.com/pay/orderquery";//微信传参地址
        $dataxml = $this->http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        /*
		 * 微信支付日志
        */
        $this->payLog($objectxml,$dataxml);
        //file_put_contents("../resources/views/home/wxpay/testfile.txt",$dataxml,FILE_APPEND);
         if ($objectxml['return_code']=='SUCCESS'&$objectxml['result_code']=='SUCCESS'&$objectxml['trade_state']=="SUCCESS") {
         	$order = new Order;
			$data = $order->dunxin($out_trade_no);
			$arr = $order->moveUpdateOrderWx($out_trade_no);
			if ($arr) {
				 echo "<xml>
						  <return_code><![CDATA[SUCCESS]]></return_code>
						  <return_msg><![CDATA[OK]]></return_msg>
						</xml>";
			} else {
				 echo "<xml>
						  <return_code><![CDATA[SUCCESS]]></return_code>
						  <return_msg><![CDATA[OK]]></return_msg>
						</xml>";
			}
         	
         // header("location:moveWxSuccess?out_trade_no=$out_trade_no");
        } else {
                 echo $objectxml['trade_state_desc'];die;
        }
    }
}