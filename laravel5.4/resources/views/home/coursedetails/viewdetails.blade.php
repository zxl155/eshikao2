<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>课程详情</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css"><script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=1;
</script>
</head>
<body>
@include('common/head')
@foreach($curriculum_content as $value)
<div class="viewdetails">
    <div class="v-top-box">
        <div class="v-top">
            <ul class="v-top-ul clearfix">
                <li class="active">课程介绍</li>
                <li>课程表</li>
                <li>讲师介绍</li>
            </ul>
            <div class="v-top-buy">
                <span>￥
                      @if($value->recovery_original_is == '1')
                        {{$value->original_price}}
                        @else
                        {{$value->present_price}}
                        @endif
                </span>
                <a href="{{URL::asset('home/CommodityGoods.html')}}?curriculum_id={{$value->curriculum_id}}">立即购买</a>
            </div>
        </div>
    </div>
    <div class="viewdetails-header">
        <div class="details-img">
            <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
        </div>
        <div class="details-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <p class="Course-time">课程时间：{{$value->purchase_state_time}} <!-- 有效期天 -->
                <i><img src="./img/sm.png" alt=""></i>
                <q style="display: none;">自购买之日起课观看课程起止</q>
            </p>
            <p>授课教师：
                <span>{{$value->admin_name}}</span>
            </p>
            <p>解读公告: {{$value->publish}}</p>
            <p class="price-brief

">价格：<span>￥<b>
    @if($value->recovery_original_is == '1')
    {{$value->original_price}}
    @else
    {{$value->present_price}}
    @endif
   
</b></span></p>
            <div class="price-purchase">
                <a href="{{URL::asset('home/CommodityGoods.html')}}?curriculum_id={{$value->curriculum_id}}" class="active">立即购买</a>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=3049266534&site=qq&menu=yes">咨询</a>
                <span>已购{{$value->bought_number}}人 / 限购 {{$value->purchase_number}}人</span>
            </div>
        </div>
    </div>
    <div class="viewdetails-content clearfix">

        <div class="v-content-left">
            <ul class="v-content-left-ul clearfix">
                <li class="active">课程介绍</li>
                <li>课程表</li>
                <li>讲师介绍</li>
            </ul>
            <div class="v-content-left-list off">
                <?php echo htmlspecialchars_decode($value->curriculum_content); ?>
            </div>
            <div class="v-content-left-list">
                <ul class="v-content-left-list-ul">
                    
                    @foreach($pplive_content as $val)
                    <li>
                        <!-- <img src="./img/zbtb.png" alt=""> -->
                        <span class="lint-title">{{$val->pplive_name}}</span>
                        <span class="list-time">{{$val->start_time}}--{{$val->end_time}}</span>
                        <span class="list-name">{{$val->admin_name}}</span>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
            <div class="v-content-left-list">
                @foreach($pplive_content as $val)
                <div class="v-introduce">
                    <div class="v-introduce-tx">
                        <img src="{{URL::asset('/')}}home/img/admin_head/{{$val->admin_head}}" alt="">
                    </div>
                    <div class="v-introduce-content">
                        <div class="v-introduce-title">
                            <h4>{{$val->admin_name}}</h4>
                            <span>易师考-资深讲师</span>
                        </div>
                        <p>
                            {{$val->admin_desc}}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="v-content-right ">
            <div class="v-right">
                <span class="v-right-title">
                    <img src="./img/shhelp.png" alt="">
                    上课帮助
                </span>
                <ul>
                    <li>1.如何上课
                    <div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>2.如何下载讲义<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>3.如何缓存<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>4.如何查快递<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>5.如何看回放<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>6.如何退课<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                </ul>
            </div>
            @foreach($regihtcontent as $v)
            <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$v->curriculum_id}}" class="v-right-a">
                <b>推荐</b>
                <h5>{{$v->curriculum_name}}</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>{{$v->notice}}</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="{{URL::asset('/')}}home/img/admin_head/{{$v->admin_head}}" alt=""><span>{{$v->admin_name}}</span></li>
                   
                </ul>
                <div class="Qualified-price">
                    <span>{{$v->bought_number}}人购买</span>
                    <h2>￥<span>
                        @if($v->recovery_original_is == '1')
                        {{$v->original_price}}
                        @else
                        {{$v->present_price}}
                        @endif
                    </span></h2>
                </div>
            </a>
          @endforeach
           
        </div>
    </div>
</div>
@endforeach
@include('common/footer')

<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>