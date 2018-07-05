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
                    <span>考试类型</span>
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
                </div>
            </div>
            <div class="personal-list">
                <!-- <div class="personal-detail-content">
                    <div class="personal-detail-img">
                        <img src="{{URL::asset('/')}}home/img/kcimg.png" alt="">
                    </div>
                    <div class="personal-detail-text">
                        <h3>
                            2018上教师资格证一站拿证（单科）
                            <span class="">回放课</span>
                            <i></i>
                        </h3>
                        <p class="personal-detail-date">上次观看时间：2018-06-07 10:34:45</p>
                        <div class="personal-detail-qqq">
                            <img src="{{URL::asset('/')}}home/img/qq0.png" alt="">
                            <span>加入学员群：123567456</span>
                            <a href="javascript:pop();">删除课程</a>
                        </div>
                    </div>
                    <div class="personal-prompt-bj">
                        <div class="personal-prompt">
                            <p class="personal-prompt-title">提示<a href="javascript:pop();">×</a></p>
                            <div class="personal-prompt-content">
                                <div class="personal-prompt-img"><img src="{{URL::asset('/')}}home/img/prompt.png" alt=""></div>
                                <div class="personal-prompt-text">
                                    <p>该课程将从我的课程中删除，删除后，如课程已下线，您将无法再次添加该课程</p>
                                    <div class="personal-prompt-an">
                                        <a href="">确定</a>
                                        <a href="javascript:pop();" class="active">取消</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                @foreach($curriculum as $val)
                <div class="personal-detail-content">
                    <div class="personal-detail-img">
                        <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$val->curriculum_pricture}}" alt="11111" width="200px" height=150px">
                    </div>
                    <div class="personal-detail-text">
                        <h3>
                            {{$val->curriculum_name}}
                           <!--  <span class="active">直播预告</span>
                            <i>请确认时间</i> -->
                        </h3>
                        <p class="personal-detail-date">开课时间：{{$val->recovery_original}}</p>
                        <a href="{{URL::asset('home/coursedetail')}}?curriculum_id={{$val->curriculum_id}}" style="color: blue">点击查看</a>
                    </div>

                </div>
                @endforeach
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