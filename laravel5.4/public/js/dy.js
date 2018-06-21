/**
 *
 *磨房全站通用js
 *
 **/
/*全局函数*/
//模拟alert弹出框alertLayer,第二参数是确定回调函数、第三个参数是取消回调函数
function alertLayer(content,callback,cancelcallback){

    showShade();
    if($('#info_tip').size()) $('#info_tip').remove();
    if($('.layer').size()) $('.layer').remove();

    var html = '';
    html += '<div class="layer alertLayer">';
    html += '    <div class="layer-title">';
    html += '        <p><span title="关闭" href="#" class="layer-close">&nbsp;</span><span>提示信息</span></p>';
    html += '    </div>';
    html += '    <div class="layer-content">';
    html += '        <p class="content-p">' + content + '</p>';
    html += '        <p class="button-p">';
    html += '            <a href="javascript:void(0);" class="button-mini layer-confirm current">确定</a>';
    html += '            <a href="javascript:void(0);" class="button-mini layer-cancel">取消</a>';
    html += '        </p>';
    html += '    </div>';
    html += '</div>';
    $('body').append(html);

    var layerHeight = $('.alertLayer').height();
    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    var windowHeight = $(window).height();
    $('.alertLayer').css('top',scrollTop+windowHeight/2).css('marginTop',-layerHeight/2-50);
    $('.alertLayer .layer-confirm').click(function(){
        if(typeof callback == 'function') callback();
        $('.alertLayer .layer-close').click();
    });
    $('.alertLayer .layer-cancel').click(function(){
        if(typeof cancelcallback == 'function') cancelcallback();
    });

}
function alert(msgs,callback){

    //让页面失去焦点
    if(document.activeElement){
        $(document.activeElement).blur();
    }
    if($('#info_tip').size()) $('#info_tip').remove();

    showShade();
    var html = '';

    html += '<div class="layer alertLayer">';
    html += '    <div class="layer-title">';
    html += '        <p><span title="关闭" href="#" class="layer-close">&nbsp;</span><span>提示信息</span></p>';
    html += '    </div>';
    html += '    <div class="layer-content">';
    html += '        <p class="content-p">' + msgs + '</p>';
    html += '        <p class="button-p">';
    html += '            <a href="javascript:void(0);" class="button-mini layer-confirm current">确定</a>';
    html += '        </p>';
    html += '    </div>';
    html += '</div>';
    //如果存在，先清除
    if($('.alertLayer').size()) $('.alertLayer').remove();
    $('body').append(html);

    var layerHeight = $('.alertLayer').height();
    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    var windowHeight = $(window).height();
    $('.alertLayer').css('top',scrollTop+windowHeight/2).css('marginTop',-layerHeight/2-50);
    $('.alertLayer .layer-close').click(function(){
        if(callback) callback();
    });
    $('.alertLayer .layer-confirm').click(function(){
        $('.alertLayer .layer-close').click();
    });
}
//出现阴影
function showShade(type){
    if(!$('#shade-bg').size()){
        if(type){
            $("body").append('<div class="shade-bg shade-bg1" id="shade-bg"></div>');
        }
        else{
            $("body").append('<div class="shade-bg" id="shade-bg" style="height: '+ $(document).height() +'px;"></div>');
        }
    }
}
//隐藏阴影
function closeShade(){
    $('#shade-bg').remove();
}

//自动消失信息提示弹窗，
function msgTip(content,callback){

    showShade();
    //if($('#info_tip').size()) $('#info_tip').remove();

    var html = '';
    html += '<div class="layer alertLayer auto-disappear">';
    html += '    <div class="layer-title">';
    html += '        <p><span>提示信息</span></p>';
    html += '    </div>';
    html += '    <div class="layer-content">';
    html += '        <p class="content-p">' + content + '</p>';
    html += '    </div>';
    html += '</div>';
    $('body').append(html);

    var layerHeight = $('.alertLayer').height();
    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    var windowHeight = $(window).height();
    $('.alertLayer').css('top',scrollTop+windowHeight/2).css('marginTop',-layerHeight/2-50);

    if(typeof callback == 'function') {
        setTimeout(function(){
            callback();
            //$(".auto-disappear").remove();
            //$("#shade-bg").remove();
        }, 700);
    };


}
//只有确认按钮的提示弹窗
function alertConfirm(content,callback){

    showShade();
    if($('#info_tip').size()) $('#info_tip').remove();

    var html = '';
    html += '<div class="layer alertLayer">';
    html += '    <div class="layer-title">';
    html += '        <p><span title="关闭" href="#" class="layer-close">&nbsp;</span><span>提示信息</span></p>';
    html += '    </div>';
    html += '    <div class="layer-content">';
    html += '        <p class="content-p">' + content + '</p>';
    html += '        <p class="button-p">';
    html += '            <a href="javascript:void(0);" class="button-mini layer-confirm current">确定</a>';
    html += '        </p>';
    html += '    </div>';
    html += '</div>';
    $('body').append(html);

    var layerHeight = $('.alertLayer').height();
    var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    var windowHeight = $(window).height();
    $('.alertLayer').css('top',scrollTop+windowHeight/2).css('marginTop',-layerHeight/2-50);
    $('.alertLayer .layer-confirm').click(function(){
        if(typeof callback == 'function') callback();
        $('.alertLayer .layer-close').click();
    });

}
/*键盘操作弹出层*/
if(!$('body').data("hasThisKeyupEvent")){
    $(document).keydown(function(e){
        if($(".alertLayer").size()){
            if (e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 9) {
                if($(".button-mini",".layer").length !== 1){
                    $(".button-mini.current").removeClass("current").siblings().addClass("current");
                }
                e.preventDefault();
            }
            if(e.keyCode == 13){
                //e.keyCode == 9;
                /*if($(".button-mini",".layer").length !== 1){
                    $(".button-mini.current").removeClass("current").siblings().addClass("current");
                }*/
                $("a.current",".layer").trigger('click',function(){
                });
                e.preventDefault();
            }

            $('body').data("hasThisKeyupEvent","hasThisKeyupEvent");//给body添加jquery data属性
        }
    });
}

//扩展日期格式化函数,参数是时间格式（例如：'yyyy-MM-dd hh:mm:ss'）
Date.prototype.format=function(fmt) {
    var o = {
        "M+" : this.getMonth()+1, //月份       
        "d+" : this.getDate(), //日      
        "h+" : this.getHours() == 0 ? 12 : this.getHours(), //小时       
        "H+" : this.getHours(), //小时       
        "m+" : this.getMinutes(), //分       
        "s+" : this.getSeconds(), //秒       
        "q+" : Math.floor((this.getMonth()+3)/3), //季度       
        "S" : this.getMilliseconds() //毫秒       
    };
    var week = {
        "0" : "\u65e5",
        "1" : "\u4e00",
        "2" : "\u4e8c",
        "3" : "\u4e09",
        "4" : "\u56db",
        "5" : "\u4e94",
        "6" : "\u516d"
    };

    if(/(y+)/.test(fmt)){
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }

    if(/(E+)/.test(fmt)){
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "\u661f\u671f" : "\u5468") : "")+week[this.getDay()+""]);
    }

    for(var k in o){
        if(new RegExp("("+ k +")").test(fmt)){
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        }
    }
    return fmt;
}
/*绑定到jquery的全局函数*/
$(function(){
    /*扩展到jQuery对象上*/
    $.extend({
        input : function(obj,num,tips){//input框输入限制
            if(!$('#'+tips).data('defaultValue')) $('#'+tips).data('defaultValue',$(obj).html());
            var reg = /[^\a-zA-Z\u4E00-\u9FA5\d]/g;
            if(reg.test(obj.value)){
                //针对mac系统下的safari浏览器使用搜狗输入法的处理
                if($.browser.safari && navigator.userAgent.indexOf('Macintosh')!=-1 && obj.value.indexOf('\'')!=-1) return;
                obj.value = obj.value.replace(reg,'');
                $('#'+tips).css('color','#c00').html('只允许输入'+ Math.ceil(num/2) +'个中文或'+ num +'个字母和数字').show();
            }
            else{

                var len = obj.value.replace(/[^\x00-\xff]/g,'**').length;
                $('#'+tips).css('color','').html($(obj).data('defaultValue'));
                if(len>num) {
                    var temp_len = obj.value.replace(/[^\x00-\xff]/g,'**').substr(0,len).replace(/[^*]/g,'').length;
                    temp_len = temp_len ? temp_len : 0;
                    temp_len = Math.ceil(temp_len/2);
                    obj.value = obj.value.substr(0,num-temp_len);
                    $('#'+tips).css('color','#c00').html('只允许输入'+ Math.ceil(num/2) +'个中文或'+ num +'个字母和数字').show();
                }
            }

        },
        str_cut : function(str,len){
            var byte_len = str.replace(/[^\x00-\xff]/g,'**').length;
            var temp_len = str.replace(/[^\x00-\xff]/g,'**').substr(0,len).replace(/[^*]/g,'').length;
            temp_len = temp_len ? temp_len : 0;
            temp_len = Math.ceil(temp_len/2);
            if(byte_len<len || byte_len==len) return str;

            return str.substr(0,len-temp_len)+'...';

        },
        /*获取对象长度*/
        getLength : function(obj){
            var length = 0;
            for(var k in obj){
                length++;
            }
            return length;
        },
        /*替换标签--可以执行js版本,可以多行匹配*/
        replaceTemplate : function(template,data){
            //处理html模板中的图片
            if(template.indexOf('rsrc=')!=-1)
                template = template.replace('rsrc=','src=');//处理图片地址
            /*url解码*/
            var htmlstring = '';
            var url_reg = new RegExp('%(\\n|.){2}','g');
            var url_result;
            var url_temp = template;
            while((url_result = url_reg.exec(url_temp)) != null){
                if(/%([0-9]|[a-f]|[A-F]){2}/.test(url_result[0])){

                }
                else{
                    var url_result_temp = url_result[0].replace('%','%25');
                    template = template.replace(url_result[0],url_result_temp);
                }
            }
            template = decodeURI(template);

            /*特殊码还原*/
            template = template.replace(/&lt;/g,'<');
            template = template.replace(/&gt;/g,'>');
            template = template.replace(/&amp;/g,'&');

            /*标记变量*/
            var old_reg = new RegExp('{#((\\n|.)*?)#}','mg');
            var old_temp = template;
            var x = 0;
            var x_obj = {};
            while((old_result = old_reg.exec(old_temp)) != null){
                x_obj['~p'+x+'~'] = old_result[0];
                template = template.replace(old_result[0],'~p'+x+'~');
                x++;
            }

            var y,x_obj_temp;
            for( y in x_obj ){
                x_obj_temp = x_obj[y].replace(/{@(.*?)}/g,'\'$&\'');
                template = template.replace(y,x_obj_temp);
            }

            /*for循环*/
            if(!data) data = [];
            for(var i=0; i<data.length; i++){
                for(tx in data[i]){//过滤数据中的换行符
                    if(typeof data[i][tx] == 'string') data[i][tx] = data[i][tx].replace('\n','');
                }
                var temp = template;
                var reg = new RegExp('{@(.*?)}','g');
                while((result = reg.exec(template)) != null){
                    var reg1 = new RegExp(result[0],'g');
                    if(result[1]=='key'){
                        temp = temp.replace(reg1,i);
                    }
                    else if(result[1]=='length'){
                        temp = temp.replace(reg1,data.length);
                    }
                    else{
                        temp = temp.replace(reg1,data[i][result[1]]);
                    }
                }
                htmlstring += temp;
            }
            htmlstring = htmlstring.replace(/undefined/g,'');

            /*解析if-else*/
            var if_reg = new RegExp('{#\\s*if\\s*\\(.*?\\)\\s*#}(\\n|.)*?{#\\s*/if\\s*#}','mg');
            var if_temp = htmlstring;
            while((if_result = if_reg.exec(if_temp)) != null){
                var if_reg1 = new RegExp('#}((\\r\\n|\\n|.)*?){#','mg');
                var if_x = if_result[0].replace(if_reg1,"{'$1'}");
                if_x = if_x.replace(/{#|#}/g,'');
                if_x = if_x.replace('/if','');
                if_x = if_x.replace(/\n|\r\n/g,'');
                htmlstring = htmlstring.replace(if_result[0],eval(if_x));
            }

            /*执行js*/
            var new_reg = new RegExp('{#((\\n|.)*?)#}','mg');
            var new_temp = htmlstring;
            while((new_result = new_reg.exec(new_temp)) != null){
                var temp_new_result = '';
                if(new_result[1].indexOf('\n')!=-1){
                    var temp_new_result = eval(new_result[1].replace(/\n/g,'%@@@%'));
                    temp_new_result = temp_new_result.replace(/%@@@%/g,'\n');
                }
                else{
                    temp_new_result = eval(new_result[1]);
                }
                htmlstring = htmlstring.replace(new_result[0],temp_new_result);
            }
            htmlstring = htmlstring.replace(/undefined/g,'');
            return htmlstring;
        },
        /*替换标签*/
        replaceString : function(template,data){
            var htmlstring = '';
            template = decodeURI(template);
            for(var i=0; i<data.length; i++){
                var temp = template;
                var reg = new RegExp('\{(.*?)\}','g');
                while((result = reg.exec(template)) != null){
                    var reg1 = new RegExp(result[0],'g');
                    if(result[1].indexOf('url:') != -1){
                        result[1] = result[1].replace('url:','');
                        temp = temp.replace(reg1,encodeURI(data[i][result[1]]));
                    }
                    else{
                        temp = temp.replace(reg1,data[i][result[1]]);
                    }
                }
                htmlstring += temp;
            }
            htmlstring = htmlstring.replace(/undefined/g,'');
            return htmlstring;
        },
        /*取得分页*/
        getPage : function(currpage,total,url,ele){
            if(total == '0' || total == '1' || !total) return;

            if(url.indexOf('fpage') != -1) url = url.replace('fpage='+$.getUrl(url,'fpage'),'fpage={page}');//url
            else url = url.replace('page='+$.getUrl(url,'page'),'page={page}');//url

            if(url.indexOf('{page}') == -1){
                var splitPage = url.split('/');
                if(!splitPage[splitPage.length-1]){
                    url = url += '{page}';
                }
                else if(!isNaN(splitPage[splitPage.length-1])){
                    splitPage.pop();//删除最后一个元素
                    url = splitPage.join('/') + '/{page}';
                }
                else{
                    url += '/{page}';
                }
            }

            //创建一个分页对象实例
            var testObj = new $.creatPageObject(currpage,total,url);
            //在页面上显示分页
            if((typeof ele).toLowerCase() == 'string'){
                if(ele.indexOf('#') == 0) ele = ele.substr(1,ele.length);
                $('#'+ele).html(testObj.createPage());
            }
            else if((typeof ele).toLowerCase() == 'object') $(ele).html(testObj.createPage());
        },
        /*获取url参数*/
        getUrl : function(url,name){
            if(url.indexOf('?')!=-1){
                var temp = decodeURI(url).substring(url.indexOf('?')+1,url.length);
                var arr = temp.split('&');
                for(var i=0; i<arr.length; i++){
                    var temp_arr = arr[i].split('=');
                    if(temp_arr[0] == name) return temp_arr[1];
                }
                return '';
            }
            else{
                return '';
            }
        },
        /*获取数据并写入*/
        getJsonData : function(url,target,source,pageId,options){
            if(target == source) if(!$(target).data('temp')) $(target).data('temp',$(source).html());

            if($(target).get(0).nodeName == 'TBODY'){
                $(target).html('<tr><td colspan="7" style="border:none;"><div class="hby_ajaxLoading"></div></td></tr>');
            }
            else{
                $(target).html('<div class="hby_ajaxLoading"></div>');
            }

            $.get(url,function(data){//获取数据
                if(options) data.result = $.changeData(data.result,options);//处理数据
                $.writeData(data,url,target,source,pageId);//写入数据
            },'json');
        },
        innerJsonData : function(url,target,source,pageId){
            if(target == source) if(!$(target).data('temp')) $(target).data('temp',$(source).html());

            if($(target).get(0).nodeName == 'TBODY'){
                $(target).html('<tr><td colspan="7" style="border:none;"><div class="hby_ajaxLoading"></div></td></tr>');
            }
            else{
                $(target).html('<div class="hby_ajaxLoading"></div>');
            }

            $.get(url,function(data){//获取数据
                $.innerData(data,url,target,source,pageId);//写入数据
            },'json');
        },
        /*处理数据*/
        changeData : function(data,options){
            //options = [{name : 'sex', value : {'0':'男','1':'女'}}];
            $.each(data,function(index,obj){
                for(var i=0; i<options.length; i++){
                    if((typeof options[i].value).toLowerCase() == 'string'){
                        data[index][options[i].name] = data[index][options[i].name] || options[i].value;
                    }
                    else{
                        data[index][options[i].name] = options[i].value[obj[options[i].name]];
                    }
                }
            });
            return data;
        },
        /*更新DOM*/
        writeData : function(data,url,target,source,pageId){
            var $targetObj = $(target);
            if(!$targetObj.data('temp')) $targetObj.data('temp',$(source).html());
            var htmlstring = $.replaceString($targetObj.data('temp'),data.result);
            $targetObj.empty().html(htmlstring).show().attr('ishave','yes');
            //构造分页
            if(pageId){
                $.getPage(data.page,data.tpage,url,pageId);
            }
        },
        innerData : function(data,url,target,source,pageId){
            var $targetObj = $(target);
            if(!$targetObj.data('temp')) $targetObj.data('temp',$(source).html());
            var htmlstring = $.replaceTemplate($targetObj.data('temp'),data.result);
            //无相关数据的时候
            if(!data.result) data.result = [];
            if(!$.getLength(data.result)){
                if($(target).get(0).nodeName == 'TBODY'){
                    htmlstring = '<tr><td colspan="7" style="border:none;"><div class="tc pt20 pb20">暂无相关数据</div></td></tr>';
                }
                else{
                    htmlstring = '<div class="tc pt20">暂无相关数据</div>';
                }
            }
            $targetObj.empty().html(htmlstring).show().attr('ishave','yes');
            //构造分页
            if(pageId){
                $.getPage(data.page,data.tpage,url,pageId);
            }
        },
        /*构造分页对象*/
        creatPageObject : function(currpage,total,url,options,template,template_ellipsis){
            this.currpage = parseInt(currpage);
            this.total = parseInt(total);
            this.url = url;
            this.template = template || '<li{currpage}><a href="{url}">{page}</a></li>';
            this.template_ellipsis = template_ellipsis || '<li>{page}</li>';
            this.options = options || {};
            this.options.first = this.options.first || 2;
            this.options.last = this.options.last || 2;
            this.options.left = this.options.left || 3;
            this.options.right = this.options.right || 2;
            this.options.allShowNum = this.options.allShowNum || 0;
            this.error = false;
            this.msg = '初始化过程中发生了以下错误：\n';
            this.init();
        }
    });
    $.creatPageObject.prototype.init = function(){
        if(!this.isInteger(this.currpage)){
            this.error = true;
            this.msg += '当前页必须是正整数\n';
        }
        if(!this.isInteger(this.total)){
            this.error = true;
            this.msg += '总页数必须是正整数\n';
        }
        if(!this.isInteger(this.options.left)){
            this.error = true;
            this.msg += 'options参数中的left必须是正整数\n';
        }
        if(!this.isInteger(this.options.right)){
            this.error = true;
            this.msg += 'options参数中的right必须是正整数\n';
        }
        if(!this.isInteger(this.options.allShowNum)){
            this.error = true;
            this.msg += 'options参数中的allShowNum必须是正整数\n';
        }
        if(!this.isInteger(this.options.first)){
            this.error = true;
            this.msg += 'options参数中的first必须是正整数\n';
        }
        if(!this.isInteger(this.options.last)){
            this.error = true;
            this.msg += 'options参数中的last必须是正整数\n';
        }
        if(this.error){
            this.show(this.msg);
            return;
        }
        if(this.currpage>this.total){
            this.error = true;
            this.msg += '当前页数不能大于总页数\n';
        }
        if(this.error){
            this.show(this.msg);
            return;
        }
    };
    $.creatPageObject.prototype.isInteger = function(num){
        if(isNaN(num)) return false;
        else{
            var regExp = new RegExp('^\\d+$','g');
            if(!regExp.test(num)){
                return false;
            }
        }
        return true;
    }
    $.creatPageObject.prototype.show = function(msg){
        alert(msg);
    };
    $.creatPageObject.prototype.createPage = function(){
        if(this.error){
            //this.show(this.msg);
            return 0;
        }
        var htmlstring = '';
        var data = { url:'', page: '', currpage: '' };
        //添加上一页
        //if(this.currpage != 1) htmlstring += '<li><a href="'+this.url.replace(/{.*}/g,this.currpage-1)+'">上一页</a></li>';
        if(this.currpage > 1) {
            data.url = this.url.replace(/{.*}/g,this.currpage-1);
            data.page = '« Prev';
            htmlstring += this.replaceTemplate(this.template,data);
        }
        if(this.options.allShowNum){
            if(this.total <= this.options.allShowNum) htmlstring += this.showPage1();
            else htmlstring += this.showPage2();
        }
        else {
            htmlstring += this.showPage2();
        }
        //添加下一页
        //if(this.currpage < this.total) htmlstring += '<li><a href="'+this.url.replace(/{.*}/g,this.currpage+1)+'">下一页</a></li>';
        if(this.currpage < this.total) {
            data.url = this.url.replace(/{.*}/g,this.currpage+1);
            data.page = 'Next »';
            htmlstring += this.replaceTemplate(this.template,data);
        }
        htmlstring = '<ul>'+ htmlstring + '</ul>';
        return htmlstring;
    };
    $.creatPageObject.prototype.showPage1 = function(){
        var htmlstring = '';
        var data = { url:'', page: '', currpage: '' };
        for (var i=1; i<=this.total; i++){
            //if(this.currpage==i) htmlstring += '<li class="hby_curr"><a href="'+this.url.replace(/{.*}/g,i)+'">'+ i +'</a></li>';
            //else htmlstring += '<li><a href="'+this.url.replace(/{.*}/g,i)+'">'+ i +'</a></li>';
            data.url = this.url.replace(/{.*}/g,i);
            data.page = i;
            if(this.currpage==i) data.currpage = ' class="active"';
            else data.currpage = '';
            htmlstring += this.replaceTemplate(this.template,data);
        }
        return htmlstring;
    };
    $.creatPageObject.prototype.showPage2 = function(){
        var htmlstring = '';
        var data = { url:'', page: '', currpage: '' };
        //开始部分
        for(var m=1; m<=this.options.first; m++){
            if(m<=this.total){
                //if(m==this.currpage) htmlstring += '<li class="hby_curr"><a href="'+this.url.replace(/{.*}/g,m)+'">'+ m +'</a></li>';
                //else htmlstring += '<li><a href="'+this.url.replace(/{.*}/g,m)+'">'+ m +'</a></li>';
                data.url = this.url.replace(/{.*}/g,m);
                data.page = m;
                if(this.currpage==m) data.currpage = ' class="active"';
                else data.currpage = '';
                htmlstring += this.replaceTemplate(this.template,data);
            }
        }
        //出现省率号
        if(this.currpage-this.options.left-this.options.first>1){
            if(this.currpage-this.options.left-this.options.first>2){
                data.url = '';
                data.page = '...';
                data.currpage = '';
                htmlstring += this.replaceTemplate(this.template_ellipsis,data);
            }
            else{
                data.url = this.url.replace(/{.*}/g,this.options.first+1);
                data.page = this.options.first+1;
                data.currpage = '';
                htmlstring += this.replaceTemplate(this.template,data);
            }
        }
        //当前页附近循环
        if(this.total-this.options.last>this.options.first){
            var i = (this.currpage-this.options.left) > this.options.first ? (this.currpage-this.options.left) : (this.options.first+1);
            var i_big = (this.currpage+this.options.right) < (this.total - this.options.last) ? (this.currpage+this.options.right) : (this.total - this.options.last);
            for( i; i<=i_big; i++ ){
                data.url = this.url.replace(/{.*}/g,i);
                data.page = i;
                if(this.currpage==i) data.currpage = ' class="active"';
                else data.currpage = '';
                htmlstring += this.replaceTemplate(this.template,data);
            }
        }
        //出现省率号
        if(this.total-this.options.last>this.currpage+this.options.right){
            if(this.total-this.options.last>this.currpage+this.options.right+1){
                data.url = '';
                data.page = '...';
                data.currpage = '';
                htmlstring += this.replaceTemplate(this.template_ellipsis,data);
            }
            else{
                data.url = this.url.replace(/{.*}/g,this.currpage+this.options.right+1);
                data.page = this.currpage+this.options.right+1;
                data.currpage = '';
                htmlstring += this.replaceTemplate(this.template,data);
            }
        }
        //结尾部分
        if(this.options.first < this.total){
            var n = (this.total-this.options.last) > this.options.first ? (this.total-this.options.last+1) : (this.options.first + 1);
            for(n; n<=this.total; n++){
                if(n>this.options.first){
                    //if(n==this.currpage) htmlstring += '<li class="hby_curr"><a href="'+this.url.replace(/{.*}/g,n)+'">'+ n +'</a></li>';
                    //else htmlstring += '<li><a href="'+this.url.replace(/{.*}/g,n)+'">'+ n +'</a></li>';
                    data.url = this.url.replace(/{.*}/g,n);
                    data.page = n;
                    if(this.currpage==n) data.currpage = ' class="active"';
                    else data.currpage = '';
                    htmlstring += this.replaceTemplate(this.template,data);
                }
            }
        }
        return htmlstring;
    };
    $.creatPageObject.prototype.replaceTemplate = function(template,data){
        var htmlstring = '';
        template = decodeURI(template);
        var temp = template;
        var reg = new RegExp('\{(.*?)\}','g');
        while((result = reg.exec(template)) != null){
            var reg1 = new RegExp(result[0],'g');
            if(result[1].indexOf('url:') != -1){
                result[1] = result[1].replace('url:','');
                temp = temp.replace(reg1,encodeURI(data[result[1]]));
            }
            else{
                temp = temp.replace(reg1,data[result[1]]);
            }
        }
        htmlstring += temp;
        htmlstring = htmlstring.replace(/undefined/g,'');
        return htmlstring;
    };

});
/*通用组件*/
$(function(){

    //通用切换
    $('.tab .tabtitle').click(function(){
        var $tab = $(this).parents('.tab').first();
        var $tabtitle = $tab.find('.tabtitle');
        var $tabpane = $tab.find('.tabpane');
        var indexId = 0;
        var that = this;

        /*循环标题*/
        $.each($tabtitle,function(index){
            $(this).removeClass('active');
            if(this==that) indexId = index;
        });
        $(this).addClass('active');//当前标题

        /*循环容器*/
        $.each($tabpane,function(){
            $(this).hide();
        });
        $tabpane.eq(indexId).show();

        return false;
    });
    //切换初始化
    (function(){
        var $tabs = $('.tab');
        $.each($tabs,function(){
            $(this).find('.tabtitle').removeClass('active').first().addClass('active');
            $(this).find('.tabpane').hide().first().show();
        });
    })();

    //默认页构造分页
    $(function(){
        $.each($('.page'),function(){
            if( $(this).attr('total') && ($(this).attr('url') || $(this).attr('ajaxUrl')) ){
                var that = this;
                var temp_currPage = $(this).attr('page') || 1;//当前页
                var temp_totalPage = $(this).attr('total');//总页数
                var temp_url = $(this).attr('url') || $(this).attr('ajaxUrl');//分页地址
                var temp_container = $(this);//分页容器
                $.getPage(temp_currPage,temp_totalPage,temp_url,temp_container);

                if($(this).attr('ajaxUrl')&&$(this).attr('targetId')&&$(this).attr('sourceId')&&$(this).attr('pageId')){
                    $(this).find('a').live('click',function(){
                        ajaxSend($(that),'',$(this).attr('href'));
                        return false;
                    });
                    $(this).data('isbind',1);//已绑定
                }

            }
        });
    });

    /*聚焦*/
    $('[action="focus"]').focus(function(){
        if(this.value == this.defaultValue){
            this.value = '';
        }
        $(this).css('color','#2b2b2b');
    }).blur(function(){
            if(this.value==''){
                this.value = this.defaultValue;
                $(this).css('color','#9c9c9c');
            }
        });
    /*聚焦初始化*/
    (function(){
        $('[action="focus"]').css('color','#9c9c9c');
    })();

    /*时间控件*/
    if($('#dateLine').size()){
        $("#dateLine").click(function(){
            WdatePicker({
                skin : 'whyGreen',
                dateFmt : 'yyyy-MM-dd'
            });
        });
    }

    /*验证新建相册框*/
    if($('#my-gallery-layer').size()){
        $('#my-gallery-layer form').validate({
            /*自定义验证规则*/
            rules : {
                'sets_name' : { required : true }
            },
            /*提示信息*/
            messages : {
                'sets_name' : '相册名称不能为空'
            },
            /*错误提示位置*/
            errorPlacement : function(error, element){
                $('<span class="help-block"></span>').html(error).insertAfter(element);
            },
            focusInvalid : true
        });
        //触发提交
        $('#my-gallery-layer-submit').click(function(){
            $('#my-gallery-layer form').submit();
        });
    }

    /*上传图片*/
    if($('#galleryUploadBox').size()){
        //创建相册
        $('#createGallery').click(function(){

            showShade();
            if($('#galleryUploadBox').get(0).className.indexOf('resources_galleryUploadBox') != -1){
                if($('#my-gallery-layer').size()){
                    $("#my-gallery-layer").css('top',$('#createGallery').offset().top).show();
                }
                else{
                    $(document.body).append($('#newGalleryTemplate').html());
                    //验证表单
                    $('#my-gallery-layer form').validate({
                        /*自定义验证规则*/
                        rules : {
                            'sets_name' : { required : true }
                        },
                        /*提示信息*/
                        messages : {
                            'sets_name' : '相册名称不能为空'
                        },
                        /*错误提示位置*/
                        errorPlacement : function(error, element){
                            $('<span class="help-block"></span>').html(error).insertAfter(element);
                        },
                        focusInvalid : true
                    });

                    $('#my-gallery-layer form').ajaxForm({
                        dataType:'json',
                        success: function(data){
                            if(parseInt(data.error) == 0){
                                //刷新附件中全部图片中的文件夹
                                if(typeof ResBrowser != 'undefined'){
                                    ResBrowser.photos = null;
                                }

                                var select = $('#GallerySelectListItem').get(0);
                                //清空下拉
                                var selectLength = select.options.length;
                                for(var i=0; i<selectLength; i++){
                                    select.remove(1);
                                }
                                //添加新的下拉
                                for(var k=0; k<data.result.length; k++){
                                    var option = new Option(data.result[k].Name, data.result[k].SetID);
                                    select.options.add(option);
                                }
                                //跳到新建的相册选项
                                for(var j=0; j<select.options.length; j++){
                                    if(select.options[j].value == data.new_setsID) select.options[j].selected = true;
                                }
                                $(".layer-close").click();

                                //清空数据
                                $('#my-gallery-layer input[name="sets_name"]').val('');
                                $('#my-gallery-layer [name="sets_desc"]').val('');
                                $('#my-gallery-layer select[name="access"]').get(0).options[0].selected = true;
                                $('#my-gallery-layer input[name="dateLine"]').val($('#my-gallery-layer input[name="dateLine"]').get(0).defaultValue);
                                $('#my-gallery-layer select[name="category"]').get(0).options[0].selected = true;
                                $('#my-gallery-layer select[name="hide_exif"]').get(0).options[0].selected = true;

                            }
                            else{
                                alert(data.msgs);
                            }
                        }
                    });

                    //时间控件
                    $("#dateLine").click(function(){
                        WdatePicker({
                            skin : 'whyGreen',
                            dateFmt : 'yyyy-MM-dd'
                        });
                    });

                    //触发提交
                    $('#my-gallery-layer-submit').click(function(){
                        $('#my-gallery-layer form').submit();
                    });

                    $("#my-gallery-layer").css('top',$('#createGallery').offset().top).show();
                }
            }
            else{
                $("#my-gallery-layer").show();
            }
            return false;
        });
        //ajax提交新建相册框
        $('#my-gallery-layer form').ajaxForm({
            dataType:'json',
            success: function(data){

                if(parseInt(data.error) == 0){

                    var select = $('#GallerySelectListItem').get(0);
                    //清空下拉
                    var selectLength = select.options.length;
                    for(var i=0; i<selectLength; i++){
                        select.remove(1);
                    }
                    //添加新的下拉
                    for(var k=0; k<data.result.length; k++){
                        var option = new Option(data.result[k].Name, data.result[k].SetID);
                        select.options.add(option);
                    }
                    //跳到新建的相册选项
                    for(var j=0; j<select.options.length; j++){
                        if(select.options[j].value == data.new_setsID) select.options[j].selected = true;
                    }
                    $(".layer-close").click();

                    //清空数据
                    $('#my-gallery-layer input[name="sets_name"]').val('');
                    $('#my-gallery-layer [name="sets_desc"]').val('');
                    $('#my-gallery-layer select[name="access"]').get(0).options[0].selected = true;
                    $('#my-gallery-layer input[name="dateLine"]').val($('#my-gallery-layer input[name="dateLine"]').get(0).defaultValue);
                    $('#my-gallery-layer select[name="category"]').get(0).options[0].selected = true;
                    $('#my-gallery-layer select[name="hide_exif"]').get(0).options[0].selected = true;

                }
                else{
                    alert(data.msgs);
                }
            }
        });


        //删除临时上传图片
        $('#thumbnails .delLink').live('click',function(){
            if(confirm('您确定要删除这张图片吗？')){
                var that = this;
                var url = $(this).attr('ajaxUrl');
                var requestData = {};
                $.get(url,requestData,function(data){
                    if(parseInt(data.error) == 0){
                        //alert(data.msgs);
                        var imgSize = $(that).parents('li').first().attr('imgSize');
                        $(that).parents('li').first().remove();

                        var imgId = '';
                        $.each($('#thumbnails li'),function(){
                            if($(this).attr('imgID')) imgId += $(this).attr('imgID')+',';
                        });
                        $('#imgUploadIDList').val(imgId);

                        //计算上传数量
                        var num = parseInt($('#divStatus').html());
                        num = num-1 < 0 ? 0 : num-1;
                        $('#divStatus').html(num);
                        if(!$('#thumbnails li').size()){
                            $('#NoImgBox').css({'height':'auto'});
                            $('#uploadBar').hide();
                        }

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
                        alert(data.msgs);
                    }
                },'json');
            }
            return false;
        });
        //上传图片
        function uploadImg(url){
            var requestData = {};
            requestData.setsID = $('#GallerySelectListItem').val();
            var imgIdList = $('#imgUploadIDList').val();
            if(!imgIdList){
                alert('您还没有上传任何图片');
                return false;
            }
            imgIdList = imgIdList.substr(0,imgIdList.length-1);
            requestData.imgIdList = imgIdList;
            $.get(url,requestData,function(data){
                if(parseInt(data.error) == 0){

                    if(typeof ResTab != 'undefined'){
                        ResBrowser.showMessage('<span style="color: green">文件上传成功，请稍候...</span>');
                        ResBrowser.recent = null;
                        ResBrowser.uploadPhoto = null;

                        setTimeout("ResTab.tabs['recent'].activate()", 2000);
                        //ResTab.tabs[ResTab.activeId].workarea.innerHTML = ResTab.uploadPhotoTemplate;
                        $('#thumbnails').html('');
                        $('#NoImgBox').css('height','auto');
                        $('#uploadBar').hide();
                    }
                    else{
                        $('#imgUploadIDList').val('');
                        window.location.href = '/gallery/gallery/index?sid=' + data.setId;
                    }
                }
                else{
                    alert(data.msgs);
                }
            },'json');
        }
        $('#uploadBarButton').click(function(){
            //无效状态不能点击
            if(this.className.indexOf('button-disable') != -1) return false;

            var url = $(this).attr('ajaxUrl');
            var setsID = $('#GallerySelectListItem').val();
            if(setsID==0){
                alertLayer('您没有选择上传相册，是否添加至默认相册？',function(){
                    uploadImg(url);
                });
                return false;
            }
            else{
                uploadImg(url);
                return false;
            }

        });
    }

    /*关闭弹出框*/
    $(".layer-close,.layer-cancel").live('click',function(){
        closeShade();
        var parent = $(this).parents('.layer').first();
        if(parent.hasClass('alertLayer')) parent.remove();
        else parent.hide();

        //$('.layer').hide();
    });

    /*新功能提示效果*/
    function faceOut(){
        var t = document.interval || 1000;
        document.faceOut = true;
        $('.new_gallery_face').animate({left:'-=34px',opacity:'1'},1000,function(){
            document.faceOut = false;
            if(document.faceOutIs) return
            document.faceTime = setTimeout(function(){
                faceIn();
            },t);
        });
    }
    function faceIn(){
        var t = document.interval || 1000;
        document.faceIn = true;
        $('.new_gallery_face').animate({left:'+=34px',opacity:'0'},1000,function(){
            document.faceIn = false;
            document.faceTime = setTimeout(function(){
                faceOut();
            },t);
        });
    }
    (function(){
        if($.cookie('new_gallery')||!$('.new_gallery_face').size()) return;
        $('.new_gallery_face').show();
        //绑定弹出函数
        $('#LogoImg,.new_gallery_face').click(function(){
            $.cookie('new_gallery','1',{expires: 365});

            $('.new_gallery_tips').animate({top:'+190px',left:'-=210px',height:'480px',width:'618px',opacity:'1'},500,function(){
                $('#LogoImg').unbind();
                $('.new_gallery_face').remove();
            });
            return false;
        });
        $('.new_gallery_face').hover(function(){

        },function(){

        });
        //开始淡出
        faceOut();
    })()
    //关闭提示
    $('.indexCloseTips').click(function(){
        //var left = $('#LogoImg').offset().left;
        $('.new_gallery_tips').animate({top:'10px',left:'383px',height:'0',width:'0',opacity:'0'},500,function(){
            $(this).remove();
            faceIn();
        });
        $.cookie('new_gallery','1',{expires: 365});
        return false;
    });
    //马上体验
    $('.indexNowGo').click(function(){
        $.cookie('new_gallery','1',{expires: 365});
        return true;
    });

    //广告浮动
    if($('.right_col_flowbit').size()){
        $(window).scroll(function(){

            var scrollTop = $(window).scrollTop();

            var top = $('.right_col_flowbitBox').offset().top;
            var width = $('.right_col_flowbitBox').width();
            var height = $('.right_col_flowbit').height();
            var windowWidth = $(window).width();
            var windowHeight = $(window).height();
            var footTop = $('#footer').offset().top;
            if(scrollTop + height > footTop - 70){
                $('.right_col_flowbit').css('position','static');
                return;
            }
            if(windowWidth<996){
                if(scrollTop>=top) $('.right_col_flowbit').css('position','absolute').css('top',scrollTop+10).css('width',width);
                else $('.right_col_flowbit').css('position','static');
            }
            else{
                if(scrollTop>=top) $('.right_col_flowbit').css('position','fixed').css('top','10px').css('width',width);
                else $('.right_col_flowbit').css('position','static');
            }


        });
    }

});


//旧的commmon.js
// legacy functions

Number.prototype.NaN0 = function ()
{
    return isNaN(this) ? 0 : this;
}

if (!Array.prototype.push)
{
    Array.prototype.push = function (item)
    {
        this[this.length] = item;
    }
}

if (!Array.prototype.indexOf)
{
    Array.prototype.indexOf = function(elt /*, from*/)
    {
        var len = this.length;

        var from = Number(arguments[1]) || 0;
        from = (from < 0)
            ? Math.ceil(from)
            : Math.floor(from);
        if (from < 0)
            from += len;

        for (; from < len; from++)
        {
            if (from in this &&
                this[from] === elt)
                return from;
        }
        return -1;
    };
}

var currentWidth = window.innerWidth;

function addEvent(o, e, m)
{
    if (browser.isIE)
    {
        o.attachEvent('on' + e, m);
    }
    else
    {
        o.addEventListener(e, m, false);
    }
}

function setOpacity(obj, opacity)
{
    if (document.all)
    {
        obj.style.filter = 'alpha(opacity=' + opacity * 100 + ')';
    }
    else
    {
        obj.style.opacity = opacity;
    }
}

browser = new function ()
{
    this.isIE    = false;
    this.isOP    = false;
    this.isNS    = false;

    var userAgent = navigator.userAgent;

    if (userAgent.indexOf("MSIE") != -1 && document.all)
    {
        this.isIE = true;
        return;
    }

    if (window.opera)
    {
        this.isOP = true;
        return;
    }

    if (userAgent.indexOf('Gecko') != -1 || userAgent.indexOf('Netscape6/') != -1)
    {
        this.isNS = true;
        return;
    }
}

function getPosition(obj)
{
    var left = 0;
    var top  = 0;

    while (obj.offsetParent)
    {
        left += obj.offsetLeft + (obj.currentStyle ? (parseInt(obj.currentStyle.borderLeftWidth)).NaN0() : 0);
        top  += obj.offsetTop  + (obj.currentStyle ? (parseInt(obj.currentStyle.borderTopWidth)).NaN0() : 0);
        obj   = obj.offsetParent;
    }

    left += obj.offsetLeft + (obj.currentStyle ? (parseInt(obj.currentStyle.borderLeftWidth)).NaN0() : 0);
    top  += obj.offsetTop  + (obj.currentStyle ? (parseInt(obj.currentStyle.borderTopWidth)).NaN0() : 0);

    return {x:left, y:top};
}

function isChild(obj, pid)
{
    var obj = typeof(obj) != 'object' ? document.getElementById(obj) : obj;

    if (obj.id == pid)
    {
        return true;
    }

    while (obj.parentNode)
    {
        if (obj.parentNode.id == pid)
        {
            return true;
        }

        obj = obj.parentNode;
    }

    return false;
}

// for resource.js

function downloadUrl(url, callback, data)
{
    // init
    url += url.indexOf("?") >= 0 ? "&" : "?";
    url += "random_download_url=" + Math.random();

    if (typeof data == 'undefined')
    {
        var data = null;
    }

    method = data ? 'POST' : 'GET';

    // create XMLHttpRequest object
    if (window.XMLHttpRequest)
    {
        var objXMLHttpRequest = new XMLHttpRequest();
    }
    else
    {
        var MSXML = ['Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.3.0'];
        for(var n = 0; n < MSXML.length; n ++)
        {
            try
            {
                var objXMLHttpRequest = new ActiveXObject(MSXML[n]);
                break;
            }
            catch(e)
            {
            }
        }
    }

    // send request
    with(objXMLHttpRequest)
    {
        //setTimeouts(30*1000,30*1000,30*1000,30*60*1000);
        try
        {
            open(method, url, true);

            if (method == 'POST')
            {
                setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            }

            send(data);
        }
        catch(e)
        {
            alert(e);
        }

        // on ready
        onreadystatechange = function()
        {
            if (objXMLHttpRequest.readyState == 4)
            {
                callback(objXMLHttpRequest.responseText, objXMLHttpRequest.status);
                delete(objXMLHttpRequest);
            }
        }
    }
}

// date format

Date.prototype.format = function(mask) {

    var d = this;

    var zeroize = function (value, length) {

        if (!length) length = 2;

        value = String(value);

        for (var i = 0, zeros = ''; i < (length - value.length); i++) {

            zeros += '0';

        }

        return zeros + value;

    };

    return mask.replace(/"[^"]*"|'[^']*'|\b(?:d{1,4}|m{1,4}|yy(?:yy)?|([hHMstT])\1?|[lLZ])\b/g, function($0) {

        switch($0) {

            case 'd':   return d.getDate();

            case 'dd':  return zeroize(d.getDate());

            case 'ddd': return ['Sun','Mon','Tue','Wed','Thr','Fri','Sat'][d.getDay()];

            case 'dddd':    return ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][d.getDay()];

            case 'M':   return d.getMonth() + 1;

            case 'MM':  return zeroize(d.getMonth() + 1);

            case 'MMM': return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][d.getMonth()];

            case 'MMMM':    return ['January','February','March','April','May','June','July','August','September','October','November','December'][d.getMonth()];

            case 'yy':  return String(d.getFullYear()).substr(2);

            case 'yyyy':    return d.getFullYear();

            case 'h':   return d.getHours() % 12 || 12;

            case 'hh':  return zeroize(d.getHours() % 12 || 12);

            case 'H':   return d.getHours();

            case 'HH':  return zeroize(d.getHours());

            case 'm':   return d.getMinutes();

            case 'mm':  return zeroize(d.getMinutes());

            case 's':   return d.getSeconds();

            case 'ss':  return zeroize(d.getSeconds());

            case 'l':   return zeroize(d.getMilliseconds(), 3);

            case 'L':   var m = d.getMilliseconds();

                if (m > 99) m = Math.round(m / 10);

                return zeroize(m);

            case 'tt':  return d.getHours() < 12 ? 'am' : 'pm';

            case 'TT':  return d.getHours() < 12 ? 'AM' : 'PM';

            case 'Z':   return d.toUTCString().match(/[A-Z]+$/);

            // Return quoted strings with the surrounding quotes removed     

            default:    return $0.substr(1, $0.length - 2);

        }

    });

};

// tabify

jQuery.fn.extend({

    tabify: function($tab) {

        return this.each(function() {

            $(this).find('li').each(function(){

                if($tab && $(this).attr('rel') == $tab)
                {
                    $(this).addClass('tab_active');
                };

                if($(this).hasClass('tab_active'))
                    $('#'+$(this).attr('rel')).show();
                else
                    $('#'+$(this).attr('rel')).hide();
                $(this).click(function(){
                    $(this).parent().find('li').each(function(){
                        $(this).removeClass('tab_active');
                        $('#'+$(this).attr('rel')).hide();
                    });
                    $('#'+$(this).attr('rel')).show();
                    $(this).addClass('tab_active');
                    $('a').blur();
                    return false;
                })
            });
        });
    }
});

// lazyload

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(5($){$.J.L=5(r){8 1={d:0,A:0,b:"h",v:"N",3:4};6(r){$.D(1,r)}8 m=9;6("h"==1.b){$(1.3).p("h",5(b){8 C=0;m.t(5(){6(!$.k(9,1)&&!$.l(9,1)){$(9).z("o")}j{6(C++>1.A){g B}}});8 w=$.M(m,5(f){g!f.e});m=$(w)})}g 9.t(5(){8 2=9;$(2).c("s",$(2).c("i"));6("h"!=1.b||$.k(2,1)||$.l(2,1)){6(1.u){$(2).c("i",1.u)}j{$(2).K("i")}2.e=B}j{2.e=x}$(2).T("o",5(){6(!9.e){$("<V />").p("X",5(){$(2).Y().c("i",$(2).c("s"))[1.v](1.Z);2.e=x}).c("i",$(2).c("s"))}});6("h"!=1.b){$(2).p(1.b,5(b){6(!2.e){$(2).z("o")}})}})};$.k=5(f,1){6(1.3===E||1.3===4){8 7=$(4).F()+$(4).O()}j{8 7=$(1.3).n().G+$(1.3).F()}g 7<=$(f).n().G-1.d};$.l=5(f,1){6(1.3===E||1.3===4){8 7=$(4).I()+$(4).U()}j{8 7=$(1.3).n().q+$(1.3).I()}g 7<=$(f).n().q-1.d};$.D($.P[\':\'],{"Q-H-7":"$.k(a, {d : 0, 3: 4})","R-H-7":"!$.k(a, {d : 0, 3: 4})","S-y-7":"$.l(a, {d : 0, 3: 4})","q-y-7":"!$.l(a, {d : 0, 3: 4})"})})(W);',62,62,'|settings|self|container|window|function|if|fold|var|this||event|attr|threshold|loaded|element|return|scroll|src|else|belowthefold|rightoffold|elements|offset|appear|bind|left|options|original|each|placeholder|effect|temp|true|of|trigger|failurelimit|false|counter|extend|undefined|height|top|the|width|fn|removeAttr|lazyload|grep|show|scrollTop|expr|below|above|right|one|scrollLeft|img|jQuery|load|hide|effectspeed'.split('|'),0,{}))

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

// global document.ready functions

$(document).ready(function() {

    // IE 6 must die !!!
    $("#site_nav>ul>li>ul>li>a").bind('mouseenter mouseleave', function() {
        $(this).toggleClass('menuitem');
    });

    $("#site_nav>ul>li").bind('mouseenter', function() {
        $(this).children('ul').show().css("z-index", "999");
    });

    $("#site_nav>ul>li").bind('mouseleave', function() {
        $(this).children('ul').hide();
    });

    $(".user_tip,.drop_menu").live('mouseleave', function() {
        //$(".user_tip").remove();
        //$(".drop_menu").hide();
    });

    $('a[rel="external"]').live("click", function() {
        window.open( $(this).attr('href') );
        return false;
    });

    $('a[rel^="info_"]').each(function() {
        var params = $(this).attr('rel').substr(5).split('_');
        var type = params.shift();
        //var offset = $(this).offset();
        $(this).addClass('info_' + type);
        $(this).attr('href', "###");
        /*$(this).live('click', function(e) {
         $("#info_tip").remove();
         $(this).after('<div id="info_tip" class="user_tip"><p style="padding:0 6px;">loading...</p></div>');
         $("#info_tip").load("/info/?act=" + type + "&param=" + params);
         return false;
         });*/
    });

    $('a[rel^="info_"]:not("object")').live('click',function(){

        //clearTimeout(document.info_tip_timer);

        var params = $(this).attr('rel').substr(5).split('_');
        var userName = $(this).attr('username');
        var type = params.shift();
        //var offset = $(this).offset();
        $(this).addClass('info_' + type);
        $(this).attr('href', "###");
        var that = this;

        $("#info_tip").remove();

        var callBackType = $(this).attr('callBackType');
        $(that).after('<div id="info_tip" class="user_tip"><p style="padding:0 6px 6px;">loading...</p></div>');
        $("#info_tip").attr('callBackType',callBackType);

        if(!userName) $("#info_tip").load("/info/?act=" + type + "&param=" + params);
        else{
            $("#info_tip").load("/info/?act=" + type + "&userName=" + userName);
        }
        return false;
    });
    $('body').click(function(e){
        var $obj = $(e.target).parents('#info_tip');
        if(!$obj.size()) $('#info_tip').remove();
    });
    //信息框里的加关注
    $('.info_tip_addFollow').live('click',function(){
        var that = this;
        var url = $(this).attr('ajaxUrl');
        var callBackType = $("#info_tip").attr('callBackType');
        $.get(url,function(data){
            if(parseInt(data.error) == '0'){
                $(that).html('取消关注').removeClass('info_tip_addFollow').addClass('info_tip_cancelFollow').attr('ajaxUrl',url.replace('add','cancel'));
                if(callBackType == 'myIndex'){//个人主页猜你认识
                    alert(data.msgs,function(){
                        //猜你认识
                        ajaxSend($('#my-interest-content'));
                    });
                }
                else if(callBackType == 'myInterest'){//关注管理-我感兴趣的人
                    ajaxSend($('#my-interest-content'));
                    if($('#my-follow-her').size()) ajaxSend($('#my-follow-her-a'));
                }
                else if(callBackType == 'myFollow'){//关注管理-我关注的人

                }
                else if(callBackType == 'myFans'){//关注管理-关注我的人
                    var $obj = $('#her-follow-my-a');
                    var ajaxUrl = $('#her-follow-my-a').attr('ajaxUrl');
                    var currPage = $('#her-follow-page').attr('currPage');
                    currPage = currPage ? currPage : 1;
                    ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
                    ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                }
                else if(callBackType == 'mySeach'){//关注管理-搜索结果
                    var $obj = $('#my-search-page');
                    var ajaxUrl = $('#my-search-page').attr('ajaxUrl');
                    var currPage = $('#my-search-page').attr('currPage');
                    currPage = currPage ? currPage : 1;
                    ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
                    ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                }
                else if(callBackType == 'myHome'){//个人主页
                    if(myHomeIsOwn && isFollowAndFans){
                        window.location.reload();
                    }
                }
                else if(callBackType == 'myHomeFollow'){//个人主页-我关注的人
                    if(myHomeIsOwn && isFollowAndFans){
                        window.location.reload();
                    }
                    else if(myHomeIsOwn && !isFollowAndFans){
                        //刷新我关注的人
                        if($('#my-interest-per').size()){
                            ajaxSend($('#my-interest-per'),function(data){
                                $('#my-interest-num').html(data.total);
                            });
                        }
                    }
                }
            }
            else{
                alert(data.msgs);
            }
        },'json');
        return false;
    });
    //信息框里的取消关注
    $('.info_tip_cancelFollow').live('click',function(){
        var that = this;
        var callBackType = $("#info_tip").attr('callBackType');
        alertLayer('您确定要取消关注吗？',function(){
            var url = $(that).attr('ajaxUrl');
            $.get(url,function(data){
                if(parseInt(data.error) == '0'){
                    $(that).html('加关注').removeClass('info_tip_cancelFollow').addClass('info_tip_addFollow').attr('ajaxUrl',url.replace('cancel','add'));
                    if(callBackType == 'myIndex'){//个人主页猜你认识

                    }
                    else if(callBackType == 'myInterest'){

                    }
                    else if(callBackType == 'myFollow'){//关注管理-我关注的人
                        var $obj = $('#my-follow-her-a');
                        var ajaxUrl = $('#my-follow-her-a').attr('ajaxUrl');
                        var currPage = $('#my-follow-page').attr('currPage');
                        currPage = currPage ? currPage : 1;
                        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
                        ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                    }
                    else if(callBackType == 'myFans'){//关注管理-关注我的人
                        var $obj = $('#her-follow-my-a');
                        var ajaxUrl = $('#her-follow-my-a').attr('ajaxUrl');
                        var currPage = $('#her-follow-page').attr('currPage');
                        currPage = currPage ? currPage : 1;
                        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
                        ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                    }
                    else if(callBackType == 'mySeach'){//关注管理-搜索结果
                        var $obj = $('#my-search-page');
                        var ajaxUrl = $('#my-search-page').attr('ajaxUrl');
                        var currPage = $('#my-search-page').attr('currPage');
                        currPage = currPage ? currPage : 1;
                        ajaxUrl = ajaxUrl.substring(0,ajaxUrl.length-1)+currPage;
                        ajaxSend($obj,'',ajaxUrl,'','','','',currPage);
                    }
                    else if(callBackType == 'myHome'){//个人主页
                        if(myHomeIsOwn && isFollowAndFans){
                            window.location.reload();
                        }
                    }
                    else if(callBackType == 'myHomeFollow'){//个人主页-我关注的人
                        if(myHomeIsOwn && isFollowAndFans){
                            window.location.reload();
                        }
                        else if(myHomeIsOwn && !isFollowAndFans){
                            //刷新我关注的人
                            if($('#my-interest-per').size()){
                                ajaxSend($('#my-interest-per'),function(data){
                                    $('#my-interest-num').html(data.total);
                                });
                            }
                        }
                    }
                }
                else{
                    alert(data.msgs);
                }
            },'json');
        });
        return false;
    });

    /*$('.dm_handle').each(function() {
     var target = "#" + $(this).attr('id') + "_menu";
     $(this).bind('click', function() {
     $(target).show();
     return false;
     });
     });*/

    $('.dm_handle').live('click',function(){
        var target = "#" + $(this).attr('id') + "_menu";
        //隐藏所有
        $('#topic_manage .mod_menu_item .drop_menu').hide();
        $(target).show();
        return false;
    });
    $("#topic_dig_menu").hover(function(){
        $(this).show();
    },function(){
        $(this).hide();
    });

    if($('#topic_manage').size()){
        $('body').click(function(e){
            var $parent = $(e.target).parents('.drop_menu').first();
            if(!$parent.size()) $('#topic_manage .mod_menu_item .drop_menu').hide();
        });
    }
    // lazyload
    $(".avatar, .attach").lazyload({
        placeholder : "http://static.doyouhike.net/images/leech.gif"
    });

    $("#btn_pos").toggle(
        function () {
            $("#topic_pos").show("slow");
        },
        function () {
            $("#topic_pos").hide("slow");
        }
    );

    // debug info box for admin
    $("#btn_debug").toggle(
        function () {
            $("#div_debug").show("slow",function(){
                window.scroll(0, 30000);
            });
        },
        function () {
            $("#div_debug").hide("slow");
        }
    );

    (new GoTop()).init({
        pageWidth       :980,
        nodeId          :'go-top',
        nodeWidth       :70,
        distanceToBottom    :155,
        hideRegionHeight    :130,
        text            :'回到顶部',
        isHidden        :true
    });
    (new GoTop(function(){
        window.location="/doc/contact.html";
        //showComment();
    })).init({
            pageWidth       :980,
            nodeId          :'feedback',
            nodeWidth       :70,
            distanceToBottom    :95,
            hideRegionHeight    :130,
            text            :'联系我们',
            isHidden        :false
        });

    $('#switch_version').click(function(){
        var version = $(this).attr('version');
        if(version=='new'){
            $.cookie("dyh_version", 'old', { expires : 15 , path: '/' });
        }else{
            $.removeCookie("dyh_version", { path: '/' });
        }
        window.location.reload();
    });
});

/*弹出意见反馈框*/
function showComment() {
    /*显示阴影*/
    var cheight = document.body.clientHeight||document.documentElement.clientHeight;
    if(document.getElementById('comment_shade')){
        document.getElementById('comment_shade').style.display = 'block';
        document.getElementById('comment_shade').style.height = cheight + 'px';
    }
    else{
        var shade = document.createElement('div');
        shade.className = 'shade';
        shade.id = "comment_shade";
        shade.style.height = cheight + 'px';
        document.body.appendChild(shade);
    }

    /*出现iframe*/
    var stop = document.documentElement.scrollTop || document.body.scrollTop;
    var innerHeight = window.innerHeight || document.documentElement.clientHeight;
    if(document.getElementById('comment_iframe')){
        document.getElementById('comment_iframe').style.display = 'block';
        document.getElementById('comment_iframe').style.top = (innerHeight/2+stop)+'px';
    }
    else {
        var iframe = document.createElement('iframe');
        iframe.id = 'comment_iframe';
        iframe.className = "comment_iframe";
        iframe.scrolling = 'no';
        iframe.frameBorder = '0';
        iframe.style.top = (innerHeight/2+stop)+'px';
        document.body.appendChild(iframe);
        iframe.src = '/feedback/feedback';//这句一定得写最后，不然ie6会是空白的
    }
}

/*左右或者上下切换*/
/*切换滑动类
 *参数说明,传入的参数可以是jquery对象、dom对象或者直接传入id
 *container 滑动容器
 *slidebox 滑动对象
 *preObj 上一个按钮
 *nextObj 下一个按钮
 *autoPlay 是否开启自动滚动
 *nextTime 滚动时间间隔
 */
var slide = function(container,slidebox,preObj,nextObj,len,direction,autoPlay,nextTime){
    //滑动容器
    this.container = this.getObj(container);
    //滑动对象
    this.slidebox = slidebox ? this.getObj(slidebox) : this.getObj(this.container.children());
    //上一个按钮
    this.preObj = this.getObj(preObj);
    //下一个按钮
    this.nextObj = this.getObj(nextObj);
    //滑动对象中包含元素个数（例如li的个数）
    this.num = null;
    //滑动指针
    this.needle = 0;
    //展示数量
    this.len = len || 3;
    //移动的方向（水平horizontal或垂直vertical）
    this.direction = direction || 'horizontal'
    //是否可以左移
    this.isLeft = false;
    //是否可以右移
    this.isRight = false;
    //移动步伐长度
    this.step = 0;
    //滚动时间间隔
    this.nextTime = nextTime || 3000;
    //是否开启自动滚动
    this.autoPlay = autoPlay || false;
    //把每次实例化的对象缓存起来
    if(!slide.childs) slide.childs=[];
    this.id=slide.childs.push(this)-1;
    this.timeout = '';
};
slide.prototype.getObj = function(value){
    //value为jquery对象
    if(value instanceof jQuery) return value;
    //value为dom对象
    else if(typeof(value) == 'Object') return $(value);
    //value为id
    else if(typeof(value) == 'String') return $('#'+value);
    //value为空
    else if(!value) return null;
};
slide.prototype.init = function(){
    this.num = this.slidebox.children().size();//初始化个数
    if(this.num <= this.len){
        this.preObj.removeClass('hby-pre-hover');
        this.nextObj.removeClass('hby-next-hover');
        this.isLeft = false;
        this.isRight = false;
    }
    else{
        this.step = this.getStep();//获取步伐长度
        //this.nextObj.addClass('hby-next-hover');
        this.isLeft = false;
        this.isRight = true;
    }
    var that = this;
    /*左移*/
    this.preObj.click(function(event){
        that.next();
        return false;//阻止冒泡和默认事件发生
    }).hover(function(){
            $(this).addClass('hby-pre-hover');
            if(this.autoPlay) clearTimeout(that.timeout);
        },function(){
            $(this).removeClass('hby-pre-hover');
            if(this.autoPlay) that.timeout = setTimeout("slide.childs["+ that.id +"].next()",that.nextTime);
        });
    /*右移*/
    this.nextObj.click(function(event){
        that.pre();
        return false;//阻止冒泡和默认事件发生
        //event.preventDefault();//仅阻止默认事件发生
        //event.stopPrapagation();//仅阻止冒泡事件发生
    }).hover(function(){
            $(this).addClass('hby-next-hover');
            if(this.autoPlay) clearTimeout(that.timeout);
        },function(){
            $(this).removeClass('hby-next-hover');
            if(this.autoPlay) that.timeout = setTimeout("slide.childs["+ that.id +"].next()",that.nextTime);
        });
    /*自动*/
    if(this.autoPlay){
        this.timeout = setTimeout("slide.childs["+ this.id +"].next()",this.nextTime);
        //鼠标移上去停止自动
        this.container.hover(function(){
            clearTimeout(that.timeout);
        },function(){
            that.timeout = setTimeout("slide.childs["+ that.id +"].next()",that.nextTime);
        });
    }
};
slide.prototype.changeStatus = function(){
    if(this.needle == 0 || this.num <= this.len){
        //this.preObj.removeClass('hby-pre-hover');
        this.isLeft = false;
    }
    else{
        //this.preObj.addClass('hby-pre-hover');
        this.isLeft = true;
    }
    if(this.needle+this.len >= this.num || this.num <= this.len){
        //this.nextObj.removeClass('hby-next-hover');
        this.isRight = false;
    }
    else{
        //this.nextObj.addClass('hby-next-hover');
        this.isRight = true;
    }
};
slide.prototype.getStep = function(){
    if(this.direction=='horizontal'){
        var $childFirst = this.slidebox.children().eq(0);
        var paddingLeft = parseInt($childFirst.css('paddingLeft'));
        var paddingRight = parseInt($childFirst.css('paddingRight'));
        var marginLeft = parseInt($childFirst.css('marginLeft'));
        var marginRight = parseInt($childFirst.css('marginRight'));
        var sterWidth = $childFirst.width();
        return paddingLeft + paddingRight + marginLeft + marginRight + sterWidth;
    }
    else{
        var $childFirst = this.slidebox.children().eq(0);
        var paddingTop = parseInt($childFirst.css('paddingTop'));
        var paddingBottom = parseInt($childFirst.css('paddingTop'));
        var marginTop = parseInt($childFirst.css('marginTop'));
        var marginBottom = parseInt($childFirst.css('marginBottom'));
        var sterHeight = $childFirst.height();
        return paddingTop + paddingBottom + marginTop + marginBottom + sterHeight;
    }
};
slide.prototype.pre = function(){
    if(!this.isLeft){//到达最左边转到最后一个
        this.needle = this.num-this.len;
        if(this.direction=='horizontal'){
            this.slidebox.animate({
                marginLeft : -(this.step*(this.num-this.len))
            },'fast');
        }
        else{
            this.slidebox.animate({
                marginTop : -(this.step*(this.num-this.len))
            },'fast');
        }

        //return;
    }
    else{
        this.needle --;
        if(this.direction=='horizontal'){
            this.slidebox.animate({
                marginLeft : '+='+this.step
            },'fast');
        }
        else{
            this.slidebox.animate({
                marginTop : '+='+this.step
            },'fast');
        }

    }
    this.changeStatus();
};
slide.prototype.next =function(){
    if(!this.isRight){//到达最右边转到第一个
        this.needle = 0;
        if(this.direction=='horizontal'){
            this.slidebox.animate({
                marginLeft : 0
            },'fast');
        }
        else{
            this.slidebox.animate({
                marginTop : 0
            },'fast');
        }
        //return;
    }
    else{
        this.needle ++;
        if(this.direction=='horizontal'){
            this.slidebox.animate({
                marginLeft : '-='+this.step
            },'fast');
        }
        else{
            this.slidebox.animate({
                marginTop : '-='+this.step
            },'fast');
        }
    }
    this.changeStatus();
    if(this.autoPlay){
        clearTimeout(this.timeout);
        this.timeout = setTimeout("slide.childs["+ this.id +"].next()",this.nextTime);
    }
};

//实例化例子
/*
 var $slideBox = $("#indexFriends");//容器（必须参数）
 var $slideObj = $slideBox.children();//滑动对象（必须参数）
 var $pre = $slideBox.siblings('.left');//左按钮（必须参数）
 var $next = $slideBox.siblings('.right');//右按钮（必须参数）
 var len = 2;//显示的数量
 var direction = 'horizontal';//水平horizontal或垂直方向vertical,默认是水平
 var autoPlay = true;//是否自动滑动、默认是false（可选参数）
 var nextTime = 3000;//自动滑动的时间间隔、默认是3000（可选参数）
 var newSlide = new slide($slideBox,$slideObj,$pre,$next,len,direction,autoPlay,nextTime);
 newSlide.init();
 */

/**
 *自定义错误信息列表项
 *2012-11-12
 **/

//定义全局错误变量error
error = {};
error.required = '必填！';
error.remote = '请修正该字段！';
error.email = '请输入正确格式的电子邮件！';
error.url = '请输入合法的网址！';
error.date = '请输入合法的日期！';
error.dateMinNow = '输入的日期不能小于当天！';
error.number = '请输入合法的数字！';
error.digits = '只能输入整数！';
error.creditcard = '请输入合法的信用卡号！';
error.equalTo = '请再次输入相同的值！';
error.accept = '请输入拥有合法后缀名的字符串！';
error.telphone = '请输入正确的电话号码！';
error.mobile = '请输入正确的手机号码！';
error.maxlength = function(max){ max = max?max:1; return '请输入一个 长度最多是 ' + min + ' 的字符串！' };
error.minlength = function(min){ min = min?min:1; return '请输入一个 长度最少是 ' + min + ' 的字符串！' };
error.rangelength = function(min,max){ min = min?min:1; max = max?max:10; return '请输入 一个长度介于 ' + min + ' 和 ' + max + ' 之间的字符串！' };
error.range = function(min,max){ min = min?min:1; max = max?max:10; return '请输入一个介于 ' + min + ' 和 ' + max + ' 之间的值！' };
error.max = function(max){ max = max?max:10; return '请输入一个最大为 ' + max + ' 的值！' };
error.min = function(min){ min = min?min:1; return '请输入一个最小为 ' + min + ' 的值！' };

//================
//活动频道
//================
error.event = {};

//创建、编辑活动
error.event.add = {};
error.event.add.activity_null = '您必须先选择一个活动！';
error.event.add.title_null = '活动标题不能为空！';
error.event.add.activityType_null = '请选择至少一个活动类型！';
error.event.add.title_maxlength = '活动标题长度请控制在50个字符内！';
error.event.add.activityStartTime_null = '出发时间不能为空！';
error.event.add.activityStartHour_range = '小时数应介于 0 和 23 之间！';
error.event.add.activityStartMinute_range = '分钟数应介于 0 和 59 之间！';
error.event.add.time_null = '活动时间不能为空！';
error.event.add.time_num = '活动时间必须为数字！';
error.event.add.time_min = '活动时间必须为大于0的数字！';
error.event.add.time_max = '活动时间必须为小于3600的数字！';
error.event.add.startAddress_null = '出发城市不能为空！';
error.event.add.endAddress_null = '目的地不能为空！';
error.event.add.maxNumber_null = '参加人数不能为空！';
error.event.add.maxNumber_min = '参加人数上限必须大于2！';
error.event.add.maxNumber_max = '参加人数上限必须小于1000000！';
error.event.add.activityInfo_null = '内容不能为空！';
error.event.add.activityInfo_minlength = '请填写一定长度的，有意义的内容！';
error.event.add.activity_is = '您至少要在发布范围和发布圈子中选择一个';
error.event.add.activityArea_is = '您还没选择要发布到地区中的那个城市';

//活动回复评价
error.event.reply = {};
error.event.reply.title_null = '留言标题不能为空！';
error.event.reply.content_null = '留言内容不能为空！';

//我的求捡
error.event.wish = {};
error.event.wish.dests_null = '目的地不能为空！';
error.event.wish.days_null = '天数不能为空！';
error.event.wish.time_start_null = '空闲时间不能为空！';
error.event.wish.days_min = '天数最小值是1！';

//修改活动路线
error.event.manage = {};
error.event.manage.res_files_null = '上传文件不能为空！';
error.event.manage.res_files_format = '上传文件的格式必须为kml！';
error.event.manage.line_name_null = '路线名称不能为空！';
error.event.manage.line_max = '只能选择2条上传路线！';
error.event.manage.line_min = '您必须选择1条上传路线！';

//完善保险信息
error.event.baoxian = {};
error.event.baoxian.usename_null = '姓名不能为空！';
error.event.baoxian.insuname_null = '险种不能为空！';
error.event.baoxian.insunum_null = '保险单不能为空！';

//添加紧急联系人
error.event.contacter = {};
error.event.contacter.conname1_null = '联系人姓名1不能为空！';
error.event.contacter.contel1_null = '电话1不能为空！';
error.event.contacter.conname2_null = '联系人姓名2不能为空！';
error.event.contacter.contel2_null = '电话2不能为空！';


//搜索框自动完成功能
$(function(){

    /**目的地首页 搜索 scene_search**/
    var sceneIndex_search = $('.scene_index .scene_search');
    var scene_search_input = $('.search_input');
    var scene_search_pop = $('.search_popupmenu');
    var scene_search_popUl = $('.search_popupmenu ul');

    var isIndexPage = false;//判断当前页面是否为首页
    var isOnly = false; //判断后台返回only是否为真

    if(scene_search_input.attr("isIndex") == '1'){
        isIndexPage = true;
    }

    /**搜索下拉选择 search_popUl**/
    var search_popupMenu_Li = $('.search_popupmenu li');
    search_popupMenu_Li.live('mouseenter',function(){
        search_popupMenu_Li.removeClass('current');
        $(this).addClass('current');
    }).live('mouseleave',function(){
        $(this).removeClass('current');
    });

    search_popupMenu_Li.live('click',function(){
        var key = $(this).attr('area');
        var from=$(this).parent().parent().prev().find("input[name=from]").val();
        $.get('/s/search_analytics?keyword='+key+'&from='+from,function(data){});
        if(scene_search_input.hasClass('quguo_place_input')){
            var id = $(this).attr('nodeid');
            var val = $(this).find('a').text();
            $('.node_id_hidden').val(id);
            $('.quguo_place_input').val(val);
        }
    });

    //搜索自动填充功能
    var last;
    var $currUrl;
    var selected;
    function searchParent(event,obj){
        var keyword = $.trim(obj.val());
        var scene_search_pop = obj.parents('.dest_search_wrap').find('.search_popupmenu');
        var _that = obj;
        isOnly = false;
        //利用event的timeStamp来标记时间，这样每次的keyup事件都会修改last的值，注意last必需为全局变量
        last = event.timeStamp ? event.timeStamp : timestamp();
        setTimeout(function(){
            //如果时间差为0（也就是你停止输入0.5s之内都没有其它的keyup事件发生）则做你想要做的事
            var cur_evt_time;
            cur_evt_time = event.timeStamp ? event.timeStamp : timestamp();
            if(last - cur_evt_time == 0){
                $.post('/api/place/auto_output_nodes',{node_name:keyword},function(data){
                    if(data.only == true){
                        isOnly = true;
                    }
                    if(data.node.length>0){
                        scene_search_popUl.html('');
                        var $li = '';
                        $.each(data.node,function(i,n){
                            if(obj.hasClass('quguo_place_input')){
                                $li += '<li area="'+data.node[i].NodeName+'" nodeid="'+data.node[i].NodeID+'"><a href="javascript:void(0);">'+data.node[i].NodeName+'</a></li>';
                            }else{//高亮
                                var str = data.node[i].tree.split('>>');
                                var len = str.length - 2;
                                var father = str[len];
                                var new_name_str = '<em>'+keyword+'</em>';
                                var new_slug_str = '<em>'+keyword+'</em>';
                                var rs_name_str = data.node[i].NodeName.replace(keyword,new_name_str);
                                var rs_slug_str = data.node[i].NodeSlug.replace(keyword,new_slug_str);

                                $li += '<li area="'+data.node[i].NodeName+'" url="/dest/'+data.node[i].NodeSlug+'" ><a href="/dest/'+data.node[i].NodeSlug+'" >'+rs_name_str;
                                if(father !== undefined){
                                    $li += '&nbsp;&nbsp;-&nbsp;&nbsp;<span>'+father+'</span>';
                                }
                                $li += '<p class="search_rs_py_txt">'+rs_slug_str+'</p></a></li>';
                            }

                        });
                        if(_that.hasClass('master_search')){$li += '<li><p class="search_drop_more"><a onclick="search_form.submit();" href="javascript:void(0);">查看更多搜索结果:<em>'+_that.val()+'</em></a></p></li>';}
                        scene_search_popUl.append($li);
                        //$currUrl = "/dest/"+data.node[0].NodeSlug;

                        if(_that.hasClass('quguo_place_input')){
                            var node_id = $('.node_id_hidden').val();
                            if(node_id == ''){
                                $('.node_id_hidden').val(data.node[0].NodeID);
                                $('.quguo_place_input').val(data.node[0].NodeName);
                            }
                        }
                        scene_search_pop.show();
                    }else{
                        scene_search_popUl.html('');
                        scene_search_pop.hide();
                        $currIdx =  false;
                    }
                },'json');

            }
        },300);
    }

    var $spi= $(".search_popupmenu ul li").size();
    var $currIdx;var $currVal;
    $('.search_input').keyup(function(event){

        var _that = $(this);
        if(event.keyCode != 13){
            selected = false;
            var $popLiSize = _that.parents('.dest_search_wrap').find(".search_popupmenu ul li").size();
            if(_that.hasClass('quguo_place_input')){
                $('.node_id_hidden').val('');
            }
            if(event.keyCode == 40 || event.keyCode == 38){
                selected = true;
                if($(".search_popupmenu ul li:visible").size()){
                    if($(".search_popupmenu ul li.current").size()){
                        if(event.keyCode == 40){
                            $spi = _that.parents('.dest_search_wrap').find(".search_popupmenu ul li.current").index() + 1;
                        }else if(event.keyCode == 38){
                            $spi = _that.parents('.dest_search_wrap').find(".search_popupmenu ul li.current").index() - 1;
                        }
                        $currIdx = $spi % $popLiSize;

                    }else{
                        if(event.keyCode == 40){
                            $currIdx =  0;
                        }else if(event.keyCode == 38){
                            $currIdx = $popLiSize - 1;
                        }
                    }
                    _that.parents('.dest_search_wrap').find(".search_popupmenu ul li").eq($currIdx).addClass("current").siblings("li").removeClass("current");
                }
                $currVal = $(".search_popupmenu ul li.current").attr("area");
                $currUrl = $(".search_popupmenu ul li.current").attr("url");
                if($currVal !== undefined){_that.val($currVal);}
                if(_that.hasClass('quguo_place_input')){
                    var node_id = $(".search_popupmenu ul li.current").attr('nodeid');
                    $('.node_id_hidden').val(node_id);
                }

            }else{
                searchParent(event,_that);
            }
        }else{//keyup时，如果为回车
            if(selected){
                var father_node = $(".search_popupmenu ul li.current");
                var son_node = father_node.find('.search_drop_more');
                if(son_node.length == 1){//如果enter查看更多搜索结果，则url跳转
                    $currUrl = '/s/?keyword='+_that.parent().parent().find('.search_drop_more a em').text();
                }

            }else{
                if(_that.parent().hasClass('mdd_search_form')){
                    $currUrl = '/s/dest/?more_btn=1&keyword='+_that.val();

                }else{
                    $currUrl = '/s/?keyword='+_that.val();
                }
            }
            if(!_that.hasClass('quguo_place_input'))window.location.href = $currUrl;
            if($(".search_popupmenu:visible").size()){
                scene_search_pop.hide();
                return false;
            }

        }
    });

    sceneIndex_search.click(function(e){
        e.stopPropagation();
    });

    $(document).click(function() {
        scene_search_pop.hide();
    });

});

//加入小组
$(function(){

    $('.join').bind('click',function(){
        var _that = $(this),group_id = $(this).attr('group_id'),count;
        $.get('/api/group/joinGroup',{group_id:group_id},function(data){
            if(data.error == 0){
                if(typeof(_that.attr('backurl')) == "undefined"){
                    _that.unbind();
                    _that.parent().addClass('add');
                    //_that.removeClass().addClass('joined').html('&#10004已加入');
                    var type;
                   if(data.type == '1'){
                       type = '&#10004已加入';
                       _that.parent().append('<span class="added" style="line-height:40px;padding-left:4px;color:green;font-weight:bold;">'+type+'</span>');
                   }
                   if(data.type == '0'){
                       type = '审核中';
                       _that.parent().append('<span style="line-height:40px;padding-left:4px;color:red;font-weight:bold;">'+type+'</span>');
                   }
                    _that.remove();
                    count = $('.added','.gp_list').size();
                    $('.joined_num').text(count);
                    if(count != 0){
                        $('.enjoy_group_link').text('进入浏览');
                    }

                }else{
                    msgTip(data.msgs,function(){
                        window.location.href = _that.attr('backurl');
                    });
                }
            }else{
                if(data.msgs == '请登录'){
                    alertLayer(data.msgs,function(){
                        window.location.href = '/user/login/';
                    });
                }else{
                    if(data.msgs=="is_member")
                        window.location.href = '/group/'+group_id+"/1/";
                    else 
                        alertConfirm(data.msgs);
                }
            }
        },'json');

        return false;
    });
});

//取得当前的时间戳
function timestamp() {
    var timestamp = Date.parse(new Date());
    return timestamp;
}
$(function(){//booking 酒店搜索统计
    $("#HotelForm").submit(function(){
        $.get('/s/search_analytics?keyword='+$("#js_form_poi").val()+"&from="+$("#js_search_button").attr("data"),function(data){});
    });
	$(".weixin a").hover( function(){ 
		$(".weixinqr").fadeIn(400);
		},
		function(){
			$(".weixinqr").fadeOut(400);
		}
	);
});

/*生成分页html
  currIndex：当前页码  
  total：总页数
  $holder： html存放$对象
*/
function xlznNav(currIndex, total, $holder){
    var visibleNum = 10,
        markIndex = currIndex,
        prevArr = [],
        nextArr = [],
        prevnum = 0,
        nextnum = 0,
        moveNextnum = 0,
        movePrevnum = 0;

    for(prevnum; prevnum < 4; prevnum++){
        var markIndex = currIndex - prevnum - 1;
        if(markIndex > 0){
            prevArr.unshift(markIndex);
        }else{
            break;
        }
    }
    for(nextnum; nextnum < 4; nextnum++){
        var markIndex = currIndex + nextnum + 1;
        if(markIndex < total){
            nextArr.push(markIndex);
        }else{
            break;
        }
    }
    if(prevnum < 4){
        moveNextnum = 4 - prevnum;
        for(moveNextnum; moveNextnum > 0; moveNextnum--){
            
            var markIndex = currIndex + nextnum + 1;
            if(markIndex < total){
                nextArr.push(markIndex);
            }else{
                break;
            }
            nextnum++
        }
    }
    if(nextnum < 4){
        movePrevnum = 4 - nextnum;
        for(movePrevnum; movePrevnum > 0; movePrevnum--){
            
            var markIndex = currIndex - prevnum - 1;
            if(markIndex > 0){
                prevArr.unshift(markIndex);
            }else{
                break;
            }
            prevnum++
        }
    }
    $holder.html('');
    $(prevArr).each(function(i, o){
        $('<a>'+ o +'</a>').attr('data-href', o).appendTo($holder);
    });
    $('<a class="active">'+ currIndex +'</a>').attr('data-href', currIndex).appendTo($holder);
    $(nextArr).each(function(i, o){
        $('<a>'+ o +'</a>').attr('data-href', o).appendTo($holder);
    });
    var firstnum = parseInt($holder.children().eq(0).attr('data-href')),
        lastnum = parseInt($holder.children().last().attr('data-href'));
    if(firstnum > 1){
        if(firstnum != 2) $('<span>...</span>').prependTo($holder);
        $('<a>'+ 1 +'</a>').attr('data-href', 1).prependTo($holder);
    }
    if(lastnum < total){
        if(lastnum != total-1) $('<span>...</span>').appendTo($holder);
        $('<a>'+ total +'</a>').attr('data-href', total).appendTo($holder);
    }

    var $prev = $('<a href="" class="prev">« Prev</a>'),
        $next = $('<a href="" class="next">Next »</a>');

    if(currIndex == 1) $prev.addClass('disabled');
    if(currIndex == total) $next.addClass('disabled');
    $prev.prependTo($holder);
    $next.appendTo($holder);
}
$(function(){
    //线路创建页面返回cookie
    if($('.xlzn_create_btn[data-cookieurl]').size()>0){
        $.cookie('addroute_return_url', window.location.href,{path:'/'});
    }
});
jQuery.fn.placeholder = function() {
    var i = document.createElement('input'),
        placeholdersupport = 'placeholder' in i;
    if (!placeholdersupport) {
        var inputs = jQuery(this);
        inputs.each(function() {
            var input = jQuery(this),
                text = input.attr('placeholder'),
                pdl = 0,
                height = input.outerHeight(),
                width = input.outerWidth(),
                placeholder = jQuery('<span class="phTips">' + text + '</span>');
            try {
                pdl = input.css('padding-left').match(/\d*/i)[0] * 1;
            } catch (e) {
                pdl = 5;
            }
            pdl = 12;
            placeholder.css({
                'margin-left': -(width - pdl),
                'height': height,
                'line-height': height + "px",
                'position': 'absolute',
                'color': "#c3c3c3",
                'font-size': "14px"
            });
            placeholder.click(function() {
                input.focus();
            });
            if (input.val() != "") {
                placeholder.css({
                    display: 'none'
                });
            } else {
                placeholder.css({
                    display: 'inline'
                });
            }
            placeholder.insertAfter(input);
            input.keyup(function(e) {
                if (jQuery(this).val() != "") {
                    placeholder.css({
                        display: 'none'
                    });
                } else {
                    placeholder.css({
                        display: 'inline'
                    });
                }
            });
        });
    }
    return this;
};
//页面底部APP下载提示
$(function() {
    if (!$.cookie('app_bottom') && document.location.href.indexOf('/user/login?') < 0 && document.location.href.indexOf('/user/register') < 0 && document.location.href.indexOf('/user/account/lost_password') < 0) {
        var _first_url = $.cookie('app_first_url');
        
        if(!_first_url || (_first_url == location.href && $.cookie('app_prev_url')==_first_url)){
            $.cookie('app_first_url', location.href, { path: "/" });
            $('#appBottomIn').show();
            
            $('#appBottomIn .app_close').click(function() {
                $('#appBottomIn').hide();
                var date = new Date();
                date.setTime(date.getTime() + (24*60*60 * 1000 * 7));
                $.cookie('app_bottom', true, {
                    expires: date
                }); // expires after 7 day
            });
        }

    }
    $.cookie('app_prev_url', location.href, { path: "/" });
});