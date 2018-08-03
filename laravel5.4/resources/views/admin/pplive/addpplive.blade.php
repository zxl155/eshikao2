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
                    <form class="am-form tpl-form-line-form" action="{{ url('admin/dopplive') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="curriculum_id" value="{{$curriculum_id}}">
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播课程名称 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="pplive_name" placeholder="请输入直播课程名称" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="recovery_original" class="am-u-sm-3 am-form-label">直播开始时间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id='demo'   name="start_time" class="laydate-icon" onClick="laydate({elem: '#demo',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="purchase_state_time" class="am-u-sm-3 am-form-label">直播结束时间 <span class="tpl-form-line-small-title"></span></label>
                             <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id="purchase_state_time"  name="end_time" class="laydate-icon" onClick="laydate({elem: '#purchase_state_time',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播类型<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="type" class="wei">
                                    <option value="2">普通大班课</option>
                                    <option value="1">一对一课</option>
                                    <option value="3">小班课普通版</option>
                                    <option value="5">伪直播</option>
                                </select>
                            </div>
                        </div>
                        <div class="am-form-room" style="display: none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播回放room_id <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="playback_room_id" placeholder="请输入直播回放room_id">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">任课教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="admin_id">
                                    @foreach($admin_teacher as $value)
                                    <option value="{{$value->admin_id}}">{{$value->nickname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">助教教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="assistant_admin_id">
                                    @foreach($admin_teacher as $value)
                                    <option value="{{$value->admin_id}}">{{$value->nickname}}</option>
                                    @endforeach
                                </select>
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
$('.wei').change(function(){
    var type = $('.wei option:checked').val();
    if (type==5) {
        $('.am-form-room').removeAttr('style');
    } else {
        $('.am-form-room').attr('style',"display: none");
    }
})
</script>
</html>