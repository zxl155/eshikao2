<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="./style.css">
    <script src="js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="personal">
    <div class="personal-main">
        @include('common.left')
        <div class="personal-content">
            <div class="personal-content-seat">
                <span>正常订单</span><span class="xgmm">物流信息</span>
            </div>
            @foreach($order as $value)
            <div class="personal-list">
                <div class="personal-topic">
                    <p>课程名称：<span>{{$value->curriculum_name}}</span></p>
                    <p>快递单号：<span>{{$value->invoice_number}}</span></p>
                </div>
                <div class="personal-Addr">
                    <p><span>收货人：</span>
                        <span>{{$value->address_name}}</span>{{$value->address_tel}}</p>
                    <p>
                        <span>{{$value->address_detailed}}</span>
                    </p>
                </div>
                <div class="personal-topic-content">
                   @if($value->invoice_number=='')
                    暂无物流信息
                   @else
                     @foreach($data as $val)
                       {{$val['time']}}<br/>
                       {{$val['context']}}<br/><br/>
                     @endforeach
                   @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('common.footer')
</body>
</html>