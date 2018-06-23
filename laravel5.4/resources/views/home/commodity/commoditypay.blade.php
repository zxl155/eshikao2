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
            <span><img src="./img/zfb.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span>
            <span class="active"><img src="./img/wxzf.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span>
        </div>

        <div class="commodity-text">
            @foreach($address as $val)
            <span class="commodity-text-cope">应付金额：<b>￥{{$val->order_money}}</b></span><br>
            @endforeach
            <div class="commodity-button">
                <a href="" class="active">确认支付</a>
            </div>
            <p id="yyd"><i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i><i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a></p>
        </div>
    </div>
</div>
@include('common.footer')
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>