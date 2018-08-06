@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="am-active">展示管理员添加新用户</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 展示管理员添加新用户
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    
                   <div class="am-form-group">
                        <a href="{{ url('admin/addUser') }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 添加用户</a>
                    </div>
                    
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">编号</th>
                                    <th class="table-title">手机号</th>
                                    <th>添加时间</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>
                                    <th>{{$value->user_id}}</th>
                                    <th>{{$value->user_tel}}</th>
                                    <th>{{$value->add_time}}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <div class="am-fr">
                                <div id="pull_right">
                                    <div class="pull-right">
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </form>
                </div>

            </div>
        </div>
        <div class="tpl-alert">
            <div id="pull_right">
                                    <div class="pull-right">
                                       {!! $data->render() !!}
                                    </div>
                                </div>
        </div>
    </div>

    </div>

    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
    <script type="text/javascript">
setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
window.location.reload();//页面刷新
},60000);
</script>
</body>
</html>