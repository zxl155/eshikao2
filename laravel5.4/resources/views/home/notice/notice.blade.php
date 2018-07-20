<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <title>招聘公告详情</title>
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=3;
</script>
</head>
<body>
@include('common.head')
<div class="notice">
    <p class="notice-title">
        <span>招考公告</span>|<span>教师招聘</span>
    </p>
    @foreach($notice as $value)
    <div class="notice-content">
        <h2>{{$value -> recruitment_name}}</h2>
        <p class="notice-source">
            <span>来源：<b>易师考</b>{{$value->add_time}}  </span>
            <span></span>
        </p>
        <div class="notice-text-main">
            <p class="notice-main-title">
                易师考资讯频道提供全国教师招聘最新<b>招聘公告</b>、<b>考试报名入口</b>、<b>考试成绩查询入口</b>等。<b>易师考</b>为考生提供便利的教师招聘考试信息查询通道。</p>
            <p class="notice-main"><?php echo htmlspecialchars_decode($value->content); ?></p>

            
        </div>
        <div class="enclosure">
            <div class="enclosure-title">
                点击下载附件
            </div>
            <div class="enclosure-list">
               <!--  <a href="">1.各认定机构网站及联系方式.xls</a>
                <a href="">2.{{$value->region_name}}省教师资格人员健康体检表.doc</a>
                <a href="">3.申请人思想品德鉴定表.doc</a> -->
                <a href="{{URL::asset('/')}}home/img/recruitment/{{$value->recruitment_file}}"  >{{$value->recruitment_file}}</a>
            </div>
            <!-- <div class="enclosure-addr">
                <p>{{$value->region_name}}省教育厅</p>
                <p>{{$value->year}}年{{$value->month}}月{{$value->day}}日</p>
            </div> -->
           <!--  <p class="enclosure-Share">分享至：
                <a href=""><img src="./img/weixin.png" alt=""></a>
                <a href=""><img src="./img/sina.png" alt=""></a>
                <a href=""><img src="./img/qq.png" alt=""></a>
            </p> -->
        </div>
    </div>
    @endforeach
</div>
@include('common.footer')
</body>
</html>