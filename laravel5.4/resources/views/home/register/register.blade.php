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
    <script type="text/javascript">
     Hindex=3;
</script>
</head>
<body>
	@include('common.head')
<div class="Login">
    <div class="Login-box">
        <div class="logins">
            <div class="logins-title clearfix">
                <span>
            <a href="{{URL::asset('home/login.html')}}">登录</a></span>
                <span class="clearfix">
            <a href="{{URL::asset('home/register.html')}}" class="active">注册</a></span>
            </div>
            <div>
                 <span class="zhui" style="color:red"></span>
                <div class="Register">
                    <input placeholder="请输入手机号码" id="user_tel" value="">
                    <span class="zh-prompt"></span>
                    <div class="Register-zym">
                        <input type="string" placeholder="请短信验证码" id="code" value="">
                        <span class="getveri2">获取验证码</span>
                        <span class="getveri">获取验证码</span>
                    </div>
                    <span class="zh-prompt"></span>
                    <input type="password" placeholder="请设置密码8-16位数字或字母" id="user_pwd" value="">
                    <span class="zh-prompt"></span>
                    <input type="password" placeholder="请确认密码" id="user_pqrwd" value="">
                    <a href="javascript:;" id="btn" class="btnlogin">立即注册</a>
                    <span class="forgetmm">
                        <a href="{{URL::asset('home/login.html')}}">已有账号，马上登录</a>
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
    //提交信息
    $("#btn").click(function(){
        if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) { //手机版本
               var user_tel = $("#user_tel").val();
                var user_pwd = $("#user_pwd").val();
                var code = $("#code").val();
                var patterns = /^1[34578]\d{9}$/;
                var password = /^[a-zA-Z1-9\d_]{8,16}$/;
                var number = /^[0-9]{6,6}$/;
                var user_pqrwd = $("#user_pqrwd").val();
                if (user_tel == '' || user_pwd == '') {
                    $('.zhui').html('<span>手机号密码不能为空</span>');
                    return false;
                } else if(code == ''){
                    $('.zhui').html('<span>验证码不能为空</span>');
                    return false;
                }
                if (patterns.test(user_tel) == false) {
                    $('.zhui').html('<span>请输入正确的手机号</span>');
                    return false;
                } 
                if(number.test(code) == false) {
                    $('.zhui').html('<span>请输入正确的验证码</span>');
                    return false;
                }
                if (password.test(user_pwd) == false) {
                    $('.zhui').html('<span>请输入6-12位数字、字母密码</span>');
                    return false;
                }
                if(user_pqrwd != user_pwd) {
                    $('.zhui').html('<span>确认密码错误</span>');
                    return false;
                }
                $.ajax({
                    url:"{{URL::asset('home/doregister')}}",
                    data:{code:code,_token:"{{ csrf_token() }}"},
                    type:'get', 
                    success:function(data){
                        if(data == 1){
                        }   else {

                                 $.ajax({
                                     url:"{{URL::asset('home/addregister')}}",
                                     data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{ csrf_token() }}"},
                                     type:'get',
                                     success:function(msg){  
                                        if (msg == 2) {
                                            window.location.href = "{{URL::asset('home/login.html')}}";  
                                        } else {
                                            $('.zhui').html('<span>请确认您的手机号是否注册过</span>');
                                            return false;
                                        }
                                        
                                                      
                                     }
                                })  
                        }
                    }
                })
        } else {
                var user_tel = $("#user_tel").val();
                var user_pwd = $("#user_pwd").val();
                var code = $("#code").val();
                var patterns = /^1[34578]\d{9}$/;
                var password = /^[a-zA-Z1-9\d_]{8,16}$/;
                var number = /^[0-9]{6,6}$/;
                var user_pqrwd = $("#user_pqrwd").val();
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
                if(user_pqrwd != user_pwd) {
                    var txt=  "确认密码错误";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
                $.ajax({
                    url:"{{URL::asset('home/doregister')}}",
                    data:{code:code,_token:"{{ csrf_token() }}"},
                    type:'get', 
                    success:function(data){
                        if(data == 1){
                            var txt=  "验证码错误";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                            return false; 
                        }   else {

                                 $.ajax({
                                     url:"{{URL::asset('home/addregister')}}",
                                     data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{ csrf_token() }}"},
                                     type:'get',
                                     success:function(msg){  
                                        if (msg == 2) {
                                            window.location.href = "{{URL::asset('home/login.html')}}";  
                                        } else {
                                            var txt =  "请确认您的手机号是否注册过";
                                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                                        }
                                        
                                                      
                                     }
                                })  
                        }
                    }
                })
        }

        
    })
    // //发送验证码
    // function codeTime(){
    //     $('.getveri2').html('('+i+')秒后重新获取');
    //     console.log(i-=1);
    //     $('.getveri').css('display','none');
    //     $('.zh-prompt').html('')
    //     if(i<0){
    //         clearTimeout(time);
    //         $('.getveri').css('display','block');
    //         $('.getveri2').html('(60)秒后重新获取');
    //     }
    // }
    // $(".getveri").click(function(){
       /* var phone = $('#user_tel').val();
        function codeyz(){
             if (phone == '') {
            var txt=  "手机号不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        } else {
           var pattern = /^1[34578]\d{9}$/; 
           if(pattern.test(phone)) {
                 $.ajax({
                    url:"{{URL::asset('home/emails')}}",
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
        }*/
    //     codeyz()?time=setInterval(codeTime,1000):null;
    //     console.log(codeyz());
    // });
    //````````````````````````
    //定时器
$(".getveri").click(function(){

var phone = $('#user_tel').val();
        function codeyz(){
           if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) { //手机版本
                 if (phone == '') {
                    $('.zhui').html('<span>手机号不能为空</span>');
                    return false;
                } else {
                   var pattern = /^1[34578]\d{9}$/; 
                   if(pattern.test(phone)) {
                         $.ajax({
                            url:"{{URL::asset('home/emails')}}",
                            data:{phone:phone,_token:"{{ csrf_token() }}"},
                            type:'get',
                            success:function(data){
                                if(data == 1){
            
                                }else{
                                    $('.zhui').html('<span>发送失败请确认你是否注册</span>');
                                    return false;
                                }
                            }
                        });
                   } else {
                         $('.zhui').html('<span>请输入正确的手机号</span>');
                         return false;
                   }
                    
                }
                return true;
           } else {
                 if (phone == '') {
                    var txt=  "手机号不能为空";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                } else {
                   var pattern = /^1[34578]\d{9}$/; 
                   if(pattern.test(phone)) {
                         $.ajax({
                            url:"{{URL::asset('home/emails')}}",
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
           
        }
        if(codeyz()){
addCookie("secondsremained", 60, 60)
    settime($('.getveri2'));
    $('.getveri').css('display','none');
    $('.getveri2').html('(60)秒后重新获取');
        }//添加cookie记录,有效时间60s
})
//发送验证码时添加cookie
function addCookie(name, value, expiresHours) {
    var cookieString = name + "=" + escape(value);
    //判断是否设置过期时间,0代表关闭浏览器时失效
    if(expiresHours > 0) {
        var date = new Date();
        date.setTime(date.getTime() + expiresHours * 1000);
        cookieString = cookieString + ";expires=" + date.toUTCString();
    }
    document.cookie = cookieString;
}
//修改cookie的值
function editCookie(name, value, expiresHours) {
    var cookieString = name + "=" + escape(value);
    if(expiresHours > 0) {
        var date = new Date();
        date.setTime(date.getTime() + expiresHours * 1000); //单位是毫秒
        cookieString = cookieString + ";expires=" + date.toGMTString();
    }
    document.cookie = cookieString;
}
//根据名字获取cookie的值
function getCookieValue(name) {
    var strCookie = document.cookie;
    var arrCookie = strCookie.split("; ");
    for(var i = 0; i < arrCookie.length; i++) {
        var arr = arrCookie[i].split("=");
        if(arr[0] == name) {
            return arr[1];
            break;
        }
    }
}//开始倒计时
var countdown;
function settime(obj) {
    countdown = getCookieValue("secondsremained");
    var tim = setInterval(function() {
        countdown-=1;
        obj.html("(" + countdown + ")秒后重新获取");
    $('.getveri').css('display','none');
        if(countdown <= 0 ) {
            clearInterval(tim);
    $('.getveri').css('display','block');
    obj.html('(60)秒后重新获取');
        }
        editCookie("secondsremained", countdown, countdown + 1);
    }, 1000) //每1000毫秒执行一次
}
//获取验证码
$(function() {
    $('.getveri').on("tap", function() {
        settime($('.getveri2')); //开始倒计时
    })
    if(getCookieValue("secondsremained")){//获取cookie值
        v=getCookieValue("secondsremained");
        $('.getveri').css('display','none');
    }else {
        v=0;
        $('.getveri').css('display','block');
    }
    if(v > 0) {
        settime($('.getveri2')); //开始倒计时
    }
})
</script>
</html>