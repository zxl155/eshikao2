@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/upds') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $data['admin_id'] }}" name="admin_id">
                                <div class="am-form-group">
                                    <label for="admin-name" class="am-u-sm-3 am-form-label">昵称 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="nickname"  placeholder="请输入正确姓名" value="{{ $data['nickname'] }}" required>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="admin-email" class="am-u-sm-3 am-form-label">头像 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <div class="am-form-group am-form-file">
                                        <button type="submit" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 添加头像</button>
                                            <input type="file" id="admin_head" name="admin_head" value="{{ $data['admin_head'] }}" required> <span>(请选择您真实的头像)</span>
                                        </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="admin-sex" class="am-u-sm-3 am-form-label">性别 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        @if($data->admin_sex == 1)
                                        <input type="radio" class="tpl-form-input" name="admin_sex" value="1"  checked>男
                                        <input type="radio" class="tpl-form-input" name="admin_sex" value="2"  >女
                                       @else
                                        <input type="radio" class="tpl-form-input" name="admin_sex" value="1" >男
                                        <input type="radio" class="tpl-form-input" name="admin_sex" value="2" checked >女
                                       @endif
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="admin-phone" class="am-u-sm-3 am-form-label">手机号 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="admin_phone"  placeholder="请输入正确手机号" value="{{ $data['admin_phone'] }}" required>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="admin-name" class="am-u-sm-3 am-form-label">简介 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" placeholder="请输入您的个性简介" name="admin_desc" value="{{ $data['admin_desc'] }}" required>
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
<script type="text/javascript"></script>
</html>