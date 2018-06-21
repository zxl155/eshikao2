/*线路详情1*/
var xlznFormData = {};
$(function(){
	var xlznTypeArr = ['山野穿越','健行','骑行', '跑步', '自驾', '露营', '溯溪', '滑雪', '攀岩', '漂流', '温泉'];
	if (!window.location.origin) {
	  	window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
	}	
	function dragSlide(ele){
		var $slidemove = $(ele),
			ifmove = false,
			index = 0,
			dir,
			startX,
			endX,
			moveX,
			beginX,
			moveDistance = -1;

		$slidemove.on('mousedown', function(e){
			startX = e.screenX;
			ifmove = true;
			return false;
		});
		$('.xlzn_form_slide').on('mousemove', function(e){
			if(ifmove){
				endX = e.screenX;
				moveX = endX - startX;
				if(moveX > 0){
					dir = 'right';
				}else{
					dir = 'left';
				}
				beginX = parseInt($slidemove.css('left'));
				moveDistance =beginX + moveX;
				if(moveDistance > 400){
					moveDistance = 400;
				}
				if(moveDistance < 0){
					moveDistance = 0;
				}
				$slidemove.css('left', moveDistance);
				index = parseInt(moveDistance/50) + 1;
				startX = endX;
			}
			return false;
		});
		$('.xlzn_form_slide li').on('click', function(){
			var index = $(this).index() + 1;
			$slidemove.css('left', index * 50);
			$slidemove.prev().children().each(function(i ,o){
				if(i < index){
					$(o).addClass('active');
				}else{
					$(o).removeClass('active');
				}
			});
			$('.xlzn_form_slide input[type="hidden"]').val($(this).text());
		});
		$(document).on('mouseup', function(e){
			if(ifmove){
				ifmove = false;
				if(moveDistance > -1){
					$slidemove.prev().children().each(function(i ,o){
						if(i < index){
							$(o).addClass('active');
						}else{
							$(o).removeClass('active');
						}
					});
					
					$('.xlzn_form_slide input[type="hidden"]').val($('.xlzn_form_slide li').eq(index-1).text());
				}
			}
		});
	}
	/*dragSlide('#xlzn_slidebtn');
	$('.xlzn_slidebtn').on('click', function(e){
		e.preventDefault();
	});*/
	$('.xlzn_form_slide li').click(function(){
		$(this).siblings().removeClass('active');
		$(this).toggleClass('active');
		var txt = '';
		if($(this).hasClass('active')){
			txt = $(this).text();
		}
		$('.xlzn_form_slide input[type="hidden"]').val(txt);
	});
	$('.xlzn_modal_close').click(function(e){
		e.preventDefault();
		if($('#xlznIndexPhotoModal').size() > 0 && $('#xlznIndexPhotoModal').data('ifUploading')){
			xlznAlert('上传过程中不要离开哦');
			return;
		}
		$(this).parent().hide();
		if($('#xlznIndexPhotoModal').size() > 0 && $(this).parent().hasClass('xlzn_gallery_modal')){
			$('.xlzn_modal_cover').css('zIndex', 1000);
			return;
		}
		$('.xlzn_modal_cover').hide();
	});

	$('.xlzn_form_control').delegate('.xlzn_form_select a', 'click', function(e){
		e.preventDefault();
		var $this = $(this),
			$input = $this.children();

		if($input.is('[type="radio"]')){
			$this.parent().siblings().children().removeClass('active');
			$this.parent().siblings().children().children().attr('checked', false);
			if($this.hasClass('toggle')){
				$this.toggleClass('active');
				if($this.hasClass('active')) {
					$input.attr('checked', true);
				}else{
					$input.attr('checked', false);
				}
			}else{
				$this.addClass('active');
				$input.attr('checked', true);
				$('[data-tipfor="'+ $input.attr('name') +'"]').hide();
			}
		}else{
			$this.toggleClass('active');
			if($this.hasClass('active')){
				$input.attr('checked', true);
			}else{
				$input.attr('checked', false);
			}
			$this.parent().siblings().find('[type="radio"]').parent().removeClass('active');
		}
	});
	$('.xlzn_input input').focus(function(){
		var value = $(this).val();
		if(value == '10个字以内' || value == '30个字以内' || value == '最多添加3个，标签之间用逗号隔开'){
			$(this).removeClass('disabled').val('');
		}
		$(this).parent().addClass('focus');
	});
	/*$('.xlzn_input input[data-max]').keyup(function(){
		var max = $(this).attr('data-max');
		if($(this).val().length > max){
			$('[data-tipfor="'+$(this).attr('name')+'"]').show();
		}else{
			$('[data-tipfor="'+$(this).attr('name')+'"]').hide();
		}
	});*/
	$('.xlzn_form_textarea').focus(function(){
		if($(this).val() == '详细的介绍下该条线路的一些相关信息...'){
			$(this).val('');
			$(this).addClass('active');
		}
	});
	$(document).delegate('.xlzn_form_textarea', 'keyup change', function(){
		var $span = $(this).next().children(),
			value = $(this).val(),
			max = $(this).attr('data-max'),
			min = $(this).attr('data-min')
		if(!$span.length){
			$span = $('[data-rangefor="#'+ this.id +'"]').children();
		}
		if(value.length < min){
			$span.addClass('highlight');
		}else{
			$span.removeClass('highlight');
			$('[data-tipfor="#'+ this.id +'"]').hide();
		}
		if(value.length > max){
			value = value.substr(0, max);
			$(this).val(value);
		}
		$span.text(value.length);
	});
	
	$('.xlzn_input input[data-max]').on('keyup change', function(e){
		var max = $(this).attr('data-max'),
			value = $(this).val(),
			min = $(this).attr('data-min'),
			$tip = $(this).parent().next(),
			$num = $tip.find('i');

		if(value.length < min){
			$num.addClass('highlight');
		}else{
			$num.removeClass('highlight');
		}	
		if(value.length >　max){
			$(this).val(value.substr(0, max))
		}
		$num.text(value.length);

	}).on('focus', function(){
		$(this).parent().next().show();
	}).on('blur', function(){
		$(this).parent().next().hide();
	});

	$('.xlzn_input input').blur(function(){
		$(this).parent().removeClass('focus');
	});
	//分享
    $('.xlzn_share').hover(function() {
        $("#xlznSocialModal").show();
    }, function() {
        $("#xlznSocialModal").hide();
    });
    
     
	//发送到微信
	if(window.route_info && 'qr_code_url' in route_info && route_info['qr_code_url'] !== null){
		sendToWeixin('.xlzn_weixin', route_info['qr_code_url'])
	}
	function sendToWeixin(elem, src){
		$(elem).show();
		var img = new Image();
		img.src = src;
		$(img).appendTo($(elem).find('.pic'));
		$(elem).hover(function(){
			$('.send_weixin').fadeIn();
		},function(){
			$('.send_weixin').fadeOut();
		});
	}
	
	
	$('.xlzn_cbox_tab a[data-target]').click(function(e){
		e.preventDefault();
		var $target = $($(this).attr('data-target')),
			$nav = $(this).parent();

		$target.siblings().removeClass('active');
		$nav.siblings().removeClass('active');
		$target.addClass('active');
		$nav.addClass('active');
	});
	$('.xlzn_attr_more').hover(function(){
		$(this).find('.xlzn_attr_popup').show();
	},function(){
		$(this).find('.xlzn_attr_popup').hide();
	});
	//想去,去过交互
	$('.xlzn_cmt_favor>a, .xlzn_cmt_gone>a').click(function(e){
		e.preventDefault();
		var $span = $(this).next().find('span'),
			num = parseInt($span.text()),
			$plus = $(this).next().next();

		$plus.show().animate({
			bottom: '40px',
			fontSize: '16px'
		},function(){
			$(this).hide().css({
				bottom: '5px',
				fontSize: '12px'
			});
		});
		$span.text(++num);

		var node_id = $(this).closest('.xlzn_cmt').attr('data-nodeid');
		if($(e.target).parent().hasClass('xlzn_cmt_gone')){
            $.get('/api/place/addVisited/',{node_id:node_id},function(data){
                //console.log(data);
            },'json');
		}
		if($(e.target).parent().hasClass('xlzn_cmt_favor')){
			$.get('/api/place/addWish/',{node_id:node_id},function(data){
                //console.log(data);
			},'json');
		}

	});
	$('.xlzn_cmt>div').hover(function(){
		$(this).find('p').show();
	},function(){
		$(this).find('p').hide();
	});
	
	$('#xlznMapModal .xlzn_modal_footer>.xlzn_modal_btn').click(function(e){
		e.preventDefault();
		$('#xlznMapModal, .xlzn_modal_cover').hide();
	});
	$('#xlznOpenMap').click(function(e){
		e.preventDefault();
		if(!$('#xlznMapModalCenter').data('ifLoad')){
			modalMap = new xlznMap();
		    if(window.route_info){
		    	modalMap.relativeMap = window.roadMap ? roadMap : null;
		    	modalMap.init('xlznMapModalCenter',{lng:route_info.offset_lngi,lat:route_info.offset_lati});
		    }else{
		    	modalMap.init('xlznMapModalCenter');
		    }
		    modalMap.bindKeydown('keyword');
		    modalMap.addMenu(false);
		    $('#xlznMapModalCenter').data('ifLoad', true);
		}
		var _h = $(window).height() - 80;
		if(_h < 650){
			$('#xlznMapModalCenter').height(490-(650-_h)-10);
			$('#xlznMapModal').height(590-(650-_h)-10)
		}else{
			$('#xlznMapModalCenter').innerHeight(490);
			$('#xlznMapModal').innerHeight(650);
		}
		$('#xlznMapModal').css('marginTop', -1*$('#xlznMapModal').innerHeight()/2);
		$('#xlznMapModal, .xlzn_modal_cover').show();
	});

	//基本信息验证
	function xlznCreateBasicValidate(ifDisableRouteName){
		var type = $('[name="route_type_id"]:checked').val() || ($('[name="route_type_id"]').attr('type') == 'hidden' ? $('[name="route_type_id"]').val(): ''),
			title = $('[name="route_name"]').val(),
			desc = $('[name="route_desc"]').val(),
			location = $('[name="dest_node_name"]').val(),
			lng = $('[name="lngi"]').val(),
			lat = $('[name="lati"]').val(),
			returnData = true,
			checkRegx = new RegExp("([\u4E00-\u9FA5]+，?)+",'g'),
			checkRegx2 = new RegExp("[^\a-\z\A-\Z0-9\u4E00-\u9FA5\_\-]", 'g');

		if(!type){
			$('[data-tipfor="route_type_id"]').show();
			returnData = false;
		}else{
			$('[data-tipfor="route_type_id"]').hide();
		}
		var titleMatch = title.match(checkRegx);
		if(title == ''){
			$('[data-tipfor="route_name"]').text('字数必须在4~30').show();
			returnData = false;
		}else if(checkRegx2.test(title)){
			$('[data-tipfor="route_name"]').text('只允许中英文,数字,中划线-,下划线_').show();
			returnData = false;
		}else if(!titleMatch){
			$('[data-tipfor="route_name"]').text('至少包含2个中文字').show();
			returnData = false;
		}else if(titleMatch.length == 1 && titleMatch[0].length < 2){
			$('[data-tipfor="route_name"]').text('至少包含2个中文字').show();
			returnData = false;
		}else if(title.length < 4 || title.length > 30){
			$('[data-tipfor="route_name"]').text('字数必须在4~30').show();
			returnData = false;
		}else{
			if(ifDisableRouteName){
				$('[data-tipfor="route_name"]').hide();
			}else{
				if(!$('#xlznIndexModal').length && window.route_info && title == route_info.route_name){//驳回页
					$('[data-tipfor="route_name"]').hide();
				}else{
					$.ajax({
		                type: "post",
		                url: window.location.protocol + "//" + window.location.host + "/route/route_exists",
		                data: {route_name:title},
		                dataType: 'json',
		                async: false,
		                success: function(data) {
		                    if(data.result.exist == '1'){
		                    	$('[data-tipfor="route_name"]').text('名称重复，该线路已被创建。').show();
		                    	returnData = false;
		                    }else{
		                    	$('[data-tipfor="route_name"]').hide();
		                    }
		                }
		            });
				}
			}
		}

		if(desc.length < 20 || desc.length > 300){
			$('[data-tipfor="route_desc"]').text('字数必须在20~300').show();
			returnData = false;
		}else{
			$('[data-tipfor="route_desc"]').hide();
		}
		if(lng == ''){
			$('[data-tipfor="lngi"]').text('请标置坐标').show();
			returnData = false;
		}else{
			$('[data-tipfor="lngi"]').text('请标置坐标').hide();
		}
		if(location.length < 2 || location.length > 15){
			$('[data-tipfor="dest_node_name"]').text('字数必须在2-15').show();
			returnData = false;
		}else if(checkRegx2.test(location)){
			$('[data-tipfor="dest_node_name"]').text('只允许中英文,数字,中划线-,下划线_').show();
			returnData = false;
		}else{
			$('[data-tipfor="dest_node_name"]').hide();
		}
		if(returnData){
			return {
				route_type_id: type,
				route_name: title,
				route_desc: desc,
				dest_node_name: location,
				lngi:lng,
				lati:lat,
				is_ajax: 1
			}
		}else{
			return false;
		}
		
	}
	(function(){

		function validate(name, value){
			var checkRegx = new RegExp("([\u4E00-\u9FA5]+，?)+",'g'),
				checkRegx2 = new RegExp("[^\a-\z\A-\Z0-9\u4E00-\u9FA5\_\-]", 'g');
			switch(name){
				case 'route_name':
					var title = value,
						titleMatch = title.match(checkRegx);

					if(title == ''){
						$('[data-tipfor="route_name"]').text('字数必须在4~30').show();
					}else if(checkRegx2.test(title)){
						$('[data-tipfor="route_name"]').text('只允许中英文,数字,中划线-,下划线_').show();
					}else if(!titleMatch){
						$('[data-tipfor="route_name"]').text('至少包含2个中文字').show();
					}else if(titleMatch.length == 1 && titleMatch[0].length < 2){
						$('[data-tipfor="route_name"]').text('至少包含2个中文字').show();
					}else if(title.length < 4 || title.length > 30){
						$('[data-tipfor="route_name"]').text('字数必须在4~30').show();
					}else{
						if(!$('#xlznIndexModal').length && window.route_info && title == route_info.route_name){//驳回页
							$('[data-tipfor="route_name"]').hide();
						}else{

							$.ajax({
			                    type: "post",
			                    url: window.location.protocol + "//" + window.location.host + "/route/route_exists",
			                    data: {route_name:title},
			                    dataType: 'json',
			                    async: false,
			                    success: function(data) {
			                        if(data.result.exist == '1'){
			                        	$('[data-tipfor="route_name"]').text('名称重复，该线路已被创建。').show();
			                        }else{
			                        	$('[data-tipfor="route_name"]').hide();
			                        }
			                    }
			                });
						}
					}
					break;
				case 'route_desc':
					var desc = value;
					if(desc.length < 20 || desc.length > 300){
						$('[data-tipfor="route_desc"]').text('字数必须在20~300').show();
					}else{
						$('[data-tipfor="route_desc"]').hide();
					}
					break;
				case 'dest_node_name':
					var location = value;
					if(location.length < 2 || location.length > 15){
						$('[data-tipfor="dest_node_name"]').text('字数必须在2-15').show();
					}else if(checkRegx2.test(location)){
						$('[data-tipfor="dest_node_name"]').text('只允许中英文,数字,中划线-,下划线_').show();
					}else{
						$('[data-tipfor="dest_node_name"]').hide();
					}
					break;
			}
		}
		$('[name="route_name"],[name="route_desc"],[name="dest_node_name"]').blur(function(){
				var name = $(this).attr('name'),
					value = $(this).val();
				validate(name, value);
		}).keyup(function(){
			var name = $(this).attr('name'),
				value = $(this).val();
			if($('[data-tipfor='+ name +']').is(':visible')){
				validate(name, value);
			}
		});
	})();
	

	//线路详情验证
	function xlznCreateDetailValidate(){
		var season_ids = [],
			season_desc = $('[name="season_desc"]').val() == '30个字以内' ? '' : $('[name="season_desc"]').val(),
			tag_ids = $('[name="tag_ids"]').val(),
			tag_custom = $('[name="tag_custom"]').val() == '最多添加3个，标签之间用逗号隔开' ? '' : $('[name="tag_custom"]').val(),
			travel_time = $('[name="travel_time"]').val(),
			travel_time2 = $('[name="travel_time2"]').val() == '' ? '' : $('[name="travel_time2"]').val(),
			difficulty_level = $('[name="difficulty_level"]:checked').val(),
			traffic_info = $('[name="traffic_info"]').val(),
			road_state_ids = $('[name="road_state_ids"]').val(),
			road_state_desc = $('[name="road_state_desc"]').val(),
			campsite_ids = [],
			campsite_count = $('[name="campsite_count"]:checked').val(),
			travel_line = $('[name="travel_line"]').val(),
			prompt_notice = $('[name="prompt_notice"]').val(),
			returnData = true;

		$('.xlzn_input input[data-max]').each(function(i, o){
			var max = $(o).attr('data-max');
			if($(o).val() != '最多添加3个，标签之间用逗号隔开' && $(o).val().length > max){
				var $target = $('[data-tipfor="'+$(o).attr('name')+'"]');
				$target.show();
				$target.closest('.xlzn_form_control').get(0).scrollIntoView();
				returnData = false;
				return false;
			}
		});	
		if(travel_time2 && travel_time2 !='' && !/^[1-9]\d{0,2}$/.test(parseInt(travel_time2))){
			var $target = $('[data-tipfor="travel_time2"]');
			$target.show();
			$target.closest('.xlzn_form_control').get(0).scrollIntoView();
			returnData = false;
		}else{
			$('[data-tipfor="travel_time2"]').hide();
		}
		if(!returnData){
			return false;
		}
		$('[name="season_ids"]:checked').each(function(i ,o){
			season_ids.push($(o).val());
		});
		season_ids = season_ids.join(',');
		/*$('[name="tag_ids"]:checked').each(function(i ,o){
			tag_ids.push($(o).val());
		});
		tag_ids = tag_ids.join(',');
		$('[name="road_state_ids"]:checked').each(function(i ,o){
			road_state_ids.push($(o).val());
		});
		road_state_ids = road_state_ids.join(',');*/
		$('[name="campsite_ids"]:checked').each(function(i ,o){
			campsite_ids.push($(o).val());
		});
		campsite_ids = campsite_ids.join(',');
		return {
			season_ids: season_ids,
			season_desc: season_desc,
			tag_ids: tag_ids,
			tag_custom: tag_custom,
			travel_time: travel_time,
			difficulty_level: difficulty_level,
			traffic_info: traffic_info,
			road_state_ids:　road_state_ids,
			road_state_desc: road_state_desc,
			campsite_ids: campsite_ids,
			campsite_count: campsite_count,
			travel_line: travel_line,
			prompt_notice: prompt_notice
		}
	}
	function displayXlznType(id){
		switch(id){
			case '1':
			case '7':
				$('.xlzn_form_control[data-type="7"]').remove();
				break;
			case '2':
			case '3':
			case '4':
			case '5':
				$('.xlzn_form_control[data-type="8"]').remove();
				$('.xlzn_form_control[data-type="9"]').remove();
				$('.xlzn_form_control[data-type="10"]').remove();
				break;
			case '6':
				$('.xlzn_form_control[data-type="5"]').remove();
				$('.xlzn_form_control[data-type="6"]').remove();
				$('.xlzn_form_control[data-type="7"]').remove();
				$('.xlzn_form_control[data-type="10"]').remove();
				break;
			case '8':
			case '9':
			case '10':
			case '11':
				$('.xlzn_form_control[data-type="5"]').remove();
				$('.xlzn_form_control[data-type="6"]').remove();
				$('.xlzn_form_control[data-type="7"]').remove();
				$('.xlzn_form_control[data-type="8"]').remove();
				$('.xlzn_form_control[data-type="9"]').remove();
				$('.xlzn_form_control[data-type="10"]').remove();
				break;
			default:
				$('.xlzn_form_control[data-type="5"]').remove();
				$('.xlzn_form_control[data-type="6"]').remove();
				$('.xlzn_form_control[data-type="7"]').remove();
				$('.xlzn_form_control[data-type="8"]').remove();
				$('.xlzn_form_control[data-type="9"]').remove();
				$('.xlzn_form_control[data-type="10"]').remove();
				break;
		}
	}
	//创建线路成功弹框
	function xlznCreateBasicSuccess(data){
		$('#xlznBasicSuccess, .xlzn_modal_cover').show();
		var $num = $('#xlznBasicSuccess .xlzn_modal_tip>span');
		$('#xlznTitle').text(data.route_name);
		displayXlznType(data.route_type_id);
		getLabel(data.route_type_id);
		$('.xlzn_cbox_tab .disabled').removeClass('disabled');
		$('[href="#xlznMapContent"]').click();
		$('#xlznMainEditBox').get(0).scrollIntoView();
		var type = $('[name="route_type_id"]:checked').parent().text();
		$('[for="route_type"]').next().hide();
		$('<p></p>').text(type).insertAfter($('[for="route_type"]'));
		$('[for="route_name"]').next().hide();
		$('<p></p>').text(data.route_name).insertAfter($('[for="route_name"]'));

		$('#xlznCreateBasicBtn').remove();
		$('#xlznCreateEditBtn').show();
		$('#xlznBasicSuccess .xlzn_modal_btn').click(function(e){
			e.preventDefault();
			$('#xlznBasicSuccess, .xlzn_modal_cover').hide();
		});
		xlznIntervalID = setInterval(function(){
			var _num = $num.text();
			if(_num == 1){
				$('#xlznBasicSuccess, .xlzn_modal_cover').hide();
				clearInterval(xlznIntervalID);
			}else{
				$num.text(_num - 1);
			}
		},1000);
		
		
		function getLabel(typeId){
			var $holder = $('[data-type="2"] .xlzn_type_autolist'),
				arr = [];

			$(tagMetaArr).each(function(i, arr){
				if(arr[1] == typeId){
					$('<a>'+ arr[2] +'</a>').attr('data-idx', arr[0]).prependTo($holder);
					arr.push(arr[2]);
				}
			});
			$('[name="tag_ids"]').next().val(arr.join(','));
		}
	}
	//创建线路
	$('#xlznCreateBasicBtn').click(function(e){
		e.preventDefault();
		var formData = xlznCreateBasicValidate();
		if(formData){
			$.ajax({
				url: location.protocol + "//" + location.host + '/route/add_base',
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data){
					xlznCreateBasicSuccess(formData);
					xlznData = data.result;
					roadMap = new xlznMap();
	                roadMap.init('xlznMap',{'lng': formData.lngi,'lat': formData.lati}, formData.route_type_id, formData.route_name);
	                roadMap.addMenu(true);
	                if(window.modalMap){
	                	modalMap.relativeMap = roadMap.getMap();
	                }
	                //roadMap = roadMap.getMap();
				}
			});
		}
	});
	//编辑线路
	$('#xlznCreateEditBtn').click(function(e){
		e.preventDefault();
		
		if(!$('#xlznIndexModal').length && window.route_info){//驳回页
			var basicData = xlznCreateBasicValidate();
		}else{
			var basicData = xlznCreateBasicValidate(true);
		}
		//基本信息
		if(!basicData){
			if(!$('#xlznBasicContent').hasClass('active')){
				$('#xlznBasicContent').siblings('.xlzn_cbox_content').removeClass('active');
				$('#xlznBasicContent').addClass('active');
				$('[href="#xlznBasicContent"]').parent().siblings().removeClass('active');
				$('[href="#xlznBasicContent"]').parent().addClass('active');
			}
			return;
		}
		//线路详情
		var	detailData = xlznCreateDetailValidate();
		if(!detailData){
			if(!$('#xlznDetailContent').hasClass('active')){
				$('#xlznDetailContent').siblings('.xlzn_cbox_content').removeClass('active');
				$('#xlznDetailContent').addClass('active');
				$('[href="#xlznDetailContent"]').parent().siblings().removeClass('active');
				$('[href="#xlznDetailContent"]').parent().addClass('active');
			}
			return;
		}
		//照片
		var photoData = {
			photo_ids:'',
			site_photo_ids:''
		}
		var localArr = [],
			setArr = [];
		$('#xlznPhotoContent .xgl_list>li').each(function(i, obj){
			if($(obj).attr('data-group') == 'site_photo_ids'){
				setArr.push($(obj).attr('imgId'));
			}else{
				localArr.push($(obj).attr('imgId'));
			}
		});
		photoData.photo_ids = localArr.join(',');
		photoData.site_photo_ids = setArr.join(',');

		//轨迹路书
		var roadData = {
			road_point:[]
		};
		$('.xlzn_marker_wrapnew').each(function(i, obj){
			var roadObj = {
				coor_type: 'gcj02'
			};
			var	$target = $(obj);

			if($target.attr('data-type')){
				roadObj.flag_type = $target.attr('data-type');
				roadObj.lngi = $target.attr('data-lng');
				roadObj.lati = $target.attr('data-lat');
				roadObj.flag_txt = $target.find('.xlzn_mk_tip').text();
				roadData.road_point.push(roadObj);
			}
			
		});	
		if(!window.xlznRoadData){
			xlznRoadData = {};
		}
		roadData.coord_type = $('#mapCoordSelect').attr('data-coord');
		if(!$('#xlznIndexModal').length && window.route_info){
			if(!window.xlznData){
				xlznData = {
					route_base_id: route_info.route_base_id,
					route_attr_ver_id: route_info.route_attr_id
				}
			}
			xlznData.dest_node_id = route_info.parent_node_id;
			if(route_info.map_line_id){
				xlznData.map_line_id = route_info.map_line_id;
			}
		}
		xlznFormData = $.extend({}, xlznData, basicData, detailData, photoData, roadData, xlznRoadData);
		$('#xlznEditModal, .xlzn_modal_cover').show();
	});
	//编辑后确定提交
	$('#xlznEditModalSure').click(function(e){
		e.preventDefault();
		$.ajax({
			url: location.protocol + "//" + location.host + '/route/add_all',
			dataType: 'json',
			data: xlznFormData,
			type: 'POST',
			success: function(data){
				if(data.msgs == 'success'){
					xlznData = data.result;
					$('.xlzn_modal_cover').css('zIndex', 1000);
					$('#xlznEditModal,.xlzn_modal_cover').hide();
					var _return_url = $.cookie('addroute_return_url'); 
					if(_return_url){
						location.href = _return_url;
					}else{
						window.close();
					}

				}else{
					xlznAlert(data.msgs)
				}
			}
		});
	});
	//编辑后取消
	$('#xlznEditModalCancel').click(function(e){
		e.preventDefault();
		$('#xlznEditModal').hide();
		if(!$('#xlznIndexModal').size()){
			$('.xlzn_modal_cover').hide();
		}
		$('.xlzn_modal_cover').css('zIndex', 1000);
	});
	//顶部tab切换
	$('.xlzn_cbox_tab a').click(function(e){
		if($(this).attr('href') != '#routeCmtBox'){
			e.preventDefault();
		}else{
			$('[href="#xlznIndexBasic"]').click();
			return;
		}
		
		if($(this).parent().hasClass('disabled')){
			xlznAlert('你必须完成【基本信息】以后才能填写其他内容哦。')
			return;
		}
		if($(this).attr('data-target')) return;
		if($(this).attr('href') != '#xlznPhotoContent' && $('#xlznPhotoContent').data('ifUploading')){
			xlznAlert('上传过程中不要离开哦');
			return;
		}
		var _href = $(this).attr('href'),
			$target = $(_href),
			$rTarget = $('[href="'+ _href + '"]').parent();
		$rTarget.siblings().removeClass('active');
		$rTarget.addClass('active');

		$target.siblings('.xlzn_cbox_content, .xlzn_content').removeClass('active');
		$(this).parent().siblings().removeClass('active');
		$target.addClass('active');
		$(this).parent().addClass('active');
		if($(this).closest('.xlzn_fixed_top').length>0){
			$(window).scrollTop(134);
		}
	});
	$.fn.hasExtension = function(exts) {
	    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test($(this).val());
	}
	//上传轨迹
	$('#fileToUpload').live('change', function(e){
		if (!$(this).hasExtension(['.gpx', '.kml'])) {
		    xlznAlert('仅支持kml,gpx格式!');
		    return;
		}
		$('.xlzn_map_loading').show();
		$('#fileToUpload, #xlznMapUpload').hide();
		$.ajaxFileUpload({
			url: location.protocol + "//" + location.host + '/route/add_road_map',
			secureuri:false,
			fileElementId:'fileToUpload',
			dataType:'json',
			success: function (data, status){
				if(data.msgs == 'success'){
					xlznRoadData = {
						map_line_path: data.result.map_line_path,
						next_actvty_id: data.result.next_actvty_id
					}
					if(window.roadMap) {
						roadMap.getMap().destroy();
					}
						
					roadMap = new xlznMap();
					var mapline_data = data.result.mapline_data;

						roadMap.init('xlznMap',{
							lng: mapline_data[0].Lng,
							lat:mapline_data[0].Lat
						},true, '起点');
						roadMap.addMarker({
							lng: mapline_data[mapline_data.length-1].Lng,
							lat: mapline_data[mapline_data.length-1].Lat
						},4,'终点');
						roadMap.polyLine(mapline_data);
						roadMap.addMenu(true);
						//roadMap = roadMap.getMap();
					$('.xlzn_map_tip, #mapCoordSelect').show();
					$('#mapCoordSelect').removeAttr('data-coord');
					
				}else{
					xlznAlert(data.msgs)
				}
				$('#fileToUpload, #xlznMapUpload').show();
				$('.xlzn_map_loading').hide();
			},
			error: function(data){
				xlznAlert('上传失败');
				$('#fileToUpload, #xlznMapUpload').show();
				$('.xlzn_map_loading').hide();
			}
		});
	});
	$('#mapCoordSelect').change(function(e){
		e.preventDefault();
		var _coord_type = $('#mapCoordSelect').val();
		if(_coord_type!=''){
			$('#fileToUpload, #xlznMapUpload,#mapCoordSelect, .xlzn_map_tip').hide();
			$('.xlzn_map_loading').show();
			$.ajax({
				url: location.protocol + "//" + location.host  + '/route/amap_coord_switch',
				dataType: 'json',
				data: {
					coord: _coord_type,
					next_actvty_id: xlznRoadData.next_actvty_id
				},
				type: 'POST',
				success: function(data){
					if(data.msgs == 'success'){
						
						if(window.roadMap) {
							roadMap.getMap().destroy();
						}
							
						roadMap = new xlznMap();
							roadMap.init('xlznMap',{
								lng: data.result[0].Lng,
								lat: data.result[0].Lat
							},true, '起点');
							roadMap.addMarker({
								lng: data.result[data.result.length-1].Lng,
								lat: data.result[data.result.length-1].Lat
							},4,'终点');
							roadMap.polyLine(data.result);
							roadMap.addMenu(true);
							//roadMap = roadMap.getMap();
						$('#mapCoordSelect').attr('data-coord', _coord_type);
						
					}else{
						xlznAlert(data.msgs)
					}
					$('#fileToUpload, #xlznMapUpload,#mapCoordSelect, .xlzn_map_tip').show();
					$('.xlzn_map_loading').hide();
				}
			});
		}else{
			$('#mapCoordSelect').attr('data-coord', _coord_type);
		}

	});
	//详情页数据初始化
	if($('#openIndexModal').size()){
		//展示
		if(window.route_info){
			var $basicHolder = $('.xlzn_info'),
				$extraHolder = $('.xlzn_time'),
				$maplineInfo = $('#xl_datas');
			if(route_info.route_type_id){
				$('<div class="xlzn_attr">所属类型 :<span>'+ xlznTypeArr[route_info.route_type_id-1]  +'</span></div>').insertBefore($maplineInfo);
			}
			if(route_info.difficulty_level){
				var difficultyArr = ['休闲','标准','挑战','自虐'];
				if(difficultyArr[route_info.difficulty_level-1]){
					$('<div class="xlzn_attr">线路难度 :<span>'+ difficultyArr[route_info.difficulty_level-1]  +'</span></div>').appendTo($basicHolder);
				}
			}
			if(route_info.season_ids){
				var seasonArr = ['春','夏','秋','冬'],	
					idArr = route_info.season_ids.split(','),
					str = [];
				$(idArr).each(function(i, o){
					if(seasonArr[o-1]){
						str.push(seasonArr[o-1]);
					}
				});
				str = str.join('<span class="xlzn_split">/</span>');
				if(str){
					$('<div class="xlzn_attr">最佳季节 :<span>'+ str +'</span></div>').appendTo($basicHolder);
				}
			}
			if(route_info.travel_time){
				$('<div class="xlzn_attr">活动时长 :<span>'+ route_info.travel_time  +'天</span></div>').appendTo($basicHolder);
			}
			
			if(route_info.campsite_count){
				var campCountArr = ['1-5个','5-10个','10-20个','20-50个','50-100个','更多'];
				if(campCountArr[route_info.campsite_count-1]){
					$('<div class="xlzn_attr">营位数量 :<span>'+ campCountArr[route_info.campsite_count-1]  +'</span></div>').appendTo($basicHolder);
				}
			}
			if(route_info.road_state_ids || route_info.road_state_desc){
				var idArr = route_info.road_state_ids ? route_info.road_state_ids.split(',') : [],
					xlznRoadArr = roadMetaArr,
					str = [],
					str2 = route_info.road_state_desc ? route_info.road_state_desc.split(','):[];
				$(idArr).each(function(i, o){
					if(xlznRoadArr[o-1] && xlznRoadArr[o-1][1]){
						str.push(xlznRoadArr[o-1][1]);
					}
				});
				str = str.concat(str2);
				str = str.join('<span class="xlzn_split">/</span>');
				if(str){
					$('<div class="xlzn_attrfull"><span>道路状况 :</span><p>'+ str  +'</p></div>').insertBefore($extraHolder);
				}
			}
			/*if(route_info.route_desc){
				var value = route_info.route_desc.replace(/\n/g, '<br/>');
				$('<div class="xlzn_des"></div>').html(value).insertAfter($basicHolder)
			}*/
			if(route_info.campsite_ids){
				var idArr = route_info.campsite_ids.split(','),
					xlznCampArr = ['卫生间','淋浴间','烧烤区', '商店', '可充电', '装备租赁', '停车场', '季节性水源', '常年水源'],
					str = [];
				$(idArr).each(function(i, o){
					if(xlznCampArr[o-1]){
						str.push(xlznCampArr[o-1]);
					}
				});
				str = str.join('<span class="xlzn_split">/</span>');
				if(str){
					$('<div class="xlzn_attrfull"><span>营地设施 :</span><p>'+ str  +'</p></div>').insertBefore($extraHolder);
				}
			}
			if(route_info.travel_line){
				var value = route_info.travel_line.replace(/\n/g, '<br/>');
				$('<div class="xlzn_attrfull"><span>线路行程 :</span><p>'+ value +'</p></div>').insertBefore($extraHolder);
			}
			if(route_info.traffic_info){
				var value = route_info.traffic_info.replace(/\n/g, '<br/>');
				$('<div class="xlzn_attrfull"><span>交通位置 :</span><p>'+ value +'</p></div>').insertBefore($extraHolder);
			}
			if(route_info.prompt_notice){
				var value = route_info.prompt_notice.replace(/\n/g, '<br/>');
				$('<div class="xlzn_attrfull xlzn_tip"><p>重要提示</p><div>'+ value +'</div></div>').insertBefore($extraHolder);
			}
			if(!route_info.tag_ids && !route_info.tag_custom){
				$('.xlzn_label').remove();
			}
		}
		if(tagMetaArr.length>0){
			var $holder = $('[data-type="2"] .xlzn_type_autolist'),
				arr = [];

			$(tagMetaArr).each(function(i, arr){
				if(arr[1] == route_info.route_type_id){
					$('<a>'+ arr[2] +'</a>').attr('data-idx', arr[0]).prependTo($holder);
					arr.push(arr[2]);
				}
			});
			$('[name="tag_ids"]').next().val(arr.join(','));

		}
		displayXlznType(route_info.route_type_id);
		//mapLineArr[10].Lat = '';//test
		checkMapline();
		//轨迹
		if(mapLineArr.length > 0 && !mapLineInfo.ifDataError){
			var topMap = new xlznMap(true, true);
			topMap.init('xlznTopMap',{
				lng: mapLineArr[0].Lng,
				lat: mapLineArr[0].Lat
			},true, '起点');
			topMap.addMarker({
				lng: mapLineArr[mapLineArr.length-1].Lng,
				lat: mapLineArr[mapLineArr.length-1].Lat
			},4,'终点')
			var _returnData = topMap.polyLine(mapLineArr); 
			mapLineInfo.eMax = _returnData.eMax;
			mapLineInfo.eMin = _returnData.eMin;
			//是否有海拔数据
			if(mapLineInfo.ifHasAlt == 'y'){
				$maplineInfo.find('.xlmapline_emax').text(parseInt(mapLineInfo.eMax));
				$maplineInfo.find('.xlmapline_emin').text(parseInt(mapLineInfo.eMin));
				$('#maplineEmax').text(parseInt(mapLineInfo.eMax)+' m');
				$('#maplineEmin').text(parseInt(mapLineInfo.eMin)+' m');
				
			}
			//是否有里程值
			if(parseFloat(mapLineInfo.total)){
				$maplineInfo.find('.xlmapline_total').text(parseFloat(mapLineInfo.total).toFixed(2));
				$('#maplineLen').text(parseFloat(mapLineInfo.total).toFixed(2)+' km');
				$maplineInfo.show();
				$('#maplineStatus').show();
			}
			
			
		}else{
			var topMap = new xlznMap(true, true);
			topMap.init('xlznTopMap',{
				lng: route_info.offset_lngi,
				lat: route_info.offset_lati
			},route_info.route_type_id, route_info.route_name);
		}
		//$('#testMap').attr('src', getAMapImgUrl(3,'300*220','3,0xa75cde,1,,',mapLineArr))
		//地图不可通过鼠标拖拽平移
		topMap.getMap().setStatus({
			dragEnable: false,
			scrollWheel: false
		});
		//轨迹tab点击
		$('[href="#xlznIndexMap"]').one('click', function(){
			if(!$('#xlznIndexMap').data('ifload')){
				var beginPoint,
					endPoint,
					ifInitBegin = false,
					mapLineArrLen = mapLineArr.length,
					_return_polyline = {};
				if(mapLineArrLen > 0 && !mapLineInfo.ifDataError){
					centerMap = new xlznMap(false, true);
					centerMap.init('xlznCenterMap');
					_return_polyline = centerMap.polyLine(mapLineArr); 
					beginPoint = {
						lng: mapLineArr[0].Lng,
						lat: mapLineArr[0].Lat
					};
					endPoint = {
						lng: mapLineArr[mapLineArrLen-1].Lng,
						lat: mapLineArr[mapLineArrLen-1].Lat
					};
					initRouteChart();
					$('#routeChartToggle').click(function(){
						$(this).toggleClass('toggle_up');
						$('#routeChart').slideToggle();
						$('#routeChartToggle>i').toggleClass('route_down');
						$('.route_chart_none').toggle();
					});

				}else{
					centerMap = new xlznMap(false, true);
					centerMap.init('xlznCenterMap',{
						lng: route_info.offset_lngi,
						lat: route_info.offset_lati
					},route_info.route_type_id, route_info.route_name);
				}
				if(roadPoint.length > 0){
					$(roadPoint).each(function(i, o){
						var position = new AMap.LngLat(o.offset_lngi, o.offset_lati),
							type;

						switch(o.flag_type){
							case '起点': 
								type = 1;
								ifInitBegin = true;
								if(beginPoint) position = beginPoint;
								break;
							case '路点': type = 2;break;
							case '营地': type = 3;break;
							case '终点': 
								type = 4;
								if(endPoint) position = endPoint;
								break;
						}
						centerMap.addMarker(position, type, o.flag_txt);
					});
				}
				if(!mapLineInfo.ifDataError && !ifInitBegin && mapLineArrLen > 0){
					centerMap.addMarker(beginPoint, 1, '起点');
					centerMap.addMarker(endPoint, 4, '终点');
				}
				$('#xlznIndexMap').data('ifload', true);
			}
		});
		//照片tab点击
		$('[href="#xlznIndexPhoto"]').one('click', function(){
			if(!$('#xlznIndexPhoto').data('ifload')){
				if(routeImageArr.length>0){
					routeImageArr = routeImageArr.reverse();
					xlznPhotoIndexShow(1);
					var total = Math.ceil(routeImageArr.length/20);
					if(total>1) xlznNav(1, total, $('#routePhotoNav'));
				}
				$('#xlznIndexPhoto').data('ifload', true);
			}
		});
	}
	//详情页打开编辑框
	$('#openIndexModal').click(function(e){
		e.preventDefault();
		if(photoUsername =='') return;
		if(!$('#xlznIndexModal').data('iffirst')){
			xlznIndexModalInit();
			$('#xlznIndexModal').data('iffirst', true);
		}
		$('#xlznIndexModal, .xlzn_modal_cover').show();
		$('#xlznIndexModal').get(0).scrollIntoView();

	});
	$('#openIndexModalMap').click(function(e){
		e.preventDefault();
		if(photoUsername =='') return;
		if($(this).attr('data-target')){
			var $target = $($(this).attr('data-target'));
			$target.siblings().removeClass('active');
			$target.addClass('active');
			var $tab = $target.siblings('.xlzn_cbox_head').find('[data-target="'+ $(this).attr('data-target') +'"]').parent();
			$tab.siblings().removeClass('active');
			$tab.addClass('active');
		}
		if(!$('#xlznIndexModal').data('iffirst')){
			xlznIndexModalInit();
			$('#xlznIndexModal').data('iffirst', true);
		}
		$('#xlznIndexModal, .xlzn_modal_cover').show();
		$('#xlznIndexModal').get(0).scrollIntoView();
	});
	
	function xlznIndexModalInit(){
		if(window.route_info){
			if($('[name="route_type_id"]').length>1){
				$('[name="route_type_id"][value='+ route_info.route_type_id +']').parent().click();
			}else{
				$('[name="route_type_id"]').val(route_info.route_type_id);
				$('[name="route_type_id"]').next().text(xlznTypeArr[route_info.route_type_id-1]);
				$('[name="route_name"]').next().text(route_info.route_name);
				$('[name="dest_node_name"]').parent().next().text(route_info.parent_node_name);
			}
			
			$('[name="route_name"]').val(route_info.route_name);
			$('[name="route_desc"]').val(route_info.route_desc);
			$('[name="dest_node_name"]').val(route_info.parent_node_name);
			$('[name="lngi"]').val(route_info.offset_lngi);
			$('[name="lati"]').val(route_info.offset_lati);
			$('#lnglat').text(route_info.offset_lngi + ', ' + route_info.offset_lati).show();

			if(route_info.season_ids){
				$('[name="season_ids"]').attr('checked', false).parent().removeClass('active');
				var seasonArr =  route_info.season_ids.split(',');
				$(seasonArr).each(function(i, o){
					$('[name="season_ids"][value="'+ o +'"]').attr('checked', true).parent().addClass('active');
				});
			}
			if(route_info.season_desc){
				$('[name="season_desc"]').val(route_info.season_desc).removeClass('disabled');
			}
			if(route_info.travel_time){
				if(parseInt(route_info.travel_time) > 7){
					$('[name="travel_time2"]').val(route_info.travel_time);
					$('.xlzn_form_slide li').removeClass('active');
					$('.xlzn_form_slide li').first().addClass('active');
					$('[name="travel_time"]').val('0.5');
				}else{
					$('[name="travel_time"]').val(route_info.travel_time);
					$('.xlzn_form_slide li').removeClass('active');
					var i = parseInt(route_info.travel_time);
					if(route_info.travel_time != ''){
						$('.xlzn_form_slide li').eq(i).addClass('active');
					}
					$('#xlzn_slidebtn').css('left', i*50+'px');
				}
			}
			if(route_info.tag_custom){
				$('[name="tag_custom"]').val(route_info.tag_custom);
				var tagCustomArr = route_info.tag_custom.split(',');
				$(tagCustomArr).each(function(i, o){
					$('<li><a class="extra">'+ o +'<span>×</span></a></li>').prependTo($('[data-type="2"] .xlzn_type_auto'));
				});
			}
			if(route_info.tag_ids){
				$('[name="tag_ids"]').val(route_info.tag_ids);
				var tagArr =  route_info.tag_ids.split(','),
					$tagholder = $('[name="tag_ids"]').parent();
				$(tagArr).each(function(i, o){
					$('<li><a class="extra">'+ $tagholder.find('[data-idx="'+ o +'"]').text() +'<span>×</span></a></li>').prependTo($('[data-type="2"] .xlzn_type_auto'));
				});

			}
			
			if(route_info.difficulty_level){
				$('[name="difficulty_level"]').attr('checked', false).parent().removeClass('active');
				$('[name="difficulty_level"][value="'+ route_info.difficulty_level +'"]').attr('checked', true).parent().addClass('active');
			}
			if(route_info.road_state_desc){
				$('[name="road_state_desc"]').val(route_info.road_state_desc);
				var roadCustomArr = route_info.road_state_desc.split(',');
				$(roadCustomArr).each(function(i, o){
					$('<li><a class="extra">'+ o +'<span>×</span></a></li>').prependTo($('[data-type="7"] .xlzn_type_auto'));
				});
			}
			if(route_info.road_state_ids){
				$('[name="road_state_ids"]').val(route_info.road_state_ids);
				var roadArr =  route_info.road_state_ids.split(','),
					roadp = roadMetaArr;

				$(roadArr).each(function(i, o){
					$('<li><a class="extra">'+ roadp[o-1][1] +'<span>×</span></a></li>').prependTo($('[data-type="7"] .xlzn_type_auto'));
				});
			}
			
			if(route_info.campsite_ids){
				$('[name="campsite_ids"]').attr('checked', false).parent().removeClass('active');
				var campsiteArr =  route_info.campsite_ids.split(',');
				$(campsiteArr).each(function(i, o){
					$('[name="campsite_ids"][value="'+ o +'"]').attr('checked', true).parent().addClass('active');
				});
			}
			if(route_info.campsite_count){
				$('[name="campsite_count"][value="'+ route_info.campsite_count +'"]').attr('checked', true).parent().addClass('active');
			}
			if(route_info.travel_line){
				$('[name="travel_line"]').val(route_info.travel_line);
			}
			if(route_info.traffic_info){
				$('[name="traffic_info"]').val(route_info.traffic_info);
			}
			if(route_info.prompt_notice){
				$('[name="prompt_notice"]').val(route_info.prompt_notice);
			}
			$('.xlzn_form_textarea').addClass('active').keyup();

		}
	}
	$('[data-target="#xlznEditMap"]').one('click', function(e){
		if(!$('#xlznMap').attr('data-load')){
			var beginPoint,
				endPoint,
				ifInitBegin = false,
				mapLineArrLen = mapLineArr.length;
			if(mapLineArrLen > 0 && !mapLineInfo.ifDataError){
				if(window.roadMap) {
					roadMap.getMap().destroy();
				}
				roadMap = new xlznMap();
				roadMap.init('xlznMap');
				roadMap.polyLine(mapLineArr);
				beginPoint = {
					lng: mapLineArr[0].Lng,
					lat: mapLineArr[0].Lat
				};
				endPoint = {
					lng: mapLineArr[mapLineArrLen-1].Lng,
					lat: mapLineArr[mapLineArrLen-1].Lat
				};
				
			}else{
				if(window.roadMap) {
					roadMap.getMap().destroy();
				}
				roadMap = new xlznMap();
				roadMap.init('xlznMap',{
					lng: route_info.offset_lngi,
					lat: route_info.offset_lati
				},route_info.route_type_id, route_info.route_name);
			}
			if(roadPoint.length > 0){
				roadMap.ifAddnew = true;//已审核通过路点营地是否能编辑删除
				roadMap.ifPostData = true;//已审核通过路点营地是否编辑后数据提交
				$(roadPoint).each(function(i, o){
					var position = new AMap.LngLat(o.offset_lngi, o.offset_lati),
						type;

						switch(o.flag_type){
							case '起点': 
								type = 1;
								ifInitBegin = true;
								if(beginPoint) position = beginPoint;
								break;
							case '路点': type = 2;break;
							case '营地': type = 3;break;
							case '终点': 
								type = 4;
								if(endPoint) position = endPoint;
								break;
						}
					roadMap.addMarker(position, type, o.flag_txt, null, o.pointId);
				});
			}
			if(!mapLineInfo.ifDataError && !ifInitBegin && mapLineArrLen > 0){
				roadMap.addMarker(beginPoint, 1, '起点');
				roadMap.addMarker(endPoint, 4, '终点');
			}
			roadMap.addMenu(true);
			if(window.modalMap){
            	modalMap.relativeMap = roadMap.getMap();
            }
			//roadMap = roadMap.getMap();
			$('#xlznMap').attr('data-load', true);
		}
	});
	//详情页编辑
	$('#xlznIndexEditBtn').click(function(e){
		e.preventDefault();
		var basicData = xlznCreateBasicValidate(true);
		//基本信息
		if(!basicData){
			if(!$('#xlznEditBasic').hasClass('active')){
				$('#xlznEditBasic').siblings('.xlzn_cbox_content').removeClass('active');
				$('#xlznEditBasic').addClass('active');
				$('[data-target="#xlznEditBasic"]').parent().siblings().removeClass('active');
				$('[data-target="#xlznEditBasic"]').parent().addClass('active');
			}
			return;
		}
		//线路详情
		var	detailData = xlznCreateDetailValidate();
		if(!detailData){
			if(!$('#xlznEditDetail').hasClass('active')){
				$('#xlznEditDetail').siblings('.xlzn_cbox_content').removeClass('active');
				$('#xlznEditDetail').addClass('active');
				$('[data-target="#xlznEditDetail"]').parent().siblings().removeClass('active');
				$('[data-target="#xlznEditDetail"]').parent().addClass('active');
			}
			return;
		}
		//轨迹路书
		var roadData = {
			road_point:[]
		};
		$('#xlznMap .xlzn_marker_wrapnew').each(function(i, obj){
			var roadObj = {
				coor_type: 'gcj02'
			};
			var	$target = $(obj);

			if($target.attr('data-type')){
				roadObj.flag_type = $target.attr('data-type');
				roadObj.lngi = $target.attr('data-lng');
				roadObj.lati = $target.attr('data-lat');
				roadObj.flag_txt = $target.find('.xlzn_mk_tip').text();
				roadData.road_point.push(roadObj);
			}
			
		});	
		
		if(!window.xlznRoadData){
			xlznRoadData = {};
		}
		if(!window.xlznData){
			xlznData = {
				route_base_id: route_info.route_base_id,
				route_attr_ver_id: route_info.route_attr_id
			}
		}
		xlznData.dest_node_id = route_info.parent_node_id;
		if(route_info.map_line_id){
			xlznData.map_line_id = route_info.map_line_id;
		}
		roadData.coord_type = $('#mapCoordSelect').attr('data-coord');
		xlznFormData = $.extend({}, xlznData, basicData, detailData, roadData, xlznRoadData);
		$('.xlzn_modal_cover').css('zIndex', 1010);
		$('#xlznEditModal, .xlzn_modal_cover').show();
	});	
	//详情页编辑确定提交
	$('#xlznIndexEditSure').click(function(e){
		e.preventDefault();
		$.ajax({
			url: location.protocol + "//" + location.host  + '/route/add_all',
			dataType: 'json',
			data: xlznFormData,
			type: 'POST',
			success: function(data){
				if(data.msgs == 'success'){
					xlznData = data.result;
					$('.xlzn_modal_cover').css('zIndex', 1000);
					$('#xlznIndexModal, #xlznEditModal,.xlzn_modal_cover').hide();
					$('.xlzn_marker_wrapnew').removeClass('xlzn_marker_wrapnew');
					if(window.roadMap){
						roadMap.disabledPostedMarker();
					}
				}else{
					xlznAlert(data.msgs)
				}
			}
		});
	});
	//照片列表hover效果
	$(".xlzn_gallery_list").delegate("li", "hover", function(e){
	    if (e.type == 'mouseenter') {
	        var $target = $(this).find('.shadow, .info');
			$target.stop(true, true).animate({
				'display': 'block',
				'bottom': 0
			}, 'fast');
	    }
	    if(e.type == 'mouseleave'){
	        var $target = $(this).find('.shadow, .info');
			$target.stop(true, true).animate({
				'bottom': '-30px',
				'display': 'none'
			}, 'fast');
	    }
	});
	//详情页照片放大
	$('#xlznPhotoHolder').delegate("li", 'click', function(e){
		if($(e.target).is('a')) return;
		var idx = $(this).attr('data-idx');
		$('#jSlideModal, .xlzn_modal_cover_heavy').show();
		$('.jslide_wrap').jSlide({
			dataArr: routeImageArr,
			index: idx
		});
	});
	//详情页添加照片
	$('#xlznIndexAddPhoto').click(function(e){
		e.preventDefault();
		if(photoUsername =='') return;
		$('#xlznIndexPhotoModal, .xlzn_modal_cover').show();
	});
	//详情页照片添加完成编辑
	$('#xlznIndexPhotoEditBtn').click(function(e){
		e.preventDefault();
		if($('#xlznIndexPhotoModal').size() > 0 && $('#xlznIndexPhotoModal').data('ifUploading')){
			xlznAlert('上传过程中不要离开哦');
			return;
		}
		//照片
		var photoData = { 
			route_base_id: route_info.route_base_id,
			route_attr_ver_id: route_info.route_attr_id,
			photo_ids:'',
			site_photo_ids:'',
			op_fr: 'route_detail'
		}
		var localArr = [],
			setArr = [],
			imgArr = [];
		$('#xlznIndexPhotoModal .xgl_list>li').each(function(i, obj){
			if($(obj).attr('data-group') == 'site_photo_ids'){
				setArr.push($(obj).attr('imgId'));
			}else{
				localArr.push($(obj).attr('imgId'));
			}
			imgArr.push($(obj).find('img').attr('src'));
		});
		photoData.photo_ids = localArr.join(',');
		photoData.site_photo_ids = setArr.join(',');
		if(localArr.length || setArr.length){
			$.ajax({
				url: location.protocol + "//" + location.host + '/route/save_route_img',
				dataType: 'json',
				data: photoData,
				type: 'POST',
				success: function(data){
					if(data.msgs == "success"){
						var len = imgArr.length;
						len--;
						$(imgArr).each(function(i, o){
							var obj = {
								path: o,
								username: photoUsername,
								userid: myUID
							}
							routeImageArr.unshift(obj);
							/*var img_lg = o.replace('_m.', '_b.');
							$('<li data-idx="'+ len +'"><div><a><img src="'+ o +'" data-href="'+ img_lg +'"/></a></div><p class="shadow"></p><p class="info">照片来自: <span class="user">'+ route_info.username +'</span></p></li>').prependTo($('#xlznPhotoHolder'));
							$('#xlznPhotoHolder li').eq(20).remove();
							len--;*/
							xlznPhotoIndexShow(1);
							var total = Math.ceil(routeImageArr.length/20);
							if(total>1) xlznNav(1, total, $('#routePhotoNav'));

						});
						$('#xlznIndexPhotoModal .xgl_list').html('');
						$('#xlznIndexPhotoModal, .xlzn_modal_cover').hide();
					}else{
						xlznAlert(data.msgs)
					}
				},
				error: function(msg){
					xlznAlert(msg)
				}
			});
		}else{
			xlznAlert('您还没有选中任何照片')
		}
	});
	function xlznPhotoIndexShow(page){
		var $photoHolder = $('#xlznPhotoHolder');
		$photoHolder.html('');
		for(var i = (page-1) *20; i < page*20 && i < routeImageArr.length; i++){
			var o = routeImageArr[i];
			var img_lg = o.path.replace('_m.', '_b.');
			var $li = $('<li data-idx="'+ i +'"><div><a><img data-src="'+ o.path +'" data-href="'+ img_lg +'"/></a></div><p class="shadow"></p><p class="info">照片来自: <a href="/user/'+ o.userid +'" class="user">'+ o.username +'</a></p></li>');
			$li.appendTo($photoHolder);
			imagePre(o.path, i);
		}
		$(window).scrollTop(0);
		function imagePre(src, idx){
			var $ele = $('#xlznPhotoHolder li[data-idx="' + idx + '"]');
			var holderW = $ele.width(),
				holderH = $ele.height();

			$('<img/>').on('load error', function(e){
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
				$ele.find('img').attr('src', src).css({
					width: imgW,
					height: imgH,
					marginTop: _marginTop,
					marginLeft: _marginLeft
				});
				
			}).attr('src', src);
		}
	}
	
	//详情页分页点击
	$('#routePhotoNav').delegate('a', 'click', function(e){
		e.preventDefault();
		var $target = $(this);
		if($target.hasClass('active') || $target.hasClass('disabled')) return;
		var currIndex = parseInt($target.siblings('.active').attr('data-href'));

		if($target.hasClass('prev')){
			currIndex--;
		}else if($target.hasClass('next')){
			currIndex++;
		}else{
			currIndex = parseInt($target.attr('data-href'));
		}
		xlznPhotoIndexShow(currIndex);
		var total = Math.ceil(routeImageArr.length/20);
		if(total>1) xlznNav(currIndex, total, $('#routePhotoNav'));
	});
	//编辑框取消
	$('.xlzn_cbox_cancel').click(function(e){
		e.preventDefault();
		if($('#xlznIndexPhotoModal').size() > 0 && $('#xlznIndexPhotoModal').data('ifUploading')){
			xlznAlert('上传过程中不要离开哦');
			return;
		}
		if($(this).closest('.xlzn_modal').length){
			$(this).closest('.xlzn_modal').hide();
			$('.xlzn_modal_cover').hide();
		}else{
			if(confirm('您确定要取消编辑吗？')){
				if(!$('#xlznIndexModal').length && window.route_info){//驳回页
					history.go(-1);
					return;
				}
				var _return_url = $.cookie('addroute_return_url'); 
				if(_return_url){
					location.href = _return_url;
				}else{
					window.close();
				}
			}
		}
	});
	//详情页小地图点击
	$('.xlzn_mapimg').click(function(e){
		e.preventDefault();
		$('[href="#xlznIndexMap"]').click();
	});
	$('#xlznSelectCity').click(function(e){
		e.preventDefault();
		$(this).next().fadeIn();
	});

	
	function GetRequest() {
	   var url = location.search; //获取url中"?"符后的字串
	   var theRequest = new Object();
	   if (url.indexOf("?") != -1) {
	      var str = url.substr(1);
	      strs = str.split("&");
	      for(var i = 0; i < strs.length; i ++) {
	         theRequest[strs[i].split("=")[0]] = strs[i].split("=")[1];
	      }
	   }
	   return theRequest;
	}
	//详情页顶部tab悬浮
	$(window).scroll(function(){
		if(window.xlznTopTimeoutId){
			clearTimeout(xlznTopTimeoutId)
		}
		xlznTopTimeoutId = setTimeout(function(){
			var _top = $(window).scrollTop();
			if(_top > 200){
				$('.xlzn_fixed_top').show();
			}else{
				$('.xlzn_fixed_top').hide();
			}
		},60);
	});
	//标签自动生成效果
	$('.xlzn_autoinput').on('keypress', function(e){
		e.preventDefault();
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == 13){
			var $split = $(this).closest('li'),
				txt = $(this).val(),
				$rel = $('[name="'+ $(this).attr('data-for') +'"]');
				defaultArr = $rel.next().val().split(','),
				setArr = $(this).next().val() ? $(this).next().val().split(','):[],
				relIdArr = $rel.val() ? $rel.val().split(','):[];

			if(txt == '') return;
			for(var i=0; i<setArr.length; i++){
				if(txt == setArr[i]){
					$(this).val('');
					return;
				}
			}
			for(var i=0; i<relIdArr.length; i++){
				if(txt == $rel.siblings('[data-idx='+ relIdArr[i] +']').text()){
					$(this).val('');
					return;
				}
			}
			for(var i=0; i<defaultArr.length; i++){
				if(txt == defaultArr[i]){
					var idx = $rel.siblings('[data-idx]').eq(i).attr('data-idx');
					relIdArr.push(idx);
					$rel.val(relIdArr.join(','));
					$('<li><a class="extra">'+ txt +'<span>×</span></a></li>').insertBefore($split);
					$(this).val('');
					return;
				}
			}
			setArr.push(txt);
			$(this).next().val(setArr.join(','));
			$('<li><a class="extra">'+ txt +'<span>×</span></a></li>').insertBefore($split);
			$(this).val('').focus();
		}
	}).on('focus', function(){
		$(this).parent().next().show();
	}).on('blur', function(){
		$(this).parent().next().hide();
	});
	
	$('.xlzn_type_auto').delegate('a', 'click', function(e){
		e.preventDefault();
		var txt = $(this).text().split('×')[0],
			$control = $(this).closest('.xlzn_form_control'),
			$tar = $control.find('.xlzn_autoinput'),
			$rel = $('[name="'+ $tar.attr('data-for') +'"]'),
			setArr = $tar.next().val().split(','),
			relIdArr = $rel.val().split(',');

		for(var i=0; i<setArr.length; i++){
			if(txt == setArr[i]){
				setArr.splice(i,1);
				$tar.next().val(setArr.join(','));
				break;
			}
		}
		for(var i=0; i<relIdArr.length; i++){
			if(txt == $rel.siblings('[data-idx='+ relIdArr[i] +']').text()){
				relIdArr.splice(i,1);
				$rel.val(relIdArr.join(','));
				break;
			}
		}

		$(this).parent().remove();
	});
	$('.xlzn_type_autolist').delegate('a', 'click', function(e){
		e.preventDefault();
		var idx = $(this).attr('data-idx'),
			txt = $(this).text(),
			$control = $(this).closest('.xlzn_form_control'),
			$tar = $control.find('.xlzn_autoinput'),
			$split = $tar.parent().parent(),
			$rel = $('[name="'+ $tar.attr('data-for') +'"]'),
			relIdArr = $rel.val() ? $rel.val().split(','):[];

		for(var i=0; i<relIdArr.length; i++){
			if(idx == relIdArr[i]){
				return;
			}
		}
		relIdArr.push(idx);
		$rel.val(relIdArr.join(','));
		$('<li><a class="extra">'+ txt +'<span>×</span></a></li>').insertBefore($split);
	});
	$('#openIndexModal, #openIndexModalMap, #xlznIndexAddPhoto').click(function(e){
		if(photoUsername ==''){
			location.href = '/user/login?url='+ location.pathname;
		}
	});
	//评分星星
	$('[data-score]').each(function(i, obj){
		initStar($(obj));
	});
	//cookie
	if($('[data-cookieurl]').size()>0){
		$.cookie('addroute_return_url', window.location.href,{path:'/'});
	}
	//被驳回再次编辑
	if(!$('#xlznIndexModal').length && window.route_info){
		$('.xlzn_cbox_tab').children().removeClass('disabled');
		$('#xlznCreateBasicBtn').hide();
		$('#xlznCreateEditBtn').show();
		if(tagMetaArr.length>0){
			var $holder = $('[data-type="2"] .xlzn_type_autolist'),
				arr = [];

			$(tagMetaArr).each(function(i, arr){
				if(arr[1] == route_info.route_type_id){
					$('<a>'+ arr[2] +'</a>').attr('data-idx', arr[0]).prependTo($holder);
					arr.push(arr[2]);
				}
			});
			$('[name="tag_ids"]').next().val(arr.join(','));
		}
		
		displayXlznType(route_info.route_type_id);
		xlznIndexModalInit();
		$('.xlzn_input input').change();
		//轨迹tab点击
		//$('[href="#xlznMapContent"]').one('click', function(){
			if(!$('#xlznMap').data('ifload')){
				var beginPoint,
					endPoint,
					ifInitBegin = false,
					mapLineArrLen = mapLineArr.length;
	                
				if(mapLineArrLen > 0){
					roadMap = new xlznMap(false, false);
					roadMap.init('xlznMap');
					roadMap.polyLine(mapLineArr); 
					beginPoint = {
						lng: mapLineArr[0].Lng,
						lat: mapLineArr[0].Lat
					};
					endPoint = {
						lng: mapLineArr[mapLineArrLen-1].Lng,
						lat: mapLineArr[mapLineArrLen-1].Lat
					};
				}else{
					roadMap = new xlznMap(false, false);
					roadMap.init('xlznMap',{
						lng: route_info.offset_lngi,
						lat: route_info.offset_lati
					},route_info.route_type_id, route_info.route_name);
				}
				roadMap.ifAddnew = true;
				roadMap.ifPostData = true;
				if(roadPoint.length > 0){
					$(roadPoint).each(function(i, o){
						var position = new AMap.LngLat(o.offset_lngi, o.offset_lati),
							type;

						switch(o.flag_type){
							case '起点': 
								type = 1;
								ifInitBegin = true;
								if(beginPoint) position = beginPoint;
								break;
							case '路点': type = 2;break;
							case '营地': type = 3;break;
							case '终点': 
								type = 4;
								if(endPoint) position = endPoint;
								break;
						}
						roadMap.addMarker(position, type, o.flag_txt, null, o.pointId);
					});
				}
				if(!ifInitBegin && mapLineArrLen > 0){
					roadMap.addMarker(beginPoint, 1, '起点');
					roadMap.addMarker(endPoint, 4, '终点');
				}
				if(window.modalMap){
                	modalMap.relativeMap = roadMap.getMap();
                }
                roadMap.addMenu(true);
                //roadMap = roadMap.getMap();
                window.roadMap.ifSetViewFit = true;
				$('#xlznMap').data('ifload', true);
			}
		//});
		//图片数据加载
		if(routeImageArr.length){
			$('.xgl_null').hide();
			var _size = 0;
			$(routeImageArr).each(function(i, obj){
				var $li = $('<li><div><span class="xgl_close">×</span><img alt="" src="'+  obj.path +'" /><div class="xgl_progressbar"><div class="xgl_progressbg"></div><p class="xgl_progress" style="width:100%;"></p><span>100%</span></div></div></li>');
				$li.find('.xgl_close').attr('ajaxurl','/route/del_img?img_id='+obj.photoid);
				$li.attr('imgId', obj.photoid).attr('data-group','site_photo_ids');
				$li.attr('imgSize', obj.size);
				$li.appendTo($('.xgl_list'));
				_size += parseFloat(obj.size);
			});
			//计算上传数量
			var status = document.getElementById("divStatus");
			var num = parseInt(status.innerHTML);
			num++;
			status.innerHTML = routeImageArr.length;

			//计算上传总量
			var temp_imgUploadTotalSize = document.getElementById('temp_imgUploadTotalSize');
			var size = temp_imgUploadTotalSize.value ? temp_imgUploadTotalSize.value : 0;
			size = parseFloat(size);
			size += _size;
			temp_imgUploadTotalSize.value = size;
			var imgUploadTotalSize = document.getElementById('imgUploadTotalSize');
			if(size<=1024){
				imgUploadTotalSize.innerHTML = round2(size/(1024*1024),4);
			}
			else{
				imgUploadTotalSize.innerHTML = round2(size/(1024*1024),3);
			}
		}
		
		$('[href="#xlznMapContent"]').click(function(e){
			e.preventDefault();
			if(window.roadMap.ifSetViewFit == true && route_info.map_line_id){
				roadMap.setFitView();
				//roadMap.setZoom(13);
				roadMap.ifSetViewFit = false;
			}
		});
	}
	function checkMapline(){
		if(window.mapLineArr){
			for(var i = 0, len = mapLineArr.length; i < len; i++){
				if(!mapLineArr[i].Lat || !mapLineArr[i].Lng){
					mapLineInfo.ifDataError = true;
					$('#routeChartToggle, .mapline_info').hide();
					break;
				}
			}
		}
	}
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
//线路提示弹框
function xlznAlert(content, callback){
	if($('.xlzn_alert').size()) return;
	var _html = '<div class="xlzn_modal xlzn_alert"><a class="xlzn_modal_close">×</a><h4 class="xlzn_modal_title">提示</h4><p>'
			  + content + '</p><div class="xlzn_modal_footer center"><a class="xlzn_modal_btn active">确定</a></div></div>';
	
	$(_html).appendTo($('body')).css({
		'marginTop':-1 * $('.xlzn_alert').innerHeight()/2
	}).show();

	$('.xlzn_modal_cover').css('zIndex', 1001).show();		
	$('.xlzn_alert a').click(function(e){
		e.preventDefault();
		$(this).closest('.xlzn_alert').remove();
		if($('#xlznIndexModal').size()){
			$('.xlzn_modal_cover').css('zIndex', 1000);	
		}else{
			$('.xlzn_modal_cover').css('zIndex', 1000).hide();	
		}
		
	});
	var $sure = $('.xlzn_alert .xlzn_modal_btn'),
		$close = $('.xlzn_alert .xlzn_modal_close');
	if(typeof callback == 'function'){
		$sure.click(function(e){
			callback();
			$('.xlzn_modal_cover').hide();
		});
		$close.click(function(e){
			$('.xlzn_modal_cover').hide();
		});
	}
}

//绘制轨迹海拔图表
function initRouteChart() {
    var mapLineArrLen = mapLineArr.length,
    	chartNum =  mapLineArrLen>500 ? 500: mapLineArrLen,
    	_split = parseFloat(mapLineInfo.total)/chartNum,
    	chartArr = [],
    	_step = Math.floor(chartNum/5),
    	chartCategoryArr = [],
    	maxDis = mapLineArr[0].DistanceDest;
    for (var i = 0; i < mapLineArrLen; i++) {
        var obj = {};
        obj.y = mapLineArr[i].Alt * 1;
        obj.lng = mapLineArr[i].Lng * 1;
        obj.lat = mapLineArr[i].Lat * 1;
        obj.dis = maxDis - mapLineArr[i].DistanceDest * 1;

        var _idx = Math.floor(obj.dis/_split);
        if(obj.dis%_split < _split && !chartArr[_idx]){
        	chartArr[_idx] = obj;
        }
        if(i == mapLineArr.length-1){
        	chartArr[chartNum-1] = obj;
        }
        if(i == 0){
        	chartArr[0] = obj;
        }
    }
    for(var i=0; i< chartArr.length-1; i++){
    	if(chartArr[i] == undefined){
    		chartArr[i] = chartArr[i-1];
    		chartArr[i].dis = chartArr[i-1].dis + _split;
    	}
    }
    for(var i=0; i< chartArr.length-1; i++){
    	if(chartArr[i]){
    		chartCategoryArr.push(parseInt(chartArr[i].dis));
    	}
    }
    chartCategoryArr.push((maxDis - mapLineArr[mapLineArrLen-1].DistanceDest).toFixed(1))
    
    $('#routeChart').highcharts({
        chart: {
        	backgroundColor: "rgba(255,255,255,.8)",
            alignTicks: false,
            ignoreHiddenSeries: false,
            width: 996,
            height: 100,
            borderWidth: 0,
            spacing: [10, 20, 0, 10]
        },
        xAxis: {
        	categories: chartCategoryArr,
            type: 'category',
            tickLength: 0,
            labels: {
                step: _step
            },
            lineWidth: 0
        },
        yAxis: {
            title: {
                text: '海拔(m)'
            },
            labels: {
                style: {
                    color: '#3a9d9a',
                    fontSize: '0.8em',
                    width: 100
                },
                formatter: function() {
                    return this.value;
                },
                align: 'left',
                x: 0,
                y: 8
            },
            showLastLabel: true,
            lineWidth: 0,
            gridLineWidth: 1
        },
        tooltip: {
            crosshairs: true,
            enabled: true,
            valueDecimals: 2,
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/><span style="color:{series.color}">asdf</span>:<b>{point.x}</b>',
            headerFormat: "",
            formatter: function() {
                if(!window.moveMarker){
                	var _position = new AMap.LngLat(this.point.lng, this.point.lat);
                	moveMarker = new AMap.Marker({
                        map: centerMap.getMap(),
                        position: _position, //基点位置
                        icon: "http://webapi.amap.com/images/marker_sprite.png", //marker图标，直接传递地址url
                        offset: {
                            x: -8,
                            y: -34
                        } //相对于基点的位置
                    });
                }else{
                	var _position = new AMap.LngLat(this.point.lng, this.point.lat);
                	moveMarker.show();
                	moveMarker.setPosition(_position);
                	
                }
                
                var he = this.y.toFixed(2);
                return "<span>海拔：" + he + " 米</span><br><span>距离：≈"+ this.point.dis.toFixed(1) +"公里</span>";
            },
            backgroundColor: 'rgba(255,255,255,1.0)',
            zIndex: 201
        },
        series: [{
            name: '',
            data: chartArr,
            type: 'spline',
            index: 0

        }],
        plotOptions: {
            spline: {
                lineWidth: 1,
                dashStyle: 'Solid',
                enabled: true,
                cropThreshold: 1000000,
                turboThreshold: 1000000,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                marker: {
                    enabled: false
                }
            },
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            },
            series: {
                point: {
                    events: {
                        mouseOut: function() {
                            if(window.moveMarker){
                            	moveMarker.hide();
                        	}
                        }
                    }
                }
            }
        },
        title: {
            text: ""
        },
        credits: {
            enabled: false
        },
        navigator: {
            enabled: false
        },
        rangeSelector: {
            selected: 1,
            enabled: false
        },
        legend: {
            enabled: false
        }
    });
}
//2050413修改
$(function(){
	
	$.fn.mfpop = function(){
		var pop, popDate, html;
		if(!$(this).data('mfpop')){
			return false;
		}
		popData = $(this).data('mfpop');
		html = '<div class=\'mfpop\'><span>' + popData + '</span><i></i></div>';
		$(html).appendTo($(this));
		pop = $(this).find('.mfpop')
		pop.css('left', ($(this).innerWidth() - pop.width())/2)
	}
	$('.xlzn_map_type li').hover(function(){
		$(this).mfpop()
	},function(){
		$(this).find('.mfpop').remove();
	})
	
	
	//城市选择
	if(window.province_city && typeof province_city !== undefined){
		(function cityInit(){
			//20150407添加
			$('#xl_allcity').on('click', function(){
				$(this).parent().toggleClass('select');
				$('#xl_city_cont').slideToggle(200);
			})
			$(document).on('click', function(event){
				if($(event.target).parents('.select_city').length === 0){
					$('#xl_city_cont').slideUp(200);
					$('#xl_allcity').parent().removeClass('select')
				}
			})
			
			$('#xl_citycate').on('click','li',function(e){
				e.preventDefault();
				var request = GetRequest();
				request['city_slug'] = '';	
				if('keyword' in request && request['keyword'] !== null){
					request['keyword'] = '';
				}
				if('page' in request){
					try{
						delete request['page']
					}catch(e){
						request['page'] = 1;
					}
				}
				var url = location.origin + location.pathname + '?',
					req = '';

				for(var obj in request){
					req += obj + '=' + request[obj] + '&';
				}
				req = req.substr(0, req.length - 1);
				window.location = url + req;
			})
			
			$('#xl_citynames').on('click','li',function(e){
				e.preventDefault();
				var request = GetRequest();
				request['city_slug'] = $(this).data('citycode');	
				request['keyword'] = $(this).text();	
				if('page' in request){
					try{
						delete request['page']
					}catch(e){
						request['page'] = 1;
					}
				}
				var url = location.origin + location.pathname + '?',
					req = '';

				for(var obj in request){
					req += obj + '=' + request[obj] + '&';
				}
				req = req.substr(0, req.length - 1);
				window.location = url + req;
			})
			
			insertCity($('#xl_citynames'), province_city)
		})();
	}
	
	function insertCity(elem, obj){
		var obj = obj || window.province_city;
		var arr = [];
		var str = '';

		for(var i in obj){
			arr.push(i)
		}
		arr.sort();
		
		for(var i = 0; i < arr.length; i++){
			str += '<dl><dt>' + arr[i].toUpperCase() + '</dt><dd><ul>' + loopCity(obj[arr[i]]) + '</ul></dd></dl>';
		}

		elem.html(str);
		
		//地域点击按钮的文字
		$('#xl_allcity span').text(function(i,t){		
			var rst = GetRequest();
			if('keyword' in rst && ($.inArray(decodeURI(rst['keyword']), allCity(obj)) !== -1)){
				return decodeURI(rst['keyword']);
			}
			if('city_slug' in rst && rst['city_slug']){
				var code = rst['city_slug'];
				return $('li[data-citycode=' + code + ']').html();
			}else{
				return '全部'
			}
		})

	}
	
	function loopCity(elem){
		var citystr = ''
		for(var i = 0; i < elem.length; i++){
			citystr += '<li data-citycode=' + elem[i].slug_name + '>' + elem[i].node_name + '</li>';
		}
		return citystr;
	}
	
	function allCity(elem){
		var allCities = [];
		for(var i in elem){
			for(var s = 0; s < province_city[i].length; s++){
				allCities.push(province_city[i][s].node_name)
			}
		}
		return allCities;
	}
	
	function GetRequest() {
	   var url = location.search; //获取url中"?"符后的字串
	   var theRequest = new Object();
	   if (url.indexOf("?") != -1) {
	      var str = url.substr(1);
	      strs = str.split("&");
	      for(var i = 0; i < strs.length; i ++) {
	         theRequest[strs[i].split("=")[0]] = strs[i].split("=")[1];
	      }
	   }
	   return theRequest;
	}
	
	
	//20150415添加 
	$('#xl_datas').hover(function(){
		$(this).find('ul').show()
	},function(){
		$(this).find('ul').hide()
	})
});

//线路名称重复填写下拉框提示
$(function(){
	//改用dy.js 目的地搜索框代码
	var scene_search_pop = $('.search_popupmenu');
    var scene_search_popUl = $('.search_popupmenu ul');
	//搜索自动填充功能
    var last;
    var $currUrl;
    var selected;
    function searchParent(event,obj){
        var keyword = $.trim(obj.val());
        var scene_search_pop = obj.parents('.xlzn_form_control').find('.search_popupmenu');
        var _that = obj;
        isOnly = false;
        //利用event的timeStamp来标记时间，这样每次的keyup事件都会修改last的值，注意last必需为全局变量
        last = event.timeStamp ? event.timeStamp : timestamp();
        setTimeout(function(){
            //如果时间差为0（也就是你停止输入0.5s之内都没有其它的keyup事件发生）则做你想要做的事
            var cur_evt_time;
            cur_evt_time = event.timeStamp ? event.timeStamp : timestamp();
            if(last - cur_evt_time == 0){
                $.post('/api/place/auto_output_nodes',{node_name:keyword,sch_src:'route'},function(data){
                    if(data.only == true){
                        isOnly = true;
                    }
                    if(data.node.length>0){
                        scene_search_popUl.html('');
                        var $li = '<li class="search_popupmenu_tip">亲，这条线路可能已被创建了哦。</li>';
                        $.each(data.node,function(i,n){
                            if(obj.hasClass('quguo_place_input')){
                                $li += '<li area="'+data.node[i].NodeName+'" nodeid="'+data.node[i].NodeID+'"><a href="javascript:void(0);">'+data.node[i].NodeName+'</a></li>';
                            }else{//高亮
                                var str = data.node[i].tree.split('>>');
                                var len = str.length - 2;
                                var father = str[len];
                                var new_name_str = '<em>'+keyword+'</em>';
                                var new_slug_str = '<em>'+keyword+'</em>';
                                var rs_name_str = data.node[i].NodeName.replace(keyword,new_name_str);
                                var rs_slug_str = data.node[i].NodeSlug.replace(keyword,new_slug_str);

                                $li += '<li area="'+data.node[i].NodeName+'" url="/dest/'+data.node[i].NodeSlug+'" ><a target="_blank" href="/dest/'+data.node[i].NodeSlug+'" >'+rs_name_str;
                                if(father !== undefined){
                                    $li += '&nbsp;&nbsp;-&nbsp;&nbsp;<span>'+father+'</span>';
                                }
                                $li += '<p class="search_rs_py_txt">'+rs_slug_str+'</p></a></li>';
                            }

                        });
                        if(_that.hasClass('master_search')){$li += '<li><p class="search_drop_more"><a onclick="search_form.submit();" href="javascript:void(0);">查看更多搜索结果:<em>'+_that.val()+'</em></a></p></li>';}
                        scene_search_popUl.append($li);
                        //$currUrl = "/dest/"+data.node[0].NodeSlug;

                        if(_that.hasClass('quguo_place_input')){
                            var node_id = $('.node_id_hidden').val();
                            if(node_id == ''){
                                $('.node_id_hidden').val(data.node[0].NodeID);
                                $('.quguo_place_input').val(data.node[0].NodeName);
                            }
                        }
                        scene_search_pop.show();
                    }else{
                        scene_search_popUl.html('');
                        scene_search_pop.hide();
                        $currIdx =  false;
                    }
                },'json');
            }
        },300);
    }
	$('#routeName').keyup(function(event){
		var $input = $(this);
		if(event.keyCode != 13){
			searchParent(event, $input);
		}else{//回车

		}
	});
});
//
function getAMapImgUrl(zoom, size, pathsObj, pointsArr, key){
	var url = 'http://restapi.amap.com/v3/staticmap?',
		key = key ? key : '3e0367750ed9d9215ff82e6c3e91f939',
		points = '';

	for(var i=0,len=pointsArr.length; i<len; i++){
		if(pointsArr[i].Lng && pointsArr[i].Lat){
			points += pointsArr[i].Lng + ',' + pointsArr[i].Lat + ';';
		}
	}
	if(points.length){
		points = points.substr(0, points.length-1);
	}
	return url+'size='+size+'&paths='+pathsObj+':'+points+'&key='+key+'&markers=mid,0xFF0000,A:'+pointsArr[0].Lng+','+pointsArr[0].Lat;
}
