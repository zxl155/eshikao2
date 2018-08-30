<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>修改密码</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_706885_oj0ko6hl9i.css">
    <script src="js/jquery-1.8.3.js"></script>
</head>
<body>
<!--移动-->
@include('common.head')
<div class="Login">
    <div class="Login-box">
        <div class="logins">
            <div class="logins-title clearfix">
                <span>
            <a href="login.html">登录</a></span>
                <span class="clearfix">
            <a href="Register.html" class="active">注册</a></span>
            </div>
            <div>
                <div class="Register">
                    <input type="hidden" class="user_id" value= "<?php echo session('user_id')?>"  >
                    <input placeholder="原始密码" class="clean">
                    <span class="zh-prompt"></span>
                    <span class="zh-prompt2"></span>
                    <input type="password" placeholder="输入新密码" class="onepwd" value="">
                    <span class="zh-prompt2"></span>
                    <input type="password" placeholder="再次输入新密码" class="twopwd" value="">
                     <span class="zhui" style="color:red"></span>
                     <span class="zhui2" style="color:blue"></span>
                    <a href="javascript:;" class="btnlogin">确认</a>
                    <span class="forgetmm">
                        <a href="">已有账号，马上登录</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--移动-->
@include('common.footer')
<script src="js/index.js"></script>
<script>
        $(".btnlogin").click(function(){
        var clean = $('.clean').val();
        var onepwd = $('.onepwd').val();
        var twopwd = $('.twopwd').val();
        var user_id = $('.user_id').val();
        var password = /^[a-zA-Z1-9\d_]{8,16}$/;
        if (clean == '' || onepwd == "" || twopwd == "") {
            $('.zhui').html('<span>各项数据不能为空</span>');
            return false;
        } else {
            if (password.test(onepwd) || password.test(twopwd) || password.test(clean)) {
                $.ajax({
                        url:"{{URL::asset('home/updatepwds')}}",
                        data:{clean:clean,onepwd:onepwd,twopwd:twopwd,user_id:user_id},
                        type:'get',
                        success:function(data){
                            if (data == '修改成功') {
                                $('.zhui').html('');
                                $('.zhui2').html('<span>修改成功</span>');
                                setTimeout(function(){
                                   window.location.href="userlist";
                                },2000)
                                
                            } else {
                                $('.zhui').html('<span>修改失败</span>');
                                return false;
                            }
                        }
                })
            } else {
                $('.zhui').html('<span>请设置正确的格式</span>');
                return false;
            }
        }
    })
</script>
</body>
</html>