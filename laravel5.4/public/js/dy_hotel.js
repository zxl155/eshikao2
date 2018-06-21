$(function(){
    $('#js_form_poi').live('click',function(){
        $('#side_booking_placehot').show().css('left',$(this).position().left);
    });
    $('#side_booking_placehot .js_hot_poi_li a').live('click',function(){
        $('#js_form_poi').val($(this).html());
        $('#side_booking_placehot').hide();
    });
    $(".Wdate").click(function(){
        WdatePicker({
            minDate : '%y-%M-{%d}',
            onpicked : function(){
                var time_arr = $(this).val().split('-');
                var monthday = time_arr[2];
                var year_month = time_arr[0] + '-' + time_arr[1];
                var id = $(this).attr('id');
                var form = $('#HotelForm').get(0);
                if(id == 'hotel_from'){
                    form.elements['checkin_monthday'].value = monthday;
                    form.elements['checkin_year_month'].value = year_month;
                }
                else if(id == 'hotel_to'){
                    form.elements['checkout_monthday'].value = monthday;
                    form.elements['checkout_year_month'].value = year_month;
                }
            }
        });
    });

	$(".name_search li").click(function(){
		$('#js_form_poi').val($(this).html());
		$('.search-submit').click();
	
	});

	$(".dest_seatch li").click(function(){
		var dest_name = $(this).attr('dest');
		$('#js_form_poi').val(dest_name);
		$('.search-submit').click();
	
	});

    /*给body加点击事件*/
    $("body").click(function(event){
        //console.log($(event.target).parents('#side_booking_placehot').size());
        if($(event.target).parents('#side_booking_placehot').size()==0) $("#side_booking_placehot").hide();
    });
});