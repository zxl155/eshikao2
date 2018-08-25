@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        讲义展示
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">教室直播列表</a></li>
        <li class="am-active">讲义展示</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <a href="{{ url('admin/handoutadd') }}?pplive_id={{$pplive_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 添加讲义</a>
                    </div>
                </div>
            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                   <th>讲义名称</th>
                                   <th>操作</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if($data[0]->jianyi!='')
                                <th>{{$data[0]->jianyi}}</th>
                                <th><a href="{{url('admin/handoutupd')}}?pplive_id={{$data[0]->pplive_id}}">修改</a></th>
                                @endif
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
        <div class="tpl-alert"></div>
    </div>

    </div>

    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>