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
        <h2>订单号：2018020202020202</h2>
        <div class="address-list">
            <div class="address-list-text">
                <span>收件人：赵航</span>
                <span>手机号：12345245677</span><br>
                <span>收件地址：北京市东城区上地街道嘉华大厦</span>
            </div>
        </div>
        <div class="commodity-img">
            <img src="./img/kctitle.png" alt="">
        </div>
        <div class="commodity-brief">
            <h2>2018上教师资格一站拿证 （单科）</h2>
            <p class="Course-time">课程时间：2018年3月14日（100课时） 有效期365天
                <i><img src="./img/sm.png" alt=""></i>
                <span>自购买之日起课观看课程旗帜</span>
            </p>
            <p>授课教师<span>余老师</span><span>杨老师</span></p>
            <p>解读公告 高效备考</p>
            <p class="commodity-brief-number

">已购10000人/限购10001人</p>
        </div>
    </div>
    <div class="commodity-content clearfix">
        <h3>请选择支付方式</h3>
        <div class="cfmode">
            <span><img src="./img/zfb.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span>
            <span class="active"><img src="./img/wxzf.png" alt=""><img class="confirm" src="./img/confirm.png" alt=""></span>
        </div>

        <div class="commodity-text">
            <span class="commodity-text-cope">应付金额：<b>￥100</b></span><br>
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