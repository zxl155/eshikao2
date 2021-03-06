@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">销售代理</a></li>
                <li class="am-active">添加课程包</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/addSaless') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">注册手机号<span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="sales_tel" placeholder="请输入注册手机号" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">姓名: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_name" placeholder="请输入姓名" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">身份证号: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_identity" placeholder="请输入身份证" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">开户行: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_bank" placeholder="请输入开户行" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">银行卡号: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_number" placeholder="请输入银行卡号" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">对接人员: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="name" placeholder="请输入对接人员" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">代理渠道: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="sales_channel">
                                          <option value="校园代理">校园代理</option>
                                          <option value="流量平台">流量平台</option>
                                          <option value="第三方支付平台">第三方支付平台</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">状态: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="sales_is">
                                          <option value="1">启用</option>
                                          <option value="0">禁止</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">推荐课程包: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="course_id">
                                         @foreach($course as $val)
                                          <option value="{{$val->course_id}}">{{$val->course_name}}</option>
                                         @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">代理人简介: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <textarea name="sales_content"></textarea>
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