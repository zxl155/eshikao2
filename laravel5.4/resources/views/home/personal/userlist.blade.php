<!DOCTYPE html>
<html lang="en">
    <script type="text/javascript">
     Hindex=3;
</script>
@include('common.head')
<body>
<!--移动-->
<div class="m-header">
    <div class="m-header-content">
        <div><a href="javascript:history.go(-1);"><img src="./img/88_03.png" alt=""></a></div>
        <div>易师考</div>
        <div></div>
    </div>
</div>
<div class="m-userlist">
    <div class="m-user">

        <div class="user-tx">
            <?php if (empty(session('head'))): ?>
                <img src="{{URL::asset('/')}}home/img/touxiang.png" alt="">
            <?php else: ?>
                <img src="{{URL::asset('/')}}home/img/head/<?php echo session('head') ?>" alt="">
            <?php endif ?>
        </div>
        <span> <?php if (!empty(session('user_id'))): ?>
                        <?php if (!empty(session('user_name'))): ?>
                            <?php echo session('user_name') ?>
                      <?php else: ?>
                         <?php echo session('user_tel') ?>
                        <?php endif ?>
                    <?php endif ?>
        </span>
    </div>
    <div class="m-user-content">
        <ul class="m-user-ul">
            <li>
                <a href="{{URL::asset('home/myclass.html')}}">
                    <i class="iconfont icon-course"></i>
                    我的课程
                </a>
            </li>
            <li>
                <a href="{{URL::asset('home/coupon.html')}}">
                    <i class="iconfont icon-youhuiquan01"></i>
                    我的优惠券
                </a>
            </li>
            <li>
                <a href="{{URL::asset('home/moveOrder')}}">
                    <i class="iconfont icon-dingdan"></i>
                    我的订单
                </a>
            </li>
            <li>
                <a href="{{URL::asset('home/moveAddress.html')}}">
                    <i class="iconfont icon-dizhi01"></i>
                    收货地址
                </a>
            </li>
            <li>
                <a href="{{URL::asset('home/movepassword')}}">
                    <i class="iconfont icon-mima"></i>
                    修改密码
                </a>
            </li>
        </ul>
    </div>
    <a class="Sign-out" href="{{URL::asset('home/out')}}">退出登录</a>
</div>
<!--移动-->
@include('common.footer')
</body>
</html>