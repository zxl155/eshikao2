<?php 
        $money= "1";//充值金额 
       // $money = $money * 100;
        $userip = get_ip(); //获得用户设备IP 自己网上百度去
        //$userip = "124.193.91.166";
        $appid = "wxb7c95914eaa62229";//微信给的
        $mch_id = "1508009641";//微信官方的
        $key = "371325198602104558jiayanqing088x";//自己设置的微信商家key
      
        $out_trade_no = rand(111111,999999999);//平台内部订单号
        $nonce_str=MD5($out_trade_no);//随机字符串
        $body = "易师考支付";//内容
        $total_fee = $money; //金额
        $spbill_create_ip = $userip; //IP
        $notify_url = urlencode("http://www.eshikao.com/home/publiCpayments"); //回调地址
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
        $objectxml['mweb_url'] = $objectxml['mweb_url']."&redirect_url=".$notify_url."?out_trade_no=".$out_trade_no;
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
 <script type="text/javascript">
      document.location = "<?php echo $objectxml['mweb_url'];?>";
</script>