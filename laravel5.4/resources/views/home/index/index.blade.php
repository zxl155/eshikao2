<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>易师考</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
</head>
@include('common.head')
<body>
<div class="Home">
    <div id="focus-banner">
        <ul id="focus-banner-list">
            <li> <a href="#" class="focus-banner-img" style="background: url('./img/banner.png')no-repeat;background-position: center;background-size: 1920px 377px">
            </a>
            </li>
            <li> <a href="#" class="focus-banner-img" style="background: url('./img/banner.png')no-repeat;background-position: center;background-size: 1920px 377px">
            </a>
            </li>
            <li><a href="#" class="focus-banner-img" style="background: url('./img/banner.png')no-repeat;background-position: center;background-size: 1920px 377px">
            </a>
            </li>
        </ul>
        <a href="javascript:;" id="next-img" class="focus-handle"></a> <a href="javascript:;" id="prev-img" class="focus-handle"></a>
        <ul id="focus-bubble">
        </ul>
    </div>
    <div class="react-swipe-container carousel" style="overflow: hidden; visibility: visible; position: relative;">
        <div style="overflow: hidden; position: relative; width: 5820px;">
            <div data-index="0"
                 style="float: left; width: 1940px; position: relative; transition-property: transform; left: 0px; transition-duration: 0ms; transform: translate(1940px, 0px) translateZ(0px);">
                <img src="" alt=""></div>
            <div data-index="1"
                 style="float: left; width: 1940px; position: relative; transition-property: transform; left: -1940px; transition-duration: 300ms; transform: translate(-1940px, 0px) translateZ(0px);">
                <img src="" alt=""></div>
            <div data-index="2"
                 style="float: left; width: 1940px; position: relative; transition-property: transform; left: -3880px; transition-duration: 300ms; transform: translate(0px, 0px) translateZ(0px);">
                <img src="" alt=""></div>
        </div>
    </div>
    <div class="Qualified"><h2 class="Qualified-title"><span>教师资格 <a aria-current="false" href="qualifications"> 更多»</a></span>
    </h2>
        <div class="Qualified-content clearfix">
            @foreach($qualifications as $value)
           
            <a href="coursedetails?curriculum_id={{$value->curriculum_id}}">
                <b>教师资格  </b>
                <h5>{{$value->curriculum_name}}(单科)</h5>
                <div class="Qualified-period" curriculum_id = "{{$value->curriculum_id}}">
                    <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                    <span>{{$value->notice}}</span>
                 </div>
                <ul class="Qualified-teacher">
                     @foreach($admin as $values)
                      @if($value->curriculum_id==$values->curriculum_id)
                    <li>
                        <img src="{{URL::asset('/')}}home/img/touxiang.png" alt="">
                        <span>
                           
                                {{$values->admin_name}}
                            
                        </span>
                    </li>
                    @endif
                     @endforeach
                </ul>
                <div class="Qualified-price">
                    <span>{{$value->bought_number}}人购买</span>
                    <h2>￥<span>{{$value->money}}</span></h2>
                </div>
            </a>
             
            @endforeach
        </div>
        <h2 class="Qualified-title">
            <span>教师招聘 <a aria-current="false" href="recruit"> 更多»</a></span>
        </h2>
         <div class="Qualified-content clearfix">
            @foreach($qualification as $value)
           
            <a href="coursedetails?curriculum_id={{$value->curriculum_id}}">
                <b>教师资格  </b>
                <h5>{{$value->curriculum_name}}(单科)</h5>
                <div class="Qualified-period" curriculum_id = "{{$value->curriculum_id}}">
                    <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                    <span>{{$value->notice}}</span>
                 </div>
                <ul class="Qualified-teacher">
                     @foreach($admins as $values)
                       @if($value->curriculum_id==$values->curriculum_id)
                    <li>
                        <img src="{{URL::asset('/')}}home/img/touxiang.png" alt="">
                        <span>
                          
                                {{$values->admin_name}}
                            
                        </span>
                    </li>
                    @endif
                     @endforeach
                </ul>
                <div class="Qualified-price">
                    <span>{{$value->bought_number}}人购买</span>
                    <h2>￥<span>{{$value->money}}</span></h2>
                </div>
            </a>
             
            @endforeach
        </div>
    </div>
    <div class="home-advert">
        <div>
            <div class="home-advert-erwm"><img src="" alt=""></div>
            <span>扫一扫二维码<br>下载易师考APP</span></div>
    </div>
</div>
@include('common.footer')
</body>
</html>