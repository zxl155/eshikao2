$(function(){
	var $wrap = $('.me-wrap');
	$('.me-checkbox').click(function(e){
        e.preventDefault();
        $(this).toggleClass('checked');
    });
    $('.me-radio').click(function(e){
    	e.preventDefault();
    	$(this).addClass('active').siblings('.me-radio').removeClass('active');
    });
	//验证表单
	function validateForm(type, targetId){
		var ifPass = true;
		var $intoView = null;
		var validate = {
			title: function(){//标题
				var $title = $('#topicTitle');
				var $holder = $('#titleGp');//$title.parent()
				var _title = $.trim($title.text());
				if(_title.length > 50 || _title.length<2 || $title.hasClass('ph')){
					if(type == 'title' || type == null){
						$holder.addClass('me-error');
						if($title.hasClass('ph')){
							$title.removeClass('ph');
							$title.html('');
						}
						//$('#titleError').addClass('active');
					}
					ifPass = false;
					$intoView = $holder;
				}else{
					if(type == 'title' || type == null){
						$holder.removeClass('me-error');
						//$('#titleError').removeClass('active');
					}
				}
			},
			depart: function(){//出发地
				var cityid = $('[name="acCity"]').val();
				if(!cityid){
					if(type == 'depart' || type == null){
						$('#startGp').addClass('me-error');
					}
					$intoView = $intoView ? $intoView : $('#startGp');
					ifPass = false;	
				}else{
					if(type == 'depart' || type == null){
						$('#startGp').removeClass('me-error');
					}
				}
			},
			dest: function(){//目的地
				//var _destList = $('[name="event_dest_list"]').val()?JSON.parse($('[name="event_dest_list"]').val()):[];
				if($('#drList>li').length === 0){//$('#destInput').parent().siblings('.dest-box').length == 0
					if(type == 'dest' || type == null){
						$('#destGp').addClass('me-error');
					}
					$intoView = $intoView ? $intoView : $('#destGp');
					ifPass = false;
				}else{
					if(type == 'dest' || type == null){
						$('#destGp').removeClass('me-error');
					}
				}
			},
			date:function(){//行程日期
				var _minDate = $('#minWdate').val();
				var _maxDate = $('#maxWdate').val();
				if( _minDate== '' || _maxDate == '' || (new Date(_minDate)).getTime() > (new Date(_maxDate)).getTime()){
					if(type == 'date' || type == null){
						$('#dateGp').addClass('me-error');
					}
					$intoView = $intoView ? $intoView :$('#dateGp');
					ifPass = false;
				}else{
					if(type == 'date' || type == null){
						$('#dateGp').removeClass('me-error');
					}
				}
			},
			time: function(){//集合时间
				var $wrap = $('#timeGp');
		    	var $error = $('#timeGp .gp-error');
		    	var _hour =  $('#eHour').val();
		    	var _minute = $('#eMinute').val();
		    	
		    	var errText = '';
		    	if(_hour != '' || _minute != ''){
		    		if(!/\d/.test(_hour) || _hour.length>2 || _hour<0 || _hour> 23){
						errText += '小时数应介于 0 和 23 之间！';
						ifPass = false;
					}
					if(!/\d/.test(_minute)|| _minute.length>2 || _minute<0 || _minute> 59){
						if(targetId != 'eHour'){
							errText += '分钟数应介于 0 和 59 之间！';
						}
						ifPass = false;
					}

					if(type == 'time' || type == null){
						if(!ifPass && errText != ''){
							$error.text(errText);
							$wrap.addClass('me-error');
							ifPass = false;
							$intoView = $intoView ? $intoView :$wrap;
						}else{
							$wrap.removeClass('me-error');
						}
					}
		    	}else{
		    		$wrap.removeClass('me-error');
		    	}
				
			},
			amount: function(){//人数限制
				var amount = $('#amountLimit').val();
				var _max = parseInt($('#amountLimit').attr('data-max'));
				_max = _max > 16 ? _max:16;
				if(!/^(\d)+$/.test(amount) || (amount>16 && amount != _max) || amount < 2 || isNaN(amount)){
					//$('#amountLimit').val('');
					if(type == 'amount' || type == null){
						$('#amountGp').addClass('me-error');
					}
					ifPass = false;
					$intoView = $intoView ? $intoView : $('#amountGp');
				}else{
					if(type == 'amount' || type == null){
						$('#amountGp').removeClass('me-error');
					}
				}
			},
			types: function(){//活动类型
				if ($('#eventType .me-cb.active').length == 0) {
					if(type == 'types' || type == null){
						$('#typeGp').addClass('me-error');
					}
					ifPass = false;
					$intoView = $intoView ? $intoView : $('#typeGp');
				}else{
					if(type == 'types' || type == null){
						$('#typeGp').removeClass('me-error');
					}
				}
			}
		}
		
		for(var item in validate){
			validate[item]();
		}
		if(!ifPass){
			if(type == null){
				$intoView.get(0).scrollIntoView();
			}
			$('#releaseBtn').addClass('disabled');
			$('#releaseTip').addClass('active');
		}else{
			$('#releaseBtn').removeClass('disabled');
			$('#releaseTip').removeClass('active');
		}
		
		return ifPass;
	}
	//更新提交按钮状态
	function checkRelease(type, targetId){
		var $btn = $('#releaseBtn');
		if(validateForm(type, targetId)){
			$btn.removeClass('disabled');
		}else if(!$btn.hasClass('disabled')){
			$btn.addClass('disabled');
		}
	}

	//标题输入实时验证
	$('#topicTitle').keyup(function(){
		checkRelease('title');
	});
	//出发地实时验证
	$('.me-form').delegate('[name="acCity"], [name="city_id"]', 'change', function(){
		checkRelease('depart');
	});
    //集合时间实时验证
    $('#eHour, #eMinute').on('keyup', function(){
    	checkRelease('time', this.id);
    	if($('#cWdate').val() == ''){
    		var _minDate = $('#minWdate').val();
    		if(_minDate!= ''){
    			$('#cWdate').val(_minDate);
    		}else{
    			var _today = new Date();
    			_month = parseInt(_today.getMonth())+1;
    			_date = _today.getDate();
    			_today = _today.getFullYear() +'-'+ (_month>9?_month:'0'+_month) +'-'+ (_date>9?_date:'0'+_date);
    			$('#cWdate').val(_today);
    		}
    	}
    });
	//人数限制实时验证
	$('#amountLimit').keyup(function(e){
		checkRelease('amount');
	});
	//行程日期
    if($('#minWdate').length){
        var $minWdate=$dp.$('minWdate');
        var $maxWdate=$dp.$('maxWdate');
        $('#minWdate').focus(function(){
            WdatePicker({
                el: 'minWdate',
                skin: 'mfEvent2',
                onpicked:function(_data){
                    $maxWdate.focus();
                    set_title();
                   	//$('#cWdate').val(($(this).val()));
                    //checkRelease('date');
                },
                oncleared:function(){
                	checkRelease('date');
                },
                minDate: '%y-%M-%d'//'#F{$dp.$D(\'maxWdate\')}'
            });
        });
        $('#maxWdate').focus(function(){
            WdatePicker({
                el: 'maxWdate',
                skin: 'mfEvent2',
                onpicked:function(){
                    set_title();
                    checkRelease('date');
                    var collectTime = Date.parse($('#cWdate').val().replace('-','/'));
                    var endTime = Date.parse($(this).val().replace('-','/'));
                    if(collectTime!='' && collectTime>endTime){
                    	var _minDate = $('#minWdate').val();
                    	if(_minDate!=''){
                    		$('#cWdate').val(_minDate);
                    	}else{
                    		var _today = new Date();
			    			_month = parseInt(_today.getMonth())+1;
			    			_date = _today.getDate();
			    			_today = _today.getFullYear() +'-'+ (_month>9?_month:'0'+_month) +'-'+ (_date>9?_date:'0'+_date);
			    			$('#cWdate').val(_today);
                    	}
                    }
                },
                oncleared:function(){
                	checkRelease('date');
                },
                minDate:'#F{$dp.$D(\'minWdate\')}'
            });
        });
        $('#cWdate').focus(function(){
            WdatePicker({
                el: 'cWdate',
                skin: 'mfEvent2',
                onpicked:function(){console.log()
                    //set_title();
                    //checkRelease('date');
                },
                oncleared:function(){

                },
                minDate: '%y-%M-%d',
                maxDate: '#F{$dp.$D(\'maxWdate\')}'
            });
        });
    }
    //活动类型
    $('.me-cb').click(function(){       
        activeTypeNum = activeTypeNum ? activeTypeNum : 0;

        var $this = $(this);
        var $rel = $this.parent();
        var num = parseInt($rel.data('activeNum'));
        if(!num){
            num = 0;
        }
        
        if(!$this.hasClass('active') &&  activeTypeNum == 3){
            return;
        }
        $this.toggleClass('active');
        if($this.hasClass('active')){
            activeTypeNum++;
        }else{
            activeTypeNum--;
        }
        if(activeTypeNum > 2){
            $('#eventType').addClass('disabled');
        }else{
            $('#eventType').removeClass('disabled');
        }
        $rel.data('activeNum', num);
        checkRelease('types');
    });
	//产生标题
	var customTitle = false;
	function set_title() {
	 	if (customTitle) return;
	 	var $topTitle = $('#topicTitle');
	 	var title = $.trim($topTitle.text());
	 	var dest = get_dest()[1];
	 	if(!Date.parse($('#maxWdate').val())){
	 		var days = Math.ceil((Date.parse($('#maxWdate').val().replace('-','/')) - Date.parse($('#minWdate').val().replace('-','/'))) / (3600000 * 24)) + 1;
	 	}else{
	 		var days = Math.ceil((Date.parse($('#maxWdate').val()) - Date.parse($('#minWdate').val())) / (3600000 * 24)) + 1;
	 	}
	 	var tag = $('#eventType span.active:first').text();
	 	if (dest && days && tag) {
	 		title = dest + days + '天' + tag;
	 		$topTitle.text(title);
	 		var $editIcon = $topTitle.next();
	 		if($editIcon.hasClass('hide')){
	 			$editIcon.removeClass('hide');
	 		}
	 		$topTitle.removeClass('ph');
	 		checkRelease('title');
	 	}
	}
	//用户是否自定义标题
	$('#topicTitle').keyup(function(){
		var title = $.trim($('#topicTitle').text());

		if ( '' != title) {
			customTitle = true;
		} else {
			customTitle = false;
		}
	});
	$('#eventType').click(function(){
	 	set_title();		 	
	});
	//输入框默认提示
    $('[data-placeholder]').each(function(i, o){
    	var $target = $(o);
    	var phValue = $target.attr('data-placeholder');
    	$target.text(phValue);
    	$target.click(function(e){
    		if($.trim($target.text()) == phValue){
    			$target.text('').removeClass('ph');
    		}
    	});
    });
    var $eventContent = $('#eventContent');//编辑框
	if($wrap.hasClass('me-wrap-add') || $wrap.hasClass('me-wrap-update')){//发布活动页，修改活动页	
		
		// 发布
		$('#releaseBtn').click(function(e){
			e.preventDefault();
			var $this = $(this);
			if($this.hasClass('ing')){
				return;
			}
			if(validateForm(null, true)){
				$this.addClass('ing');
				if($wrap.hasClass('me-wrap-add')){
					//是否需要短信验证
					$.ajax({
						url: "ajax_is_need_verification",
						type: 'get',
						success: function(data){
							if(data == 1){
							
								$('.verify-modal, .me-cover').show();
								$('#releaseBtn').data('ifNeedVerify', true);
							}else{
								releaseEvent();
							}
						},
						error: function(){
							alert('发布失败，请稍后重试');
							$this.removeClass('ing');
						}
					});
				}
			}
		});
		// function releaseEvent(){
		// 	alert('表单调用');return
		// 	var $releaseBtn = $('#releaseBtn');
		// 	//集合时间
		// 	var _gatherTime = $('#cWdate').val();
		// 	var _hour = $('#eHour').val();
		// 	var _minute = $('#eMinute').val();
		// 	if(_hour != '' && _minute != ''){
		// 		_hour = _hour.length < 2 ? '0'+_hour: _hour;
		// 		_minute = _minute.length < 2 ? '0'+_minute: _minute;
		// 		_gatherTime += ' ' +  _hour + ':' + _minute;
		// 	}
		// 	var _cityId = $('[name="acCity"]').val();
		// 	// 提交表单
			
		// 	var topic = {
		// 		tagId: get_tagid(),
		// 		title: $('#topicTitle').text(),
		// 		type_first: $('#eventType span.active:first').text(),
		// 		content: get_content(),
		// 		departure: _cityId,
		// 		departure_name: $('[name="acCity"]').find('option[value="'+ _cityId +'"]').text(),
		// 		dest: get_dest()[2],
		// 		dest_name: get_dest()[1],
		// 		begin_date: $('#minWdate').val(),
		// 		end_date: $('#maxWdate').val(),
		// 		gather_date: _gatherTime,
		// 		member_limit: $('#amountLimit').val(),
		// 		fee_type: $('#eventFee > div.active').attr('data-id'),
		// 		pub_forum_id: $('#syncForm').hasClass('checked') ? $('#formSelect').val(): '',
		// 		pub_city_id: $('#syncAdr').hasClass('checked') ? $('[name="adrSelect2"]').val(): '',
		// 		pub_group_id: $('#syncGroup').hasClass('checked') ? $('#groupSelect').val(): ''
		// 	};
		// 	if($('#releaseBtn').data('ifNeedVerify')){
		// 		topic.mobile_verification = $('#mbCode').val();
		// 	}
		// 	var url = '';
		// 	var message =  '';
		// 	var node_id  = '';
		// 	if ($wrap.hasClass('me-wrap-add')) {
				
		// 		url = 'http://www.doyouhike.net/event/yueban/do_publish';
		// 	} else {

		// 		url = 'http://www.doyouhike.net/event/yueban/do_update/' + location.pathname.split('/').pop();
		// 	}
		// 	alert(2)
		// 	//console.log(topic);return;
		// 	$.post(
		// 		url,
		// 		topic,
		// 		function(data, status) {
		// 			data=jQuery.trim(data);
		// 			if($('#releaseBtn').data('ifNeedVerify')){
		// 				$('.verify-modal, .me-cover').hide();
		// 			}
		// 			if (parseInt(data) > 0) {
		// 				$releaseBtn.data('isReleaseOk', true);//flag for window refresh or close
		// 				var topic_link =$releaseBtn.attr('topic_link');

		// 				if(topic_link == '')
		// 				{
		// 					location.href = 'adddo'+data ;
		// 				}else
		// 				{
		// 					location.href = 'adddo'+topic_link+data ;
		// 				}

		// 			} else if ('bad_word' == data) {
		// 				$releaseBtn.removeClass('ing');
		// 				alert('发布失败，内容包含敏感词。');
		// 			}else if('frequently' == data)
		// 			{
		// 				$releaseBtn.removeClass('ing');
		// 				alert('为了营造良好的社区氛围，不能频繁发布过多活动。');
		// 			}else if('error_Number_limit' == data)
		// 			{
		// 				$releaseBtn.removeClass('ing');
		// 				alert('活动修改人数上限不得小于确定报名人数。');
		// 			}
		// 			else {
		// 				$releaseBtn.removeClass('ing');
		// 				alert('发布失败，请您稍后再尝试。');							
		// 			}						
		// 		},
		// 		'text'
		// 	);
		// }
		/**
		 * 添加注意事项
		 */
		 $('.addon .tool-btn').click(function(){
		 	//$('#eventContent').click();
		 	//var imgPos =  $('#eventContent').data('caretHolder');
		 	var _insertContent = $(this).prev('div').html()+'<br>';
          	/*if(imgPos){
          		if($(imgPos).find('img').length>0 || $(this.imgPos).text()!=''){
          			var $newImgPos = $(_insertContent);
          			$newImgPos.insertAfter($(imgPos));
          			$('#eventContent').data('caretHolder',$newImgPos.get(0));
          		}else{
          			$(imgPos).html(_insertContent);
          		}
          	}else{
          		$(_insertContent).appendTo($('#eventContent'));
          	}*/
          	var $last = $eventContent.children().last();
          	if($last.is('div') && $last.text() == '' && $last.find('img').length < 1){
          		$last.html(_insertContent);
          	}else{
          		$eventContent.append($(_insertContent));
          	}
          	//$('#eventContent').append($('<div></div>'));
		 	//$eventContent.children().last().get(0).focus();
		 	set_focus($eventContent);
		 });

		 // /**
		 //  * 获取格式化内容
		 //  */
		 // function get_content() {
			// var _content = [];			

			// //获得编辑器实例
   //      	var publisharea =  $("#eventContent2").sceditor('instance');//console.log(publisharea.getWysiwygEditorValue(true));return;
   //      	$eventContent.find('img').removeAttr('width').removeAttr('height');
   //      	publisharea.setWysiwygEditorValue($eventContent.html());
   //      	var contents = publisharea.getWysiwygEditorValue(true);
   //      	var contentsArr = contents.split('\n');  
   //      	for(var i=0,len=contentsArr.length; i<len; i++){
   //      		var ct = contentsArr[i];
   //      		var obj = {};
   //      		var textObj = null;
   //      		if(/\[img\](.)+\[\/img\]/.test(ct)){//判断是否为图片
   //      			ct = ct.replace(/\[img\]|\[\/img\]/g, '');
   //      			if(ct.indexOf('?id') > -1){
   //      				var qry = ct.split('?id=')[1];
   //      				if(qry.indexOf('&new=') > -1){
   //      					var _imgId = qry.split('&new=')[0];
	  //                       var _rest = qry.split('&new=')[1];
	  //                       var _new = _rest.split('&')[0];
	  //                       var _txt = _rest.split('&')[1];
   //      					if(_new){
   //      						obj.is_new = _new;
   //      					}
   //      					if(_txt){
	  //                       	var textObj = {
	  //                       		text: _txt+'\n'
	  //                       	}
	  //                       }
   //      				}else{
   //      					var _imgId = qry;
   //      				}
   //      				obj.photo_id = _imgId;
   //      			}
   //      		}else{
   //      			obj.text = ct == '' ? '\n' : ct + '\n';
   //      		}
   //      		_content.push(obj);
   //      		if(textObj){
	  //           	_content.push(textObj);
	  //           }
   //      	}
   //      	return JSON.stringify(_content);
		 // }

		/**
		 * 获取目的地
		 */
		// function get_dest() {
		// 	var dests = '';
		// 	var dest_name = '';
		// 	var dest_array = new Array();
		// 	$('#drList>li').each(function(i, o){
		// 		var $o = $(o);
		// 		var _id = $o.attr('data-id');
		// 		var _name = $o.attr('data-name');
		// 		if(_id == 'undefined'){
		// 			_id = _name;
		// 		}
		// 		dests += _id+ ',';
		// 		dest_name += _name+ '-';
		// 		dest_array[i]={
		// 			'id':_id,
		// 			'name':_name
		// 		};
		// 	});
		// 	if ('' != dests) {
		// 		dests = dests.slice(0, -1);
		// 		dest_name = dest_name.slice(0, -1);
		// 	}

		// 	return [dests, dest_name,dest_array];
		// }

		/**
		 * 获取选中分类
		 */
		function get_tagid() {
			var ids = '';
			$('#eventType span.active').each(function(){
				ids += $(this).attr('data-id') + ',';				
			});
			if ('' != ids) {
				ids = ids.slice(0, -1);
			}
			
			return ids;
		}
		
		//编辑内容对黏贴内容过滤
		$eventContent.on('paste', function(e){
			var $this = $(this);
			if(this._timeoutId){
				clearTimeout(this._timeoutId);
			}
			this._timeoutId = setTimeout(function(){
				$this.find('img:not(.mf)').remove();
			}, 100);
		});
		
		//上传图片
	    var uploader = new plupload.Uploader({
	        // General settings
	        runtimes : 'silverlight,html4',
	        browse_button : 'pickImg', // you can pass in id...
	        url : '/event/yueban/upload_image/',
	        chunk_size : '1mb',
	        unique_names : true,
	        // Resize images on client-side if we can
	        resize : { width : 320, height : 240, quality : 90 },
	        filters : {
	            max_file_size : '2mb',
	            // Specify what files to browse for
	            mime_types: [
	                {title : "Image files", extensions : "jpg"}
	            ]
	        },      
	        flash_swf_url : '../js/Moxie.swf',
	        silverlight_xap_url : '../js/Moxie.xap',         
	        // PreInit events, bound before the internal events
	        preinit : {
	            Init: function(up, info) {
                    $('#photoModal').removeClass('active');//for ie bug,the photoadd btn need to be show in the begin and hidden then
	                // console.log('[Init]', 'Info:', info, 'Features:', up.features);
	            },
	            UploadFile: function(up, file) {
	                // console.log('[UploadFile]', file);
	              	//static.doyouhike.net/images/leech.gif
	              	
	              	this.lodingId = (new Date()).getTime();
	              	this.imgPos =  $eventContent.data('caretHolder');
	              	var $imgPos = $(this.imgPos);
	              	if(this.imgPos){
	              		if($imgPos.find('img').length>0 || $imgPos.text()!=''){
	              			var $newImgPos = $('<div><img contentEditable="false" src="'+ MISC_PATH +'images/leech.gif" class="uploading" data-id="'+ this.lodingId +'"/><br></div>');
	              			$newImgPos.insertAfter($(this.imgPos));
	              			$eventContent.data('caretHolder',$newImgPos.get(0));
	              			set_focus($newImgPos);
	              		}else{
	              			$imgPos.html('<img contentEditable="false" src="'+ MISC_PATH +'images/leech.gif" class="uploading" data-id="'+ this.lodingId +'"/><br>');
	              			set_focus($imgPos);
	              		}
	              	}else{
	              		$('<div><img contentEditable="false" src="'+ MISC_PATH +'images/leech.gif" class="uploading" data-id="'+ this.lodingId +'"/></div><br>').appendTo($('#eventContent'));
	              		set_focus($eventContent);
	              	}
	                
	                //$('<img src="http://static.doyouhike.net/images/leech.gif" class="uploading" data-id="'+ (new Date()).getTime() +'"/>').appendTo($('#eventContent'));
	                // You can override settings before the file is uploaded
	                // up.setOption('url', 'upload.php?id=' + file.id);
	                // up.setOption('multipart_params', {param1 : 'value1', param2 : 'value2'});
	                
	                $('#photoModal').removeClass('active');
	            }
	        },
	        init : {
	            Browse: function(up) {
	                // Called when file picker is clicked
	                 //console.log('[Browse]');
	            },
	            BeforeUpload: function(up, file) {
	                // Called right before the upload for a given file starts, can be used to cancel it if required
	                // console.log('[BeforeUpload]', 'File: ', file);
	            },
	            UploadProgress: function(up, file) {
	                // Called while file is being uploaded
	                // console.log('[UploadProgress]', 'File:', file, "Total:", up.total);
	                var _pct = parseInt(file.loaded/file.size*100); 
	                // console.log(file)
	                var $target = $('#leProgress').children();
	                $target.css('width', _pct + '%').text(_pct + '%');
	            },
	            FilesAdded: function(up, files) {
	                // Called when files are added to queue
	                // console.log('[FilesAdded]');
	 
	                plupload.each(files, function(file) {
	                	// console.log(file.getSource())
	                    // console.log('  File:', file);
	                });
	                uploader.start();
	                $('.photo-tip').addClass('hidden');
	                $('#leProgress').addClass('active');
	            },
	            FileUploaded: function(up, file, info) {
	                // Called when file has finished uploading
	                // console.log(info);
	                var response = jQuery.parseJSON(info.response);
	                // console.log(response.code);
	                if (0 == response.code) {
	                	$('#eventContent img.uploading[data-id="'+ this.lodingId +'"]').replaceWith('<img class="mf" contentEditable="false" src="'+ response.imgURL +'?id='+ response.photoID +'&new='+ 1 +'&" />');
	                	//var is_new = $wrap.hasClass('me-wrap-update') ? 1 : 0;
	                	//$('<div><img class="mf" src="'+ response.imgURL +'?id='+ response.photoID +'&new='+ 1 +'" /></div>').appendTo($('#eventContent'));
	                	
	                }
	                // var _res = info.response.replace('"{', '{').replace('}"', '}');
	                // var objResponse = $.parseJSON(_res);
	                // console.log(objResponse.code);
	                //success
	                // if(objResponse.code == '0'){
	                //     var _imgUrl = objResponse.data.imgURL;
	                //     $("#race_img").val(objResponse.data.photoID_temp);
	                //     previewImg(_imgUrl);
	                // }
	                // console.log(objResponse);
	            },
	            UploadComplete: function(up, files,info) {
	                // Called when all files are either uploaded or failed
	                // console.log('[UploadComplete]');
	                // console.log(files)
	            },
	            Destroy: function(up) {
	                // Called when uploader is destroyed
	                // console.log('[Destroy] ');
	            },
	            Error: function(up, args) {
	                // Called when error occurs
	                console.log('[Error] ', args);
	                if(args.code == plupload.FILE_SIZE_ERROR){
	                	alert('无法上传超过2M的图片')
	                }else{
	                	alert('无法上传图片')
	                }
	            }
	        }
	    });
	    uploader.init();
		
	}
	if($wrap.hasClass('me-wrap-update')){  // 修改活动页
		
		if (1 == $('#topicTitle').attr('data-custom')){
			customTitle = true;
		}

		/**
		 * 默认活动类型
		 * @param array tags 
		 */
		 var activeTypeNum = $('#eventType span.active').length;
		 if(activeTypeNum>2){
		 	$('#eventType').addClass('disabled');
		 }
		 function tag_value(tags) {
		 	for (i in tags) {
		 		$('#eventType span').each(function(){
		 			if(tags[i]['tag_id'] == $(this).attr('data-id')) {
		 				$(this).addClass('active');
		 				activeTypeNum++;
		 				if (activeTypeNum == 3) {
		 					$('#eventType').addClass('disabled');
		 				}
		 				return;
		 			}
		 		});
		 	}
		 }
	}
	
    //检验集合时间是否正确
    function checkTime(ifShowError, eleId){
    	var $wrap = $('#timeGp');
    	var $error = $('#timeGp .gp-error');
    	var _hour =  $('#eHour').val();
    	var _minute = $('#eMinute').val();
    	
    	var errText = '';
    	var ifPass = true;

		if(!/\d/.test(_hour) || _hour.length>2 || _hour<0 || _hour> 23){
			errText += '小时数应介于 0 和 23 之间！';
			ifPass = false;
		}
		if(!/\d/.test(_minute)|| _minute.length>2 || _minute<0 || _minute> 59){
			if(eleId != 'eHour'){
				errText += '分钟数应介于 0 和 59 之间！';
			}
			ifPass = false;
		}
		if(ifShowError){
			if(!ifPass && errText != ''){
				$error.text(errText);
				$wrap.addClass('me-error');
			}else{
				$wrap.removeClass('me-error');
			}
		}
		return ifPass;
    }
    
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
    
    //图片选择
    (function initPhotoModal(){
    	var $albumList = $('#albumList');
    	var $modal = $('#photoModal');
    	$("#openPhotoModal").click(function(e){
	    	e.preventDefault();
	    	e.stopPropagation();
	    	$modal.toggleClass('active');
	    	if(!$modal.data('ifAlbumInit')){
	    		//获取相册数据
			    $.get(
				  '/event/yueban/get_albums',
				  function(data, status){
				  	if(data.code == 0){
				  		var result = data.data;
				  		var _html = '';
				  		if(result.length>0){
				  			for(var i=0,len= result.length; i<len; i++){
					  			var obj = result[i];
					  			var name = obj.Name;
					  			var id = obj.SetID;
					  			/*if(name == '默认相册'){
					  				_html = '<li class="active" data-id="'+id+'">'+name+'</li>'+_html;
					  			}else{
					  				_html += '<li data-id="'+id+'">'+name+'</li>';
					  			}*/
					  			if(name == '默认相册'){
					  				_html += '<option selected value="'+id+'">'+name+'</option>';
					  			}else{
					  				_html += '<option value="'+id+'">'+name+'</option>';
					  			}
					  		}
					  		$albumList.html(_html);
					  		//$('#toggleAlbum').addClass('active');
					  		bindAlbumSelect();
				  		}else{
				  			$photolist.html('相册为空')
				  		}
				  	}else{
				  		$photolist.html('无法加载，请检查网络');
				  	}
				  },'json'
				);
				$modal.data('ifAlbumInit', true);
	    	}
	    });	
	    
		var $arrow = $('#toggleAlbum .icon-arrow');
		var $albumText = $('#toggleAlbum span');
	    $('#toggleAlbum').click(function(){
	    	$arrow.toggleClass('down');
	    	$albumList.toggleClass('active');
	    });
	    var albumObj = {}
	    //相册选择
	    function bindAlbumSelect(){
	    	albumObj = {
	    		album_id: $albumList.val(),
		  		page: 1,
		  		page_size: 15
	    	}
	    	/*$albumList.find('li').click(function(){
	    		var $this = $(this);
	    		$albumText.text($this.text());
		  		$albumList.removeClass('active');
		  		$arrow.toggleClass('down');
	    		if($this.hasClass('active')) return;
	    		$photolist.data('ifInit', false);
	    		$this.addClass('active').siblings().removeClass('active');
		  		albumObj.album_id = $this.attr('data-id');
		  		getPhoto(albumObj);
		  	});*/
		  	$albumList.change(function(e){
		  		$photolist.data('ifInit', false);
		  		albumObj.album_id = this.value;
		  		getPhoto(albumObj, 1);
	    	});
		  	getPhoto(albumObj);
	    }
	    
	    var $photoload = $('#plLoad');
	    var $photolist = $('#plList');
	    //获取图片数据
	    function getPhoto(postObj, page){
	    	if(typeof page == 'number'){
	    		postObj.page = page;
	    	}
	    	$photoload.addClass('active');
	    	$photolist.html('');
	    	$.ajax({
				url: '/event/yueban/get_album_photos',
				data: postObj,
				dataType: 'json',
				type: 'post',
				success: function(data){
					if(data.code == 0){
						var result = data.data;
						var totalCount = result.total_record;
						var _html = '';
						if(totalCount>0){
							$('#photoPage').show();
							result = result.list;
							for(var i=0,len=result.length; i<len; i++){
								var obj = result[i];
						    	_html += '<li data-id="'+ obj.PhotoID +'" data-src="'+ obj.Path +'"><img src="'+ obj.PathMedium +'" alt=""><p class="add-tip"><span>添加</span></p></li>';
						    }
						    if(!$photolist.data('ifInit')){
						    	initPage($('#photoPage'), totalCount, postObj.page_size, function pageselectCallback(page_index) {
									if($photolist.data('ifInit')){
										page_index++;
										getPhoto(albumObj, page_index);
									}else{
										$photolist.data('ifInit', true);
									}
									
								},4);
						    }
						}else{
							_html = '<p>相册为空，可直接添加本地图片</p>';
							$('#photoPage').hide();
						}
					}else{
						var _html = '<p>无法加载相册，请检查网络</p>';

					}
					$photoload.removeClass('active');
					$photolist.html(_html);
				},
				error: function(_data){

				}
			});
	    }
	    //选择图片
	    $photolist.delegate('li','click', function(){
	    	var $this = $(this);
	    	var _id = $this.attr('data-id');
	    	var _src = $this.attr('data-src');
	    	var imgPos =  $eventContent.data('caretHolder');
          	if(imgPos){
          		var $imgPos = $(imgPos);
          		if($imgPos.find('img').length>0 || $imgPos.text()!=''){
          			var $newImgPos = $('<div><img class="mf" src="'+ _src +'?id='+ _id +'&new=0&" /><br></div>');
          			$newImgPos.insertAfter($(imgPos));	
          			$eventContent.data('caretHolder', $newImgPos.get(0));
          			set_focus($newImgPos);
          		}else{
          			$imgPos.html('<img class="mf" src="'+ _src +'?id='+ _id +'&new=0&" /><br>');
          			set_focus($imgPos);
          		}
          	}else{
          		$('<div><img class="mf" src="'+ _src +'?id='+ _id +'&new=0&" /><br></div>').appendTo($eventContent);
          		set_focus($eventContent);
          	}
	    	//$('<div><img class="mf" src="'+ _src +'?id='+ _id +'&new=0" /></div>').appendTo($('#eventContent'));
	    	
	    	$('#photoModal').removeClass('active');
	    });
	    //关闭照片弹框
	    $(document).click(function(e){
	    	if($modal.hasClass('active') && !$(e.target).closest('#photoModal').length){
	    		$('#photoModal').removeClass('active');console.log($(e.target))
	    	}
	    });
    })();
    //获取编辑框光标位置容器
    function getCaretParent(eleId){
    	if (typeof window.getSelection != "undefined") {
		  var range = window.getSelection().getRangeAt(0);
		  var selected = range.toString().length; // *
		  var preCaretRange = range.cloneRange();
		  preCaretRange.selectNodeContents(document.getElementById(eleId));
		  preCaretRange.setEnd(range.endContainer, range.endOffset);

		  if(selected){ // *
		    caretOffset = preCaretRange.toString().length - selected; // *
		  } else { // *
		    caretOffset = preCaretRange.toString().length; 
		  } // *

		  if(preCaretRange.endContainer.nodeName == '#text'){
				return preCaretRange.endContainer.parentNode;
			}else{
				return preCaretRange.endContainer;
			}
		}
		
		//return preCaretRange.endContainer.parentNode;
    }
    $eventContent.on('keyup click', function(e){
    	var $this = $(this);
    	var caretHolder = getCaretParent('eventContent');
    	if(caretHolder && caretHolder.id == 'eventContent'){
    		caretHolder = null;
    	}
    	$this.data('caretHolder', caretHolder);
    });
    //刷新或关闭页面
    window.onbeforeunload = function(e) {
    	if(!$('#releaseBtn').data('isReleaseOk')){
    		return '离开页面将丢失所输入的内容';
    	}
	};
    //store onbeforeunload for later use
    $(window).data('beforeunload',window.onbeforeunload);  

      //remove||re-assign onbeforeunload on hover 
    $('#photoModal').delegate('a[href^="javascript:"]','mouseenter', function(e){
        window.onbeforeunload=null;
             
    });
    $('#photoModal').delegate('a[href^="javascript:"]','mouseout', function(e){
        window.onbeforeunload=$(window).data('beforeunload');
    });
	$('[placeholder]').placeholder();
	//焦点定位到输入框文字最末尾
    function set_focus(el) {
        el = el[0]; // jquery 对象转dom对象
        el.focus();
        /*if(el.createTextRange){console.log(1)
        	var range = el.createTextRange();
            range.move('character', 6);
            range.select();
        } else if (el.selectionStart) {console.log(2)
            el.focus();
            el.setSelectionRange(6, 6);
        }else */if (document.selection && document.selection.createRange){//console.log(3)//el.createTextRange) {
            var rng;
            el.focus();
            rng = document.selection.createRange();
            rng.moveStart('character', -el.innerText.length);
            var text = rng.text;
            for (var i = 0; i < el.innerText.length; i++) {
                if (el.innerText.substring(0, i + 1) == text.substring(text.length - i - 1, text.length)) {
                    result = i + 1;
                }
            }
        } else if (document.createRange) {//console.log(4)
            var range = document.createRange();
            range.selectNodeContents(el);
            range.collapse(false);
            var sel = window.getSelection();  
            sel.removeAllRanges();
            sel.addRange(range);
        }
        var caretHolder = getCaretParent('eventContent');
    	if(caretHolder && caretHolder.id == 'eventContent'){
    		caretHolder = null;
    	}
    	$eventContent.data('caretHolder', caretHolder);
        //$('#test').attr('contentEditable', false)
    }
    //活动目的地
    (function(){
    	var $active = null,
	        $dialog = $('.ed-list-dialog'),
	        $search = $dialog.find('input').eq(0),
	        $destList = $dialog.find('.dest-list li'),
	        $routeList = $dialog.find('.route-list li'),
	        activeIdx = 0,
	        $activeList = null;

	    function reInit() {
	        $active = null,
	        $dialog = $('.ed-list-dialog'),
	        $search = $dialog.find('input').eq(0),
	        $destList = $dialog.find('.dest-list li'),
	        $routeList = $dialog.find('.route-list li'),
	        activeIdx = 0,
	        $activeList = null;
	    }

	    function keyboardSelect(e) {
	        switch (e.which) {
	            case 40: //down
	                if (!$active) {
	                    if ($destList.length > 0) {
	                        $activeList = $destList;
	                    } else if ($routeList.length > 0) {
	                        $activeList = $routeList;
	                    }
	                } else {
	                    if ($activeList == $routeList && activeIdx + 2 <= $activeList.length - 1) {
	                        activeIdx += 2;
	                    }
	                    if ($activeList == $destList) {
	                        if (activeIdx + 4 > $activeList.length - 1) {
	                            if ($routeList.length > 0) {
	                                activeIdx = 0;
	                                $activeList = $routeList;
	                            }
	                        } else {
	                            activeIdx += 4;
	                        }
	                    }
	                }
	                break;
	            case 38: //up
	                if ($activeList == $destList && activeIdx - 4 >= 0) {
	                    activeIdx -= 4;
	                }
	                if ($activeList == $routeList) {
	                    if (activeIdx - 2 >= 0) {
	                        activeIdx -= 2;
	                    } else if ($destList.length > 0) {
	                        activeIdx = 0;
	                        $activeList = $destList;
	                    }
	                }
	                break;
	            case 37: //left
	                if ($activeList == $routeList && activeIdx == 0 && $destList.length > 0) {
	                    activeIdx = 0;
	                    $activeList = $destList;
	                }
	                if (activeIdx > 0) {
	                    activeIdx -= 1;
	                }
	                break;
	            case 39: //right
	                if ($activeList == $routeList && activeIdx < $routeList.length - 1) {
	                    activeIdx += 1;
	                }
	                if ($activeList == $destList && activeIdx < $destList.length - 1) {
	                    activeIdx += 1;
	                } else if ($activeList == $destList && $routeList.length > 0) {
	                    activeIdx = 0;
	                    $activeList = $routeList;
	                }
	                break;
	        }
	        if ($activeList) {
	            $active = $activeList.eq(activeIdx);
	        }
	        $destList.removeClass('active');
	        $routeList.removeClass('active');
	        if ($active) {
	            $active.addClass('active');
	            var _name = $active.attr('data-NodeName');
	        	var _id = $active.attr('data-nodeid');
	            $search.val($active.attr('data-NodeName')).attr({
		        	'data-id': _id,
		        	'data-name': _name
		        });
	        }
	    }

	    function objToHtml(keyword, obj, type) {
	        var trees = obj.tree.split('>>'),
	            mainCity = trees[trees.length - 2],
	            _replace = '<em>' + keyword + '</em>',
	            newName = obj.NodeName.replace(keyword, _replace),
	            newSlug = obj.NodeSlug.replace(keyword, _replace),
	            _html = '';

	        _html += '<li data-NodeID="' + obj.NodeID + '" data-NodeName="' + obj.NodeName + '" data-NodeSlug="' + obj.NodeSlug + '"><p>' + newName + (mainCity ? ('&nbsp;&nbsp;-&nbsp;&nbsp;' + mainCity) : '') + '</p>';

	        if (obj.NodeCat != 'route') {
	            _html += '<p class="e">' + newSlug + '</p>';
	        }
	        _html += '</li>';
	        return _html;
	    }
	    $('.dr_add_wrap').delegate('.ed-list-dialog', 'click', keyboardSelect);
	    $dialog.on('keydown', keyboardSelect);
	    //已选择活动目的地
	    var _destList = $('[name="event_dest_list"]').val() ? JSON.parse($('[name="event_dest_list"]').val()) : [];
	    var destArr = [];
	    $('#drList>li').each(function(i, o) {
	        var destObj = {};
	        destObj.destId = $(o).attr('data-id');
	        destObj.destName = $(o).attr('data-name');
	        destArr.push(destObj);
	    });
	    if (!_destList.length && 　$('#rel_dest').length && $('#rel_dest').val() != '') {
	        var str = $('#rel_dest').val().split(',');
	        var relObj = {
	            DestName: str[2],
	            NodeSlug: str[1],
	            DestID: str[0],
	            ShowRoute: '0',
	            ifRoute: 0
	        }
	        _destList.push(relObj);
	        $('[name="event_dest_list"]').val(JSON.stringify(_destList));
	    }
	    if (_destList.length) {
	        for (var i = 0; i < _destList.length; i++) {
	            var obj = _destList[i];
	            var _html = '<li data-idx="' + i + '"><span>' + obj.DestName + '</span><ul class="select"><li class="dr_delete"><span>删除</span></li>';
	            _html += '</ul></li>';
	            $(_html).appendTo($('#drList'));
	        }
	    }

	    //活动目的地输入
	    $search.keyup(function(e) {
	        if (/(38|40|37|39)/.test(e.which)) return;
	        var keyword = $(this).val();
	        if (e.which == 13 && keyword != '') {
	            checkDestList();
	        } else {
	            if (keyword == '') {
	                $('.dest-list, .route-list').hide()
	            } else {
	            	_token=$('input[name="_token"]').val();
	                $.post('/api/place/auto_output_nodes', {
	                    node_name: keyword,_token:_token
	                }, function(data) {
	                    var _cityHtml = '',
	                        _routeHtml = '';
	                    if (data.node.length > 0) {
	                        for (var i = 0; i < data.node.length; i++) {
	                            var _obj = data.node[i];
	                            if (_obj.NodeCat != 'route') {
	                                _cityHtml += objToHtml(keyword, _obj);
	                            } else {
	                                _routeHtml += objToHtml(keyword, _obj);
	                            }
	                        }
	                        if (_cityHtml != '') {
	                            $('.dest-list').html(_cityHtml).show();
	                        }
	                        if (_routeHtml != '') {
	                            $('.route-list').html(_routeHtml).show();
	                        }
	                        reInit();
	                    } else {
	                        $('.dest-list').hide();
	                    }
	                });
	            }
	        }
	    });
	    $('.dest-list, .route-list').delegate('>li', 'click', function() {
	        $active = $(this);
	        $active.addClass('active');
	        var e = $.Event("keyup");
	        e.which = 13;
	        var _name = $active.attr('data-NodeName');
	        var _id = $active.attr('data-nodeid');
	        $search.val($active.attr('data-NodeName')).attr({
	        	'data-id': _id,
	        	'data-name': _name
	        }).trigger(e);
	        $('.ed-list-dialog').hide(600);
	    });
	    //已选项下拉
	    $('.dr_list').delegate('li', 'click', function(e) {
	        e.stopPropagation();
	        $(this).siblings().removeClass('toggle');
	        $(this).toggleClass('toggle');
	    });
	    //删除
	    $('.dr_list').delegate('.dr_delete', 'click', function(e) {
	        var $target = $(this).parent().parent();
	        var _idx = parseInt($target.attr('data-idx'));
	        for (var i = _idx + 1; i < _destList.length; i++) {
	            $('.dr_list>li').eq(i).attr('data-idx', i - 1)
	        }
	        var _deleteObj = _destList[_idx];
	        _destList.splice(_idx, 1);
	        $('[name="event_dest_list"]').val(JSON.stringify(_destList));
	        $target.remove();
	        checkRelease('dest');
	    });
	    $('.ed-list-dialog').click(function(e) {
	        e.stopPropagation();
	    });
	    $(document).click(function(e) {
	        $('.dr_list>li').removeClass('toggle');
	        $('.ed-list-dialog').hide(600);
	    });
	    $('#addEventDestBtn').click(function(e) {
	        e.stopPropagation();
	        $('.ed-list-dialog').show(600);
	        $search.focus();
	    });
	    $('#drSure').click(function() {
	        var e = $.Event("keyup");
	        e.which = 13;
	        $search.trigger(e);
	        $('.ed-list-dialog').hide(600);
	    });

	    function checkDestList(obj) {
	        var _flag = false;
	       	var _name = $search.attr('data-name') ? $search.attr('data-name'): $search.val();
	       	var _id = $search.attr('data-id')?$search.attr('data-id'):'undefined';
	       	$('#drList>li').each(function(i, o){
				if($(this).attr('data-id') == _id && $(this).attr('data-name') == _name){
					_flag = true;
				} 
			});
	        if (!_flag) {
	            var _html = '<li data-id="' + _id + '" data-name="' + _name + '"><span>' + _name + '</span><ul class="select"><li class="dr_delete"><span>删除</span></li>';
	            _html += '</ul></li>';
	            var $html = $(_html).appendTo($('#drList'));
	            $search.val('').attr({
	            	'data-id': '',
	            	'data-name': ''
	            });
	            $('.dest-list, .route-list').html('').hide();
	            $('.ed-list-dialog').hide(600);
	            checkRelease('dest');
	            reInit();
	        }
	        //$('[name="event_dest_list"]').val(JSON.stringify(_destList));
	        $('#destGp').removeClass('me-error');
	    }
    })();

    //短信验证
  //   $('#vertifyText').keyup(function(e){//输入实时验证
  //   	var $this = $(this);
  //   	var _vertifyText = $.trim($this.val());
  //   	var reg = /^[0-9a-zA-Z]{5}$/;
  //   	$('#verifyTip').text('');
  //   	$('#vmIconOk').removeClass('active');
  //   	var $verifyBtn = $('#mobileVerify');
  //   	if(reg.test(_vertifyText)){
  //   		$this.data('isRequesting', true);
  //   		$.ajax({
		// 		type: 'GET',
		// 		dataType: 'JSON',
		// 		url: 'verification',
		// 		data: {verification: _vertifyText},
		// 		success: function(data){
		// 			if(data.status == '200'){
	 //    				$this.parent().removeClass('wrong').addClass('right');
	 //    				if(!$('#mobileVerify').hasClass('counting')){
	 //    					$verifyBtn.addClass('active');
	 //    				}
	 //    			}else{
	 //    				$this.parent().removeClass('right').addClass('wrong');
	 //    				$('#verifyTip').text(data.message);
	 //    				$verifyBtn.removeClass('active');
	 //    			}
	 //    			$this.data('isRequesting', false);
	 //    		},
	 //    		error: function(){
	 //    			$this.data('isRequesting', false);
	 //    		}
	 //    	});
  //   	}else{
  //   		$this.parent().removeClass('wrong right');
  //   		$verifyBtn.removeClass('active');
  //   	}
  //   })
  //   //获取短信验证码
  //   $('#mobileVerify').click(function(e){
		// var $this = $(this);
		// var $vertifyText = $('#vertifyText');
  //   	var _vertifyText = $.trim($vertifyText.val());
  //   	var $mobileBackTip = $('#mobileBackTip');

    	
  //   	//clearTimeout($mobileBackTip._timeout);
  //   	if($vertifyText.data('isRequesting')){
  //   		$('#verifyTip').text('操作失败，请稍后重试');
  //   	}else{
  //   		if($this.hasClass('active')){
		// 		$this.removeClass('active').addClass('loading');
		// 		$mobileBackTip.hide();
		// 		$.ajax({
		// 			type: 'GET',
		// 			dataType: 'JSON',
		// 			url: '/event/yueban/send_msg',
		// 			data: {verification: _vertifyText},
		// 			success: function(data){
		// 				$this.removeClass('loading');
		// 				if(data.status == 200){
		// 					var _time = 60;
		// 					var $btntext = $this.find('span');
		// 					var count = function(){
		// 						clearTimeout($this.timeoutId);
		// 						$btntext.text(_time+'s');
		// 						$this.timeoutId = setTimeout(function(){
		// 							_time--;
		// 							if(_time == 0){
		// 								$this.addClass('active').removeClass('counting');
		// 								$btntext.text('获取短信验证码');
		// 							}else{
		// 								count();
		// 							}
		// 						},1000);
		// 					}
		// 					$this.addClass('counting');
		// 					count();
		// 					$mobileBackTip.text(data.message).fadeIn();
		// 					/*$mobileBackTip._timeout = setTimeout(function(){
		// 						$mobileBackTip.fadeOut();
		// 					}, 5000);*/
		// 					$('#verifySure').addClass('active');
		// 				}else{
		// 					$this.attr('disabled', false);
		// 					alert(data.message);
		// 				}
		// 			},
		// 			error: function(data){
		// 				alert('操作失败，请稍后重试');
		// 				$this.attr('disabled', false).removeClass('loading');
		// 			}
		// 		});
		// 	}else if(!$this.hasClass('counting')){//$.trim($('#vertifyText').val()).length == 0
		// 		$('#verifyTip').text('请输入正确的验证码');
		// 	}
  //   	}
  //   });	
	// 手机短信验证确定
	// $('#verifySure').click(function(){
	// 	var _mbCode = $('#mbCode').val();
	// 	var $verifySure = $(this);
	// 	var $mbTip = $('#mbTip');
	// 	if($verifySure.hasClass('loading')){
	// 		return;
	// 	}
	// 	if(!$('.vm-text-wrap').hasClass('right')){
	// 		$('#verifyTip').text('请输入正确的验证码');
	// 		return;
	// 	}
		
	// 	if(!/^[0-9]{6}$/.test(_mbCode)){
	// 		$mbTip.text('请输入正确的6位短信验证码');
	// 	}else{
	// 		$verifySure.addClass('loading');
	// 		$('#vmCloseBtn').hide();
	// 		$.ajax({
	// 			type: 'GET',
	// 			dataType: 'JSON',
	// 			url: '/event/yueban/ajax_mobile_verification',
	// 			data: {mobile_verification: _mbCode},
	// 			success: function(data){
	// 				if(data.status == 200){
	// 					releaseEvent();
	// 				}else{
	// 					$mbTip.text(data.message);
	//     				$verifySure.removeClass('loading');
	//     				$('#vmCloseBtn').show();
	// 				}
	//     		},
	//     		error: function(data){
	//     			$mbTip.text(data.message);
	//     			$verifySure.removeClass('loading');
	//     			$('#vmCloseBtn').show();
	//     		}
	//     	});
	// 	}
		
	// });
   	//换验证码
   	// $('.verify-code').click(function(){
   	// 	$(this).css("backgroundImage","url(captcha)");
   	// 	$('#verifyTip').text('');
   	// 	$('.vm-text-wrap').removeClass('right wrong');
   	// 	$('#vertifyText').val('');
    // 	$('#mobileVerify').removeClass('active');
   	// });
   	//关闭验证框
   	// $('#vmCloseBtn').click(function(){
   	// 	$('.verify-modal, .me-cover').hide();
   	// 	$('#releaseBtn').removeClass('ing');
   	// 	$('.vm-text-wrap').removeClass('right wrong');
   	// 	$('#vertifyText, #mbCode').val('');
   	// 	$('.verify-modal .vm-btn').removeClass('active');
   	// 	$('#verifyTip, #mbTip, #mobileBackTip').text('');
   	// });
});