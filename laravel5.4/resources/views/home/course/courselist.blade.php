<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_706885_3j8v67fgec7.css">
    <script src="js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="Certificate">
    <!--移动-->
   <!--  <div class="m-sort-content">
        <ul class="m-sort-ul">
            <li class="active">综合</li>
            <li>人气</li>
            <li>
                价格
                <span>
                    <i class="iconfont icon-paixujiantoushang active"></i>
                <i class="iconfont icon-paixujiantouxia"></i>
                </span>
            </li>
            <li>筛选
                <i class="iconfont icon-shaixuan active"></i></li>
        </ul>
        <div class="m-screenbox">
            <dl class="active">
                <dt>选择类型</dt>
                <dd class="btn-type">
                    <button class="active" type="button" value="1">全部</button>
                    <button type="button" value="2">笔试</button>
                    <button type="button" value="3">面试</button>
                </dd>
            </dl>
            <dl>
                <dt>选择学段</dt>
                <dd class="btn-period">
                    <button class="active" type="button" value="1">全部</button>
                    <button type="button" value="2">高中</button>
                    <button type="button" value="3">初中</button>
                    <button type="button" value="4">小学</button>
                    <button type="button" value="5">幼儿园</button>
                </dd>
            </dl>
            <dl>
                <dt>选择学科</dt>
                <dd class="btn-subject">
                    <button class="active" type="button" value="1">全部</button>
                    <button type="button" value="2">1</button>
                    <button type="button" value="3">2</button>
                    <button type="button" value="4">3</button>
                    <button type="button" value="5">4</button>
                </dd>
            </dl>
            <a href="javascript:void(0);" onclick="resetScreen()">重置</a>
            <a href="">提交</a>
        </div>
    </div> -->
    <div class="Certificate-title">
       {{$curriculum[0]->curriculum_name}}
    </div>
    <div class="Qualified-content clearfix">
         @foreach($data as $val)
        <a target="_blank" href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
            <div class="m-Qualified-title">
                <b>教师资格</b>
            <h5>{{$val->curriculum_name}}</h5>
            </div>
            <div class="Qualified-period">
                <i><img src="{{URL::asset('/')}}home/img/jifen.png"></i>
                <span>{{$val->notice}}</span>
            </div>
            <ul class="Qualified-teacher">
                 
                <li>
                    <img src="{{URL::asset('/')}}home/img/admin_head/{{$val->admin_head}}" alt="" height="50px" width="50px" alt="">
                    <span>{{$val->admin_name}}</span>
                </li>
             
            </ul>
            <div class="Qualified-price">
                <span>{{$val->bought_number}}人购买</span>
                <h2>￥<span>
                     @if($val->recovery_original_is == 1)
                          {{$val->original_price}}
                        @else
                        {{$val->present_price}}
                        @endif
                </span></h2>
            </div>
        </a>
        @endforeach
    </div>
    <div id="page" class="page_div"></div>
</div>

@include('common.footer')
<script>
    function resetScreen() {
        $('.m-screenbox dd').each(function () {
            $(this).children('button').eq(0).addClass('active').siblings().removeClass('active');
        })
    }
</script>
<script src="./js/paging.js"></script>
<script src="js/index.js"></script>
</body>
</html>