@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li class="am-active">修改管理员</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/adminUpdates') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="admin_id" value="{{$data[0]->admin_id}}">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">用户名 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="admin_name" placeholder="请输入姓名"  value="{{$data[0]->admin_name}}"  required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">昵称 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="nickname" placeholder="请输入昵称" value="{{$data[0]->nickname}}" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">真实姓名 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="realname" value="{{$data[0]->realname}}" placeholder="请输入真实名称" required>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">头像 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <div class="am-form-group am-form-file">
                                            
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 添加头像</button>
                                            <input id="doc-form-file" type="file" name="admin_head" value="{{$data[0]->admin_head}}" required>
                                        </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">性别 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        @if($data[0]->admin_sex == '1') 
                                        <input type="radio" class="tpl-form-input" name="admin_sex" required value="1" checked>男
                                        <input type="radio" class="tpl-form-input" name="admin_sex" required value="2">女
                                        @else
                                        <input type="radio" class="tpl-form-input" name="admin_sex" required value="1">男
                                        <input type="radio" class="tpl-form-input" name="admin_sex" required value="2" checked>女
                                        @endif
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">手机号 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="admin_phone" placeholder="请输入手机号" value="{{$data[0]->admin_phone}}" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">身份证 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="identity" value="{{$data[0]->identity}}" placeholder="请输入身份证" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">银行名称 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                         <input type="text" class="tpl-form-input" name="bank_name" placeholder="请输入银行名称" value="{{$data[0]->bank_name}}" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">银行账号 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                         <input type="text" class="tpl-form-input" name="bank_number" placeholder="请输入银行账号" value="{{$data[0]->bank_number}}" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">普通课时费/小时 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                         <input type="text" class="tpl-form-input" name="general_edition" placeholder="请输入课时费/小时" value="{{$data[0]->general_edition}}" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-intro" class="am-u-sm-3 am-form-label">个人简介</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="10" name="admin_desc" placeholder="请输入内容" required>{{$data[0]->admin_desc}}</textarea>
                                    </div>
                                </div> 
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">所属角色 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <select name="role_id">
                                        @foreach($role_content as $val)
                                           <option value="{{$val->role_id}}"
                                            @if($val->role_name == $data[0]->role_name)
                                            selected
                                            @endif
                                            required>{{$val->role_name}}</option>
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