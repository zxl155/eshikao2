@include('common/header')

<div class="tpl-content-wrapper">
    <div class="tpl-content-page-title">
        课程管理
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('admin/index') }}" class="am-icon-home">首页</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="am-active">用户对应的课程</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 展示用户对应的课程
            </div>
        </div>
        <div class="tpl-block">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                
                                <tr>
                                    <th class="table-id">编号</th>
                                    <th>订单号</th>
                                    <th>下单时间</th>
                                    <th class="table-title">手机号</th>
                                    <th>课程名称</th>
                                    <th>课程价格</th>
                                    <th>收货姓名</th>
                                    <th>收货地址</th>
                                    <th>快递单号(以发货请输入订单号)</th>
                                    <th>请选择快递</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>
                                    <th>{{$value->order_id}}</th>
                                    <th>{{$value->order_number}}</th>
                                    <th>{{$value->order_time}}</th>
                                    <th>{{$value->address_tel}}</th>
                                    <th>{{$value->curriculum_name}}</th>
                                    <th>{{$value->order_money}}</th>
                                    <th>{{$value->address_name}}</th>
                                    <th>{{$value->address_detailed}}</th>
                                    <th><input class="invoice" value="{{$value->invoice_number}}" order_id='{{$value->order_id}}' placeholder="请输入物流单号" style="background: pink"></th>
                                    <th>
                                        <select style="font-size: 10px" class="invoices" order_id='{{$value->order_id}}'>
                                            <option value="" @if($value->invoice == '') selected @endif>请选择</option>
                                            <option value="ems" @if($value->invoice=='ems') selected @endif>EMS</option>
                                            <option value="shunfeng" @if($value->invoice=='shunfeng') selected @endif>顺丰</option>
                                            <option value="shentong" @if($value->invoice=='shentong') selected @endif>申通</option>
                                            <option value="yuantong" @if($value->invoice=='yuantong') selected @endif>圆通</option>
                                            <option value="zhongtong" @if($value->invoice=='zhongtong') selected @endif>中通</option>
                                            <option value="yunda" @if($value->invoice=='yunda') selected @endif>韵达</option>
                                            <option value="tiantian" @if($value->invoice=='tiantian') selected @endif>天天</option>
                                        </select>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            
                            <div class="am-fr">
                                <div id="pull_right">
                                    <div class="pull-right">
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </form>
                </div>

            </div>
        </div>
        <div class="tpl-alert">
            <div id="pull_right">
                                    <div class="pull-right">
                                       {!! $data->render() !!}
                                    </div>
                                </div>
        </div>
    </div>

    </div>

    </div>
    <script src="{{URL::asset('/')}}assets/js/jquery.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/amazeui.min.js"></script>
    <script src="{{URL::asset('/')}}assets/js/app.js"></script>
    <script type="text/javascript">
        //修改快递单号
        $('.invoice').blur(function(){
           var order_id = $(this).attr('order_id');
           var invoice_number = $(this).val();
            $.ajax({
                url:"{{URL::asset('admin/invoice')}}",
                data:{invoice_number:invoice_number,order_id:order_id,_token:"{{csrf_token()}}"},
                type:'get',
                dataType:"json",
                success:function(data){
                     location.reload();
                }
            })
        })
        //修改快递名称
        $('.invoices').change(function(){
            var order_id = $(this).attr('order_id');
            var invoice = $(this).find('option:selected').val();
            $.ajax({
                url:"{{URL::asset('admin/invoices')}}",
                data:{invoice:invoice,order_id:order_id,_token:"{{csrf_token()}}"},
                type:'get',
                dataType:"json",
                success:function(data){
                     location.reload();
                }
            })
        })
    </script>
</body>
</html>