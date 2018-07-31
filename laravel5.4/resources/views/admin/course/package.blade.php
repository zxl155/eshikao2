@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程包管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">销售代理</a></li>
        <li class="am-active">课程包</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span>课程包列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
     
                    <div class="am-form-group">
                        <a href="{{ url('admin/addPackage') }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span>添加课程包</a>
                    </div>
                    
                </div>
                
                <!-- <div class="am-u-sm-12 am-u-md-3">
                    <form action="listcurr" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="search" value="" class="am-form-field">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div> -->

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">课程包标题</th>
                                    <th class="table-type">代理课程ID</th>
                                    <th class="table-title">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $val)
                               <tr>
                                    <th class="table-id">{{$val->course_id}}</th>
                                    <th class="table-title">{{$val->course_name}}</th>
                                    <th class="table-type">{{$val->curriculum_id}}</th>
                                    <th class="table-title"><span><a href="{{url('admin/updatePackage')}}?course_id={{$val->course_id}}" onClick="return confirm('确定修改?');">修改</a></span>|<span><a href="{{url('admin/delPackage')}}?course_id={{$val->course_id}}" onClick="return confirm('确定删除?');">删除</a></span></th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <!-- <div class="am-fr">
                                <div id="pull_right">
                                    <span>当前总课程包<span style="color: red"></span>条</span>
                                    <div class="pull-right">
                                       
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <hr>

                   
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
    <script>
    </script>
</body>
</html>