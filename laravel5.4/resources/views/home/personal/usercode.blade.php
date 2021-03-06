<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>修改密码</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
         @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span>个人资料</span>|<span class="xgmm">修改密码</span>
            </div>
            <div class="personal-list">
                <form class="personal-list-form">
                    <input type="hidden" class="user_id" value= "<?php echo session('user_id')?>"  >
                    <span>旧密码：</span><input type="password" class="clean" value=""><br>
                    <span>新密码：</span><input type="password" class="onepwd" value="" placeholder="请设置密码8-16位数字或字母"><br>
                    <span>确认密码：</span><input type="password" class="twopwd" value="" placeholder="确认密码"><br>
                    <div class="personal-list-form-an">
                        <a href="#" class="button">确认</a>
                        <a href="updatepwd">取消</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('common.footer')
<script type="text/javascript"></script>
<script>
    $(".button").click(function(){
        var clean = $('.clean').val();
        var onepwd = $('.onepwd').val();
        var twopwd = $('.twopwd').val();
        var user_id = $('.user_id').val();
        var password = /^[a-zA-Z1-9\d_]{8,16}$/;
        if (clean == '' || onepwd == "" || twopwd == "") {
            var txt=  "各项数据不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
        } else {
            if (password.test(onepwd) || password.test(twopwd) || password.test(clean)) {
                $.ajax({
                        url:"{{URL::asset('home/updatepwds')}}",
                        data:{clean:clean,onepwd:onepwd,twopwd:twopwd,user_id:user_id},
                        type:'get',
                        success:function(data){
                            if (data == '修改成功') {
                                var txt = "修改成功";
                                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                                setTimeout(function(){
                                    window.location.reload();//刷新当前页面.
                                },2000)
                            } else {
                                var txt = "修改失败请输入正确信息";
                                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                            }
                        }
                })
            } else {
                var txt = "请设置正确的格式";
                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            }
        }
    })
</script>
</body>
</html>