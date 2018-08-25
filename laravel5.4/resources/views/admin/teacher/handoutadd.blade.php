@include('common/header')
<div class="tpl-content-wrapper">
        <div class="tpl-content-page-title">
        易师考
        </div>
        <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">教室直播列表</a></li>
        <li class="am-active">讲义添加</li>
        </ol>
        <div class="tpl-portlet-components">
        <div class="tpl-block">

            <div class="am-g">
                <div class="tpl-form-body tpl-form-line">
                    <form class="am-form tpl-form-line-form" action="{{ url('admin/handoutadds') }}" method="post"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="pplive_id" value="{{$pplive_id}}">    
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">上传讲义 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9" id="div">
                                <input type="file" name="jianyi">
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