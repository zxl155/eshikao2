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
@include('common/head')
<div class="Certificate">
    <div class="Certificate-box" id="type">
        <div class="Certificate-type">
            <div class="Certificate-choice">选择类别:</div>
            <ul class="Certificate-ul" id="cattype">
                <li class="active" cattype_id='0'>全部</li>
                @foreach($cattype as $value)
                <li cattype_id="{{$value->type_id}}">{{$value->type_name}}</li>
                @endforeach
            </ul>
        </div>
        <div class="Certificate-type">
            <div class="Certificate-choice">选择年级:</div>
            <ul class="Certificate-ul" id="grade">
                <li class="active" grade_id='0'>全部</li>
                @foreach($gradetype as $value)
                <li grade_id="{{$value->grade_id}}">{{$value->grade_name}}</li>
                @endforeach
            </ul>
        </div>
        <div class="Certificate-type">
            <div class="Certificate-choice">选择学科:</div>
            <ul class="Certificate-ul" id="subject">
                <li class="active" subject_id="0">全部</li>
                @foreach($subjecttype as $value)
                <li subject_id="{{$value->subject_id}}">{{$value->subject_name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sort-content">
        <div class="sort-text" id="quan"><span>全部</span>
            <!-- <ul class="sort-text-ul">
                <li class="active">人气优先 <span class="jt">&uarr;</span></li>
                <li class="">价格优先 <span class="jt">&darr;</span></li>
            </ul> -->
        </div>
    </div>
    <!--移动-->
    <div class="m-sort-content">
        <ul class="m-sort-ul">
            <li class="active" id="comprehensive">综合</li>
            <li id="popularity">人气</li>
            <li>
                价格
                <span id="moneys">
                    <i class="iconfont icon-paixujiantoushang active" value='1'></i>
                    <i class="iconfont icon-paixujiantouxia" value='2'></i>
                </span>
            </li>
            <li>筛选
            <i class="iconfont icon-shaixuan active"></i></li>
        </ul>
        <div class="m-screenbox">
            <dl class="active">
                <dt>选择类型</dt>
                <dd class="btn-type">
                    <button class="active" type="button" value="0">全部</button>
                     @foreach($cattype as $value)
                    <button type="button" value="{{$value->type_id}}">{{$value->type_name}}</button>
                    @endforeach
                </dd>
            </dl>
            <dl>
                <dt>选择学段</dt>
                <dd class="btn-period">
                    <button class="active" type="button" value="0">全部</button>
                    @foreach($gradetype as $value)
                    <button type="button" value="{{$value->grade_id}}">{{$value->grade_name}}</button>
                     @endforeach
               
                </dd>
            </dl>
            <dl>
                <dt>选择学科</dt>
                <dd class="btn-subject">
                    <button class="active" type="button" value="0">全部</button>
                     @foreach($subjecttype as $value)
                    <button type="button" value="{{$value->subject_id}}">{{$value->subject_name}}</button>
                    @endforeach
                </dd>
            </dl>
            <a href="javascript:void(0);" onclick="resetScreen()">重置</a>
            <a href="#" class="move">提交</a>
        </div>
    </div>
    <div  id="html">
    <div class="Qualified-content clearfix">
       @foreach($qualifications as $val)
       @if($val->is_course == 1)
                   <a target="_blank" href="{{URL::asset('home/courselist.html')}}?curriculum_id={{$val->curriculum_id}}">
           @else 
            <a target="_blank" href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
            @endif
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
            @if($val->is_course == 1)
                <img class="img" src="{{URL::asset('/')}}home/img/home_bom.jpg" alt="">
            @endif
        </a>
        @endforeach
    </div>
    
   </div>
</div>
@include('common/footer')
<script type="text/javascript"></script>
<script>    
       $('#type').click(function(){
            var cattype_id = $("#cattype .active").attr('cattype_id');
            var grade_id = $("#grade .active").attr('grade_id');
            var subject_id = $("#subject .active").attr('subject_id');
            $.ajax({
                    url:"{{URL::asset('home/quasearch')}}",
                    data:{cattype_id:cattype_id,grade_id:grade_id,subject_id:subject_id,_token:"{{ csrf_token() }}"},
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        if (data.empty=='empty') {
                            var txt =  "课程即将上线，小主敬请期待ing";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                            var html = ""; 
                            html+='<div class="Qualified-content clearfix">'
                           
                            html+='<b></b>'
                            html+='<h5></h5>'
                            html+='<div class="Qualified-period">'
                                html+='<i></i>'
                                html+='<span></span>'
                            html+='</div>'
                            html+='<ul class="Qualified-teacher">'
                                html+='<li>'
                                    html+='<img src="" alt="" height="50px" width="50px" alt="">'
                                    html+='<span></span>'
                                html+='</li>'
                            html+='</ul>'
                            html+='<div class="Qualified-price">'
                                html+='<span></span>'
                                
                                    html+='<h2><span></span></h2>'
                              
                                
                            html+='</div>'
                            
                            html+='</div>'
                            //html+='<div id="page" class="page_div">'+data.data+'->links("common.pagination")</div>'
                            $('#html').html(html);
                        } else {
                            var html = ""; 
                            html+='<div class="Qualified-content clearfix">'
                            jQuery.each(data.data,function(key,value){
                                        html+='<a target="_blank" href="coursedetails.html?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>'+value.curriculum_name+'</h5>'
                                        html+='<div class="Qualified-period">'
                                            html+='<i><img src="{{URL::asset("/")}}home/img/jifen.png" alt=""></i>'
                                            html+='<span>'+value.notice+'</span>'
                                        html+='</div>'
                                        html+='<ul class="Qualified-teacher">'
                                            html+='<li>'
                                                html+='<img src="{{URL::asset("/")}}home/img/admin_head/'+value.admin_head+'" alt="" height="50px" width="50px" alt="">'
                                                html+='<span>'+value.admin_name+'</span>'
                                            html+='</li>'
                                        html+='</ul>'
                                        html+='<div class="Qualified-price">'
                                            html+='<span>'+value.bought_number+'人购买</span>'
                                            if (value.recovery_original_is == 1) {
                                                html+='<h2>￥<span>'+value.original_price+'</span></h2>'
                                            } else {
                                                html+='<h2>￥<span>'+value.present_price+'</span></h2>'
                                            }
                                            
                                        html+='</div>'
                                        html+='</a>'
                            }) 
                            html+='</div>'
                            //html+='<div id="page" class="page_div">'+data.data+'->links("common.pagination")</div>'
                            $('#html').html(html);
                        }
                    }
                })
       })

    /*移动端*/
    $('.move').click(function(){
        var cattype_id = $(".btn-type .active").val(); //类型
        var grade_id = $(".btn-period .active").val(); //学科
        var subject_id = $(".btn-subject .active").val(); //地区
        $.ajax({
                    url:"{{URL::asset('home/quasearch')}}",
                    data:{cattype_id:cattype_id,grade_id:grade_id,subject_id:subject_id,_token:"{{ csrf_token() }}"},
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        if (data.empty=='empty') {
                            var html = ""; 
                            $('#html').html(html);
                        } else {
                            var html = ""; 
                            html+='<div class="Qualified-content clearfix">'
                            jQuery.each(data.data,function(key,value){
                                        html+='<a href="coursedetails.html?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>'+value.curriculum_name+'</h5>'
                                        html+='<div class="Qualified-period">'
                                            html+='<i><img src="{{URL::asset("/")}}home/img/jifen.png" alt=""></i>'
                                            html+='<span>'+value.notice+'</span>'
                                        html+='</div>'
                                        html+='<ul class="Qualified-teacher">'
                                            html+='<li>'
                                                html+='<img src="{{URL::asset("/")}}home/img/admin_head/'+value.admin_head+'" alt="" height="50px" width="50px" alt="">'
                                                html+='<span>'+value.admin_name+'</span>'
                                            html+='</li>'
                                        html+='</ul>'
                                        html+='<div class="Qualified-price">'
                                            html+='<span>'+value.bought_number+'人购买</span>'
                                            if (value.recovery_original_is == 1) {
                                                html+='<h2>￥<span>'+value.original_price+'</span></h2>'
                                            } else {
                                                html+='<h2>￥<span>'+value.present_price+'</span></h2>'
                                            }
                                            
                                        html+='</div>'
                                        html+='</a>'
                            }) 
                            html+='</div>'
                            //html+='<div id="page" class="page_div">'+data.data+'->links("common.pagination")</div>'
                            $('#html').html(html);
                        }
                    }
                })
    })
    /*综合*/
    $('#comprehensive').click(function(){
        location.reload();
    })
    /*人气*/
    $('#popularity').click(function(){
         $.ajax({
                    url:"{{URL::asset('home/popularity')}}",
                    data:{_token:"{{ csrf_token() }}"},
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        if (data.empty=='empty') {
                           var html = ""; 
                            $('#html').html(html);
                        } else {
                            var html = ""; 
                            html+='<div class="Qualified-content clearfix">'
                            jQuery.each(data.data,function(key,value){
                                        html+='<a href="coursedetails.html?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>'+value.curriculum_name+'</h5>'
                                        html+='<div class="Qualified-period">'
                                            html+='<i><img src="{{URL::asset("/")}}home/img/jifen.png" alt=""></i>'
                                            html+='<span>'+value.notice+'</span>'
                                        html+='</div>'
                                        html+='<ul class="Qualified-teacher">'
                                            html+='<li>'
                                                html+='<img src="{{URL::asset("/")}}home/img/admin_head/'+value.admin_head+'" alt="" height="50px" width="50px" alt="">'
                                                html+='<span>'+value.admin_name+'</span>'
                                            html+='</li>'
                                        html+='</ul>'
                                        html+='<div class="Qualified-price">'
                                            html+='<span>'+value.bought_number+'人购买</span>'
                                            if (value.recovery_original_is == 1) {
                                                html+='<h2>￥<span>'+value.original_price+'</span></h2>'
                                            } else {
                                                html+='<h2>￥<span>'+value.present_price+'</span></h2>'
                                            }
                                            
                                        html+='</div>'
                                        html+='</a>'
                            }) 
                            html+='</div>'
                            //html+='<div id="page" class="page_div">'+data.data+'->links("common.pagination")</div>'
                            $('#html').html(html);
                        }
                    }
        })
    })
    /*移动通过价格*/
    $('#moneys').click(function(){
        var moneys = $('#moneys  .active').attr('value');
        $.ajax({
                    url:"{{URL::asset('home/moneys')}}",
                    data:{moneys:moneys,_token:"{{ csrf_token() }}"},
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        if (data.empty=='empty') {
                           var html = ""; 
                            $('#html').html(html);
                        } else {
                            var html = ""; 
                            html+='<div class="Qualified-content clearfix">'
                            jQuery.each(data.data,function(key,value){
                                        html+='<a href="coursedetails.html?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>'+value.curriculum_name+'</h5>'
                                        html+='<div class="Qualified-period">'
                                            html+='<i><img src="{{URL::asset("/")}}home/img/jifen.png" alt=""></i>'
                                            html+='<span>'+value.notice+'</span>'
                                        html+='</div>'
                                        html+='<ul class="Qualified-teacher">'
                                            html+='<li>'
                                                html+='<img src="{{URL::asset("/")}}home/img/admin_head/'+value.admin_head+'" alt="" height="50px" width="50px" alt="">'
                                                html+='<span>'+value.admin_name+'</span>'
                                            html+='</li>'
                                        html+='</ul>'
                                        html+='<div class="Qualified-price">'
                                            html+='<span>'+value.bought_number+'人购买</span>'
                                            if (value.recovery_original_is == 1) {
                                                html+='<h2>￥<span>'+value.original_price+'</span></h2>'
                                            } else {
                                                html+='<h2>￥<span>'+value.present_price+'</span></h2>'
                                            }
                                            
                                        html+='</div>'
                                        html+='</a>'
                            }) 
                            html+='</div>'
                            //html+='<div id="page" class="page_div">'+data.data+'->links("common.pagination")</div>'
                            $('#html').html(html);
                        }
                    }
                })
    })
    function resetScreen() {
        $('.m-screenbox dd').each(function () {
            $(this).children('button').eq(0).addClass('active').siblings().removeClass('active');
        })
    }
</script>
</body>
</html>