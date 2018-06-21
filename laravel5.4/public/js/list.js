$(function(){
	var $sliderNav = $('#sliderNav');
	$(".rslides").responsiveSlides({
        auto: false, // Boolean: Animate automatically, true or false
        speed: 500, // Integer: Speed of the transition, in milliseconds
        timeout: 4000, // Integer: Time between slide transitions, in milliseconds
        pager: true, // Boolean: Show pager, true or false
        nav: false, // Boolean: Show navigation, true or false
        random: false, // Boolean: Randomize the order of the slides, true or false
        pause: false, // Boolean: Pause on hover, true or false
        pauseControls: true, // Boolean: Pause when hovering controls, true or false
        prevText: "Previous", // String: Text for the "previous" button
        nextText: "Next", // String: Text for the "next" button
        maxwidth: "", // Integer: Max-width of the slideshow, in pixels
        navContainer: "", // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "", // Selector: Declare custom pager navigation
        namespace: "rslides", // String: Change the default namespace used
        before: function(index) {
        	var $target = $sliderNav.children().eq(index);
        	if($target.hasClass('active')) return;
        	$sliderNav.children().removeClass('active');
        	$target.addClass('active');
        	$('.rslides_tabs li').removeClass('active').eq(index).addClass('active');}, // Function: Before callback
        after: function(index) {
        	
        } // Function: After callback
    });
	$('.rslides_tabs').children().eq(0).addClass('active');
	$('.rslides_tabs a').hover(function(e){
		var $this = $(this),
			$li = $this.parent(),
			index = $li.index();
		if($li.hasClass('rslides_here')) return;

		if(window.rsTimeoutId) clearTimeout(window.rsTimeoutId);
		window.rsTimeoutId = setTimeout(function(){
			
			$this.click();
			$li.addClass('active').siblings().removeClass('active');
			$sliderNav.children().removeClass('active').eq(index).addClass('active');
		}, 300);
	});
	$('.mte-slider').mouseleave(function(e){
		if(window.rsTimeoutId) clearTimeout(window.rsTimeoutId);
	})
	
	
	//加载更多
	$(".race-more-btn").on("click",function(){
		var count=$(".race-list li").length;
		if(count>0){
			$.ajax({
				type: "GET",
				url: "/index",
				data: {offset:count,json:false},
				dataType: "html",
				success: function(html){
					console.log(html);
					if(html!="")$(".race-list").append(html);
					else{
						$(".race-more-btn").html("没有数据可以显示");
					}
				}
			});
		}
	});
	
});
