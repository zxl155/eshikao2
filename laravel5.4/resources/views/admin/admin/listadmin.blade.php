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
                                            <th class="table-title">姓名</th>
                                            <th class="table-type">头像</th>
                                            <th class="table-type">昵称</th>
                                            <th class="table-type">性别</th>
                                            <th class="table-type">手机号</th>
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
                                            <td><img src="{{URL::asset('/')}}/{{ $val->admin_head }}" height="30px"></td>
                                            <td>{{ $val->nickname }}</td>
                                            <td>{{ $val->admin_sex ==1?'男':'女'}}</td>
                                            <td>{{ $val->admin_phone }}</td>
                                            <td>{{ $val->register_time }}</td>

                                            <td>{{ $val->admin_desc }}</td>
                                            <td>{{ $val->start ==1?'使用中':'已冻结'}}</td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <button data-id="{{ $val->admin_id }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
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
    <script type="text/javascript">
        $(".am-btn").click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url:'del',
                data:{id:id},
                type:'get',
                success:function(data){
                    if(data == 1){
                        var txt=  "删除成功";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                        location.href = 'listadmin';
                    }else if(data ==3){
                        var txt=  "不能删除自己";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                        return false;
                    }else {
                        var txt=  "删除失败";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                        return false;
                    }
                }
            })
        })
    </script>
</html>