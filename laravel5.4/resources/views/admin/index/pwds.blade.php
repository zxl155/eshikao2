@include('common/header')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                易师考
            </div>
            
            <div class="tpl-portlet-components">
                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form">
                                <input type="hidden" value="{{ $admin_id }}" id="admin_id">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">原密码 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="original_pwd">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">新密码 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="new_pwd">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">确认密码 <span class="tpl-form-line-small-title"></span></label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" id="confirm_pwd">
                                    </div>
                                </div>

                               
                            </form>
                             <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button id="btn" class="am-btn am-btn-primary tpl-btn-bg-color-success ">修改</button>
                                    </div>
                                </div>
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
    $("#btn").click(function(){
        var admin_id = $("#admin_id").val();
        var original_pwd = $("#original_pwd").val();
        var new_pwd = $("#new_pwd").val();
        var confirm_pwd = $("#confirm_pwd").val();
        if(original_pwd == '' || new_pwd == '' || confirm_pwd == ''){
            var txt=  "用户名或密码不能为空";
            window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        $.ajax({
            url:"{{ url('admin/pwds') }}",
            data:{admin_id:admin_id,original_pwd:original_pwd,new_pwd:new_pwd,confirm_pwd:confirm_pwd,_token:"{{ csrf_token() }}"},
            type:'get',
            success:function(data){
                
                if(data == 1){
                    var txt=  "原密码错误";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }else if(data == 2){
                    var txt=  "俩次密码不一致";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }else if(data==3){
                    var txt=  "修改成功";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.success);
                    location.href = 'personal';
                } else {
                     var txt=  "修改失败";
                    window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.warning);
                    return false;
                }
            }
        })
    })
</script>
</html>