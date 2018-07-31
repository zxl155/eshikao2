<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="360-site-verification" content="40f658a6fca39e65966161eb0b48cef3" />
    <meta name="360-site-verification" content="76906b1ff278008f53902c4b39933277" />
    <meta name="baidu-site-verification" content="do40ZX3bYh" />
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" /> 
    <title>易师考，教师资格证考试，教师招聘考试一站式备考平台</title>
    <meta name="keywords" content="教师资格证,教师资格证考试,中国教师资格网,中小学教师资格考试网,教师招聘网,教师,教师招聘,教师资格考试,特岗教师,教师招聘考试,中国教师网,教师资格,教师网,教师考试网,易师考,教师考试试题,教师培训报名,教师考试培训">
    <meta name="description" content="教师网提供发布国家教师资格证考试、教师招聘考试（含特岗）报名时间、报名入口、真题资料、教材用书、辅导培训、考试成绩等,更多教师考试信息,请关注易师考">
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
            <div class="swiper-slide">
                <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$va->curriculum_id}}">
                   <img src="{{URL::asset('/')}}home/img/sowing_msp/{{$va->broadcast_url}}" alt=""> 
                </a>
            </div>
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
            <a target="_blank" href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
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
            <a target="_blank" href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
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
            <!-- <span>扫一扫二维码<br>下载易师考APP</span> --></div>
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