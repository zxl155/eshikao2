@include('common/header')

        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                管理员管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li class="am-active">管理员列表</li>
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
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-u-md-3">
                            
                        </div>
                        <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-input-group am-input-group-sm">
                                
                            </div>
                        </div>
                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <form class="am-form">
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-id">ID</th>
                                            <th class="table-title">用户名</th>
                                            <th class="table-type">头像</th>
                                            <th class="table-type">昵称</th>
                                            <th class="table-type">真实名称</th>
                                            <th class="table-type">性别</th>
                                            <th class="table-type">手机号</th>
                                            <th class="table-type">身份证</th>
                                            <th class="table-type">银行名称</th>
                                            <th class="table-type">银行账号</th>
                                            <th class="table-type">课时费/小时</th>
                                            <th class="table-type">所属角色</th>
                                            <th class="table-type">注册时间</th>
                                            <th class="table-type">简介</th>
                                            <th class="table-type">是否冻结</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key =>$val)
                                        <tr>
                                            <td>{{ $val->admin_id }}</td>
                                            <td>{{ $val->admin_name }}</td>
                                            <td><img src="{{URL::asset('/')}}home/img/admin_head/{{ $val->admin_head }}" height="30px"></td>
                                            <td>{{ $val->nickname }}</td>
                                            <td>{{ $val->realname }}</td>
                                            <td>{{ $val->admin_sex ==1?'男':'女'}}</td>
                                            <td>{{ $val->admin_phone }}</td>c
                                            <td>{{ $val->identity }}</td>
                                            <td>{{ $val->bank_name }}</td>
                                            <td>{{ $val->bank_number }}</td>
                                            <td>{{ $val->general_edition }}</td>
                                            <td>{{ $val->role_name}}</td>
                                            <td>{{ $val->register_time }}</td>
                                            <td>{{ $val->admin_desc }}</td>
                                            <td>{{ $val->start ==1?'使用中':'已冻结'}}</td>
                                            <td>
                                                @if($val->role_id != '1')
                                                 <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a href="{{URL::asset('admin/adminUpdate')}}?admin_id={{ $val->admin_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span>编辑</a>
                                                    </div>
                                                </div>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a href="{{URL::asset('admin/del')}}?admin_id={{ $val->admin_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="if(confirm('确实要删除数据吗？')) return true;else return false;"><span class="am-icon-trash-o"></span>删除</a>
                                                    </div>
                                                </div>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a href="{{URL::asset('admin/updates')}}?admin_id={{ $val->admin_id }}&start={{ $val->start }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="if(confirm('确实要修改状态吗？')) return true;else return false;">修改状态</a>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="am-cf">

                                    <div class="am-fr">
                                        <div id="pull_right">
                                            <div class="pull-right">
                                               {!! $data->render() !!}
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