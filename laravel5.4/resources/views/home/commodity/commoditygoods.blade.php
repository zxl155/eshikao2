<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
@include('common.head')
@foreach($data as $value)
<div class="commodity">
    
    <div class="commodity-header">
        <h2>商品详情</h2>
        <div class="commodity-img">
            <img src="./img/kctitle.png" alt="">
        </div>
        <div class="commodity-brief">
            <h2>{{$value->curriculum_name}}（单科）</h2>
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
    </div>
    
    <div class="commodity-content clearfix">
        <h3>请选择优惠券 <span><b>+</b>添加收货地址</span></h3>
        <div class="newaddress">
            <form>
                <span>收件人:</span> <input type="text" name="Addressee" />
                <span>手机号:</span> <input type="text" name="phone" /><br>
                <span>寄送地址:</span><select id="s_province" name="s_province"></select>  
                <select id="s_city" name="s_city" ></select>  
                <select id="s_county" name="s_county"></select><br>
                <span>详情地址:</span> <input class="details" type="text" />
            </form>
            <div class="newaddress-button">
                <a href="">确认</a>
                <a href="">取消</a>
            </div>
        </div>
        <div class="address-list active">
            <img src="./img/confirm.png" alt="">
            <div class="address-list-text">
                <span>收件人：赵航</span>
                <span>手机号：12345245677</span><br>
                <span>收件地址：北京市东城区上地街道嘉华大厦</span>
            </div>
            <a href="">删除</a>
        </div>
        <div class="address-list">
            <img src="./img/confirm.png" alt="">
            <div class="address-list-text">
                <span>收件人：赵航</span>
                <span>手机号：12345245677</span><br>
                <span>收件地址：北京市东城区上地街道嘉华大厦</span>
            </div>
            <a href="">删除</a>
        </div>
    </div>
    <div class="commodity-content clearfix">
        <!-- <h3>请选择优惠券 <span>（您有0张优惠券可用）</span></h3>
        <ul class="commodity-coupon">
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥100</b></h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥80</b></h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥20</b></h4></li>
        </ul> -->
        <div class="commodity-text">
            <span>共1个商品，商品总金额：￥{{$value->money}}</span><br>
            <!-- <span class="commodity-text-yhj">优惠券：<b>-￥100</b></span><br> -->
            <span class="commodity-text-cope">应付金额：<b>￥{{$value->money}}</b></span><br>
            <div class="commodity-button">
                <a href="">返回</a>
                <a href="{{URL::asset('home/CommodityPay')}}" class="active">提交订单</a>
            </div>
            <p id="yyd">
                <i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i>
                <i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a>
            </p>
        </div>
    </div>
</div>
@endforeach
@include('common.footer')>
<script class="resources library" src="js/area.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>