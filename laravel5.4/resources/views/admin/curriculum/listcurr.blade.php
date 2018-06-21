@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">课程管理</a></li>
        <li class="am-active">课程列表</li>
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
                        <a href="{{ url('admin/addcurr') }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 添加课程</a>
                    </div>
                    
                </div>
                
                <div class="am-u-sm-12 am-u-md-3">
                    <form action="listcurr" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="search" value="{{$search == null ? '' : $search}}" class="am-form-field">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">编号</th>
                                    <th class="table-title">名称</th>
                                    <th class="table-type">时间</th>
                                    <th class="table-title">有效期</th>
                                    <th class="table-title">公吿</th>
                                    <th class="table-title">价格</th>
                                    <th class="table-title">状态</th>
                                    <th class="table-title">数量</th>
                                    <th class="table-title">已购</th>
                                    <th class="table-title">所属教师</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody> 
                                @foreach($data as $key=>$val)
                                <tr>
                                    <td>{{ $val->curriculum_id }}</td>
                                    <td>{{ $val->curriculum_name }}</td>
                                    <td>{{ $val->start_time }}</td>
                                    <td>{{ $val->effective }}</td>
                                    <td>{{ $val->notice }}</td>
                                    <td>{{ $val->money }}</td>
                                    <td>{{ $val->state ==1?'已开启':'已下线' }}</td>
                                    <td>{{ $val->stock_number }}</td>
                                    <td>{{ $val->bought_number }}</td>
                                    <td>@foreach($admin as $values)
                                        @if($val->curriculum_id == $values->curriculum_id)
                                            {{$values->admin_name}}</br>
                                        @endif
                                    @endforeach</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{ url('admin/updcurr') }}?id={{ $val->curriculum_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 修改</a>
                                                <a href="{{ url('admin/delcurr') }}?id={{ $val->curriculum_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 删除</a>
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
                                    <span>当前总课程{{ $num == null ? 1 : $num }}条</span>
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