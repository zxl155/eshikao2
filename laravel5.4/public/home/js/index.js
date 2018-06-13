
var renderZhao=(function () {
    var jt=$('.sort-text-ul').focus('.jt');
    var sortRqJt=1;//人气排序
    function flSwitch(_this) {
        _this.bind('click',function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
        _this.bind('click',function () {
            sortRqJt?$(this).children('.jt').html('&uarr;'):$(this).children('.jt').html('&darr;');
            sortRqJt?sortRqJt=0:sortRqJt=1;
        })
    }
    //吸顶盒
    $(function(){
        var TIMER;//定义全局变量
        $(window).scroll( function() {
            clearTimeout(TIMER);//必须要有这句
            if( $(document).scrollTop() > 418 ){
                TIMER = setTimeout(function(){
                    $(".v-top-box").slideDown();
                },100);
            }else if($(document).scrollTop()==0){
                TIMER = setTimeout(function(){
                    $(".v-top-box").slideUp();
                },100);
            }else{
                TIMER = setTimeout(function(){
                    $(".v-top-box").slideUp();
                },100);
            }
        });
    });
    //登录状态显示头像
    function courseTime(err,ser){
        err.mouseover(function () {
            ser.css('display', 'inline-block');
        })
        err.mouseout(function () {
            ser.css('display', 'none');
        })
    }
    //切换&&吸顶盒切换
    $('.v-content-left-ul li').click(function () {
        var _index=$(this).index();
        $('.v-top-ul li').eq(_index).addClass('active').siblings().removeClass('active');
        $('.v-content-left-ul li').eq(_index).addClass('active').siblings().removeClass('active');
        $('.v-content-left-list').eq(_index).addClass('off').siblings().removeClass('off');
    })
    $('.v-top-ul li').click(function () {
        var _index=$(this).index();
        $('.v-top-ul li').eq(_index).addClass('active').siblings().removeClass('active');
        $('.v-content-left-ul li').eq(_index).addClass('active').siblings().removeClass('active');
        $('.v-content-left-list').eq(_index).addClass('off').siblings().removeClass('off');
    })
    //上课帮助
    $('.v-right li').mouseover(function () {
        var _index=$(this).index()
        $('.v-right-title-ts').eq(_index).addClass('off').siblings().removeClass('off');
    })
    $('.v-right li').mouseout(function () {
        var _index=$(this).index()
        $('.v-right-title-ts').eq(_index).removeClass('off').siblings().addClass('off');
    })
    //商品详情购买
    $('#yyd .yyd-i1').click(function () {
        $(this).css('display','none');
        $('#yyd .yyd-i2').css('display','inline-block');
    });
    $('#yyd .yyd-i2').click(function () {
        $(this).css('display','none');
        $('#yyd .yyd-i1').css('display','inline-block');
    })
//省级联动
    var Gid  = document.getElementById ;
    var showArea = function(){
        Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +
            Gid('s_city').value + " - 县/区" +
            Gid('s_county').value + "</h3>"
    }
    $('#s_county').change(function () {
        showArea();
    });
//选择收货地址
    function goods(err,err2){
        err.click(function () {
            var _this=$(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            err2.eq(_this).addClass('active').siblings().removeClass('active');
        })
    }
    function focusBanner(){
        var $focusBanner=$("#focus-banner"),
            $bannerList=$("#focus-banner-list li"),
            $focusHandle=$(".focus-handle"),
            $bannerImg=$(".focus-banner-img"),
            $nextBnt=$("#next-img"),
            $prevBnt=$("#prev-img"),
            $focusBubble=$("#focus-bubble"),
            bannerLength=$bannerList.length,
            _index=0,
            _timer="";

        var _height=$(".focus-banner-img").height();
        $focusBanner.height(_height);
        $bannerImg.height(_height);

        for(var i=0; i<bannerLength; i++){
            $bannerList.eq(i).css("zIndex",bannerLength-i);
            $focusBubble.append('<li><a href="javascript:;">'+i+'</a></li>');
        }
        $focusBubble.find("li").eq(0).addClass("current");
        var bubbleLength=$focusBubble.find("li").length;
        $focusBubble.css({
            "width":bubbleLength*22,
            "marginLeft":-bubbleLength*11
        });//初始化

        $focusBubble.on("click","li",function(){
            $(this).addClass("current").siblings().removeClass("current");
            _index=$(this).index();
            changeImg(_index);
        });//点击轮换

        $prevBnt.on("click",function(){
            _index++
            if(_index>bannerLength-1){
                _index=0;
            }
            changeImg(_index);
        });//下一张

        $nextBnt.on("click",function(){
            _index--
            if(_index<0){
                _index=bannerLength-1;
            }
            changeImg(_index);
        });//上一张

        function changeImg(_index){
            $bannerList.eq(_index).fadeIn(250);
            $bannerList.eq(_index).siblings().fadeOut(200);
            $focusBubble.find("li").removeClass("current");
            $focusBubble.find("li").eq(_index).addClass("current");
            clearInterval(_timer);
            _timer=setInterval(function(){$nextBnt.click()},5000)
        }//切换主函数
        _timer=setInterval(function(){$nextBnt.click()},5000);


        function isIE() { //ie?
            if (!!window.ActiveXObject || "ActiveXObject" in window)
                return true;
            else
                return false;
        }

        if(!isIE()){
            $(window).resize(function(){
                window.location.reload();
            });
        }else{
            if(!+'\v1' && !'1'[0]){
                alert("老铁什么年代啦还在搞ie8以下版本啊！")
            } else{
                $(window).resize(function(){
                    window.location.reload();
                });
            };
        }
    };
    return {
        init:function () {
            flSwitch($('.Certificate-ul li'));//分类切换
            flSwitch($('.sort-text-ul li'));//排序切换
            courseTime($('.Course-time i'),$('.Course-time span'));//登录状态显示头像
            goods($('.address-list'));
            goods($('.cfmode span'));
            goods($('.abouts-list li'),$('.abouts-content li'));
            focusBanner();
        }
    }
})();
renderZhao.init();
