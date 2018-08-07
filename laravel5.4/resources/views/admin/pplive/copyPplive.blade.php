@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="{{ url('admin/addcurr') }}">课程管理</a></li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="{{url('admin/copyPplives') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="curriculum_ids" value="{{$curriculum_id}}">
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">请选择课程 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               <select name="curriculum_id" class="curriculum_id">
                                    <option value="0">--请选择--</option>
                                    @foreach($curriculum as $value)
                                   <option value="{{$value->curriculum_id}}">{{$value->curriculum_id}}----{{$value->curriculum_name}}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">请选择直播间 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                               
                                   <span class="tbody">请选择课程</span>
                              
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">复制</button>
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
    $('.curriculum_id').change(function(){
       var curriculum_id = $('.curriculum_id option:selected').val();
       var tbody = $('.tbody');
       var html = '';
       if (curriculum_id != 0) {
            $.ajax({
                url:"{{URL::asset('admin/copySearch')}}",
                data:{curriculum_id:curriculum_id,_token:"{{ csrf_token() }}"},
                type:'get',
                dataType:'json',
                 success:function(data){
                    if (data == "无直播") {
                        tbody.html("无直播");
                    } else {
                        jQuery.each(data,function(key,value){
                            html+='<input type="checkbox" name="pplive_id[]" value='+value.pplive_id+'>'+value.pplive_name+'<br/>'
                        })
                        tbody.html(html);
                    }
                 }
            })
        } else {
            tbody.html("请选择课程");
        }
    })
</script>
</html>