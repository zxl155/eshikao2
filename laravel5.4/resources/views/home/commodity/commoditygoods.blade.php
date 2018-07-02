<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购买课程</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
@include('common.head')

<div class="commodity">
    
    <div class="commodity-header">
        <h2>商品详情</h2>
        <div class="commodity-img">
            <img src="./img/kctitle.png" alt="">
        </div>
        <div class="commodity-brief">
            <h2></h2>
            <input type="hidden" class="curriculum_id" value="">
            <p class="Course-time">课程时间： &nbsp;&nbsp; 有效期365天
                <i><img src="./img/sm.png" alt=""></i>
                <span>自购买之日起课观看课程旗帜</span>
            </p>
            <p>授课教师: 
                        <span></span>
                        
            </p>
            <p>解读公告 高效备考</p>
            <p class="commodity-brief-number

">已购人</p>
        </div>
    </div>
    
    <div class="commodity-content clearfix">
        <h3>请选择优惠券 <span><b>+</b>添加收货地址</span></h3>
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
        
     
        <span id="html">
        <center><span style="color: red"> <h4>无收货地址</h4></span></center>
        </span>
      
       
        <div class="address-list" >
            <span address_id=""></span>
            <img src="./img/confirm.png" alt="">
            <div class="address-list-text">
                <span>收件人：</span>
                <span>手机号：</span><br>
                <span>收件地址：</span>
            </div>
            <a href="{{URL::asset('home/CommodityAddress')}}?address_id=&curriculum_id=">删除</a>
        </div>
      
        </span>
    
    
       
    </div>
    <div class="commodity-content clearfix">
         <h3>请选择优惠券 <span>（您有0张优惠券可用）</span></h3>
        <!-- <ul class="commodity-coupon">
            <li><input type="radio" name="a"><h4>无优惠券</h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥80</b></h4></li>
            <li><input type="radio" name="a"><h4>优惠券：金额抵用 <b>￥20</b></h4></li>
        </ul>  -->
        <div class="commodity-text">
            <span>共1个商品，商品总金额：￥</span><br>
            <span class="commodity-text-yhj">优惠券：<b>-￥0.00</b></span><br> 
            <span class="commodity-text-cope" money="">应付金额：<b>￥</b></span><br>
            <div class="commodity-button">
                <a href="{{URL::asset('home/coursedetails')}}?curriculum_id=">返回</a>   
                <input type="button" name="" class="active" value="提交订单">
            </div>
            <p id="yyd">
                <i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i>
                <i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a>
            </p>
        </div>
    </div>
</div>

@include('common.footer')>
<script class="resources library" src="js/area.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
<script>
    $('.but').click(function(){
        var curriculum_id = $('.curriculum_id').val();
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
                    window.location.href = "{{URL::asset('home/CommodityPay')}}";
                } else {
                    var txt=  "提交订单失败！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                }
            }
        })
        } else {
           var txt=  "请选择收货地址！";
           window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
           return false;
        }
    })
</script>
</body>
</html>