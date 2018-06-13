<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>易师考</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head')
<div class="Certificate">
    <div class="Certificate-box">
        <div class="Certificate-type">
            <div class="Certificate-choice">选择类别:</div>
            @foreach($cate as $key =>$val)
            <ul class="Certificate-ul">
                <li value="{{ $val['cate_id'] }}">{{ $val['cate_name'] }}</li>
            </ul>
            @endforeach
        </div>
        <div class="Certificate-type">
            <div class="Certificate-choice">选择年级:</div>
            @foreach($grade as $key =>$val)
            <ul class="Certificate-ul">
                <li class="active">{{ $val['grade_name'] }}</li>
            </ul>
            @endforeach
        </div>
        <div class="Certificate-type">
            <div class="Certificate-choice">选择学科:</div>
            @foreach($subject as $key =>$val)
            <ul class="Certificate-ul">
                <li class="active">{{ $val['subject_name'] }}</li>
            </ul>
            @endforeach
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
    <div class="Qualified-content clearfix">
        @foreach($data as $key => $val)
        <a href="#">
            <b>教师资格</b>
            <h5>{{ $val->curriculum_title }}</h5>
            <div class="Qualified-period">
                <i><img src="{{URL::asset('/')}}home/img/jifen.png" alt=""></i>
                <span>{{ $val->curriculum_desc }}</span>
            </div>
            <ul class="Qualified-teacher">
                <li><img src="{{URL::asset('/')}}home/img/touxiang.png" alt=""><span>{{ $val->tea_name }}</span></li>
            </ul>
            <div class="Qualified-price">
                <span>{{ $val->curriculum_num }}人购买</span>
                <h2>￥<span>{{ $val->curriculum_price }}</span></h2>
            </div>
        </a>
        @endforeach
        
    </div>
    <div id="page" class="page_div"></div>
</div>
@include('common.footer')
<script src="./js/paging.js"></script>
<script>
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
</script>

</body>
</html>