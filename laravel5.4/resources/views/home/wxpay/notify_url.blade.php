<?php 
        $appid = "wxb7c95914eaa62229";//微信给的
        $mch_id = "1508009641";//微信官方的
        $key = "371325198602104558jiayanqing088x";//自己设置的微信商家key
        $out_trade_no="{$out_trade_no}";//订单号
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
        $dataxml = http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        fopen("../resources/views/home/wxpay/testfile.txt", $objectxml);
       if ($objectxml['return_code']=='SUCCESS'&$objectxml['result_code']=='SUCCESS'&$objectxml['trade_state_desc']=="订单未支付") {
          echo $objectxml['trade_state_desc'];die;
       } else {
       		header("location:moveWxSuccess?out_trade_no=$out_trade_no");
       }

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
 ?>
