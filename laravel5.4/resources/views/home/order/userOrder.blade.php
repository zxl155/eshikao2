<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的订单</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
    <script type="text/javascript">
    var Uindex=3;
</script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
        @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span class="personal-content-grzl active">正常订单</span>
                <span class="personal-content-grzl">退费订单</span>
            </div>
            <div class="personal-list">
                <table class="add">
                    <col width="300px">
                    <col width="260px">
                    <col width="120px">
                    <col width="250px">
                    <tr>
                        <th>购买内容</th>
                        <th>支付交易号</th>
                        <th>订单金额</th>
                        <th>订单详情</th>
                    </tr>
                    @foreach($order_content as $value)
                    <tr>
                        <td>
                            <h3 title="{{$value->curriculum_name}}">{{$value->curriculum_name}}</h3>
                            <div class="td-date">交易时间：{{$value->order_time}}</div>
                        </td>
                        <td>{{$value->order_number}}</td>
                        <td>￥{{$value->order_money}}</td>
                        <td>
                            @if($value->order_state == 1)
                            @if($value->is_goods == 2)
                            <div class="td-details"><a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}">查看课程</a>
                               @if($value->qq_group_key != '') |<a href="http://shang.qq.com/wpa/qunwpa?idkey={{$value->qq_group_key}}">加QQ群</a></div>
                               @endif
                            <a href="">物流信息</a>
                            @else
                            <div class="td-details"><a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}">查看课程</a>
                                 @if($value->qq_group_key != '')|<a href="http://shang.qq.com/wpa/qunwpa?idkey={{$value->qq_group_key}}">加QQ群</a></div>
                                  @endif
                            @endif
                            @else
                             <div class="td-details"><a href="{{URL::asset('home/CommodityPay.html')}}?order_number={{$value->order_number}}">去支付</a></div>
                            
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                <!-- <table>
                    <col width="300px">
                    <col width="260px">
                    <col width="120px">
                    <col width="250px">
                    <tr>
                        <th>购买内容</th>
                        <th>支付交易号</th>
                        <th>订单金额</th>
                        <th>订单详情</th>
                    </tr>
                    <tr>
                        <td>
                            <h3 title="2018上教师资格证一站拿证（单科）">2018上教师资格证一站拿证（单科）</h3>
                            <div class="td-date">交易时间：2018-06-05 16:43:32</div>
                        </td>
                        <td>654457765345423432</td>
                        <td>￥100</td>
                        <td>
                            <a href="">物流信息</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 title="2018上教师资格证一站拿证（单科）">2018上教师资格证一站拿证（单科）</h3>
                            <div class="td-date">交易时间：2018-06-05 16:43:32</div>
                        </td>
                        <td>654457765345423432</td>
                        <td>￥100</td>
                        <td>

                            <a href="">物流信息</a>
                        </td>
                    </tr>
                </table> -->
            </div>
        </div>
    </div>
</div>
@include('common.footer')

<script>
    $('.personal-content-grzl').click(function () {
        var _this=$(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.personal-list table').eq(_this).addClass('add').siblings().removeClass('add')
    })
</script>
</body>
</html>