<!DOCTYPE html>
<html lang="en">
@include('common.head')
<body>
<script>
    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=750){
                    docEl.style.fontSize = '100px';
                }else{
                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
</script>
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
        <div class="user-tx"><img src="./img/touxiang.png" alt=""></div>
        <span>123536346</span>
    </div>
    <div class="m-user-content">
        <ul class="m-user-ul">
            <li>
                <a href="">
                    <i class="iconfont icon-course"></i>
                    我的课程
                </a>
            </li>
            <li>
                <a href="">
                    <i class="iconfont icon-youhuiquan01"></i>
                    我的优惠券
                </a>
            </li>
            <li>
                <a href="">
                    <i class="iconfont icon-dingdan"></i>
                    我的订单
                </a>
            </li>
            <li>
                <a href="">
                    <i class="iconfont icon-dizhi01"></i>
                    收货地址
                </a>
            </li>
            <li>
                <a href="">
                    <i class="iconfont icon-mima"></i>
                    修改密码
                </a>
            </li>
        </ul>
    </div>
    <a class="Sign-out" href="">退出登录</a>
</div>
<!--移动-->
@include('common.footer')
</body>
</html>