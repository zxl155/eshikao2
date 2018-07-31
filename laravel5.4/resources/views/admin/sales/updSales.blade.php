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
                            <form class="am-form tpl-form-line-form" action="{{ url('admin/updSaless') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">注册手机号<span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="sales_tel" value="{{$data[0]->sales_tel}}" placeholder="请输入注册手机号" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">姓名: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_name" placeholder="请输入姓名" value="{{$data[0]->sales_name}}" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">身份证号: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_identity" placeholder="请输入身份证" value="{{$data[0]->sales_identity}}" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">开户行: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_bank" placeholder="请输入开户行" value="{{$data[0]->sales_bank}}" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">银行卡号: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="sales_number" placeholder="请输入银行卡号" value="{{$data[0]->sales_number}}" required>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">对接人员: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <input type="text" class="tpl-form-input" name="name"  value="{{$data[0]->name}}" placeholder="请输入对接人员" required>
                                    </div>
                                </div>
                                 <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">代理渠道: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="sales_channel">
                                         @if($data[0]->sales_channel=="校园代理")
                                          <option value="校园代理" selected>校园代理</option>
                                          <option value="流量平台">流量平台</option>
                                          <option value="第三方支付平台">第三方支付平台</option>
                                          @elseif($data[0]->sales_channel=="流量平台")
                                           <option value="校园代理">校园代理</option>
                                          <option value="流量平台" selected>流量平台</option>
                                          <option value="第三方支付平台">第三方支付平台</option>
                                          @else
                                           <option value="校园代理">校园代理</option>
                                          <option value="流量平台">流量平台</option>
                                          <option value="第三方支付平台" selected>第三方支付平台</option>
                                          @endif
                                      </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">状态: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="sales_is">
                                        @if($data[0]->sales_is=="1")
                                          <option value="1" selected>启用</option>
                                          <option value="0">禁止</option>
                                        @else
                                         <option value="1">启用</option>
                                          <option value="0" selected>禁止</option>
                                        @endif
                                      </select>
                                    </div>
                                </div>
                                <input type="hidden" name="sales_id" value="{{$data[0]->sales_id}}">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">推荐课程包: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                      <select name="course_id">
                                         @foreach($course as $val)
                                         <option value="{{$val->course_id}}"
                                          @if($val->course_id == $data[0]->course_id)
                                          selected
                                          @endif
                                          >{{$val->course_name}}</option>
                                         @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">代理人简介: <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                       <textarea name="sales_content">{{$data[0]->sales_content}}</textarea>
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
</html>