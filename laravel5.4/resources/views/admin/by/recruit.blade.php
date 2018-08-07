@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程包管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">课程排序</a></li>
        <li class="am-active">PC教师招聘排序</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span>PC教师招聘排序列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">课程名称</th>
                                    <th class="table-type">排序</th>
                                    <th>操作</th>
                                    <th>是否为首页</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($curriculum as $value)
                                <form action="{{ url('admin/recruitPCSearch') }}" method="post">
                                    {{ csrf_field() }}
                                    <tr>
                                        <th>{{$value->curriculum_id}}<input type="hidden" name="curriculum_id" value="{{$value->curriculum_id}}"></th>
                                        <th>{{$value->curriculum_name}}</th>
                                        <th><input type="text" name="order_by" value="{{$value->order_by}}" style="background:pink"></th>
                                        <th><input type="submit" style="color: blue" value="修改"></th>
                                         <th>
                                            @if($value->home_page=='0')
                                                <span style="color: red">否</span>(<a href="recruitHomePage?curriculum_id={{$value->curriculum_id}}"  style="color:blue">点击</a>进行修改)
                                            @else
                                                <span style="color:blue">是</span>(<a href="recruitHomePage?curriculum_id={{$value->curriculum_id}}" style="color:blue">点击</a>进行修改)
                                            @endif
                                        </th>
                                    </tr>
                                </form>
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