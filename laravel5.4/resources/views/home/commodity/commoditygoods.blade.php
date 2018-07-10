<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购买课程</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
@include('common.head')
@foreach($curriculum_content as $value)
<div class="commodity">
    
    <div class="commodity-header">
        <h2>商品详情</h2>
        <div class="commodity-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
        </div>
        <div class="commodity-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <input type="hidden" class="curriculum_id" value="{{$value->curriculum_id}}">
           <p class="Course-time">课程时间：{{$value->purchase_state_time}}
                <i><img src="./img/sm.png" alt=""></i>
                 <q style="display: none;">自购买之日起课观看课程旗帜</q>
            </p>
            <p>授课教师: 
                        <span>{{$value->admin_name}}</span>
                        
            </p>
            <p>解读公告: {{$value->publish}}</p>
            <p class="commodity-brief-number

"> 已购{{$value->bought_number}}人 / 限购 {{$value->purchase_number}}人</p>
        </div>
    </div>
    
    <div class="commodity-content clearfix">
         <h3> <span id="commodity-add"><b>+</b>添加新地址</span></h3>
        <div class="newaddress" style="display: none;">
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
                        <a href="#">取消</a>
                    </div>
        </div>
      <div id='html'>
    @foreach($good_content as $val)
       @if($val->address_id == '')
        <span>
        <center><span style="color: red"> <h4>无收货地址</h4></span></center>
        </span>
      @else
          <div class="address-list">
            <span address_id="{{$val->address_id}}"></span>
            <div class="address-dg">
                <img src="./img/cdh.png" alt="">
            </div>
            <div class="address-list-text">
                <span>收件人：{{$val->address_name}}</span>
                <span>手机号：{{$val->address_tel}}</span><br>
                <span>收件地址：{{$val->address_detailed}}</span>
            </div>
            <a href="{{URL::asset('home/CommodityAddress')}}?address_id={{$val->address_id}}&curriculum_id={{$value->curriculum_id}}">删除</a>
        </div>
        
    @endif
    @endforeach
      </div>
    </div>
    <div class="commodity-content clearfix">
         <!--<h3>请选择优惠券 <span>（您有0张优惠券可用）</span></h3>
         <ul class="commodity-coupon">
            <li><input type="radio" name="a"><h4>无优惠券</h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥80</b></h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥20</b></h4></li>
        </ul>  -->
        <div class="commodity-text">
            <span>共1个商品，商品总金额：￥ @if($value->recovery_original_is == '1')
    {{$value->original_price}}
    @else
    {{$value->present_price}}
    @endif</span><br>
           <!--  <span class="commodity-text-yhj">优惠券：<b>-￥0.00</b></span><br>  -->
            <span class="commodity-text-cope" money="@if($value->recovery_original_is == '1')
    {{$value->original_price}}
    @else
    {{$value->present_price}}
    @endif">应付金额：<b>￥ @if($value->recovery_original_is == '1')
    {{$value->original_price}}
    @else
    {{$value->present_price}}
    @endif</b></span><br>
            <div class="commodity-button">
                <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$value->curriculum_id}}">返回</a>   
                <input type="button" name="" class="active" value="提交订单">
            </div>
            <p id="yyd">
                <i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i>
                <i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="{{URL::asset('home/agreement.html')}}">《易师考用户使用服务协议》</a>
            </p>
        </div>
    </div>
</div>
@endforeach
@include('common.footer')>
<script class="resources library" src="js/area.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script>
    $('.but').click(function(){
        var curriculum_id = $('.curriculum_id').val(); //课程id
         var address = $('.Addressee').val();          //收件人
         var phone = $('.phone').val();                //手机号
         var s_province = $('.s_province').val();      //寄送地址
         var s_city = $('.s_city').val();
         var s_county = $('.s_county').val();
         var details = $('.details').val();            //详情地址
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
                    //var txt=  "添加收货地址成功";
                   // window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                    var html = ""; 
                            jQuery.each(data.content,function(key,value){
                                html+='<div class="address-list">'
                                       html+='<span address_id="'+value.address_id+'"></span>'
                                        html+='<img src="./img/confirm.png" alt="">'
                                       html+='<div class="address-list-text">'
                                            html+='<span>收件人：'+value.address_name+'</span>'
                                            html+='<span>手机号：'+value.address_tel+'</span><br>'
                                            html+='<span>收件地址：'+value.address_detailed+'</span>'
                                        html+='</div>'
                                        html+='<a href="{{URL::asset("home/CommodityAddress")}}?address_id='+value.address_id+'&curriculum_id='+curriculum_id+'">删除</a>'
                                  html+='</div>'
                            }) 
                            $('#html').html(html);
                            location.reload();
                } else if (data.data == '错误') {
                    var txt=  "收货地址添加失败！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
            }
        })

     })
    $('.active').click(function(){
        var curriculum_id = $('.curriculum_id').val(); //课程id
        var address_id = $('.active span').attr('address_id'); //地址id
        var money = $('.commodity-text-cope').attr('money');  //金额
        if (address_id) {
            $.ajax({
            url:"{{URL::asset('home/orderAdd')}}",
            data:{
                curriculum_id:curriculum_id,
                address_id:address_id,
                money:money,
                _token:"{{ csrf_token() }}"
            },
            type:'get', 
            dataType:'json',
            success:function(data){
                if (data.error=='成功') {
                     var txt=  "提交订单成功！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                    window.location.href = "{{URL::asset('home/CommodityPay.html')}}";
                } else if(data.error=='失败') {
                    var txt=  "提交订单失败！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                } else {
                    var txt=  "已有订单请到个人中心查看！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                }
            }
        })
        } else {
           var txt=  "请选择收货地址！";
           $('.commodity-content h3 span').addClass('dy');
           //window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
           //$('#commodity-add').css('text-decoration','blink');
// function blinklink() {
//     // $('.commodity-content h3 span').css('backgroundColor')=='#fff'?$('.commodity-content h3 span').css('backgroundColor','#fff'):$('.commodity-content h3 span').css('backgroundColor','red');
//     $('.commodity-content h3 span').css('backgroundColor','#fff')
//     timer = setTimeout("blinklink()", 100);
// }
// function stoptimer() {
//     clearTimeout(timer);
//     $('.commodity-content h3 span').css('backgroundColor')=='red'
// } 
// blinklink();
           return false;
        }
    })
</script>
</body>
</html>