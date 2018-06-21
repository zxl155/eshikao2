$(function(){
    function createCardList(data){
        var _html = '';
        var status={};
        status[1]='召集中';
        status[2]='已满员';
        status[3]='已结束';
        var gender={};
        gender[1]='';
        gender[2]='male';
        gender[3]='female';
        for(var i=0,len=data.length; i<len; i++){
            var obj = data[i];
            _html += '<li class="card-item">';
            _html += '<a target="_blank" href="/event/yueban/detail/'+obj.node_id+'">'+''+'<div class="c-show"><img src="'+obj.image +'" alt="" />';
            _html += '<div class="t-wrap"><h4 class="part-title multi">'+obj.title+'</h4></div>';
            _html += '<div class="anim-des"><h4 class="title">'+obj.title+'</h4>';
            _html += '<span class="date">'+ obj.created_at +'&nbsp;发布</span>';
            if(obj.fee_type!="")
            {
                _html += '<span class="tag">'+ obj.fee_type +'</span>';
            }
            _html += '</div><span class="type"><i class="me-icon icon-flag"></i>'+status[obj.status]+'</span></div>';
            _html += '<p class="user-info"><a href="/user/'+ obj.leader_user.user_id +'"><img src="'+ obj.leader_user.avatar+'" alt="" class="userimg" /></a>';
            _html += '<a href="###" class="info_user" rel="info_user_'+obj.leader_user.user_id+'"><span class="username">'+ obj.leader_user.user_name +'</span></a><i class="me-icon icon-'+ gender[obj.leader_user.gender] +'"></i></p>';
            _html += '<div class="detail"><span class="me-icon icon-date"></span><span>'+obj.begin_date+'</span><span class="ci-last">'+ (obj.days>99? '99+':obj.days) +'天</span>';
            _html += '<p class="pct"><span class="me-icon icon-user"></span><span class="ci-last">'+obj.joined+'/'+ obj.limitation +'</span></p></div></a></li>';
        }
        return _html;
    }
    function createEventList(data){
        var _html = '';
        var status={};
        status['recruiting']='召集中';
        status['full']='已满员';
        status['expiration']='已截止';
        status['finish']='已结束';
        status['cancel']='已取消';
        status['close']='已删除';
        for(var i=0,len=data.length; i<len; i++){
            var obj = data[i];
            _html += '<li><a target="_blank" class="evshow" href="/event/yueban/detail/'+obj.node_id+'">'+'<img src="'+obj.image +'" alt="" /></a>';
            _html += '<div class="evinfo"><a target="_blank" href="/event/yueban/detail/'+obj.node_id+'"><h4 class="title">'+obj.title+'</h4></a>';
            var _dest = obj.to;
            var _destStr = '';
            for(var xx=0,xlen=_dest.length; xx<xlen; xx++){
                _destStr += '<span>'+_dest[xx].dest_name + '；</span>';
            }
            _html += '<p class="evdest"><i class="me-icon icon-dest"></i>'+ _destStr +'</p>';
            _html += '<p><span class="evtag '+ (status[obj.event_status] == '召集中' ? 'ing': '') +'">'+ status[obj.event_status] +'</span>';
            _html += '<span class="me-icon icon-date"></span><span>'+ obj.begin_date +'</span>&nbsp;';
            _html += '<span class="ci-last"><i class="daynum">'+ (obj.days>99? '99+':obj.days) +'</i>天</span>';
            _html += '<span class="me-icon icon-user"></span><span class="ci-last">'+ obj.member_num+'/'+ obj.member_limit +'</span></p>';
            _html += '<div class="evuser"><a target="_blank" class="user" href="/user/'+ obj.leader_user.internal_id +'"><img src="'+ obj.leader_user.avatar.replace('none.gif','none_header.gif') +'" alt="" /></a>';
            _html += ' <a href="###" class="info_user name" rel="info_user_'+obj.leader_user.internal_id+'">'+ obj.leader_user.user_name +'</a></div></li>'
        }
        return _html;
    }
    //ajax查询对象
    var filterObj = {};
    function setDefaultFilter(){//console.log($('#city_gp span a.default_city').attr('data-id'))
        filterObj = {
            date: 'null',
            key_word: 'null',
            page_num: 1,// 页码
            has_fd: 0, //好友是否参加 0不做好友过滤  1好友参加
            city_id: $('#city_gp span a.default_city').attr('data-id'),// 出发地城市id
            tag_id: 'null',// 类型
            search_type: 1,// //2:最新发布 1:即将出发
            page_limit: 30,
            fee_type: 'none' // 1AA  2免费
        };
    }
    setDefaultFilter();
    var $elList = $('#eventList'); //活动列表
    var $elLoading = $('#elLoading');
    var $elNone = $('#meNone');
    var $elPage = $('#elPage');
    
    function getEventListData(page, ifChangeFilter){
        if(typeof page == 'number'){
            filterObj.page_num = page;
        }
        $elList.html('');
        $elLoading.addClass('active');
        $elNone.removeClass('active');

        $.ajax({
            url: '/event/yueban/index_list',
            data: filterObj,
            dataType: 'json',
            success: function(_data){
                $elNone.removeClass('active'); 
                if(_data.status == 200){
                    var _html='';
                    var _result = _data.data;
                    if(_result.data.length>0){
                        $elNone.removeClass('active'); 
                        $elPage.show();
                        _html += createEventList(_result.data);
                        var totalCount = parseInt(_result.member_count);
                        if(totalCount>1980){
                            totalCount = 1980;
                        }
                        initPage($elPage, totalCount, filterObj.page_limit, function pageselectCallback(page_index) {
                            if($elPage.data('init')){
                                page_index++;
                                filterObj.page_num = page_index;//console.log(filterObj.page_num)
                                $elList.get(0).scrollIntoView();
                                createQuery(filterObj, true);
                            }
                            $elPage.data('init', true);
                            
                        }, 10, parseInt(filterObj.page_num)-1);
                    }else{
                        $elNone.addClass('active');
                        $elPage.hide();
                    }
                }else{
                    _html = '<p>数据加载失败,请稍后再试!</p>';
                    $elPage.hide();
                }

                $(_html).appendTo($elList).find('.evshow>img').imageFixedShow();
                $elLoading.removeClass('active');
                if(!$elList.data('init')){
                   $elList.data('init', true);
                }
            },
            error: function(data){
                var _html = '<p>数据加载失败,请稍后再试!</p>';
                $elPage.hide();

            }
        });
    }
    //读取url查询字符串初始化ajax查询对象
    function readUrl(){
        var queryArr = [];
        var queryStr = '';
        if(window.location.search != ''){
            queryStr = window.location.search;
        }else if(window.location.hash.indexOf('?') > -1){
            queryStr = window.location.hash.split('?')[1];
        }
        queryArr = queryStr.split('&');
        if(queryArr.length > 0){
           for(var i=0,len=queryArr.length; i<len; i++){
                var query = queryArr[i];
                if(query.indexOf('?')>-1){
                    query = query.substr(1);
                }
                var name = query.split('=')[0];
                var value = query.split('=')[1];//console.log(name)
                if(name in filterObj){
                    filterObj[name] = value;//console.log(name, value)
                }
            } 
        }else{
            setDefaultFilter();
        }
        //console.log(filterObj)
    }
    var History = window.History;
    // Bind to StateChange Event
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        if($elList.data('init')){//var State = History.getState(); // Note: We are using History.getState() instead of event.state
            //console.log('State!!!!!!!!!!!!!!!!!')
            //console.log(readUrl())
            clearTimeout($elList._timeoutId);
            $elList._timeoutId = setTimeout(function(){
                readUrl()
                drawFilter();
                getEventListData();
                //$('#evtKeyword').val('');
            }, 100);
        }
    });
    //url查询字符串生成
    function createQuery(obj){
        var _str = '?'
        for(var name in obj){
            if(name  != 'key_word'){
                _str += name + '=' + obj[name] + '&';
            }
        }
        //_str += 'time=' + (new Date()).getTime() + '&'; //处理关键字不变时
        _str = _str.substr(0, _str.length-1);
        //window.location.search = _str;
        History.pushState({state:1}, '活动约伴 - 磨房', _str);//console.log('History.pushState')
    }
    //根据url查询reset各选项
    function drawFilter(){
        var $feeType = $('#fee_gp');
        if(filterObj.fee_type != 'null' || filterObj.fee_type != ''){
            $feeType.find('a').removeClass('selected');
            $feeType.find('[data-id="'+ filterObj.fee_type +'"]').addClass('selected');
        }else{
            $feeType.find('a').removeClass('selected');
            $feeType.find('a').eq(0).addClass('selected');
        }
        var $city_gp = $('#city_gp');
        if(filterObj.city_id != 'null' || filterObj.city_id != ''){
            $city_gp.find('a').removeClass('selected');
            $city_gp.find('[data-id="'+ filterObj.city_id +'"]').addClass('selected');
        }else{
            $city_gp.find('a').removeClass('selected');
            $city_gp.find('a').eq(0).addClass('selected');
        }
        var $type = $('#type_gp');
        if(filterObj.tag_id != 'null' || filterObj.tag_id != ''){
            $type.find('a').removeClass('selected');
            $type.find('[data-id="'+ filterObj.tag_id +'"]').addClass('selected');
        }else{
            $type.find('a').removeClass('selected');
            $type.find('a').eq(0).addClass('selected');
        }
        var $search = $('.filter-tab');
        $('.filter-tab').removeClass('active');
        $('.filter-tab[data-value="'+ filterObj.search_type +'"]').addClass('active');

        if(filterObj.has_fd == '1'){
            $('#hasFd').addClass('checked');
        }else{
            $('#hasFd').removeClass('checked');
        }
        if(filterObj.key_word != 'null'){
            $('#evtKeyword').val(decodeURI(filterObj.key_word));
        }
        var $date = $('#date_gp');
        if(filterObj.date != 'null' && filterObj.date != '1' && filterObj.date != '2' && filterObj.date != '3'){
            $date.find('a').removeClass('selected');
            $('#departWdate').val(decodeURI(filterObj.date));
        }else{
            $('#departWdate').val('');
            $date.find('a').removeClass('selected');
            $date.find('[data-id="'+ filterObj.date +'"]').addClass('selected');
        }
    }
    //初始化
    readUrl();
    getEventListData();
    drawFilter();
    //最新发布，即将出发切换
    $('.filter-tab').click(function(e){
        e.preventDefault();
        var $this = $(this);
        if($this.hasClass('active')) return;
        $this.addClass('active');
        $this.siblings('.filter-tab').removeClass('active');
        filterObj.search_type = parseInt($this.attr('data-value'));
        filterObj.page_num='1';
        $elPage.data('init', false);
        //getEventListData(1, true);
        createQuery(filterObj);
    });
    //费用，城市，类型过滤
    $('.rs-fgp>.ct a').click(function(e){
        e.preventDefault();
        var $this = $(this);
        if($this.hasClass('selected')) return;
        filterObj.page_num='1';
        var $wrap = $this.parent();
        var $p = $this.closest('.ct');
        $this.addClass('selected');
        $wrap.siblings().find('a').removeClass('selected');
        var selectedValue = $this.attr('data-id');
        switch($p.attr('id')){
            case 'fee_gp':
                filterObj.fee_type = selectedValue;
                break;
            case 'city_gp':
                filterObj.city_id = selectedValue;
                break;
            case 'type_gp':
                filterObj.tag_id = selectedValue;
                break;
            case 'date_gp':
                filterObj.date = selectedValue;
                break;
        }
        $elPage.data('init', false);
        //getEventListData(1, true);
        createQuery(filterObj);
    });
    //好友参加
    $('#hasFd').click(function(){
        filterObj.page_num='1';
        if($(this).hasClass('checked')){
            filterObj.has_fd = 0;
        }else{
            filterObj.has_fd = '1';
        }
        $elPage.data('init', false);
        //getEventListData(1, true);
        createQuery(filterObj);
    });
    $('.me-checkbox').click(function(e){
        e.preventDefault();
        //$(this).toggleClass('checked');
    });
    //搜索
    $('#evtSearch').click(function(e){
        //e.preventDefault();
        filterObj.page_num='1';
        filterObj.key_word = $('#evtKeyword').val();
        $elPage.data('init', false);
        //createQuery(filterObj);
        getEventListData();
       
    });
    $('#evtKeyword').keyup(function(e){
        if(e.which == 13){
            filterObj.page_num='1';
            filterObj.key_word = $('#evtKeyword').val();
            $elPage.data('init', false);
            //createQuery(filterObj);
            getEventListData();
        }
    });
    //出发日期筛选
    var $departWdate=$dp.$('departWdate');
    $('#departWdate').focus(function(){
        WdatePicker({
            el: 'departWdate',
            skin: 'mfEvent',
            isShowClear: true,
            onpicked:function(_data){
                filterObj.page_num='1';
                filterObj.date = $('#departWdate').val();
                $('#date_gp>span>a').removeClass('selected');
                $elPage.data('init', false);
                createQuery(filterObj);
            }/*,
            minDate: '%y-%M-%d'*///'#F{$dp.$D(\'maxWdate\')}'
        });
    });
    //重置筛选
    $('#resetBtn').click(function(){
        setDefaultFilter();
        /*$elPage.data('init', false);
        getEventListData();
        $('#evtKeyword').val('');
        createQuery(filterObj);*/
        window.location.href = '/event/yueban';
    });
    //创建分页($holder, 总数，每页个数，切换页码回调)
    function initPage($el, totalNum, pageLimit, pageselectCallback, entries, currPage){
        $el.pagination(totalNum, {
            current_page: currPage,
            prev_text:" ",
            next_text:" ",
            num_edge_entries: 1, //边缘页数
            num_display_entries: entries?entries:6, //主体页数
            callback: pageselectCallback,
            link_to:"javascript:void(0);",
            items_per_page: pageLimit //每页显示1项
        });
    } 
});
$.fn.imageFixedShow = function(){
	var _error_img =MISC_PATH + 'images/event/v2/no_pic2.jpg';//ev_no_pic.jpg
	$(this).each(function(){
		var $this = $(this);
		var $ele = $this.parent();
		var holderW = $ele.width(),
			holderH = $ele.height();

		var _src = $this.attr('src');
		$('<img/>').on('load error', function(e){
			if(e.type == 'error'){
                $this.attr('src', _error_img).addClass('error');
            }else{
				var imgW = this.width,
					imgH = this.height,
					_marginTop = 0,
					_marginLeft = 0;

				imgH = parseInt(holderW * imgH / imgW);
				imgW = holderW;

				if(imgH < holderH){
					imgW = parseInt(holderH * imgW / imgH);
					imgH = holderH;
				}
				if(imgW > holderW){
					_marginLeft = (holderW - imgW)/2
				}
				if(imgH > holderH){
					_marginTop = (holderH - imgH)/2
				}
				$this.css({
					width: imgW,
					height: imgH,
					marginTop: _marginTop,
					marginLeft: _marginLeft
				})
			}
			$this.fadeIn();
		}).attr('src', _src);
	});
	return this;
}

