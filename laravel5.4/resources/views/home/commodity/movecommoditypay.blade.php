<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
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
            <span class="m-addresxg" style="color: blue">更改收货地址</span>
        </div>
        <div class="m-content-addres">
            <div class="m-addres-content">
                <p>
                <span class="m-addres-man">收货人：赵航</span>
                <span class="m-addres-phone">12435462562</span>
            </p>
                <p class="m-addres-text">收货地址：北京市北京</p>
            </div>
        </div>
    </div>
    <div class="m-commodity-top">
        <div class="m-commodity-img">
            <img src="./img/kcimg.png" alt="">
        </div>
        <div class="m-commodity-title">
            <p class="m-commodity-tp">18下资格幼儿园试听课</p>
            <p class="m-commodity-tm">2018.06.13至2018.06.13</p>
            <p class="m-commodity-tg">￥9.9</p>
        </div>
        <!-- <a href="" class="m-commodity-yhj">
            <span>优惠券<i>0张可用</i></span>
            <span>暂无优惠券可用</span>
        </a> -->
    </div>
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