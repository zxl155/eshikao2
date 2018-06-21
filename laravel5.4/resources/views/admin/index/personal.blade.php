@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        易师考
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="{{ url('admin/personal') }}">个人资料</a></li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">  
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <a href="{{ url('admin/upd') }}?id={{ $data['admin_id'] }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改资料</a>
                    <a href="{{ url('admin/pwd') }}?id={{ $data['admin_id'] }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改密码</a>
                    <!-- <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 修改密码</button> -->
                </div>
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    
                </div>
                
            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        {{ csrf_field() }}
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th class="table-id">角色</th>
                                    <th class="table-title">用户名</th>
                                    <th class="table-type">昵称</th>
                                    <th class="table-author am-hide-sm-only">头像</th>
                                    <th class="table-title">性别</th>
                                    <th class="table-date am-hide-sm-only">手机号</th>
                                    <th class="table-title">是否冻结</th>
                                    <th class="table-title">注册时间</th>
                                    <th class="table-title">更新时间</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td width="100px">{{ $data['role_name'] }}</td>
                                    <td>{{ $data['admin_name'] }}</td>
                                    <td>{{ $data['nickname'] }}</td>
                                    <td width="100px">
                                    @if(Session('data')['admin_head']) 
                                        <img src="{{URL::asset('/')}}/{{ Session('data')['admin_head'] }}" height="50px"> 
                                    @else
                                        <img src="{{URL::asset('/')}}home/img/touxiang.png" height="50px"> 
                                    @endif
                                    </td>
                                    <td>{{ $data['admin_sex'] ==1?'男':'女' }}</td>
                                    <td>{{ $data['admin_phone'] }}</td>
                                    <td>{{ $data['start'] ==1?'使用中':'已冻结'}} </td>
                                    <td>{{ $data['register_time'] }}</td>
                                    <td>{{ $data['modify_time'] }}</td>
                                </tr>

                            </tbody>
                        </table>
                        
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