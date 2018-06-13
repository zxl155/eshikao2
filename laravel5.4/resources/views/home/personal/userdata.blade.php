<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
        <ul class="personal-nav">
            <li class="active"><a href="myclass">我的课程</a></li>
            <li><a href="mydata">个人资料</a></li>
            <li><a href="">我的优惠券</a></li>
            <li><a href="">我的订单</a></li>
            <li><a href="">收货地址</a></li>
        </ul>
        <div class="personal-content">
            <div class="personal-content-seat">
                <span class="personal-content-grzl">个人资料</span>
            </div>
            <div class="personal-list">
                <form class="personal-list-form" method="post" action="">
                    <div class="personal-form-img">
                        <div class="personal-form-tx">
                            <img src="{{URL::asset('/')}}home/img/mrtx.png" alt="">
                        </div>
                        <div class="personal-form-upload">
                            <span>点击修改</span>
                            <input type="file">
                        </div>

                    </div>
                    <br>

                    <input type="hidden" class="user_id" value="{{$data[0] -> user_id}}" >
                    <span>用户名：</span><input type="text" placeholder="请设置用户名2-5位汉字" class="username" value="{{$data[0] -> user_name}}"><br>
                    <span>账号信息：</span><span class="active"><?php echo session('user_tel') ?></span><br>
                    <span>密码设置：</span>
                    <div class="active"><a href="updatepwd">修改密码</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('common.footer')(
<script type="text/javascript"></script>
<script>
    $(".username").blur(function(){
        var user_name = $(this).val();
        var user_id = $('.user_id').val();
         var pattern = /^[\u4E00-\u9FA5]{2,5}$/;
        if(confirm("确认修改用户名?")){
           if (pattern.test(user_name)) {
     　　         $.ajax({
                    url:'updatemydata',
                    data:{user_name:user_name,user_id:user_id},
                    type:'get',
                    success:function(data){
                        if (data == "修改成功") {
                             var txt=  "修改成功";
                             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                              window.location.reload();
                        } else {
                             var txt=  "用户名不能重复修改";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                        }

                    }
                })
            } else {
                 var txt=  "请输入2-5个汉字";
                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            }
        }
    })
</script>
</body>
</html>