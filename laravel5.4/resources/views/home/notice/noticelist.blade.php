<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>招考公告-教师资格证考试,教师招聘考试,考教师更容易</title>
     <meta name="keywords" content="易师考,教师资格证,教师资格证考试">
    <meta name="description" content="易师考专注于教师资格考试的教育培训企业;致力服务准教师群体,提供线上直播,线下面授,在线题库,配套图书等;易师考荣获海淀留学人员创业园授予'金种子'称号,为教师群体提供优选教师岗位...">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=3;
</script>
</head>
<body>
@include('common.head')
<div class="notice">
    <p class="notice-title">
        <span>招考公告</span>|<span>公告列表</span>
    </p>
    <div class="Certificate-type"  id="region" >
        <div class="Certificate-choice">选择地区:</div>
        <ul class="Certificate-ul" class="region_name">
            <li class="active" region_id = '0'>全部</li>
            @foreach($data as $value)
            <li class="" region_id = '{{$value -> region_id}}'>{{$value -> region_name}}</li>
            @endforeach
        </ul>
    </div>
    <div class="notice-listbox">
        <p class="notice-listbox-title">
            <img src="./img/addr.png" alt="">
            <span >
                已选择
                <b id="selected">全部</b>
            </span>
        </p>
        <span  id="html">
          @foreach($recruitment as $values)
         
        <div class="notice-datelist">
            <div class="notice-date">
                <span>{{$values->month}}-{{$values->day}}</span>
                <span>{{$values->year}}</span>
            </div>
            <ul class="notice-datelist-ul">
              
                <li>
                    <a href="{{URL::asset('home/notice')}}?recruitment_id={{$values->recruitment_id}}">{{$values->region_name}}|{{$values -> recruitment_name}}</a>
                    <span><img src="./img/xiazai.png" alt="">
                    {{$values->region_name}}教师招聘考试</span>
                </li>
               
            </ul>
        </div>
    
         @endforeach
         </span>
        <div id="page" class="page_div"></div>
<div id="pull_right">
   <div class="pull-right">
      <span class="pages">{!! $recruitment->render() !!}</span>
   </div>
</div>
    </div>
</div>
@include('common.footer')
<script src="./js/paging.js"></script>
<script src="js/index.js"></script>
<!-- <script>
    var renderZhao=(function () {
        //var jt=$('.sort-text-ul').focus('.jt');
        var sortRqJt=1;//人气排序
        function flSwitch(_this) {
            _this.click(function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
            _this.click(function () {
                sortRqJt?$(this).children('.jt').html('&uarr;'):$(this).children('.jt').html('&darr;');
                sortRqJt?sortRqJt=0:sortRqJt=1;
            })
        }
        $("#page").paging({
            pageNo:1,
            totalPage: 10,
            totalSize: 300,
            callback: function(num) {
                alert(num)
            }
        })
        return {
            init:function () {
                flSwitch($('.Certificate-ul li'));//分类切换
                flSwitch($('.sort-text-ul li'));//排序切换
            }
        }
    })();
    renderZhao.init();
</script> -->
<script>
     $('#region').click(function(){
         var region_id = $("#region .active").attr('region_id');
         if (region_id == 0) {
            window.location.href="noticelist.html"; return false;
         }
         var region_name = $("#region .active").html();
         $('#selected').html(region_name);
         $.ajax({
            url:"{{URL::asset('home/noticeSearch')}}",
            data:{region_id:region_id,_token:"{{ csrf_token() }}"},
            type:'get',
            dataType:'json',
            success:function(data){
               if (data.empty=='empty') {
                   var txt =  "招考即将发布，小主敬请期待ing";
                   window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                   var html = ""; 
                   html+='<div class="notice-datelist">'
                    html+='</div>'
                    $('#html').html(html);
                    $('.pages').html('');
                } else {

                    var html = ""; 
                    jQuery.each(data.data,function(key,value){
                            html+='<div class="notice-datelist">'
                            html+='<div class="notice-date">'
                            html+='<span>'+value.month +'-'+value.day+'</span>'
                            html+='<span>'+value.year+'</span>'
                            html+='</div>'
                            html+='<ul class="notice-datelist-ul">'
                            html+='<li>'
                            html+='<a href="notice?recruitment_id='+value.recruitment_id+'">'+value.region_name+'|'+value.recruitment_name+'</a>'
                            html+='<span><img src="./img/xiazai.png" alt="">'+value.region_name+'教师招聘考试</span>'
                                html+='</li>'
                            html+='</ul>'
                        html+='</div>'
                        
                    }) 
                    $('#html').html(html);
                    $('.pages').html('');
                }
            }
         })
     })
</script>
<style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>
</body>
</html>