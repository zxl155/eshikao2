<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
@include('common.head')
<div class="commodity">
    <div class="commodity-header">
        @foreach($address as $val)
        <h2>订单号：{{$val->order_number}} </h2>
        <div class="address-list">
            <div class="address-list-text">
                <span>收件人：{{$val->address_name}}</span>
                <span>手机号：{{$val->address_tel}}</span><br>
                <span>收件地址：{{$val->address_detailed}}</span>
            </div>
        </div>
        @endforeach
        <div class="commodity-img">
            <img src="./img/kctitle.png" alt="">
        </div>
        @foreach($data as $value)
         <div class="commodity-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <input type="hidden" class="curriculum_id" value="{{$value->curriculum_id}}">
            <p class="Course-time">课程时间：{{$value->start_time}} &nbsp;&nbsp; 有效期365天
                <i><img src="./img/sm.png" alt=""></i>
                <span>自购买之日起课观看课程旗帜</span>
            </p>
            <p>授课教师: @foreach($teacher as $val)
                        <span>{{$val->admin_name}}</span>
                        @endforeach
            </p>
            <p>解读公告 高效备考</p>
            <p class="commodity-brief-number

">已购{{$value->bought_number}}人</p>
        </div>
        @endforeach
    </div>

    <div class="commodity-content clearfix">
        <h3>请选择支付方式</h3>
        <div class="cfmode">
            <span class="active"><img src="./img/zfb.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span>
           <!--  <span class="active"><img src="./img/wxzf.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span> -->
        </div>

        <div class="commodity-text">
            @foreach($address as $val)
            <span class="commodity-text-cope">应付金额：<b>￥{{$val->order_money}}</b></span><br>
            @endforeach
            <div class="commodity-button">

               
        <form action="{{URL::asset('home/alipayapi')}}" class="alipayform" method="post" target="_blank">
                {{csrf_field()}}
                @foreach($address as $val)
                <!-- <div class="etitle">商户订单号:</div> -->
                <div class="einput"><input type="hidden" name="WIDout_trade_no" id="out_trade_no" value="{{$val->order_number}}" readonly="readonly"></div>
                <!-- <br>
                <div class="mark">注意：商户订单号(out_trade_no).必填(建议是英文字母和数字,不能含有特殊字符)</div> -->
                @endforeach
                 @foreach($data as $value)
                <!-- <div class="etitle">商品名称:</div> -->
                <div class="einput"><input type="hidden" name="WIDsubject" value="{{$value->curriculum_name}}"></div>
                <!-- <br>
                <div class="mark">注意：产品名称(subject)，必填(建议中文，英文，数字，不能含有特殊字符)</div> -->
                @endforeach
                @foreach($address as $val)
                <!-- <div class="etitle">付款金额:</div> -->
                <div class="einput"><input type="hidden" name="WIDtotal_fee" value="{{$val->order_money}}"></div>
                <!-- <br>
                <div class="mark">注意：付款金额(total_fee)，必填(格式如：1.00,请精确到分)</div> -->
                @endforeach
               <!--  <div class="etitle">商品描述:</div> -->
                <div class="einput"><input type="hidden" name="WIDbody" value="高效备考"></div>
               <!--  <br>
                <div class="mark">注意：商品描述(body)，选填(建议中文，英文，数字，不能含有特殊字符)</div> -->
            
                <input type="submit" class="active" value ="确认支付">
            
        </form>
               
            </div>
            <p id="yyd"><i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i><i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a></p>
        </div>
    </div>
</div>

<!-- <script>
    var even = document.getElementById("licode");   
    var showqrs = document.getElementById("showqrs");
     even.onmouseover = function(){
        showqrs.style.display = "block"; 
     }
     even.onmouseleave = function(){
        showqrs.style.display = "none";
     }
     
     var out_trade_no = document.getElementById("out_trade_no");

     //设定时间格式化函数
     Date.prototype.format = function (format) {
           var args = {
               "M+": this.getMonth() + 1,
               "d+": this.getDate(),
               "h+": this.getHours(),
               "m+": this.getMinutes(),
               "s+": this.getSeconds(),
           };
           if (/(y+)/.test(format))
               format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
           for (var i in args) {
               var n = args[i];
               if (new RegExp("(" + i + ")").test(format))
                   format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? n : ("00" + n).substr(("" + n).length));
           }
           return format;
       };
       
     out_trade_no.value = 'test'+ new Date().format("yyyyMMddhhmmss");
</script>
 -->
@include('common.footer')
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>