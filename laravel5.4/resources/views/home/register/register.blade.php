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
        <div class="logins">
            <div class="logins-title clearfix">
                <span>
            <a href="login">登录</a></span>
                <span class="clearfix">
            <a href="register" class="active">注册</a></span>
            </div>
            <div>
                <div class="Register">
                    <input placeholder="请输入手机号码" id="user_tel" value="">
                    <span class="zh-prompt"></span>
                    <input type="string" placeholder="请短信验证码" id="code" value="">
                    <span class="getveri2">获取验证码</span>
                    <span class="getveri">获取验证码</span>
                    <span class="zh-prompt"></span>
                    <input type="password" placeholder="请设置密码8-16位数字或字母" id="user_pwd" value="">
                    <a href="javascript:;" id="btn">立即注册</a>
                    <span class="forgetmm">
                        <a href="login">已有账号，马上登录</a>
                    </span>
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
        var code = $("#code").val();
        var patterns = /^1[34578]\d{9}$/;
        var password = /^[a-zA-Z1-9\d_]{8,16}$/;
        var number = /^[0-9]{6,6}$/;
        if (user_tel == '' || user_pwd == '') {
            var txt=  "手机号或密码不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        } else if(code == ''){
            var txt=  "验证码不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        if (patterns.test(user_tel) == false) {
             var txt=  "请输入正确的手机号";
             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
             return false;
        } 
        if(number.test(code) == false) {
             var txt=  "请输入正确的验证码";
             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
             return false;
        }
        if (password.test(user_pwd) == false) {
             var txt=  "请输入6-12位数字、字母密码";
             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
             return false;
        }
        $.ajax({
            url:'doregister',
            data:{code:code,_token:"{{ csrf_token() }}"},
            type:'get', 
            success:function(data){
                if(data == 1){
                    var txt=  "验证码错误";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false; 
                }   else {

                         $.ajax({
                             url:'addregister',
                             data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{ csrf_token() }}"},
                             type:'get',
                             success:function(msg){  
                                if (msg == 2) {
                                    var txt =  "注册成功";
                                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                                } else {
                                    var txt =  "请确认您的手机号是否注册过";
                                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                                }
                                
                                              
                             }
                        })  
                }
            }
        })
        
    })

    var i =59;
    var time;
    function codeTime(){
        $('.getveri2').html('('+i+')秒后重新获取');
        console.log(i-=1);
        $('.getveri').css('display','none');
        $('.zh-prompt').html('')
        if(i<0){
            clearTimeout(time);
            $('.getveri').css('display','block');
            $('.getveri2').html('(60)秒后重新获取');
        }
    }
    $(".getveri").click(function(){
        var phone = $('#user_tel').val();
        function codeyz(){
             if (phone == '') {
            var txt=  "手机号不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        } else {
           var pattern = /^1[34578]\d{9}$/; 
           if(pattern.test(phone)) {
                 $.ajax({
                    url:'emails',
                    data:{phone:phone,_token:"{{ csrf_token() }}"},
                    type:'get',
                    success:function(data){
                        if(data == 1){
                            var txt=  "发送成功";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                        }else{
                            var txt=  "发送失败请确认你是否注册";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                            return false;
                        }
                    }
                });
           } else {
                var txt=  "请输入正确的手机号";
                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                return false;
           }
            
        }
        return true;
        }
        codeyz()?time=setInterval(codeTime,1000):null;
        console.log(codeyz());
    });
</script>
</html>