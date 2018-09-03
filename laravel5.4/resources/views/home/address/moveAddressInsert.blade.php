<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
<!--移动-->
@include('common.head')
<div class="m-address">
    <div class="m-address-list">
        <p>联系人</p>
        <div class="m-address-inp">
            <span>姓名：</span>
            <input type="text" placeholder="请填写收货人的姓名"  class="Addressee" >
        </div>
        <div class="m-address-inp">
            <span>电话：</span>
            <input type="text" placeholder="请填写收货人手机号码" class="phone">
        </div>
    </div>
    <div class="m-address-list">
        <p>收货地址</p>
        <div class="m-address-inp">
            <span>省：</span><select id="s_province" name="s_province"  class="s_province"></select>
        </div>
        <div class="m-address-inp">
        <span>市：</span><select id="s_city" name="s_city"  class="s_city" ></select> 
        </div>
        <div class="m-address-inp">
            <span>区/县：</span><select id="s_county" name="s_county"  class="s_county"></select>
        </div>
        <div class="m-address-inp">
            <span>详细地址：</span>
            <input type="text" placeholder="请输入详细地址" class="details">
        </div>
    </div>
    <span class="zhui" style="color:red"></span>
    <div class="m-address-an">
        <a href="#" class="but">增加地址</a>
    </div>
</div>
<script class="resources library" src="js/area.js?v1=1.0.0"></script>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
<script>
     $('.but').click(function(){
         var address = $('.Addressee').val();
         var phone = $('.phone').val();
         var s_province = $('.s_province').val();
         var s_city = $('.s_city').val();
         var s_county = $('.s_county').val();
         var details = $('.details').val();
         var nickname = /^[\u4E00-\u9FA5]{2,5}$/; //名称正则
         var tel = /^1[34578]\d{9}$/; //手机号正则
        if (nickname.test(address) == false) {
            $('.zhui').html('<span>收件人请输入2-5个汉字！</span>');
            return false;
         }
         if (tel.test(phone) == false) {
            $('.zhui').html('<span>请输入正确手机号！</span>');
            return false;
         }
         if (s_province == '省份' || s_city == '地级市' || s_county == '市、县级市') {
            $('.zhui').html('<span>请选择您收货地区！</span>');
            return false;
         }
         if (details == '') {
            $('.zhui').html('<span>请输入你的详情信息</span>');
            return false;
         }
         $.ajax({
            url:"{{URL::asset('home/addressAdd')}}",
            data:{
                address_name:address,
                address_tel:phone,
                s_province:s_province,
                s_city:s_city,
                s_county:s_county,
                details:details,
                _token:"{{ csrf_token() }}"
            },
            type:'get', 
            dataType:'json',
            success:function(data){
                if (data.data=='正确') {
                         window.location.replace("moveAddress.html");
                } else if (data.data == '错误') {
                    $('.zhui').html('<span>收货地址添加失败！</span>');
                    return false;
                }
            }
        })

     })
</script>
</body>
</html>