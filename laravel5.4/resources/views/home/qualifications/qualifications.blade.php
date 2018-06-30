<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教师资格证</title>
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
            <ul class="sort-text-ul">
                <li class="active">人气优先 <span class="jt">&uarr;</span></li>
                <li class="">价格优先 <span class="jt">&darr;</span></li>
            </ul>
        </div>
    </div>
    <div class="Qualified-content clearfix" id="html">
       @foreach($qualifications as $val)
        <a href="{{URL::asset('home/coursedetails')}}curriculum_id={{$val->curriculum_id}}">
            <b>教师资格</b>
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
     <div id="page" class="page_div">{{ $qualifications->links('common.pagination') }} </div>
   
   
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
                            var txt =  "没有数据";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                        } else {
                            var html = ""; 
                            jQuery.each(data.data,function(key,value){
                                
                                        html+='<a href="coursedetails?curriculum_id='+value.curriculum_id+'">'
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
                            $('#html').html(html);
                        }
                    }
                })
       })
</script>
</body>
</html>