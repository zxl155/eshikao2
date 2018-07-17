<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>忘记密码</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_706885_oj0ko6hl9i.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
    <script type="text/javascript">
     Hindex=3;
</script>
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
            <span class="zhui" style="color:red"></span>
            <div class="Register">
                <input class="phone" placeholder="请输入手机号码" id="user_tel">
                <span class="zh-prompt"></span>
                <div class="Register-zym">
                    <input type="string" placeholder="请短信验证码" id="code" value="">
                    <span class="getveri2">(60)秒后重新获取</span>
                    <span class="getveri">获取验证码</span>
                </div>
                <span class="zh-prompt2"></span>
                <input type="password" placeholder="请设置密码8-16位数字或字母" id="user_pwd" value="">
                <span class="zh-prompt2"></span>
                <input type="password" placeholder="请确认密码" id="user_pqrwd" value="">
                <a href="javascript:;" class="btnlogin" id="btn">确定</a>
                <a href="javascript:history.go(-1);void(0);" class="btnlogin">取消</a>
            </div>
        </div>
    </div>
</div>
@include('common/footer')
<script src="js/index.js"></script>
<script>
    $("#btn").click(function(){
        var user_tel = $("#user_tel").val();
        var user_pwd = $("#user_pwd").val();
        var code = $("#code").val();
        var patterns = /^1[34578]\d{9}$/;
        var password = /^[a-zA-Z1-9\d_]{8,16}$/;
        var number = /^[0-9]{6,6}$/;
        var user_pqrwd = $("#user_pqrwd").val();
        if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) { //手机版本
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
                $('.zhui').html('<span>请输入8-16位数字、字母密码</span>');
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
                        $('.zhui').html('<span>验证码错误</span>');
                        return false; 
                    }   else {

                             $.ajax({
                                 url:"{{URL::asset('home/retrieves')}}",
                                 data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{ csrf_token() }}"},
                                 type:'get',
                                 success:function(msg){  
                                    if (msg == 2) {
                                        window.location.href = "{{URL::asset('home/login.html')}}";  
                                    } else {
                                         $('.zhui').html('<span>修改失败</span>');
                                         return false; 
                                    }
                                    
                                                  
                                 }
                            })  
                    }
                }
            })

        } else {
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
                 var txt=  "请输入8-16位数字、字母密码";
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
                                 url:"{{URL::asset('home/retrieves')}}",
                                 data:{user_tel:user_tel,user_pwd:user_pwd,_token:"{{ csrf_token() }}"},
                                 type:'get',
                                 success:function(msg){  
                                    if (msg == 2) {
                                        var txt =  "修改成功";
                                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                                        window.location.href = "{{URL::asset('home/login.html')}}";  
                                    } else {
                                        var txt =  "修改失败！";
                                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                                    }
                                    
                                                  
                                 }
                            })  
                    }
                }
            })
        }
        
    })








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
                                    $('.zhui').html('<span>验证码发送失败·请确认是否注册过</span>');
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
</body>
</html>