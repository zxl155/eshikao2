<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
<!--移动-->
@include('common.head')
<div class="m-addres">
    @foreach($content as $value)
    @if($value->address_name == "")
                    
    @else
    <span class="bian" style="color: red"></span>
    <div class="m-addres-list">
        <div class="m-addres-title">
            <div class="m-addres-i">
                @if($value->is_default == 1)
                <i class="active" address_id="{{$value->address_id}}"></i>默认地址
                @else
                <i address_id="{{$value->address_id}}"></i>默认地址
                @endif
            </div>
            <div class="m-addres-an">
                <a href="{{URL::asset('home/moveAddressUpd')}}?address_id={{$value->address_id}}">编辑</a>|<a href="{{URL::asset('home/moveAddressDelete')}}?address_id={{$value->address_id}}">删除</a>
            </div>
        </div>
        <div class="m-addres-content">
            <p>
                <span class="m-addres-man">收货人：{{$value->address_name}}</span>
                <span class="m-addres-phone">{{$value->address_tel}}</span>
            </p>
            <p class="m-addres-text">收货地址：{{$value->address_detailed}}</p>
        </div>
    </div>
    @endif
    @endforeach
    <a href="{{URL::asset('home/moveAddressInsert')}}">添加新地址</a>
</div>
</body>
    <script type="text/javascript" src="{{URL::asset('/')}}home/js/index.js"></script>
    <script type="text/javascript">
        $('.m-addres-i').click(function(){
            var bian = $('.bian');
            var address_id = $('.m-addres-i .active').attr('address_id');
             $.ajax({
                url:"{{URL::asset('home/movedefault')}}",
                data:{address_id:address_id,_token:"{{ csrf_token() }}"},
                type:'get',
                dataType:'json',
                success:function(data){
                    if (data == "失败") {
                        bian.html('修改默认失败');
                    }
                }
            });
            
        })
    </script>
</html>