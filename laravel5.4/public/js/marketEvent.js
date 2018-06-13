$(function(){
	var $sliderNav = $('#sliderNav');
	$(".rslides").responsiveSlides({
        auto: true, // Boolean: Animate automatically, true or false
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
			$sliderNav.data('isConstrained', true);
			$this.click();
            $sliderNav.data('isConstrained', false);
			$li.addClass('active').siblings().removeClass('active');
			$sliderNav.children().removeClass('active').eq(index).addClass('active');
		}, 300);
	});
    $('.rslides_tabs a').click(function(e){
        if(! $sliderNav.data('isConstrained')){
            var $this = $(this),
            $li = $this.parent(),
            index = $li.index();

            var _href = $sliderNav.find('a').eq(index).attr('href');
            window.open(_href, '_blank');
        } 
    });
	$('.mte-slider').mouseleave(function(e){
		if(window.rsTimeoutId) clearTimeout(window.rsTimeoutId);
	})


    //动态加载数据
    $(".mte-more-btn").on("click",function(){
        $("body").append('<form class="moreform" action="" method="get"></form>');
        var form1=$(".moreform");
        var count=$(".mte-box").length;
        form1.ajaxSubmit({
            dataType:'json',
            url: "http://"+SITE_DOMAIN+"/zhuanti/mfhd/more/" + count,
            beforeSend: function() {
                $(".mte-more-btn i").append("<img src='"+MISC_PATH+"images/loading.gif' />");
            },
            success:function(data) {
                //console.log(data);
                if(!data.result){
                    $(".mte-more-btn").hide();
                }
                $.each(data.result,function(i,item){
                    var html='<div class="mte-box">'+
                        '<a href="'+item.url+'"><h3 class="title">'+item.title+'</h3></a>'+
                        '<p class="info"><span class="name">'+item.username+'</span><span class="split">|</span><span class="time">发布于:'+item.created+'</span></p>'+
                        '<span class="icon-like">'+item.dignum+'</span>'+
                        '<span class="icon-cmt">'+item.postnum+'</span>'+
                        '<span class="icon-see">'+item.hitnum+'</span>'+
                        '<a href="'+item.url+'"><img src="'+item.photourl+'" alt="" /></a>'+
                        '<a href="'+item.url+'"><p class="des">'+item.content+'</p></a>'+
                    '</div>';
                    $(".mte-ct .mte-box").last().after(html);
                });
            },
            error:function(xhr){
                console.log(xhr);
                $(".mte-more-btn i img").remove();
            },
            complete:function(){
                $(".mte-more-btn i img").remove();
            }
        });
    });


});
