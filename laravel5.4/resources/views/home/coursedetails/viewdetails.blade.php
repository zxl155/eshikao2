<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
<body>
@include('common/head')
@foreach($data as $value);
<div class="viewdetails">
    <div class="v-top-box">
        <div class="v-top">
            <ul class="v-top-ul clearfix">
                <li class="active">课程介绍</li>
                <li>课程表</li>
                <li>讲师介绍</li>
            </ul>
            <div class="v-top-buy">
                <span>￥{{$value->money}}</span>
                <a href="">立即购买</a>
            </div>
        </div>
    </div>
    <div class="viewdetails-header">
        <div class="details-img">
            <img src="./img/kctitle.png" alt="">
        </div>
        <div class="details-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <p class="Course-time">课程时间：{{$value->start_time}} 有效期{{$value->effective}}天
                <i><img src="./img/sm.png" alt=""></i>
                <span>自购买之日起课观看课程旗帜</span>
            </p>
            <p>授课教师：
                @foreach($teacher as $val)
                <span>{{$val->admin_name}}</span>
                @endforeach
            </p>
            <p>解读公告 高效备考</p>
            <p class="price-brief

">价格：<span>￥<b>{{$value->money}}</b></span></p>
            <div class="price-purchase">
                <a href="" class="active">立即购买</a>
                <a href="">咨询</a>
                <span>已购{{$value->bought_number}}人</span>
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
                <img src="./img/detailsdt.png" alt="">
            </div>
            <div class="v-content-left-list">
                <ul class="v-content-left-list-ul">
                    <li>
                       @foreach($pplive as $values)
                    <li><a href="">
                        <img src="./img/zbtb.png" alt="">
                        <span class="lint-title">【直播】{{$values->pplive_name}}</span>
                        <span class="list-time">{{$values->times}}</span>
                        <span class="list-name">{{$values->admin_name}}</span>
                    </a></li>
                    @endforeach
                    </li>
                </ul>
            </div>
            <div class="v-content-left-list">
                @foreach($teacher as $val)
                <div class="v-introduce">
                    <div class="v-introduce-tx">
                        <img src="./img/touxiang.png" alt="">
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
                    <li>5.如何同意回放<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>6.如何退课<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                </ul>
            </div>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
        </div>
    </div>
</div>
@include('common/footer')
@endforeach
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>