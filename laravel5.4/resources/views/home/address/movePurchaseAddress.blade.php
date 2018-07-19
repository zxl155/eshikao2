<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<!--移动-->
@include('common.head')
<div class="m-addres">
    @foreach($content as $value)
    <div class="m-addres-list">
        <a href="" class="m-addres-content">
            <p>
                <span class="m-addres-man">收货人：{{$value->address_name}}</span>
                <span class="m-addres-phone">{{$value->address_tel}}</span>
            </p>
            <p class="m-addres-text">收货地址：{{$value->address_detailed}}</p>
        </a>
    </div>
    @endforeach
    <a href="{{URL::asset('home/movePurchaseAddressInsert')}}">添加新地址</a>
</div>
</body>
</html>