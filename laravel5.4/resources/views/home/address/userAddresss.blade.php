<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css"><script type="text/javascript">
     Uindex=4;
</script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
         @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span class="personal-content-grzl">修改收货地址</span>
            </div>
            @foreach($data as $value)
            <div class="personal-list">
                <div class="newaddress">
                    <form>
                        <input type="hidden" class="address_id" value="{{$value->address_id}}">
                        <span>收件人:</span> <input type="text" class="Addressee" value= "{{$value->address_name}}" />
                        <span>手机号:</span> <input type="text" class="phone"  value= "{{$value->address_tel}}"/><br>
                        <span>寄送地址:</span><select id="s_province" class="s_province"></select>  
                        <select id="s_city" class="s_city" ></select>  
                        <select id="s_county" class="s_county"></select><br>
                        <span>详情地址:</span> <input class="details" type="text" />
                    </form>
                    <div class="newaddress-button">
                        <a href="#" class="but">确认</a>
                        <a href="">取消</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('common.footer')
<script class="resources library" src="js/area.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
<script>
    $('.but').click(function(){
         var address = $('.Addressee').val();
         var address_id = $('.address_id').val();
         var phone = $('.phone').val();
         var s_province = $('.s_province').val();
         var s_city = $('.s_city').val();
         var s_county = $('.s_county').val();
         var details = $('.details').val();
         var nickname = /^[\u4E00-\u9FA5]{2,5}$/; //名称正则
         var tel = /^1[34578]\d{9}$/; //手机号正则
        if (nickname.test(address) == false) {
             var txt=  "收件人请输入2-5个汉字！";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
         }
         if (tel.test(phone) == false) {
            var txt=  "请输入正确手机号！";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
         }
         if (s_province == '省份' || s_city == '地级市' || s_county == '市、县级市') {
            var txt=  "请选择您收货地区！";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
         }
         if (details == '') {
            var txt=  "请输入你的详情信息";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
         }
         $.ajax({
            url:"{{URL::asset('home/addressUpdates')}}",
            data:{
                address_name:address,
                address_tel:phone,
                s_province:s_province,
                s_city:s_city,
                s_county:s_county,
                address_id:address_id,
                details:details,
                _token:"{{ csrf_token() }}"
            },
            type:'get', 
            dataType:'json',
            success:function(data){
                if (data.is=='正确') {
                    var txt=  "修改地址成功";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                     window.location.replace("address");
                } else {
                    var txt=  "修改地址失败";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
            }
        })

     })
</script>
</body>
</html>