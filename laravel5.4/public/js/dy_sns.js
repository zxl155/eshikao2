/**
 *
 *磨房我的sns模块js
 *
 **/
/*活动详细页*/
$(function(){
	//他们也想去（邀请弹出框）
	$('.inviteLink').live('click',function(){
		var that = this;
		showShade();
	    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
	    var windowHeight = $(window).height();
	    var topHeight = scrollTop + (windowHeight/2-50);

	    var event_id = $(this).attr('event_id');
	    var UserName = $(this).attr('UserName');
	    $('#invite-layer textarea').val('');
	    $('#invite-layer input[name="event_id"]').val(event_id);
	    $('#invite-layer input[name="UserName"]').val(UserName);
	    $('#invite-layer-button').data('callbackobj',that);

	    $('#invite-layer').css('top',topHeight).show();
	    return false;
	});

	//他们也想去（取消邀请）
	$('.cancleInviteLink').live('click',function(){
		var that = this;
		var url = $(this).attr('ajaxUrl');
		var requestData = {};
		$.get(url,requestData,function(data){
			if(parseInt(data.error)==0){
				$(that).html('邀请').removeClass('cancleInviteLink').addClass('inviteLink');
	            //刷新报名列表
	            var ajaxUrl = $('#hby_sign_ajax_li').attr('ajaxUrl');
	            $.get(ajaxUrl, function(data) {
	                if(parseInt(data.error) == 0) {
	                    var htmlString = ''; 
	                    for(var i=0; i<data.result.length; i++) {
	                        htmlString += '<tr calss="alt1">';
	                        htmlString += '<td width="120"><img src="'+ MISC_PATH +'images/event/'+ data.result[i].Icon +'" calss="icon" alt="'+ data.result[i].IconTip +'"/><a href="###" class="info_user pr16" rel="hby_info_user_'+ data.result[i].UserID +'" subject="'+ data.result[i].Ttitle +'">'+ data.result[i].UserName +'</a></td>';
	                        htmlString += '<td width="30" class="small">'+ data.result[i].Sex +'</td>';
	                        htmlString += '<td>'+ data.result[i].Memo +'</td>';
	                        htmlString += '<td width="80">'+ data.result[i].State +'</td>';
	                        htmlString += '<td width="130" class="small tc">'+ data.result[i].JoinDate +'</td>';
	                        htmlString += '</tr>';
	                    }
	                    $('#eventListTbody').html(htmlString);
	                    $('#eventListQueryNum').html(data.MemberNum);
	                    $('#eventListLimitNum').html(data.memberLimit);
	                } 
	            }, 'json');
			}
			else{
				alert(data.msgs);
			}
		},'json');
	    return false;
	});

	//他们也想去（邀请提交）
	$('#invite-layer-button').live('click',function(){

		var that = this;
		var $inviteLink = $($('#invite-layer-button').data('callbackobj'));
		var url = $(this).attr('ajaxUrl');
		var requestData = {};
		requestData.event_id = $('#invite-layer input[name="event_id"]').val();
		requestData.UserName = $('#invite-layer input[name="UserName"]').val();
		requestData.msg = $.trim($('#invite-layer textarea').val());
		/*if(!requestData.msg){
			alert('您还没有输入邀请的内容！');
			return false;
		}*/
		$.post(url,requestData,function(data){
			if(parseInt(data.error)==0){
				$('#layer-close').click();
				alert('邀请成功！');

				$inviteLink.html('取消邀请').removeClass('inviteLink').addClass('cancleInviteLink');
				//刷新报名列表
				var ajaxUrl = $('#hby_sign_ajax_li').attr('ajaxUrl');
				$.get(ajaxUrl,function(data){
					if(parseInt(data.error)==0){
						var htmlString = '';
						for(var i=0; i<data.result.length; i++){
							htmlString += '<tr class="alt1">';
							htmlString +=	 '<td width="120"><img src="'+ MISC_PATH +'images/event/'+ data.result[i].Icon +'" class="icon" alt="'+ data.result[i].IconTip +'"/> <a href="###" class="info_user pr16" rel="hby_info_user_'+ data.result[i].UserID +'" subject="'+ data.result[i].Title +'">'+ data.result[i].UserName +'</a></td>';
							htmlString +=	'<td width="30" class="small">'+ data.result[i].Sex +'</td>';
							htmlString +=	 '<td>'+ data.result[i].Memo +'</td>';
							htmlString +=	 '<td width="80">'+ data.result[i].State +'</td>';
							htmlString +=	'<td width="130" class="small tc">'+ data.result[i].JoinDate +'</td>';
							htmlString += '</tr>';
						}
						$('#eventListTbody').html(htmlString);
						$('#eventListQueryNum').html(data.MemberNum);
						$('#eventListLimitNum').html(data.MemberLimit);
					}
				},'json');
			}
			else{
				alert(data.msgs);
			}
		},'json');
	});

	
	var $previewHolder = $('.route-preview');
	if($previewHolder.length){
		var nodeid = $previewHolder.attr('data-nodeid');
		routePreview(nodeid, $previewHolder);
	}
	function routePreview(nodeid, $holder){
		$.post('/api/route/get_info',{node_id:nodeid},function(data){
			var info = data.result.data;
			
			if(info.map_line && info.map_line.length){
				$('<img>').attr('src', getAMapImgUrl('800*400',info.map_line)).appendTo($holder);
			}
			$('.preload').remove();
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
});
//专题首页
$(function(){
	if($("div.themeAactity").length>0){
	    //首页滚动Banner图文显示
	    $('#slider .view li').soChange({
	        thumbObj:'#slider .control li',
	        thumbNowClass:'current',
	        changeTime:6000
	    });
	    
		$("#f2").siblings("ul.con").eq(1).hide();
		$("#f3").siblings("ul.con").eq(1).hide();

		$("div.theme_box div.more_btn a").click(function(){		
			$(this).toggleClass("cur");
			
			if($(this).text()=="收起"){
				$(this).text("更多");	
				$(this).parent("div.more_btn").siblings("ul.con").eq(1).hide();
			}else{
				$(this).text("收起");
				$(this).parent("div.more_btn").siblings("ul.con").eq(1).show();
			}
			
		});
	}
});
//气泡提示框
$(function(){
    $('.bubble_tips_trigger').hover(function(){
        $(this).parents('.bubble_tips_box').find('.bubble_tips').css('display','block');
    },function(){
        $(this).parents('.bubble_tips_box').find('.bubble_tips').css('display','none');
    });
});

//圈子成员管理
$(function(){
    //设置管理员或者成员
    $('.set_member').change(function(){
        var $originalRole = $(this).find('option:selected');

        if(confirm('确定执行此操作？') == true){
            var group_id = $(this).attr('group_id'),
                user_id = $(this).attr('user_id'),
                index = $(this).find('option:selected').index(),
                role;
            role = index == 0 ? 'admin' : 'member';
            $.get('/api/group/setRole',{group_id:group_id,user_id:user_id,role:role},function(data){
                if(data.error == 0){
                    location.reload();
                }else{
                    alert(data.msgs);
                }
            },'json');
        }else{
            $originalRole.siblings().attr('selected','selected');
            return false;
        }

    });
    //确认小组成员
    $('.cf_member').click(function(){
        if(confirm('确定执行此操作？') == true){
            var group_id = $(this).parents('.cf_m_table').find('.set_member').attr('group_id'),
                user_id = $(this).attr('user_id'),
                //index = $(this).find('option:selected').index(),
                role = 'confirm';
            $.get('/api/group/setRole',{group_id:group_id,user_id:user_id,role:role},function(data){
                //alert(data);
                if(data.error == 0){
                    location.reload();
                }else{
                    alert(data.msgs);
                }
            },'json');
        }else{
            //$originalRole.siblings().attr('selected','selected');
            return false;
        }
    });
    //圈子管理页面加入圈子
    $('.join_group').click(function(){
        var group_id = $(this).attr('group_id');
        $.get('/api/group/joinGroup',{group_id:group_id},function(data){
            if(data.error == 0){
                msgTip(data.msgs,function(){
                    location.reload();
                });
            }else if(data.error == 1 ){
                alertLayer(data.msgs,function(){
                    window.location.href = '/user/login/';
                });
            }else{
                if(data.msgs=="is_member")
                    window.location.href = '/group/'+group_id+"/1/";
                else {
                    alertConfirm(data.msgs,function(){
                        location.reload();
                    });
                }
            }
        },'json');
    });
    //圈子悄悄话
    $("input[name='pmgroup']",'.group_sending_qqh').each(function(){

        if($(this).val() == 'Admin'){
            $('.group_sending_qqh').find("input[type='checkbox'][role='admin']").attr('checked','checked');
        }
    });
    //圈子悄悄话发送给哪些成员
    $("input[name='pmgroup']").bind('click',function(){
        $('.group_sending_qqh').find("input[type='checkbox']").attr('checked','checked');
        if($(this).val() == 'All'){
            $('.group_sending_qqh').find("input[type='checkbox']").attr('checked','checked');
        }else if($(this).val() == 'Admin'){
            $('.group_sending_qqh').find("input[type='checkbox']:not([role='admin'])").attr('checked',false);
        }else if($(this).val() == 'Member'){
            $('.group_sending_qqh').find("input[type='checkbox']:not([role='member'])").attr('checked',false);
        }else if($(this).val() == 'notAll'){
            $('.group_sending_qqh').find("input[type='checkbox']").attr('checked',false);
        }
    });

});
