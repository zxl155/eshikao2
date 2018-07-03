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
                        <input type="text" name="search" value="" class="am-form-field">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                   
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">编号</th>
                                    <th class="table-title">课程图片</th>
                                    <th class="table-type">课程名称</th>
                                    <th class="table-title">考试类型</th>
                                    <th class="table-title">展示类型</th>
                                    <th class="table-title">状态</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody> 
                                @foreach($curriculum_content as $value)
                                <tr>
                                    <th>{{$value->curriculum_id}}</th>
                                    <th> 
                                        <img src="{{URL::asset('/')}}home/img/curriculum_pricture/{{$value->curriculum_pricture}}" width="100px" height="100px" alt="">
                                    </th>
                                    <th>{{$value->curriculum_name}}</th>
                                    <th>
                                        @if($value->teacher_type == 1)
                                            <span>教师资格证</span>
                                        @else
                                            <span>教师招聘</span>
                                        @endif
                                    </th>
                                    <th>课程</th>
                                    <th>
                                        @if($value->state == 1)
                                        <button style="background: green" class="shelf" value="1" curriculum_id = "{{$value->curriculum_id}}">已上架</button>
                                        @else
                                        <button style="background: red" class="shelf" value="0" curriculum_id = "{{$value->curriculum_id}}">未上架</button>
                                        @endif
                                    </th>
                                    <th><a href="{{URL::asset('home/coursedetails')}}?curriculum_id={{$value->curriculum_id}}">课程预览</a>
                                        <a href="{{URL::asset('admin/listpplive')}}?curriculum_id={{$value->curriculum_id}}">直播课程列表</a>
                                        <a href="{{URL::asset('admin/updcurr')}}?curriculum_id={{$value->curriculum_id}}">编辑</a>
                                        <a onclick="if(confirm('确实要删除数据吗？')) return true;else return false;" href="{{URL::asset('admin/delcurr')}}?curriculum_id={{$value->curriculum_id}}" >删除</a>
                                    </th>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <div class="am-fr">
                                <div id="pull_right">
                                    <span>当前总课程<span style="color: red">{{$count}}</span>条</span>
                                    <div class="pull-right">
                                       {!! $curriculum_content->render() !!}
                                    </div>
                                </div>
                            </div>
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
        $(".shelf").click(function(){
            var state = $(this).attr('value');
            var curriculum_id = $(this).attr('curriculum_id');
            if(confirm("请确认是否上下架课程！")){
                $.ajax({
                    url:"{{URL::asset('admin/shelf')}}",
                    data:{state:state,curriculum_id:curriculum_id,_token:"{{csrf_token()}}"},
                    type:'get',
                    dataType:"json",
                    success:function(data){
                        if (data.state == "修改成功") {
                            var txt=  "课程状态修改成功";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                            window.location.reload();
                        } else {
                            var txt=  "课程状态修改失败";
                            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                            window.location.reload();
                        }
                    }
                })
            }
            
        })
    </script>
</body>
</html>