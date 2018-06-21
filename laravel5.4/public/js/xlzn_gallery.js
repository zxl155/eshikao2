$(function(){
	//删除上传的图片
	$('.xgl_list').delegate('.xgl_close', 'click', function(e){
		e.preventDefault();
		$('#xlznDeleteModal').show();
		$('.xlzn_modal_cover').css('zIndex', 1010).show();
		$('.xgl_close_selected').removeClass('xgl_close_selected');
		$(this).addClass('xgl_close_selected');
	});
	$('#xlznDeleteModalSure').click(function(e){
		e.preventDefault();
		var $li = $('.xgl_close_selected').closest('li'),
			url = $li.find('.xgl_close').attr('ajaxurl');

		if(url){
			$.get(url,{},function(data){
                if(parseInt(data.error) == 0){
                    var imgSize = $li.attr('imgSize');
                    $li.remove();

                    //计算上传数量
                    var num = parseInt($('#divStatus').html());
                    num = num-1 < 0 ? 0 : num-1;
                    $('#divStatus').html(num);
                    //计算上传总量
                    var temp_imgUploadTotalSize = document.getElementById('temp_imgUploadTotalSize');
                    var size = temp_imgUploadTotalSize.value ? temp_imgUploadTotalSize.value : 0;
                    size = parseFloat(size);
                    size -= parseFloat(imgSize);
                    temp_imgUploadTotalSize.value = size;
                    var imgUploadTotalSize = document.getElementById('imgUploadTotalSize');
                    imgUploadTotalSize.innerHTML = (size/(1024*1024)).toFixed(2);

                }
                else{
                    xlznAlert(data.msgs);
                }
            },'json');
		}else{
			$li.remove();
		}
		$('#xlznDeleteModal').hide();
		if($('#xlznIndexPhotoModal').size()>0){
			$('.xlzn_modal_cover').css('zIndex', 1000);
		}else{
			$('.xlzn_modal_cover').css('zIndex', 1000).hide();
		}
		
	});
	$('#xlznDeleteModalCancel').click(function(e){
		e.preventDefault();
		$('#xlznDeleteModal').hide();
		if($('#xlznIndexPhotoModal').size()>0){
			$('.xlzn_modal_cover').css('zIndex', 1000);
		}else{
			$('.xlzn_modal_cover').css('zIndex', 1000).hide();
		}
	});
	/*相册图片选择
		openEleId：打开相册框button的ID，
		getDataUrl：数据请求url，
		callback：回调
	*/
	function xlznGallery(openEleId, getDataUrl, callback){
		var data = '';
		//打开相册弹框
		$(openEleId).click(function(e){
			e.preventDefault();
			$('.xlzn_gallery_modal').show();
			$('.xlzn_modal_cover').css('zIndex', 1010).show();
			if(!$(openEleId).attr('data-ifGet')){
				$('#xglmGalleryMain').hide();
				$.ajax({
					url: getDataUrl,
					dataType: 'json',
					data: {
						
					},
					success: function(data){
						if(data.error == 0){
							var photoSets = data.result.photo_sets,
								defaultPhotos = data.result.site_photos;

							//初始化相册选择框
							var $setHolder = $('#xlznGallerySet');
							$setHolder.html('');
							$('.xgl_null').hide();
							$(photoSets).each(function(i, obj){
								$('<option value="' + obj.SetID + '">' + obj.Name + '</option>').appendTo($setHolder);
							});
							$setHolder.val(data.result.default_site_id);
							var $imgListHolder = $('#xglmGalleryMain');
							$imgListHolder.html('');
							
							$(defaultPhotos).each(function(i, obj){
								$('<li imgId="'+ obj.PhotoID +'"><a><img src="'+obj.Image+'"/></a></li>').appendTo($imgListHolder);
							});
							
							$(openEleId).attr('data-ifGet', true);
							$('.xglm_loading').hide();
							$imgListHolder.show();
						}else{
							xlznAlert(data.msgs)
						}
					}
				});
			}else{
				$('#xglmGallerySide').html('');
				$('#xglmGalleryMain .xglm_selected').remove();
				$('.xlzn_gallery_modal [data-num]').attr('data-num', 0);
				$('#xglmcInfo').text('0/10');
			}
			
		});
		//相册弹框图片选择
		$('.xglm_list').delegate('a', 'click', function(e){
			e.preventDefault();
			var $target = $(this),	
				$sideHolder = $('#xglmGallerySide'),
				imgId = $target.parent().attr('imgId'),
				$img = $target.find('img'),
				selectedNum = parseInt($('.xlzn_gallery_modal [data-num]').attr('data-num')),
				$info = $('#xglmcInfo');

			if(selectedNum == 10 && $target.find('.xglm_selected').length == 0){
				xlznAlert('最多选择10张');
			}else{
				if($target.find('.xglm_selected').length == 0){
					$target.append($('<p class="xglm_selected"><i></i></p>'));
					var $div = $('<div></div>');
					$div.append('<span class="xgl_close">×</span>').append($img.clone());
					$('<li></li>').attr('imgId', imgId).append($div).appendTo($sideHolder);
					selectedNum++;
				}else{
					$target.find('.xglm_selected').remove();
					$sideHolder.find('[imgId="'+imgId+'"]').remove();
					selectedNum--;
				}
				$('.xlzn_gallery_modal [data-num]').attr('data-num', selectedNum);
				$info.text(selectedNum + '/10');
			}
		});
		//相册弹框图片选择删除
		$('.xglm_list').delegate('.xgl_close', 'click', function(e){
			var $target = $(this),	
				$sideHolder = $('#xglmGallerySide'),
				$mainHolder = $('#xglmGalleryMain'),
				imgId = $target.parent().parent().attr('imgId'),
				selectedNum = parseInt($('.xlzn_gallery_modal [data-num]').attr('data-num')),
				$info = $('#xglmcInfo');

			$sideHolder.find('[imgId="'+imgId+'"]').remove();	
			$mainHolder.find('[imgId="'+imgId+'"]').find('.xglm_selected').remove();	
			selectedNum--;
			$('.xlzn_gallery_modal [data-num]').attr('data-num', selectedNum);
			$info.text(selectedNum + '/10');
		});
		$('#xlznGallerySure').click(function(e){
			e.preventDefault();
			var $li = $('#xglmGallerySide [imgId]'),
				arr = [];

			$li.each(function(i, obj){
				arr.push($(obj).attr('imgId'));
			});
			data = arr.join(',');
			callback(data);
		});
		//相册切换
		$('#xlznGallerySet').change(function(){
			var setId = $(this).val();
			var $imgListHolder = $('#xglmGalleryMain');
			$imgListHolder.hide();
			$('.xglm_loading').show();
			$.ajax({
				url: getDataUrl,
				dataType: 'json',
				data: {
					site_id: setId
				},
				success: function(data){
					if(data.error == 0){
						var defaultPhotos = data.result.site_photos;
						$imgListHolder.html('');
						$(defaultPhotos).each(function(i, obj){
							$('<li imgId="'+ obj.PhotoID +'"><a><img src="'+obj.Image+'"/></a></li>').appendTo($imgListHolder);
						});
						$('.xglm_loading').hide();
						$imgListHolder.show();
					}
				}
			});
		});
		$('.xglm_cancel').click(function(e){
			e.preventDefault();
			$(this).closest('.xlzn_gallery_modal').hide();
			if($('#xlznIndexPhotoModal').size()>0){
				$('.xlzn_modal_cover').css('zIndex', 1000);
			}else{
				$('.xlzn_modal_cover').css('zIndex', 1000).hide();
			}
		});
		callback(data);
	}
	xlznGallery('#xlznGalleryOpen', location.protocol + "//" + location.host+'/route/my_site_img', function(data){
		if($('#xlznIndexPhotoModal').size()>0){
			$('.xlzn_gallery_modal').hide();
			$('.xlzn_modal_cover').css('zIndex', 1000);
		}else{
			$('.xlzn_gallery_modal').hide();
			$('.xlzn_modal_cover').css('zIndex', 1000).hide();
		}
		$('#xglmGallerySide [imgId]').each(function(i, obj){
			var $li = $('<li><div><span class="xgl_close">×</span><img alt="" src="'+  $(obj).find('img').attr('src') +'" /><div class="xgl_progressbar"><div class="xgl_progressbg"></div><p class="xgl_progress" style="width:100%;"></p><span>100%</span></div></div></li>');
			$li.attr('imgId', $(obj).attr('imgId')).attr('data-group','site_photo_ids');
			$li.appendTo($('.xgl_list'));
		});
		
	});
});