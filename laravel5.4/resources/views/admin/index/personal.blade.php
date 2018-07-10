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
                    <a href="{{ url('admin/upd') }}?admin_id={{$admin_content[0]->admin_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改资料（个人）</a>
                    <a href="{{ url('admin/pwd') }}?admin_id={{$admin_content[0]->admin_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改密码（个人）</a>
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
                                    <th class="table-title">用户名</th>
                                    <th class="table-author am-hide-sm-only">头像</th>
                                    <th class="table-type">昵称</th>
                                    <th class="table-type">手机号</th>
                                    <th class="table-title">性别</th>
                                    <th class="table-title">用户类型</th>
                                    <th class="table-title">状态</th>
                                    <th class="table-title">注册时间</th>
                                    <th class="table-title">更新时间</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admin_content as $val)
                                <tr>
                                    <th>{{$val->admin_name}}</th>
                                    <th>
                                        <img src="{{URL::asset('/')}}home/img/admin_head/{{$val->admin_head}}" alt="" width="100" height="100">
                                    </th>
                                    <th>{{$val->nickname}}</th>
                                    <th>{{$val->admin_phone}}</th>
                                    <th>{{ $val->admin_sex ==1?'男':'女'}}</th>
                                    <th>{{$val->role_name}}</th>
                                    <th>{{ $val->start ==1?'使用中':'冻结'}}</th>
                                    <th>{{$val->register_time}}</th>
                                    <th>{{$val->modify_time}}</th>
                                </tr>
                                @endforeach
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