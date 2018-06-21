@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="{{ url('admin/addcurr') }}">添加课程</a></li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="{{ url('admin/docurr') }}" method="post">
                        {{ csrf_field() }}
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">课程名称 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="curriculum_name" placeholder="请输入课程名称" required>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">类别 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="type_id"  required>
                                  <option>--请选择--</option>
                                  @foreach($cat as $key => $val)
                                  <option value="{{ $val['type_id'] }}">{{ $val['type_name'] }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">类型 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="teacher_type"  required>
                                  <option>--请选择--</option>
                                  <option value="1">教师资格</option>
                                  <option value="2">教师招聘</option>
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">学段 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="grade_id" required>
                                  <option>--请选择--</option>
                                  @foreach($grade as $key => $val)
                                  <option value="{{ $val['grade_id'] }}">{{ $val['grade_name'] }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">学科 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <select name="subject_id"  required>
                                  <option>--请选择--</option>
                                  @foreach($subject as $key => $val)
                                  <option value="{{ $val['subject_id'] }}">{{ $val['subject_name'] }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">地区 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                
                                <select name="region_id"  required>
                                  <option>--请选择--</option>
                                  @foreach($region as $key => $val)
                                    <option value="{{ $val['region_id'] }}">{{ $val['region_name'] }}</option>
                                  @endforeach
                                </select>
                                
                            </div>
                        </div>        

                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">开始时间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input placeholder="请输入日期" name="start_time" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">课程公告 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="notice" placeholder="请输入公告" required>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">课程价格 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="money" placeholder="请输入价格" required>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">授课教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                @foreach($teacher as $key => $val)
                                    <input type="checkbox" name="admin_id[]" value="{{ $val->admin_id }}">{{ $val->admin_name }}
                                @endforeach
                            </div>
                        </div>

                        

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">总数量 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" name="stock_number" placeholder="请输入数量" required>
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
</html>