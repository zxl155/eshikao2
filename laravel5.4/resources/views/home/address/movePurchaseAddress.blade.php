<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>Title</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<!--移动-->
@include('common.head')
<div class="m-addres">
    <span class="bian" style="color: red"></span>
    @foreach($content as $value)
    <div class="m-addres-list"  address_id="{{$value->address_id}}" curriculum_id="{{$curriculum_id}}">
        <div class="m-addres-content">
            <p>
                <span class="m-addres-man">收货人：{{$value->address_name}}</span>
                <span class="m-addres-phone">{{$value->address_tel}}</span>
            </p>
            <p class="m-addres-text">收货地址：{{$value->address_detailed}}</p>
        </div>
    </div>
    @endforeach
    <a href="{{URL::asset('home/movePurchaseAddressInsert')}}">添加新地址</a>
</div>
</body>
<script type="text/javascript">
        $('.m-addres-list').click(function(){
            var bian = $('.bian');
            var address_id = $(this).attr('address_id');
            var curriculum_id = $(this).attr('curriculum_id');
             $.ajax({
                url:"{{URL::asset('home/movedefault')}}",
                data:{address_id:address_id,_token:"{{ csrf_token() }}"},
                type:'get',
                dataType:'json',
                success:function(data){
                    if (data == "失败") {
                        bian.html('修改默认失败');
                    } else {
                        window.location.replace("moveCoursedetails?curriculum_id="+curriculum_id);
                    }
                }
            });
            
        })
    </script>
</html>