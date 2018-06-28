@include('common/header')
@include('UEditor::head')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <ol class="am-breadcrumb">
                <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
                <li><a href="#">添加公告</a></li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/dorecr') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">标题 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="recruitment_name" placeholder="请输入名称" required>
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
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">选择文件1 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="file" class="tpl-form-input" name="recruitment_file">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">选择文件2 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="file" class="tpl-form-input" name="recruitment_files">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">选择文件3 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="file" class="tpl-form-input" name="recruitment_filess">
                                    </div>
                                </div>
                               <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">内容</label>
                            <div class="am-u-sm-9">
                                <!-- 加载编辑器的容器 -->
                                <script id="ue-container" name="content"  type="text/plain">
                               
                                </script>
                                <!-- 上述的 php 代码是根据实际需求进行的编写，该处为初始化内容的位置-->
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
</script>
</html>