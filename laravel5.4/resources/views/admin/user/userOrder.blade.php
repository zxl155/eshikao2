@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="am-active">用户对应的所有购买课程</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 用户对应的所有购买课程
            </div>
        </div>
        <div class="tpl-block">
             <div class="am-g">
               <!--  <div class="am-u-sm-12 am-u-md-3">
                    
                    <div class="am-form-group">
                        <a href="{{ url('admin/userCurriculum?need=1') }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span> 点击查看需发货人员</a>
                    </div>
                    
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <form action="{{ url('admin/userCurriculum') }}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="user_tel"  placeholder="请输入用户手机号查询">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div> -->

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">ID</th>
                                    <th>手机号</th>
                                    <th>注册时间</th>
                                    <th>课程名称</th>
                                </tr>

                            </thead>
                            <tbody>
                               @foreach($data as $key=>$value)
                               <tr>
                                   <th>{{$value->user_id}}</th>
                                   <th>{{$value->user_tel}}</th>
                                   <th>{{$value->add_time}}</th>
                                   <th>{{$value->curriculum_name}}</th>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <div class="am-fr">
                                <div id="pull_right">
                                    <div class="pull-right">
                                        <div class="pull-right">
                                            {!! $data->render() !!}
                                        </div>
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
                
            </div>
        </div>
    </div>

    </div>

    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>