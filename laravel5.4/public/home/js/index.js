var renderZhao=(function () {
    var i =3;
    var time;
    //var jt=$('.sort-text-ul').focus('.jt');
    var sortRqJt=1;//PC价格排序
    function flSwitch(_this) {
        _this.bind('click',function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
        _this.bind('click',function () {
            sortRqJt?$(this).children('.jt').html('&uarr;'):$(this).children('.jt').html('&darr;');
            sortRqJt=sortRqJt?0:1;
        })
    }
    //价格排序
    $('.m-sort-ul li').eq(2).click(function () {
        sortRqJt=sortRqJt?0:1;
        sortRqJt?$('.m-sort-ul li span i').eq(0).addClass('active').siblings().removeClass('active'):$('.m-sort-ul li span i').eq(1).addClass('active').siblings().removeClass('active');
    })
    //吸顶盒
    $(function(){
        var TIMER;//定义全局变量
        $(window).scroll( function() {
            clearTimeout(TIMER);//必须要有这句
            //console.log($(document).scrollTop());
            if( $(document).scrollTop() > 418 ){
                TIMER = setTimeout(function(){
                    $(".v-top-box").slideDown();
                },100);
            }else if($(document).scrollTop()===0){
                TIMER = setTimeout(function(){
                    $(".v-top-box").css('display','none');
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
        var art=arguments[1];
        err.on('click',function () {
            console.log(123);
            clearCookie('userindex');
            var _this=$(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            art?art.eq(_this).addClass('active').siblings().removeClass('active'):null;
        })

    }
    //筛选
    function screenbtn(err,eve){
        err.eq(3).siblings().click(function () {
            eve.slideUp(200);
        })
        err.eq(3).click(function () {
            eve.slideToggle(200);
        })
    }
    function screens(err){
        err.children('dt').bind('click',function () {
            var _this=$(this).index();
            $(this).siblings('dd').slideToggle(200);
            $(this).parent('dl').siblings().children('dd').slideUp(200);
        })
    }
    //banner
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
        var _height=$bannerImg.height();
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


        // function isIE() { //ie?
        //     if (!!window.ActiveXObject || "ActiveXObject" in window)
        //         return true;
        //     else
        //         return false;
        // }

        // if(!isIE()){
        //     $(window).resize(function(){
        //         window.location.reload();
        //     });
        // }else{
        //     if(!+'\v1' && !'1'[0]){
        //         alert("老铁什么年代啦还在搞ie8以下版本啊！")
        //     } else{
        //         $(window).resize(function(){
        //             window.location.reload();
        //         });
        //     };
        // }
    };
    //定时器
    function codeTime(){
        $('.getveri2').html('('+i+')秒后重新获取');
        console.log(i-=1);
        $('.zh-prompt').html('')
        if(i<0){
            i=3;
            clearTimeout(time);
            $('.getveri').css('display','block');
            $('.getveri2').html('(60)秒后重新获取');
        }
    }
    //定时器
    $('.getveri').click(function () {
        var ret=/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
        $('.getveri').css('display','none');
        ret.test($('.phone').val())?time=setInterval(codeTime,1000):null;
    })
    //物流信息显示
    $('.logins-text-an').click(function () {
        $(this).next().fadeToggle(200);
    })
    //导航默认样式
    $(function(){
        if(typeof Hindex==='number'){
            $('.header-ul a').eq(Hindex).addClass('active');
            $('.m-Nav a').eq(Hindex).addClass('active')
        }
    })
    $(function(){
        typeof Uindex==='number'?$('.personal-nav li').eq(Uindex).addClass('active'):null;
    })
    // 新增收货地址
    $('#commodity-add').on('click',function(){
        $('.newaddress').toggle();
    })
    //返回顶部
    $(function () {
        $('.rt-top').click(function () {
            $('html , body').animate({scrollTop: 0}, 'slow');
        });
        getCookie('userindex')?ulIndex():null;
    });
//加入易师考
    function getCookie(c_name)
    {
        if (document.cookie.length>0)
        {
            c_start=document.cookie.indexOf(c_name + "=")
            if (c_start!=-1)
            {
                c_start=c_start + c_name.length+1
                c_end=document.cookie.indexOf(";",c_start)
                if (c_end==-1) c_end=document.cookie.length
                return unescape(document.cookie.substring(c_start,c_end))
            }
        }
        return ""
    }

    function setCookie(c_name,value,expiredays)
    {
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
            ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
    }
    function clearCookie(name) {
        setCookie(name, "", -1);
    }
    function checkCookie()
    {
        userindex=getCookie('userindex')
        if (userindex!=null && userindex!="")
        {
            console.log(123);}
        else
        {
            userindex='1';
            if (userindex!=null && userindex!="")
            {
                setCookie('userindex',userindex,10000)
            }
        }
    }
    $('.addcy').click(function () {
        checkCookie();
    });
    $('.knowesk').click(function (){
        clearCookie('userindex')
    })
    function ulIndex() {
        var _index=getCookie('userindex');
        $('.abouts-list li').eq(_index).addClass('active').siblings().removeClass('active');
        $('.abouts-content li').eq(_index).addClass('active').siblings().removeClass('active');
    }
    /*支付选项*/
    function zfPay(){
        var pay=0;
        $('.cfmode span').click(function(){
            pay=$(this).index();
            console.log(pay)
            $('.commodity-button form').eq(pay).addClass('addform').siblings().removeClass('addform');
        })
    }
    $('.m-screenbox .move').click(function () {
        $('.m-screenbox').css('display','none');
    })
    //移动收货地址‘文字内容’
    $('.m-content-addres .m-addres-man').html()?$('.m-add-addres .m-addresm').html('收货地址')&&$('.m-addresxg').html('更改收货地址'):null;
    //移动招考公告
    $('.notice-listbox .notice-listbox-title').click(function () {
        if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
            $('.notice .Certificate-type').slideToggle()
        }
    })
    $('.notice .Certificate-ul').click(function () {
        console.log(123);
        if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
            $('.notice .Certificate-type').slideUp()
        }
    })
    //客服
    var smallPro=false;
    $('#service').on('click',function () {
        wx.miniProgram.getEnv(function(res) {
            console.log(res.miniprogram) // true
            if(res.miniprogram){
                smallPro=true;
            }else{
                smallPro=false;
            }
        });
        if(smallPro){
            wx.miniProgram.navigateTo({
                url:'/pages/call/call',//跳转回小程序的页面
                success: function(){
                    console.log('success')
                },
                fail: function(){
                    console.log('fail');
                },
            });
        }else {
            window.open('http://wpa.qq.com/msgrd?v=3&uin=3049266534&site=qq&menu=yes','_blank')
        }
    })
    return {
        init:function () {
            flSwitch($('.Certificate-ul li'));//分类切换
            flSwitch($('.sort-text-ul li'));//排序切换
            courseTime($('.Course-time i'),$('.Course-time q'));//登录状态显示头像
            goods($('.address-list'));//收货地址
            goods($('.cfmode span'));
            goods($('.m-commodity-payan a'));//移动支付方式
            goods($('.m-sort-ul li'));//筛选
            screenbtn($('.m-sort-ul li'),$('.m-screenbox'));//筛选
            screens($('.m-screenbox dl'));//筛选
            goods($('.m-screenbox dd button'));//筛选
            goods($('.abouts-list li'),$('.abouts-content li'));
            zfPay();
            focusBanner();
        }
    }
})();
renderZhao.init();