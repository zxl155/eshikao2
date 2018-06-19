<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>招聘公告</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="notice">
    <p class="notice-title">
        <span>招考公告</span>|<span>教师招聘</span>
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
                    <a href="notice?recruitment_id={{$values->recruitment_id}}">{{$values->region_name}}|{{$values -> recruitment_name}}</a>
                    <span><img src="./img/xiazai.png" alt="">
                    {{$values->region_name}}教师招聘考试</span>
                </li>
               
            </ul>
        </div>
    
         @endforeach
         </span>
        <div id="page" class="page_div"></div>
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
         var region_name = $("#region .active").html();
         $('#selected').html(region_name);
         $.ajax({
            url:'noticeSearch',
            data:{region_id:region_id},
            type:'get',
            dataType:'json',
            success:function(data){
               if (data.empty=='empty') {
                    var txt =  "没有数据";
                     window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
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
                }
            }
         })
     })
</script>
</body>
</html>