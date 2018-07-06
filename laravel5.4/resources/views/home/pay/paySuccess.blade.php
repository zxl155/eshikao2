<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="paySuccess">
    <div class="paySuccess-content">
        <div class="paySuccess-title">
            <img src="./img/success.png" alt="">
            <span>恭喜您，购买成功</span>
        </div>
        <div class="paySuccess-text">
            @foreach($data as $value)
            <p>订单号：{{$value->order_number}}</p>
            <p>支付金额：{{$value->order_money}}元</p>
            <p>课程名称：{{$value->curriculum_name}}</p>
            
            <div class="paySuccess-text-button">
                <a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}" class="active">查看课程</a>
                <a href="{{URL::asset('/')}}">返回首页</a>
            </div>
            @endforeach
            <!-- <div class="paySuccess-footer">
                    <div class="paySuccess-follow-content">
                        <p class="paySuccess-follow-title">
                            <img src="./img/love.png" alt="">
                            <span>更多学习福利</span>
                        </p>
                        <p class="paySuccess-steps">操作步骤：1.关注“易师考服务号”2.查看最新资讯与福利</p>
                    </div>
                <a href="">立即关注</a>
                </div>
            <div class="paySuccess-footer">
                <div class="paySuccess-follow-content">
                    <p class="paySuccess-follow-title">
                        <img src="./img/love.png" alt="">
                        <span>班级QQ学习群</span>
                    </p>
                    <p class="paySuccess-steps">1235425</p>
                </div>
                <a href="">复制号码</a>
            </div> -->
        </div>

    </div>
</div>
@include('common.footer')
<script>
</script>
</body>
</html>