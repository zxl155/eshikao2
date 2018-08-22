@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">课程管理</a></li>
         <li class="am-active">添加课程包</li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="{{ url('admin/curriculumCourses') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="am-form-group">
                            <label for="curriculum-pricture" class="am-u-sm-3 am-form-label">课程包图片<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="file" class="tpl-form-input" name="curriculum_pricture" placeholder="请选择图片" required><br/>
                                <input type="text" class="tpl-form-input" name="video" placeholder="如需免费试听请输入百家云链接">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">课程包名称 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="curriculum_name" placeholder="请输入课程名称" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="purchase_number" class="am-u-sm-3 am-form-label">课程包限购人数 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="number" class="tpl-form-input" name="purchase_number" placeholder="请输入限购人数" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="present_price" class="am-u-sm-3 am-form-label">课程包价格<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="present_price" placeholder="请输入现价" required>
                            </div>
                        </div>
                         <div class="am-form-group">
                            <label for="purchase_state_time" class="am-u-sm-3 am-form-label">课程包限购开始时间 <span class="tpl-form-line-small-title"></span></label>
                             <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id="purchase_state_time"  name="purchase_state_time" class="laydate-icon" onClick="laydate({elem: '#purchase_state_time',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="purchase_end_time" class="am-u-sm-3 am-form-label">课程包限购结束时间 <span class="tpl-form-line-small-title"></span></label>
                             <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id="purchase_end_time" name="purchase_end_time"  name="purchase_end_time" class="laydate-icon" onClick="laydate({elem: '#purchase_end_time',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                            </div>
                        </div>
                         <div class="am-form-group">
                            <label for="notice" class="am-u-sm-3 am-form-label">展示标签 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="notice" placeholder="请输入标签" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="original_price" class="am-u-sm-3 am-form-label">考试类型 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="teacher_type">
                                     <option value="0">--请选择--</option>
                                    <option value="1">教师资格证</option>
                                    <option value="2">教师招聘</option>
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="original_price" class="am-u-sm-3 am-form-label">课程类型 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="type_id">
                                    <option value="0">--请选择--</option>
                                    @foreach($cattype_content as $val)
                                    <option value="{{$val->type_id}}">{{$val->type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">

                            <label for="original_price" class="am-u-sm-3 am-form-label">学科 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <span class="label1_quan">全选</span><br/>
                                @foreach($subjecttype_content as $val)
                               <input type="checkbox" class="tpl-form-input1" name="subject_id[]" value="{{$val->subject_id}}">{{$val->subject_name}}
                               @endforeach
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="original_price" class="am-u-sm-3 am-form-label">学段 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <span class="label2_quan">全选</span><br/>
                                @foreach($gradetype_content as $val)
                               <input type="checkbox" class="tpl-form-input2" name="grade_id[]" value="{{$val->grade_id}}" >{{$val->grade_name}}
                               @endforeach
                            </div>
                        </div>
                         <div class="am-form-group">
                            <label for="original_price" class="am-u-sm-3 am-form-label">地区 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <span class="label3_quan">全选</span><br/>
                                @foreach($region_content as $val)
                               <input type="checkbox" class="tpl-form-input3" name="region_id[]" value="{{$val->region_id}}">{{$val->region_name}}
                               @endforeach
                            </div>
                        </div>
                         <div class="am-form-group">
                            <label for="present_price" class="am-u-sm-3 am-form-label">任课老师<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="admin_id">
                                    <option>--请选择--</option>
                                    @foreach($admin_teacher as $val)
                                    <option value="{{$val->admin_id}}">{{$val->nickname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- 是否为课程包 -->
                        <input type="hidden" name="is_course" value="1">
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type="submit" name="" value="提交" class="am-btn am-btn-primary tpl-btn-bg-color-success ">
                               
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
    <script type="text/javascript">
!function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    laydate({elem: '#demo'});//绑定元素
    laydate({elem: '#purchase_state_time'});//绑定元素
    laydate({elem: '#purchase_end_time'});//绑定元素
}();
</script>
<!-- ueditor-mz 配置文件 -->
<script type="text/javascript" src="{{asset('/')}}ueditor-mz/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="{{asset('/')}}ueditor-mz/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('ue-container');
    ue.ready(function(){
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
    });
 $(".label1_quan").click(function(){
    $(this).toggle(
        function(){
            $('.tpl-form-input1').attr('checked','checked');
            $(this).removeAttr('style');
        },
    );
 })
 $(".label2_quan").click(function(){
    $(this).toggle(
        function(){
            $('.tpl-form-input2').attr('checked','checked');
            $(this).removeAttr('style');
        },
    );
 })
  $(".label3_quan").click(function(){
    $(this).toggle(
        function(){
            $('.tpl-form-input3').attr('checked','checked');
            $(this).removeAttr('style');
        },
    );
 })
</script>
</body>
</html>