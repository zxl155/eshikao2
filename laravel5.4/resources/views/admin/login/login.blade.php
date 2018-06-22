<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>易师考登录</title>
  <meta name="description" content="这是一个 登录 页面">
  <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="{{URL::asset('/')}}assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="{{URL::asset('/')}}assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/amazeui.min.css" />
  <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/admin.css">
  <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
  <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
  <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
</head>

<body data-type="login">

  <div class="am-g myapp-login">
	<div class="myapp-login-logo-block  tpl-login-max">
		<div class="myapp-login-logo-text">
			<div class="myapp-login-logo-text">
				易师考后台<span> 登录</span> <i class="am-icon-skyatlas"></i>
				
			</div>
		</div>

		<div class="login-font">
			
		</div>
		<div class="am-u-sm-10 login-am-center">
			<form class="am-form">

       <!--  {{ csrf_field() }} -->
				<fieldset>
					<div class="am-form-group">
						<input type="text" id="admin_name" placeholder="输入用户名">
					</div>
					<div class="am-form-group">
						<input type="password" id="password" placeholder="请输入密码">
					</div>
          <div class="am-form-group"> 
            <input type="text" id="code" placeholder="请输入验证码"><img src="{{ url('admin/captcha') }}" id="captcha">
          </div>
					<p><button type="submit" id="btn" class="am-btn am-btn-default">登录</button></p>
				</fieldset>
        
			</form>
		</div>
	</div>
</div>

  <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
  <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
  <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>
 <script type="text/javascript">
  //验证码
  $("#captcha").click(function(){
    this.src="{{url('admin/captcha')}}?r="+Math.random();
  })

  $("#btn").click(function(){
    var admin_name = $("#admin_name").val();
    var password = $("#password").val();
    var code = $("#code").val();
    if(admin_name == '' || password == ''){
      var txt=  "用户名或密码不能为空";
      window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
      return false;
    }else if(code == ''){
      var txt=  "验证码不能为空";
      window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
      return false;
    } 

    $.ajax({
      url:"{{ url('admin/proving') }}",
      data:{admin_name:admin_name,password:password,code:code,_token:"{{csrf_token()}}"},
      type:'get',
      success:function(m){
        if(m == 1){
          var txt=  "用户名错误";
          window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
          return false;
        }else if(m == 2){
          var txt=  "密码错误";
          window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
          return false;
        }else if(m == 3){
          var txt=  "验证码错误";
          window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
          return false;
        }else if(m == 4){
          var txt=  "您已被冻结";
          window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
          return false;
        }else{
          var txt=  "登录成功";
          window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
          window.location.href = "{{ url('admin/index') }}";
        }
      }
    })
  })
</script>