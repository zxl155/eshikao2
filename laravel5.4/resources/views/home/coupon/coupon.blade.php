<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的优惠券</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript">
     Uindex=2;
</script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
         @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span class="personal-content-grzl">优惠券</span>
            </div>
            <div class="personal-coupon clearfix">
                <center><h4>暂无</h4></center>
               <!--  <div class="personal-coupon-list">
                    <div class="personal-coupon-sum">
                        <p>￥100</p>
                        <span>小课优惠券</span>
                    </div>
                    <div class="personal-coupon-text">
                        <span>截止时间：2018-08-12</span><br>
                        <a href="">立即使用</a>
                    </div>
                </div> -->
               <!--  <div class="personal-coupon-list">
                    <div class="personal-coupon-sum">
                        <p>￥100</p>
                        <span>小课优惠券</span>
                    </div>
                    <div class="personal-coupon-text">
                        <span>截止时间：2018-08-12</span><br>
                        <a href="">立即使用</a>
                    </div>
                </div> -->
                <!-- <div class="personal-coupon-list">
                    <div class="personal-coupon-sum">
                        <p>￥100</p>
                        <span>小课优惠券</span>
                    </div>
                    <div class="personal-coupon-text">
                        <span>截止时间：2018-08-12</span><br>
                        <a href="">立即使用</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@include('common.footer')
</body>
</html>