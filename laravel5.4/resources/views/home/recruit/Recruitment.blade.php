<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common/head');
<div class="Certificate">
    <div class="Certificate-box" id="type">
        <div class="Certificate-type">
            <div class="Certificate-choice">选择类别:</div>
            <ul class="Certificate-ul" id="cattype">
                <li class="active" cattype_id="0">全部</li>
                @foreach($cattype as $value)
                <li cattype_id="{{$value->type_id}}">{{$value->type_name}}</li>
                @endforeach
            </ul>
        </div>
        <div class="Certificate-type">
            <div class="Certificate-choice">选择地区:</div>
            <ul class="Certificate-ul" id="region">
                <li class="active" region_id='0'>全部</li>
                 @foreach($region as $value)
                <li region_id="{{$value->region_id}}">{{$value->region_name}}</li>
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
                <li class="active" subject_id='0'>全部</li>
                @foreach($subjecttype as $value)
                <li subject_id="{{$value->subject_id}}">{{$value->subject_name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sort-content">
        <div class="sort-text"><span>全部</span>
            <ul class="sort-text-ul">
                <li class="active">人气优先 <span class="jt">&uarr;</span></li>
                <li class="">价格优先 <span class="jt">&darr;</span></li>
            </ul>
        </div>
    </div>
    <div class="Qualified-content clearfix" id="html">
        @foreach($curriculum as $value)
        <a href="coursedetails?curriculum_id={{$value->curriculum_id}}">
            <b>教师资格</b>
            <h5>{{$value->curriculum_name}}(单科)</h5>
            <div class="Qualified-period">
                <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                <span>{{$value->notice}}</span>
            </div>
            <ul class="Qualified-teacher">
                @foreach($admin as $values)
                @if($value->curriculum_id==$values->curriculum_id)
                <li>
                    <img src="img/touxiang.png" alt="">
                    <span>{{$values->admin_name}}</span>
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
    <div id="page" class="page_div"></div>
             {{$curriculum->links()}} 
    </div>
</div>
@include('common/footer');
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
                    url:'recruitsearch',
                    data:{cattype_id:cattype_id,grade_id:grade_id,subject_id:subject_id,region_id:region_id},
                    type:'get',
                    dataType:'json',
                    success:function(data){
                        if (data.empty=='empty') {
                            var txt =  "没有数据";
                             window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                        } else {
                            var html = ""; 
                            jQuery.each(data.data,function(key,value){
                                
                                        html+='<a href="coursedetails?curriculum_id='+value.curriculum_id+'">'
                                        html+='<b>教师资格</b>'
                                        html+='<h5>"'+value.curriculum_name+'"(单科)</h5>'
                                        html+='<div class="Qualified-period">'
                                        html+='<i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>'
                                        html+='<span>'+value.notice+'</span>'
                                        html+='</div>'
                                        html+='<ul class="Qualified-teacher">'
                                        html+='<li>'
                                        html+='<img src="img/touxiang.png" alt="">'
                                        html+='<span></span>'
                                        html+='</li>'
                                        html+='</ul>'
                                        html+='<div class="Qualified-price">'
                                        html+='<span>'+value.bought_number+'人购买</span>'
                                        html+='<h2>￥<span>'+value.money+'</span></h2>'
                                        html+='</div>'
                                        html+='</a>'
                                 
                            }) 
                            $('#html').html(html);
                        }
                    }
                })
     })
</script>
</body>
</html>