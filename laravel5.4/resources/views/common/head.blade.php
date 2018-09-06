
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css?v=1.0.0.1">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css">
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="{{URL::asset('/')}}js/jweixin.js" type="text/javascript"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
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
        <div><a href="javascript:history.go(-1);"><img src="{{URL::asset('/')}}home/img/88_03.png" alt=""></a></div>
        <div>易师考</div>
        <div><div class="m-consultation"><i class="iconfont icon-zixun" id="service"></i><br/><span>客服</span></div></div>
    </div>
</div>
<div class="header">
        <div class="header-content">
            <a class="header-logo">
                <img src="{{URL::asset('/')}}home/img/logo.png" alt="">
            </a>
            <ul class="header-ul">
                <li><a href="{{URL::asset('/')}}">首页</a></li>
                <li><a href="{{URL::asset('home/qualifications.html')}}">教师资格证</a></li>
                <li><a href="{{URL::asset('home/recruit.html')}}">教师招聘</a></li>
                <li><a href="{{URL::asset('home/noticelist.html')}}">招考公告</a></li>
               <!--  <li><a href="#">APP下载</a></li> -->
            </ul>
            <div class="header-login">
                <a href="{{URL::asset('home/login.html')}}" class="active">登录</a>
                <a href="{{URL::asset('home/register.html')}}">注册</a></div>
                
                <div class="header-login1">
                <a href="{{URL::asset('home/myclass.html')}}">
                    <?php if (empty(session('head'))): ?>
                        <img src="{{URL::asset('/')}}home/img/touxiang.png" alt="">
                    <?php else: ?>
                        <img src="{{URL::asset('/')}}home/img/head/<?php echo session('head') ?>" alt="">
                    <?php endif ?>
                </a>
                <a href="{{URL::asset('home/myclass.html')}}">
                    <?php if (!empty(session('user_id'))): ?>
                        <?php if (!empty(session('user_name'))): ?>
                            <?php echo session('user_name') ?>
                      <?php else: ?>
                         <?php echo session('user_tel') ?>
                        <?php endif ?>
                            <a href="{{URL::asset('home/out')}}">退出</a>
                    <?php endif ?>
                </a>
                </div>
                
            </div>
            
    </div>
  <?php $user_id = session('user_id'); if ($user_id!='') { ?>
         <script>
         $('.header-login').css('display','none');
        $('.header-login1').css('display','inline-block');
        </script>
  <?php  }?>    
        
    

    
