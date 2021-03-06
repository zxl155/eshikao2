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
@include('common/head')
@foreach($curriculum_content as $value)
<div class="viewdetails">
    <div class="v-top-box">
        <div class="v-top">
            <ul class="v-top-ul clearfix">
                <li class="active">课程介绍</li>
                <li>课程表</li>
                <li>常见问题</li>
            </ul>
            <div class="v-top-buy">
                <span>￥
                      @if($value->recovery_original_is == '1')
                        {{$value->original_price}}
                        @else
                        {{$value->present_price}}
                        @endif
                </span>
               @if($value->bought_number>=$value->purchase_number)
                 <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;">已售罄</a>
                @else
                    @if($isPurchase == 1)
                     <a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d">观看</a>
                    @else 
                        @if($value->is_p_s == 1)
                             <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;">即将开售</a>
                        @else
                            <a href="{{URL::asset('home/CommodityGoods.html')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d">立即购买</a>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="viewdetails-header">
        <div class="details-img">
          @if($value->video == '')  
          <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" alt="">
          @else 
           <iframe frameborder="0" width="400" height="250" src="{{$value->video}}&autoplay=false"></iframe>
          @endif
        </div>
        <div class="details-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <p class="Course-time">开售时间：{{$value->purchase_state_time}} <!-- 有效期天 -->
                <i><img src="./img/sm.png" alt=""></i>
                <q style="display: none;">自购买之日起课观看课程起止</q>
            </p>
            <p>授课教师：
                <span>{{$value->admin_name}}</span>
            </p>
            <p>解读公告: {{$value->publish}}</p>
            <p class="price-brief

">价格：<span>￥<b>
    @if($value->recovery_original_is == '1')
    {{$value->original_price}}
    @else
    {{$value->present_price}}
    @endif
   
</b></span></p>
            <div class="price-purchase">
                @if($value->bought_number>=$value->purchase_number)
                 <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;">已售罄</a>
                @else
                @if($isPurchase == 1)
                 <a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d">观看</a>
                @else 
                 @if($value->is_p_s == 1)
                    <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;">即将开售</a>
                 @else
                    <a href="{{URL::asset('home/CommodityGoods.html')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d">立即购买</a>
                 @endif
                @endif
                @endif
               
                <a href="http://wpa.qq.com/msgrd?v=3&uin=3049266534&site=qq&menu=yes">咨询</a>
                <span>已购{{$value->bought_number}}人 / 限购 {{$value->purchase_number}}人</span>
            </div>
        </div>
    </div>
    <div class="viewdetails-content clearfix">

        <div class="v-content-left">
            <ul class="v-content-left-ul clearfix">
                <li class="active">课程介绍</li>
                <li>课程表</li>
                <li>常见问题</li>
            </ul>
            <div class="v-content-left-list off">
                <?php echo htmlspecialchars_decode($value->curriculum_content); ?>
            </div>
            <div class="v-content-left-list">
                <ul class="v-content-left-list-ul">
                    <!-- 免费直播 -->
                    @if(!empty($free[0]->pplive_name))
                     @if($free[0]->is_time == 0)
                           <li>
                                <a>
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title">【未开始】{{$free[0]->pplive_name}}</span>
                                    <span class="list-time">{{$free[0]->start_time}}--{{$free[0]->end_time}}</span>
                                    <span class="list-name">{{$free[0]->admin_name}}</span>
                                </a>
                            </li>
                        @elseif($free[0]->is_time == 1)
                           <li>
                                <a target="_blank" href="{{URL::asset('home/coursedetailShow')}}?pplive_id={{$free[0]->pplive_id}}">
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title"><span style="color: blue">【直播】</span>{{$free[0]->pplive_name}}</span>
                                    <span class="list-time">{{$free[0]->start_time}}--{{$free[0]->end_time}}</span>
                                    <span class="list-name">{{$free[0]->admin_name}}</span>
                                </a>
                            </li>
                        @else 
                            <li>
                                <a target="_blank" href="{{URL::asset('home/playback')}}?pplive_id={{$free[0]->pplive_id}}">
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title"><span style="color: red">【回放】</span>{{$free[0]->pplive_name}}</span>
                                    <span class="list-time">{{$free[0]->start_time}}--{{$free[0]->end_time}}</span>
                                    <span class="list-name">{{$free[0]->admin_name}}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    
                   <!-- 免费直播 -->
                    @foreach($pplive_content as $val)
                        @if($val->is_free == 0)
                            <li>
                                <a>
                                    <img src="./img/zbtb.png" alt="">
                                    <span class="lint-title">{{$val->pplive_name}}</span>
                                    <span class="list-time">{{$val->start_time}}--{{$val->end_time}}</span>
                                    <span class="list-name">{{$val->admin_name}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                    
                </ul>
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
                                主要针对参加教资/教招教育理论基础知识的地区（如：您所在的省份考公共基础知识，可选择再购买《公共基础知识全程上岸班》即可）。<br>
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
                                登录www.eshikao.com—【我的课程】—【获得QQ群】一【加入学员群】享受专属，如课程中无微信、QQ群暂不支持服务哦。<br>
                                2、讲义发的货:<br>
                                如课程有纸质讲义：则购买之日起三日内发货，默认发货为中通、圆通快递<br>
                                如课程无纸质讲义：暂不支持发货<br>
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
                                购课24小时内退费不收取手续费,若教材已寄出:扣除教材费用
                                购课超过24小时退费:若无教材,扣除手续费10元;若教材已寄出
                                除教材费用+手续费
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
    <!--移动-->
    <div class="m-price-purchase">
        <div class="m-price-money">
            <h4>￥@if($curriculum_content[0]->recovery_original_is == '1')
                        {{$curriculum_content[0]->original_price}}
                        @else
                        {{$curriculum_content[0]->present_price}}
                        @endif</h4>
            <span>{{$curriculum_content[0]->bought_number}}人购买</span>
        </div>
         
            @if($curriculum_content[0]->bought_number>=$curriculum_content[0]->purchase_number)
             <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;"><button type="button" style="background: #cdcdcd;border-color:#cdcdcd;">已售罄</button></a>
            @else
            @if($isPurchase == 1)
             <a href="{{URL::asset('home/coursedetail.html')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d"><button type="button">观看</button> </a>
            @else 
                @if($value->is_p_s == 1)
                     <a href="#" class="active" style="background: #cdcdcd;border-color:#cdcdcd;"><button type="button" style="background: #cdcdcd;border-color:#cdcdcd;">即将开售</button></a>
                 @else
                    <a href="{{URL::asset('home/moveCoursedetails')}}?curriculum_id={{$value->curriculum_id}}" class="active" style="background: #fea70d;border-color:#fea70d"><button type="button">购买</button> </a>
                 @endif
            
            @endif
            @endif
    </div>
</div>
@endforeach
@include('common/footer')

<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>