<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>易师考</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/swiper.min.css">
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/swiper.min.js"></script>
    <script type="text/javascript">
    Hindex=0;
</script>
</head>
@include('common.head')
<body>
<div class="Home">
    <div id="focus-banner">
        <ul id="focus-banner-list">
            @foreach($broadcast_content as $va)
            <li> <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$va->curriculum_id}}" class="focus-banner-img" style="background: url('{{URL::asset('/')}}home/img/sowing_msp/{{$va->broadcast_url}}')no-repeat;background-position: center;background-size: 1920px 377px">
            </a>
            </li>
            @endforeach
           
        </ul>
        <a href="javascript:;" id="next-img" class="focus-handle"></a> <a href="javascript:;" id="prev-img" class="focus-handle"></a>
        <ul id="focus-bubble">
        </ul>
    </div>
    <!--移动-->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($broadcast_content as $va)
            <div class="swiper-slide"><img src="{{URL::asset('/')}}home/img/sowing_msp/{{$va->broadcast_url}}" alt=""></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
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
    <div class="Qualified"><h2 class="Qualified-title"><span>教师资格 <a aria-current="false" href="{{URL::asset('home/qualifications.html')}}"> 更多»</a></span>
    </h2>
        <div class="Qualified-content clearfix">
            
           @foreach($qualifications as $val)
            <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
                <div class="m-Qualified-title">
                   <b>教师资格  </b>
                <h5>{{$val->curriculum_name}}</h5> 
                </div>
                <div class="Qualified-period" curriculum_id = "{{$val->curriculum_id}}">
                    <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                    <span>{{$val->notice}}</span>
                 </div>
                <ul class="Qualified-teacher">
                    
                    <li>
                        <img src="{{URL::asset('/')}}home/img/admin_head/{{$val->admin_head}}" alt="">
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
        <h2 class="Qualified-title">
            <span>教师招聘 <a aria-current="false" href="{{URL::asset('home/recruit.html')}}"> 更多»</a></span>
        </h2>
       
         <div class="Qualified-content clearfix">
            
           @foreach($recruit as $val)
            <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
                <div class="m-Qualified-title">
                   <b>教师招聘  </b>
                <h5>{{$val->curriculum_name}}</h5> 
                </div>
                <div class="Qualified-period" curriculum_id = "{{$val->curriculum_id}}">
                    <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                    <span>{{$val->notice}}</span>
                 </div>
                <ul class="Qualified-teacher">
                    
                    <li>
                        <img src="{{URL::asset('/')}}home/img/admin_head/{{$val->admin_head}}" alt="">
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
    </div>
    <div class="home-advert">
        <div>
            <div class="home-advert-erwm"><img src="" alt=""></div>
            <span>扫一扫二维码<br>下载易师考APP</span></div>
    </div>
</div>
<script>
    //sweiper
    var mySwiper = new Swiper('.swiper-container',{
        loop: true,
        autoplay: 3000,
        pagination : '.swiper-pagination',
    });
</script>
@include('common.footer')
</body>
</html>