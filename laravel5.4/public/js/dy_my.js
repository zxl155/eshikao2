/**
 *
 *磨房我的个人首页js
 *
 **/
/**
*我的磨房
*2013-01-17
**/

//通用的ajax请求函数
function ajaxSend(obj,callback,ajaxUrl,sourceId,targetId,pageId,append,currPage){
    var ajaxUrl = ajaxUrl?ajaxUrl:$(obj).attr('ajaxUrl');//请求地址
    var sourceId = sourceId?sourceId:$(obj).attr('sourceId');//来源id
    var targetId = targetId?targetId:$(obj).attr('targetId');//目标id
    var pageId = pageId?pageId:$(obj).attr('pageId');//分页id
    if(!$('#'+sourceId).data('temp')){
        //处理html模板并缓存起来
        var clone_html = $('#'+sourceId).html();//克隆
        if(clone_html) clone_html = clone_html.replace('rsrc=','src=');//处理图片地址
        $('#'+sourceId).data('temp',clone_html);//缓存模板
    }
    if(append) $('#'+targetId).append('<div class="hby_ajaxLoading"></div>').show();//加载等待图标
    else $('#'+targetId).html('<div class="hby_ajaxLoading"></div>').show();//加载等待图标

    $.get(ajaxUrl,function(data){

        var template = $('#'+sourceId).data('temp');
        var htmlstring = '';

        if(!(data.result instanceof Array) || data.result.length==0 || data.result=='null'){
            if(data.msgs){
                if(parseInt(currPage)>1){
                    ajaxUrl = ajaxUrl.substring(0,ajaxUrl.lastIndexOf('/')+1) + (parseInt(currPage)-1);
                    ajaxSend(obj,'',ajaxUrl);
                }
                else htmlstring = '<div class="pt20 pl10 pb20">'+ data.msgs +'</div>';
            }
            else htmlstring = '<div class="pt20 pl10 pb20">很抱歉，暂时没有相关数据！</div>';
        }
        else htmlstring = $.replaceTemplate(template,data.result);

        if(append) $('#'+targetId).append(htmlstring).show();
        else $('#'+targetId).html(htmlstring).show();

        if(callback) callback(data);//回调函数

        if(!pageId) return;//如果不存在分页
        $('#'+pageId).attr('currPage',data.page);//记录当前分页
        $.getPage(data.page,data.tpage,ajaxUrl,'#'+pageId);
        if(parseInt(data.tpage)<2) $('#'+pageId).empty();//分页为0的时候
        //绑定点击事件
        if(!$('#'+pageId).data('isbind')){
            if(obj.attr('id')=='my-photo-a'){
                $('#'+pageId+' a').live('click',function(){
                    ajaxSend(obj,function(){
                        $('#my-photo-content').masonry('reloadItems');
                        callback();
                    },$(this).attr('href'));
                    return false;
                });
            }
            else{
                $('#'+pageId+' a').live('click',function(){
                    ajaxSend(obj,'',$(this).attr('href'));
                    return false;
                });
            }

            $('#'+pageId).data('isbind',1);
        }
    },'json');
}

/*通用的加关注、取消关注和移除粉丝*/
function addFollow(thisObj,callback){
    var $obj = $('#'+$(thisObj).attr('forId'));
    if($obj.size()){
        var ajaxUrl = $obj.attr('ajaxUrl');
        var currPage = $('#'+$(thisObj).attr('forPage')).attr('currPage');
        currPage = currPage?currPage:1;
        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
    }
    
    $.get($(thisObj).attr('ajaxUrl'),function(data){
        if(data.error==0){
            alert(data.msgs,function(){
                if(data.follow_num != 'undefined'){
                    $('#myFlowNum').html(data.follow_num);
                    $('#myFansNum').html(data.fans_num);
                }
                if($obj.size()) ajaxSend($obj,'',ajaxUrl);
                if(callback) callback(data);
            });
        }
        else{
            alert(data.msgs);
        }
    },'json');
}

function cancelFollow(thisObj,callback){
    alertLayer('您确定要取消关注吗？',function(){
        var $obj = $('#'+$(thisObj).attr('forId'));
        var ajaxUrl = $obj.attr('ajaxUrl');
        var currPage = $('#'+$(thisObj).attr('forPage')).attr('currPage');
        currPage = currPage?currPage:1;
        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
        $.get($(thisObj).attr('ajaxUrl'),function(data){
            if(data.error==0){
                if(data.follow_num != 'undefined'){
                    $('#myFlowNum').html(data.follow_num);
                    $('#myFansNum').html(data.fans_num);
                }
                ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                if(callback) callback(data);
            }
            else{
                alert(data.msgs);
            }
        },'json');
    });
}

function removeFollow(thisObj,callback){
    alertLayer('您确定要移除他吗？',function(){
        var $obj = $('#'+$(thisObj).attr('forId'));
        var ajaxUrl = $obj.attr('ajaxUrl');
        var currPage = $('#'+$(thisObj).attr('forPage')).attr('currPage');
        currPage = currPage?currPage:1;
        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
        $.get($(thisObj).attr('ajaxUrl'),function(data){
            if(data.error==0){
                if(data.follow_num != 'undefined'){
                    $('#myFlowNum').html(data.follow_num);
                    $('#myFansNum').html(data.fans_num);
                }

                ajaxSend($obj,'',ajaxUrl,'','','','',currPage);

                if(callback) callback(data);
            }
            else{
                alert(data.msgs);
            }
        },'json');
    });
}

/*我的磨房首页*/
//获取我的动态模板
function getFeedTemp(data){
    var htmlstring = '';
    for(var i=0;i<data.result.length;i++){
        if(data.result[i].FeedType=='photo_new'){
            if(data.result[i].Content.Photos.length>0){
                htmlstring += '<dl class="dl-list clearfix">';
                htmlstring += '<dt class="mb10">';
                htmlstring += '<a href="/user/'+ data.result[i].UserID +'/"><img alt="" src="'+ data.result[i].Face +'"></a>';
                htmlstring += '</dt>';
                htmlstring += '<dd class="des">';
                htmlstring += '<a title="'+ data.result[i].UserName +'" href="#" rel="info_user_'+ data.result[i].UserID +'" class="info_user">'+ data.result[i].UserName +'</a><span class="ml10">添加了新照片</span>';
                htmlstring += '</dd>';
                htmlstring += '<dd class="imgBox">';
                htmlstring += '<a href="'+ data.result[i].Content.Photos[0].Url +'" data-lightbox="example-set" title="'+ data.result[i].Content.Photos[0].Title +'"><img class="BigImg" alt="" src="'+ data.result[i].Content.Photos[0].Url +'"></a>';
                htmlstring += '<div class="ImgListBox mt15 mb10">';
                htmlstring += '<div class="left"></div>';
                htmlstring += '<ul class="ImgList clearfix" id="ImgList">';
                for(var k=1;k<data.result[i].Content.Photos.length;k++){
                    htmlstring += '<li>'+
                                        '<a href="'+ data.result[i].Content.Photos[k].Url +'" data-lightbox="example-set" title="'+ data.result[i].Content.Photos[k].Title +'">'+
                                            '<img alt="" src="'+ data.result[i].Content.Photos[k].Thumb +'" width="90" height="90" />'+
                                        '</a>'+
                                   '</li>';
                }
                htmlstring += '</ul>';
                htmlstring += '<div class="right"></div>';
                htmlstring += '</div>';
                htmlstring += '<div class="imgDes"><span class="fr">'+ new Date(parseInt(data.result[i].CreatedTime)*1000).format('yyyy-MM-dd HH:mm:ss') +'</span>共<em>'+ data.result[i].Content.Photos.length +'</em>张</div>';
                htmlstring += '</dd>';

                htmlstring += '</dl>';
            }
        }
        else{
            htmlstring += '<dl class="dl-list clearfix">';
            htmlstring += '<dt>';
            htmlstring += '<a href="/user/'+ data.result[i].UserID +'/"><img alt="" src="'+ data.result[i].Face +'"></a>';
            htmlstring += '</dt>';
            htmlstring += '<dd class="des">';
            htmlstring += '<a title="'+ data.result[i].UserName +'" href="#" rel="info_user_'+ data.result[i].UserID +'" class="info_user">'+ data.result[i].UserName +'</a><span class="ml10">'+ data.result[i].DisplayTitle +'</span>';
            htmlstring += '</dd>';
            htmlstring += '<dd class="title">';
            htmlstring += data.result[i].DisplayContent;
            htmlstring += '</dd>';
            htmlstring += '<dd class="des"><span class="fr">'+ new Date(parseInt(data.result[i].CreatedTime)*1000).format('yyyy-MM-dd HH:mm:ss') +'</span>'+ data.result[i].DisplayForum +'</dd>';
            htmlstring += '</dl>';
        }
    }
    return htmlstring;
}
//获取与我相关模板
function getFeedMeTemp(data){
    var htmlstring = '';
    for(var i=0;i<data.result.length;i++){

        if(i != 0){
            if(data.result[i].ObjectType == 'photo' && !data.result[i].Comment_list){

            }
            else
                htmlstring += "<hr class='line mt10' style='margin-top:30px; border-color:#b8b8b8;' />";
        }

        if(data.result[i].ObjectType == 'photo'){
            
            if(data.result[i].Comment_list){
                var FeedWord = '';
                if(data.result[i].FeedType == 'mention'){
                    FeedWord = '提到我：';
                }
                else if(data.result[i].FeedType == 'reply'){
                    FeedWord = '回复我：';
                }
                else if(data.result[i].FeedType == 'comment'){
                    FeedWord = '评论我：';
                }
                htmlstring += '<dl class="dl-list clearfix">';
                htmlstring +=     '<dt><a href="/user/'+ data.result[i].UserID +'/"><img src="'+ data.result[i].Face +'" alt=""></a></dt>';
                htmlstring +=     '<dd class="des"><a class="info_user" rel="info_user_'+ data.result[i].UserID +'" href="#" title="'+ data.result[i].UserName +'">'+ data.result[i].UserName +'</a><span class="">'+ FeedWord +'</span></dd>';
                htmlstring +=     '<dd class="des mt5">'+ data.result[i].CreatedTime +'</dd>';
                htmlstring +=     '<dd class="imgBox mt10">';
                htmlstring +=         '<p><a class="info_user" rel="info_user_'+ data.result[i].origin.UserID +'" href="#" title="'+ data.result[i].origin.UserName +'">'+ data.result[i].origin.UserName +'</a>分享了一张照片：'+ data.result[i].origin.title +'</p>';
                htmlstring +=         '<a data-lightbox="example-set" href="'+ data.result[i].origin.Image_b +'"><img src="'+ data.result[i].origin.Image_s +'" alt="" class="BigImg"></a>';
                htmlstring +=         '<div class="imgDes"><span class="fr">评论(<em>'+ data.result[i].Comments +'</em>)</span>'+ data.result[i].origin.CreatedTime +'</div>';
                htmlstring +=     '</dd>';
                htmlstring += '</dl>';

                htmlstring += '<div class="RelyListBox" id="RelyListBox'+ data.result[i].ID +'" ajaxUrl="api/my_home/user_feed_me_comments/'+ data.result[i].Comment_list[0].CommentID +'">';
                htmlstring +=     '<div id="RelyListContent'+ data.result[i].ID +'">';


                for(var j=0; j<data.result[i].Comment_list.length; j++){
                    htmlstring += '<div class="RelyList" parent_id="'+ data.result[i].Comment_list[0].CommentID +'">';
                    if(j==0) 
                        htmlstring += '<dl>';
                    else
                        htmlstring += '<dl class="RelyDl">';

                        htmlstring +=    '<dd class="Img"><a href="/user/'+ data.result[i].Comment_list[j].UserID +'"><img src="'+ data.result[i].Comment_list[j].Face +'" alt=""></a></dd>';
                        htmlstring +=    '<dt><a href="#" rel="info_user_'+ data.result[i].Comment_list[j].UserID +'" class="info_user pr16">'+ data.result[i].Comment_list[j].UserName +'</a><span>'+ data.result[i].Comment_list[j].Content +'</span></dt>';
                        htmlstring +=    '<dd class="Des">';
                        htmlstring +=        '<span class="Time">'+ data.result[i].Comment_list[j].CreatedTime +'</span>';
                        htmlstring +=        '<a href="#" class="RelyLink" userName="'+ data.result[i].Comment_list[j].UserName +'" forid="'+ data.result[i].ID +'" comment_id="'+ data.result[i].Comment_list[j].CommentID +'">回复</a>';
                        htmlstring +=    '</dd>';
                        htmlstring +=    '<dd class="clear"></dd>';
                        htmlstring += '</dl>';
                    htmlstring += '</div>';
                }


                htmlstring +=     '</div>';
                htmlstring += '</div>';

                htmlstring += '<div class="RelyForm" id="RelyForm'+ data.result[i].ID +'">';
                htmlstring +=     '<form action="/api/photo/addPhotoComment" method="post" RelyID="'+ data.result[i].ID +'">';
                htmlstring +=         '<div class="RelyWho">回复 @<span></span><a href="#">取消</a></div>';
                htmlstring +=         '<textarea name="photo_comment" placeholder="我也想说两句..." style="width:440px;height:60px;"></textarea>';
                htmlstring +=         '<input type="hidden" name="parent_id" value="'+ data.result[i].Comment_list[0].CommentID +'" />';
                htmlstring +=         '<input type="hidden" name="comment_id" value="'+ data.result[i].Comment_list[0].CommentID +'" oldValue="'+ data.result[i].Comment_list[0].CommentID +'" />';
                htmlstring +=         '<input type="hidden" name="photo_id" value="'+ data.result[i].Comment_list[0].PhotoID +'" />';
                htmlstring +=         '<p class="AllWordsBox">';
                htmlstring +=             '<span class="AllWords">（<i>0</i>/140）</span>';
                htmlstring +=             '<input type="submit" value="发表" class="button-only" />';
                htmlstring +=         '</p>';
                htmlstring +=     '</form>';
                htmlstring += '</div>';
            }
            else{//回复列表错误
                htmlstring += '';
            }

        }
        else{
           /* htmlstring += '<dl class="dl-list clearfix">';
            htmlstring += '<dd class="des"><span class="fr">'+ new Date(parseInt(data.result[i].CreatedTime)*1000).format('yyyy-MM-dd HH:mm:ss') +'</span>'+ data.result[i].DisplayForum +'</dd>';
            htmlstring += '</dl>';*/

            htmlstring += '<dl class="dl-list clearfix">';
            htmlstring +=    '<dt><a href="/user/'+ data.result[i].UserID +'/"><img src="'+ data.result[i].Face +'" alt=""></a></dt>';
            htmlstring +=    '<dd class="des"><a class="info_user" rel="info_user_'+ data.result[i].UserID +'" href="#" title="'+ data.result[i].origin.UserName +'">'+ data.result[i].origin.UserName +'</a><span class="ml10">引用了我的评论</span></dd>';
            htmlstring +=    '<dd class="title">';
            htmlstring +=        '<a href="'+ data.result[i].origin.url +'">'+ data.result[i].origin.PostSubject +'</a>';
            htmlstring +=        ''+ data.result[i].origin.PostContent +'';
            htmlstring +=    '</dd>';
            htmlstring +=    '<dd class="des"><span class="fr">'+ data.result[i].CreatedTime +'</span></dd>';
            htmlstring += '</dl>';
        }
    }
    return htmlstring;
}
function appendData(objID){
    var $targetObj = $('#'+objID);
    var ajaxUrl = $targetObj.attr('ajaxUrl')+$targetObj.attr('lastId')+'/'+$targetObj.attr('getTotal');
    //如果上次的请求还没结束，则不发送新请求
    if(!$targetObj.data('success')) return;
    $targetObj.data('success',0);
    $targetObj.append('<div class="hby_ajaxLoading"></div>');

    $.get(ajaxUrl,function(data){
        
        if(!data.result){
            $targetObj.find('.hby_ajaxLoading').remove();
            $targetObj.append('<div class="tc pt20">没有更多数据了！</div>');
            return;
        }
        $targetObj.attr('lastId',data.result[data.result.length-1].ID);//更新最后一条id
        var htmlstring = '';
        if(objID == 'my-index-feed') htmlstring = getFeedTemp(data);
        if(objID == 'DynamicBoxWithMy') htmlstring = getFeedMeTemp(data);
        $targetObj.find('.hby_ajaxLoading').remove();
        $targetObj.append(htmlstring);
        $targetObj.data('success',1);
    },'json');
}
$(function(){
    if($('#My-index').size()){

        $('#my-index-feed').data('success',1);//初始化标识
        $('#DynamicBoxWithMy').data('success',1);

        $(window).scroll(function(){
            //判断是否为底部
            var scrollHeight = $(document).height();
            var height = $(window).height();
            var scrollTop = $(window).scrollTop();
            if(height+scrollTop < scrollHeight-20) return;
            //加载数据
            if($('#my-index-feed').size()) appendData('my-index-feed');
            if($('#DynamicBoxWithMy').size()) appendData('DynamicBoxWithMy');
            
        });

        if($('#my-index-feed').size()) appendData('my-index-feed');
        if($('#DynamicBoxWithMy').size()) appendData('DynamicBoxWithMy');

        //猜你认识
        ajaxSend($('#my-interest-content'));

        //加关注
        $('.addFollow').live('click',function(){
            addFollow(this,function(data){
                ajaxSend($('#my-interest-content'));
            });
            return false;
        });

    }
});

/*我的求捡*/
$(function(){
    if($("#hby_activity_myPick").size()){

        /*鼠标划过出现操作*/
        /*$("#hby_activity_myPick .hby_myPick_list li").live({ mouseenter: function(){
            //$(this).children('.hby_operation').fadeToggle(600);
            $(this).children('.hby_operation').stop().fadeTo(600,1);
        }, mouseleave: function(){
            //$(this).children('.hby_operation').fadeToggle(600);
            $(this).children('.hby_operation').stop().fadeTo(600,0);
        } });*/

        /*相关活动*/
        $('.hby_relative_btn').live('click',function(){
            var url = $(this).attr('href');
            var $targetParent = $(this).parent().parent();
            var $target = $(this).parent().nextAll('.hby_relative_content');
            $.get(url,function(data){
                if(!data.result){
                    alert('暂时没有相关活动');
                }
                else{
                    $('.hby_myPick_list .hby_relative_content').hide();
                    $target.show();
                    $.innerData(data,url,$target.find('dd').eq(0),'#hby_myPick_dd_extra');
                }
            },'json');
            return false;
        });

        /*时间控件*/
        $(".Wdate").click(function(){
            WdatePicker({
                skin : 'whyGreen',
                dateFmt : 'yyyy-MM-dd',
                minDate : '%y-%M-{%d}'
            });
        });

        /*弹出发布框*/
        $("#hby_showBtn").click(function(){
            showShade();
            $("#my-wish-layer").show();
        });

        /*验证弹出发布框*/
        document.validate = $('#my-wish-layer form').validate({
            /*自定义验证规则*/
            rules : {
                'dests[]' : { required : true },
                'time_start' : { required : true },
                'days' : { required : true, digits : true, min: 1 }
            },
            /*提示信息*/
            messages : {
                'dests[]' : error.event.wish.dests_null,
                'time_start' : error.event.wish.time_start_null,
                'days' : error.event.wish.days_min
            },
            /*错误提示位置*/
            errorPlacement : function(error, element){
                $('<span class="help-inline"></span>').html(error).insertAfter(element);
            },
            focusInvalid : true
        });

        /*发布框ajax提交*/
        $('#my-wish-layer-submit').click(function(){
            if($('#my-wish-layer form').valid()){
                var requestData = $('#my-wish-layer form').serializeArray();
                $('#my-wish-layer input[name="act"]').val('');
                $('#my-wish-layer input[name="dests_str"]').val('');
                $.post($('#my-wish-layer form').attr('action'),requestData,function(data){
                    if(data.error=='0'){
                        //alert('发布成功');
                        $('#my-wish-layer input[name="act"]').val('success');
                        $('#my-wish-layer input[name="dests_str"]').val(data.msgs);
                        $('#my-wish-layer form').submit();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            }
            else{
                document.validate.focusInvalid();
            }
        });

        /*编辑*/
        $("#hby_activity_myPick .hby_edit").live('click',(function(){
            $('#my-wish-layer-edit label.error').parent().remove();
            $("#shade-bg").remove();
            $("body").append('<div class="shade-bg" id="shade-bg" style="height: '+ $("document").height() +'px;"></div>');
            var $li = $(this).parent().parent();
            var time = $li.find("[forname='time']").val();
            //time = time.replace(/[^\d]/g,'-');
            //time = time.substr(0,time.length-1);
            var day = $li.find("[forname='day']").html();
            var words = $li.find("[forname='words']").val();
            var destination = $li.find("[forname='destination']").html();
            var destnameold = $li.find("[name='destnameold']").val();
            var id = $(this).attr('forid');
            var $layer = $("#my-wish-layer-edit");
            $layer.find("[name='time_start']").val(time);
            $layer.find("[name='days']").val(day);
            $layer.find("[name='memo']").val(words);
            $layer.find("[name='destName']").val(destination);
            $layer.find("[name='destNameOld']").val(destnameold);
            $layer.find("[name='id']").val(id);
            $layer.show();
        }));

        /*验证弹出发布框*/
        document.validateEdit = $('#my-wish-layer-edit form').validate({
            /*自定义验证规则*/
            rules : {
                'destName' : { required : true },
                'time_start' : { required : true },
                'days' : { required : true, digits : true, min: 1 }
            },
            /*提示信息*/
            messages : {
                'destName' : error.event.wish.dests_null,
                'time_start' : error.event.wish.time_start_null,
                'days' : error.event.wish.days_min
            },
            /*错误提示位置*/
            errorPlacement : function(error, element){
                $('<span class="help-inline"></span>').html(error).insertAfter(element);
            }
        });

        /*编辑框ajax提交*/
        $('#my-wish-layer-edit-submit').click(function(){
            if($('#my-wish-layer-edit form').valid()){
                var requestData = $('#my-wish-layer-edit form').serializeArray();
                $.post($('#my-wish-layer-edit form').attr('action'),requestData,function(data){
                    if(data.error=='0'){
                        //alert('发布成功');
                        window.location.reload();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            }
            else{
                document.validateEdit.focusInvalid();
            }
        });

        /*相关活动构造默认分页*/
        //var x_url = '/api/wish/my/index/1';
        var x_url = $('#hby_myPick_page').attr('url');
        var x_total = $('#hby_myPick_page').attr('total');
        $.getPage(1,x_total,x_url,'#hby_myPick_page');
        /*分页*/
        $('#hby_myPick_page a').live('click',function(){
            var url = $(this).attr('href');
            $.innerJsonData(url,'#hby_myPick_body','#hby_myPick_body_extra','#hby_myPick_page');
            return false;
        });

        /*收到邀请构造默认分页*/
        var y_url = $('#hby_myPick_invite_page').attr('url');
        var y_total = $('#hby_myPick_invite_page').attr('total');
        $.getPage(1,y_total,y_url,'#hby_myPick_invite_page');
        /*分页*/
        $('#hby_myPick_invite_page a').live('click',function(){
            var url = $(this).attr('href');
            $.innerJsonData(url,'#hby_myPick_invite_body','#hby_myPick_invite_body_extra','#hby_myPick_invite_page');
            return false;
        });

    }
});

/*我的求捡发布成功*/
$(function(){
    if($("#hby_activity_myPickSuccess").size()){

        /*时间控件*/
        $(".Wdate").click(function(){
            WdatePicker({
                skin : 'whyGreen',
                dateFmt : 'yyyy-MM-dd',
                minDate : '%y-%M-{%d}'
            });
        });

        /*弹出发布框*/
        $("#hby_hby_pickLayer_Btn").click(function(){
            $("body").append('<div class="xubox_shade_0" id="xubox_shade" style="z-index: 9999; width: 100%; height: '+ $("document").height() +'px;"></div>');
            showShade();
            $("#my-wish-layer").show();
            return false;
        });

        /*发布框ajax提交*/
        $('#my-wish-layer-submit').click(function(){
            if($('#my-wish-layer form').valid()){
                var requestData = $('#my-wish-layer form').serializeArray();
                $('#my-wish-layer input[name="act"]').val('');
                $('#my-wish-layer input[name="dests_str"]').val('');
                $.post($('#my-wish-layer form').attr('action'),requestData,function(data){
                    if(data.error=='0'){
                        //alert('发布成功');
                        $('#my-wish-layer input[name="act"]').val('success');
                        $('#my-wish-layer input[name="dests_str"]').val(data.msgs);
                        $('#my-wish-layer form').submit();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            }
        });

        /*验证弹出发布框*/
        $('#my-wish-layer form').validate({
            /*自定义验证规则*/
            rules : {
                'dests[]' : { required : true },
                'time_start' : { required : true },
                'days' : { required : true, digits : true, min: 1 }
            },
            /*提示信息*/
            messages : {
                'dests[]' : error.event.wish.dests_null,
                'time_start' : error.event.wish.time_start_null,
                'days' : error.event.wish.days_min
            },
            /*错误提示位置*/
            errorPlacement : function(error, element){
                $('<span class="help-inline"></span>').html(error).insertAfter(element);
            }
        });


    }
});

/*我的书签*/
$(function(){
    if($('#My-bookMarks').size()){
        //出现取消收藏
        $('.PlateUl li').hover(function(){
            $(this).find('.cancel').show();
        },function(){
            $(this).find('.cancel').hide();
        });
    }
});

/*我的关注*/
$(function(){
    if($('#My-follow').size()){

        //我关注的人
        if($('#my-follow-her').size()) ajaxSend($('#my-follow-her-a'));

        //我关注的人
        if($('#her-follow-my').size()) ajaxSend($('#her-follow-my-a'));

        //取消关注
        $('.cancelFollow').live('click',function(){
            cancelFollow(this);
            return false;
        });

        //加关注
        $('#her-follow-content .addFollow').live('click',function(){
            addFollow(this);
            return false;
        });
        $('#my-interest-content .addFollow').live('click',function(){
            addFollow(this,function(data){
                ajaxSend($('#my-interest-content'));
                if($('#my-follow-her').size()) ajaxSend($('#my-follow-her-a'));
            });
            return false;
        });

        //移除粉丝
        $('.removeFollow').live('click',function(){
            removeFollow(this);
            return false;
        });

        //搜索页中的加关注
        $('#my-search-content .addFollow').live('click',function(){
            addFollow(this);
            return false;
        });

        //可能感兴趣的人
        ajaxSend($('#my-interest-content'));
    }
});

/*封面大图*/
$(function(){
    if($('#my-options').size()){

        //验证保存表弟
        $('#My-optCover-saveForm').submit(function(){
            var $radios = $(this).find('input[name="img"]');
            var flag = false;
            $.each($radios,function(){
                if(this.checked){
                    flag = this.checked;
                    return false;
                }
            });
            if(!flag){
                alert('请选择一张图片！');
                return false;
            }
            return true;
        });

        //验证保存表弟
        $('#My-optCover-uploadForm').submit(function(){
            var $radio = $(this).find('input[name="img"]');
            if(!$radio.val()){
                alert('请选择上传的图片！');
                return false;
            }
            return true;
        });
    }
});

/*我的活动*/
$(function(){
    if($("#hby_activity_myActivity").size()){

        var $obj = $("#hby_activity_myActivity");

        /*切换*/
        $title = $("#hby_activity_myActivity_title li").not('.last');

        $title.click(function(){
            $('#hby_myActivity_add').attr('href',$(this).attr('url'));
            if($(this).attr('text')){
                $('#hby_myActivity_add').html($(this).attr('text'));
            }
            else{
                $('#hby_myActivity_add').html('发起活动');
            }
        });

        /*更多*/
        $('.more').live('click',function(){
            if($(this).attr('forid')){
                $('#'+$(this).attr('forid')).find('a').click();
                return false;
            }
        });

        /*ajax获取我发布的数据*/
        $('#hby_title_public').click(function(){

            if($('#hby_title_public_box').attr('ishave')=='yes'){
                return;
            }
            else{

                $.innerJsonData($(this).attr('href'),'#hby_title_public_box','#hby_title_public_box','#hby_public_page');
                /*分页点击*/
                $('#hby_public_page a').live('click',function(){
                    var url = $(this).attr('href');
                    //$.getJsonData(url,'#hby_title_public_box','#hby_title_public_box','#hby_public_page');
                    $.innerJsonData(url,'#hby_title_public_box','#hby_title_public_box','#hby_public_page');
                    return false;
                });
            }

        });

        /*ajax获取我参加的数据*/
        $('#hby_title_join').click(function(){

            if($('#hby_title_join_box').attr('ishave')=='yes'){
                return;
            }
            else{

                $.innerJsonData($(this).attr('href'),'#hby_title_join_box','#hby_title_join_box','#hby_join_page');

                /*分页点击*/
                $('#hby_join_page a').live('click',function(){
                    var url = $(this).attr('href');
                    //$.getJsonData(url,'#hby_title_join_box','#hby_title_join_box','#hby_join_page');
                    $.innerJsonData(url,'#hby_title_join_box','#hby_title_join_box','#hby_join_page');
                    return false;
                });
            }

        });

        /*查看往期*/
        $('.hby_showSeriesHistoryButton').live('click',function(){
            $('.layer').hide();
            showShade();
            $('#hby_showSeriesHistory').show();
            var $targetObj = $('#hby_manageLine_body');
            if(!$targetObj.data('temp')) $targetObj.data('temp',$('#hby_manageLine_body').html());
            $('#hby_manageLine_body').html('<tr><td colspan="3"><div class="hby_ajaxLoading" style="height:50px;"></div></td></tr>');
            $.get($(this).attr('href'),function(data){
                var html = $.replaceTemplate($targetObj.data('temp'),data.result);
                $('#hby_manageLine_body').empty().html(html);
            },'json');
            return false;
        });

        /*ajax获取系列活动*/
        $('#hby_title_series').click(function(){

            if($('#hby_series_body').attr('ishave')=='yes'){
                return;
            }
            else{

                $.innerJsonData($(this).attr('href'),'#hby_series_body','#hby_series_body','#hby_series_page');

                /*分页点击*/
                $('#hby_series_page a').live('click',function(){
                    var url = $(this).attr('href');
                    $.innerJsonData(url,'#hby_series_body','#hby_series_body','#hby_series_page');
                    return false;
                });
            }

        });

        /*ajax获取活动草稿*/
        $('#hby_title_paper').click(function(){

            if($('#hby_title_pager_box').attr('ishave')=='yes'){
                return;
            }
            else{

                $.innerJsonData($(this).attr('href'),'#hby_title_pager_box','#hby_title_pager_box','#hby_pager_page');

                /*分页点击*/
                $('#hby_pager_page a').live('click',function(){
                    var url = $(this).attr('href');
                    $.innerJsonData(url,'#hby_title_pager_box','#hby_title_pager_box','#hby_pager_page');
                    return false;
                });
            }
            
        });

        /*删除草稿*/
        $('.hby_series_delBtn').live('click',function(){
            var $that = $(this);
            if(confirm('您确定要删除这个活动草稿吗？')){
                $.get($(this).attr('href'),function(data){
                    if(data.error == 0){
                        alert('删除成功');
                        $that.parent().parent().remove();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            }
            return false;
        });

        /*打开保险、紧急联系人*/
        function initEdit(data){
            //var id = getUrl(url,'id');
            //var uid = getUrl(url,'uid');
            //var act = getUrl(url,'act');
            if(typeof data.id != 'undefined') $('#hby_join_edit input[forid="id"]').val(data.id);
            if(typeof data.uid != 'undefined') $('#hby_join_edit input[forid="uid"]').val(data.uid);
            if(typeof data.conname1 != 'undefined') $('#hby_join_edit input[forid="emer_user1"]').val(data.conname1);
            if(typeof data.contel1 != 'undefined') $('#hby_join_edit input[forid="emer_telephone1"]').val(data.contel1);
            if(typeof data.conname2 != 'undefined') $('#hby_join_edit input[forid="emer_user2"]').val(data.conname2);
            if(typeof data.contel2 != 'undefined') $('#hby_join_edit input[forid="emer_telephone2"]').val(data.contel2);
            if(typeof data.username != 'undefined') $('#hby_join_edit input[forid="insurance_name"]').val(data.username);
            if(typeof data.insuname != 'undefined') $('#hby_join_edit input[forid="insurance_type"]').val(data.insuname);
            if(typeof data.insunum != 'undefined') $('#hby_join_edit input[forid="insurance_number"]').val(data.insunum);
        }
        $(".hby_showInsurance",$obj).live('click',function(){

            $('#hby_join_edit').find('a[forclass="showEmergent"]').attr('href',$(this).siblings('a').attr('href')).attr('ishave','');
            $('#hby_join_edit').find('a[forclass="showInsurance"]').attr('href',$(this).attr('href')).attr('ishave','yes');

            if($(this).attr('isUpdate')=='true') $('#hby_join_edit [type="submit"]').show();
            else $('#hby_join_edit [type="submit"]').hide()
            $.get($(this).attr('href'),function(data){
                initEdit(data.result);
                $('#hby_join_edit').fadeTo(400,1).siblings().hide();
                $(".hby_joinTitle a",$obj).eq(1).click();
            },'json');
            return false;
        });
        $(".hby_showEmergent",$obj).live('click',function(){

            $('#hby_join_edit').find('a[forclass="showEmergent"]').attr('href',$(this).attr('href')).attr('ishave','yes');
            $('#hby_join_edit').find('a[forclass="showInsurance"]').attr('href',$(this).siblings('a').attr('href')).attr('ishave','');

            if($(this).attr('isUpdate')=='true') $('#hby_join_edit [type="submit"]').show();
            else $('#hby_join_edit [type="submit"]').hide()
            $.get($(this).attr('href'),function(data){
                initEdit(data.result);
                $('#hby_join_edit').fadeTo(400,1).siblings().hide();
                $(".hby_joinTitle a",$obj).eq(0).click();
            },'json');
            return false;
        });

        /*取消保险、紧急联系人*/
        $('#hby_join_edit .hby_reset').click(function(){
            $('#hby_join_edit').hide().siblings().show();
        });

        /*修改保险切换*/
        $(".hby_joinTitle a",$obj).click(function(){
            var $that = $(this);
            if($(this).attr('ishave') != 'yes'){
                $.get($(this).attr('href'),function(data){
                    initEdit(data.result);
                    $that.attr('ishave','yes');
                },'json');
            }

            $(this).addClass('hby_curr').siblings('a').removeClass('hby_curr');
            var $hby_join_editBox = $(this).parent().siblings('.hby_join_editBox');
            $hby_join_editBox.hide();
            //$hby_join_editBox.eq($(this).index()).fadeTo(600,1);
            $hby_join_editBox.eq($(this).index()).show();

            return false;
        });

        /*ajax提交保险、紧急联系人表单*/
        $('#hby_insuranceForm,#hby_emergentForm').ajaxForm(
            {   
                dataType:'json',
                success: function(data){
                    if(data.error == '0') $('#hby_join_edit').hide().siblings().show();
                    else{
                        alert(data.msgs);
                    }
                }
            }
        );
        var $status=false;
        /*退出参加的活动*/
        $('.hby_activity_exit').live('click',function(){
            if($status){
                alert('数据正在处理中,请稍后提交!');
                return false;
            }
            $status=true;
            if(confirm('您确定要退出这个活动吗？')){ 
                $that = $(this);
                $.get($(this).attr('href'),function(data){
                    if(data.status==200){
                        alert('退出成功');
                        $status=false;
                        $that.parent().parent().remove();
                    }
                    else{
                        alert(data.message);
                        $status=false;
                    }
                },'json');
                $status=false;
            }
             else{
                $status=false;
                return false; 
            }
            $status=false;
            return false;
        });

        /*输入目的地*/
        $("#hby_addTarget").click(function(){
            if(document.hby_id=='hby_addTime') return;
            var $input = $(this).hide().nextAll('.hby_input').fadeTo(600,1).children('input').focus(function(){
                if($(this).val()==$(this).get(0).defaultValue) $(this).val('');
            }).keyup(function(){
                var reg = /[^\a-zA-Z\u4E00-\u9FA5\d]/g;
                if(reg.test(this.value)){
                    this.value = this.value.replace(reg,'');
                    $('#my-event-targetAddress-tips').html('您只能输入12个中文、字母和数字').show();
                }
                else{
                    $('#my-event-targetAddress-tips').hide();
                    if(this.value.length>12) {
                        this.value = this.value.substr(0,12);
                        $('#my-event-targetAddress-tips').html('您只能输入12个中文、字母和数字').show();
                    }
                }
            });
            var text = $input.get(0).defaultValue;
            $input.val('').val(text);
            document.hby_input = $input;
            document.hby_id = 'hby_addTarget';
        });

        /*输入空闲时间*/
        $("#hby_addTime").click(function(){
            if(document.hby_id=='hby_addTarget') return;
            var $input = $(this).hide().nextAll('.hby_input').fadeTo(600,1).children('input');
            document.hby_input = $input;
            document.hby_id = 'hby_addTime';
        });

        /*输入目的地、空闲时间失去焦点*/
        $("body").click(function(event){
            var $tar = $(event.target);
            if(document.hby_id){
                if(document.hby_id == 'hby_addTarget'){//添加目的地
                    if($tar.parent().attr('class') != 'hby_input' && $tar.attr('id') != 'hby_addTarget' && document.hby_input){
                        var $that = document.hby_input;
                        var that = document.hby_input.get(0);
                        if($.trim($that.val()) == '' || $that.val() == that.defaultValue){
                            $that.parent().hide().prev().fadeTo(600,1);
                        }
                        else {
                            var comp_value = $.trim($that.val());
                            var flag = false;
                            $.each($('#hby_addTarget_ul a.hby_del'),function(){
                                if(comp_value == $.trim($(this).html())){
                                    flag = true;
                                    alert('不能输入重复的目的地！');
                                    $that.val('').parent().hide().prev().fadeTo(600,1);
                                    return false;
                                }
                            });
                            if(flag) return;
                            //这个地方会发送ajax请求
                            var sendData = {};
                            sendData.acti = 'dongtai';
                            sendData.act = 'update';
                            sendData.usbid = $('#hby_usbid').val();
                            if(!sendData.usbid) sendData.act = 'insert';
                            sendData.dest = '';
                            var $dest = $('#hby_addTarget_ul').find('span[forname="dest"]');
                            $.each($dest,function(index,obj){
                                if($(obj).html()) sendData.dest += $(obj).html() + ',';
                            });
                            sendData.dest += $('#hby_addTarget_ul').find('input[forname="dest"]').val();
                            //sendData.dest = sendData.dest.substring(0,sendData.dest.length-1);
                            $.get('/my/event',sendData,function(data){
                                //这个是回调函数
                                if(data.error == '0'){
                                    window.location.reload();
                                }
                                else{
                                    alert(data.msgs);
                                    $("#hby_addTarget").fadeTo(600,1).nextAll('li').hide();
                                }
                            },'json');
                            $that.parent().hide().next().fadeTo(600,1);
                        }
                        document.hby_input = null;
                        document.hby_id = null;
                    }
                }
                if(document.hby_id == 'hby_addTime'){//修改时间

                    if($tar.parent().attr('class') != 'hby_input' && !$tar.parents('#hby_addTime').size() && document.hby_input){
                        var $that = document.hby_input;
                        var that = document.hby_input.get(0);
                        var that1 = document.hby_input.get(1);

                        if($.trim($that.eq(0).val()) == '' || $.trim($that.eq(1).val()) == '' || ($that.eq(0).val() == that.defaultValue && $that.eq(1).val() == that1.defaultValue) ){
                            $that.parent().hide().prev().fadeTo(600,1);
                        }
                        else {
                            //这个地方会发送ajax请求
                            var sendData = {};
                            sendData.acti = 'dongtai';
                            sendData.act = 'update';
                            sendData.usbid = $('#hby_usbid_time').val();
                            if(!sendData.usbid) sendData.act = 'insert';
                            sendData.time = document.hby_input.eq(0).val();
                            sendData.day = document.hby_input.eq(1).val();
                            $.get('/my/event',sendData,function(data){
                                //这个是回调函数
                                if(data.error == '0'){
                                    window.location.reload();
                                } 
                                else{
                                    alert(data.msgs);
                                    $("#hby_addTime").fadeTo(600,1).nextAll('li').hide();
                                }
                            },'json');
                            $that.parent().hide().next().fadeTo(600,1);
                        }
                        document.hby_input = null;
                        document.hby_id = null;
                    }
                }
            }
        });

        /*时间控件*/
        $(".Wdate",$obj).click(function(){
            WdatePicker({
                skin : 'whyGreen',
                minDate : '%y-%M-{%d}'
            });
        });

        /*删除*/
        $("#hby_deve_right li a.hby_del").live('click',function(){
            var $that = $(this).parent();

            //这个地方会发送ajax请求
            var sendData = {};
            sendData.acti = 'dongtai';
            sendData.act = 'update';
            sendData.usbid = $('#hby_usbid').val();
            sendData.dest = '';
            var $dest = $('#hby_addTarget_ul').find('span[forname="dest"]');
            $dest = $dest.not($(this).find('span'));
            $.each($dest,function(index,obj){
                if($(obj).html()) sendData.dest += $(obj).html() + ',';
            });
            sendData.dest = sendData.dest.substring(0,sendData.dest.length-1);

            $.get('/my/event',sendData,function(data){
                //这个是回调函数
                if(data.error == '0'){
                    window.location.reload();
                }
                else{
                    alert(data.msgs);
                    $("#hby_addTarget").fadeTo(600,1).nextAll('li').hide();
                }
            },'json');

            $that.html('<img class="w20 h20" alt="" src="'+MISC_PATH+'images/event/hby_loading.gif" />删除……');
        });

        /*删除搜索过的地点记录*/
        $("#my-event-clean").live('click',function(){

            //这个地方会发送ajax请求
            var sendData = {};
            sendData.act = 'clean';
            $.get('/my/event',sendData,function(data){
                //这个是回调函数
                if(data.error == '0'){
                    window.location.reload();
                }
                else{
                    alert(data.msgs);
                }
            },'json');
        });




        /*根据url中的#号来跳转*/
        if(location.href.split('#')[1] == 'initiate') $('#hby_title_public a').click();
        if(location.href.split('#')[1] == 'participate') $('#hby_title_join a').click();
        if(location.href.split('#')[1] == 'series') $('#hby_title_series a').click();
        if(location.href.split('#')[1] == 'draft') $('#hby_title_paper a').click();

    }
});

/*我的话题*/
$(function(){
    if($('#My-topic').size()){

        function ajaxTopic(obj,ajaxUrl){
            var ajaxUrl = ajaxUrl || obj.attr('ajaxUrl');
            var $targetObj = $('#'+obj.attr('targetId'));
            var pageId = obj.attr('pageId');
            $targetObj.html('<div class="hby_ajaxLoading"></div>');
            var htmlstring = '';

            $.get(ajaxUrl,function(data){
                if(!data.result){
                    $targetObj.find('.hby_ajaxLoading').remove();
                    $targetObj.append('<div class="pt20 pl10 pb20">很抱歉，暂时没有相关数据！</div>');
                    return;
                }

                for(var i=0;i<data.result.length;i++){
                    htmlstring += '<dl>';
                    htmlstring += '<dt class="title"><a href="'+ data.result[i].Edit_Link +'" class="fr">编辑</a><a href="'+ data.result[i].Nodes[0].LinkUrl +'">'+ data.result[i].Title +'</a></dt>';
                    htmlstring += '<dd>';
                    htmlstring += '<span class="fr">'+ $.dateFmt(data.result[i].Created,'yyyy-MM-dd hh:mm:ss') +'</span>';
                    htmlstring += '<span class="mr20"><a href="'+ data.result[i].Nodes[0].LinkUrl +'">回帖(<em>'+ data.result[i].PostNum +'</em>)</a></span>';
                    htmlstring += '<span class="mr20">好评(<em>'+ data.result[i].DigNum +'</em>)</span>';
                    for(var j=0;j<data.result[i].Nodes.length;j++){
                        htmlstring += '<span class="mr10">'+ (data.result[i].Nodes[j].LinkName?data.result[i].Nodes[j].LinkName:"") +'</span>';
                    }
                    htmlstring += '</dd>';
                    htmlstring += '</dl>';
                }

                $targetObj.find('.hby_ajaxLoading').remove();
                $targetObj.html(htmlstring);

                //构造分页
                $.getPage(data.page,data.tpage,ajaxUrl,'#'+pageId);
                //绑定点击事件
                if(!$('#'+pageId).data('isbind')){
                    $('#'+pageId+' a').live('click',function(){
                        ajaxTopic(obj,$(this).attr('href'));
                        return false;
                    });
                    $('#'+pageId).data('isbind',1);
                }

            },'json');
        }
        //我的话题
        /*if($('#my-topic-content').size()){
            ajaxTopic($('#my-topic-a'));
        };

        //我参与的话题
        if($('#my-join-content').size()) ajaxSend($('#my-join-a'));*/
        
    }
});

/*我的悄悄话*/
$(function(){
    if($("#hby_activity_myPm").size()){

        var $obj = $("#hby_activity_myPm .hby_emailBox");
        /*全选*/
        $("th input:checkbox",$obj).click(function(){
            var checkValue = this.checked;
            $.each($("td input:checkbox",$obj),function(index,obj){
                if(checkValue) this.checked = true;
                else this.checked = false;
            });
        })
        
        /*$("#hby_pmTitle h2 a").click(function(){
            $(this).parent().addClass('hby_curr').siblings('h2').removeClass('hby_curr');
            $("#hby_pmTitle").siblings().hide();
            $("#hby_pmTitle").siblings().eq($(this).parent().index()).fadeTo(600,1);
            return false;
        });*/

        /*默认页构造分页*/
        /*var x_total = $('#hby_inbox_page').attr('total');//总页数
        var x_url = '/my/pm/index?act=inbox&page={page}';//url
        $.getPage(1,x_total,x_url,'#hby_inbox_page');*/

        /*发件箱*/
        $.getPage(1,$('#hby_outbox_page').attr('total'),'/my/pm/index?act=outbox&page={page}','#hby_outbox_page');
        /*地址薄*/
        $.getPage(1,$('#hby_pmAddress_page').attr('total'),'/my/pm/index?act=ab&page={page}','#hby_pmAddress_page');

        /*收件箱--分页点击*/
        $('#hby_inbox_page a').live('click',function(){
            var url = $(this).attr('href');

            $.innerJsonData(url,'#hby_inbox_body','#hby_inbox_body_extra','#hby_inbox_page');
            return false;
        });
        /*ajax删除收件箱*/
        $('#hby_inForm_submit').click(function(){
            $('#hby_inboxForm_msgs').ajaxSubmit({dataType: 'json',success: function(data){
                if(data.error == '0'){
                   //alert('删除成功');
                    window.location.reload();
                }
                else{
                    alert(data.msgs);
                }
            }});
        });

        $('#hby_pmTitle_out').click(function(){
            var url = $(this).attr('href');


            $.innerJsonData(url,'#hby_outbox_body','#hby_outbox_body_extra','#hby_outbox_page');
            return false;
        });
        /*发件箱--分页点击*/
        $('#hby_outbox_page a').live('click',function(){
            var url = $(this).attr('href');

            $.innerJsonData(url,'#hby_outbox_body','#hby_outbox_body_extra','#hby_outbox_page');
            return false;
        });
        /*ajax删除发件箱*/
        $('#hby_outForm_submit').click(function(){
            $('#hby_outForm_msgs').ajaxSubmit(
                {
                    dataType: 'json',
                    success: function(data){
                        if(data.error == '0'){
                            alert('删除成功');
                            window.location.reload();
                        }
                        else{
                            alert(data.msgs);
                        }
                    }
                }
            );
        });

        /*ajax获取地址薄*/
        $('#hby_pmTitle_ab').click(function(){
            var url = $(this).attr('href');
            $.getJsonData(url,'#hby_pmAddress_body','#hby_pmAddress_body_extra','#hby_pmAddress_page');
            return false;
        });
        /*地址薄--分页点击*/
        $('#hby_pmAddress_page a').live('click',function(){
            var url = $(this).attr('href');
            $.getJsonData(url,'#hby_pmAddress_body','#hby_pmAddress_body_extra','#hby_pmAddress_page');
            return false;
        });

    }
});

/*我的相册首页*/
$(function(){
    if($('#special-list').size()){
        
        //创建相册
        $('#createGallery').click(function(){
            $('#layer-title-span').html('新建相册');
            $('#my-gallery-layer form').attr('action','/api/photo/addSets');
            $('#my-gallery-layer input[name="sets_name"]').val('');
            $('#my-gallery-layer [name="sets_desc"]').val('');
            $('#my-gallery-layer select[name="access"]').get(0).options[0].selected = true;
            $('#my-gallery-layer input[name="dateLine"]').val($('#my-gallery-layer input[name="dateLine"]').get(0).defaultValue);
            $('#my-gallery-layer select[name="category"]').get(0).options[0].selected = true;
            $('#my-gallery-layer input[name="sets_id"]').val('');
            $('#my-gallery-layer select[name="hide_exif"]').get(0).options[0].selected = true;
            showShade();

            var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
            var windowHeight = $(window).height();
            var topHeight = scrollTop + (windowHeight/2-100);
            $("#my-gallery-layer").css('top',topHeight).show();

        });
        //ajax提交新建相册框
        $('#my-gallery-layer form').ajaxForm({   
            dataType:'json',
            success: function(data){
                if(parseInt(data.error) == 0){
                    if($('#my-gallery-layer form input[name="sets_id"]').val()){
                        var title = $('#sets_name').val();
                        var access = $('#access').val();
                        var that = $("#my-gallery-layer").data('currGallery');
                        $(that).parents('li').first().find('.NameA').html(title);
                        if(access=='0') $(that).parents('li').first().find('.FristSpan').html('仅自己可见');
                        else $(that).parents('li').first().find('.FristSpan').html('');
                        $('#layer-close').click();
                    }
                    else{
                        window.location.reload();
                    }
                }
                else{
                    alert(data.msgs);
                }
            }
        });
        //出现编辑、删除相册链接
        $('.ImgBox').hover(function(){
            $(this).find('.Layer1').show();
        },function(){
            $(this).find('.Layer1').hide();
        });
        //删除相册
        $('.galleryDel').live('click',function(){
            var that = this;
            var num = parseInt($(this).attr('num'));
            var str = '';
            if(num == 0){
                str = '您确定要删除这个空相册吗？';
            }
            else{
                str = '相册内还有'+ num +'张照片，将一起被删除，是否删除？';
            }
            alertLayer(str,function(){
                var url = $(that).attr('ajaxUrl');
                var requestData = {};
                requestData.setID = $(that).attr('setId');
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                        window.location.reload();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            });
            
            return false;
        });
        //编辑相册
        $('.galleryEdit').live('click',function(){
            var that = this;
            var url = $(this).attr('ajaxUrl');
            var requestData = {};
            $.get(url,requestData,function(data){
                if(parseInt(data.error) == 0){
                    //记录当前编辑的相册
                    $("#my-gallery-layer").data('currGallery',that);
                    $('#layer-title-span').html('编辑相册');
                    $('#my-gallery-layer form').attr('action','/api/photo/editSets');
                    $('#my-gallery-layer input[name="sets_name"]').val(data.result.Name);
                    $('#my-gallery-layer [name="sets_desc"]').val(data.result.Description);
                    $.each($('#my-gallery-layer select[name="access"]').get(0).options,function(){
                        if(this.value == data.result.Access){
                            this.selected = true;
                        }
                    });
                    $('#my-gallery-layer input[name="dateLine"]').val(data.result.DateLine);
                    $.each($('#my-gallery-layer select[name="category"]').get(0).options,function(){
                        if(this.value == data.result.Category){
                            this.selected = true;
                        }
                    });
                    $('#my-gallery-layer input[name="sets_id"]').val(data.result.SetID);
                    $.each($('#my-gallery-layer select[name="hide_exif"]').get(0).options,function(){
                        if(this.value == data.result.HideExif){
                            this.selected = true;
                        }
                    });
                    showShade();
                    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
                    var windowHeight = $(window).height();
                    var topHeight = scrollTop + (windowHeight/2-100);
                    $("#my-gallery-layer").css('top',topHeight).show();
                }
                else{
                    alert('请求失败,请再试一次!');
                }
            },'json');
            return false;
        });
        //切换展现方式
        $('#showViewSelect').change(function(){
            var url = $(this).attr('gotourl');
            url += '&vt='+ this.value;
            window.location.href = url;
        });

    }
});

/*我的相册图片列表*/
$(function(){
    if($('#gallery-list').size()){
        //批量管理
        $('#batchManage').toggle(function(){
            $('#batchManage').attr('isOpen','1');//标志批量管理已经打开
            $('.batchManageBar').show();
            var flag = 0;
            var imgId = '';
            $.each($('.GalleryImgBox'),function(){
                if(parseInt($(this).attr('isSelect'))==1){
                    flag++;
                    $(this).find('.Layer2').show();
                    imgId += $(this).attr('imgId') + ',';
                }
            });
            $('#GalleryImgSelectedList').val(imgId);
            $('#GalleryImgSelectedNum').html(flag);
            return false;
        },function(){
            $('#batchManage').attr('isOpen','0');//标志批量管理已经关闭
            $('.batchManageBar').hide();
            $('.GalleryImgBox .Layer2').hide();
            return false;
        });
        //关闭批量管理
        $('.batchManageBar .close').click(function(){
            $('#batchManage').click();
        });
        //创建相册
        $('#createGallery').click(function(){
            if(!$('#GalleryImgSelectedList').val()){
                alert('请选择图片!');
                return false;
            }
            showShade();
            $("#my-gallery-layer").show();
            return false;
        });
        //ajax提交新建相册框
        $('#my-gallery-layer form').ajaxForm({   
            dataType:'json',
            success: function(data){
                if(parseInt(data.error) == 0){
                    var select = $('#GallerySelectListItem').get(0);
                    //清空下拉
                    var selectLength = select.options.length;
                    for(var i=0; i<selectLength; i++){
                        select.remove(1);
                    }
                    //添加新的下拉
                    for(var k=0; k<data.result.length; k++){
                        var option = new Option(data.result[k].Name, data.result[k].SetID);
                        select.options.add(option);
                    }
                    //跳到新建的相册选项
                    for(var j=0; j<select.options.length; j++){
                        if(select.options[j].value == data.new_setsID) select.options[j].selected = true;
                    }
                    $(".layer-close").click();
                    $('.batchManageBar select').change();
                }
                else{
                    alert(data.msgs);
                }
            }
        });
        //出现编辑、删除bar
        $('.GalleryImgBox').hover(function(){
            var isOpen = parseInt($('#batchManage').attr('isOpen'));
            if(isOpen){
                var isSelect = parseInt($(this).attr('isSelect'));
                if(!isSelect) $(this).find('.Layer2').show();
            }
            else{
                $(this).find('.Layer1').show();
            }
        },function(){
            var isOpen = parseInt($('#batchManage').attr('isOpen'));
            if(isOpen){
                var isSelect = parseInt($(this).attr('isSelect'));
                if(!isSelect) $(this).find('.Layer2').hide();
            }
            else{
                $(this).find('.Layer1').hide();
            }
        });
        //删除
        $('.GalleryImgDel').live('click',function(){       
            var that = this;        
            alertLayer('您确定要删除这张图片吗？',function(){
                var url = $(that).attr('ajaxUrl');
                var requestData = {};
                requestData.imgIdList = $(that).attr('imgId');
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){

                        //删除相册操作
                        $(that).parent().parent("div.Layer1").parent("div.GalleryImgBox").parent("li").remove();

                        //判断当前页面是否已经全部删完
                        var Imgbox = $("div.Gallery-changeBox ul li").size();
                        if(Imgbox<1){              
                            var total = $("div.page").attr("total"); 
                            var curPage = $("div.page").attr("page");   
                            
                            if(curPage==total){
                                if(total==1){
                                
                                }else{                      
                                    var prevPage = $("div.page ul li:first").children("a").attr("href");
                                    location.href = prevPage;
                                }
                            }else {
                                window.location.reload();
                            }
                        }             
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            });
            return false;
        });
        //选择一张图片
        $('.GalleryImgSelect').live('click',function(){
            $(this).hide();
            $(this).siblings('.GalleryImgSelected').css('display','block');
            $(this).parents('.GalleryImgBox').attr('isSelect','1');
            //计算已选数量
            var flag = 0;
            var imgId = '';
            var allNum = 0;
            $.each($('.GalleryImgBox'),function(){
                allNum ++;
                if(parseInt($(this).attr('isSelect'))==1){
                    flag++;
                    imgId += $(this).attr('imgId') + ',';
                }
            });
            $('#GalleryImgSelectedList').val(imgId);
            $('#GalleryImgSelectedNum').html(flag);
            if(allNum == flag) $('.batchManageBar input[type="checkbox"]').get(0).checked = true;
            return false;
        });
        //取消选择一张图片
        $('.GalleryImgSelected').live('click',function(){
            $(this).hide();
            $(this).siblings('.GalleryImgSelect').css('display','block');
            $(this).parents('.GalleryImgBox').attr('isSelect','0');
            $('.batchManageBar input[type="checkbox"]').get(0).checked = false;
            //计算已选数量
            var flag = 0;
            var imgId = '';
            $.each($('.GalleryImgBox'),function(){
                if(parseInt($(this).attr('isSelect'))==1){
                    flag++;
                    imgId += $(this).attr('imgId') + ',';
                }
            });
            $('#GalleryImgSelectedList').val(imgId);
            $('#GalleryImgSelectedNum').html(flag);
            return false;
        });
        //全选
        $('.batchManageBar input[type="checkbox"]').click(function(){
            if(this.checked){//全选
                $('.GalleryImgBox .Layer2').show();
                $('.GalleryImgBox').attr('isSelect','1');
                $('.GalleryImgSelect').css('display','none');
                $('.GalleryImgSelected').css('display','block');
            }
            else{//全不选
                
                $('.GalleryImgBox').attr('isSelect','0');
                $('.GalleryImgSelected').css('display','none');
                $('.GalleryImgSelect').css('display','block');
                $('.GalleryImgBox .Layer2').hide();
                
            }
            //计算已选数量
            var flag = 0;
            var imgId = '';
            $.each($('.GalleryImgBox'),function(){
                if(parseInt($(this).attr('isSelect'))==1){
                    flag++;
                    imgId += $(this).attr('imgId') + ',';
                }
            });
            $('#GalleryImgSelectedList').val(imgId);
            $('#GalleryImgSelectedNum').html(flag);
        });
        //移动到
        $('.batchManageBar select').change(function(){
            var selectValue = this.value;
            var curr_sid = $('#GallerySelectListItem').attr('curr_sid');
            if(parseInt(selectValue)==0 || selectValue == curr_sid) return false;
            if(!$('#GalleryImgSelectedList').val()){
                alert('请选择图片!');
                $('#GallerySelectListItem').get(0).options[0].selected = true;
                return false;
            }
            var that = this;
            alertLayer('您确定要移动选中的图片到'+ this.options[this.selectedIndex].innerHTML +'吗？',function(){
                var url = $(that).attr('ajaxUrl');
                var requestData = {};
                requestData.setsID = that.value;
                var imgIdList = $('#GalleryImgSelectedList').val();
                imgIdList = imgIdList.substr(0,imgIdList.length-1);
                requestData.imgIdList = imgIdList;
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                        window.location.reload();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            },function(){
                $('#GallerySelectListItem').get(0).options[0].selected = true;
            });

        });
        //批量删除
        $('#batchDel').click(function(){
            if(!$('#GalleryImgSelectedList').val()){
                alert('您还没有选择任何图片！');
                return false;
            }
            var that = this;
            alertLayer('您确定要批量删除选中的图片吗？',function(){
                var url = $(that).attr('ajaxUrl');
                var requestData = {};
                var imgIdList = $('#GalleryImgSelectedList').val();
                imgIdList = imgIdList.substr(0,imgIdList.length-1);
                                
                requestData.imgIdList = imgIdList;
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                       
                        //删除相册操作
                        var curIdx = imgIdList.split(',');      
                        $(curIdx).each(function(i) {
                            $("div.Gallery-changeBox ul li").each(function(b){
                                var all_id = $(this).children("div").attr("imgid");
                                if(curIdx[i]==all_id){
                                    $(this).remove();
                                }
                            });
                        });

                         //判断当前页面是否已经全部删完
                        var Imgbox = $("div.Gallery-changeBox ul li").size();
                        if(Imgbox<1){              
                            var total = $("div.page").attr("total"); 
                            var curPage = $("div.page").attr("page");   
                            
                            if(curPage==total){
                                if(total==1){
                                
                                }else{                      
                                    var prevPage = $("div.page ul li:first").children("a").attr("href");
                                    location.href = prevPage;
                                }
                            }else {
                                window.location.reload();
                            }
                        } 
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
           });

            return false;
        });
        //让图片垂直居中
        /*var boxHeight = $('.GalleryImgBox').height();
        $('.GalleryImgBox img').hide();
        $('.GalleryImgBox img').load(function(){
            var height = $(this).fadeIn(400).height();
            if(height<boxHeight){
                $(this).css('marginTop',(boxHeight-height)/2);
            }
        });*/
    }
});

/*我的图片详细页*/
$(function(){
    if($('#gallery-datail').size()){

        //加载相册图片
        var url = $('#gallery').attr('ajaxUrl');
        var imgID = $('#gallery').attr('curr_photoID');
        var is_cover = $('#gallery').attr('is_cover');
        var setID = $('#gallery').attr('setID');
        var photoUserID = $('#gallery').attr('photoUserID');
        var flag = 0;
        var requestData = {};
        $.get(url,requestData,function(data){
            if(parseInt(data.error)==0){
                $('#photoViewBox').remove();

                var htmlString = '';

                for(var k=0; k<parseInt(data.total); k++){
                    htmlString += '<li imgID="" ajaxUrl="">';
                    htmlString += '<img exif="" photoid="" tit="" time="" des="" data-origin="" src="about:blank" real-src="" comments="" is_cover="">';
                    htmlString += '</li>';
                }

                $('#gallery ul').html(htmlString);

                htmlString = '';

                var curr_flag = parseInt(data.pos);
                for(var j=0; j<data.result.length; j++){
                    if(data.result[j].PhotoID == imgID) curr_flag = curr_flag - (j + 1);
                }
                
                var $galleryLi = $('#gallery li');
                var $photoSliderLi = $('#photoSliderUl').find('li');
                for(var i=0; i<data.result.length; i++){
                    var Exif = data.result[i].Exif == null ? '' : data.result[i].Exif;
                    var Description = data.result[i].Description;
                    var UploadDate = new Date(parseInt(data.result[i].UploadDate)*1000);
                    UploadDate = UploadDate.format('yyyy-MM-dd HH:mm:ss');
                    var is_coverValue = is_cover == data.result[i].PhotoID ? 1 : 0;
                    //更新origin数据
                    var $gtemp_li = $galleryLi.eq(curr_flag+i);
                    var $gtemp_img = $gtemp_li.find('img').first();
                    $gtemp_li.attr('imgID',data.result[i].PhotoID).attr('ajaxUrl','/api/photo/getPhotoComments?photo_id='+data.result[i].PhotoID);
                    $gtemp_img.attr('exif',Exif).attr('photoid',data.result[i].PhotoID).attr('tit',data.result[i].Title).attr('time','上传于'+UploadDate).attr('des',Description).attr('data-origin',data.result[i].Image_b).attr('real-src',data.result[i].Image_s).attr('comments',data.result[i].Comments).attr('is_cover',is_coverValue);
                    //更新photoNav数据
                    var $ptemp_li = $photoSliderLi.eq(curr_flag+i);
                    var $ptemp_img = $ptemp_li.find('img').first();
                    $ptemp_img.attr('src',data.result[i].Image_s).attr('real-src',data.result[i].Image_s);
                }

                var firstId = '';
                var isContinu = true;
                var lastId = '';
                $.each($galleryLi,function(index){
                    var t_imgID = $(this).attr('imgID');
                    if(t_imgID&&!firstId) firstId = t_imgID;
                    if(firstId&&!t_imgID) isContinu = false;
                    if(t_imgID) lastId = t_imgID;
                    if(t_imgID == imgID) flag = index;
                });

                window.gz = $("#gallery").freesaGallery({"index" : flag});
                //初始化分页参数
                gz.requestUrl = '/api/photo/getPhotoPage/';
                gz.requestData = {'set_id':setID, 'photo_user_id':photoUserID, 'fr':'my', 'perpage':30};
                gz.firstId = data.result[0].PhotoID;
                gz.lastId = data.result[data.result.length-1].PhotoID;

                //悉放内存
                $photoSliderLi = '';
                $galleryLi = '';

            }
            else{
                alert(data.msgs);
            }
        },'json');

        //点击编辑名称
        $('#photoTitleSpan').click(function(){
            $(this).hide();
            //var width = $(this).width();
            //if(width < 150) width = 150;
            var width = 300;
            $('#photoTitleInput').val($(this).html()).css('width',width).fadeIn(600).focus();
            toEnd($('#photoTitleInput'));
        }).hover(function(){
            $(this).css({borderColor:'#000',borderRadius:'3px'});
        },function(){
            $(this).css({borderColor:'#fff'});
        });
        $('#photoTitleInput').focus(function(){
            document.isfocus = true;
        }).blur(function(){
            document.isfocus = false;
            var oldValue = $.trim($('#photoTitleSpan').html());
            var newValue = $.trim($(this).val());
            var that = this;
            if(oldValue == newValue || !newValue){
                $(this).hide();
                $('#photoTitleSpan').fadeIn(600);
            }
            else{
                var url = $(this).attr('ajaxUrl');
                var requestData = {};
                requestData.imgId = $('[name="photo_id"]').val();
                requestData.imgTitle = newValue;
                $('<div class="ajaxloading"></div>').insertAfter($(this).parent());
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                        $(that).parent().nextAll('.ajaxloading').remove();
                        $(that).hide();
                        $('#photoTitleSpan').html(newValue).fadeIn(600);
                        $('#origin_ul img[photoid="'+ requestData.imgId +'"]').attr('tit',newValue);
                    }
                    else{
                        alert(data.msgs,function(){
                            $(that).focus();
                        });
                        $(that).parent().nextAll('.ajaxloading').remove();
                    }
                },'json');
            }
        });
        //点击编辑简介
        $('#photoDescription').click(function(){
            $(this).hide();
            $('#photoDescriptionForm').fadeIn(600);
            var editValue = $(this).html();
            if(editValue == '点击分享照片故事') editValue = '';
            $('#photoDescriptionForm textarea').val(editValue).focus();
        }).hover(function(){
            $(this).css({borderColor:'#000',borderRadius:'3px'});
        },function(){
            $(this).css({borderColor:'#fff'});
        });
        $('#photoDescriptionFormButton').click(function(){
            var oldValue = $.trim($('#photoDescription').html());
            var newValue = $.trim($('#photoDescriptionForm textarea').val());
            var that = this;
            if(oldValue == newValue){
                $('#photoDescriptionForm').hide();
                $('#photoDescription').fadeIn(600);
            }
            else{
                var url = $(this).attr('ajaxUrl');
                var requestData = {};
                requestData.imgId = $('[name="photo_id"]').val();
                requestData.imgDesc = newValue;
                $('<div class="ajaxloading"></div>').insertAfter($(this));
                $('#photoDescriptionFormA').hide();
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                        $('#photoDescriptionForm').find('.ajaxloading').remove();
                        $('#photoDescriptionFormA').show();
                        $('#photoDescriptionForm').hide();
                        $('#photoDescriptionForm textarea').val('');
                        $('#photoDescription').html(newValue!=''?newValue:'点击分享照片故事').fadeIn(600);
                        $('#origin_ul img[photoid="'+ requestData.imgId +'"]').attr('des',newValue);
                    }
                    else{
                        alert(data.msgs);
                        $('#photoDescriptionFormA').show();
                        $('#photoDescriptionForm').find('.ajaxloading').remove();
                        $('#photoDescriptionFormA').show();
                        $('#photoDescriptionForm textarea').focus();
                    }
                },'json');
            }
        });
        $('#photoDescriptionForm textarea').focus(function(){
            showWords(this);
            document.isfocus = true;
        }).blur(function(){
            document.isfocus = false;
        }).keyup(function(){
            clearTimeout(document.pasetTime1);
            showWords(this);
        });
        if($('#photoDescriptionForm textarea').size()){
            $('#photoDescriptionForm textarea').get(0).onpaste = function(){
                var that = this;
                document.pasetTime1 = setTimeout(function(){
                    showWords(that);
                },200);
            }
        }
        //取消编辑
        $('#photoDescriptionFormA').click(function(){
            $('#photoDescriptionForm').hide();
            $('#photoDescription').fadeIn(600);
            return false;
        });
    }
});

/*我的相册图片编辑*/
$(function(){
    if($('#gallery-edit').size()){
        //创建相册
        $('#createGallery').click(function(){
            showShade();
            $("#my-gallery-layer").show();
        });
        //ajax提交新建相册框
        $('#my-gallery-layer form').ajaxForm({   
            dataType:'json',
            success: function(data){
                if(parseInt(data.error) == 0){
                    var select = $('#GallerySelectListItem').get(0);
                    //清空下拉
                    var selectLength = select.options.length;
                    for(var i=0; i<selectLength; i++){
                        select.remove(1);
                    }
                    //添加新的下拉
                    for(var k=0; k<data.result.length; k++){
                        var option = new Option(data.result[k].Name, data.result[k].SetID);
                        select.options.add(option);
                    }
                    //跳到新建的相册选项
                    for(var j=0; j<select.options.length; j++){
                        if(select.options[j].value == data.new_setsID) select.options[j].selected = true;
                    }
                    $(".layer-close").click();
                }
                else{
                    alert(data.msgs);
                }
            }
        });
    }
});

//个人主页开始

/*相册查看大图*/
//刷新回复
function refreshRelyList(id){
    id = (id == undefined) ? '' : id;
    var url = $('#RelyListBox'+id).attr('ajaxUrl');
    var requestData = {};
    requestData.photo_id = $('#RelyForm'+ id +' input[name="photo_id"]').val();
    $.get(url,requestData,function(data){
        if(parseInt(data.error) == 0){
            //把表单放到最后
            $('#RelyForm'+id).insertAfter($('#RelyListBox'+id));

            var htmlString = '';
            if(data.result.length){
                for(var i=0; i<data.result.length; i++){
                    htmlString += '<div class="RelyList" parent_id="'+ data.result[i][0].CommentID +'">';
                    for(var j=0; j<data.result[i].length; j++){
                        if(j==0) 
                            htmlString += '<dl>';
                        else
                            htmlString += '<dl class="RelyDl">';

                            htmlString +=    '<dd class="Img"><a href="/user/'+ data.result[i][j].UserID +'"><img src="'+ data.result[i][j].Face +'" alt=""></a></dd>';
                            htmlString +=    '<dt><a href="#" rel="info_user_'+ data.result[i][j].UserID +'" class="info_user pr16">'+ data.result[i][j].UserName +'</a><span>'+ data.result[i][j].Content +'</span></dt>';
                            htmlString +=    '<dd class="Des">';
                            htmlString +=        '<span class="Time">'+ data.result[i][j].CreatedTime +'</span>';
                            htmlString +=        '<a href="#" class="RelyLink" userName="'+ data.result[i][j].UserName +'" forid="'+ id +'" comment_id="'+ data.result[i][j].CommentID +'">回复</a>';
                            htmlString +=        '<a href="#" class="DelLink" ajaxUrl="/api/photo/delPhotoComment?photo_id='+ data.result[i][j].PhotoID +'&comment_id='+ data.result[i][j].CommentID +'">删除</a>';
                            htmlString +=    '</dd>';
                            htmlString +=    '<dd class="clear"></dd>';
                            htmlString += '</dl>';
                    }
                    htmlString += '</div>';
                }
                $('#RelyListContent'+id).html(htmlString);
            }
            else{
                $('#RelyListContent'+id).html('<p class="NoContent">这张图片还没有评论，赶快评一个吧！</p>');
            }
        }
        else{
            alert(data.msgs);
        }
    },'json');
}
//大图居中函数
function imgCenter(w){
    var parentHeight = $('.imgWrapper').first().height();
    var imgHeight = $('.imgWrapper img').first().height();
    if(!imgHeight&&w) imgHeight = w;
    var marginTop = 0;
    if(parentHeight > imgHeight){
        marginTop = (parentHeight-imgHeight)/2;
    }
    $('.imgWrapper img').css('marginTop',marginTop);
}
//光标移动函数
function toEnd(obj){
    if(obj.size()) obj = obj.get(0);
    if (obj.createTextRange) {
        //IE浏览器 
        var range = obj.createTextRange(); 
        range.moveStart("character", obj.value.length);
        range.moveEnd("character", obj.value.length); 
        range.collapse(true); 
        range.select();
    } 
    else {
        //非IE浏览器 
        obj.setSelectionRange(obj.value.length, obj.value.length); 
        obj.focus();
    }
}
//获取上下内间距
function getPaddingTB(obj){
    return parseInt($(obj).css('paddingTop')) + parseInt($(obj).css('paddingBottom'));
}
//获取左右外间距
function getMarginTB(obj){
    return parseInt($(obj).css('marginLeft')) + parseInt($(obj).css('marginRight'));
}
//右边容器改变函数
function changeRightSize(height){
    var formHeight = $('#RelyForm').height() + getPaddingTB($('#RelyForm'));
    var $title = $('#RelyListBox .RelyTitle');
    var titleHeight = $title.height() + getPaddingTB($title);
    var $info = $('#RelyListBox .RelyInfo');
    var infoHeight = $info.height() + getPaddingTB($info);
    var $numBox = $('#RelyListBox .RelyNumBox');
    var numBoxHeight = $numBox.height() + getPaddingTB($numBox);
    var tableHeight = height || $('#galleryFloatLayer table').first().height();
    var maxHeight = tableHeight - numBoxHeight - infoHeight - titleHeight - formHeight;
    $('#RelyListContent').css('maxHeight',maxHeight);
}
//窗口大小改变函数
var IE7 = false;
if($.browser.msie && $.browser.version.indexOf('7') != -1) IE7 = true;

function changeSize(){
    var maxHeight = 1000;
    var minHeight = 300;
    var rate = 1.6;
    var topHeight = 94;
    var $galleryFloatLayer = $('#galleryFloatLayer');
    var clientWidth = $(window).width();
    var windowHeight = $(window).height();
    if(windowHeight < 600) topHeight = 74;
    if(windowHeight < 450) topHeight = 20;
    var tableHeight = windowHeight - topHeight;
    var floatLayerWidth = tableHeight*rate + 30;
    //判读宽度够不够
    if(floatLayerWidth > clientWidth){
        floatLayerWidth = clientWidth - 20;
        tableHeight = parseInt(floatLayerWidth/rate);
    }
    $galleryFloatLayer.css('width',floatLayerWidth);
    var width = $galleryFloatLayer.width();
    var marginLeft = 0;

    if(clientWidth < width){
        marginLeft = (width - clientWidth)/2;
    }
    $galleryFloatLayer.css('marginLeft' , (marginLeft-width/2));

    //改变左容器的尺寸
    var $tableWrapper = $galleryFloatLayer.find('table').first();
    if(tableHeight > maxHeight) tableHeight = maxHeight;
    if(tableHeight < minHeight) tableHeight = minHeight;
    $tableWrapper.css('height',tableHeight);
    $galleryFloatLayer.css('top',(windowHeight-tableHeight)/2);
    if(IE7){
        var $imgTd1 = $galleryFloatLayer.find('.td1').first();
        $imgTd1.css('width',width-290);
    }
    var $imgWrapper = $galleryFloatLayer.find('.imgWrapper').first();
    $imgWrapper.css('height',tableHeight-30).css('width',width-290-60);
    //改变图片导航的宽度
    var $imgPhotoNav = $galleryFloatLayer.find('.photoNav').first();
    var navWidth = width - 290;
    var temp_navWidth = navWidth;
    if(typeof gz != 'undefined'){
        var $photoSliderUl = $galleryFloatLayer.find('.photoSliderUl').first();
        var marginWidth = getMarginTB($photoSliderUl);
        var marginRightWidth = parseInt($photoSliderUl.find('li').first().css('marginRight'));
        var navNum = Math.floor((navWidth - marginWidth + marginRightWidth)/gz.navWidth);
        gz.navLen = navNum;
        navWidth = navNum*gz.navWidth - marginRightWidth + marginWidth;
    }
    $imgPhotoNav.css('width',navWidth).css('left',parseInt(temp_navWidth-navWidth)/2);
    var $imgPhotoNavBg = $galleryFloatLayer.find('.photoNavBg').first();
    $imgPhotoNavBg.css('width',width - 290);
    //改变右边容器的高度
    changeRightSize(tableHeight);
    //图片居中
    imgCenter();
}

//计算字符数函数
function showWords(obj){
    var value = $.trim($(obj).val());
    //var reg = /[\u4E00-\u9FA5]/g;
    var limit = 140;
    var $parent = $(obj).parents('form').first();
    /*if(reg.test(value)){
        var flag = 0;
        for(var i=0; i<value.length; i++){
            if(value[i] == '*'){
                flag++;
            }
        }
        var tem_value = value.replace(reg,'**');
        var len = Math.round(tem_value.length/2);
        if(len <= limit){
            $parent.find('.AllWords i').html(len);
        }
        else{
            //alert('已达到最大字数限制！您最多可以输入140个字符、70个汉字。');
            $parent.find('.AllWords i').html(limit);
            var tem_len = tem_value.substr(0,limit*2).replace(/[^*]/g,'').length - flag;
            tem_len = Math.round(tem_len/2);
            $(obj).val(value.substr(0,limit*2-tem_len));
        }
    }
    else{*/
    var len = value.length;
    if(len <= limit){
        $parent.find('.AllWords i').html(len);
    }
    else{
        //alert('已达到最大字数限制！您最多可以输入140个字符、70个汉字。');
        $parent.find('.AllWords i').html(limit);
        $(obj).val(value.substr(0,limit));
    }
    //}
}

//个人主页-操作大图
$(function(){
    if($('.RelyListBox').size() || $('#DynamicBoxWithMy').size()){

        if($('#my-perHomePage').size()){
            //根据分辨率改变弹出层大小
            //var screenWidth = window.screen.width;
            //if(screenWidth <= 1024) $('#galleryFloatLayer').addClass('galleryFloatLayer1');
            //窗口大小改变事件
            window.onresize = changeSize;
            changeSize();
            //点击图片查看大图
            $('.ViewBigImg').live('click',function(){

                //把滚动条隐藏
                $('body').css('overflow','hidden');
                if(IE7){
                    $('html').css('overflow','hidden');
                }

                showShade(1);
                document.documentElement.scrollTop = 0;
                document.body.scrollTop = 0;

                var $galleryUl = $('#gallery ul');
                var $parentLI = $(this).parents('li').first();
                var imgID = $parentLI.attr('imgID');
                var setID = $parentLI.attr('setID');
                var photoUserID = $parentLI.attr('photoUserID');
                var flag = 0;

                var is_load = $('#galleryFloatLayer').attr('is_load');
                
                var url = $parentLI.attr('ajaxUrl');
                var requestData = {};
                $.get(url,requestData,function(data){
                    if(parseInt(data.error)==0){
                        $('#photoViewBox').remove();
                        //$('#photoTitle').show();
                        if(!$galleryUl.children().length){
                            var htmlString = '';
                            
                            for(var k=0; k<parseInt(data.total); k++){
                                htmlString += '<li imgID="" ajaxUrl="">';
                                htmlString += '<img exif="" photoid="" tit="" time="" des="" data-origin="" src="about:blank" real-src="" comments="">';
                                htmlString += '</li>';
                            }

                            $galleryUl.html(htmlString);
                            htmlString = '';
                            
                        }
                        var curr_flag = parseInt(data.pos);
                        for(var j=0; j<data.result.length; j++){
                            if(data.result[j].PhotoID == imgID) curr_flag = curr_flag - (j + 1);
                        }

                        var $photoSliderLi = $('#photoSliderUl').find('li');
                        var $galleryLi = $galleryUl.find('li');
                        for(var i=0; i<data.result.length; i++){
                            var Exif = data.result[i].Exif == null ? '' : data.result[i].Exif;
                            var Description = data.result[i].Description;
                            var UploadDate = new Date(parseInt(data.result[i].UploadDate)*1000);
                            UploadDate = UploadDate.format('yyyy-MM-dd HH:mm:ss');
                            //更新origin数据
                            var $gtemp_li = $galleryLi.eq(curr_flag+i);
                            var $gtemp_img = $gtemp_li.find('img').first();
                            $gtemp_li.attr('imgID',data.result[i].PhotoID).attr('ajaxUrl','/api/photo/getPhotoComments?photo_id='+data.result[i].PhotoID);
                            $gtemp_img.attr('exif',Exif).attr('photoid',data.result[i].PhotoID).attr('tit',data.result[i].Title).attr('time','上传于'+UploadDate).attr('des',Description).attr('data-origin',data.result[i].Image_b).attr('real-src',data.result[i].Image_s).attr('comments',data.result[i].Comments);
                            //更新photoNav数据
                            //var $ptemp_li = $('.photoSliderUl li:eq('+ (curr_flag+i) +')');
                            var $ptemp_li = $photoSliderLi.eq(curr_flag+i);
                            var $ptemp_img = $ptemp_li.find('img').first();
                            $ptemp_img.attr('src',data.result[i].Image_s).attr('real-src',data.result[i].Image_s);
                        }

                        /*for(var i=0; i<data.result.length; i++){
                            var Exif = data.result[i].Exif == null ? '' : data.result[i].Exif;
                            var Description = data.result[i].Description;
                            var UploadDate = new Date(parseInt(data.result[i].UploadDate)*1000);
                            UploadDate = UploadDate.format('yyyy-MM-dd HH:mm:ss');
                            htmlString += '<li imgID="'+ data.result[i].PhotoID +'" ajaxUrl="/api/photo/getPhotoComments?photo_id='+ data.result[i].PhotoID +'">';
                            htmlString += '<img exif="'+ Exif +'" photoid="'+ data.result[i].PhotoID +'" tit="'+ data.result[i].Title +'" time="上传于'+ UploadDate +'" des="'+ Description +'" data-origin="'+ data.result[i].Image_b +'" src="about:blank" real-src="'+ data.result[i].Image_s +'" comments="'+ data.result[i].Comments +'">';
                            htmlString += '</li>';
                        }*/
                        //$galleryUl.html(htmlString);
                        var firstId = '';
                        var isContinu = true;
                        var lastId = '';

                        $.each($galleryLi,function(index){
                            var t_imgID = $(this).attr('imgID');
                            if(t_imgID&&!firstId) firstId = t_imgID;
                            if(firstId&&!t_imgID) isContinu = false;
                            if(t_imgID) lastId = t_imgID;
                            if(t_imgID == imgID) flag = index;
                        });

                        if(!is_load){
                            window.gz = $("#gallery").freesaGallery({"index" : flag, "navWidth" : 66 });
                            //初始化分页参数
                            gz.requestUrl = '/api/photo/getPhotoPage/';
                            gz.requestData = {'set_id':setID, 'photo_user_id':photoUserID, 'perpage':30};
                            gz.firstId = data.result[0].PhotoID;
                            gz.lastId = data.result[data.result.length-1].PhotoID;
                            $('#galleryFloatLayer').attr('is_load',1);

                            //根据窗口调整
                            changeSize();
                        }
                        else{
                            if(isContinu){
                                gz.firstId = firstId;
                                gz.lastId = lastId;
                            }
                            else{
                                gz.firstId = data.result[0].PhotoID;
                                gz.lastId = data.result[data.result.length-1].PhotoID;
                            }
                            //定位
                            window.gz.show(flag);
                        }
                        //悉放内存
                        $photoSliderLi = '';
                        $galleryLi = '';

                    }
                    else{
                        alert(data.msgs);
                        $('#galleryFloatLayer').hide();
                    }
                },'json');

                $('#galleryFloatLayer,#galleryFloatLayerBox').show();
                return false;
            });
        }

        //关闭回复
        $('#galleryFloatLayerClose').click(function(){
            //显示滚动条
            $('body').css('overflow','');
            if(IE7) $('html').css('overflow','');
            $('#galleryFloatLayer,#galleryFloatLayerBox').hide();
            closeShade();
            return false;
        });
        //回复
        $('.RelyListBox .RelyLink').live('click',function(){
            var id = $(this).attr('forid');
            var content = $.trim($('#RelyForm'+ id +' [name="photo_comment"]').val());
            if(content.length) document.isInputContent = true;
            else document.isInputContent = false;

            /*if(document.isInputContent){
                if(!confirm('您确认要放弃正在编辑的评论吗？')){
                    return false;
                }
            }*/

            //var $dl = $(this).parents('dl').first();
            //$('#RelyForm'+ id).insertAfter($dl);
            $('#RelyForm'+ id +' input[name="parent_id"]').val($(this).parents('.RelyList').first().attr('parent_id'));
            $('#RelyForm'+ id +' input[name="comment_id"]').val($(this).attr('comment_id'));
            //$('#RelyForm'+ id +' [name="photo_comment"]').val('回复 @'+$(this).attr('userName')+' ：').focus();
            $('#RelyForm'+ id +' .RelyWho').show();
            $('#RelyForm'+ id +' .RelyWho span').html($(this).attr('userName'));
            $('#RelyForm'+ id +' [name="photo_comment"]').focus();
            return false;
        });
        //取消回复
        $('.RelyForm .RelyWho a').live('click',function(){
            $(this).parents('.RelyWho').first().hide();
            var form = $(this).parents('form').first();
            form.find('input[name="parent_id"]').val('0');
            form.find('input[name="comment_id"]').val(form.find('input[name="comment_id"]').attr('oldValue'));
            return false;
        });
        //提交回复
        $('.RelyForm form').live('submit',function(){
            var that = this;
            if(!$.trim($(this).find('[name="photo_comment"]').val())){
                alert('您还没有输入留言!');
                $(this).find('[name="photo_comment"]').focus();
                return false;
            }
            $(this).ajaxSubmit({
                dataType:'json',
                success: function(data){
                    if(parseInt(data.error) == 0){
                        $(that).find('[name="photo_comment"]').val('');
                        $(that).find('.AllWords i').html('0');
                        var id = $(that).attr('RelyID');
                        refreshRelyList(id);//刷新回复

                        //清除回复的人
                        $(that).find('.RelyWho a').click();

                        //改变评论数
                        $('#span_'+$('#RelyForm [name="photo_id"]').val()).html(data.total);
                        $('#photoCommentSpan').html(data.total);
                        //alert(data.msgs);
                    }
                    else{
                        alert(data.msgs);
                    }
                }
            });
            return false;
        });

        //输入框聚焦的时候，取消键盘事件
        $('.RelyForm textarea').focus(function(){
            document.isfocus = true;
        }).blur(function(){
            document.isfocus = false;
        }).live('keyup',function(){
            clearTimeout(document.pasetTime);
            showWords(this);
        });
        if($('.RelyForm textarea').size()){
            $('.RelyForm textarea').get(0).onpaste = function(){
                var that = this;
                document.pasetTime = setTimeout(function(){
                    showWords(that);
                },200);
            }
        }

        //删除
        $('#RelyListBox .DelLink').live('click',function(){
            var that = this;
            var url = $(this).attr('ajaxUrl');
            alertLayer('您确定要删除这条评论吗?',function(){
                $.get(url,function(data){
                    if(parseInt(data.error) == 0){
                        refreshRelyList();//刷新回复
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            });
            return false;
        });

        //按ESC键或者点击空白处退出大图
        if($('#galleryFloatLayer').size()){
            $(document.body).keydown(function(obj){
                return function(e){
                    var code = e.keyCode;
                    if(code == 27){
                        $('#galleryFloatLayerClose').click();
                    }
                }
            }(this));
            $(document.body).click(function(obj){
                return function(e){
                    var target = e.target;
                    if(target.id == 'galleryFloatLayerBox'){
                        $('#galleryFloatLayerClose').click();
                    }
                }
            }(this));
        }

        //鼠标移动到上方的时候出现导航栏
        $('.galleryFloatLayer .galleryTable').mousemove(function(e){
            var clientX = e.clientX;
            var clientY = e.clientY;
            var position = $(this).offset();
            var left = position.left;
            var top = position.top;
            var $photoNav = $('.photoNav').first();
            var $photoNavBg = $('.photoNavBg').first();
            var width = $photoNavBg.width();
            var height = 130;
            if((0 < clientX - left && clientX - left < width) && (0 < clientY - top && clientY - top < height)){
                clearTimeout(document.photoNavTime);
                if($photoNav.attr('isShow') == '1') return;

                $photoNav.attr('isShow','1');
                $photoNav.css('visibility','visible').hide();
                $photoNavBg.css('visibility','visible').hide();

                $photoNav.stop().fadeIn(600);
                $photoNavBg.stop().fadeTo(600,0.5);

            }
            else{
                if($photoNav.attr('isShow') == '0') return;
                $photoNav.attr('isShow','0');
                //document.photoNavTime = setTimeout(function(){
                    $photoNav.stop().fadeOut(600);
                    $photoNavBg.stop().fadeOut(600);
                //},600);
            }
        }).mouseleave(function(e){
            var $photoNav = $('.photoNav').first();
            var $photoNavBg = $('.photoNavBg').first();
            if($photoNav.attr('isShow') == '0') return;
            $photoNav.attr('isShow','0');
            $photoNav.stop().fadeOut(600);
            $photoNavBg.stop().fadeOut(600);
        });

    }
    if($('#photoTitle').size()){
        //图片查看页删除
        $('#photoTitle .del').click(function(){
            var that = this;
            alertLayer('您确定要删除这张图片吗?',function(){
                var url = $(that).attr('ajaxUrl');
                var sid = $(that).attr('sid');
                $.get(url,function(data){
                    if(parseInt(data.error) == 0){
                        //alert(data.msgs);
                        //跳到下一张
                        gz.length = gz.length - 1;
                        if(gz.length < 1){
                            window.location.href = '/gallery/gallery/?sid=' + sid;
                        }
                        else{
                            $('.photoSliderUl .hov').first().remove();
                            gz.origin.find('li:eq('+ gz.index +')').remove();
                            $('.imgWrapper img').first().attr('src','');
                            if((gz.index+1) < gz.length) gz.show(gz.index);
                            else gz.show(0);
                        }
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
            });
            return false;
        });
        //设置为封面
        $('#photoTitle .setCover').click(function(){
            var url = $(this).attr('ajaxUrl');
            var requestData = {};
            requestData.imgId = $(this).attr('photoID');
            $.get(url,requestData,function(data){
                if(parseInt(data.error) == 0){
                    alert(data.msgs);
                    //改变封面
                    $('#photoTitle .setCover').hide();
                    $('.IsCoverBox').show();
                    $('#origin_ul img').attr('is_cover',0);
                    $('#origin_ul img[photoid="'+ requestData.imgId +'"]').attr('is_cover',1);
                    //window.location.reload();
                }
                else{
                    alert(data.msgs);
                }
            },'json');
            return false;
        });
        //显示相机详细信息
        $('#ShowCameraImg').hover(function(){
            var position = $(this).position();
            var left = position.left - 34;
            var top = position.top + 21;
            clearTimeout(document.ShowCamera);
            $('.ShowCameraBox').show().css({'top':top,'left':left});
        },function(e){
            document.ShowCamera = setTimeout(function(){
                $('.ShowCameraBox').hide();
            },500);
        });
        $('.ShowCameraBox').hover(function(){
            clearTimeout(document.ShowCamera);
        },function(){
            document.ShowCamera = setTimeout(function(){
                $('.ShowCameraBox').hide();
            },500);
        });
    }
});

/*个人主页*/
$(function(){
    if($('#my-perHomePage').size()){

        //添加关注
        $('.addFollow').click(function(){
            var ajaxUrl = $(this).attr('ajaxUrl');
            var that = this;
            $.get(ajaxUrl,function(data){
                if(data.error==0){//成功
                    window.location.reload();
                }
                else{
                    alert(data.msgs);
                }
            },'json');
            return false;
        });
        
        //取消关注
        $('.cancelFollow').click(function(){
            var ajaxUrl = $(this).attr('ajaxUrl');
            var that = this;
            alertLayer('您确定要取消关注吗？',function(){
                $.get(ajaxUrl,function(data){
                    if(data.error==0){//成功
                        window.location.reload();
                    }
                    else{
                        alert(data.msgs);
                    }
                },'json');
             });
            return false;
        });
        
        //我关注的人
        if($('#my-interest-per').size()){
            ajaxSend($('#my-interest-per'),function(data){
                //if(parseInt(data.total)==0) $('#my-interest-per').html('<div class="pt20 pl10 pb20">'+ data.result +'</div>');
                $('#my-interest-num').html(data.total);
            });
        }

        //关注我的人
        if($('#per-interest-my').size()){
            ajaxSend($('#per-interest-my'),function(data){
                //if(parseInt(data.total)==0) $('#per-interest-my').html('<div class="pt20 pl10 pb20">'+ data.result +'</div>');
                $('#per-interest-num').html(data.total);
            });
        }

        //我的相册
        if($('#my-photo-a').size()){//如果相册存在
            //加载相册文件夹
            if(!$('#my-PhoteFolder').data('ishave')){
                ajaxSend($('#my-PhoteFolder'),function(){
                    //相册上下切换
                    var $slideBox = $("#PhotoFolderList");//容器（必须参数）
                    var $slideObj = $slideBox.children();//滑动对象（必须参数）
                    var $pre = $slideBox.siblings('.photoUp');//左按钮（必须参数）
                    var $next = $slideBox.siblings('.photoDown');//右按钮（必须参数）
                    var len = 2;//显示的数量
                    //var autoPlay = true;//是否自动滑动、默认是false（可选参数）
                    //var nextTime = 3000;//自动滑动的时间间隔、默认是3000（可选参数）
                    var newSlide = new slide($slideBox,$slideObj,$pre,$next,len,'vertical');
                    newSlide.init();
                });
                $('#my-PhoteFolder').data('ishave',1);
            }
            //加载相册列表
            //ajaxSend($('#my-photo-a'),function(){});
        }

        //相册专辑
        $('#my-PhoteFolder a').live('click',function(){
            ajaxSend($(this).parents('li').first());
            return false;
        });

        //粉丝/关注
        $('#my-follow-more').click(function(){
            $('#my-follow-a').attr('sourceId','my-follow-template');
            $('#my-follow-a').attr('ajaxUrl',$(this).attr('ajaxUrl'));
            $('#my-follow-a').attr('href','#my-follow');
            $('.my-follow-fans').attr('id','my-follow');
            location.hash = 'my-follow';
            return false;
        });
        $('#my-fans-more').click(function(){
            $('#my-follow-a').attr('sourceId','my-fans-template');
            $('#my-follow-a').attr('ajaxUrl',$(this).attr('ajaxUrl'));
            $('#my-follow-a').attr('href','#my-fans');
            $('.my-follow-fans').attr('id','my-fans');
            location.hash = 'my-fans';
            return false;
        });

        /*下拉*/
        $('#my-perHomePage .DownLi').hover(function(){
            $(this).addClass('DownLi_curr');
        },function(){
            $(this).removeClass('DownLi_curr');
        });

        //切换展现方式
        $('#showViewSelect').change(function(){
            var url = $(this).attr('gotourl');
            url += '?vt='+ this.value;
            window.location.href = url;
        });
    }
});

/*图片居中显示函数*/
function galleryImgChange(img){
    $(img).fadeIn(400);
    var width = $(img).width();
    var height = $(img).height();
    var parentHeight = $(img).parent().height();
    var parentWidth = $(img).parent().width();
    if(height<=parentHeight){//高度居中
        $(img).css('marginTop',(parentHeight-height)/2);
    }
    else if(width>parentWidth){
        if(width/height>parentWidth/parentHeight){
            $(img).height(parentHeight);
        }
        else{
            $(img).width(parentWidth);
        }
    }
}

//活动管理开始

/*成员管理*/
$(function(){
	if($('#hby_activity_manageNumber').size()){

		/*修改成员*/
		$('.hby_manageNumber_update').live('click',function(){
			var htmlstring = '<select class="hby_manageNumber_update_select none">';
				htmlstring += '<option value="2">协作</option>';
				htmlstring += '<option value="3">财务</option>';
				htmlstring += '<option value="4">成员</option>';
				htmlstring += '<option value="5">留守</option>';
				htmlstring += '</select>';
			$(htmlstring).insertAfter($(this)).fadeTo(600,1);
            var value = $(this).parent().parent().find('.hby_roleBox').html();
            $.each($('.hby_manageNumber_update_select option',$(this).parent()),function(index){
                if(this.text==value){
                    this.selected = true;
                    return false;
                }
            });

			$(this).hide();
			return false;
		});
		$('.hby_manageNumber_update_select').live('change',function(){
			var $that = $(this);
			var $a = $(this).siblings('.hby_manageNumber_update');
			$a.attr('role_value',$that.val());
			var sendData = {};
			sendData.uid = $a.attr('uid');
			sendData.id = $a.attr('id');
			sendData.role_value = $a.attr('role_value');
            sendData.act = $a.attr('act');
			$.get('',sendData,function(data){
				if(data.error == '0'){
                    var $role = $a.parent().parent().find('.hby_roleBox');
					$role.html(data.msgs).fadeOut('fast').fadeIn('fast').css('color','#c00');
					$a.fadeTo(600,1);
					$that.remove();
				}
				else{
					alert(data.msgs);
					$a.fadeTo(600,1);
					$that.remove();
				}
			},'json');
		});

        /*给body加点击事件*/
        $("body").click(function(event){

            if( !$(event.target).hasClass('hby_manageNumber_update_select') ){
                var $that = $('.hby_manageNumber_update_select');
                var $a = $that.siblings('.hby_manageNumber_update');
                $a.fadeTo(600,1);
                $that.remove();
            } 

        });

		/*删除*/
		$('#hby_manageNumber_del').live('click',function(){
			var $that = $(this);
			var sendData = {};
			sendData.uid = $(this).attr('uid');
			sendData.eid = $(this).attr('eid');
			$.get('',sendData,function(data){
				if(data.error == '0'){
					$that.parent().parent().remove();
				}
				else{
					alert(data.msgs);
				}
			},'json');
		});

        /*确认成员*/
        $("a.okBtnMan").click(function(){
            // $(this).html("修改").addClass("hby_manageNumber_update");
            // console.log("ssdfsd");
            var $this = $(this);
            var $userID = $this.attr("uid");
            var $ID = $this.attr("eid");

            var $del_html = "";
            alertLayer("确定执行此操作？",function(){
                $.get("/api/user/confirmUser",{event_id:$ID,user_id:$userID},function(data){

                    if(data.error=="0"){
                        $('#hby_roleBox_'+$userID).html('成员');
                        var $amend_html = "<a href='#' uid='"+ $userID +"' id='"+ $ID +"' role_value='' act='role' class='hby_manageNumber_update mr10'>修改</a>";
                        $this.siblings("a").html("删除");
                        $this.after($amend_html);
                        $this.remove();
                    }else{
                        alert(data.msgs);
                    }
                });
            });

        });

		/*获取群发用户*/
		/*$('#hby_manageNumber_getName input').click(function(){
			var sendData = {};
			sendData.id = $(this).attr('eid');
			sendData[$(this).attr('name')] = $(this).val();
			$.get('',sendData,function(data){
				var temp = $('#hby_manageNumber_getName_body_extra').html();
				$('#hby_manageNumber_getName_body').html($.replaceString(temp,data));
			},'json');
		});*/
        //验证是否选择了
        $("#member_sent").click(function(){
            if(!$("#hby_manageNumber_form div.userList label input:checked").length>0){
                alert("请选择收件人！");
                return false;
            }
        })

        /*验证群发用户*/
        $('#hby_manageNumber_form').validate({
            /*自定义验证规则*/
            rules : {
                'users[]' : { required : true },
                'msg' : { required : true }
            },
            /*提示信息*/
            messages : {
                'users[]' : '用户不能为空',
                'msg' : '信息不能为空'
            },
            /*错误提示位置*/
            errorPlacement : function(error, element){
                $('<strong class="red normal ml10"></strong>').appendTo(element.parent());
                error.appendTo(element.parent().children().last());
            }
        });

        /**点击详情展开**/
        $(".detail").click(function(){
            var detailLink = $(this).parent("td");
            var detailContent = $(this).parents("tr").next("tr");
            var state = detailContent.attr("state");
            //$(".detailLink").removeClass("show");
            //$(".detailContent").hide();
            if(state == "hide"){
                detailContent.show();
                detailContent.attr("state","show");
                detailLink.addClass("show");
            }
            else{
                detailContent.hide();
                detailContent.attr("state","hide");
                detailLink.removeClass("show");
            }

        });
        /**点击展开或关闭所有详情**/
        $('.allDetailBtn').click(function(){
            if($(this).attr('isOpen') != '1'){
                $(".detailLink").addClass("show");
                $(".detailContent").show().attr("state","show");
                $(this).attr('isOpen','1');
                $(this).attr('title','点击关闭');
            }
            else{
                $(".detailLink").removeClass("show");
                $(".detailContent").hide().attr("state","hide");
                $(this).attr('isOpen','0');
                $(this).attr('title','点击展开');
            }
        });

        /**全部、确认、未确认、全否**/
        $('#group_all').click(function(){
            //pmlist_all在页面上引入
            $('#recv_list').val(pmlist_all);
            //拆分成数组
            var pmlist_all_arr = pmlist_all.split(',');
            $.each($('#addContent input'),function(){
                $(this).parent().css('color','');
                this.checked = false;
            });
            for(var i=0; i<pmlist_all_arr.length; i++){
                $.each($('#addContent input'),function(){
                    if(this.value==pmlist_all_arr[i]){
                        this.checked = true;
                        $(this).parent().css('color','#3E84AB');
                    }
                });
            }

            //出现自由选择
            $('#addContent').slideDown(600);
        });
        $('#group_a').click(function(){
            //pmlist_a在页面上引入
            $('#recv_list').val(pmlist_a);
            //拆分成数组
            var pmlist_a_arr = pmlist_a.split(',');
            $.each($('#addContent input'),function(){
                $(this).parent().css('color','');
                this.checked = false;
            });
            for(var i=0; i<pmlist_a_arr.length; i++){
                $.each($('#addContent input'),function(){
                    if(this.value==pmlist_a_arr[i]){
                        $(this).parent().css('color','#3E84AB');
                        this.checked = true;
                    }
                });
            }

            //出现自由选择
            $('#addContent').slideDown(600);
        }).click();
        $('#group_u').click(function(){
            //pmlist_u在页面上引入
            $('#recv_list').val(pmlist_u);
            //拆分成数组
            var pmlist_u_arr = pmlist_u.split(',');
            $.each($('#addContent input'),function(){
                $(this).parent().css('color','');
                this.checked = false;
            });
            for(var i=0; i<pmlist_u_arr.length; i++){
                $.each($('#addContent input'),function(){
                    if(this.value==pmlist_u_arr[i]){
                        $(this).parent().css('color','#3E84AB');
                        this.checked = true;
                    }
                });
            }

            //出现自由选择
            $('#addContent').slideDown(600);
        });
        $('#group_not').click(function(){
            $('#recv_list').val('');
            $.each($('#addContent input'),function(){
                $(this).parent().css('color','');
                this.checked = false;
            });

            //出现自由选择
            $('#addContent').slideDown(600);
        });

        /**自由添加**/
        $('#addButton').click(function(){
            if(this.style.display == 'none'){
                $('#addContent').slideDown(600);
            }
            else{
                $('#addContent').slideUp(600);
            }
        });
        $('#addContent input').click(function(){
            var value = $(this).val();
            var $recv_list = $('#recv_list');
            var recv_list_value = $recv_list.val();
            var recv_list_arr = recv_list_value.split(',');
            if(this.checked){
                if(recv_list_value.indexOf(value) == -1){
                    recv_list_arr.push(value);
                    $recv_list.val(recv_list_arr.join(','));
                }
            }
            else{
                if(recv_list_value.indexOf(value) != -1){
                    var new_arr = [];
                    for(var i=0; i<recv_list_arr.length; i++){
                        if(recv_list_arr[i]==value) recv_list_arr[i] = '';
                        if(recv_list_arr[i] != '') new_arr.push(recv_list_arr[i]);
                    }
                    $recv_list.val(new_arr.join(','));
                }
            }
        });

	}
});

/*发布到版面*/
$(function(){
	if($("#hby_activity_managePublic").size()){
		$obj = $("#hby_activity_managePublic");
		/*编辑*/
		$(".hby_edit a",$obj).click(function(){
			var $dl = $(this).parent().parent();
			$dl.hide().siblings().eq(0).fadeTo(600,1);
		});
		/*删除*/
		$(".hby_del a",$obj).click(function(){
			var $dl = $(this).parent().parent();
			$dl.hide().siblings().eq(1).fadeTo(600,1);
		});
		/*确定*/
		$(".hby_managePublic input:button",$obj).click(function(){
			var $dl = $(this).parent().parent();
			$dl.hide().siblings().eq(0).fadeTo(600,1);
		});
		/*发布*/
		$(".hby_a a",$obj).click(function(){
			var $table = $(".hby_managePublic table",$obj);
			$table.hide().siblings("form").fadeTo(600,1);
		});
		/*确认发布*/
		$("form .hby_sub",$obj).click(function(){
			var $form = $(".hby_managePublic form",$obj);
			$form.hide().siblings("table").fadeTo(600,1);
		});
		/*取消*/
		$("form .hby_reset",$obj).click(function(){
			var $form = $(".hby_managePublic form",$obj);
			$form.hide().siblings("table").fadeTo(600,1);
		});
        /*移动*/
        $('.hby_move').click(function(){
            var $obj = $(this).hide().parents('form').find('.hby_selectBox').hide();
            $obj.prev('.hby_move').fadeIn();
            if($(this).attr('copy') == 'yes'){
                $obj.children('input:checkbox').get(0).checked = true;
            }
            else if($(this).attr('copy') == 'no'){
                $obj.children('input:checkbox').get(0).checked = false;
            }
            $obj.insertAfter($(this)).fadeIn();
            $(this).siblings('input:radio').click();
            return false;
        });
	}
});

/*取消活动*/
$(function(){
	if($("#hby_activity_manageCancel").size()){
		$obj = $("#hby_activity_manageCancel textarea");
		/*聚焦、失去焦点*/
		$obj.focus(function(){
			if(this.value == this.defaultValue) $(this).val('').css('color','#464646');
		}).blur(function(){
			if(this.value == '') $(this).val(this.defaultValue).css('color','#999');
		});

        /*验证表单为空*/
        $('#hby_activity_manageCancel form').submit(function(){
            var content = $(this).find('[name="content"]').val();
            if(!$.trim(content)){
                alert('内容不能为空');
                $(this).find('[name="content"]').focus();
                return false;
            }
        });

	}
});

/*活动声明*/
$(function(){
    if($("#hby_activity_manageDeclare").size()){

        /*验证表单为空*/
        $('#hby_activity_manageDeclare form').submit(function(){
            var content = $(this).find('[name="content"]').val();
            if(!$.trim(content)){
                alert('内容不能为空');
                $(this).find('[name="content"]').focus();
                return false;
            }
        });

    }
});

/*活动报告*/
$(function(){
    if($("#hby_activity_manageReport").size()){
        /*验证表单为空*/
        $('#hby_activity_manageReport form').submit(function(){
            //更新编辑器
            $('#content').sceditor('instance').updateOriginal();
            var content = $(this).find('[name="content"]').val();
            if(!$.trim(content)){
                alert('内容不能为空');
                $(this).find('[name="content"]').focus();
                return false;
            }
        });

    }
});

/*修改活动路线*/
/*预览路线*/
function loadGoogle(){

    if(typeof google != 'undefined'){
        //配置参数
        var latlng = new google.maps.LatLng(22.5316,114.0467);
        var myOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        //构造地图
        document.map = document.map ? document.map : new google.maps.Map(document.getElementById("hby_manageLine_preview_body"), myOptions);
        
        if(document.geoXml) document.geoXml.setMap();
        var url = document.kmlUrl;

        //url = 'http://hzsrc.ctfs.ftn.qq.com/ftn_handler/b81e64110a39148255f2dad62afcc52d9d18c946ff60380a22dcf4089de94a6a783b360e44cddcaedc2fdbaa6f9dc8a3e59ff4f4699e99b48732510151b9feab/?fname=gg.kml&k=0b393336da0b9999f4638e3412645749070e07000c5006501d09055402495156000f1e540655034b0408055503025454070f5705346265015717585b586420&fr=00&&txf_fid=2be60732b7e942c7d63afad7750371a5a4bac0c9&xffz=233490';
        //url = 'http://xasrc.ctfs.ftn.qq.com/ftn_handler/021ea5031ae0f5daa3cbb06b622092d3acf5f76a5d9308e2627cd663707766b7b66c0279adec3cf4190011a26db729a1d122bc5ae4d50c9ff632a824c8a9b86b/?fname=556090.htm&k=5e666164d3cdc7cfa53cdc6611340a1f03505053055000074c53045156190c5455004c5d020d5e1d5805020154030c5251045905373e38055450515d071a50440c6624&fr=00&&txf_fid=e2cd4d06f957e9e35ce174889256a3c64583a601&xffz=1564';
        //url = 'http://static.dev.doyouhike.net/files/556090.htm';
        //url = 'http://static.dev.doyouhike.net/files/kml/2012/11/27/9/9d0f453ea3d5d5c188164d67e069fbef_baidu.kml';
        document.geoXml = new google.maps.KmlLayer(url);
        document.geoXml.setMap(document.map);

        //document.geoXml = new google.maps.KmlLayer(document.kmlUrl,{map : document.map});
    }
    else{
        alert('谷歌地图下载中，请稍后点击，不便之处，敬请谅解！');
    }
    return;
}
function showGoogleMap(obj){
    $('.layer').hide();
    showShade();
    $('#hby_manageLine_preview').show();
    if(!document.map) $('#hby_manageLine_preview_body').html('<div class="hby_ajaxLoading" style="text-align: center; height: 400px; background-position: 350px center; line-height: 400px;">地图数据加载中...</div>');
    document.kmlUrl = $(obj).attr('url');
    document.lineID = $(obj).attr('line_id');
    loadGoogle();
    return false;
}
$(function(){
	if($('#hby_activity_manageLine').size()){

		/*显示相关活动*/
		$('.hby_showLineBtn').click(function(){
			$('.layer').hide();
            showShade();
			$('#hby_showRelativeLine').show();
			var $targetObj = $('#hby_manageLine_body');
			if(!$targetObj.data('temp')) $targetObj.data('temp',$('#hby_manageLine_body').html());
			$('#hby_manageLine_body').html('<tr><td colspan="3"><div class="hby_ajaxLoading" style="height:210px;"></div></td></tr>');
			$.get($(this).attr('url'),function(data){
				var html = $.replaceTemplate($targetObj.data('temp'),data.result);
				$('#hby_manageLine_body').empty().html(html);
			},'json');
			return false;
		});

        function adjust_kml(reset){
            var url = '/api/event_manage/'+(reset?'reset_kml':'adjust_kml')+'/'+document.lineID;
            $.get(url,function(data){//获取数据
                if(data.error){
                    alert(data.msgs);
                }else{
                    geoXml = new google.maps.KmlLayer(data.msgs);
                    geoXml.setMap(document.map);
                }
            },'json');
        }

        $('.hby_kml_adjust').click(function(){
            adjust_kml(false);
            return false;
        });
        $('.hby_kml_reset').click(function(){
            adjust_kml(true);
            return false;
        });

		/*验证表单*/
		$("#hby_manageLine_form").validate({
			/*自定义验证规则*/
			rules : {
				'res_files[]' : { required : true, accept : 'kml' },
				'line_name' : { required : true }
			},
			/*提示信息*/
			messages : {
				'res_files[]' : { required : error.event.manage.res_files_null, accept : error.event.manage.res_files_format },
				'line_name' : error.event.manage.line_name_null
			},
			/*错误提示位置*/
			errorPlacement : function(error, element){
				error.appendTo(element.parent());
			}
		});

        /*验证上传路线*/
        $('#hby_manageLine_form_select').validate({
            /*自定义验证规则*/
            rules : {
                'line_id[]' : { required : true }
            },
            /*提示信息*/
            messages : {
                'line_id[]' : error.event.manage.line_min
            },
            /*错误提示位置*/
            errorPlacement: function(error, element){
                alert(error.html());
            }
        });

        /*只能选择2条路线*/
        var $checkboxs = $('#hby_manageLine_form_select input:checkbox');
        $checkboxs.click(function(){
            var len = 0;
            $.each($checkboxs,function(){
                if(this.checked) len++;
            });
            if(len>2){
                this.checked = false;
                alert(error.event.manage.line_max);
            }
        });

	}
});

/*邀请用户*/
$(function(){
	if($("#hby_activity_manageInvite").size()){
		var $obj = $("#hby_activity_manageInvite");

		/*换一批*/
		$('#manage-invite-change').click(function(){
            var that = this;
            var request = {};
            request.page = $(this).attr('page');
            var tpage = $(this).attr('tpage');
            if(tpage==1||!tpage) {
                alert('只有一批用户');
                return;
            }
			$.get($(this).attr('url')+request.page,function(data){
                
                if((data.page+1) > tpage) $(that).attr('page',1);
                else $(that).attr('page',parseInt(data.page)+1);
                
				var $targetObj = $('#hby_relativeList_body');
				if(!$targetObj.data('temp')) $targetObj.data('temp',$('#hby_relativeList_body_extra').html());
				var htmlstring = $.replaceTemplate($targetObj.data('temp'),data.result);
                $targetObj.empty().html(htmlstring);
                isInvited();
                $('#selectAll').get(0).checked = false;
			},'json');
		});

        /*验证邀请是否为空*/
        $('#hby_manageInvite_form').submit(function(){
            if(!$('#userIdList').val()){
                alert('您还没选择用户！');
                return false;
            };
        }).get(0).reset();

        /*已邀请的用户变灰色，不能被选*/
        function isInvited(){
            var userList = [];
            $.each($('#hby_manageInvite_is img[userid]'),function(){
                if($(this).attr('userid')) userList.push($(this).attr('userid'));
            });
            $.each($('#hby_relativeList_body input[name="personList"]'),function(){
                var that = this;
                $.each(userList,function(index,value){
                    if(that.value == value){
                        that.disabled = true;
                        return false;
                    }
                });
            });
        }
        isInvited();

		/*聚焦、失去焦点*/
		$('#manage-invite-search input[type="text"]').focus(function(){
		    if($(this).val()==$(this).get(0).defaultValue) $(this).val('').css('color','#464646');
		});
		$('#manage-invite-search input[type="text"]').blur(function(){
		    if($(this).val()=='') $(this).val($(this).get(0).defaultValue).css('color','#999');
		});
		$('#hby_activity_manageInvite textarea').focus(function(){
		    if($(this).val()==$(this).get(0).defaultValue) $(this).val('').css('color','#464646');
		});
		$('#hby_activity_manageInvite textarea').blur(function(){
		    if($(this).val()=='') $(this).val($(this).get(0).defaultValue).css('color','#999');
		});

        /*查找用户提交*/
        $('#manage-invite-search form').submit(function(){
            var $username = $(this).find('[name="UserName"]');
            if($username.val()=='' || $username.val()==$username.get(0).defaultValue){
                alert('请输入被邀请人的磨房ID');
                $username.focus();
                return false;
            }
        });

		/*切换*/
		$(".hby_inviteTitle h3",$obj).click(function(){
			var $oldClass = 'hby_title hby_inviteTitle ';
            $(this).addClass('hby_curr').siblings().removeClass('hby_curr');
            $(this).parent().attr('class','').addClass($oldClass + $(this).attr('pClass'));
            var $inviteBox = $(this).parent().siblings('.hby_manageInvite').children('div');
            $inviteBox.hide();
            $inviteBox.eq($(this).index()).fadeTo(600,1);
		});

		/*点击复选框*/
    	$("#hby_manageInvite_relativeList dl input:checkbox").live('click',function(){
    		var userId = $(this).val();
			var userName = $(this).attr("userName");
			var checkValue = this.checked;
			var flag = false;
			var value = $("#userIdList").val();
			$.each($("#personListShow li"),function(index,obj){
		        if($(this).attr('userId') == userId){
		        	flag = true;
		            if(!checkValue){
		                $(this).remove();
		                var reg = new RegExp(userId+',','g');
		                $("#userIdList").val(value.replace(reg,''));
		            }
		        }
			});
			if(!flag&&checkValue){
				$("#personListShow ul").append('<li class="tips-list" userId="'+ userId +'">'+ userName +'<i>×</i></li>');
				$("#userIdList").val(value+ userId +',');
			}
    	});

		/*点击已选用户*/
		$("#personListShow li").live('click',function(){
	    	var parentOffset = $(this).parent().parent().offset();
	    	var top = $(this).offset().top - parentOffset.top + this.offsetHeight;
	    	var left = $(this).offset().left - parentOffset.left;
	    	$("#hby_tips").css({top : top,left : left}).children('.hby_url').attr('href','/user/'+$(this).attr('userId'));
	    	document.hby_tips = $(this);
            //删除用户
            $("#hby_tips .hby_del").click();
	    });

		/*全选按钮*/
		$("#selectAll").click(function(){

			$checkValue = this.checked;
            $.each($("#hby_relativeList_body dl input:checkbox"),function(index,obj){
            	var that = this;
                if(this.disabled){

                }
                else{
                    if($checkValue) {
                        this.checked = true;
                        var value = $("#userIdList").val();
                        var reg = new RegExp(this.value+',','g');
                        if(!reg.test(value)){
                            $("#userIdList").val(value+ this.value +',');
                            $("#personListShow ul").append('<li class="tips-list" userId="'+ this.value +'">'+ $(this).attr("userName") +'<i>×</i></li>');
                        }
                    }
                    else {
                        this.checked = false;
                        var value = $("#userIdList").val();
                        var reg = new RegExp(this.value+',','g');
                        if(reg.test(value)) $("#userIdList").val(value.replace(reg,''));
                        $.each($("#personListShow ul li"),function(index,obj){
                            if($(this).attr("userid") == that.value) $(this).remove();
                        });
                    }
                }
			});

		});

		/*给body加点击事件*/
		/*$("body").click(function(event){
			if(!$(event.target).attr('userId')&&$(event.target).attr('id')!='hby_tips') $("#hby_tips").hide(600);
	    });*/

	    /*删除用户*/
	    $("#hby_tips .hby_del").click(function(){
	    	var $obj = document.hby_tips;
	    	$obj.remove();
	    	$("#hby_tips").slideUp('fast');
	    	var value = $("#userIdList").val();
	    	var reg = new RegExp($obj.attr('userId')+',','g');
            $("#userIdList").val(value.replace(reg,''));
            /*遍历已选用户把打钩去掉*/
            $.each($("#hby_manageInvite_relativeList dl input:checkbox"),function(index,obj){
				if($obj.attr('userId')==$(this).val()) this.checked = false;
			});
	    });

	    /*清空隐藏域*/
	    $("#userIdList").val('');
	}
});

/*创建活动、系列活动、修改活动信息*/
$(function(){
    if($("#hby_activityCreate").size()){

    	$obj = $("#hby_activityCreate");

    	/*系列活动跳转*/
		$('#hby_Create_oldList input').click(function(){
			$(this).siblings('a').get(0).click();
		});

		/*展开、折叠*/
		$("#hby_Create_oldList p",$obj).toggle(function(){
			$(this).css('backgroundPosition','0 -19px').html('向上收起');
			var $dl = $("#hby_Create_oldList dl",$obj);
			var heightValue = $dl.css('height','auto').height();
			$dl.css('height','');
			$dl.animate({height : heightValue},600);
		},function(){
			$(this).css('backgroundPosition','0 0').html('向下展开');
			$("#hby_Create_oldList dl",$obj).animate({height : '120px'},600);
		});

    	/*时间控件*/
    	$(".Wdate").click(function(){
    		WdatePicker({
    			dateFmt : 'yyyy-MM-dd',
    			skin : 'whyGreen',
                minDate : '%y-%M-{%d+1}',
                isShowToday : false
    		});
    	});

    	/*活动类型*/
    	$(".hby_ul li").click(function(){
    		if($(this).attr('class') == 'active'){
                $(this).removeClass('active').children('input').removeAttr('checked');
    		}
    		else{
    			$(this).addClass('active').children('input').attr('checked','checked');
    		}
    	});

    	/*表单验证*/
    	document.validate = $("#hby_activityCreateForm").validate({
            onclick : false,
		    /*自定义验证规则*/
			rules : {
				activityTitle : { required : true, maxlength : 50 },
				activityStartTime : { required : true },
                activityStartHour : { required : true, digits : true, min: 0, max: 23 },
				activityMaxNumber : { required : true , digits : true, min : 3, max : 1000000 },
                activityStartMinute : { required : true, digits : true, min: 0, max: 59 },
                //activityStartAddress : { required : true },
                //activityAndAddress : { required : true },
                event_type : { required : true, minlength : 3},
                event_dest_list: { required : true, minlength : 3},
				content : { required : true, minlength: 4 },
				activityDay : { required: true, digits : true, min : 1, max : 3600 }
			},
			/*提示信息*/
			messages : {
				activityTitle :{
                    required : error.event.add.title_null,
                    maxlength : error.event.add.title_maxlength
                },
				activityMaxNumber : {
                    required : error.event.add.maxNumber_null,
                    min : error.event.add.maxNumber_min,
                    max : error.event.add.maxNumber_max
                },
				activityStartTime : {
                    required : error.event.add.activityStartTime_null
                },
                activityStartHour : error.event.add.activityStartHour_range,
                activityStartMinute : error.event.add.activityStartMinute_range,
                //activityStartAddress : error.event.add.startAddress_null,
                //activityAndAddress : error.event.add.endAddress_null,
                event_type : {
                    required : error.event.add.activityType_null,
                    minlength : error.event.add.activityType_null
                },
                event_dest_list: {
                    required : error.event.add.endAddress_null,
                    minlength : error.event.add.endAddress_null
                },
				content :{
                    required : error.event.add.activityInfo_null,
                    minlength : error.event.add.activityInfo_minlength
                },
				activityDay : {
                    required : error.event.add.time_null,
                    digits : error.event.add.time_num,
                    min : error.event.add.time_min,
                    max : error.event.add.time_max
                }
			},
			/*错误提示位置*/
			errorPlacement : function(error, element){
				error.appendTo(element.parent());
			},
            onsubmit : false
		});


        $("#hby_activityCreateForm").submit(function(){

            if($('input[name="event_id_old"]').size()){
                /*
                if(!$('input[name="event_id_old"]').val()) {
                    alert(error.event.add.activity_null);
                    $(document).scrollTop(0);
                    return false;
                }
                */
            }
            $('#div_resources').hide();
            var a = document.validate.form();
            $('#div_resources').show();
            //var b = document.validate.element($('input[name="activityStartAddress"]'));
            var b= $('select[name="activityStartAddress"]').val();
            //var c = document.validate.element($('input[name="activityAndAddress"]'));
            var c = document.validate.element($('input[name="event_dest_list"]'));
            var _typeCheck = document.validate.element($('input[name="event_type"]'));
            if(!b){
                $(this).find('select[name="activityStartAddress"]').prev().addClass('error').attr('id','select');
                //$(this).find('select[name="activityStartAddress"]').after('<label for="activityAndAddress" generated="true" class="error">'+error.event.add.startAddress_null+'</label>');
                alert(error.event.add.startAddress_null);
                $(document).scrollTop(0);
                return false;
            }
            if(!(a&&c&&_typeCheck)){
                $(document).scrollTop(0);
            }
            else if($(this).find('input[name="is_activityArea"]').size()){
                var flagArea = false;
                $.each($(this).find('input[isSelect="yes"]'),function(){
                    if(this.checked){
                        flagArea = true;
                        return false;
                    }
                });
                if(!flagArea){
                    alert(error.event.add.activity_is);
                    return false;
                }
                else{
                    if($(this).find('input[name="is_activityArea"]').get(0).checked && !$(this).find('select[name="activityArea"]').val()){
                        $(this).find('input[name="is_activityArea"]').nextAll('select').eq(0).addClass('error').attr('id','select');
                        alert(error.event.add.activityArea_is);
                        return false;
                    }
                }
            }
            return  a&&b&&c&&_typeCheck  ? true : false;
        });


        $('#select').live('click',function(){
            if(this.value == '000000') $(this).addClass('error');
            else $(this).removeClass('error');
        });


		/*正常提交*/
		/*$('#hby_activityCreate_sub').click(function(){
			$('#hby_open').val('1');
		});*/
		/*保存草稿*/
		/*$('#hby_activityCreate_sub_paper').click(function(){
			$('#hby_open').val('0');
		});*/

		/*添加目的地、出发地*/
		function addTarget($element){
			$(".hby_btn",$element).click(function(){
	    		var $left = $(this).offset().left - $(this).parent().offset().left;
	    		$(this).nextAll(".hby_showBox").css('left',$left+'px').show('fast');
                $('.hby_showBox_button').prevAll('input').focus();
	    	});
	    	var $hby_showBox = $(".hby_showBox",$element);
	    	var $hidden = $('input[forid="hidden"]',$element);//隐藏域
	    	$hidden.val('');
	    	$.each($hby_showBox.siblings("ul").children("li"),function(name,value){
	            var $temp = $hidden.val();
	            $hidden.val($temp + $(this).text() + ',');
	    	});
	    	var $value = '';
	    	$("li",$hby_showBox).click(function(){
	    		$value = $hidden.val();
	    		if( $value.indexOf( $(this).text() ) == -1){
	    			$hidden.val($value + $(this).text() + ',');
	    			$hby_showBox.siblings("ul").append($(this).clone());
	    		}
	    		$hby_showBox.hide(600);
                //document.validate.element($('input[name="activityStartAddress"]'));
                document.validate.element($('input[name="activityAndAddress"]'));
	    	});
	    	/*确定*/
	    	$(".hby_showBox_button",$hby_showBox).click(function(){
                $(".hby_text_div").remove();
	    		var $text = $("input:text",$hby_showBox).val();
	    		$hby_showBox.hide(600);
	    		if($.trim($text) != ''){
	    			$value = $hidden.val();
	    			if( $value.indexOf( $text ) == -1){
	    				$hby_showBox.siblings("ul").append('<li title="点击删除">'+ $text +'</li>');
	    		    	$hidden.val($value + $text + ',');
	    		    }
	    		}
                $(this).prevAll('input').val('');
                //document.validate.element($('input[name="activityStartAddress"]'));
                document.validate.element($('input[name="activityAndAddress"]'));

	    	});
	    	/*删除*/
	    	$('.hby_Create_target_ul li',$element).live('click',function(){
	    		$(this).remove();
	    		if( $hidden.val().indexOf( $(this).html() ) != -1 ){
	    			var temp = $hidden.val().replace($(this).html()+',','');
	    			$hidden.val(temp);
	    		}
                //document.validate.element($('input[name="activityStartAddress"]'));
                document.validate.element($('input[name="activityAndAddress"]'));
	    	});
		}
    	//addTarget($('#hby_Create_target'));//添加目的地
    	addTarget($('#hby_Create_source'));//出发地

        /*给body加点击事件*/
        $("body").click(function(event){

            if( $(event.target).attr('is') !='no' ) $(".hby_showBox").hide(600);

        });

    }
});

/*活动日志*/
$(function(){
	if($('#hby_activity_manageDaily').size()){

		/*构造默认分页*/
		var x_url = '/event/manage_new/log?id='+ $('#hby_manageDaily_page').attr('forid') +'&page={page}'+'&nodeId='+ $('#hby_manageDaily_page').attr('data_id');
		var x_total = $('#hby_manageDaily_page').attr('total');
		$.getPage(1,x_total,x_url,'#hby_manageDaily_page');

		/*分页*/
		$('#hby_manageDaily_page a').live('click',function(){
			var url = $(this).attr('href');
			//$.getJsonData(url,'#hby_manageDaily_body','#hby_manageDaily_body_extra','#hby_manageDaily_page');
			$.innerJsonData(url,'#hby_manageDaily_body','#hby_manageDaily_body_extra','#hby_manageDaily_page');
			return false;
		});

	}
});

/*个人首页去过交互*/
$(function(){
    /**图片hover cover显示图片信息**/
    $('.img_cover_info_wrap li,.img_cover_info_wrap_sp').hover(function(){
        var oimg_cover = $(this).find('.img_cover_info');
        var extend_height = oimg_cover.parent().height();
        var extend_top = 0;
        var text = oimg_cover.find('p').text();
        if(text != '')oimg_cover.stop().animate({top:extend_top,height:extend_height}, 500);
    },function(){
        var oimg_cover = $(this).find('.img_cover_info');
        var text = oimg_cover.find('p').text();
        var an_extend_height = oimg_cover.parent().height();
        var shrink_height = oimg_cover.find('h3').height();
        var shrink_top = an_extend_height - shrink_height;
        if(text != '')oimg_cover.stop().animate({top:shrink_top,height:shrink_height}, 500);
    });
    //ie7,8 placeholder
    if($.browser.msie){
        $('input[placeholder],textarea[placeholder]').each(function(){
            var input = $(this);
            $(input).val(input.attr('placeholder'));

            $(input).focus(function(){
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            });
            $(input).blur(function(){
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.val(input.attr('placeholder'));
                }
            });
        });
    }

    var selected;
    $('.add_quguo_btn').click(function(){
        $('.node_id_hidden,.quguo_place_input,.Wdate,.sets_desc').val('');
        showShade();
        selected = false;
        $('#my_quguo_impression_submit').prop('disabled', false).addClass('add_quguo');;
        $('#layer-title-span').text('添加去过');
        $('.AllWords.fr i').html('0');
        $('.my_quguo_pop_layer').show();
    });

    $('.quguo_pencil_i').click(function(){
        $('#my_quguo_impression_submit').prop('disabled', false).removeClass('add_quguo');
        isPopMenu = true;
        selected = false;
        showShade();
        $('#layer-title-span').text('编辑去过');
        $('.sets_desc').val('');
        $('.AllWords.fr i').html('0');
        var text = $(this).parents('li').find('.quguo_place_name').text();
        var date = $(this).parents('li').find('.date').text();
        $('.quguo_place_input').val(text);
        $('.Wdate').val(date);

        var vid = $(this).attr('vid');
        $.get('/api/place/getVisited/',{vId:vid},function(data){
            //console.log(data.result);
            $('.Wdate').val(data.result.CreatedTime);
            $('.node_id_hidden').val(data.result.NodeID);
            $('.impression_id_hidden').val(data.result.impression_id);
            $('.visited_id_hidden').val(data.result.visited_id);
            if(data.result.impression_content !== null){
                $('.sets_desc').val(data.result.impression_content);
            }
            $('.my_quguo_pop_layer').show();
        },'json');
    });

    $('.quguo_delete_i').click(function(){
        showShade();
        var visited_id = $(this).prev().attr('vid');
        alertLayer('您将要删除此去过地点，确认现在删除吗？',function(){
            $.post('/api/place/delVisited/',{vId:visited_id},function(data){
                alert(data.msgs,function(){
                    location.reload();
                });

            },'json');
        });
    });

    $('.sets_desc').keyup(function(){
        show_typed_words($(this));
    });

    $('#my_quguo_impression_submit').click(function(){
        var visited_id = $('.visited_id_hidden').val();
        var node_id = $('.node_id_hidden').val();
        var created_time = $('.Wdate').val();
        var impression_id = $('.impression_id_hidden').val();
        var impression_content = $('.sets_desc').val();
        var _that = $(this);
        if($(this).hasClass('add_quguo')){

            if(node_id != '' && created_time !== ''){
                $.post('/api/place/addVisited/',{node_id:node_id,created_time:created_time,impression_info:impression_content},function(data){
                    if(data.error == 0){
                        $(this).hide();
                        var $successDiv = $('<p class="success">感谢您添加<?php echo $dest?>去过印象,审核通过后,即可显示!</p>');
                        $('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                        setTimeout(function(){
                            $(".layer-close").click();
                            $('.my_quguo_pop_layer').find('.layer-content .success').remove();
                        },2000);
                        location.reload();
                    }else{
                        $('.backTips').empty().html(data.msgs).show().fadeOut(1500);
                    }

                    _that.prop('disabled', true);
                },'json');
            }else if(node_id == ''){

                //$('.backTips').text('没有选择目的地！').show().fadeOut(1500);
                var $successDiv = $('<p class="success">没有选择目的地！</p>');
                if($('.success').length == 0)$('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                else $('.success').text('没有选择目的地！').show();
                $('.success').fadeOut(2000);

            }else if(created_time == ''){
                //$('.backTips').text('日期格式不正确！').show().fadeOut(1500);
                var $successDiv = $('<p class="success">日期格式不正确！</p>');
                if($('.success').length == 0)$('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                else $('.success').text('日期格式不正确！').show();
                $('.success').fadeOut(2000);
            }

        }else{
            if(node_id != '' && impression_content !== '' && created_time !== ''){
                $.post('/api/place/editVisited/',{visited_id:visited_id,node_id:node_id,created_time:created_time,impression_id:impression_id,impression_content:impression_content},function(data){
                    if(data.error == 0){
                        $(this).hide();
                        var $successDiv = $('<p class="success">感谢您添加<?php echo $dest?>去过印象,审核通过后,即可显示!</p>');
                        $('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                        setTimeout(function(){
                            $(".layer-close").click();
                            $('.my_quguo_pop_layer').find('.layer-content .success').remove();
                        },2000);
                        location.reload();
                    }else{
                        $('.backTips').empty().html(data.msgs).show().fadeOut(1500);
                    }

                    _that.prop('disabled', true);
                },'json');
            }else if(node_id == ''){
                var $successDiv = $('<p class="success">没有选择目的地！</p>');
                if($('.success').length == 0)$('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                else $('.success').text('没有选择目的地！').show();
                $('.success').fadeOut(2000);

            }else if(created_time == ''){
                var $successDiv = $('<p class="success">日期格式不正确！</p>');
                if($('.success').length == 0)$('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                else $('.success').text('日期格式不正确！').show();
                $('.success').fadeOut(2000);
            }else if(impression_content == ''){
                var $successDiv = $('<p class="success">印象不能为空！</p>');
                if($('.success').length == 0)$('.my_quguo_pop_layer').find('.layer-content').append($successDiv);
                else $('.success').text('印象不能为空！').show();
                $('.success').fadeOut(2000);
            }

        }

    });

    $('.user_homepage_quguo ul li').hover(function(){
        var _that = $(this);
        var vid = $(this).attr('vid');
        $.get('/api/place/getVisited/',{vId:vid},function(data){
            if(data.result.impression_content == null){
                _that.find('.quguo_fun_box p').text('没有印象！');
            }else{
                _that.find('.quguo_fun_box p').text(data.result.impression_content);
            }

        },'json');
    },function(){

    });
});


$(function(){
    //点击领取勋章
    $(".click-to-draw").click(function(){
        var medalID = $(this).attr('id');
        if($(".pop").size()){

            $(".pop").remove();
        }
        $.post("/api/medal/setMedal/",{medal_id:medalID},function(data){

            if(data.error == 0){
                msgTip("领取成功！", function(){
                    $(".auto-disappear").remove();
                    $("#shade-bg").remove();
                    location.reload();
                });
            }else{
                alertLayer(data.msgs);
            }
        });
    });

    $(".pop-detail").click(function(){
        var $father = $(this).parents(".medal-wrap"),
            imgUrl = $father.find("img").attr("src"),
            name = $father.find(".pop-detail").text(),
            desc = $father.find(".pop-detail").attr("desc"),
            time = $father.find(".pop-detail").attr("time"),
            subTime = time.substr(0,16);
        if($(".pop").size()){
            $(".pop").remove();
        }

        var content = "霸王勋章";
        var html = '';
        html += '<div class="pop">';
        html += '    <div class="title">';
        html += '        <p><span>勋章信息</span></p>';
        html += '    </div>';
        html += '    <div class="layer-content">';
        html += '       <div>';
        html += '           <div class="img">';
        html += '               <img src="'+imgUrl+'"/>';
        html += '               <div class="desc-wrap">';
        html += '                   <span class="desc">'+subTime+'</span>';
        html += '               </div>';
        html += '           </div>';
        html += '           <div class="content">';
        html += '               <p class="medal-name">'+name+'</p>';
        html += '               <p class="medal-desc">'+desc+'</p>';
        html += '           </div>';
        html += '       </div>';
        html += '    </div>';
        html += '</div>';
        if(!$(".pop").size()){
            $father.append(html);
        }

        $('body').click(function(e){
            var $obj = $(e.target).parents('.pop');
            if(!$(e.target).parents(".medal-wrap").size()) {
                $father.find(".pop").remove();
            }
        });

    });
});


//计算字符数函数
function show_typed_words(obj){
    var value = $.trim($(obj).val());
    var limit = 70;
    var $parent = $(obj).parent();

    var len = value.length;
    if(len <= limit){
        $parent.find('.AllWords i').html(len);
    }else{
        $parent.find('.AllWords i').html(limit);
        $(obj).val(value.substr(0,limit));
    }

}
//取得当前的时间戳
function timestamp() {
    var timestamp = Date.parse(new Date());
    return timestamp;
}
//*************活动目的地表单 ajax 提示输入*******************start
var event_last;
var selected;
$(function(){
    $('#dest_input').attr("autocomplete","off").keyup(function(event){
       //选择列表的目的地
       //40 down 38 up
       if($(".hby_text_div .current").size()==0&&event.keyCode == 40){//向下选择第一条
            $(".hby_text_div ul li:first").addClass("current");
            $(this).val($(".current").attr("area"));
            selected=true;
        }else if($(".hby_text_div .current").size()==0&&event.keyCode == 38){//向上选择最后一条
            $(".hby_text_div ul li:last").addClass("current");
            $(this).val($(".current").attr("area"));
            selected=true;
        }else if($(".hby_text_div .current").size()!=0&&event.keyCode == 40){//向下选择
            $(".hby_text_div .current").removeClass("current").next().addClass("current");
            $(this).val($(".current").attr("area"));
            selected=true;
        }else if($(".hby_text_div .current").size()!=0&&event.keyCode == 38){//向上选择
            $(".hby_text_div .current").removeClass("current").prev().addClass("current");
            $(this).val($(".current").attr("area"));
            selected=true;
        }else if(event.keyCode == 13){
            if($('#dest_input').val()=="")return;
            if(selected){
                var val=$('input[forid="hidden"]');
                var text=$(".current").attr("area");
                if( val.val().indexOf(text) == -1){
                    $('.hby_Create_target_ul').append('<li title="点击删除">'+ text +'</li>');
                    val.val(val.val() + text + ',');
                    $(".hby_text_div").remove();
                    document.validate.element($('input[name="activityAndAddress"]'));
                    $('#dest_input').val("");
                }
            }
            selected=false;
        }else{
            selected=false;
            var keyword=$(this).val();
            if(keyword==""){
                $(".hby_text_div").remove();
                return ;
            }
            $.post('/api/place/auto_output_nodes',{node_name:keyword},function(data){
                if(data.only == true){
                    isOnly = true;
                }
                if(data.node.length>0){
                    $(".hby_text_div").remove();
                    var list=$("<div class='hby_text_div' style='display:none;position:absolute;width:200px;z-index:1000;text-align:left;'><ul style='padding:0px;'></ul></div>");
                    $("#dest_input").after(list);
                    var obj =$(this)[0];
                    list.css({display:"block",left:obj.offsetLeft + "px",top:obj.offsetTop + obj.offsetHeight+ "px"})
                    var li = '';
                    $.each(data.node,function(i,n){
                        //li +="<li is='no' class='arealist' area='"+data.node[i].NodeName+"'>"+data.node[i].NodeName+"&nbsp;&nbsp;-&nbsp;&nbsp;<span is='no'>广西</span><p is='no' class='search_rs_py_txt'><em is='no'>nanning</em></p></a></li>";
                        var str = data.node[i].tree.split('>>');
                        var len = str.length - 2;
                        var father = str[len];
                        var new_name_str = '<em is="no">'+keyword+'</em>';
                        var new_slug_str = '<em is="no">'+keyword+'</em>';
                        var rs_name_str = data.node[i].NodeName.replace(keyword,new_name_str);
                        var rs_slug_str = data.node[i].NodeSlug.replace(keyword,new_slug_str);

                        li += '<li class="arealist" is="no" area="'+data.node[i].NodeName+'">'+rs_name_str;
                        if(father !== undefined){
                            li += '&nbsp;&nbsp;-&nbsp;&nbsp;<span is="no">'+father+'</span>';
                        }
                        li += '<p is="no" class="search_rs_py_txt">'+rs_slug_str+'</p></a></li>';
                    });
                    list.find("ul").html(li);
                    $(".arealist").click(function(){
                        $('#dest_input').val($(this).attr("area"));
                        $(".hby_text_div").remove();
                    });
                }
            });
            
        }
    });
});
//*************活动目的地表单 ajax 提示输入*******************end

//新版勋章 2015-05-18
$(function(){
    var $myMedalList = $('#myMedalList'),//个人
        $userMedalList = $('#userMedalList'),//公开
        $modal = $('#medalModal'),
        dataList = [],
        gotDataList = [],//已领取
        ungotDataList = [],//尚未领取
        notDataList = [],//不可领取
        ifDataEmpty = true;

    //勋章列表数据初始化
    function initMedalList($holder){
        var postObj = {
            url: location.protocol + "//" + location.host + '/my/medal/medal_list',
            dataType: 'json',
            type: 'POST',
            success: function(data){
                if(data.error == 0){
                    dataList = data.result.medal_list ? data.result.medal_list.data:[];
                    var _html = '';
                    if(dataList.length > 0){
                        for(var i=0, dataLen = dataList.length; i<dataLen; i++){
                            var obj = dataList[i];
                            medalStatusReady(obj);
                        }
                        displayMedalList($holder);
                    }else{
                        _html = '没有勋章';
                        $holder.html(_html);
                    }
                    
                }
            }
        }
        if($holder == $userMedalList){
            var _userid = $holder.attr('data-userid');
            if(_userid){
                postObj.data = {
                    UserID: _userid
                }
            }
        }
        $.ajax(postObj);
    }
    function displayMedalList($holder, ifControl){
        var _html = '';
        for(var i=0; i<gotDataList.length; i++){
            var obj = gotDataList[i];
            if(obj.grade && obj.grade[0].gradeType == '2') obj.medalName +=' '+obj.grade[0].gradeName;
            _html +='<li data-index="g'+ i +'"><img src="'+obj.activePic+'"/><span>'+obj.medalName+'</span></li>'; 
        }
        for(var i=0; i<ungotDataList.length; i++){
            var obj = ungotDataList[i];
            if(obj.grade && obj.grade[0].gradeType == '2') obj.medalName +=' '+obj.grade[0].gradeName;
            if($holder == $myMedalList){
                _html +='<li data-index="u'+ i +'"><img src="'+obj.activePic+'"/><span>'+obj.medalName+'</span><i class="point" data-mid="'+ obj.medalID +'"></i></li>';   
            }else if(obj.grade.length>1){
                _html +='<li data-index="u'+ i +'"><img src="'+obj.activePic+'"/><span>'+obj.medalName+'</span></li>';   
            }
        }
        for(var i=0; i<notDataList.length; i++){
            var obj = notDataList[i];
            if(obj.grade && obj.grade[0].gradeType == '2') obj.medalName +=' '+obj.grade[0].gradeName;
            if($holder == $myMedalList){
                obj.activePic = obj.picOff;
                _html +='<li data-index="n'+ i +'"><img src="'+obj.activePic+'"/><span>'+obj.medalName+'</span></li>'; 
            }
        }
        if(ifDataEmpty && $holder == $userMedalList){
            _html = '没有勋章';
        }
        $holder.html(_html);
    }
    function medalStatusReady(obj){
        if(obj.grade){
            var _grade;
            for(var i=0; i<obj.grade.length; i++){
                _grade = obj.grade[i];
                if(_grade.medalStatus == '2'){
                    obj.ifGetone = 1;
                    obj.gIdx = i; 
                    obj.activePic = _grade.picOn;
                    ifDataEmpty = false;
                }
                if(_grade.medalStatus == '1'){
                    obj.getIconIdx = i;//未领取
                    if(i>0 && _grade.gradeType != '2'){
                        obj.grade[i-1].medalStatus = '2';
                        obj.activePic = obj.grade[i-1].picOn;
                        ifDataEmpty = false;
                    }else{
                        obj.activePic = obj.picOff;
                    }
                }
                if(_grade.gradeType != '0'){
                    obj.ifHasGrade = 1;
                }
                if(_grade.gradeType == '2'){//城市勋章
                    var newObj = $.extend(true, {}, obj);
                    newObj.grade.length = 0;
                    if(_grade.medalStatus == '1'){
                        newObj.getIconIdx = 0;
                        newObj.ifGetone = 0;
                    }
                    newObj.grade.push(_grade);
                    if(typeof newObj.getIconIdx == 'undefined' && newObj.ifGetone == 1){//已领取
                        gotDataList.push(newObj);
                    }
                    if(typeof newObj.getIconIdx != 'undefined'){//尚未领取
                        ungotDataList.push(newObj);
                    }
                    if(typeof newObj.getIconIdx == 'undefined' && newObj.ifGetone != 1){//不可领取
                        newObj.activePic = newObj.picOff;
                        notDataList.push(newObj);
                    }
                }
            }
            if(_grade.gradeType != '2'){
                if(typeof obj.getIconIdx == 'undefined' && obj.ifGetone == 1){//已领取
                    gotDataList.push(obj);
                }
                if(typeof obj.getIconIdx != 'undefined'){//尚未领取
                    ungotDataList.push(obj);
                }
                if(typeof obj.getIconIdx == 'undefined' && obj.ifGetone != 1){//不可领取
                    obj.activePic = obj.picOff;
                    notDataList.push(obj);
                }
            }
        }else{
            obj.activePic = obj.picOff;
            notDataList.push(obj);
        }
        
        return obj;
    }
    if($myMedalList.size()>0){
        initMedalList($myMedalList);
    }
    if($userMedalList.size()>0){
        initMedalList($userMedalList);
    }
    //打开勋章弹框
    $('.medal-list').delegate('>li', 'click', function(e){
        e.preventDefault();
        var $li = $(this),
            _idx = $li.attr('data-index'),
            _mIdx = _idx,
            dataObj;
            
        if(_idx.indexOf('g') != -1){
            _idx = _idx.split('g')[1];
            dataObj = gotDataList[_idx];
        }
        if(_idx.indexOf('u') != -1){
            _idx = _idx.split('u')[1];
            dataObj = ungotDataList[_idx];
        }
        if(_idx.indexOf('n') != -1){
            _idx = _idx.split('n')[1];
            dataObj = notDataList[_idx];
        }
        var _split = '';
        var _descP = '';
        var _city = '';
        if(dataObj.grade && dataObj.grade[0].gradeType == '2'){
            _city = dataObj.grade[0].gradeName;
        }
        if(dataObj.medalDesc){
            _split = dataObj.medalDesc.split('\n');
            for(var i=0; i<_split.length; i++){
                if(i==0){
                    _descP += '<p class="top">'+_split[i]+_city+'</p>';
                }else{
                    _descP += '<p>'+_split[i]+'</p>';
                }
            }
        }
        var _tip = '';
        if(dataObj.unit && dataObj.grade){
            var _nowCount;
            for(var i=0; i<dataObj.grade.length; i++){
                if(dataObj.grade[i].medalStatus != '0' && dataObj.grade[i].nowCount){
                    _nowCount = dataObj.grade[i].nowCount;
                }
            }
            if(typeof _nowCount != 'undefined'){
                _tip = '<p class="tip_wrap"><span class="tip">'+ dataObj.unit +': '+ _nowCount +'</span></p>';
            }
        }
        if(dataObj.grade && dataObj.grade.length > 1){
            $modal = $('#medalLevelModal');
            var _html = '<div class="side"><img src="'+dataObj.activePic+'"><h4>'+dataObj.medalName+_city+'</h4>'+ _tip+ _descP +'</div>';
            _html += ' <div class="main"><ul class="medal-level-list">';
            for(var i=0; i<dataObj.grade.length; i++){
                var _grade = dataObj.grade[i];
                var _showImg = _grade.medalStatus == '2' ? _grade.picOn : _grade.picOff;
                if(typeof dataObj.getIconIdx == 'number' && i == dataObj.getIconIdx && $myMedalList.size()>0){//可领取
                    _html +='<li data-idx="'+ i +'"><img src="'+_showImg+'"><p class="medal-get" data-idx="'+_mIdx +'" data-id="'+ dataObj.medalID +'">领取</p><i class="medal-get-icon"></i></li>';
                }else{
                    _html +='<li data-idx="'+ i +'"><img src="'+_showImg+'"><span class="score">'+ _grade.value +'</span></li>';
                }
            }
            _html += '</ul></div>';
        }else{
            $modal = $('#medalModal');
            var _toget = '';
            if(typeof dataObj.getIconIdx == 'number' && $myMedalList.size()>0){//可领取
                _toget = '<div data-idx="0" class="medal-get-wrap"><p class="medal-get" data-idx="'+_mIdx +'" data-id="'+ dataObj.medalID +'">领取</p></div>';
            }
            var _html = '<div class="side"><img src="'+dataObj.activePic+'">'+ _tip +_toget +'</div>';
            _html += '<div class="main"><h4>'+dataObj.medalName+'</h4>'+_descP+'</div>';
        }    
        $modal.find('.layer-content').html(_html);
        if($('.modal_cover').size()>0){
            $('.modal_cover').show();
        }else{
            $('<div class="modal_cover"></div>').insertAfter($modal).show();
        }
        $modal.show();
    });
    //领取勋章
    $('.medal-modal').delegate('.medal-get', 'click', function(){

        var $target = $(this),
            _metalId = $target.attr('data-id'),
            _gIdx = $target.parent().attr('data-idx'),
            $img = $target.siblings('img'),
            dataIdx = $target.attr('data-idx');
            if(dataIdx.indexOf('u') != '-1'){
                var _idx = dataIdx.split('u')[1],
                    obj = ungotDataList[_idx],
                    _grade = obj.grade[_gIdx];
                var _gid = _grade.gID;
            }

        $.ajax({
            url: location.protocol + "//" + location.host + '/my/medal/receive_medal',
            dataType: 'json',
            type: 'POST',
            data:{
                MedalID: _metalId,
                GID: _gid
            },
            success: function(data){
                var dataObj = data.result.receive_medal;
                if(dataObj.errorCode == 0){
                    //success
                    if(dataIdx.indexOf('u') != '-1'){
                        _grade.medalStatus = '2';
                        obj.getIconIdx = undefined;
                        obj.activePic = _grade.picOn;
                        $img.attr('src', obj.activePic);
                        $modal.find('.side>img').attr('src', obj.activePic);
                        $('[data-index='+ dataIdx +']').find('img').attr('src', obj.activePic);
                    }
                    $target.siblings('.medal-get-icon').css({
                        top: '0',
                        opacity: '1'
                    });
                    $target.removeClass('medal-get').addClass('medal-get-done').text('已领取');
                    $('[data-mid='+ _metalId +']').remove();
                    
                }else{
                    alert('领取不成功，请稍后重试')
                }
            }
        });
    });
    //关闭弹框
    $('.medal-modal-close').click(function(){
        $(this).closest('.medal-modal').hide();
        $('.modal_cover').hide();
    });
});

/*新版创建活动目的设定 2015-06*/
$(function(){
    var $active = null,
            $dialog = $('.ed-list-dialog'),
            $search = $dialog.find('input').eq(0),
            $destList = $dialog.find('.dest-list li'),
            $routeList = $dialog.find('.route-list li'),
            activeIdx = 0,
            $activeList = null;
    function reInit(){
        $active = null,
        $dialog = $('.ed-list-dialog'),
        $search = $dialog.find('input').eq(0),
        $destList = $dialog.find('.dest-list li'),
        $routeList = $dialog.find('.route-list li'),
        activeIdx = 0,
        $activeList = null;
    }
    function keyboardSelect(e){
        if(e.which == 13){
            $('.ed-list-dialog').hide(600);
            return false;
        }
        switch(e.which){
            case 40://down
                if(!$active){
                    if($destList.length>0){
                        $activeList = $destList;
                    }else if($routeList.length>0){
                        $activeList = $routeList;
                    }
                }else{
                    if($activeList == $routeList && activeIdx + 2 <= $activeList.length - 1){
                        activeIdx += 2;
                    }
                    if($activeList == $destList){
                        if(activeIdx + 4 > $activeList.length - 1){
                            if($routeList.length>0){
                                activeIdx = 0;
                                $activeList = $routeList;
                            }
                        }else{
                            activeIdx +=4;
                        }
                    }
                }
                break;
            case 38://up
                if($activeList == $destList && activeIdx - 4 >= 0){
                    activeIdx -=4;
                }
                if($activeList == $routeList){
                    if(activeIdx - 2 >= 0){
                        activeIdx -= 2;
                    }else if($destList.length>0){
                        activeIdx = 0;
                        $activeList = $destList;
                    }
                }
                break;
            case 37: //left
                if($activeList == $routeList && activeIdx == 0 && $destList.length>0){
                    activeIdx = 0;
                    $activeList = $destList;
                }
                if(activeIdx > 0){
                    activeIdx -= 1;
                }
                break;
            case 39://right
                if($activeList == $routeList && activeIdx < $routeList.length - 1){
                    activeIdx += 1;
                }
                if($activeList == $destList && activeIdx < $destList.length - 1){
                    activeIdx += 1;
                }else if($activeList == $destList && $routeList.length > 0){
                    activeIdx = 0;
                    $activeList = $routeList;
                }
                break;
        }
        if($activeList){
            $active = $activeList.eq(activeIdx);
        }
        $destList.removeClass('active');
        $routeList.removeClass('active');
        if($active){
            $active.addClass('active');
            $('#drSearch').val($active.attr('data-NodeName'));
        }
    }
    function objToHtml(keyword, obj, type){
        var trees = obj.tree.split('>>'),
            mainCity = trees[trees.length - 2],
            _replace = '<em>'+ keyword +'</em>',
            newName = obj.NodeName.replace(keyword, _replace),
            newSlug = obj.NodeSlug.replace(keyword, _replace),
            _html = '';

            _html += '<li data-NodeID="'+ obj.NodeID+'" data-NodeName="'+ obj.NodeName +'" data-NodeSlug="'+ obj.NodeSlug +'"><p>'+ newName + (mainCity ? ('&nbsp;&nbsp;-&nbsp;&nbsp;'+ mainCity): '') +'</p>';
                
            if(obj.NodeCat != 'route'){
                _html += '<p class="e">' + newSlug + '</p>';
            }
            _html += '</li>';
        return _html;
    }
    $dialog.on('keydown', keyboardSelect);
    //已选择活动目的地
    var _destList = $('[name="event_dest_list"]').val()?JSON.parse($('[name="event_dest_list"]').val()):[];
    var $previewHolder,$preload;
    if(_destList.length){
        for (var i = 0; i < _destList.length; i++) {
            var obj = _destList[i];
            var _html = '<li data-idx="' + i + '"><span>' + obj.DestName + '</span><ul class="select"><li class="dr_delete"><span>删除</span></li>';
            if (obj.ShowRoute == '1') {
                if (!$previewHolder) {
                    $previewHolder = $('<div class="route-preview"></div>').prependTo($('#content').parent());
                }
                $previewHolder.html('');
                $preload = $('<div class="preload"></div>').appendTo($previewHolder);
                _html = '<li data-idx="' + i + '"><i class="dr_showi"></i><span>' + obj.DestName + '</span><ul class="select"><li class="dr_delete"><span>删除</span></li>';
                routePreview(obj.DestID, $previewHolder);
            }
            if (obj.NodeCat == 'route') {
                _html += '<li class="dr_show"><span>展示线路详细信息</span>';
                if (obj.ShowRoute == '1') {
                    _html += '<i class="dr_tick"></i>';
                }
                _html += '</li>';
                $('#drList').data('ifFirstTip', true);
            }
            _html += '</ul></li>';
            $(_html).appendTo($('#drList'));
        }
    }
    
    //活动目的地输入
    $('#drSearch').keyup(function(e){
        if (/(38|40|37|39)/.test(e.which)) return
        var keyword = $(this).val();
        if(e.which == 13 && keyword != ''){
            var obj = {};
            obj.DestName = keyword;
            checkDestList(obj);
        }else{
            if(keyword == ''){
                $('.dest-list, .route-list').hide()
            }else{
                $.post('/api/place/auto_output_nodes',{node_name:keyword},function(data){
                    var _cityHtml = '',
                        _routeHtml = '';
                    if(data.node.length>0){
                        for(var i=0; i<data.node.length; i++){
                            var _obj = data.node[i];
                            if(_obj.NodeCat != 'route'){
                                _cityHtml += objToHtml(keyword, _obj);
                            }else{
                                _routeHtml += objToHtml(keyword, _obj);
                            }
                        }
                        if(_cityHtml != ''){
                            $('.dest-list').html(_cityHtml).show();
                        }
                        if(_routeHtml != ''){
                            $('.route-list').html(_routeHtml).show();
                        }
                        reInit();
                    }else{
                        $('.dest-list').hide();
                    }
                });
            }
        }
    });
    $('.dest-list, .route-list').delegate('>li', 'click', function(){
        $active = $(this);
        $active.addClass('active');
        var e = $.Event("keyup");
        e.which = 13; 
        $('#drSearch').val($active.attr('data-NodeName')).trigger(e);
        $('.ed-list-dialog').hide(600);
    });
    //已选项下拉
    $('.dr_list').delegate('li', 'click', function(e){
        e.stopPropagation();
        $(this).siblings().removeClass('toggle');
        $(this).toggleClass('toggle');
    });
    //删除
    $('.dr_list').delegate('.dr_delete', 'click', function(e){
        var $target = $(this).parent().parent();
        var _idx = parseInt($target.attr('data-idx'));
        for(var i = _idx+1; i<_destList.length; i++){
            $('.dr_list>li').eq(i).attr('data-idx', i-1)
        }
        var _deleteObj = _destList[_idx];
        _destList.splice(_idx, 1);
        $('[name="event_dest_list"]').val(JSON.stringify(_destList));
        $target.remove();
        if(_deleteObj.ShowRoute == '1'){
            $previewHolder.html('');
        }
    });
    $('.ed-list-dialog').click(function(e){
        e.stopPropagation();
    });
    $(document).click(function(e){
        $('.dr_list>li').removeClass('toggle');
        $('.ed-list-dialog').hide(600);
    });
    $('#addEventDestBtn').click(function(e){
        e.stopPropagation();
        $('.ed-list-dialog').show(600);
        $('#drSearch').focus();
    });
    $('#drSure').click(function(){
        var e = $.Event("keyup");
        e.which = 13; 
        $('#drSearch').trigger(e);
        $('.ed-list-dialog').hide(600);
    });
    function checkDestList(obj){
        var _flag = false;
        for(var i=0; i<_destList.length; i++){
            if(_destList[i].DestName == obj.DestName){
                _flag = true;
                break;
            }
        }
        if(!_flag){
            var _idx = _destList.length;
            obj.DestID = 0;
            obj.NodeSlug = '';
            obj.ShowRoute = 0;
            var _html = '<li data-idx="'+ _idx +'"><span>'+obj.DestName+'</span><ul class="select"><li class="dr_delete"><span>删除</span></li>';
            if($active && $active.parent().hasClass('route-list')){
                _html += '<li class="dr_show"><span>展示线路详细信息</span></li>';
                obj.ifRoute = 1;
                if(!$('#drList').data('ifFirstTip')){
                    $('#drList').data('ifFirstTip', true);
                    _html += '</ul><div class="dr_tip"><p>亲，下拉可勾选“展示线路详细信息”哦</p></div>';
                    setTimeout(function(){
                        $('.dr_tip').fadeOut('slow');
                    },5000);
                }
                _html += '</li>';
            }else{
                _html += '</ul></li>';
            }
            if($active){
                obj.DestID = $active.attr('data-NodeID');
                obj.NodeSlug = $active.attr('data-NodeSlug');
            }
            _destList.push(obj);

            $(_html).appendTo($('#drList'));
            $('#drSearch').val('');
            $('.dest-list, .route-list').html('').hide();
            reInit();
        }
        $('[name="event_dest_list"]').val(JSON.stringify(_destList));
        document.validate.element($('input[name="event_dest_list"]'));
    }
    //展示线路信息
    $('.dr_list').delegate('.dr_show', 'click', function(e){
        var $this = $(this),
            $parent = $this.parent().parent(),
            _idx = parseInt($parent.attr('data-idx')),
            _destShowObj = _destList[_idx];

        if($this.find('.dr_tick').length == 0){
            $('<i class="dr_tick"></i>').appendTo($this);
            $('<i class="dr_showi"></i>').prependTo($parent);
            $parent.siblings().find('.dr_tick, .dr_showi').remove();
        }else{
            _destShowObj = null;
            $('.dr_list').find('.dr_tick, .dr_showi').remove();
            $previewHolder.html('');
        }
        $parent.removeClass('toggle');
        for(var i=0; i<_destList.length; i++){
            if(i == _idx && _destShowObj){
                _destList[i].ShowRoute = 1;
                var _destid = _destList[i].DestID;
                if(!$previewHolder){
                    $previewHolder = $('<div class="route-preview"></div>').prependTo($('#content').parent());
                }
                $previewHolder.html('');
                $preload = $('<div class="preload"></div>').appendTo($previewHolder);
                routePreview(_destid, $previewHolder);
            }else{
                _destList[i].ShowRoute = 0;
            }
        }
        $('[name="event_dest_list"]').val(JSON.stringify(_destList));
        //编辑器插入线路信息
        //$(ResBrowser.editor).sceditor('instance').wysiwygEditorInsertHtml('<p>ssss</p>');
    });
    function routePreview(nodeid, $holder){
        $.post('/api/route/get_info',{node_id:nodeid},function(data){
            var info = data.result.data;
            
            if(info.map_line && info.map_line.length){
                $('<img>').attr('src', getAMapImgUrl('689*400',info.map_line)).appendTo($holder);
            }
            $preload.remove();
            //展示
            if(info){
                var _html = '';
                if(info.route_name){
                    _html += '<h4>'+info.route_name+'</h4>';
                }
                if(info.slug_name){
                    _url = 'http://' +SITE_DOMAIN +'/dest/'+ info.slug_name;
                    _html += '(&nbsp;<a href="'+_url+'" target="_blank">查看线路详情&nbsp;:&nbsp;'+_url+'</a>&nbsp;)';
                }
                if(info.route_desc){
                    var _desc = info.route_desc.replace(/\n/g, '<br/>');
                    _html += '<div class="xlzn_des">'+ _desc + '</div>';
                }
                if(info.distance_km){
                    _html += '<div id="infoAlt" class="xlzn_attrfull attr_inline"><span>高度里程 :</span><p>'+ info.distance_km  +'km</p>';
                    var altMax = info.alt_max ? (parseInt(info.alt_max) == 0 ? 0 : parseFloat(info.alt_max).toFixed(2)) : 0,
                        altMin = info.alt_min ? (parseInt(info.alt_min) == 0 ? 0 : parseFloat(info.alt_min).toFixed(2)) : 0;
                    if(altMax && altMin){
                        _html += '<span>最高海拔 :</span><p>'+ altMax  +'m</p>';
                        _html += '<span>最低海拔 :</span><p>'+ altMin  +'m</p>';
                    }
                    _html += '</div>';
                                     
                }
                if(info.route_tag_list.length){
                    _html += '<div class="xlzn_attrfull"><span>特色标签 :</span><p>'+ info.route_tag_list.join('<span class="xlzn_split">/</span>')+'</p></div>';
                }
                if(info.campsite_count){
                    var campCountArr = ['1-5个','5-10个','10-20个','20-50个','50-100个','更多'];
                    if(campCountArr[info.campsite_count-1]){
                        _html += '<div class="xlzn_attrfull"><span>营位数量 :</span><p>'+ campCountArr[info.campsite_count-1]  +'</p></div>';
                    }
                }
                if(info.road_state_ids || info.road_state_desc){
                    var str = [],
                        str2 = info.road_state_desc ? info.road_state_desc.split(','):[];
                    if(info.route_road_list){
                        for(var i=0; i<info.route_road_list.length; i++){
                            str.push(info.route_road_list[i].road_type)
                        }
                    }
                    str = str.concat(str2);
                    str = str.join('<span class="xlzn_split">/</span>');
                    if(str){
                        _html += '<div class="xlzn_attrfull"><span>道路状况 :</span><p>'+ str  +'</p></div>';
                    }
                }
                if(info.campsite_ids){
                    var idArr = info.campsite_ids.split(','),
                        xlznCampArr = ['卫生间','淋浴间','烧烤区', '商店', '可充电', '装备租赁', '停车场', '季节性水源', '常年水源'],
                        str = [];
                    $(idArr).each(function(i, o){
                        if(xlznCampArr[o-1]){
                            str.push(xlznCampArr[o-1]);
                        }
                    });
                    str = str.join('<span class="xlzn_split">/</span>');
                    if(str){
                        _html += '<div class="xlzn_attrfull"><span>营地设施 :</span><p>'+ str  +'</p></div>';
                    }
                }
                if(info.travel_line){
                    var value = info.travel_line.replace(/\n/g, '<br/>');
                    _html += '<div class="xlzn_attrfull"><span>线路行程 :</span><p>'+ value +'</p></div>';
                }
                if(info.traffic_info){
                    var value = info.traffic_info.replace(/\n/g, '<br/>');
                    _html += '<div class="xlzn_attrfull"><span>交通位置 :</span><p>'+ value +'</p></div>';
                }
                if(info.prompt_notice){
                    var value = info.prompt_notice.replace(/\n/g, '<br/>');
                    _html += '<div class="xlzn_attrfull xlzn_tip"><p>重要提示</p><div>'+ value +'</div></div>';
                }
                $holder.append($(_html));
            }
        });
    }
});
/*新版创建活动活动类型选择 2015-06*/
$(function(){
    var $selectedList = $('#drtSelectedList'),
        _selectedArr = $('[name="event_type"]').val()?JSON.parse($('[name="event_type"]').val()):[];

    for(var i=0;i<_selectedArr.length;i++){
        var obj = _selectedArr[i];
        obj.name = obj.CustomName ? obj.CustomName:obj.type_name;
        obj.id = obj.CatID;
        $('<li>'+ obj.name +'<i class="drt_close"></i></li>').appendTo($selectedList);
    }
    $('[name="event_type"]').val(JSON.stringify(_selectedArr))
    //活动类型一级选择
    $('#drtList>li').click(function(e){
        e.stopPropagation();
        var $target = $(this),
            $list = $target.parent(),
            $2rdList = $target.find('.drt_2rd_list').eq(0);

        var _left = $target.position().left - $list.position().left,
            _width = $2rdList.width(),
            _pWidth = $list.width();

        $target.siblings().removeClass('toggle');
        if($2rdList.length>0){
            $target.toggleClass('toggle');
            if(_left+_width>_pWidth){
                $2rdList.css('left', _pWidth-_width-_left-24);
            }
        }else{
            var _text = $target.text();
            if(!checkListExisted(_text)){
                $('<li>'+ _text +'<i class="drt_close"></i></li>').appendTo($selectedList);
                var obj = {
                    name: _text,
                    id: $target.attr('data-id')
                }
                _selectedArr.push(obj);
                $('[name="event_type"]').val(JSON.stringify(_selectedArr));
                document.validate.element($('input[name="event_type"]'));
            }
        }
    });
    //活动类型二级选择
    $('.drt_2rd_list>li').click(function(e){
        e.stopPropagation();
        var $target = $(this);
        var _text = $target.text();
        if(!checkListExisted(_text)){
            $('<li>'+ _text +'<i class="drt_close"></i></li>').appendTo($selectedList);
            var obj = {
                name: _text,
                id: $target.attr('data-id') 
            }
            _selectedArr.push(obj);
            $('[name="event_type"]').val(JSON.stringify(_selectedArr));
            document.validate.element($('input[name="event_type"]'));
        }
        $target.parent().parent().removeClass('toggle');
    });
    //删除
    $('#drtSelectedList').delegate('li', 'click', function(){
        $(this).remove();
        var _text = $(this).text();
        for(var i=0; i<_selectedArr.length; i++){
            if(_text == _selectedArr[i].name){
                _selectedArr.splice(i, 1);
                $('[name="event_type"]').val(JSON.stringify(_selectedArr));
            }
        }
    });
    $(document).click(function(e){
        $('#drtList>li').removeClass('toggle');
    });
    function checkListExisted(text){
        var _ifExisted = false;
        for(var i=0; i<_selectedArr.length; i++){
            if(text == _selectedArr[i].name){
                _ifExisted = true;
                break;
            }
        }
        return _ifExisted;
    }
    //自定义输入框
    $('#typeCustom').keyup(function(e){
        var _text = $.trim($(this).val());
        if(e.which == 13){
            if(_text == '') return;
            if(!checkListExisted(_text)){
                $('<li>'+ _text +'<i class="drt_close"></i></li>').appendTo($selectedList);
                var obj = {
                    name: _text,
                    id: 0
                }
                _selectedArr.push(obj);
                $('[name="event_type"]').val(JSON.stringify(_selectedArr));
                document.validate.element($('input[name="event_type"]'));
                $(this).val('');
                $('#drtList').children().last().removeClass('toggle');
            }
        }
    }).keydown(function(e){
        if(e.which == 13){
            e.preventDefault();
            return false;
        }
    }).click(function(e){
        e.stopPropagation();
    });
});
function getAMapImgUrl(size, pointsArr){//$('#testMap').attr('src', getAMapImgUrl('300*220',,mapLineArr))
    var url = 'http://restapi.amap.com/v3/staticmap?',
        key = '3e0367750ed9d9215ff82e6c3e91f939',
        points = '',
        pathsObj = '3,0xa75cde,1,,';

    for(var i=0,len=pointsArr.length; i<len; i++){
        if(pointsArr[i].Lng && pointsArr[i].Lat){
            points += pointsArr[i].Lng + ',' + pointsArr[i].Lat + ';';
        }
    }
    if(points.length){
        points = points.substr(0, points.length-1);
    }
    //return url+'size='+size+'&paths='+pathsObj+':'+points+'&key='+key+'&markers=mid,0xFF0000,A:'+pointsArr[0].Lng+','+pointsArr[0].Lat+'|mid,0xFF0000,B:'+pointsArr[pointsArr.length-1].Lng+','+pointsArr[pointsArr.length-1].Lat;
    var beginImgUrl = MISC_PATH +'images/event/mapicon_begin.png';
    var endImgUrl = MISC_PATH +'images/event/mapicon_end.png';
    return url+'size='+size+'&paths='+pathsObj+':'+points+'&key='+key+'&markers=-1,'+beginImgUrl+',0:'+pointsArr[0].Lng+','+pointsArr[0].Lat+'|-1,'+endImgUrl+',0:'+pointsArr[pointsArr.length-1].Lng+','+pointsArr[pointsArr.length-1].Lat;
}