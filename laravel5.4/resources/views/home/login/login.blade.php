<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>易师考</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
    <script type="text/javascript">
     Hindex=3;
</script>
</head>
<body>
	@include('common.head')
    <!--移动-->
    <div class="m-header">
        <div class="m-header-content">
            <div><a href="javascript:history.go(-1);"><img src="{{URL::asset('/')}}home/img/88_03.png" alt=""></a></div>
            <div>易师考</div>
            <div></div>
        </div>
    </div>
    <!--移动-->
    <div class="Login">
        <div class="Login-box">
            <div class="logins"><div class="logins-title clearfix">
                <span><a class="active" aria-current="true" href="{{URL::asset('home/login.html')}}">登录</a></span>
                <span class="clearfix">
                    <a aria-current="false" href="{{URL::asset('home/register.html')}}">注册</a>
                </span>
            </div>

                <div>
                    <span class="zhui" style="color:red"></span>
                    <div class="Sign">
                        <i class="sjtb">
                            <img src="{{URL::asset('/')}}home/img/sjtb.png" alt=""></i>
                        <input placeholder="请输入手机号码" id="user_tel" value="">
                        <span class="zh-prompt"></span>
                        <i class="mmtb">
                        <img src="{{URL::asset('/')}}home/img/mmtb.png" alt=""></i><input type="password" placeholder="请输入密码" id="user_pwd" value="">
                        <span class="forgetmm">
                            <a href="{{URL::asset('home/retrieve.html')}}">忘记密码?</a>
                        </span>
                        
                        <a href="javascript:;" id="btn" class="btnlogin">立即登录</a>
                        <div class="m-qt-btn">
                            <a href="{{URL::asset('home/retrieve.html')}}">忘记密码</a>|<a href="{{URL::asset('home/register.html')}}">快速注册</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.footer')
</body>
<script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $("#btn").click(function(){
    var html = "<a href='#' style='color:red'>手机号不能为空</a>";
     localStorage.setItem('id','10');
if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) { //手机版本
    var user_tel = $("#user_tel").val();
        var user_pwd = $("#user_pwd").val();
        if(user_tel == '' || user_pwd == ''){
           $('.zhui').html('<span>手机号密码不能为空</span>');
            return false;
        }
        var phone = /^1[34578]\d{9}$/;
        var password = /^[a-zA-Z1-9\d_]{6,12}$/;
        if( phone.test(user_tel) ) {
              $.ajax({
                url:"{{URL::asset('home/dologin')}}",
                data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{csrf_token()}}"},
                type:'post',
                success:function(m){
                    if(m == "登录成功"){
                       var str = document.referrer;
                       var is =str.indexOf("coursedetails.html") != -1 ;  // true
                       if (is==true) {
                             window.location.href=document.referrer;
                       } else {
                            window.location.href="userlist";
                       }
                       
                    }else{
                        $('.zhui').html('<span>登录失败</span>');
                        return false;
                    }
                }
            })
        } else {
            $('.zhui').html('<span>请输入正确的手机号</span>');
            return false;
        }
} else {
        var user_tel = $("#user_tel").val();
        var user_pwd = $("#user_pwd").val();
        if(user_tel == '' || user_pwd == ''){
            var txt=  "手机号或密码不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var phone = /^1[34578]\d{9}$/;
        var password = /^[a-zA-Z1-9\d_]{6,12}$/;
        if( phone.test(user_tel) ) {
              $.ajax({
                url:"{{URL::asset('home/dologin')}}",
                data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{csrf_token()}}"},
                type:'post',
                success:function(m){
                    if(m == "登录成功"){
                       var str = document.referrer;
                       var is =str.indexOf("coursedetails.html") != -1 ;  // true
                       if (is==true) {
                             window.location.href=document.referrer;
                       } else {
                             window.location.href="/";
                       }
                       
                      
                    }else{
                        var txt=  "登录失败";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    }
                }
            })
        } else {
            var txt=  "请输入正确的手机号";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
        }
     } 
    })
</script>
</html>