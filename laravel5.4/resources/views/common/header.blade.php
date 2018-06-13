<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>易师考</title>
    <meta name="description" content="这是一个 管理 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="{{URL::asset('/')}}assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="{{URL::asset('/')}}assets/i/app-icon72x72@2x.png">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/')}}css/xcConfirm.css"/>
    <script src="{{URL::asset('/')}}js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('/')}}js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
      .sgBtn{width: 135px; height: 35px; line-height: 35px; margin-left: 10px; margin-top: 10px; text-align: center; background-color: #0095D9; color: #FFFFFF; float: left; border-radius: 5px;}
    </style>
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/amazeui.min.css" />
    <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/admin.css">
    <link rel="stylesheet" href="{{URL::asset('/')}}assets/css/app.css">
    <script src="{{URL::asset('/')}}assets/js/echarts.min.js"></script>
</head>

<body data-type="index">


    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <img src="{{URL::asset('/')}}home/img/logo.png" alt="">
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">

        </div>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                

                <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                    <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                        <span class="tpl-header-list-user-nick">Hello! {{ Session('data')['nickname'] }}</span><span class="tpl-header-list-user-ico">
                            @if(Session('data')['admin_head'])
                            <img src="{{URL::asset('/')}}/{{ Session('data')['admin_head'] }}"> 
                            @else
                            <img src="{{URL::asset('/')}}home/img/touxiang.png"> 
                            @endif
                        </span>
                    </a>
                    <ul class="am-dropdown-content">
                        <li><a href="personal"><span class="am-icon-bell-o"></span> 个人资料</a></li>
                        <li><a href="out"><span class="am-icon-power-off"></span> 退出</a></li>
                    </ul>
                </li>
                <li><a href="###" class="tpl-header-list-link"><span class="am-icon-sign-out tpl-header-list-ico-out-size"></span></a></li>
            </ul>
        </div>
    </header>







    <div class="tpl-page-container tpl-page-header-fixed">


        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                易师考管理系统
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="index" class="nav-link active">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>
                    
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-table"></i>
                            <span>教师管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="addtea">
                                    <i class="am-icon-angle-right"></i>
                                    <span>添加教师</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="listtea">
                                    <i class="am-icon-angle-right"></i>
                                    <span>教师列表</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-table"></i>
                            <span>直播课程</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="outdoorsRoute">
                                    <i class="am-icon-angle-right"></i>
                                    <span>助教课程</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="curriculum">
                                    <i class="am-icon-angle-right"></i>
                                    <span>课程管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>面试课批量管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>批量导入课程</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>导学视频上传</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>课程排序管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>课程查重</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>1V1面试课</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-table"></i>
                            <span>题库管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="outdoorsRoute">
                                    <i class="am-icon-angle-right"></i>
                                    <span>录入管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsGuide">
                                    <i class="am-icon-angle-right"></i>
                                    <span>预录入</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>组卷管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>真题管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>模拟卷管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>作业卷管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>存疑与不可见管理</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>老题校对报表</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>题库统计</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                                <a href="outdoorsDest">
                                    <i class="am-icon-angle-right"></i>
                                    <span>题库日志</span>
                                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>


