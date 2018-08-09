<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../resources/views/home/wxpay/lib/WxPay.Api.php";
require_once "../resources/views/home/wxpay/example/WxPay.JsApiPay.php";
require_once '../resources/views/home/wxpay/example/log.php';

//初始化日志
$logHandler= new CLogFileHandler("../resources/views/home/wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
$money= "{$data[0]->order_money}";//充值金额 
$money = $money * 100;
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("易师考支付");
$input->SetAttach("test");
$input->SetOut_trade_no("{$data[0]->order_number}");
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.eshikao.com/home/wxnotify.html");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>易师考微信支付</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <input type="hidden" class="">
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				 if(res.err_msg == "get_brand_wcpay_request:ok"){
                       window.location.href="http://www.eshikao.com/home/moveWxSuccess?out_trade_no={{$data[0]->order_number}}";
                   }else{
                       //返回跳转到订单详情页面
                       alert(支付失败);
                         
                   }
				//alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
</head>
<body>
	@include('common.head')
	<div class="m-pay">
	    <p>订单号：{{$data[0]->order_number}}</p>
	    <div class="m-pay-content">
	        <div class="m-pay-img">
	            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
	        </div>
	        <div class="m-pay-title">
	            <h2>{{$data[0]->curriculum_name}}</h2>
	            <span>￥{{$data[0]->order_money}}</span>
	        </div>
	    </div>
	    <button class="m-pay-btn" type="button" onclick="callpay()">确认支付<span>{{$data[0]->order_money}}</span></button>
	</div>
</body>
</html>