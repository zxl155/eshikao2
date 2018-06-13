
$(function(){
    //首页滚动Banner图文显示
    if($('#slides .view li').size())
    $('#slides .view li').soChange({
        thumbObj:'#slides .control li',
        thumbNowClass:'current',
        changeTime:6000
    });
	//Banner右侧APP下载广告
	if(!$.cookie('app_in_close')){
		$('<div id="appIn" class="app-in"><div class="app-in-m"><div class="app-in-g"><a id="appCloseBtn" class="app-in-close" ></a></div></div></div>').appendTo($('body'));
		$('#appCloseBtn').click(function(e){
			e.preventDefault();
			$('#appIn').hide();
			var date = new Date();
			date.setTime(date.getTime() + (24*60*60 * 1000));
			$.cookie('app_in_close', true, { expires: date });  // expires after 1 day
		});
	}
});
