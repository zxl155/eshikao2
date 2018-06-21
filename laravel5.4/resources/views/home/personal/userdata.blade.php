<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
<script type="text/javascript">
     Uindex=1;
</script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
        @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span class="personal-content-grzl">个人资料</span>
            </div>
            <div class="personal-list">
                <form class="personal-list-form" action="{{URL::asset('home/headupdate')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @foreach($data as $value)
                    <div class="personal-form-img">
                        <div class="personal-form-tx">
                            <?php if (empty(session('head'))): ?>
                                <img src="{{URL::asset('/')}}home/img/mrtx.png" alt="" width="150" height="150">
                            <?php else: ?>
                                <img src="{{URL::asset('/')}}home/img/head/{{$value->head_images}}" alt="" width="150" height="150">
                            <?php endif ?>
                            
                            
                            
                        </div>
                        <div class="personal-form-upload">
                            <span>选择图片</span>
                            <input type="file" name="head_pirctur">
                    <input type="submit" name="" class="inpsubmit" value="确认提交">
                        </div>
                    </div>
                    @endforeach
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
                    url:"{{URL::asset('home/updatemydata')}}",
                    data:{user_name:user_name,user_id:user_id,_token:"{{ csrf_token() }}"},
                    type:'get',
                    success:function(data){
                        if (data == "修改成功") {
                             var txt=  "修改成功";
                             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                             setTimeout(function(){
                                window.location.reload();//刷新当前页面.
                             },1000)
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