/**目的地 scene**/

$(function(){


    /**目的地首页导航 scene_menu**/
    var sceneMenu = $('.scene .scene_menu li');
    sceneMenu.hover(function(){
        sceneMenu.removeClass('current');
        $(this).addClass('current');
    },function(){
        $(this).removeClass('current');
    });


    /**印象墙 我的印象列表**/
    var sceneMyImpressLi = $('.scene_impress .my_impress li');
    sceneMyImpressLi.hover(function(){
        sceneMyImpressLi.removeClass('current');
        $(this).addClass('current');
    },function(){
        $(this).removeClass('current');
    });

    /**印象墙 添加我的印象**/
    var addMyImpress = $('.addMyImpress');
    var addMyImpressBox = $('#addMyImpressBox');
    var addMyImpressForm = $('#addMyImpressForm');
    var addMyImpressTips = $('#addMyImpressForm .backTips');

    addMyImpress.click(function(){
        setTimeout(function(){
            showShade();
            $('#addMyImpressBox #sets_desc').val('');
            addMyImpressTips.empty();
            addMyImpressForm.show();
            addMyImpressBox.show();
            addMyImpressBox.find('.AllWords i').html('0');
        },500);
    });

    /**添加我的印象ajax**/
    addMyImpressForm.ajaxForm({
        dataType:'json',
        success: function(data){
            if(data.error == 0){
                addMyImpressForm.hide();
                var $successDiv = $('<p class="success">感谢您添加<?php echo $dest?>印象,审核通过后,即可显示!</p>');
                addMyImpressBox.find('.layer-content').append($successDiv);
                setTimeout(function(){
                    $(".layer-close").click();
                    addMyImpressBox.find('.layer-content .success').remove();
                },2000);
            }
            else{
                addMyImpressTips.empty().html(data.msgs).show().fadeOut(1000);
            }
        }
    });


    //遮罩层输入印象textarea
    //输入框聚焦的时候，取消键盘事件
    $('.RelyForm textarea').focus(function(){
        document.isfocus = true;
    }).blur(function(){
            document.isfocus = false;
        }).live('keyup',function(e){
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
    /**印象墙拖拽 **/
    /*var impress_note = $('.impress_board .impress_note');
    if(impress_note.size()>0){
        for(var i=0;i<=impress_note.length;i++){
            var posX = SetRandom("796");
            var posY = SetRandom("365");
            impress_note.eq(i).animate({
                left:"+="+posX,
                top:"+="+posY
            }).css("color",setRandomColor());
            hideWord(impress_note.eq(i),23)
        }

        var noteNum=impress_note.length;
        impress_note.mousedown(function(){
            $(this).css("z-index",noteNum).siblings().css("z-index",noteNum-1);
        });

        Drag("impressWrap","div")
    }*/

    /**删除我的印象**/
    $('.my_impress .delImpress').click(function(){
        var obj = $(this);
        alertLayer('您确定要删除该印象吗？',function(){
            var ajaxUrl = obj.attr('ajaxUrl');
            $.get(ajaxUrl,function(data){
                if(data.error==0){

                    window.location.reload();
                }
                else{
                    alert(data.msgs);
                }
            },'json');
        });
    });

    //图片上下div中心
    (function adjust_pic(){
        var cntr_width,cntr_height,an_cntr_width,an_cntr_height,margin_top;
        if($('.adjust_pic_position').hasClass('img_li')){
            cntr_width = $('.focusView .images').width();
            cntr_height = $('.focusView .images').height();
        }
        if($('.adjust_pic_position').hasClass('must_go')){
            an_cntr_width = $('.must_go img').parent().width();
            an_cntr_height = $('.must_go img').parent().height();
        }
        $('.adjust_pic_position img').each(function(){
            if($(this).attr('size') !== undefined){
                var tmpStr = $(this).attr('size').split('X');
                var width = tmpStr[0];
                var height = tmpStr[1];
                var ratio = width / height;
                var new_height;
                if($(this).parent().parent().hasClass('img_li')){
                    new_height = cntr_width / ratio;
                    margin_top = '-'+(new_height - cntr_height) / 2 + 'px';

                }else{
                    new_height = an_cntr_width / ratio;
                    margin_top = '-'+(new_height - an_cntr_height) / 2 + 'px';
                }
                $(this).css('marginTop',margin_top);
            }
        });
    })();

    //想去/去过
    $('.want_togo,.been_btn').hover(
        function(){
            $(this).addClass('show');
        },
        function(){
            $(this).removeClass('show');
        });

    //显示数字+1
    $('.want_togo,.been_btn,.impress_block p a').click(function(e){

        var _that = $(this);
        var node_id = $('#node_id').attr('node_id');
        var detect = $(this).find('.goodNum').length;

        $(this).find('.goodNum').show(0).animate({top:'-35px',fontSize:'20px',opacity:'0'},500,function(){
            var $text = _that.find('.count_num').text();
            var old_num = parseInt($text);
            var new_num = old_num + 1;
            $(this).css({opacity:1,top:'0px',fontSize:'12px'}).hide();
            _that.find('.count_num').text(new_num);
        });
		if($(e.target).parent().attr('class') == 'been_btn addMyImpress show'){
            $.get('/api/place/addVisited/',{node_id:node_id},function(data){
                //console.log(data);
            },'json');
		}
		if($(e.target).parent().attr('class') == 'want_togo show'){
			$.get('/api/place/addWish/',{node_id:node_id},function(data){
                //console.log(data);
			},'json');

		}
        if($(e.target).hasClass('click_impression_btn')){
            $(this).next().show(0).animate({top:'-35px',fontSize:'20px',opacity:'0'},500);
            var node_id = $("input[name='node_id']").val();
            var content = $(this).text();
            var ext = 'double';
            var _that = $(this);
            $.get('/api/place/add/',{node_id:node_id,content:content,ext:ext},function(data){
                if(data.error == 0){
                    _that.unbind().css('cursor','default');
                }
            },'json');
        }
		
    });

    //赞+1

    $('.scene .good,.continent .good').click(function(){
        var detect = $(this).find('.goodNum').length;
		var topic_id = $(this).attr('tid');
		var old_num = parseInt($(this).find('.good_count').text());

		var _that = $(this);
		$.get('/api/place/addDig',{tid:topic_id},function(data){
            //console.log(data);
            if(data.error == 1){
                //console.log(data.error_code);
                showShade();
                var top = $(window).height()/2 - 200;
                var htmlStr = '';
                var href = window.location.href;

                if(data.error_code==1){
                    alertLayer("登录后才可以进行赞操作哦！您确定现在要登录吗",function(){
                        window.location.href = '/user/login/?url='+href;
                    });
                }else{
                    htmlStr += '<div class="layer alertLayer" style="position:fixed;top: '+ top +'px;">';
                    htmlStr += '<div class="layer-title"><p><span title="关闭" href="#" class="layer-close">&nbsp;</span><span>提示信息</span></p></div><div class="layer-content">';
                    htmlStr += '<p class="content-p">'+data.msgs+'</p><p class="button-p"><a	href="javascript:void(0);" class="button-mini layer-cancel">关闭</a></p></div></div>';
                }
				$tmpDiv = $(htmlStr);
				$('body').append($tmpDiv);
			}else if(data.error == 0){
                var new_num = old_num + 1;
                _that.find('.goodNum').show(0).animate({top:'-35px',fontSize:'20px',opacity:'0'},500,function(){
                    $(this).css({opacity:1,top:'0px',fontSize:'12px'}).hide();
                    _that.find('.good_count').text(new_num);
                });
            }

		},'json');

    });

    //快速提交印象
    $('#quick_add_impress_form').ajaxForm({
        dataType: 'json',
        beforeSubmit:function(){
            var val = $.trim($('.type_impress').val());
            if(val == ''){
                return false;
            }
        },
        success: function(data){
            if(data.error == 0){
                $('.hidden_input .type_impress').val('');
                $('.post_tips p').html('感谢您添加印象，审核通过后，即可显示！');

            }else{
                $('.post_tips p').html(data.msgs);
            }
            $('.post_tips').show().delay(2400).fadeOut(500);
        }
    });

    //ie7,8placeholder
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

    /**图片hover cover显示图片信息**/
    $('.img_cover_info_wrap li,.img_cover_info_wrap_sp').hover(function(){
        var oimg_cover = $(this).find('.img_cover_info');
        var extend_top = 0;
        var text = oimg_cover.find('p').text();
        if($(this).parent().hasClass('half_height')){
            var old_top = parseInt($(this).height());
            var new_top = old_top - oimg_cover.height();
            $(this).siblings().find('a').stop().animate({opacity:0.2}, 300);
            if(text != '')oimg_cover.stop().animate({top:new_top}, 500);
        }else{
            if(text != '')$(this).find('.img_cover_info').stop().animate({top:extend_top}, 500);
        }

    },function(){
        var oimg_cover = $(this).find('.img_cover_info');
        var extend_height = $(this).height();
        var shrink_height = oimg_cover.find('h3').height();
        var shrink_top = extend_height - shrink_height;
        var text = oimg_cover.find('p').text();
        if($(this).parent().hasClass('half_height')){
            $(this).siblings().find('a').stop().animate({opacity:0}, 300);
        }

        if(text != '')oimg_cover.stop().animate({top:shrink_top}, 500);
    });

    //目的地列表tab切换
    $('.dest_list_tabs a').click(function(){
        $(this).parent().addClass('current').siblings().removeClass('current');
        var index = $(this).parent().index();
        var $current_obj = $(this).parents('.dest_list_tab_wrap').find('.dest_list_box').children().eq(index);
        $current_obj.siblings().hide();
        $current_obj.fadeIn();
    });

	//小印象展示
	var impress_block = $('.impress_board .impress_block p');
    var impress_note = $('.impress_board .impress_note p');
    if(impress_block.size()>0){
        for(var j=0;j<=impress_block.length;j++){
            /*var poY = randomNumRange(1,20);
            impress_block.eq(j).animate({
                fontSize:"+="+poY
            }).css("background",setRandomColor());*/
            impress_block.eq(j).css("background",setFiveColor());
        }
    }
    if(impress_note.size()>0){
        for(var j=0;j<=impress_note.length;j++){
            impress_note.eq(j).css("background",setFiveColor());
        }
    }


});

//设置随机数
function SetRandom(n){
    randomNum=Math.floor(Math.random()*n+1);
    return randomNum;
}
//获取范围内的随机数
 function randomNumRange(min,max){
    return Math.floor(min+Math.random()*(max-min));
}

//设置随机颜色
function setRandomColor() {
    //16进制方式表示颜色0-F
    var arrHex = ["0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F"];
    var strHex = "#";
    var index;
    for(var i = 0; i < 6; i++) {
        //取得0-15之间的随机整数
        index = Math.round(Math.random() * 15);
        strHex += arrHex[index];
    }
    return strHex;
}
//设置5种固定颜色
function setFiveColor(){
    var color_list = ['#f7ae6b','#e4d061','#8ac2ec','#a1dd75','#c9b1e5'];
    var color;
    var random = parseInt(Math.random()*(4-0+1)+0);
    color = color_list[random];
    return color;
}

//印象墙超出字数显示省略号
function hideWord(thisObj,showLeng){
    var nowObj = thisObj.find('p');
    var nowLength = 0;
    for(var i = 0; i < nowObj.text().length; i++){
        if(nowObj.html().charCodeAt(i) > 127){
            nowLength++;
        }
    }
    if(nowLength > showLeng){
        var nowWord = nowObj.html().substr(0,showLeng)+'...';
        nowObj.html(nowWord);
    }
}
//没有元素就不显示更多
$(function(){
    if($('.any_result').find('.no_result').length == 0){
        $('.any_result').find('.more_impress').css('display','block');
    }else{
        $('.any_result').find('.more_impress').css('display','none');
    }
    if($('.dest_hotel').find('.img_cover_info_wrap li').size() == 0){
        $('.dest_hotel').css('display','none');
    }
});

//印象墙拖拽
/*function Drag(wrapper,div){
    var wrap = document.getElementById(wrapper);
    var obj=document.getElementById(wrapper).getElementsByTagName(div);
    for(var i=0;i<obj.length;i++){
        dragFunction(obj[i],wrap);
    }
}*/

/**完美拖拽方法*
 * @param obj 拖拽的对象
 * @param wrap 拖拽对象的容器
 * */

/*function dragFunction(obj,wrap){

    var mouseStart={};
    var divStart={};

    //开始
    obj.onmousedown=function(ev)
    {
        var oEvent=ev||event;
        //获取鼠标和目标的初始位置
        mouseStart.x=oEvent.clientX;
        mouseStart.y=oEvent.clientY;
        divStart.x=obj.offsetLeft;
        divStart.y=obj.offsetTop;

        //事件获取（并作兼容判断）
        if(obj.setCapture)
        {
            obj.onmousemove=doDrag;
            obj.onmouseup=stopDrag;
            obj.setCapture();
        }
        else
        {
            document.addEventListener("mousemove",doDrag,true);
            document.addEventListener("mouseup",stopDrag,true);
        }

    };
    //进行
    function doDrag(ev)
    {
        var oEvent=ev||event;
        //公式：当前鼠标位置-起始鼠标位置+目标位置
        var l=oEvent.clientX-mouseStart.x+divStart.x;
        var t=oEvent.clientY-mouseStart.y+divStart.y;
        //判断对象只能在容器内拖拽
        if(l<0)
        {
            l=0;
        }
        else if(l>wrap.clientWidth-obj.offsetWidth)
        {
            l=wrap.clientWidth-obj.offsetWidth;
        }
        if(t<0)
        {
            t=0;
        }
        else if(t>wrap.clientHeight-obj.offsetHeight)
        {
            t=wrap.clientHeight-obj.offsetHeight;
        }
        obj.style.left=l+"px";
        obj.style.top=t+"px";
        document.unselectable  = "on";
        document.onselectstart = function(){
            return false;
        };
        window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
    }
    //停止
    function stopDrag()
    {
        //取消事件（并作兼容判断）
        if(obj.releaseCapture)
        {
            obj.onmousemove=null;
            obj.onmouseup=null;
            obj.releaseCapture();
        }
        else
        {
            document.removeEventListener("mousemove",doDrag,true);
            document.removeEventListener("mouseup",stopDrag,true);
        }

        document.unselectable  = "off";
        document.onselectstart = null;
    }
}*/
//计算字符数函数
function showWords(obj){
    var value = $.trim($(obj).val());
    var limit = 70;
    var $parent = $(obj).parents('form').first();

    var len = value.length;
    if(len <= limit){
        $parent.find('.AllWords i').html(len);
    }
    else{

        $parent.find('.AllWords i').html(limit);
        $(obj).val(value.substr(0,limit));
    }

}
//取得当前的时间戳
function timestamp() {
    var timestamp = Date.parse(new Date());
    return timestamp;
}
//目的地新版
$(function(){
    $('.route_show .tab [data-target]').click(function(e){
        e.preventDefault();
        var $this = $(this),
            $target = $($this.attr('data-target'));

        if($this.parent().hasClass('active')){
            return;
        }else{
            $this.parent().siblings().removeClass('active');
            $this.parent().addClass('active');
            $target.siblings('.tab_content').removeClass('active');
            $target.addClass('active');
        }
    });
    $('.route_show .item>a').hover(function(){
        var $target = $(this).find('.info>div');
        $target.addClass('fadeInUp animated');
        $(this).find('.info').addClass('fadeIn animated');
        $(this).find('.shadow').addClass('fadeIn70 animated');
    },function(){
        var $target = $(this).find('.info>div');
        $target.removeClass('fadeInUp animated');
        $(this).find('.info').removeClass('fadeIn animated');
        $(this).find('.shadow').removeClass('fadeIn70 animated');
    });
    $('.route_dest_icon').hover(function(){
        $('.route_ditxt').fadeIn();
    }, function(){
        $('.route_ditxt').fadeOut();
    });
    $('.route_newadd [data-target]').click(function(){
        var $target = $($(this).attr('data-target'));
        $('.route_faq').hide();
        $target.show();
        $('.xlzn_modal_cover').show();
    }); 
    $('.faq_close').click(function(e){
        e.preventDefault();
        $(this).closest('.route_faq').hide();
        $('.xlzn_modal_cover').hide();
    });
    //cookie
    if($('[data-cookieurl]').size()>0){
        $.cookie('addroute_return_url', window.location.href,{path:'/'});
    }
});
//目的地城市改版 2015-06
$(function(){
    //顶部nav
    $('#sceneTopNav li').click(function(){
        var $this = $(this),
            $content = $($this.attr('data-target'));

        $this.addClass('active').siblings().removeClass('active');
        $content.addClass('active').siblings('.scene_content').removeClass('active');
        $('body').get(0).scrollIntoView();
    });
    //更多跳到相应tab下
    $('[data-tabhref]').click(function(e){
        e.preventDefault();
        $('[data-target="'+ $(this).attr('data-tabhref') +'"]').click();
    });
    //线路tab下
    var routeTab = {
        currTypeId: null,
        currPage: 1,
        pageSize: 10
    }
    //线路tab第一次加载
    $('[data-target="#sceneRoute"]').one('click',function(){
        //地图数据，活动类型
        $.post('/dest/route_map',{
            p_node_id: window.nodeid
        },function(data){
            //线路类别
            var typeData = data.result.type_count;
            if(typeData && typeData.length){
                var _html = '<a class="active">全部<span>('+ data.total +')</span></a>';
                var $holder = $('#typeFilter');
                for(var i=0;i<typeData.length;i++){
                    var obj = typeData[i];
                    if(obj.count>0){
                        _html +='<a data-id="'+ obj.id +'">'+ obj.type_name +'<span>('+ obj.count +')</span></a>';                 
                    }
                }
                $holder.html(_html);
                //类别筛选
                $('#typeFilter a').click(function(e){
                    e.preventDefault();
                    var $target = $(this),
                        _typeid = $target.attr('data-id');
                    if($target.hasClass('active')) return;
                    routeTab.currTypeId = _typeid ? parseInt(_typeid):null;
                    routeTab.currPage = 1;
                    getRouteList(window.nodeid, routeTab.currPage, routeTab.currTypeId);
                    $target.siblings().removeClass('active');
                    $target.addClass('active');
                });
                $('#routeTypeArea').show();
            }
            //线路地图
            var mapData = data.result.map_route_data.route_list;
            if(mapData && mapData.length>0){
                $.getScript('http://webapi.amap.com/maps?v=1.3&key=87feaa903d10b94ab1db92ba3cffb59e').done(function() {
                    if (typeof AMap != 'undefined') {
                        var mapObj = new routeAmap('routeMap');
                        for (var i = 0; i < mapData.length; i++) {
                            var obj = mapData[i];
                            obj.position = {
                                lat: obj.offset_lati,
                                lng: obj.offset_lngi
                            }
                            obj._url = '/dest/'+obj.slug_name;
                            obj.infoHtml = '<p><a href="'+obj._url +'" target="_blank">'+ obj.route_name +'</a></p>';
                            obj.extraClass = 'xlzn_marker_style'+obj.route_type_id;
                            mapObj.addMarker(obj.position, obj.infoHtml, obj.extraClass);
                        }
                        mapObj.mapObj.setFitView();
                    }

                }).fail(function() {

                });
            }else{
                $('#routeNone').show();
            }
        });
        //线路列表初始化
        getRouteList(window.nodeid, routeTab.currPage, routeTab.currTypeId);
        //分页
        $('#routePagination').delegate('a','click',function(e){
            e.preventDefault();
            var $target = $(this);
            if($target.hasClass('active') || $target.hasClass('disabled')) return;
            if($target.hasClass('prev')){
                routeTab.currPage--;
            }else if($target.hasClass('next')){
                routeTab.currPage++;
            }else{
                routeTab.currPage = parseInt($target.attr('data-href'));
            }
            getRouteList(window.nodeid, routeTab.currPage, routeTab.currTypeId);
            $('#routeTypeArea').get(0).scrollIntoView();
        });
    });
    function getRouteList(_nodeid, _page, _typeid){
        //线路列表
        var postData = {
            p_node_id: _nodeid,
            page: _page,
            page_size: routeTab.pageSize
        }
        $('#routePreload').show();
        $('#routeList').html('');
        if(_typeid) postData.route_type_id = _typeid;
        $.post('/dest/route_tab', postData,function(data) {
            var count = data.result.route_list_data.route_count,
                routeList = data.result.route_list_data.route_list,
                pageNum = Math.ceil(count/10),
                $routeList = $('#routeList');

            if(count>0){
                var _html = ''
                for(var i=0; i<routeList.length; i++){
                    _html += routeObjHtml(routeList[i]);
                }
                $routeList.html(_html);
                $('#routePreload').hide();
                //评分星星
                $('[data-score]').each(function(i, obj){
                    initStar($(obj));
                });
                //分页
                if(count>routeTab.pageSize){
                    xlznNav(_page, pageNum, $('#routePagination'));
                    $('#routePagination').show();
                }else{
                    $('#routePagination').hide();
                }
            }
        })
    }
    function routeObjHtml(obj){
        var _url = '/dest/'+obj.slug_name;
        var _imgUrl = obj.img_list.length>0 ? obj.img_list[0].Path:(MISC_PATH+'images/scene/default_note.png');
        var _html = '<li><a class="xlzn_list_view" href="'+_url+'" target="_blank"><img src="'+_imgUrl+'"></a>';
        _html +='<span class="xlzn_type xlzn_type_'+ obj.route_type_id +'"></span>';
        _html +='<div class="xlzn_list_info"><h3><a href="'+_url+'" target="_blank">'+obj.route_name+'</a></h3>';
        _html +='<div><div class="score"><span class="route_star_sm"><i></i></span><span class="num" data-score="'+ obj.star_level +'"></span></div>';
        var typeArr = obj.tag_str;
        if(typeArr.length){
            _html +='<div class="label">标签:&nbsp;';
            for(var i=0; i<typeArr.length; i++){
                _html +='<a href="/s/route?fr=nav&amp;keyword='+ typeArr[i] +'&amp;from=result" target="_blank">';
                _html +='<span>'+ typeArr[i] +'</span></a>';
            }
             _html +='</div>';
        }
        _html +='</div></div></div></li>';         
        return _html;               
    }
    //线路评分星星
    function initStar($obj){
        var $target = $obj,
            score = parseFloat($target.attr('data-score')) ? parseFloat($target.attr('data-score')):0;
            if($target.children().length){
                $target.children().text(score.toFixed(1));
            }else{
                $target.text(score.toFixed(1));
            }
            $target.siblings('.route_star_big, .route_star_sm').children().css('width', score/5 *100 + '%');
        $target.parent().show();
        
    }
    //线路地图对象
    function routeAmap(eleId) {
        var self = this;

        function init() {
            self.mapObj = new AMap.Map(eleId, {
                //二维地图显示视口
                view: new AMap.View2D({
                    zoom: 12 //地图显示的缩放级别
                })
            });
        }
        self.addMarker = function(location, infoHtml, extraClass) {
            var position = new AMap.LngLat(location.lng, location.lat);
            var iconHtml = '<div class="xlzn_marker_wrap"><a class="xlzn_marker ' + extraClass + '"></a></div>';

            var marker = new AMap.Marker({
                topWhenMouseOver: true,
                map: self.mapObj,
                position: position, //基点位置
                offset: new AMap.Pixel(0, -34), //相对于基点的偏移位置
                content: iconHtml //自定义点标记覆盖物内容
            });
            var infoWrap = '<div class="rmap-wrap"><div class="rmap-content">'+ infoHtml +'</div><div class="rmap-sharp"></div></div>';
            var inforWindow = new AMap.InfoWindow({
                offset: new AMap.Pixel(38, -4),
                content: infoWrap,
                size:{
                    width: 150
                },
                isCustom: true
            });
            AMap.event.addListener(marker, "mouseover", function(e) {
                inforWindow.open(self.mapObj, marker.getPosition());
            });
            AMap.event.addListener(marker, "mouseout", function(e) {
                inforWindow.close();
            });
            marker.setShape(new AMap.MarkerShape({
                type: 'rect',
                coords: [0, 0, 34, 44]
            }));
            marker.setMap(self.mapObj); //在地图上添加点

        }
        init();
    }
    //游记tab下
    var travelTab = {
        currPage: 1,
        pageSize: 10,
        type: 'rank' //time
    }
    //游记tab第一次加载
    $('[data-target="#sceneTravel"]').one('click',function(){
        getTravelList(travelTab.currPage,travelTab.type, true);
        //分页
        $('#travelPagination').delegate('a','click',function(e){
            e.preventDefault();
            var $target = $(this);
            if($target.hasClass('active') || $target.hasClass('disabled')) return;
            if($target.hasClass('prev')){
                travelTab.currPage--;
            }else if($target.hasClass('next')){
                travelTab.currPage++;
            }else{
                travelTab.currPage = parseInt($target.attr('data-href'));
            }
            
            getTravelList(travelTab.currPage, travelTab.type);
            $('body').get(0).scrollIntoView();
        });
    });
    //游记好贴，新帖切换
    $('#travelType>a').click(function(e){
        e.preventDefault();
        var $target = $(this);
        if($target.hasClass('cur')) return;
        $target.siblings().removeClass('cur');
        $target.addClass('cur');
        travelTab.type = $target.attr('data-type');
        travelTab.currPage = 1;
        getTravelList(travelTab.currPage,travelTab.type, true);
    });
    function getTravelList(_page, _type, ifChangeType){
        var postData = {
            node_id: window.nodeid, 
            act: _type,
            p: _page,
            page_size: travelTab.pageSize
        }
        $('#travelList').html('');
        $('#travelPreload').show();
        $.post('/dest/travel_tab', postData, function(data){
            var travelData = data.result.travel_data;
            var count = data.total;
            if(travelData){
                if(count > 0){
                    var nodeList = travelData.node_note_list,
                        nodePic = travelData.node_note_pic,
                        nodePost = travelData.node_note_post;
                    var _html = '';
                    for(var i=0;i<nodeList.length; i++){
                        var obj = nodeList[i],
                            topicid = obj.TopicID,
                            imgurl = nodePic[topicid] ? nodePic[topicid].Path : (MISC_PATH+'images/scene/default_note.png'),
                            content = nodePost[topicid].PostContent_short;
                        _html += travelObjHtml(obj, imgurl, content);
                    }
                    $('#travelPreload').hide();
                    $('#travelList').html(_html);
                }

                if(count > travelTab.pageSize){
                    var totalPgae = Math.ceil(count/travelTab.pageSize);
                    xlznNav(travelTab.currPage, totalPgae, $('#travelPagination'));
                    $('#travelPagination').show();
                }else if(count <= travelTab.pageSize){
                    $('#travelPagination').hide();
                }
            }
        });
    }
    function travelObjHtml(_node,_imgurl,_content){
        var topicId = _node.TopicID;
        var _html ='<li>';
            _html +='   <div class="img_wrap">';
            _html +='       <a target="_blank" href="/forum/'+ topicId +',0,0,0.html"><img src="'+ _imgurl +'" /></a>';
            _html +='   </div>';
            _html +='   <div class="desc">';
            _html +='       <div class="widgetBox">';
            _html +='           <div class="rounded_rectangle"><a href="/user/'+_node.AuthorID+'"><img src="'+_node.Face+'"/></a></div>';
            _html +='           <div class="fun_box">';
            _html +='               <h3><a target="_blank" href="/forum/'+ topicId +',0,0,0.html" title="'+_node.Title+'" >'+_node.Title+'</a></h3>';
            _html +='               <div class="top clearfix">';
            _html +='                   <div class="widget_right">';
            _html +='                       <span class="see_count" title="浏览">'+_node.HitNum+'</span>';
            _html +='                       <span class="comt_count" title="回复">'+_node.PostNum+'</span>';
            _html +='                   </div>';
            _html +='                   <span>作者：<a class="info_user"  rel="info_user_'+_node.AuthorID+'" >'+_node.Author+'</a></span><span>'+_node.Created+'</span>';
            _html +='               </div>';
            _html +='           </div>';
            _html +='           <div class="good_wrap">';
            _html +='               <a class="good" tid="'+ topicId +'" title="好评">';
            _html +='                   <span class="good_img"></span>';
            _html +='                   <span class="good_count">'+_node.DigNum+'</span>';
            _html +='                   <b class="goodNum">+1</b>';
            _html +='               </a>';
            _html +='           </div>';
            _html +='       </div>';
            _html +='       <p>'+ _content +'</p>';
            _html +='   </div>';
            _html +='</li>';
        return _html;
    }
    //游记赞
    $('#travelList').delegate('.good','click',function(){
        var detect = $(this).find('.goodNum').length;
        var topic_id = $(this).attr('tid');
        var old_num = parseInt($(this).find('.good_count').text());

        var _that = $(this);
        $.get('/api/place/addDig',{tid:topic_id},function(data){
            //console.log(data);
            if(data.error == 1){
                //console.log(data.error_code);
                showShade();
                var top = $(window).height()/2 - 200;
                var htmlStr = '';
                var href = window.location.href;

                if(data.error_code==1){
                    alertLayer("登录后才可以进行赞操作哦！您确定现在要登录吗",function(){
                        window.location.href = '/user/login/?url='+href;
                    });
                }else{
                    htmlStr += '<div class="layer alertLayer" style="position:fixed;top: '+ top +'px;">';
                    htmlStr += '<div class="layer-title"><p><span title="关闭" href="#" class="layer-close">&nbsp;</span><span>提示信息</span></p></div><div class="layer-content">';
                    htmlStr += '<p class="content-p">'+data.msgs+'</p><p class="button-p"><a    href="javascript:void(0);" class="button-mini layer-cancel">关闭</a></p></div></div>';
                }
                $tmpDiv = $(htmlStr);
                $('body').append($tmpDiv);
            }else if(data.error == 0){
                var new_num = old_num + 1;
                _that.find('.goodNum').show(0).animate({top:'-35px',fontSize:'20px',opacity:'0'},500,function(){
                    $(this).css({opacity:1,top:'0px',fontSize:'12px'}).hide();
                    _that.find('.good_count').text(new_num);
                });
            }

        },'json');
    });
    //活动tab下
    var eventTab = {
        currPage: 1,
        pageSize: 10
    }
    //活动tab第一次加载
    $('[data-target="#sceneEvent"]').one('click',function(){
        getEventList(eventTab.currPage);
        //分页
        $('#eventPagination').delegate('a','click',function(e){
            e.preventDefault();
            var $target = $(this);
            if($target.hasClass('active') || $target.hasClass('disabled')) return;
            if($target.hasClass('prev')){
                eventTab.currPage--;
            }else if($target.hasClass('next')){
                eventTab.currPage++;
            }else{
                eventTab.currPage = parseInt($target.attr('data-href'));
            }
            getEventList(eventTab.currPage);
            $('body').get(0).scrollIntoView();
        });
    });
    function getEventList(_page){
        var postData = {
            node_name: window.nodename, 
            page: _page,
            page_size: eventTab.pageSize
        }
        $.post('/dest/activity_tab', postData, function(data){
            var count = data.total;
            if(count>0){
                var eventData = data.result.activity_data,
                    list = eventData.event_list;
                    if(list.length>0){
                        var _html = '';
                        for(var i=0;i<list.length; i++){
                            _html += eventObjHtml(list[i]);
                        }
                        $('#eventList').html(_html);
                    }
                    if(count > eventTab.pageSize){
                        var totalPgae = Math.ceil(count/eventTab.pageSize);
                        xlznNav(eventTab.currPage, totalPgae, $('#eventPagination'));
                        $('#eventPagination').show();
                    }else{
                        $('#eventPagination').hide();
                    }
            }else{
                $('#eventNone').show();
            }
        });
    }
    function eventObjHtml(obj){
        var _html = '<dl class="dl-list-new">';
        _html += '      <dd class="img"><a href="/user/'+obj.UserID+'" target="_blank"><img alt="" src="'+ obj.Face +'"></a></dd>';
        _html += '      <dt><h3><a href="'+ obj.Url +'" target="_blank">'+ obj.EventTitle +'</a></h3></dt>';
        _html += '      <dd class="des">';
        _html += '          <span>发起人:<a href="/user/'+obj.UserID+'" class="info_user pr16" rel="info_user_20150" target="_blank">'+ obj.EventLeader +'</a></span>';
        _html += '          <span>目的地:'+obj.dest+'</span>';
        _html += '          <span>确认人数:'+obj.MemberNum+'/'+obj.MemberLimit+'</span>';
        _html += '          <span>共'+obj.Days+'天</span>';
        _html += '</dd></dl>';
        return _html;
    }
});

