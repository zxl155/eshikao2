<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>易师考</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
</head>
<body>
	@include('common.head')
    <div class="Login">
        <div class="Login-box">
            <div class="logins"><div class="logins-title clearfix">
                <span><a class="active" aria-current="true" href="login">登录</a></span>
                <span class="clearfix">
                    <a aria-current="false" href="register">注册</a>
                </span>
            </div>

                <div>
                    <div class="Sign">
                        <i class="sjtb">
                            <img src="{{URL::asset('/')}}home/img/sjtb.png" alt=""></i>
                        <input placeholder="请输入手机号码" id="user_tel" value="">
                        <span class="zh-prompt"></span>
                        <i class="mmtb">
                        <img src="{{URL::asset('/')}}home/img/mmtb.png" alt=""></i><input type="password" placeholder="请输入密码" id="user_pwd" value="">
                        <span class="forgetmm">
                            <a href="retrieve">忘记密码?</a>
                        </span>
                        
                        <a href="javascript:;" id="btn">立即登录</a>
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
        var user_tel = $("#user_tel").val();
        var user_pwd = $("#user_pwd").val();
        if(user_tel == '' || user_pwd == ''){
            var txt=  "手机号或密码不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var phone = /^1[34578]\d{9}$/;
        var password = /^[a-zA-Z1-9\d_]{8,16}$/;
        if( phone.test(user_tel) ) {
              $.ajax({
                url:'dologin',
                data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{csrf_token()}}"},
                type:'post',
                success:function(m){
                    if(m == "登录成功"){
                        var txt=  "登录成功";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                        location.href = 'index';
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
      
    })
</script>
</html>