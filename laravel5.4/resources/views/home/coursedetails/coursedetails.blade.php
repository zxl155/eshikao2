<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>课程详情</title>
    <link href="{{URL::asset('/')}}/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css"><script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=1;
</script>
</head>
<body>
@include('common.head')
@foreach($curriculum_content as $value)
<div class="viewdetails">
    <div class="coursedetails">
        <div class="details-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <p class="Course-time">开售时间：{{$value->recovery_original}}
        </div>
    </div>
    <div class="viewdetails-content clearfix">
        <div class="v-content-left">
            <ul class="v-content-left-ul clearfix">
                 <li class="active">课程表</li>
                <li>课程介绍</li>
                <li>常见问题</li>
            </ul>
            <div class="v-content-left-list  off">
                @if($value->purchase_number== 1)
                <h3 style="color: red">温馨提示: <span style="font-size: 14px">小主，为了保障1对1的学习效果体验，请使用电脑登录易师考官网观看学习(建议下载使用1对1客户端)</span><br/><a href="https://www.baijiayun.com/classroomdown/" style="color: blue">点击下载客户端</a></h3>
                @endif
                <ul class="v-content-left-list-ul">
    
                     @foreach($pplive_content as $val)
                    
                        @if($val->is_time == 0)
                            <li>
                                <a>
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title">【未开始】{{$val->pplive_name}}</span>
                                    <span class="list-time">{{$val->start_time}}--{{$val->end_time}}</span>
                                    <span class="list-name">{{$val->admin_name}}</span>
                                </a>
                            </li>
                        @elseif($val->is_time == 1)
                            <li>
                                <a target="_blank" href="{{URL::asset('home/coursedetailShow')}}?pplive_id={{$val->pplive_id}}">
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title"><span style="color: blue">【直播】</span>{{$val->pplive_name}}</span>
                                    <span class="list-time">{{$val->start_time}}--{{$val->end_time}}</span>
                                    @if($val->jianyi != '')
                                <!-- <div> <a href="{{URL::asset('/')}}home/img/jianyi/{{$val->jianyi}}" style="color: blue">下载讲义</a></div> -->
                                    <button class="btn" onclick="event.preventDefault(),event.stopPropagation(),location='{{URL::asset('/')}}home/img/jianyi/{{$val->jianyi}}'"><i class="iconfont icon-xiazai"></i>&nbsp;下载讲义</button>
                                    @endif
                                    <span class="list-name">{{$val->admin_name}}</span>
                                </a>
                            </li>
                        @else 
                            <li>
                                <a target="_blank" href="{{URL::asset('home/playback')}}?pplive_id={{$val->pplive_id}}">
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title"><span style="color: red">【回放】</span>{{$val->pplive_name}}</span>
                                    <span class="list-time">{{$val->start_time}}--{{$val->end_time}}</span>
                                    @if($val->jianyi != '')
                                   <!--  <div><a href="{{URL::asset('/')}}home/img/jianyi/{{$val->jianyi}}" style="color: blue">下载讲义</a></div> -->
                                    <button class="btn" onclick="event.preventDefault(),event.stopPropagation(),location='{{URL::asset('/')}}home/img/jianyi/{{$val->jianyi}}'"><i class="iconfont icon-xiazai"></i>&nbsp;下载讲义</button>
                                    @endif
                                    <span class="list-name">{{$val->admin_name}}</span>
                                </a>
                            </li>
                        @endif
                   
                    @endforeach
                   
                </ul>
            </div>
             <div class="v-content-left-list">
                <?php echo htmlspecialchars_decode($value->curriculum_content); ?>
            </div>
            <div class="v-content-left-list">
                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        关于购买
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                                1、适用人群：<br>
                                主要针对参加教师资格证统考地区(不包括西藏、新疆、内蒙古等地区)<br>
                                2、支付问题：<br>
                                 微信、支付宝支付进行顺畅支付<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        关于上课
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                                1、关于直播:<br>
                                电脑登陆www.eshikao.com一点击【我的课程】—查看课程一直播列表(回放列表，使用谷歌浏览器观看更稳定哦<br>
                                2、关于回放:<br>
                                直播结束2小时后,电脑即可观看课程回放<br>
                                3、课程有效期:<br>
                                本课程的回放有效期截止到2019年7月31日<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        入群须知
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                                1,在【我的课程】中获得学员群号<br>
                                开APP—【我的课程】—【相对应课程】一-【学员群】(加群备注:姓名+注册手机号)学员群内有内部资料、上课提醒、助教答疑等专属服务（如无QQ群，显示即为暂无此项服务）<br>
                                2、讲义发的货:<br>
                                暂无讲义：按照讲义具体发货时间发货，详情参考详情页。如已有讲义：当天下午2点前购买当天发货,2点后购买次日发货,登陆我爱教师APP—【我的】—物流信息即可查看物流订单及课程信息等（如课程介绍中无纸质讲义发货，即为暂无此项服务）<br>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        关于账号
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                               每个注册帐号仅限一人使用,请勿泄漏帐号密码,以免影响您的使用,另外,每个帐号只能购买同一课程一次,特别提醒为朋友购买的同学
                            </p>
                        </div>
                    </div>
                </div>
                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        关于退费
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                                <i>①通购课时未开的课:</i><br>
                                购课24小时内退费不收取手续费,若教材已寄出:扣除教材费用60元
购课超过24小时退费:若无教材,扣除手续费10元;若教材已寄出
除教材费用+手续费共计70元
邮件名称:XX课程退费
邮件内容:姓名、注册手机号、退费原因、支付交易订单截图(个人中心—我的订单—对应课程支付交易订单号)
发送至niuxiaoyi@eshikao.com (2~3个工作日内处理)
                                注:暂不接受电话退费。
                            </p>
                            <p>
                                <i>②购课时已开课:</i><br>
                               不接受任何理由退费<br/>
注:暂不接受电话退费
                            </p>
                        </div>
                    </div>
                </div>
                <div class="v-problem">
                    <p class="v-problem-title">
                        <span>Q</span>
                        关于课程
                    </p>
                    <div class="v-problem-content">
                        <span>A</span>
                        <div class="v-problem-text">
                            <p>
                                45分钟=1课时
                            </p>
                        </div>
                    </div>
                </div>
                <div class="v-problem-content">
                        
                        <div class="v-problem-text">
                            <p>
                               客服电话: 17610497153（工作时间周一至周五10:00-18:00）
                            </p>
                        </div>
                    </div>
            </div>
        </div>
        <div class="v-content-right ">
             <div class="v-right">
                <span class="v-right-title">
                    <img src="./img/shhelp.png" alt="">
                    上课帮助
                </span>
                <ul>
                    <li>1.如何上课<div class="v-right-title-ts">
                    购买易师考网站相关课程—点击右上角头像—【我的课程】查看课程—即可观看</div></li>
                    <li>2.如何查快递<div class="v-right-title-ts">如购买课程有纸质版资料发货，点击右上角头像—【我的订单】—查看物流信息</div></li>
                    <li>3.如何查看回放<div class="v-right-title-ts">
                    直播结束2小时后,电脑即可观看课程回放</div></li>
                   
                </ul>
            </div>
            @foreach($regihtcontent as $v)
            <a href="{{URL::asset('home/coursedetails.html')}}?curriculum_id={{$v->curriculum_id}}" class="v-right-a">
                <b>推荐</b>
                <h5>{{$v->curriculum_name}}</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>{{$v->notice}}</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="{{URL::asset('/')}}home/img/admin_head/{{$v->admin_head}}" alt=""><span>{{$v->admin_name}}</span></li>
                   
                </ul>
                <div class="Qualified-price">
                    <span>{{$v->bought_number}}人购买</span>
                    <h2>￥<span>
                        @if($v->recovery_original_is == '1')
                        {{$v->original_price}}
                        @else
                        {{$v->present_price}}
                        @endif
                    </span></h2>
                </div>
            </a>
          @endforeach
           
        </div>
    </div>
</div>
@endforeach
@include('common/footer');
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
<script src="//live-cdn.baijiayun.com/js-sdk/{version}/player/extension/html.js"></script>
<script type="text/javascript">
    setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
        window.location.reload();//页面刷新
    },60000);
</script>
</body>
</html>