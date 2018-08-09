@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">课程管理</a></li>
        <li class="am-active">直播列表</li>
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
                        <a href="{{ url('admin/addpplive') }}?curriculum_id={{$curriculum_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 添加直播</a>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <a href="{{url('admin/copyPplive')}}?curriculum_id={{$curriculum_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span>复制直播间</a>
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
                                    <th class="table-title">直播课程名称</th>
                                    <th class="table-title">学员入口</th>
                                    <th>伪直播room_id</th>
                                    <th>伪直播session_id</th>
                                    <th>点播ID</th>
                                    <th class="table-type">开始时间-结束时间</th>
                                    <th class="table-type">直播类型</th>
                                    <th class="table-title">任课老师</th>
                                    <th class="table-title">助教</th>
                                    <th class="table-title">直播间</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody> 
                               @foreach($data as $val)
                               <tr>
                                    <th>{{$val->pplive_id}}</th>
                                    <th>{{$val->pplive_name}}</th>
                                    <th>{{$val->entrance}}</th>
                                    <th>{{$val->playback_room_id}}</th>
                                    <th>{{$val->playback_session_id}}</th>
                                    <th>{{$val->demand_id}}</th>
                                    <th>{{$val->start_time}}--{{$val->end_time}}</th>
                                    <th>
                                        @if($val->type==1)
                                            一对一课
                                        @elseif($val->type==2)
                                            普通大班课
                                        @elseif($val->type==3)
                                            小班课普通版
                                        @elseif($val->type==5)
                                            伪直播
                                        @elseif($val->type==6)
                                            点播
                                        @else
                                            未设定
                                        @endif
                                    </th>
                                    <th>{{$val->admin_name}}</th>
                                    <th>{{$val->assistant_admin_name}}</th>
                                    <th>
                                        @if($val->start_date_time < $val->start_time)
                                        <span>未开始</span>
                                        @elseif($val->date_time > $val->end_time)
                                        <a href="{{url('admin/playback')}}?pplive_id={{$val->pplive_id}}">直播回放</a>
                                        @else
                                            <a href="{{url('admin/Assistant')}}?pplive_id={{$val->pplive_id}}">进入直播间</a>
                                        @endif
                                    </th>
                                    <th> 
                                        <a href="{{URL::asset('admin/updpplive')}}?pplive_id={{$val->pplive_id}}&curriculum_id={{$curriculum_id}}">编辑</a> 
                                        <a href="{{URL::asset('admin/delpplive')}}?pplive_id={{$val->pplive_id}}&curriculum_id={{$curriculum_id}}" onclick="if(confirm('确实要删除数据吗？')) return true;else return false;">删除</a></th>
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
        <div class="tpl-alert"></div>
    </div>

    </div>

    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>