@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">教师直播列表</a></li>
        <li class="am-active">直播列表</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 教师直播列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    
                    <div class="am-form-group">
                        
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
                                    <th class="table-title">课程名称</th>
                                    <th class="table-title">直播名称</th>
                                    <th class="table-title">开始时间--结束时间</th>
                                    <th class="table-title">任课老师</th>
                                    <th class="table-title">助教</th>
                                    <th class="table-title">状态</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($data as $val)
                                <tr> 
                                  <th>{{$val->pplive_id}}</th>
                                  <th>{{$val->curriculum_name}}</th>
                                  <th>{{$val->pplive_name}}</th>
                                  <th>{{$val->start_time}}--{{$val->end_time}}</th>
                                  <th>
                                    
                                    
                                        {{$val->admin_name}}
                                      
                                  </th>
                                  <th>
                                      @if($val->assistant_admin_id == '')

                                      @else 
                                        {{$val->assistant_admin_name}}
                                      @endif
                                  </th>
                                  <th class="table-title">
                                    @if($val->date_time < $val->start_time)
                                    <span style="color: blue">未开始</span>
                                    @elseif($val->date_time > $val->end_time)
                                    <span style="color: red">已结束</span>
                                    @else
                                    <span style="color: green">直播中</span>
                                    @endif
                                  </th>
                                  <th>
                                    @if($val->date_time < $val->start_time)
                                    <span>未开始</span>
                                    @elseif($val->date_time > $val->end_time)
                                    <a href="{{url('admin/playback')}}?pplive_id={{$val->pplive_id}}">直播回放</a>
                                    @else
                                    @if($val->admin_id == $val->admins_id)
                                      <a href="{{url('admin/teacherLives')}}?pplive_id={{$val->pplive_id}}">开始直播</a>
                                       
                                      @else 
                                        <a href="">助教入口</a>
                                      @endif
                                    @endif



                                     
                                    
                                  </th>
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