<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教师招聘</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=2;
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
        <div class="Certificate-type">
            <div class="Certificate-choice">选择地区:</div>
            <ul class="Certificate-ul" id="region">
                <li class="active" region_id="0">全部</li>
                @foreach($region as $value)
                <li region_id="{{$value->region_id}}">{{$value->region_name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sort-content">
        <div class="sort-text" id="quan"><span>全部</span>
           <!--  <ul class="sort-text-ul">
                <li class="active">人气优先 <span class="jt">&uarr;</span></li>
                <li class="">价格优先 <span class="jt">&darr;</span></li>
            </ul> -->
        </div>
    </div>
    <div  id="html">
    <div class="Qualified-content clearfix">
       @foreach($recruits as $val)
        <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$val->curriculum_id}}">
            <b>教师招聘</b>
            <h5>{{$val->curriculum_name}}</h5>
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
@include('common/footer')
<script>
    var renderZhao=(function () {
        //var jt=$('.sort-text-ul').focus('.jt');
        var sortRqJt=1;//人气排序
        function flSwitch(_this) {
            _this.bind('click',function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
            _this.bind('click',function () {
                sortRqJt?$(this).children('.jt').html('&uarr;'):$(this).children('.jt').html('&darr;');
                sortRqJt?sortRqJt=0:sortRqJt=1;
            })
        }
        return {
            init:function () {
                flSwitch($('.Certificate-ul li'));//分类切换
                flSwitch($('.sort-text-ul li'));//排序切换
            }
        }
    })();
    renderZhao.init();
</script>
<script>
     $('#type').click(function(){
        var cattype_id = $("#cattype .active").attr('cattype_id');
        var region_id = $("#region .active").attr('region_id');
        var grade_id = $("#grade .active").attr('grade_id');
        var subject_id = $("#subject .active").attr('subject_id');
        $.ajax({
                    url:"{{URL::asset('home/recruitsearch')}}",
                    data:{cattype_id:cattype_id,grade_id:grade_id,subject_id:subject_id,region_id:region_id,_token:"{{ csrf_token() }}"},
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
                                        html+='<a href="coursedetails.html?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>"'+value.curriculum_name+'"</h5>'
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
</script>
</body>
</html>