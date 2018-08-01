<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>代理查询中心</title>
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
    <script src="{{URL::asset('/')}}assets/js/iscroll.js"></script>
    <script type="text/javascript" src="{{URL::asset('/')}}js/laydate.js"></script>
<!-- 分页样式 -->
<style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>
<style type="text/css">

</style>
</head>
<body data-type="index">
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <img src="{{URL::asset('/')}}home/img/logo.png" alt="">
            </a>
        </div>
        
    </header>
<div>
    <div class="tpl-content-page-title">
        课程包管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">销售代理</a></li>
        <li class="am-active">代理订单</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span>代理查询订单列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                 <div class="am-u-sm-12 am-u-md-3">
                    <form action="{{url('home/orderSearch')}}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="search" value="" class="am-form-field" placeholder="请输入代理人手机号">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div> 
            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>代理商姓名</th>
                                    <th>推荐人注册电话</th>
                                    <th>购买用户</th>
                                    <th>支付时间</th>
                                    <th>支付渠道</th>
                                    <th>支付金额</th>
                                    <th>课程名称</th>
                                    <th>收益金额</th>
                                    <th>收益状态</th>
                                </tr>
                            </thead>
                             <tbody>
                             	@if($order != '')
	                                @foreach($order as $value)
	                               <tr>
	                                  <th>{{$value->sales_name}}</th>
	                                  <th>{{$value->sales_user_tel}}</th>
	                                  <th>{{$value->user_tel}}</th>
	                                  <th>{{$value->order_time}}</th>
	                                  <th>H5</th>
	                                  <th>{{$value->order_money}}</th>
	                                  <th>{{$value->curriculum_name}}</th>
	                                  <th>待定</th>
	                                  <th>可提现</th>
	                               </tr>
	                               @endforeach
	                             @endif
                            </tbody>
                        </table>
                        <hr>
                </div>
            </div>
        </div>
        <div class="tpl-alert"></div>
    </div>
    </div>
    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>