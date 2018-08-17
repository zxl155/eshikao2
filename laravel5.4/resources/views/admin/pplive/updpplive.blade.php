@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="{{ url('admin/addcurr') }}">修改直播课程</a></li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="{{ url('admin/updspplive') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="pplive_id" value="{{$data[0]->pplive_id}}">
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播课程名称 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="pplive_name" placeholder="请输入直播课程名称" value="{{$data[0]->pplive_name}}" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="recovery_original" class="am-u-sm-3 am-form-label">直播开始时间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id='demo'   name="start_time" class="laydate-icon" onClick="laydate({elem: '#demo',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="{{$data[0]->start_time}}" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="purchase_state_time" class="am-u-sm-3 am-form-label">直播结束时间 <span class="tpl-form-line-small-title"></span></label>
                             <div class="am-u-sm-9">
                                <input placeholder="请输入日期" id="purchase_state_time"  name="end_time" class="laydate-icon" onClick="laydate({elem: '#purchase_state_time',istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="{{$data[0]->end_time}}" required>
                            </div>
                        </div>
                         <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播类型<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="type"  class="wei">
                                    <option value="2" @if($data[0]->type == 2)
                                                            selected
                                                      @endif
                                        >普通大班课</option>
                                    <option value="1" @if($data[0]->type == 1)
                                                            selected
                                                      @endif
                                    >一对一课</option>
                                    <option value="3"@if($data[0]->type == 3)
                                                        selected
                                                      @endif
                                    >小班课普通版</option>
                                    <option value="5"@if($data[0]->type == 5)
                                                        selected
                                                      @endif
                                    >伪直播</option>
                                     <option value="6"@if($data[0]->type == 6)
                                                        selected
                                                      @endif
                                    >点播</option>
                                </select>
                            </div>
                        </div>  
                        <div class="am-form-group">
                            <label for="purchase_state_time" class="am-u-sm-3 am-form-label">是否免费<span class="tpl-form-line-small-title"></span></label>
                             <div class="am-u-sm-9">
                               <select name="is_free">
                                    <option value="0"@if($data[0]->is_free == 0)
                                                        selected
                                                      @endif>付费</option>
                                    <option value="1" @if($data[0]->is_free == 1)
                                                        selected
                                                      @endif>免费</option>
                               </select>
                            </div>
                        </div>
                        <div class="am-form-room" style="display: none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播回放room_id <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="playback_room_id" value="{{$data[0]->playback_room_id}}" placeholder="请输入直播回放room_id">
                            </div>
                        </div>
                        <div class="am-form-room" style="display: none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">直播回放session_id <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="playback_session_id" value="{{$data[0]->playback_session_id}}" placeholder="请输入直播回放session_id">
                            </div>
                        </div>
                        <div class="am-form-rooms" style="display: none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">点播ID <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="demand_id" value="{{$data[0]->demand_id}}" placeholder="请输入点播ID">
                            </div>
                        </div>
                         <div class="am-form-rooms" style="display: none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">点播回放地址 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <input type="text" name="demand_address" value="{{$data[0]->demand_address}}" placeholder="请输入点播回放地址">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">任课教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="admin_id">
                                    @foreach($admin_teacher as $value)

                                    <option value="{{$value->admin_id}}"
                                        @if($data[0]->admin_id==$value->admin_id)
                                        selected
                                        @endif
                                        >{{$value->nickname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="curriculum_id" value="{{$curriculum_id}}">
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">助教教师 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <select name="assistant_admin_id">
                                    @foreach($admin_teacher as $value)
                                    <option value="{{$value->admin_id}}"
                                         @if($data[0]->assistant_admin_id==$value->admin_id)
                                        selected
                                        @endif
                                        >{{$value->nickname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>      
                      
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">修改</button>
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
            url:"{{ url('admin/selects') }}",
            data:{id:id},
            type:'get',
            dataType:'json',
            success:function(data){
                var html = ""; 
                jQuery.each(data,function(key,value){
                    html+='<input type="radio" name="admin_id" value="'+value.admin_id+'"><span>'+value.nickname+'</span>';  
                }) 
                $('#div').html(html);
            }
        })
    })
</script>
<script type="text/javascript">
     var type = $('.wei option:checked').val();
     if (type == 5) {
        $('.am-form-room').removeAttr('style');
     }
     if (type == 6) {
        $('.am-form-rooms').removeAttr('style');
     }
    $('.wei').change(function(){
        var type = $('.wei option:checked').val();
        if (type==5) {
            $('.am-form-room').removeAttr('style');
        } else {
            $('.am-form-room').attr('style',"display: none");
        }
        if (type==6) {
        $('.am-form-rooms').removeAttr('style');
        } else {
            $('.am-form-rooms').attr('style',"display: none");
        }
    })
</script>
</html>