<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>购买课程</title>
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
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
            <!-- <span class="commodity-text-yhj">优惠券：<b>-￥0.00</b></span><br>  -->
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
                <i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a>
            </p>
        </div>
    </div>
</div>
@endforeach
@include('common.footer')>
<script class="resources library" src="js/area.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script>
    $('.active').click(function(){
        var curriculum_id = $('.curriculum_id').val(); //课程id
        var address_id = 0; //地址id
        var money = $('.commodity-text-cope').attr('money');  //金额
        
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
                    window.location.href = "{{URL::asset('home/CommodityPay.html')}}";
                } else if(data.error=='失败') {
                    var txt=  "提交订单失败！";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                } else {
                    window.location.href = "{{URL::asset('home/CommodityPay.html')}}";
                }
            }
        })
        
    })
</script>
</body>
</html>