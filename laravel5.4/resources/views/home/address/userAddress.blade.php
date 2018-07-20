<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>收货地址</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript">
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
                <span class="personal-content-grzl">收货地址</span>
            </div>
            
            <div class="personal-list">
                <div class="newaddress">
                    <form>
                        <span>收件人:</span> <input type="text" class="Addressee" />
                        <span>手机号:</span> <input type="text" class="phone" /><br>
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
                <table class="add">
                    <col width="200px">
                    <col width="170px">
                    <col width="390px">
                    <col width="200px">
                    <tr>
                        <th>收货人</th>
                        <th>手机号</th>
                        <th>详细地址</th>
                        <th>操作</th>
                    </tr>
                    <tbody class="html">
                    @foreach($content as $value)
                    @if($value->address_name == "")
                        
                    @else
                    <tr>
                        <td>{{$value->address_name}}</td>
                        <td>{{$value->address_tel}}</td>
                        <td>{{$value->address_detailed}}</td>
                        <td>
                            <a href="{{URL::asset('home/addressUpdate.html')}}?address_id={{$value->address_id}}">编辑</a>|<a href="{{URL::asset('home/addressDelete')}}?address_id={{$value->address_id}}">删除</a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
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
                    var txt=  "添加收货地址成功";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                    var html = ""; 
                            jQuery.each(data.content,function(key,value){
                                        html+='<tr>'
                                            html+='<td>'+value.address_name+'</td>'
                                            html+='<td>'+value.address_tel+'</td>'
                                            html+='<td>'+value.address_detailed+'</td>'
                                            html+='<td>'
                                                html+='<a href="{{URL::asset("home/addressUpdate.html")}}?address_id='+value.address_id+'">编辑</a>|<a href="{{URL::asset("home/addressDelete")}}?address_id='+value.address_id+'">删除</a>'
                                            html+='</td>'
                                        html+='</tr>'
                            }) 
                            $('.html').html(html);
                    
                } else if (data.data == '错误') {
                    var txt=  "收货地址添加失败！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
            }
        })

     })
</script>
</body>
</html>