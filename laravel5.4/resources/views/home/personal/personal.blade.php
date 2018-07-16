<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的课程</title>
</head>
<body>
<script type="text/javascript">
    var Uindex=0;
</script>
    @include('common.head')
<div class="personal">
    <div class="personal-main">
        @include('common.left')
        <div class="personal-content">
            <div class="personal-content-title">
                <div class="personal-content-type">
                    <span>我的课程</span>
                <!--     <span>考试类型</span>
                <p class="personal-content-drop">
                    <span>教师资格证</span>
                    <span>教师招聘</span>
                </p>
                </div>
                <div class="personal-content-type">
                    <span>课程状态</span>
                    <p class="personal-content-drop">
                        <span>直播中</span>
                        <span>已离线</span>
                    </p>
                </div> -->
            </div>
            <div class="personal-list">
                @if($curriculum == 1)
                
                @else
                @foreach($curriculum as $val)
                <div class="personal-detail-content">
                    <div class="personal-detail-img">
                        <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$val->curriculum_pricture}}" alt="11111" width="200px" height="150px">
                    </div>
                    <div class="personal-detail-text">
                        <h3>
                            <a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$val->curriculum_id}}">{{$val->curriculum_name}}</a>
                            <span class="active"></span>
                            <i></i>
                        </h3>
                        <p class="personal-detail-date">开课时间：{{$val->recovery_original}}</p>
                        @if($val->qq_number != "")
                        <img src="{{URL::asset('/')}}home/img/qq0.png" alt="">
                        <span>加入学员群：</span><span>{{$val->qq_number}}</span>
                        <br/>
                        @endif
                    </div>
                </div>
                 @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@include('common.footer')
<script>
    if(1){
        $('.header-login').css('display','none');
        $('.header-login1').css('display','inline-block');
    }
    //选择考试类型
    $('.personal-content-type').eq(0).click(function () {
                $('.personal-content-title .personal-content-drop').eq(0).toggle();
                $('.personal-content-title .personal-content-drop').eq(1).hide();
            })
    $('.personal-content-type').eq(1).click(function () {
        $('.personal-content-title .personal-content-drop').eq(1).toggle();
        $('.personal-content-title .personal-content-drop').eq(0).hide();
    })
    function pop(){
        $('.personal-prompt-bj').toggle();
    }

</script>
</body>
</html>