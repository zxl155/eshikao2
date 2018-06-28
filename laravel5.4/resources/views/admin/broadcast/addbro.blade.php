@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">添加轮播图</a></li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/dobro') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                
                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">轮播图 <span class="tpl-form-line-small-title"></span></label>
                                <div class="am-u-sm-9">
                                        <div class="am-form-group am-form-file">
                                            
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 添加轮播图</button>
                                            <input id="doc-form-file" type="file" name="broadcast_url">
                                        </div>
                                </div>
                                
                                <div class="am-form-group">
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">选择课程 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9" id="div">
                                        <select name="curriculum_id">
                                          @foreach($data as $val)
                                          <option value="{{$val->curriculum_id}}">{{$val->curriculum_name}}</option>
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
</html>