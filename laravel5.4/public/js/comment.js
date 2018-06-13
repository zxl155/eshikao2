//详情页点评
$(function(){
    if ($('.comment_box').size()) {
        (function() {
            //打分
            var node_id = $('#routeCmt').attr('data-nodeid'),
                _src_qd = $('#routeCmt').attr('data-srcqd'),
                totalNum = 0,
                curData = [],
                $preload = $('.route_cmt_preload'),
                $cmtInsert = $preload,
                $more = $('#routeCmtMore'),
                $moreWrap = $('#routeCmtMore').parent(),
                moreIdx = 3;

            $('.comment_box').delegate('.cmt_textarea', 'keyup change', function(){
                var $span = $(this).next().children(),
                    value = $(this).val().replace(/(^\s+)|(\s+$)/g,""),
                    max = $(this).attr('data-max'),
                    min = $(this).attr('data-min')
                if(!$span.length){
                    $span = $('[data-rangefor="#'+ this.id +'"]').children();
                }
                if(value.length < min){
                    $span.addClass('highlight');
                    $('[data-bind="#'+ this.id +'"]').addClass('w_btn_a_disable');
                }else{
                    $span.removeClass('highlight');
                    $('[data-bind="#'+ this.id +'"]').removeClass('w_btn_a_disable');
                    $('[data-tipfor="#'+ this.id +'"]').hide();
                }
                if(value.length > max){
                    value = value.substr(0, max);
                    $(this).val(value);
                }
                $span.text(value.length);
            });
            if ($.cookie('route_id') == node_id){
                
                var idx = parseInt($.cookie('route_score')),
                    cmt = $.cookie('route_comment');
                $('#routeVot').children().removeClass('vot');
                for (var i = 0; i < idx; i++) {
                    $('#routeVot').children().eq(i).addClass('vot');
                }
                $('#routeVot').find('.nums').text(idx);
                if(idx>0) $('#routeVot .score').show();
                $('#routeVot').attr('data-vot', idx);
                $('#routeCmtTxt').val(cmt).change();
            }

            $('#routeVot b').click(function() {
                var idx = $(this).index() + 1,
                    $parent = $(this).parent(),
                    $num = $parent.find('.nums'),
                    $score = $parent.find('.score');

                $score.next().hide();
                $parent.children().removeClass('vot');
                for (var i = 0; i < idx; i++) {
                    $parent.children().eq(i).addClass('vot');
                }
                $parent.attr('data-vot', idx);
                $num.text(idx);
                if (!$score.is(':visible')) $score.show();
            });
            //评论发布,编辑
            $('#routeCmt').click(function(e) {
                e.preventDefault();
                if($('#routeCmt').hasClass('w_btn_a_disable')) return;
                $('#routeCmt').addClass('w_btn_a_disable');
                var short_desc = $('#routeCmtTxt').val().replace(/(^\s+)|(\s+$)/g,""),
                    star_level = $('#routeVot').attr('data-vot'),
                    parent_id = 0,
                    comment_id = $(this).attr('data-id') ? $(this).attr('data-id') : undefined;

                if (photoUsername == '') {
                    $.cookie('route_comment', short_desc); 
                    $.cookie('route_score', star_level);
                    $.cookie('route_id', node_id);
                    location.href = '/user/login?url=' + location.pathname;
                    return;
                }
                if(star_level < 1 || short_desc.length < 20){
                    if(star_level < 1) $('#routeVot>p').show();
                    if(short_desc.length < 20) $('[data-tipfor="#routeCmtTxt"]').show();
                    return;
                }
                var aid;
                if($(this).attr('data-uid')){
                    aid = $(this).attr('data-uid');
                }
                
                var _url, _data = {};
                if(typeof comment_id == 'undefined'){
                     _url = location.protocol + "//" + location.host + '/api/reviews/add_comment';
                     _data = {
                        node_id: node_id,
                        short_desc: short_desc,
                        star_level: star_level,
                        parent_id: parent_id,
                        aid:aid,
                        src_qd: _src_qd
                     }                  
                }else{
                    _url = location.protocol + "//" + location.host + '/api/reviews/update_comment';
                    _data = {
                        short_desc: short_desc,
                        star_level: star_level,
                        comment_id: comment_id,
                        src_qd: _src_qd
                    };
                }
                $.ajax({
                    url: _url,
                    dataType: 'json',
                    data:  _data,
                    type: 'POST',
                    success: function(data) {
                        $('.lis_cons').remove();
                        getCommentData(null, 1, 10, true);
                        var $scoreHolder = $('.xlzn_score [data-score]'),
                            $scoreNum = $scoreHolder.find('span'),
                            totalScore = data.result.route_star_level ? data.result.route_star_level:0;
                        $scoreHolder.attr('data-score', totalScore);
                        initStar($scoreHolder);
                        //$scoreNum.text(data.result.route_star_level);
                    }
                });
                
            });
            
            //更多评论加载触发
            $more.click(function(e) {
                e.preventDefault();
                $preload.show();
                $moreWrap.hide();
                getCommentData(null, moreIdx, 5);
            });
            //加载评论数据
            function getCommentData(parent_id, page, page_size, ifFirst) {
                $.ajax({
                    url: location.protocol + "//" + location.host + '/api/reviews/load_comment',
                    dataType: 'json',
                    data: {
                        node_id: node_id,
                        parent_id: parent_id,
                        page: page,
                        page_size: page_size,
                        src_qd: _src_qd
                    },
                    type: 'POST',
                    success: function(data) {
                        var cmtData = data.result.reviews_data;
                        if (page_size == 20 || page == 1) {
                            $('.lis_cons_other').remove();
                        }
                        if (ifFirst) {
                            if(data.result.my_reviews){
                                data.total++;
                            }
                            totalNum = data.total;
                            $('[href="#routeCmtBox"]>span').text(totalNum);
                            if(totalNum == 0){
                                $('.route_cmt_none').show();
                                $('.lis_cons').remove();
                                $('.comment_cons').show();
                                $('.route_cmt_done').hide();
                                return;
                            }else{
                                $('.route_cmt_none').hide();
                            }
                            if(data.result.my_reviews){
                                $('.comment_cons').hide();
                                var myCmtData = data.result.my_reviews,
                                    star_level = myCmtData.star_level,
                                    short_desc = myCmtData.short_desc;

                                $('#routeVot b').eq(star_level-1).click();
                                $('#routeCmtTxt').val(short_desc).change();
                                $('#routeCmt').text('确定').removeClass('w_btn_a_disable').addClass('w_btn_a_sm').attr('data-id', myCmtData.id);
                                $(getCommentHtml(myCmtData, true)).insertBefore($cmtInsert).hide().fadeIn();
                                $('#routeCmtDelete').attr('data-id', myCmtData.id);
                                $('.route_cmt_done, #routeCmtCancel').show();
                            }else{
                                $('#routeCmt').text('发布').removeAttr('data-id');
                                $('.comment_cons').show();
                                $('.route_cmt_done, #routeCmtCancel').hide();
                                $('.lis_cons_own').remove();
                            }
                            if (totalNum > 10) {
                                $moreWrap.show();
                            }
                            if (totalNum > 20) {
                                var total = Math.ceil(totalNum / 20);
                                $('<ul id="routeCmtNav" class="xlzn_pagination"></ul>').insertAfter($moreWrap).hide();
                                xlznNav(1, total, $('#routeCmtNav'));
                                //评价分页点击
                                $('#routeCmtNav').delegate('a', 'click', function(e) {
                                    e.preventDefault();
                                    var $target = $(this);
                                    if ($target.hasClass('active') || $target.hasClass('disabled')) return;
                                    var currIndex = parseInt($target.siblings('.active').attr('data-href'));

                                    if ($target.hasClass('prev')) {
                                        currIndex--;
                                    } else if ($target.hasClass('next')) {
                                        currIndex++;
                                    } else {
                                        currIndex = parseInt($target.attr('data-href'));
                                    }
                                    getCommentData(null, currIndex, 20);
                                    var total = Math.ceil(totalNum / 20);
                                    if (total > 1) xlznNav(currIndex, total, $('#routeCmtNav'));
                                    $('.comment_box').eq(0).get(0).scrollIntoView();
                                });
                            }
                        }
                        if (page == 3 && page_size == 5 && totalNum > 15) {
                            $moreWrap.show();
                            moreIdx++;
                        }
                        if (page == 4 && page_size == 5) {
                            $('#routeCmtNav').show();
                        }
                        $preload.hide();
                        
                        for (var i = 0, len = cmtData.length; i < len; i++) {
                            $(getCommentHtml(cmtData[i])).insertBefore($cmtInsert).hide().fadeIn();
                        }
                        //$('.xlzn_time').get(0).scrollIntoView();
                    }
                });
            }
            getCommentData(null, 1, 10, true);
            function getCommentHtml(obj, ifEdit) {
                var _str,
                    extraClass = ifEdit ? 'lis_cons_own' : 'lis_cons_other',
                    extraHtml = ifEdit ? '<a id="routeCmtEdit" class="cmt_edit">编辑</a><a id="routeCmtDelete" class="cmt_delete">删除</a>' : '',
                    username = ifEdit ? obj.my_uname : obj.create_uname;
                
                _str += '<div class="lis_cons '+ extraClass +'" data-uid="'+ obj.create_uid +'"><div class="head_img"><a href="' + '/user/' + obj.create_uid + '"><img src="' + obj.head_url + '" alt="';
                _str +=  username + '" /></a></div><div class="send_body"><div class="tr_top"><p class="pp_name"><a href="' + '/user/' + obj.create_uid + '">' + username + '</a>';
                _str += extraHtml + '</p><div class="stars_chose_small">';
                for (var i = 0; i < 5; i++) {
                    if (i < obj.star_level) {
                        _str += '<b class="vot"></b>';
                    } else {
                        _str += '<b></b>';
                    }
                }
                if(obj.short_desc) obj.short_desc = obj.short_desc.replace(/\n/g, '<br/>');
                _str += '<strong class="nums">' + obj.star_level + '</strong>分</div></div>';
                _str += '<div class="txt_request"><p>' + obj.short_desc + '</p><div class="txt_end"><div class="times_end">发表于<span>'
                _str += obj.create_time + '</span></div><div class="operation"><p class="reply"><a data-uid="'+ obj.create_uid +'" data-parentid="' + obj.id + '" data-uname="' + username + '">回复<span>' + obj.huifu_count + '</span></a></p></div></div></div></div></div>';
                return _str;
            }
            //点击评论回复
            $('.comment_box').delegate('[data-parentid]', 'click', function(e) {
                e.preventDefault();
                var $this = $(this),
                    replyid = $this.attr('data-parentid'),
                    replynum = parseInt($this.find('span').text());

                if (!$this.data('ifAddReplyBox')) {
                    var $insert = $this.closest('.txt_request'),
                        _html = '<div class="reply_box"><div class="have_a_reply"></div><div class="reply_body"><textarea data-max="140" data-min="2" id="cmtReply'+ replyid +'" class="reply_input cmt_textarea" >回复@' + $this.attr('data-uname') + ' : </textarea></div>';
                    _html += '<div class="w_btn"><p data-rangefor="#cmtReply'+ replyid +'" class="reply_box_zi"><span>0</span>/140</p><a data-bind="#cmtReply'+ replyid +'" data-replyid="' + replyid + '" class="w_btn_a w_btn_a_disable">发布</a></div></div>';
                    $(_html).insertAfter($insert);
                    $this.data('ifAddReplyBox', true);
                }
                var $replybox = $('[data-replyid="' + replyid + '"]').closest('.reply_box');
                if ($replybox.is(':visible')) {
                    $replybox.hide();
                } else {
                    getReplyData(replyid, replynum);
                }
            });
            $('.comment_box').delegate('[data-replyid]', 'click', function(e) {
                e.preventDefault();
                if($(this).hasClass('w_btn_a_disable')) return;
                var $this = $(this),
                    short_desc = $this.closest('.reply_box').find('.reply_input').val(),
                    parent_id = $this.attr('data-replyid'),
                    replynum = parseInt($('[data-parentid="'+ parent_id +'"]').find('span').text()),
                    aid;

                if($this.attr('data-uid')){
                    aid = $this.attr('data-uid');
                }
                if (photoUsername == '') {
                    location.href = '/user/login?url=' + location.pathname;
                    return;
                }
                $.ajax({
                    url: location.protocol + "//" + location.host + '/api/reviews/add_comment',
                    dataType: 'json',
                    data: {
                        node_id: node_id,
                        short_desc: short_desc,
                        parent_id: parent_id,
                        aid: aid,
                        src_qd: _src_qd
                    },
                    type: 'POST',
                    success: function(data) {
                        replynum++;
                        getReplyData(parent_id, replynum);
                        $($this.attr('data-bind')).val('回复@'+$this.attr('data-uname')+' : ');
                    }
                });
            });
            //刷新回复列表
            function getReplyData(parent_id, page_size) {
                $.ajax({
                    url: location.protocol + "//" + location.host + '/api/reviews/load_comment',
                    dataType: 'json',
                    data: {
                        node_id: node_id,
                        parent_id: parent_id,
                        src_qd: _src_qd,
                        page_size: page_size
                    },
                    type: 'POST',
                    success: function(data) {
                        var cmtData = data.result.reviews_data,
                            $replybox = $('[data-replyid="' + parent_id + '"]').closest('.reply_box'),
                            $holder = $('[data-replyid="' + parent_id + '"]').closest('.reply_box').find('.have_a_reply');
                        $holder.html('');

                        for (var i = 0, len = cmtData.length; i < len; i++) {
                            var obj = cmtData[i];
                            var _html = '<div class="have_a_reply_lis" data-uid="'+ obj.create_uid +'"><p class="head_img"><a href="/user/' + obj.create_uid + '"><img src="' + obj.head_url + '" alt="' + obj.create_uname + '"/></a></p>';
                            _html += '<div class="have_a_reply_cons"><div class="txt_end"><div class="times_end"><a href="/user/' + obj.create_uid + '">' + obj.create_uname + '</a><span>' + obj.create_time + '</span></div>';
                            _html += '<div class="operation"><p class="reply"><a href="#" data-uid="'+ obj.create_uid +'" data-uname="' + obj.create_uname + '">回复</a></p></div></div>'
                            _html += '<div class="have_a_reply_body">' + obj.short_desc + '</div></div></div>';
                            $(_html).appendTo($holder);
                        }
                        if (len > 0) {
                            $holder.show();
                        }
                        $('[data-parentid="'+ parent_id +'"]>span').text(len);
                        $('#cmtReply'+parent_id).change();
                        $replybox.fadeIn();
                    }
                });
            }
            $('.comment_box').delegate('.reply>a', 'click', function(e){
                e.preventDefault();
                var $this = $(this),
                    $btn = $this.closest('.lis_cons').find('[data-replyid]'),
                    $txtarea = $this.closest('.lis_cons').find('.reply_input');

                $btn.attr('data-uid', $this.attr('data-uid'));
                $btn.attr('data-uname', $this.attr('data-uname'));
                $txtarea.val('回复@'+$this.attr('data-uname')+' : ').change();
            });
            //删除
            $('.comment_box').delegate('#routeCmtDelete', 'click', function(e){
                e.preventDefault();
                var _comment_id = $(this).attr('data-id'),
                    $scoreHolder = $('.xlzn_score [data-score]'),
                    $scoreNum = $scoreHolder.find('span');
                if(typeof xlznAlert == 'function'){
                    xlznAlert('您确定要删除这条评论吗？', function(){
                        $.ajax({
                            url: location.protocol + "//" + location.host + '/api/reviews/del_comment',
                            dataType: 'json',
                            data: {
                                comment_id: _comment_id,
                                src_qd: _src_qd
                            },
                            type: 'POST',
                            success: function(data) {
                                getCommentData(null, 1, 10, true);
                                var totalScore = data.result.route_star_level ? data.result.route_star_level:0;
                                $scoreHolder.attr('data-score', totalScore);
                                initStar($scoreHolder);
                                //$scoreNum.text(data.result.route_star_level);
                                $('#routeCmt').text('发布').show();
                                $('#routeCmtCancel').hide();
                                $('#routeCmtTxt').val('');
                            }
                        });
                    });
                }else if(confirm('您确定要删除这条评论吗？')){
                    $.ajax({
                        url: location.protocol + "//" + location.host + '/api/reviews/del_comment',
                        dataType: 'json',
                        data: {
                            comment_id: _comment_id,
                            src_qd: _src_qd
                        },
                        type: 'POST',
                        success: function(data) {
                             getCommentData(null, 1, 10, true);
                             var totalScore = data.result.route_star_level ? data.result.route_star_level:0;
                                $scoreHolder.attr('data-score', totalScore);
                            initStar($scoreHolder);
                            //$scoreNum.text(data.result.route_star_level);
                            $('#routeCmt').text('发布').show();
                            $('#routeCmtCancel').hide();
                            $('#routeCmtTxt').val('');
                        }
                    });
                }
            });
            //编辑
            $('.comment_box').delegate('#routeCmtEdit', 'click', function(e){
                e.preventDefault();
                $('.lis_cons_own').hide();
                $('.comment_cons').fadeIn();
            });
            //取消编辑
            $('#routeCmtCancel').click(function(e){
                e.preventDefault();
                $('.comment_cons').hide();
                $('.lis_cons_own').show();
            });
        })();
    }
})