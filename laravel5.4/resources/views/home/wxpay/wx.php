<?php 
     $money= 1;//充值金额 
        //$userip = get_ip(); //获得用户设备IP 自己网上百度去
        $userip = "124.193.91.166";
        $appid = "wxb7c95914eaa62229";//微信给的
        $mch_id = "1508009641";//微信官方的
        $key = "371325198602104558jiayanqing088x";//自己设置的微信商家key
      
        $rand = rand(00000,99999);
        $out_trade_no = '20170804'.$rand;//平台内部订单号
        $nonce_str=MD5($out_trade_no);//随机字符串
        $body = "H5充值";//内容
        $total_fee = $money; //金额
        $spbill_create_ip = $userip; //IP
        $notify_url = "http://www.eshikao.com"; //回调地址
        $trade_type = 'MWEB';//交易类型 具体看API 里面有详细介绍
        $scene_info ='{"h5_info":{"type":"Wap","wap_url":"http://www.eshikao.com","wap_name":"支付"}}';//场景信息 必要参数
        $signA ="appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";
        $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
        $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
        $post_data = "<xml>
                        <appid>$appid</appid>
                        <body>$body</body>
                        <mch_id>$mch_id</mch_id>
                        <nonce_str>$nonce_str</nonce_str>
                        <notify_url>$notify_url</notify_url>
                        <out_trade_no>$out_trade_no</out_trade_no>
                        <scene_info>$scene_info</scene_info>
                        <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                        <total_fee>$total_fee</total_fee>
                        <trade_type>$trade_type</trade_type>
                        <sign>$sign</sign>
                    </xml>";//拼接成XML 格式
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
        $dataxml = http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
           // echo "<pre>";
            //var_dump($objectxml);
           // echo '<hr>';
        function http_post($url, $data) {
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
        //不同环境下获取真实的IP
        function get_ip(){
            //判断服务器是否允许$_SERVER
            if(isset($_SERVER)){    
                if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $realip = $_SERVER['HTTP_CLIENT_IP'];
                }else{
                    $realip = $_SERVER['REMOTE_ADDR'];
                }
            }else{
                //不允许就使用getenv获取  
                if(getenv("HTTP_X_FORWARDED_FOR")){
                      $realip = getenv( "HTTP_X_FORWARDED_FOR");
                }elseif(getenv("HTTP_CLIENT_IP")) {
                      $realip = getenv("HTTP_CLIENT_IP");
                }else{
                      $realip = getenv("REMOTE_ADDR");
                }
            }

            return $realip;
        }
 ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="content-type" content="text/html;charset=utf8"/>
    <meta id="viewport" name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1; user-scalable=no;" />
    <title>【二当家的微信H5支付】MWEB支付实例</title>
    <!--
    /****************************************
    本文件是【微信支付V2.0】JSAPI支付实例
    需要用授权接口进入页面
    ****************************************/
    -->
    <style type="text/css">
    /* 重置 [[*/
    body,p,ul,li,h1,h2,form,input{margin:0;padding:0;}
    h1,h2{font-size:100%;}
    ul{list-style:none;}
    body{-webkit-user-select:none;-webkit-text-size-adjust:none;font-family:Helvetica;background:#ECECEC;}
    html,body{height:100%;}
    a,button,input,img{-webkit-touch-callout:none;outline:none;}
    a{text-decoration:none;}
    /* 重置 ]]*/
    /* 功能 [[*/
    .hide{display:none!important;}
    .cf:after{content:".";display:block;height:0;clear:both;visibility:hidden;}
    /* 功能 ]]*/
    /* 按钮 [[*/
    a[class*="btn"]{display:block;height:42px;line-height:42px;color:#FFFFFF;text-align:center;border-radius:5px;}
    .btn-blue{background:#3D87C3;border:1px solid #1C5E93;}
    .btn-green{background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0, #43C750), color-stop(1, #31AB40));border:1px solid #2E993C;box-shadow:0 1px 0 0 #69D273 inset;}
    /* 按钮 [[*/
    /* 充值页 [[*/
    .charge{font-family:Helvetica;padding-bottom:10px;-webkit-user-select:none;}
    .charge h1{height:44px;line-height:44px;color:#FFFFFF;background:#3D87C3;text-align:center;font-size:20px;-webkit-box-sizing:border-box;box-sizing:border-box;}
    .charge h2{font-size:14px;color:#777777;margin:5px 0;text-align:center;}
    .charge .content{padding:10px 12px;}
    .charge .select li{position:relative;display:block;float:left;width:100%;margin-right:2%;height:150px;line-height:150px;text-align:center;border:1px solid #BBBBBB;color:#666666;font-size:16px;margin-bottom:5px;border-radius:3px;background-color:#FFFFFF;-webkit-box-sizing:border-box;box-sizing:border-box;overflow:hidden;}
    .charge .price{border-bottom:1px dashed #C9C9C9;padding:10px 10px 15px;margin-bottom:20px;color:#666666;font-size:12px;}
    .charge .price strong{font-weight:normal;color:#EE6209;font-size:26px;font-family:Helvetica;}
    .charge .showaddr{border:1px dashed #C9C9C9;padding:10px 10px 15px;margin-bottom:20px;color:#666666;font-size:12px;text-align:center;}
    .charge .showaddr strong{font-weight:normal;color:#9900FF;font-size:26px;font-family:Helvetica;}
    .charge .copy-right{margin:5px 0; font-size:12px;color:#848484;text-align:center;}
    /* 充值页 ]]*/
    </style>
    </head>
    <body>
    	<article class="charge">
    		<h1>二当家的微信支付-H5-demo</h1>
    		<section class="content">
    				<h2>商品：测试商品。</h2>		
    		  <ul class="select cf">
    					<li><img src="weixin.jpg" style="width:150px;height:150px"></li>
    				</ul>
    				<p class="copy-right">亲，此商品不提供退款和发货服务哦</p>
    				<div class="price">微信价：<strong>￥0.01元</strong></div>
    				<div class="operation">
    					<a class="btn-green" id="getBrandWCPayRequests" href="<?php echo $objectxml['mweb_url'];?>">立即购买</a>
    				</div>
    				<p class="copy-right">微信H5支付demo 由二当家的素材网微信提供</p>
    		</section>
    	</article>
    </body>
    <script src="//wx.gtimg.com/wxpay_h5/fingerprint2.min.1.4.1.js"></script>
     <script type="text/javascript" src="../../css/zepto.min.js"></script>
        <script type="text/javascript">
                    var fp=new Fingerprint2();
                    fp.get(function(result)
    {
    $.getJSON("h5.json.php?code="+result, function(d){
        if(d.errmsg == ''){
            $('#getBrandWCPayRequest').attr("href",d.url);//+'&redirect_url=http%3a%2f%2fwxpay.    wxutil.com%2fmch%2fpay%2fh5jumppage.php
         }else{
          alert(d.errmsg);
                                    
    }
                
    });                                                            
    }
                      );
                    </script>
     
    </html>
     
    <!-- <a href="<?php echo $objectxml['mweb_url'];?>">W3School</a>-->