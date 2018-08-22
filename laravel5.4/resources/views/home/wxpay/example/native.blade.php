<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../resources/views/home/wxpay/lib/WxPay.Api.php";
require_once "../resources/views/home/wxpay/example/WxPay.NativePay.php";
require_once '../resources/views/home/wxpay/example/log.php';

//模式一
/*
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
$url1 = $notify->GetPrePayUrl("123456789");
$WIDsubject = "{{$data['WIDsubject']}}";
$WIDsubject = substr($WIDsubject,1,-1); //名称
$WIDtotal_fee = "{{$data['WIDtotal_fee']}}";
$WIDtotal_fee = substr($WIDtotal_fee,1,-1);
$WIDtotal_fee = ($WIDtotal_fee*100); //金钱
//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody("$WIDsubject");//课程名称
$input->SetAttach("$WIDsubject");//课程名称
$num=WxPayConfig::MCHID.date("YmdHis");
$input->SetOut_trade_no($num);
$input->SetTotal_fee("$WIDtotal_fee");//价格
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("{{URL::asset('home/wxnotify.html')}}");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信支付样例</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>

    <div class="header">
    <div class="header-content">
        <a class="header-logo">
            <img src="{{URL::asset('/')}}home/img/wxzf_03.png" alt="">
<span>支付中心</span>
        </a>
        <div class="header-login1">
            <a href=""><img src="{{URL::asset('/')}}home/img/touxiang.png" alt=""></a>
            <a href="#">老天a爷</a>
        </div>
    </div>
    </div>
    <div class="wxpay">
       <p  class="wxpay-p">
                <span>《{{$data['WIDsubject']}}》 订单号：{{$data['WIDout_trade_no']}}</span>
                <span  class="wxpay-Price">￥{{$data['WIDtotal_fee']}}</span>
        </p>
        <div class="wxpay-content clearfix">
            <div class="wxpay-left">

                <span class="wxpay-title">微信支付</span><br>
                <span style="color: red">温馨提示：支付过程中请勿关闭此页面</span>
                <div class="wxpay-ewm">
                   
                    <img alt="扫码支付" src="wxpircture?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
                   
                </div>
                <div class="wxpay-sys">
                    
                    <span>
                       

    <div id="myDiv"></div><div id="timer" hidden="">0</div>
                    </span>
                </div>
            </div>
            <div class="wxpay-right">
                <img src="img/sj.png" alt="">
            </div>
        </div>

    </div>
@include('common.footer')


    <!-- <div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
    <img alt="模式二扫码支付" src="wxpircture?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
    <div id="myDiv"></div><div id="timer">0</div> -->
    <script>  
    //设置每隔1000毫秒执行一次load() 方法  
    var myIntval=setInterval(function(){load()},1000);  
    function load(){  
       document.getElementById("timer").innerHTML=parseInt(document.getElementById("timer").innerHTML)+1; 
        var xmlhttp;    
        if (window.XMLHttpRequest){    
            // code for IE7+, Firefox, Chrome, Opera, Safari    
            xmlhttp=new XMLHttpRequest();    
        }else{    
            // code for IE6, IE5    
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");    
        }    
        xmlhttp.onreadystatechange=function(){    
            if (xmlhttp.readyState==4 && xmlhttp.status==200){    
                trade_state=xmlhttp.responseText;  
                if(trade_state=='SUCCESS'){  
                    document.getElementById("myDiv").innerHTML='支付成功';  
                    //alert(transaction_id);  
                    //延迟3000毫秒执行tz() 方法
                    clearInterval(myIntval);  
                    setTimeout("location.href='wxSuccess.html'",100);  

                }else if(trade_state=='REFUND'){  
                    document.getElementById("myDiv").innerHTML='转入退款'; 
                    clearInterval(myIntval); 
                }else if(trade_state=='NOTPAY'){  
                    document.getElementById("myDiv").innerHTML='请扫码支付';  
                      
                }else if(trade_state=='CLOSED'){  
                    document.getElementById("myDiv").innerHTML='已关闭';  
                    clearInterval(myIntval);
                }else if(trade_state=='REVOKED'){  
                    document.getElementById("myDiv").innerHTML='已撤销';  
                    clearInterval(myIntval);
                }else if(trade_state=='USERPAYING'){  
                    document.getElementById("myDiv").innerHTML='用户支付中';  
                }else if(trade_state=='PAYERROR'){  
                    document.getElementById("myDiv").innerHTML='支付失败'; 
                    clearInterval(myIntval); 
                }  
                 
            }    
        }    
        //orderquery.php 文件返回订单状态，通过订单状态确定支付状态  
        xmlhttp.open("GET","{{URL::asset('home/orderquery')}}?out_trade_no=<?php echo $num;?>",false);    
        //下面这句话必须有    
        //把标签/值对添加到要发送的头文件。    
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");    
        xmlhttp.send("out_trade_no=<?php echo $num;?>");  
         
        }  
    </script>
    
</body>
</html>