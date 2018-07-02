<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{URL::asset('/')}}home/css/style.css">
    <script src="{{URL::asset('/')}}home/js/jquery-1.8.3.js"></script>
</head>
<body>
@include('common.head');
<div class="abouts">
    <div class="abouts-logo"></div>
    <div class="abouts-list">
        <ul class="clearfix">
            <li class="active">关于我们</li>
            <li>加入我们</li>
            <li>联系我们</li>
        </ul>
    </div>
    <ul class="abouts-content">
        <li class="active">啊啊啊啊啊啊啊啊啊</li>
        <li>
            <div class="abouts-recruit-title">
                · 产品经理
            </div>
            <div class="abouts-recruit-text">
                <p>【岗位职责】</p>
                <p>1、负责APP、PC产品的市场调研、需求分析、产品功能设计和交互设计</p>
            </div>
        </li>
        <li>
            <div class="abouts-map">
                <img src="./img/zuobiao.png" alt="">
            </div>
            <div class="abouts-map-text">
                <p>
                    <span>工作地点：北京海淀区上地</span>
                    <span>客服热线：4001234567</span>
                </p>
                <p>
                    <span>联系方式：12345678932</span>
                    <span>客服邮箱：niuxiaoyi@eshikao.com</span>
                </p>
                <p>
                    简历投递邮箱：hr@eshikao.com
                </p>
            </div>
        </li>
    </ul>
</div>
@include('common.footer');
<script src="js/index.js"></script>
</body>
</html>