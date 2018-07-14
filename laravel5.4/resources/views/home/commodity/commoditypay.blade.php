<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>课程支付</title>
</head>
<body>
@include('common.head')
<div class="commodity">
    @foreach($data as $value)
    <div class="commodity-header">
        @foreach($address as $val)
        <h2>订单号：{{$val->order_number}} </h2>
        <div class="address-list">
            <div class="address-list-text">
                <span>收件人：{{$val->address_name}}</span>
                <span>手机号：{{$val->address_tel}}</span><br>
                <span>收件地址：{{$val->address_detailed}}</span>
            </div>
        </div>
        @endforeach
       
        <div class="commodity-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
        </div>
        
         <div class="commodity-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <input type="hidden" class="curriculum_id" value="">
            <p class="Course-time">课程时间：{{$value->purchase_state_time}}
                <i><img src="./img/sm.png" alt=""></i>
                 <q style="display: none;">自购买之日起课观看课程旗帜</q>
            </p>
            <p>授课教师:
                        <span>{{$value->admin_name}}</span>
                        
            </p>
            <p>解读公告: {{$value->publish}}</p>
            <p class="commodity-brief-number

">已购{{$value->bought_number}}人 / 限购 {{$value->purchase_number}}人</p>
        </div>
     
    </div>
    @endforeach
    <div class="commodity-content clearfix">
        <h3>请选择支付方式</h3>
        <div class="cfmode">
            <span class="active"><img src="{{URL::asset('/')}}home/img/zfb.png" v='1' alt=""><img class="confirm" src="{{URL::asset('/')}}home/img/confirm.png" alt=""></span>
            <span ><img src="{{URL::asset('/')}}home/img/wxzf.png" v='2' alt=""><img class="confirm" src="{{URL::asset('/')}}home/img/confirm.png" alt=""></span> 
        </div>

        <div class="commodity-text">
            
            <span class="commodity-text-cope">应付金额：<b>￥{{$address[0]->order_money}}</b></span><br>
           
            <div class="commodity-button">

        <form target="_self" action="{{URL::asset('home/alipayapi')}}" class="alipayform addform" method="post" target="_blank" id="form1">
                {{csrf_field()}}
                
                <!-- <div class="etitle">商户订单号:</div> -->
                <div class="einput"><input type="hidden" class="order_number" name="WIDout_trade_no" id="out_trade_no" value="{{$address[0]->order_number}}" readonly="readonly"></div>
                <!-- <br>
                <div class="mark">注意：商户订单号(out_trade_no).必填(建议是英文字母和数字,不能含有特殊字符)</div> -->
               
                <!-- <div class="etitle">商品名称:</div> -->
                <div class="einput"><input type="hidden" name="WIDsubject" value="{{$data[0]->curriculum_name}}"></div>
                <!-- <br>
                <div class="mark">注意：产品名称(subject)，必填(建议中文，英文，数字，不能含有特殊字符)</div> -->
              
                <!-- <div class="etitle">付款金额:</div> -->
                <div class="einput"><input type="hidden" name="WIDtotal_fee" value="{{$address[0]->order_money}}"></div>
                <!-- <br>
                <div class="mark">注意：付款金额(total_fee)，必填(格式如：1.00,请精确到分)</div> -->
                
               <!--  <div class="etitle">商品描述:</div> -->
                <div class="einput"><input type="hidden" name="WIDbody" value="高效备考"></div>
               <!--  <br>
                <div class="mark">注意：商品描述(body)，选填(建议中文，英文，数字，不能含有特殊字符)</div> -->   
                <input type="submit" class="active" value ="确认支付">
        </form>
        <form target="_self" action="{{URL::asset('home/wxpay.html')}}"  class="alipayform" method="post" target="_blank" id='form2'>
                {{csrf_field()}}
                
                <!-- <div class="etitle">商户订单号:</div> -->
                <div class="einput"><input type="hidden" class="order_number" name="WIDout_trade_no" id="out_trade_no" value="{{$address[0]->order_number}}" readonly="readonly"></div>
                <!-- <br>
                <div class="mark">注意：商户订单号(out_trade_no).必填(建议是英文字母和数字,不能含有特殊字符)</div> -->
               
                <!-- <div class="etitle">商品名称:</div> -->
                <div class="einput"><input type="hidden" name="WIDsubject" value="{{$data[0]->curriculum_name}}"></div>
                <!-- <br>
                <div class="mark">注意：产品名称(subject)，必填(建议中文，英文，数字，不能含有特殊字符)</div> -->
              
                <!-- <div class="etitle">付款金额:</div> -->
                <div class="einput"><input type="hidden" name="WIDtotal_fee" value="{{$address[0]->order_money}}"></div>
                <!-- <br>
                <div class="mark">注意：付款金额(total_fee)，必填(格式如：1.00,请精确到分)</div> -->
                 <input type="submit" class="active" value ="确认支付"> 
        </form>  
       
            </div>
            <p id="yyd"><i class="yyd-i1"><img src="./img/xdg01.png" alt=""></i><i class="yyd-i2"><img src="./img/xdg02.png" alt=""></i> 我已查看并同意<a href="#">《易师考用户使用服务协议》</a></p>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("form .active").click(function(){
        var order_number = $('form #out_trade_no').val();
        var is = $('.cfmode .active img ').attr('v');
        $.ajax({
            url:"{{URL::asset('home/isOrder')}}",
            data:{
                order_number:order_number,
                _token:"{{ csrf_token() }}"
            },
            async:false,
            type:'get', 
            dataType:'json',
            success:function(data){
                if (data == "无数据") {
                    if(is == 1){
                      $('#form1').submit();  
                    } else {
                        $('#form2').submit();
                    }     
                    //$("form .active").submit();
                } else {
                   var txt=  "亲~你已经购买过本课程，请到我的课程中进行查看";
                   window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                }
            }
        })
        return false;
    })
    /*$(" #ac2").click(function(){
        var order_number = $('.order_number').val();
        var ok = true;
        var is = $('.cfmode .active img ').attr('v');
        $.ajax({
            url:"{{URL::asset('home/orderNumber')}}",
            data:{order_number:order_number,_token:"{{ csrf_token() }}"},
            type:'get',
            dataType:'json',
            success:function(data){
             if (data=="超标") {
                var txt=  "课程已卖完,敬请期待下期课程ing";
                window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                 ok = false;
              }else{
                    if (is == 1) {
                        $('#form1').submit();
                    } else {
                         $('#form2').submit();
                    }
              }
              
            }
         })  
    })*/
</script>
<!-- <script>
    var even = document.g;etElementById("licode");   
    var showqrs = document.getElementById("showqrs");
     even.onmouseover = function(){
        showqrs.style.display = "block"; 
     }
     even.onmouseleave = function(){
        showqrs.style.display = "none";
     }
     
     var out_trade_no = document.getElementById("out_trade_no");

     //设定时间格式化函数
     Date.prototype.format = function (format) {
           var args = {
               "M+": this.getMonth() + 1,
               "d+": this.getDate(),
               "h+": this.getHours(),
               "m+": this.getMinutes(),
               "s+": this.getSeconds(),
           };
           if (/(y+)/.test(format))
               format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
           for (var i in args) {
               var n = args[i];
               if (new RegExp("(" + i + ")").test(format))
                   format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? n : ("00" + n).substr(("" + n).length));
           }
           return format;
       };
       
     out_trade_no.value = 'test'+ new Date().format("yyyyMMddhhmmss");
</script>
 -->
@include('common.footer')
<script src="js/jquery-1.8.3.js"></script>
</body>
</html>