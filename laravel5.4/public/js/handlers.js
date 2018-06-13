function swfUploadLoaded() {
	
}
function fileQueued(file) {
	try {
		
		$('.xgl_null').remove();
		var $li = $('<li><div><span class="xgl_close">×</span><img alt="" src="'+  MISC_PATH +'images/route/xlzn_upload.png" /><div class="xgl_progressbar"><div class="xgl_progressbg"></div><p class="xgl_progress"></p><span>0%</span></div></div></li>');
		$li.attr('id', 'li_'+file.id);
		$li.appendTo($('.xgl_list'));
		this.liQueued = this.liQueued || [];
		this.liQueued.push($li);


	} catch (ex) {
		this.debug(ex);
	}

}
function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			//xlznAlert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			if(message == 0){
				xlznAlert("您选择的图片已经达到了最大限制！");
			}
			else{
				xlznAlert("您最多只能同时选择"+ message +"张图片！");
			}
			return false;
		}

		var $li = $('<li><div><span class="xgl_close">×</span><img alt="" src="'+  MISC_PATH +'images/route/xlzn_upload.png" /><div class="xgl_progressbar"><div class="xgl_progressbg"></div><p class="xgl_progress"></p><span>0%</span></div></div></li>');
		$li.attr('id', 'li_'+file.id);
		$li.appendTo($('.xgl_list'));

		var $info = $li.find('.xgl_progressbar>span');

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			$info.text('图片太大了！');
			//progress.setStatus("File is too big.");
			//this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			$info.text('不能上传0kb文件！');
			//progress.setStatus("Cannot upload Zero Byte files.");
			//this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			$info.text('无效的文件类型！');
			//progress.setStatus("Invalid File Type.");
			//this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				$info.text('未知错误！');
				//progress.setStatus("Unhandled Error");
			}
			//this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}

	} catch (ex) {
        this.debug(ex);
    }
}
function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if(numFilesSelected > 10){
			xlznAlert("您最多只能同时选择10张图片！");

			for(var i=0; i<this.liQueued.length; i++){
				this.liQueued[i].remove();
				this.cancelUpload(this.liQueued[i].attr('id').substr(3,this.liQueued[i].attr('id').length),false);
			}
			this.liQueued.length = 0;
			
			return true;
		}
		if(numFilesSelected > 0) {
			this.liQueued.length = 0;
			$('#xlznPhotoContent, #xlznIndexPhotoModal').data('ifUploading', true);
			//document.getElementById(this.customSettings.cancelButtonId).disabled = false;
			/* I want auto start the upload and I can do that here */
			this.startUpload();
		}
		
		
	} catch (ex)  {
        this.debug(ex);
	}
}
function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		
	}
	catch (ex) {}
	
	return true;
}
function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100),
			$progress = $('#li_'+file.id).find('.xgl_progress'),
			info = percent + '%';

		$progress.css('width', percent + '%');
		if(percent == 100){
			info = '图片处理中';
		}
		$progress.next().text(info);
		
	} catch (ex) {
		this.debug(ex);
	}
}
function round2(number,fractionDigits){   
    with(Math){   
        return round(number*pow(10,fractionDigits))/pow(10,fractionDigits);   
    }   
}
function uploadSuccess(file, serverData) {
	var jsonData = eval('('+ serverData +')');
	try {
		if(parseInt(jsonData.error) == 0){

			//计算上传数量
			var status = document.getElementById("divStatus");
			var num = parseInt(status.innerHTML);
			num++;
			status.innerHTML = num;

			//计算上传总量
			var temp_imgUploadTotalSize = document.getElementById('temp_imgUploadTotalSize');
			var size = temp_imgUploadTotalSize.value ? temp_imgUploadTotalSize.value : 0;
			size = parseFloat(size);
			size += parseFloat(jsonData.result.imgSize);
			temp_imgUploadTotalSize.value = size;
			var imgUploadTotalSize = document.getElementById('imgUploadTotalSize');
			if(size<=1024){
				imgUploadTotalSize.innerHTML = round2(size/(1024*1024),4);
			}
			else{
				imgUploadTotalSize.innerHTML = round2(size/(1024*1024),3);
			}

			var $li = $('#li_'+file.id);
			$li.attr('imgID', jsonData.result.photoID_temp);
			$li.attr('imgSize',jsonData.result.imgSize);
			$li.find('.xgl_close').attr('ajaxurl','/api/uploads/delTempImg/'+jsonData.result.photoID_temp);
			$('<img/>').attr('src', jsonData.result.imgURL).load(function(e){
				$li.find('img').attr('src', jsonData.result.imgURL);
				$li.find('.xgl_progress').next().text('100%');
				fadeIn($li.find('img').get(0), 0);
			});
		}
		else{
			xlznAlert(jsonData.msgs);
		}
	} catch (ex) {
		this.debug(ex);
	}
}
function uploadError(file, errorCode, message) {
	try {
		
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		$('#xlznPhotoContent, #xlznIndexPhotoModal').data('ifUploading', false);
	}
}
function queueComplete(numFilesUploaded) {
	
}
function swfUploadPreLoad() {
	var self = this;
	
}
function swfUploadLoadFailed() {
	
}
function fadeIn(element, opacity) {
	var reduceOpacityBy = 5;
	var rate = 30;	// 15 fps


	if (opacity < 100) {
		opacity += reduceOpacityBy;
		if (opacity > 100) {
			opacity = 100;
		}

		if (element.filters) {
			try {
				element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function () {
			fadeIn(element, opacity);
		}, rate);
	}
}

