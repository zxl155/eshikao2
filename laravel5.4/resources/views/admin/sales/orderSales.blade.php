@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程包管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">销售代理</a></li>
        <li class="am-active">代理订单</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span>代理订单列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                 <div class="am-u-sm-12 am-u-md-3">
                    <form action="{{url('admin/orderSales')}}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="search" value="" class="am-form-field" placeholder="请输入代理人手机号">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                    </form>
                </div> 
            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>代理商姓名</th>
                                    <th>推荐人注册电话</th>
                                    <th>购买用户</th>
                                    <th>支付时间</th>
                                    <th>支付渠道</th>
                                    <th>支付金额</th>
                                    <th>课程名称</th>
                                    <th>收益金额</th>
                                    <th>收益状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order as $value)
                               <tr>
                                  <th>{{$value->sales_name}}</th>
                                  <th>{{$value->sales_user_tel}}</th>
                                  <th>{{$value->user_tel}}</th>
                                  <th>{{$value->order_time}}</th>
                                  <th>H5</th>
                                  <th>{{$value->order_money}}</th>
                                  <th>{{$value->curriculum_name}}</th>
                                  <th></th>
                                  <th>可提现</th>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <hr>
                </div>
            </div>
        </div>
        <div class="tpl-alert"></div>
    </div>
    </div>
    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
</body>
</html>