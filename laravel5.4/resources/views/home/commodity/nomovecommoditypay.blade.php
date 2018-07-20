<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
<!--移动-->
@include('common.head')
<div class="m-commodity">
    @foreach($curriculum_content as $value)
    <div class="m-commodity-top">
        <div class="m-commodity-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="" width="200px" height="70px">
        </div>
        <div class="m-commodity-title">
            <p class="m-commodity-tp">{{$value->curriculum_name}}</p>
            <p class="m-commodity-tm">{{$value->purchase_state_time}}</p>
            <p class="m-commodity-tg">￥
                @if($value->recovery_original == 1 )
                    {{$value->original_price}}
                @else 
                    {{$value->present_price}}
                @endif
            </p>
        </div>
        <!-- <a href="" class="m-commodity-yhj">
            <span>优惠券<i>0张可用</i></span>
            <span>暂无优惠券可用</span>
        </a> -->
    </div>
    @endforeach
    <div class="m-commodity-pay">
        <p>支付方式</p>
        <div class="m-commodity-payan">
            <a href="">
                <img src="./img/zfb.png" alt="">
            </a>
            <a href="">
                <img src="./img/wxzf.png" alt="">
            </a>
        </div>
    </div>
    <div class="m-commodity-confirm">
        合计：<span>99.00</span>
        <a href="">确认</a>
    </div>
</div>
@include('common.footer')
<script src="js/index.js"></script>
</body>
</html>