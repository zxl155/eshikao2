@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="index" class="am-icon-home">首页</a></li>
        <li><a href="addcurr">添加课程</a></li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="dopplive" method="post">
                        {{ csrf_field() }}

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">课程 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="curriculum_id" id="select"  required>
                                  <option>--请选择--</option>
                                  @foreach($data as $key => $val)
                                  <option value="{{ $val['curriculum_id'] }}">{{ $val['curriculum_name'] }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">所属教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">名称 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="pplive_name" placeholder="请输入公告" required>
                            </div>
                        </div>        

                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">开始时间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input placeholder="请输入日期" name="start_time" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">结束时间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input placeholder="请输入日期" name="stop_time" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                            </div>
                        </div>
                      
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
<script type="text/javascript">
!function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    laydate({elem: '#demo'});//绑定元素
}();
</script>
<script type="text/javascript">
    $("#select").change(function(){
        var id = $("#select").val()
        $.ajax({
            url:'select',
            data:{id:id},
            type:'get',
            dataType:'json',
            success:function(data){
                var html = ""; 
                jQuery.each(data,function(key,value){
                    html+='<input type="radio" name="admin_id" value="'+value.admin_id+'"><span>'+value.admin_name+'</span>';  
                }) 
                $('#div').html(html);
            }
        })
    })
</script>
</html>