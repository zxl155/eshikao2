$(function(){
    var $ul = $('.my_group').find('.list');
    //var $search_ul = $('.search_gp_list');
    //var search_ul_len = $search_ul.children().size();
    var len = $ul.children().size();
    var $no_result = $('<div class="no_result"><span>此类别暂时没有圈子，赶快来<a class="quick_add_group" href="/group/group/add">创建一个</a><span></div>');
    if(len > 5){
        $ul.css({height:138,overflow:'hidden'});
        var $elm = $('<div class="seemore_wrap"><a class="seemore">展开</a></div>');
        $elm.insertAfter($('.my_group .list'));
    }
    $('.seemore').live('click',function(){
        var _that = $(this),
            $ul = $(this).parents('.my_group').find('.list'),
            regularHeight = 138,
            child = $ul.children('li').size(),
            //height = Math.ceil(child/3) * 50;
            height = child * 28;
        if(child > 5){
            if(!$(this).hasClass('more')){
                $ul.animate({height:height},500,function(){
                    _that.addClass('more').text('收起');
                });
            }else{
                $ul.animate({height:regularHeight},500,function(){
                    _that.removeClass('more').text('全部');
                });

            }
        }
    });
    if(len <= 5 && $ul.find('.no_result').length == 0){
        $ul.css('borderBottom','none');
    }
    /*if(search_ul_len < 18){$('.pages').css('display','none');}
    if(search_ul_len == 0){$('.group_panel','.interest_group_container').append($no_result);}*/

    $('.ig_list_tab').bind('click',function(){
        var index = $(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $(this).parent().next().children().eq(index).addClass('current').siblings().removeClass('current');
    });

    //用户名验证
    var last;
    $('.ig_name').keyup(function(event){
        var _that = $(this);
        last = event.timeStamp ? event.timeStamp : timestamp();
        _that.parent().find('.error_tip').remove();
        var group_name = $.trim($(this).val()),
            //regEx = /^([a-zA-Z\u4E00-\u9FA5].*$)|(^.*[a-zA-Z\u4E00-\u9FA5]$)/i;
            group_id = $("input[name='gid']").val(),
            _that = $(this);
        if(group_name != ''){
            setTimeout(function(){
                var cur_evt_time;
                cur_evt_time = event.timeStamp ? event.timeStamp : timestamp();
                if(last - cur_evt_time == 0){
                    $.ajax({
                        type:"POST",
                        dataType:"json",
                        url:"/api/group/checkGroupName",
                        data:{group_name:group_name,group_id:group_id},
                        success:function(data){
                            if(data.error == 0){

                            }else{
                                _that.parent().find('.error_tip').remove();
                                var error_tip = $('<span class="error_tip"></span>');
                                _that.parent().append(error_tip);
                                error_tip.text(data.msgs);
                            }
                        }

                    });
                }
            },300);

        }
    });
    $('.ig_name').blur(function(){
        var _that = $(this),
            formElm = _that.parents('.reg_group_form');
        var group_name = $.trim($(this).val());
        if(group_name == ''){
            var error_tip = $('<span class="error_tip">圈子名称不能为空</span>');
            formElm.find('.group_name_wrap .error_tip').remove();
            formElm.find('.group_name_wrap').append(error_tip);
        }
    });
    //select选框的验证
    $("select[name='city_id']").live('click',function(){
        if($(this).val() == ''){
            var error_tip = $('<span class="error_tip">请选择圈子地域</span>');
            $(this).parent().find('.error_tip').remove();
            $(this).parent().append(error_tip);
        }
        $(this).change(function(){
            if($(this).val() == ''){
                var error_tip = $('<span class="error_tip">请选择圈子地域</span>');
                $(this).parent().find('.error_tip').remove();
                $(this).parent().append(error_tip);
            }else{
                $(this).parent().find('.error_tip').remove();
            }
        });
    });
    //同意磨房免责声明
    $('#agree').click(function(){
        var _that = $(this),
            formElm = _that.parents('.reg_group_form');
        if($(this).attr('checked') != 'checked'){
            var $error_tip = $('<span class="error_tip sp">您必须同意磨房免责声明才能注册</span>');
            formElm.find('.agree_wrap .error_tip').remove();
            formElm.find('.agree_wrap').append($error_tip);
        }else{
            formElm.find('.agree_wrap .error_tip').remove();
        }
    });

    //当表单字段为空或出错时验证
    $('.input-submit').click(function(e){
        var _that = $(this),
            formElm = _that.parents('.reg_group_form'),
            $name_input = formElm.find('.ig_name'),
            g_name = $.trim($name_input.val());
        if(g_name == ''){
            var $error_tip = $('<span class="error_tip">圈子名称不能为空</span>');
            formElm.find('.group_name_wrap .error_tip').remove();
            formElm.find('.group_name_wrap').append($error_tip);
            e.preventDefault();
        }

        if($("select[name='city_id']").val() == ''){
            var $error_tip = $('<span class="error_tip">请选择圈子地域</span>');
            formElm.find('.g_belong_wrap .error_tip').remove();
            formElm.find('.g_belong_wrap').append($error_tip);
        }

        if($("input[name='group_cat[]']:checked").size() == 0){
            var $error_tip = $('<span class="error_tip sp">请至少选择一个类别</span>');
            formElm.find('.hby_ul .error_tip').remove();
            formElm.find('.hby_ul').append($error_tip);
            e.preventDefault();
        }

        if($('.error_tip').size()){
            e.preventDefault();
        }

        if($('.agree').length > 0){
            if($("input[name='agree']:checked").size() == 0){
                var $error_tip = $('<span class="error_tip sp">您必须同意磨房免责声明才能注册</span>');
                formElm.find('.agree_wrap .error_tip').remove();
                formElm.find('.agree_wrap').append($error_tip);
                e.preventDefault();
            }
        }
    });

    /*添加小组类别*/
    function addTarget($element){
        $(".hby_btn",$element).click(function(){
            var $left = $(this).offset().left - $(this).parent().offset().left;
            $(this).parents(".hby_ul").find('.hby_showBox').css('left',$left+'px').show('fast');
            $('.hby_showBox_button').prevAll('input').focus();
        });
        var $hby_showBox = $(".hby_showBox",$element);
        var $hidden = $('input[forid="hidden"]',$element);//隐藏域
        $hidden.val('');

        var $value = '';
        $("li:not('.last')",$element).live('click',function(){
            if($(this).parent().find('.error_tip')){
                $(this).parent().find('.error_tip').remove();
            }

                if($(this).hasClass('active')){
                    $(this).removeClass('active').children('input').removeAttr('checked');
                }else{
                    if($(this).parent().find('.active').size() < 2){//最多只能选两个小组类别
                        $(this).addClass('active').children('input').attr('checked','checked');
                    }else{
                        var $error_tip = $('<span class="error_tip sp">最多只能选2个类别</span>');
                        $(this).parents('.reg_group_form').find('.hby_ul .error_tip').remove();
                        $(this).parents('.reg_group_form').find('.hby_ul').append($error_tip);
                        $error_tip.show().delay(2000).fadeOut(500,function(){
                            $(this).remove();
                        });
                    }
                }
                var vStr = '';

                $(this).parent().find('.active').each(function(){
                    vStr += $(this).text() + ',';
                });
                $hidden.val(vStr);

        });

        /*确定添加类别*/
        $(".hby_showBox_button",$hby_showBox).click(function(){
            var text = $.trim($("input:text",$hby_showBox).val());
            //alert(typeof text);
            var regEx = /^[\u4e00-\u9fa5]+$/i;
            if(regEx.test(text)){
                var initialValues = $hidden.val();
                //$hby_showBox.hide(600);
                if(text != ''){

                    var vArr = [];
                    $(this).parents('.hby_ul').find("li:not('.last')").each(function(){
                        vArr.push($.trim($(this).text()));//ie7空白文本节点被当成节点
                    });
                    index = $.inArray(text,vArr);
                    if(index == -1){
                        if($(this).parents('.hby_ul').find(".active").size() < 2){
                            $(this).parents('.hby_ul').find('.last').before('<li class="active">'+text +'<input value="'+text+'" class="no_height" type="checkbox" name="group_cat[]" checked /></li>');
                            $hidden.val(initialValues + text + ',');
                        }else{
                            var $error_tip = $('<span class="error_tip sp">最多只能选2个类别</span>');
                            $(this).parents('.reg_group_form').find('.hby_ul').append($error_tip);
                            $error_tip.show().delay(2000).fadeOut(500,function(){
                                $(this).remove();
                            });

                        }

                    }

                }
                $(this).prevAll('input').val('');
            }
        });
    }

    addTarget($('.ig_type_list'));//添加目的地

    //捕获回车事件
    $(document).keydown(function(e){
        if(e && e.keyCode == 13){
            if($(e.target).attr('isEnter')){
                $('.hby_showBox_button').click();
                return false;
            }
        }
    });

    //显示加入圈子或审核中或未加入
    $('li','.search_gp_list').each(function(){
        var isMember = $(this).attr('isMember');
        if(isMember == '0'){
            $(this).find('.join').remove();
            $(this).find('.add_group_btn').append('<span style="margin-top: 10px;color:red;font-weight: bold;">审核中</span>');
        }
        if(isMember == '1'){
            $(this).find('.join').remove();
            $(this).find('.add_group_btn').append('<span class="added" style="margin-top: 10px;color:#00b734;font-weight: bold;">&#10004已加入</span>');
        }
    });

});

//兴趣小组上传相片
$(function(){
    var bar = $('.bar'),
        percent = $('.percent'),
        showimg = $('#showimg'),
        progress = $(".progress"),
        files = $(".files"),
        btn = $(".btn span"),
        oldPic = $('.old_pic');
    $("#fileupload").wrap("<form id='myupload' action='/api/group/setPic' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){ //选择文件
        $("#myupload").ajaxSubmit({
            dataType:  'json', //数据格式为json

            beforeSend: function() { //开始上传
                showimg.empty(); //清空显示的图片
                progress.show(); //显示进度条
                var percentVal = '0%'; //开始进度为0%
                bar.width(percentVal); //进度条的宽度
                percent.html(percentVal); //显示进度为0%
                btn.html("上传中..."); //上传按钮显示上传中
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%'; //获得进度
                bar.width(percentVal); //上传进度条宽度变宽
                percent.html(percentVal); //显示上传进度百分比
            },
            success: function(data) { //成功

                //显示上传后的图片
                $("input[name='pic_id']").val(data.pic_id);
                var imgURL = data.pic_url;
                if(oldPic.length > 0){//修改圈子头像页面
                    showimg.html('<img class="old_pic" src="'+imgURL+'">');
                }else{
                    showimg.html('<img src="'+imgURL+'">');
                }

                btn.html("添加附件"); //上传按钮还原
                progress.hide();
            },
            error:function(xhr){ //上传失败
                btn.html("上传失败");
                bar.width('0');
                files.html(xhr.responseText); //返回失败信息
            }
        });
    });

});

//获取图片尺寸
function getImageSize(FilePath){
    var imgSize={
        width:0,
        height:0
    };
    image=new Image();
    image.src=FilePath;
    imgSize.width =image .width;
    imgSize .height=image .height;
    return imgSize;
}