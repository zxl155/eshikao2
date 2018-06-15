<link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
<div class="header">
        <div class="header-content">
            <a class="header-logo">
                <img src="{{URL::asset('/')}}home/img/logo.png" alt="">
            </a>
            <ul class="header-ul">
                <li><a href="index" class="active">首页</a></li>
                <li><a href="qualifications">教师资格证</a></li>
                <li><a href="recruit">教师招聘</a></li>
                <li><a href="#">招考公告</a></li>
                <li><a href="#">APP下载</a></li>
            </ul>
            <div class="header-login">
                <a href="login" class="active">登录</a>
                <a href="register">注册</a></div>
                
                <div class="header-login1">
                <a href="myclass"><img src="{{URL::asset('/')}}home/img/touxiang.png" alt=""></a>
                <a href="myclass">
                    <?php if (!empty(session('user_id'))): ?>
                        <?php if (!empty(session('user_name'))): ?>
                            <?php echo session('user_name') ?>
                      <?php else: ?>
                         <?php echo session('user_tel') ?>
                        <?php endif ?>
                            
                    <?php endif ?>
                </a>
                </div>
                
            </div>
            
    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script>
        if({{ session('user_id')}}){
            $('.header-login').css('display','none');
            $('.header-login1').css('display','inline-block');
        }
    </script>
    