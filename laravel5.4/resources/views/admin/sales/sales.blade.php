@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程包管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">销售代理</a></li>
        <li class="am-active">销售代理管理</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span>销售代理列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
     
                    <div class="am-form-group">
                        <a href="{{url('admin/addSales')}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-pencil-square-o"></span>添加代理</a>
                    </div>
                    
                </div>
                
               <!--  <div class="am-u-sm-12 am-u-md-3">
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
                                    <th class="table-id">UID</th>
                                    <th class="table-title">手机号</th>
                                    <th class="table-type">姓名</th>
                                    <th class="table-title">渠道类型</th>
                                    <th>代理链接</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>
                                    <th>{{$value->user_id}}</th>
                                    <th>{{$value->sales_tel}}</th>
                                    <th>{{$value->sales_name}}</th>
                                    <th>{{$value->sales_channel}}</th>
                                    <th>http://www.eshikao.com/home/package?user_id={{$value->user_id}}</th>
                                    <th>{{$value->sales_time}}</th>
                                    <th>
                                        @if($value->sales_is == 1)
                                            开启
                                        @else
                                            禁用
                                        @endif
                                    </th>
                                    <th>
                                        <a href="{{url('admin/updSales')}}?sales_id={{$value->sales_id}}" onClick="return confirm('确定修改?');"">编辑</a>|
                                        <a href="{{url('admin/delSales')}}?sales_id={{$value->sales_id}}" onClick="return confirm('确定删除?');">删除</a>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
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
</body>
</html>