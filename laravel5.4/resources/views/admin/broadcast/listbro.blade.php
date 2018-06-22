@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        管理员管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">管理员管理</a></li>
        <li class="am-active">轮播图列表</li>
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
                        <a href="{{ url('admin/addbro') }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 添加轮播图</a>
                    </div>
                    
                </div>
                
                <div class="am-u-sm-12 am-u-md-3">
                    
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">编号</th>
                                    <th class="table-title">轮播图</th>
                                    <th class="table-title">状态</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody> 
                                @foreach($data as $key=>$val)
                                <tr>
                                    <td>{{ $val->broadcast_id }}</td>
                                    <td>{{ $val->broadcast_url }}</td>
                                    <td>{{ $val->state ==1?'已使用':'未使用' }}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{ url('admin/updbro') }}?id={{ $val->broadcast_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                  @endforeach
                                
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <div class="am-fr">
                                <div id="pull_right">
                                    
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