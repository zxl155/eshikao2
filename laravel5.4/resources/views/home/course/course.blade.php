<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教师资格证国考课程，教师面试结构化真题，易师考</title>
     <meta name="keywords" content="教师资格证,教师资格证考试,中国教师资格网,中小学教师资格考试网,教师招聘网,教师,教师招聘,教师资格考试,特岗教师,教师招聘考试,中国教师网,教师资格,教师网,教师考试网,易师考,教师考试试题,教师培训报名,教师考试培训">
    <meta name="description" content="教师网提供发布国家教师资格证考试、教师招聘考试（含特岗）报名时间、报名入口、真题资料、教材用书、辅导培训、考试成绩等,更多教师考试信息,请关注易师考">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
    <script type="text/javascript">
     Hindex=1;
</script>
</head>
<body>

    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css">
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
        <script>
    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=750){
                    docEl.style.fontSize = '100px';
                }else{
                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
</script>
<!--移动-->
    <script>
        if({{ session('user_id')}}){

            $('.header-login').css('display','none');
            $('.header-login1').css('display','inline-block');
        }
    </script>

    

<div class="Certificate">
  
   
    <!--移动-->
   
    <div  id="html">
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
    
   </div>
</div>

<script type="text/javascript"></script>
<script>    
    function resetScreen() {
        $('.m-screenbox dd').each(function () {
            $(this).children('button').eq(0).addClass('active').siblings().removeClass('active');
        })
    }
</script>
</body>
</html>