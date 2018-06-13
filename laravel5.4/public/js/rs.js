
$(function(){
	//页码生成
    var $page = $('#jPage');
    var totalPage = parseInt($page.attr('data-total'));
    if(totalPage>1){
    	xlznNav(1, totalPage, $page);
    }
	function xlznNav(currIndex, total, $holder){
	    var visibleNum = 10,
	        markIndex = currIndex,
	        prevArr = [],
	        nextArr = [],
	        prevnum = 0,
	        nextnum = 0,
	        moveNextnum = 0,
	        movePrevnum = 0;

	    for(prevnum; prevnum < 4; prevnum++){
	        var markIndex = currIndex - prevnum - 1;
	        if(markIndex > 0){
	            prevArr.unshift(markIndex);
	        }else{
	            break;
	        }
	    }
	    for(nextnum; nextnum < 4; nextnum++){
	        var markIndex = currIndex + nextnum + 1;
	        if(markIndex < total){
	            nextArr.push(markIndex);
	        }else{
	            break;
	        }
	    }
	    if(prevnum < 4){
	        moveNextnum = 4 - prevnum;
	        for(moveNextnum; moveNextnum > 0; moveNextnum--){
	            
	            var markIndex = currIndex + nextnum + 1;
	            if(markIndex < total){
	                nextArr.push(markIndex);
	            }else{
	                break;
	            }
	            nextnum++
	        }
	    }
	    if(nextnum < 4){
	        movePrevnum = 4 - nextnum;
	        for(movePrevnum; movePrevnum > 0; movePrevnum--){
	            
	            var markIndex = currIndex - prevnum - 1;
	            if(markIndex > 0){
	                prevArr.unshift(markIndex);
	            }else{
	                break;
	            }
	            prevnum++
	        }
	    }
	    $holder.html('');
	    $(prevArr).each(function(i, o){
	        $('<a>'+ o +'</a>').attr('data-href', o).appendTo($holder);
	    });
	    $('<a class="active">'+ currIndex +'</a>').attr('data-href', currIndex).appendTo($holder);
	    $(nextArr).each(function(i, o){
	        $('<a>'+ o +'</a>').attr('data-href', o).appendTo($holder);
	    });
	    var firstnum = parseInt($holder.children().eq(0).attr('data-href')),
	        lastnum = parseInt($holder.children().last().attr('data-href'));
	    if(firstnum > 1){
	        if(firstnum != 2) $('<span>...</span>').prependTo($holder);
	        $('<a>'+ 1 +'</a>').attr('data-href', 1).prependTo($holder);
	    }
	    if(lastnum < total){
	        if(lastnum != total-1) $('<span>...</span>').appendTo($holder);
	        $('<a>'+ total +'</a>').attr('data-href', total).appendTo($holder);
	    }

	    var $prev = $('<a href="" class="prev">前一页</a>'),//« Prev
	        $next = $('<a href="" class="next">后一页</a>');//Next »

	    if(currIndex == 1) $prev.addClass('disabled');
	    if(currIndex == total) $next.addClass('disabled');
	    $prev.prependTo($holder);
	    $next.appendTo($holder);
	}
	var filterObj = {
		city_slug: '',
		route_type_id: '',
		tag_id: '',
		page: 1
	}
	var $keyword = $('#rsKeyword');
	if($keyword){
		filterObj.keyword = $keyword.val();
	}
	$('[data-toggle]').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var $this = $(this);
		var $target = $($this.attr('data-toggle'));
		var _left = $this.get(0).offsetLeft;
		var _top = $this.get(0).offsetTop;
		$(this).toggleClass('active');
		if(_left>400){
			_left = 'auto';
			_right = '0';
		}else{
			_left = 0;
			_right = 'auto';
		}
		$target.css({
			left: _left,
			right: _right, 
			top: _top + 25
		}).toggleClass('active').parent().css('zIndex', 1000);
	});
    $(".rslides").responsiveSlides({
        auto: true, // Boolean: Animate automatically, true or false
        speed: 500, // Integer: Speed of the transition, in milliseconds
        timeout: 4000, // Integer: Time between slide transitions, in milliseconds
        pager: true, // Boolean: Show pager, true or false
        nav: true, // Boolean: Show navigation, true or false
        random: false, // Boolean: Randomize the order of the slides, true or false
        pause: false, // Boolean: Pause on hover, true or false
        pauseControls: true, // Boolean: Pause when hovering controls, true or false
        prevText: "Previous", // String: Text for the "previous" button
        nextText: "Next", // String: Text for the "next" button
        maxwidth: "", // Integer: Max-width of the slideshow, in pixels
        navContainer: "", // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "", // Selector: Declare custom pager navigation
        namespace: "rslides", // String: Change the default namespace used
        before: function() {}, // Function: Before callback
        after: function() {} // Function: After callback
    });
	$('body').click(function(){
		$('[data-toggle], .ct-modal').removeClass('active')
	});

	//城市tab
	$('.ct-tab a').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var $this = $(this);
		var $target = $($this.attr('href'));
		if($this.hasClass('active')) return;
		$this.addClass('active').siblings().removeClass('active');
		$target.addClass('active').siblings('.ct-tabct').removeClass('active');
	});
	//顶部地域类型标签筛选
	
	var hotCityArr = [];
	$('#city_gp .hotcity').each(function(i, o){
		var _value = $(o).attr('data-id');
		if(_value){
			hotCityArr.push(_value);
		}
	});
	//城市选择
	$('.tabct-gp a').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var _value = $this.attr('data-id');
		if(hotCityArr.indexOf(_value)>-1){
			var $target = $('[data-id="'+_value+'"]').eq(0);
			$target.closest('.ct').find('a').removeClass('selected');
			$target.addClass('selected');
			$('#openZoneModal').text('更多');
		}else{
			$('#city_gp a').removeClass('selected');
			var _txt = $this.text();
			$('#openZoneModal').text(_txt);
		}
		filterObj.city_slug = _value;
		filterObj.page = 1;
		updateCardData(filterObj);
	});
	$('.rs-fgp .ct a').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var $wrap = $this.closest('.ct');
		if($this.hasClass('btn-more') || $this.hasClass('selected')) return;

		$this.addClass('selected').parent().siblings().find('a').removeClass('selected');
		var _value = $this.attr('data-id');

		switch($wrap.attr('data-gp')){
			case 'city_gp':
				filterObj.city_slug = _value;
				$('#openZoneModal').text('更多');
				break;
			case 'type_gp':
				filterObj.route_type_id = _value;
				var $rel = $('[data-from="'+ _value +'"]');
				$rel.addClass('active').siblings().removeClass('active');
				$rel.find('a').removeClass('selected').eq(0).addClass('selected');
				filterObj.tag_id = '';
				break;
			case 'label_gp': 
				filterObj.tag_id = _value;
				break;
		}
		filterObj.page = 1;
		updateCardData(filterObj);
	});

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
	$('[data-score]').each(function(i, o){
		initStar($(o));
	});
	function createCard(obj){
		var _html = '<div class="rs-card"><a class="card-imgwrap" target="_blank" href="'+ obj.url +'"><img class="card-img" src="'+ obj.img +'" alt=""></a>';
		_html += '<div class="card-info"><span class="xlzn_type xlzn_type_'+ obj.typeid +'"></span>';
		_html += '<a target="_blank" class="card-link" href="'+ obj.url +'"><h3 class="card-title" title="'+ obj.title +'">'+ obj.title +'</h3></a>';
		if(obj.difficulty){
			_html += '<p class="lb-dift"><span>'+ obj.difficulty +'</span></p>';
		}
		var labelArr = obj.labelArr;
		if(labelArr.length>0){
			_html += '<p class="lb-tag">';
			for(var i=0,len=labelArr.length; i<len; i++){
				_html += '<span><a href="" data-key="'+ labelArr[i] +'">'+ labelArr[i] +'</a></span>';
			}
			_html += '</p>';
		}
		_html += '<a target="_blank" class="lb-cmt" href="'+ obj.url +'#routeCmtBox"><span>'+ obj.cmtCount +'</span></a>';
		_html += '<div class="score"><span class="route_star_sm"><i></i></span><span class="num" data-score="'+ obj.score +'"></span></div>';
		_html += '</div></div>';
		return _html;
	}
	function updateCardData(obj){
		$('.rs-card').remove();
		$('#rsNone, #rsInfo').hide();
		var $loading = $('#rsLoading').show();
		var postObj = {
			is_ajax: 1,
        	city_slug: '',
        	route_type_id: '',
        	tag_id: '',
        	keyword: '',
        	page_size: 20,
        	page: 1
		}
		for(var attr in obj){
			if(attr in postObj){
				postObj[attr] = obj[attr];
			}
		}
		$.ajax({
	        url: "/s/route",
	        dataType: 'json',
	        data: postObj,
	        type: 'POST',
	        success: function(data) {
	            if(data.error == 0){
	            	var cardData = data.result.route_list;
	            	if(cardData){
	            		var _page = data.result.page;
	            		totalPage = parseInt(data.result.page_count);
	            		var _html = '';
	            		for(var i=0,len=cardData.length; i<len; i++){
	            			var cardObj = cardData[i];
                            var cardHtmlObj = {
                                url: cardObj._route_url,
                                img: MISC_PATH + 'images/route/default_node_390_210.png',
                                typeid: cardObj.route_type_id,
                                title: cardObj.route_name,
                                difficulty: cardObj._difficulty_tag,
                                labelArr: [],
                                cmtCount: cardObj.route_reviews_cnt,
                                score: cardObj.route_star_level ? cardObj.route_star_level: 0
                            }
                            if(cardObj.img_list && cardObj.img_list.length>0){
                            	cardHtmlObj.img = cardObj.img_list[0].Path;
                            }
                            if(cardObj.tag_list){
                            	for(var y=0; y<cardObj.tag_list.length; y++){
	                            	cardHtmlObj.labelArr.push(cardObj.tag_list[y].tag_name);
	                            }
                            }

                            _html += createCard(cardHtmlObj);
	            		}
	            		$loading.hide();
	            		$('.rs-content').prepend($(_html));
	            		$('[data-score]').each(function(i, o){
							initStar($(o));
						});
						$('.card-img').imageFixedShow();
						$('#rsNum').text(data.result.route_count);
						$('#rsInfo').show();
						if(totalPage>1){
							xlznNav(_page, totalPage, $page);
							$page.show();
						}else{
							$page.hide();
						}
	            	}else{
	            		$('#rsNum').text('0');
	            		$loading.hide();
	            		$('#rsNone').show();
	            		$page.hide();
	            	}
	            }
	        }
	    });
	}


	/*$('.rs-btn').click(function(e){
		e.preventDefault();
		updateCardData();
	});*/
	//换页
	$('#jPage').delegate('a', 'click', function(e){
		e.preventDefault();
		var $this = $(this),
			$wrap = $('#jPage');
		if($this.hasClass('disabled') || $this.hasClass('active')) return;
		var oldIndex = parseInt($wrap.find('.active').eq(0).attr('data-href'));
		var idx;
		if($this.hasClass('prev')){
			idx = oldIndex-1;
		}else if($this.hasClass('next')){
			idx = oldIndex+1;
		}else{
			idx = parseInt($this.attr('data-href'));
		}
		$this.addClass('active').siblings().removeClass('active');
		filterObj.page = idx;
		updateCardData(filterObj);
	});
	//搜索点击
	$('#rsSearch').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var _value = $('#rsKeyword').val().replace(/(^\s+)|(\s+$)/g,"");
		if(_value == ''){
			alert('搜索内容不能为空！');
			return;
		}
		_value = encodeURIComponent(_value);
		if($this.hasClass('rs_blank')){
			window.open('/s/route?fr=nav&from=searchrt&keyword=' + _value, '_blank');
		}else{
			filterObj.keyword = _value;
			filterObj.page = 1;
			updateCardData(filterObj);
			//location.href = '/s/route?fr=nav&from=searchrt&keyword=' + _value;
		}
	});
	//回车搜索
	$('#rsKeyword').on('keyup',function(e){
		if(e.which == 13){
			var _value = $(this).val().replace(/(^\s+)|(\s+$)/g,"");
			if(_value == ''){
				alert('搜索内容不能为空！');
				return;
			}
			_value = encodeURIComponent(_value);
			if($(this).hasClass('rs_blank')){
				window.open('/s/route?fr=nav&from=searchrt&keyword=' + _value, '_blank');
			}else{
				filterObj.keyword = _value;
				filterObj.page = 1;
				updateCardData(filterObj);
				//location.href = '/s/route?fr=nav&from=searchrt&keyword=' + _value;
			}
			
		}
	});
	//标签搜索
	$('.rs-main').delegate('.lb-tag [data-key]', 'click', function(e){
		e.preventDefault();
		var _href = '/s/route?fr=nav&from=searchrt&keyword=' + $(this).attr('data-key');
		window.open(_href, '_blank');
	});
	
	$.fn.imageFixedShow = function(){
		var _default_img = MISC_PATH + 'images/route/default_node_390_210.png';
		$(this).each(function(){
			var $this = $(this);
			var $ele = $this.parent();
			var holderW = $ele.width(),
				holderH = $ele.height();

			var _src = $this.attr('src');
			$('<img/>').on('load error', function(e){
				if(e.type == 'error'){
                    $this.attr('src', _default_img);
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
	$('.card-img').imageFixedShow();

});