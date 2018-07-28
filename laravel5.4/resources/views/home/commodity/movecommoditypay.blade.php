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
    <div class="m-commodity-addres">
        <div class="m-add-addres">
            <span class="m-addresm"><i class="iconfont icon-dizhi01"></i>收货地址</span>
            <a href="{{URL::asset('home/movePurchaseAddress')}}?curriculum_id={{$curriculum_content[0]->curriculum_id}}"><span class="m-addresxg" style="color: blue">更改收货地址</span></a>
        </div>
         <span class="a" style="color: red"></span>
        @foreach($goodsaddress as $value)
        <div class="m-content-addres">
            <div class="m-addres-content" address_id="{{$value->address_id}}">
                <p>
                <span class="m-addres-man">收货人：{{$value->address_name}}</span>
                <span class="m-addres-phone">{{$value->address_tel}}</span>
            </p>
                <p class="m-addres-text">收货地址：{{$value->address_detailed}}</p>
            </div>
        </div>
        @endforeach
    </div>
    @foreach($curriculum_content as $value)
    <div class="m-commodity-top">
        <div class="m-commodity-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="" width="200px" height="70px">
        </div>
        <div class="m-commodity-title" curriculum_id="{{$value->curriculum_id}}">
            <p class="m-commodity-tp">{{$value->curriculum_name}}</p>
            <p class="m-commodity-tm">{{$value->purchase_state_time}}</p>
            <p class="m-commodity-tg">￥
                @if($value->recovery_original_is == '1' )
                    <span class="money1">{{$value->original_price}}</span>
                @else 
                    <span class="money1">{{$value->present_price}}</span>
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
            <a>
                <img src="./img/zfb.png" alt="" shux='1'>
            </a>
             <a>
                <img src="./img/wxzf.png" alt=""  shux='2'>
            </a> 
        </div>
    </div>
    <div class="m-commodity-confirm">
        合计：<span>
                @if($curriculum_content[0]->recovery_original_is == '1' )
                    {{$curriculum_content[0]->original_price}}
                @else 
                    {{$curriculum_content[0]->present_price}}
                @endif
            </span>
            
        <a class="but">确认</a>
    </div>
</div>
@include('common.footer')
<script src="js/index.js"></script>
<script type="text/javascript">
    $('.but').click(function(){
        var zhi = $('.m-commodity-payan .active img').attr('shux');
        var address_id = $('.m-addres-content').attr('address_id');
        var curriculum_id = $('.m-commodity-title').attr('curriculum_id');
        if (address_id) {
            var money = $('.money1').html();
            if (zhi == 1) {
               window.location.href="movezfbpay?order_money="+money+"&address_id="+address_id+"&curriculum_id="+curriculum_id;
                //$('.a').html('支付宝');
            } else if(zhi == 2) {
                window.location.href="movewxpay?order_money="+money+"&address_id="+address_id+"&curriculum_id="+curriculum_id;
            }
        } else {
            $('.a').html('请选择收货地址');
        }
        
    })
</script>
</body>
</html>