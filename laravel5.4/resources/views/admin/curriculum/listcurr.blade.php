@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="index" class="am-icon-home">首页</a></li>
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
                        <select data-am-selected="{btnSize: 'sm'}">
                          <option value="0">请选择教师</option>
                          @foreach($arr as $key => $val)
                            <option value="{{ $val['tea_id'] }}">{{ $val['tea_name'] }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field">
                        <span class="am-input-group-btn">
    <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
  </span>
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
                                    <th class="table-title">名称</th>
                                    <th class="table-type">标题</th>
                                    <th class="table-title">时间介绍</th>
                                    <th class="table-title">时间</th>
                                    <th class="table-title">教师</th>
                                    <th class="table-title">公告</th>
                                    <th class="table-title">价格</th>
                                    <th class="table-title">数量</th>
                                    <th class="table-title">库存</th>
                                    <th class="table-date am-hide-sm-only">时间</th>
                                    <th class="table-set">操作</th>
                                </tr>

                            </thead>
                            <tbody> @foreach($data as $key=>$val)
                                <tr>
                                    <td>{{ $val['curriculum_id'] }}</td>
                                    <td>{{ $val['curriculum_name'] }}</td>
                                    <td>{{ $val['curriculum_title'] }}</td>
                                    <td>{{ $val['curriculum_desc'] }}</td>
                                    <td>{{ $val['curriculum_time'] }}</td>
                                    <td>{{ $val['tea_id'] }}</td>
                                    <td>{{ $val['curriculum_notice'] }}</td>
                                    <td>{{ $val['curriculum_price'] }}</td>
                                    <td>{{ $val['curriculum_num'] }}</td>
                                    <td>{{ $val['curriculum_stock'] }}</td>
                                    <td>{{ $val['add_time'] }}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                                <button data-id="{{ $val['curriculum_id'] }}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" ><span class="am-icon-trash-o"></span> 删除</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                  @endforeach
                                
                            </tbody>
                        </table>
                        <div class="am-cf">

                            <div class="am-fr">
                                <ul class="am-pagination tpl-pagination">
                                    <li class="am-disabled"><a href="#">«</a></li>
                                    <li class="am-active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">»</a></li>
                                </ul>
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
                url:'delcurr',
                data:{id:id},
                type:'get',
                success:function(data){
                    if(data == 1){
                        var txt=  "删除成功";
                        window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                        location.href = 'listcurr';
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