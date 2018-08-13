@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="am-active">用户添加课程</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/userCurriculumAdds') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">学员手机号 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="number" class="tpl-form-input" name="user_tel" placeholder="请输入学员手机号" required>
                                    </div>
                                </div>
                                <div>
                                     <label for="user-name" class="am-u-sm-3 am-form-label">是否计入统计<span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <select name="is_statistics">
                                            <option value="0">不需要</option>
                                            <option value="1">需要</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                     <label for="user-name" class="am-u-sm-3 am-form-label">是否需要发货<span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <select name="is_consignor">
                                            <option value="0">不需要</option>
                                            <option value="1">需要</option>
                                        </select>
                                    </div>
                                </div>
                               <input type="hidden" name="curriculum_id" value="{{$curriculum_id}}">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">收件人姓名 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="address_name" placeholder="请输入收件人姓名" >
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">收件人手机号 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="number" class="tpl-form-input" name="address_tel" placeholder="请输入收件人手机号" >
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">收件人详细地址 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="address_detailed" placeholder="请输入收件人详细地址" >
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">添加</button>
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