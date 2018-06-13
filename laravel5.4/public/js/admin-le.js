$(function(){
	var postData = {};
	var $curCmdHolder;
	//活动审核页，按钮操作
	$(".btn-my-race button").on("click",function(){
		var $this = $(this);
		$curCmdHolder = $this.parent();
		var _nodeid = $this.attr('data-id');
		var _value = $this.attr('data-value');
		postData = {
			node_id: _nodeid
		}
		if($this.hasClass('event-edit')){//修改
			window.location.href = '/race/edit/'+_nodeid;
			return;
		}
		if($this.hasClass('event-passed')){//审核通过
			postData.action = 'status';
			postData[postData.action] = 'passed';
		}
		if($this.hasClass('event-rejected')){//审核不通过
			postData.action = 'status';
			postData[postData.action] = 'rejected';
			$('#feedbackInfo').val('');
        	$('#feedbackModal').modal('show');
        	return;
		}
		if($this.hasClass('event-post')){//提交审核
			postData.action = 'status';
			postData[postData.action] = 'auditing';
		}
		if($this.hasClass('event-apply')){//报名
			postData.action = 'is_apply';
			postData[postData.action] = _value;
			if(_value == 'N' && !confirm('你确定要关闭报名吗？')){
				return;
			}
		}
		if($this.hasClass('event-pay')){//支付
			postData.action = 'is_pay';
			postData[postData.action] = _value;
			if(_value == 'N' && !confirm('你确定要关闭支付吗？')){
				return;
			}
		}
		if($this.hasClass('event-cancel')){//活动取消
			postData.action = 'status';
			postData[postData.action] = 'canceled';
			if(!confirm('你确定要取消活动吗？')){
				return;
			}
		}
		if($this.hasClass('event-delete')){//删除
			postData.action = 'status';
			postData[postData.action] = 'deleted';
			if(!confirm('你确定要删除？')){
				return;
			}
		}
		if($this.hasClass('event-refund')){//删除
			postData['status'] = _value;
			if(!confirm('你确定要关闭结算？')){
				return;
			}else{
				$.ajax({
					url: "/race/closerefund",
					data: postData,
					dataType: "json",
					type: 'GET',
					success: function(data) {
						console.log(data);
						if(data.error == 0){
							alert(data.msg);
							window.location.reload();
						}else{
							alert(data.msg)
						}
					},
					error: function(){

					}
				});
				return;
			}
		}
		$curCmdHolder.find('.btn').hide();
		$curCmdHolder.find('.cmd-loading').addClass('active');
		$.ajax({
		    url: "/race/updatestatus",
		    data: postData,
		    dataType: "json",
		    type: 'POST',
		    success: function(data) {
		       	if(data.error == 0){
		       		window.location.reload();
		       	}else{
		       		alert(data.msg)
		       	}
		    },
		    error: function(){
		    	
		    }
		});
		
	});
	//审核不通过信息反馈
	$('#feedbackOk').click(function() {
		var $target = $('#feedbackInfo');
        var _remark = $target.val().replace(/(^\s+)|(\s+$)/g,"");
        if(_remark.length>50){
        	$target.parent().addClass('has-error');
        }else{
        	$target.parent().removeClass('has-error');
        	postData['remark'] = _remark;
        	$curCmdHolder.find('.btn').hide();
			$curCmdHolder.find('.cmd-loading').addClass('active');
	        $.ajax({
	            url: "/race/updatestatus",
	            dataType: 'json',
	            data: postData,
	            type: 'POST',
	            success: function(data) {
	                if (data.error == 0){
	                	window.location.reload();
	                }else{
	                    alert(data.msg);
	                }
	            }
	        });
	        $('#feedbackModal').modal('hide');
        }
    });
	//活动审核页，显示到磨房主站
	$('.le-table').delegate('.event-display','click', function(e){
		var $this = $(this);
		var _nodeid = $this.val();
		var _ifDisplay = $this.is(':checked')?'Y':'N';
		
		$.ajax({
		    url: "/race/updatestatus",
		    data:{
		    	node_id: _nodeid,
		    	is_deply_dyh: _ifDisplay,
		    	action: 'is_deply_dyh'
		    },
		    dataType: "json",
		    success: function(data) {
		       	
		    },
		    error: function(){
		    	
		    }
		});
	});

});
