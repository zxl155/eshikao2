<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="./style.css">
    <script src="js/jquery-1.8.3.js"></script>
</head>
<body>
<!--移动-->
@include('common.head')
<div class="logins-list">
    @foreach($order_content as $value)
    <div class="logins-lists">
        <div class="logins-list-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
        </div>
        <div class="logins-list-content">
            <p class="logins-list-title">{{$value->curriculum_name}}</p>

            <p>状态：<span>购买成功</span></p>
            <p class="logins-list-money">￥{{$value->order_money}}</p>
        </div>
        <div class="logins-list-order">
            <p>支付时间：{{$value->order_time}}</p>
            <p>订单号：{{$value->order_number}}</p>
        </div>
        @if($value->is_goods == 1)
        <div class="logins-list-text">
            <p class="logins-text-an">
                查看物流信息
            </p>
            <p class="logins-text-box">
                暂未开通物流消息，我们将及时为您发货
            </p>
        </div>
        @endif
    </div>
@endforeach
</div>
<script src="js/index.js"></script>
</body>
</html>