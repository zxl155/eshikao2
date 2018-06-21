// gotop

/* Author: mg12 Update: 2012/03/24 Author URI: http://www.neoease.com/ */

GoTop = function(callback) {

    this.config = {
        pageWidth           :960,       // 页面宽度
        nodeId              :'go-top',  // Go Top 节点的 ID
        nodeWidth           :50,        // Go Top 节点右边到页面右边的距离
        distanceToBottom    :120,       // Go Top 节点上边到页面底部的距离
        hideRegionHeight    :90,        // 隐藏节点区域的高度 (该区域从页面顶部开始)
        text                :'',        // Go Top 的文本内容
        isHidden            :true       //是否隐藏，默认是为真
    };

    this.cache = {
        topLinkThread       :null       // 显示 Go Top 节点的线程变量 (用于 IE6)
    }
    if(callback) this.callback = callback;
};

GoTop.prototype = {

    init: function(config) {
        this.config = config || this.config;
        var _self = this;

        // 滚动屏幕, 修改节点位置和显示状态
        jQuery(window).scroll(function() {
            _self._scrollScreen({_self:_self});
        });

        // 改变屏幕尺寸, 修改节点位置
        jQuery(window).resize(function() {
            _self._resizeWindow({_self:_self});
        });

        // 在页面中插入节点
        _self._insertNode({_self:_self});
    },

    /**
     * 在页面中插入节点
     */
    _insertNode: function(args) {
        var _self = args._self;

        // 插入节点并绑定节点事件, 当节点被点击, 用 0.4 秒的时间滚动到页面顶部
        var topLink = jQuery('<a id="' + _self.config.nodeId + '" title="'+_self.config.text+'" href="javascript:void(0);">' + _self.config.text + '</a>');
        topLink.appendTo(jQuery('body'));
        topLink.click(function() {
            if(_self.callback){
                _self.callback();
            }
            else{

                //$('html, body').animate({scrollTop:1}, 600);
                //$('html, body').get(0).scrollTop = 0;
                var body = document.documentElement.scrollTop ? document.documentElement : document.body;
                (function(){
                    var top = parseInt(body.scrollTop,10);
                    var height = top/2;
                    var step = parseInt(body.scrollTop,10)-height;
                    if(step<5) step = 0;
                    body.scrollTop = step;
                    if(step) setTimeout(arguments.callee,50);
                })();
                return false;
            }
        });

        // 节点到屏幕右边的距离
        var right = _self._getDistanceToBottom({_self:_self});

        // IE6 (不支持 position:fixed) 的样式
        if(/MSIE 6/i.test(navigator.userAgent)) {
            if(_self.config.isHidden){
                topLink.css({
                    'display': 'none',
                    'position': 'absolute',
                    'right': right + 'px'
                });
            }
            else{
                topLink.css({
                    'display': 'block',
                    'position': 'absolute',
                    'right': right + 'px'
                });
            }

            // 其他浏览器的样式
        } else {
            if(_self.config.isHidden){
                topLink.css({
                    'display': 'none',
                    'position': 'fixed',
                    'right': right + 'px',
                    'top': (jQuery(window).height() - _self.config.distanceToBottom) + 'px'
                });
            }
            else{
                topLink.css({
                    'display': 'block',
                    'position': 'fixed',
                    'right': right + 'px',
                    'top': (jQuery(window).height() - _self.config.distanceToBottom) + 'px'
                });
            }
        }
    },

    /**
     * 修改节点位置和显示状态
     */
    _scrollScreen: function(args) {
        var _self = args._self;

        // 当节点进入隐藏区域, 隐藏节点
        var topLink = jQuery('#' + _self.config.nodeId);
        if(jQuery(document).scrollTop() <= _self.config.hideRegionHeight) {
            clearTimeout(_self.cache.topLinkThread);
            if(_self.config.isHidden) topLink.hide();
            return;
        }

        // 在隐藏区域之外, IE6 中修改节点在页面中的位置, 并显示节点
        if(/MSIE 6/i.test(navigator.userAgent)) {
            clearTimeout(_self.cache.topLinkThread);
            if(_self.config.isHidden) topLink.hide();

            _self.cache.topLinkThread = setTimeout(function() {
                var top = jQuery(document).scrollTop() + jQuery(window).height() - _self.config.distanceToBottom;
                topLink.css({'top': top + 'px'}).fadeIn();
            }, 400);

            // 在隐藏区域之外, 其他浏览器显示节点
        } else {
            topLink.fadeIn();
        }
    },

    /**
     * 修改节点位置
     */
    _resizeWindow: function(args) {
        var _self = args._self;

        var topLink = jQuery('#' + _self.config.nodeId);

        // 节点到屏幕右边的距离
        var right = _self._getDistanceToBottom({_self:_self});

        // 节点到屏幕顶部的距离
        var top = jQuery(window).height() - _self.config.distanceToBottom;
        // IE6 中使用到页面顶部的距离取代
        if(/MSIE 6/i.test(navigator.userAgent)) {
            top += jQuery(document).scrollTop();
        }

        // 重定义节点位置
        topLink.css({
            'right': right + 'px',
            'top': top + 'px'
        });
    },

    /**
     * 获取节点到屏幕右边的距离
     */
    _getDistanceToBottom: function(args) {
        var _self = args._self;

        // 节点到屏幕右边的距离 = (屏幕宽度 - 页面宽度) / 2 - 节点宽度 - 节点左边到页面右边的宽度 (20px), 如果到右边距离屏幕边界不小于 10px
        var right = parseInt((jQuery(window).width() - _self.config.pageWidth)/2 - _self.config.nodeWidth - 20, 10);
        if(right < 10) {
            right = 10;
        }

        return right;
    }
};

$(function(){
     (new GoTop()).init({
        pageWidth: 980,
        nodeId: 'go-top',
        nodeWidth: 70,
        distanceToBottom: 155,
        hideRegionHeight: 130,
        text: '回到顶部',
        isHidden: true
    });
    (new GoTop(function() {
        window.location = "http://www.doyouhike.net/doc/contact.html";
        //showComment();
    })).init({
        pageWidth: 980,
        nodeId: 'feedback',
        nodeWidth: 70,
        distanceToBottom: 95,
        hideRegionHeight: 130,
        text: '联系我们',
        isHidden: false
    });

    /*弹出意见反馈框*/
    function showComment() {
        /*显示阴影*/
        var cheight = document.body.clientHeight || document.documentElement.clientHeight;
        if (document.getElementById('comment_shade')) {
            document.getElementById('comment_shade').style.display = 'block';
            document.getElementById('comment_shade').style.height = cheight + 'px';
        } else {
            var shade = document.createElement('div');
            shade.className = 'shade';
            shade.id = "comment_shade";
            shade.style.height = cheight + 'px';
            document.body.appendChild(shade);
        }

        /*出现iframe*/
        var stop = document.documentElement.scrollTop || document.body.scrollTop;
        var innerHeight = window.innerHeight || document.documentElement.clientHeight;
        if (document.getElementById('comment_iframe')) {
            document.getElementById('comment_iframe').style.display = 'block';
            document.getElementById('comment_iframe').style.top = (innerHeight / 2 + stop) + 'px';
        } else {
            var iframe = document.createElement('iframe');
            iframe.id = 'comment_iframe';
            iframe.className = "comment_iframe";
            iframe.scrolling = 'no';
            iframe.frameBorder = '0';
            iframe.style.top = (innerHeight / 2 + stop) + 'px';
            document.body.appendChild(iframe);
            iframe.src = '/feedback/feedback'; //这句一定得写最后，不然ie6会是空白的
        }
    }
});