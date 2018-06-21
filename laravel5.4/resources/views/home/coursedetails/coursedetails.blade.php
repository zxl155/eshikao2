<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css"><script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script><script type="text/javascript">
     Hindex=1;
</script>
</head>
<body>
@include('common.head');
@foreach($data as $value);
<div class="viewdetails">
    <div class="coursedetails">
        <div class="details-brief">
            <h2>{{$value->curriculum_name}}</h2>
            <p class="Course-time">开课时间：{{$value->start_time}}
        </div>
    </div>
    <div class="viewdetails-content clearfix">
        <div class="v-content-left">
            <ul class="v-content-left-ul clearfix">
                <li>课程表</li>
                <li class="active">课程详情</li>
                <li>常见问题</li>
            </ul>
            <div class="v-content-left-list">
                <h3>备考指导</h3>
                <ul class="v-content-left-list-ul">
                    @foreach($pplive as $values)
                    <li><a href="">
                        <img src="./img/zbtb.png" alt="">
                        <span class="lint-title">【直播】{{$values->pplive_name}}</span>
                        <span class="list-time">{{$values->times}}</span>
                        <span class="list-name">{{$values->admin_name}}</span>
                    </a></li>
                    @endforeach
                </ul>
            </div>
            <div class="v-content-left-list off">
                <img src="./img/detailsdt.png" alt="">
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
                                主要针对参加山东省教师招聘考试的考生，考试内容为教育学、教育心理学、心理学、公共基础知识的地区均可购买。<br>
                                青岛、济宁、潍坊、烟台、枣庄、威海、东营、聊城、淄博、德州、莱芜、滨州等地方均可选择。<br>
                                2、支付问题：<br>
                                支付宝、微信都可以进行流畅支付。<br>
                                3、购物一期笔试通关班赠送第二期笔试通关班。
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
                                电脑登录www.eshikao.com点击【我的课程】——打开课程——直播列表(回放列表)<br>
                                2、关于回放:<br>
                                直播结束12小的时后,手机和电脑即可观看课程回放。<br>
                                3、课程有效期:<br>
                                课程观看有效期截止至2019年8月31日(课程有效期一年,只能观看回放,不赠送新课)。<br>
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
                                入群需填写姓名+注册手机号,我们将在24小时内审核通过,学员群内有内部资料,上课提醒,助教答疑等专属服务。<br>
                                2、讲义发的货:<br>
                                6月21日起发的货,具体时间会在学员群通知。<br>
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
                                每个仅限一人使用，请勿泄露账号和密码，以免影响您的正常使用，另外，每个账号只能购买同一个课程一次，特别提醒为朋友购买的同学哦。
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
                                购课24小时内退费不收取手续费,若讲义已寄出:扣除讲义费用300元;<br>
                                购课超过24小时退费:<br>
                                若讲义未寄出:扣除手续费20元;<br>
                                若讲义已寄出:扣除讲义费用+手续费320元<br>
                                邮件名称:XX课程退费申请<br>
                                邮件内容:姓,名注册手机号,退课名称,退费原因,支付订单截图(我的订单中查找)发送至kefu@eshkao.com(2-3个工作日内处理回复邮件)<br>
                                ②购课时已开课:不接受任何理由退费。<br>
                                注:暂不接受电话退费。
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
            </div>
        </div>
        <div class="v-content-right ">
            <div class="v-right">
                <span class="v-right-title">
                    <img src="./img/shhelp.png" alt="">
                    上课帮助
                </span>
                <ul>
                    <li>1.如何上课
                        <div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>2.如何下载讲义<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>3.如何缓存<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>4.如何查快递<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>5.如何同意回放<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                    <li>6.如何退课<div class="v-right-title-ts">登录网站后，进入【我的课程】，即可观看视频。PS。直播入口通常会在开课前半小时开放哦~</div></li>
                </ul>
            </div>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
            <a href="#" class="v-right-a">
                <b>推荐</b>
                <h5>2018下教师资格证一站拿证（单科）</h5>
                <div class="Qualified-period">
                    <i><img src="img/jifen.png" alt=""></i>
                    <span>100课时 · 按字讲义</span>
                </div>
                <ul class="Qualified-teacher">
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                    <li><img src="img/touxiang.png" alt=""><span>杨老师</span></li>
                </ul>
                <div class="Qualified-price">
                    <span>2000人购买</span>
                    <h2>￥<span>1000</span></h2>
                </div>
            </a>
        </div>
    </div>
</div>
@endforeach
@include('common/footer');
<script src="js/jquery-1.8.3.js"></script>
<script src="js/index.js"></script>
</body>
</html>