<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_706885_oj0ko6hl9i.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
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
@include('common.head')
<div class="retrieve">
    <div class="retrieve-content">
        <div class="retrieve-title">
            找回密码
        </div>
        <div class="retrieve-text">
            <div class="Register">
                <input class="phone" placeholder="请输入手机号码">
                <span class="zh-prompt"></span>
                <div class="Register-zym">
                    <input type="string" placeholder="请短信验证码" value="">
                    <span class="getveri2">(60)秒后重新获取</span>
                    <span class="getveri">获取验证码</span>
                </div>
                <span class="zh-prompt2"></span>
                <input type="password" placeholder="请设置密码6-12位数字或字母" value="">
                <span class="zh-prompt2"></span>
                <input type="password" placeholder="请确认密码" value="">
                <a href="javascript:;" class="btnlogin">重置</a>
                <a href="javascript:history.go(-1);void(0);" class="btnlogin">取消</a>
            </div>
        </div>
    </div>
</div>
@include('common/footer')
<!--移动-->
<div class="m-Bottom">
    <nav class="m-Nav">
        <a href="" class="active">
            <i class="iconfont icon-shouye"></i>
            <span>首页</span>
        </a>
        <a href="">
            <i class="iconfont icon-zhengshu-copy"></i>
            <span>教师资格证</span>
        </a>
        <a href="">
            <i class="iconfont icon-zhaopin"></i>
            <span>教师招聘</span>
        </a>
        <a href="">
            <i class="iconfont icon-wode"></i>
            <span>我的</span>
        </a>
    </nav>
</div>
<script src="js/index.js"></script>
</body>
</html>