var xlznMap;
! function() {
    $(function() {
        xlznMap = function(ifRemoveControl, ifDisableEdit) {
            var self = this;

            self.markerArr = [];
            self.markerType = {
                begin: 1,
                point: 2,
                camping: 3,
                end: 4,
                iconType: 5
            }
            self.markerZindex = 100;
            self._startAddPoint = false;//是否开始右键菜单栏添加路点营地
            self._unpostMarkerArr = [];//新增路点营地未提交数据
            self.init = function(eleId, centerObj, ifStyle, title) {
                if (centerObj) {
                    self.mapObj = new AMap.Map(eleId, {
                        //二维地图显示视口
                        view: new AMap.View2D({
                            center: new AMap.LngLat(centerObj.lng, centerObj.lat), //地图中心点
                            zoom: 12 //地图显示的缩放级别
                        })
                    });
                    if (ifStyle) {
                        if(ifStyle === true){
                            self.addMarker(centerObj, self.markerType.begin, title);
                        }else{
                            self.addMarker(centerObj, self.markerType.iconType, title, ifStyle);
                        }
                        
                    } else {
                        self.addMarker(centerObj);
                    }

                } else {
                    self.mapObj = new AMap.Map(eleId, {
                        //二维地图显示视口
                        view: new AMap.View2D({
                            zoom: 12 //地图显示的缩放级别
                        })
                    });

                }

                if(!ifRemoveControl){
                    //地图中添加地图操作ToolBar插件
                    self.mapObj.plugin(["AMap.ToolBar"], function() {
                        toolBar = new AMap.ToolBar(); //设置地位标记为自定义标记
                        self.mapObj.addControl(toolBar);
                    });

                    //地图类型切换
                    self.mapObj.plugin(["AMap.MapType"], function() {
                        var type = new AMap.MapType({defaultType:0});//初始状态使用2D地图
                        self.mapObj.addControl(type);
                    });
                }
            }
            self.addMarker = function(location, type, tip, style,pointid) {
                var _returnMarkerObj = {};
                if (type) {
                    var markerClass,
                        draggable = true,
                        position;
                    switch (type) {
                        case self.markerType.begin:
                            markerClass = 'xlzn_marker_begin';
                            draggable = false;
                            position = new AMap.LngLat(location.lng, location.lat);
                            break;
                        case self.markerType.point:
                            markerClass = 'xlzn_marker_point';
                            position = location;
                            break;
                        case self.markerType.camping:
                            markerClass = 'xlzn_marker_camping';
                            position = location;
                            break;
                        case self.markerType.end:
                            markerClass = 'xlzn_marker_end';
                            draggable = false;
                            position = new AMap.LngLat(location.lng, location.lat);
                            break;
                        case self.markerType.iconType:
                            markerClass = 'xlzn_marker_style' + style;
                            draggable = false;
                            position = new AMap.LngLat(location.lng, location.lat);
                            break;
                    }
                    var $markerContent = $('<div class="xlzn_marker_wrap"><a class="xlzn_marker ' + markerClass + '"></a><span class="xlzn_mk_tip">' + tip + '</span></div>');
                    if(pointid)$markerContent.attr('data-id',pointid);
                    //$('.xlzn_marker .xlzn_mk_tip').removeClass('hide');
                    if(!!self.ifAddnew && !pointid){
                        $markerContent.addClass('xlzn_marker_wrapnew');  
                    }                
                    $('.xlzn_mk_dialog').hide();
                    if(type==self.markerType.point || type==self.markerType.camping){
                        //$('<div class="xlzn_mk_dialog"><span class="xlzn_mk_dialog_close">×</span><p>名称:<input type="text" value="'+ tip +'"></p><a class="xlzn_mk_delete">删除</a><a class="xlzn_mk_sure">确定</a></div>').appendTo($markerContent);
                       
                        $markerContent.attr('data-lng', position.getLng());
                        $markerContent.attr('data-lat', position.getLat());
                        if(type==self.markerType.point){
                            $markerContent.attr('data-type', '路点');

                        }
                        if(type==self.markerType.camping){
                            $markerContent.attr('data-type', '营地');
                        }
                        $markerContent.attr('data-typeid', type);
                    }else if(type==self.markerType.begin || type==self.markerType.end){
                        //$('<div class="xlzn_mk_dialog"><span class="xlzn_mk_dialog_close">×</span><p>名称:<input type="text" value="'+ tip +'"></p><a class="xlzn_mk_sure">确定</a></div>').appendTo($markerContent);
                        $markerContent.attr('data-lng', position.getLng());
                        $markerContent.attr('data-lat', position.getLat());
                        if(type==self.markerType.begin){
                            $markerContent.attr('data-type', '起点');
                        }
                        if(type==self.markerType.end){
                            $markerContent.attr('data-type', '终点');
                        }
                        $markerContent.find('.xlzn_mk_dialog').hide();
                        $markerContent.attr('data-typeid', type);
                    }
                    if(ifDisableEdit || !self.ifAddnew) draggable = false;
                    var marker = new AMap.Marker({
                        map: self.mapObj,
                        position: position, //基点位置
                        offset: new AMap.Pixel(0, -34), //相对于基点的偏移位置
                        draggable: draggable, //是否可拖动
                        content: $markerContent.get(0) //自定义点标记覆盖物内容
                    });
                    if(!ifDisableEdit && self.ifAddnew){
                        if(type != self.markerType.iconType){
                            _returnMarkerObj._event = setInfoWindow(marker, tip, type,pointid);
                        }
                    
                        marker.setShape(new AMap.MarkerShape({
                            type: 'rect',
                            coords: [0,0,24,34]
                        }));
                        marker.setMap(self.mapObj); //在地图上添加点

                        self.currMarker = marker;
                        self.markerZindex++;
                        self.currMarker.setzIndex(self.markerZindex);
                        _returnMarkerObj.marker = marker; 
                        AMap.event.addListener(marker, 'dragend', function(e){
                            var $target = $(e.target.getContent()),
                                lng = e.lnglat.lng,
                                lat = e.lnglat.lat;

                            if($target.attr('data-lng') == lng || $target.attr('data-lat') == lat){
                                return;
                            }else{
                                $target.attr('data-lng', lng).attr('data-lat', lat);
                            }
                            self.dragging = true;
                            if(self.ifPostData){//已审核通过路点营地是否编辑后数据提交
                                var _id = $target.attr('data-id'),
                                    _postData = {
                                        road_point_id: _id,
                                        offset_lngi: lng,
                                        offset_lati: lat
                                    }
                                if(_id){
                                    postMarkerData('update', _postData);
                                }
                            }
                        });
                        AMap.event.addListener(marker, 'dragging', function(e){
                            if(window.currInfoWindow)currInfoWindow.close();
                        });
                        //打开标记编辑框
                        AMap.event.addListener(marker, 'click', function(e){
                            $('.xlzn_mk_dialog').hide();
                            $(e.target.getContent()).find('.xlzn_mk_dialog').show();
                            self.currMarker = e.target;
                            self.markerZindex++;
                            self.currMarker.setzIndex(self.markerZindex);
                        });
                    }
                    
                    //标题hover效果
                    AMap.event.addListener(marker, 'mouseover', function(e){
                        if(e.target != self.openMarker)
                        $(e.target.getContent()).find('.xlzn_mk_tip').show();
                       /* self.currMarker = e.target;*/
                        self.markerZindex++;
                        e.target.setzIndex(self.markerZindex);
                    });
                    AMap.event.addListener(marker, 'mouseout', function(e){
                        if(e.target != self.openMarker)
                        $(e.target.getContent()).find('.xlzn_mk_tip').hide();
                    });
                   return _returnMarkerObj;
                } else {
                    var marker = new AMap.Marker({
                        map: self.mapObj,
                        position: new AMap.LngLat(location.lng, location.lat), //基点位置
                        icon: "http://webapi.amap.com/images/marker_sprite.png", //marker图标，直接传递地址url
                        offset: {
                            x: -8,
                            y: -34
                        } //相对于基点的位置
                    });
                }
            }
            function setInfoWindow(mar, tip, type,pointid){
                
                var ct = createContent(tip, type,pointid);
                var infoWindow = new AMap.InfoWindow({
                    content: ct,
                    size: new AMap.Size(220, 0),
                    autoMove: true,
                    offset: new AMap.Pixel(24, -20)
                });
                
                var aa = function(e) {
                    infoWindow.open(self.mapObj, mar.getPosition());
                };
                var _markerEvent = {};
                _markerEvent.infoWindowClick = AMap.event.addListener(mar, "click", aa);
                AMap.event.addListener(infoWindow, "open", function(e){
                    currInfoWindow = infoWindow;
                    self.openMarker = mar;
                    $(mar.getContent()).find('.xlzn_mk_tip').hide();
                });
                AMap.event.addListener(infoWindow, "close", function(e){
                    var tip = $(self.currMarker.getContent()).find('.xlzn_mk_tip').text(),
                        type = $(self.currMarker.getContent()).attr('data-typeid'),
                        pointid = $(self.currMarker.getContent()).attr('data-id');
                    currInfoWindow.setContent(createContent(tip, type,pointid));
                    self.openMarker = null;
                });
                if(self._startAddPoint && (type == self.markerType.point || type == self.markerType.camping)){//只有右键菜单栏添加才会自动打开编辑窗口
                    if(self._timeoutID){
                        clearTimeout(self._timeoutID);
                    }
                    self._timeoutID = setTimeout(function(){
                        infoWindow.open(self.mapObj, mar.getPosition());
                    },300);
                }
                function createContent(tip, type,pointid){
                    if(!pointid)pointid='';
                    var content = '';
                    if(type == self.markerType.begin || type==self.markerType.end){
                        content = '<div class="xlzn_mk_edit"><p>名称: <input type="text" data-id="'+pointid+'" value="'+ tip +'"></p><a class="xlzn_mk_sure">确定</a></div>'
                    }else{
                        content = '<div class="xlzn_mk_edit"><p>名称: <input type="text" data-id="'+pointid+'" value="'+ tip +'"></p><a class="xlzn_mk_delete">删除</a><a class="xlzn_mk_sure">确定</a></div>';
                    }
                    return content;
                }
                return _markerEvent;
            }
            self.bindKeydown = function(id) {
                self.keyword = document.getElementById(id);
                if(self.keyword){
                    self.keyword.onkeyup = keydown;
                    $('#mapKeySearch').click(function(e) {
                        e.preventDefault();
                        keydown();
                    });
                }
            }

            function keydown(event) {
                var key = (event || window.event).keyCode;
                var result = document.getElementById("result1")
                var cur = result.curSelect;
                if (key === 40) { //down
                    if (cur + 1 < result.childNodes.length) {
                        if (result.childNodes[cur]) {
                            result.childNodes[cur].style.background = '';
                        }
                        result.curSelect = cur + 1;
                        result.childNodes[cur + 1].style.background = '#CAE1FF';
                        document.getElementById("keyword").value = result.tipArr[cur + 1].name;
                    }
                } else if (key === 38) { //up
                    if (cur - 1 >= 0) {
                        if (result.childNodes[cur]) {
                            result.childNodes[cur].style.background = '';
                        }
                        result.curSelect = cur - 1;
                        result.childNodes[cur - 1].style.background = '#CAE1FF';
                        document.getElementById("keyword").value = result.tipArr[cur - 1].name;
                    }
                } else if (key === 13) {
                    var res = document.getElementById("result1");
                    if (res && res['curSelect'] !== -1) {
                        self.selectResult(document.getElementById("result1").curSelect);
                    }
                } else {
                    autoSearch();
                }
            }

            //输入提示
            function autoSearch() {
                var keywords = self.keyword.value;
                var auto;
                //加载输入提示插件
                self.mapObj.plugin(["AMap.Autocomplete"], function() {
                    var autoOptions = {
                        city: "" //城市，默认全国
                    };
                    auto = new AMap.Autocomplete(autoOptions);
                    //查询成功时返回查询结果
                    if (keywords.length > 0) {
                        AMap.event.addListener(auto, "complete", autocomplete_CallBack);
                        auto.search(keywords);
                    } else {
                        document.getElementById("result1").style.display = "none";
                    }
                });
            }

            function autocomplete_CallBack(data) {
                var resultStr = "";
                var tipArr = data.tips;
                //var len=tipArr.length;
                if (tipArr && tipArr.length > 0) {
                    for (var i = 0; i < tipArr.length; i++) {
                        resultStr += "<div id='divid" + (i + 1) + "' data='" + tipArr[i].adcode+ "' style=\"font-size: 13px;cursor:pointer;padding:5px 5px 5px 5px;\">" + tipArr[i].name + "<span style='color:#C1C1C1;'>" + tipArr[i].district + "</span></div>";
                    }
                    resultStr += "<div class='xlzn_close_mapresult'><a id='closeMapResult'>关闭</a></div>"
                } else {
                    resultStr = " π__π 亲,人家找不到结果!<br />要不试试：<br />1.请确保所有字词拼写正确<br />2.尝试不同的关键字<br />3.尝试更宽泛的关键字";
                }

                document.getElementById("result1").curSelect = -1;
                document.getElementById("result1").tipArr = tipArr;
                document.getElementById("result1").innerHTML = resultStr;
                document.getElementById("result1").style.display = "block";

                $('#result1').children().click(function() {
                    if (this.id.indexOf('divid') > -1) {
                        var index = this.id.split('divid')[1];
                        self.selectResult(index - 1);
                    }
                });
                $('#result1').children().mouseover(function() {
                    if (this.id.indexOf('divid') > -1) {
                        var index = this.id.split('divid')[1];
                        openMarkerTipById(index, this);
                    }
                });
                $('#result1').children().mouseout(function() {
                    if (this.id.indexOf('divid') > -1) {
                        var index = this.id.split('divid')[1];
                        onmouseout_MarkerStyle(index, this);
                    }
                });
                $('#closeMapResult').click(function(e) {
                    e.preventDefault();
                    document.getElementById("result1").style.display = "";
                    document.getElementById("result").style.display = "";
                });
            }

            //从输入提示框中选择关键字并查询
            self.selectResult = function(index) {
                if (index < 0) {
                    return;
                }
                if (navigator.userAgent.indexOf("MSIE") > 0) {
                    self.keyword.onpropertychange = null;
                    self.keyword.onfocus = focus_callback;
                }
                //截取输入提示的关键字部分
                var text = document.getElementById("divid" + (index + 1)).innerHTML.replace(/<[^>].*?>.*<\/[^>].*?>/g, "");
                var cityCode = document.getElementById("divid" + (index + 1)).getAttribute('data');
                self.keyword.value = text;
                document.getElementById("result1").style.display = "none";
                //根据选择的输入提示关键字查询
                self.mapObj.plugin(["AMap.PlaceSearch"], function() {
                    var msearch = new AMap.PlaceSearch(); //构造地点查询类
                    AMap.event.addListener(msearch, "complete", placeSearch_CallBack); //查询成功时的回调函数
                    msearch.setCity(cityCode);
                    msearch.search(text); //关键字查询查询
                });
            }

            //输出关键字查询结果的回调函数
            function placeSearch_CallBack(data) {
                //清空地图上的InfoWindow和Marker
                windowsArr = [];
                self.marker = [];
                self.mapObj.clearMap();
                var resultStr1 = "";
                self.poiArr = data.poiList.pois;
                var resultCount = self.poiArr.length;
                for (var i = 0; i < resultCount; i++) {
                    resultStr1 += "<div id='divid" + (i + 1) + "' style=\"font-size: 12px;cursor:pointer;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;\"><table><tr><td><img src=\"http://webapi.amap.com/images/" + (i + 1) + ".png\"></td>" + "<td><h3><font color=\"#00a6ac\">名称: " + self.poiArr[i].name + "</font></h3>";
                    resultStr1 += TipContents(self.poiArr[i].type, self.poiArr[i].address, self.poiArr[i].tel) + "</td></tr></table></div>";
                    addmarker(i, self.poiArr[i]);
                }
                self.mapObj.setFitView();
                document.getElementById("result").innerHTML = resultStr1;
                document.getElementById("result").style.display = "block";

                $('#result').children().mouseover(function() {
                    var index = this.id.split('divid')[1];
                    openMarkerTipById1(index - 1, this);
                });
                $('#result').children().mouseout(function() {
                    var index = this.id.split('divid')[1];
                    onmouseout_MarkerStyle(index - 1, this);
                });
                $('#result').children().click(function() {
                    document.getElementById("result1").style.display = "";
                    document.getElementById("result").style.display = "";
                });
                $(document).click(function() {
                    document.getElementById("result1").style.display = "";
                    document.getElementById("result").style.display = "";
                });
            }

            //定位选择输入提示关键字
            function focus_callback() {
                if (navigator.userAgent.indexOf("MSIE") > 0) {
                    self.keyword.onpropertychange = autoSearch;
                }
            }

            //输入提示框鼠标滑过时的样式
            function openMarkerTipById(pointid, thiss) { //根据id打开搜索结果点tip 
                thiss.style.background = '#CAE1FF';
            }
            //鼠标滑过查询结果改变背景样式，根据id打开信息窗体
            function openMarkerTipById1(pointid, thiss) {
                thiss.style.background = '#CAE1FF';
                windowsArr[pointid].open(self.mapObj, self.marker[pointid]);
            }

            //输入提示框鼠标移出时的样式
            function onmouseout_MarkerStyle(pointid, thiss) { //鼠标移开后点样式恢复 
                thiss.style.background = "";
            }

            //添加查询结果的marker&infowindow   
            function addmarker(i, d) {
                var lngX = d.location.getLng();
                var latY = d.location.getLat();
                var markerOption = {
                    map: self.mapObj,
                    icon: "http://webapi.amap.com/images/" + (i + 1) + ".png",
                    position: new AMap.LngLat(lngX, latY)
                };
                var mar = new AMap.Marker(markerOption);
                self.marker.push(new AMap.LngLat(lngX, latY));

                var infoWindow = new AMap.InfoWindow({
                    content: "<h3><font color=\"#00a6ac\">  " + (i + 1) + ". " + d.name + "</font></h3>" + TipContents(d.type, d.address, d.tel) + '<div style="text-align:right;"><a id="chooseMarker' + i + '">标注位置</a></div>',
                    size: new AMap.Size(300, 0),
                    autoMove: true,
                    offset: new AMap.Pixel(0, -30)
                });
                windowsArr.push(infoWindow);
                var aa = function(e) {
                    infoWindow.open(self.mapObj, mar.getPosition());
                };
                AMap.event.addListener(mar, "click", aa);


            }

            //infowindow显示内容
            function TipContents(type, address, tel) { //窗体内容
                if (type == "" || type == "undefined" || type == null || type == " undefined" || typeof type == "undefined") {
                    type = "暂无";
                }
                if (address == "" || address == "undefined" || address == null || address == " undefined" || typeof address == "undefined") {
                    address = "暂无";
                }
                if (tel == "" || tel == "undefined" || tel == null || tel == " undefined" || typeof address == "tel") {
                    tel = "暂无";
                }
                var str = "  地址：" + address + "<br />  电话：" + tel + " <br />  类型：" + type;
                return str;
            }

            self.addMenu = function(ifSet) {
                //地图中添加地图操作ToolBar插件、鼠标工具MouseTool插件
                self.mapObj.plugin(["AMap.ToolBar", "AMap.MouseTool"], function() {
                    toolBar = new AMap.ToolBar();
                    self.mapObj.addControl(toolBar);
                    self.mouseTool = new AMap.MouseTool(self.mapObj);
                });
                //自定义右键菜单内容
                var menuContent = document.createElement("div");
                if(ifSet){
                    menuContent.innerHTML = "<ul class='menuContent'><li id='xlznMarkPoint' class='menuContentLi'>添加路点</li><li id='xlznMarkCamping' class='menuContentLi'>添加营地</li></ul>";
                }else{
                     menuContent.innerHTML = "<ul class='menuContent'><li id='xlznMarkLocation' class='menuContentLi'>标注位置</li></ul>";
                }
                //创建右键菜单
                self.contextMenu = new AMap.ContextMenu({
                    isCustom: true,
                    content: menuContent
                }); //通过content自定义右键菜单内容

                //地图绑定鼠标右击事件——弹出右键菜单
                AMap.event.addListener(self.mapObj, 'rightclick', function(e) {
                    self.contextMenu.open(self.mapObj, e.lnglat);
                    self.contextMenuPositon = e.lnglat; //右键菜单位置
                    contextMenuPositon = self.contextMenuPositon;
                });
                
                if(ifSet){
                    //添加路点
                    $(document).delegate('#xlznMarkPoint', 'click', function() {
                        self.mouseTool.close();
                        if(!self.ifAddnew) self.ifAddnew = true;
                        self._startAddPoint = true;
                        self._unpostMarkerArr.push(self.addMarker(contextMenuPositon, self.markerType.point, '路点'));
                        self.contextMenu.close();
                    });
                    //添加营地
                    $(document).delegate('#xlznMarkCamping', 'click', function() {
                        self.mouseTool.close();
                        if(!self.ifAddnew) self.ifAddnew = true;   
                        self._startAddPoint = true;                     
                        self._unpostMarkerArr.push(self.addMarker(contextMenuPositon, self.markerType.camping, '营地'));
                        self.contextMenu.close();
                    });
                    //关闭标记编辑框
                    $(document).delegate('.xlzn_mk_dialog_close', 'click', function(){
                        $(this).parent().hide();
                    });
                    //标记编辑框确定事件
                    $(document).delegate('.xlzn_mk_sure', 'click', function(e){
                        e.preventDefault();
                        var text = $('.xlzn_mk_edit input').val();
                        $(self.currMarker.getContent()).find('.xlzn_mk_tip').text(text);
                        if(self.ifPostData){//已审核通过路点营地是否编辑后数据提交
                            var _id =  $(this).prev().prev().find('[data-id]').attr('data-id'),
                                _postData = {
                                    road_point_id: _id,
                                    flag_txt: text
                                }
                            if(_id){
                                postMarkerData('update', _postData);
                            }
                        }
                        currInfoWindow.close();
                    });
                    
                    //删除标记
                    $(document).delegate('.xlzn_mk_delete', 'click', function(e){
                        e.preventDefault();
                        if(self.ifPostData){//已审核通过路点营地是否编辑后数据提交
                            var $pointid = $(this).prev().find('[data-id]'),
                                _id = $pointid.attr('data-id'),
                                _postData = {road_point_id: _id};
                            if(_id){
                                postMarkerData('delete', _postData);
                            }else{
                                self.currMarker.setMap(null);
                                currInfoWindow.close();
                            }
                        }else{
                            self.currMarker.setMap(null);
                            currInfoWindow.close();
                        }
                    });
                    //enter键确定
                    $(document).delegate('.xlzn_mk_edit input', 'keypress', function(event){
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if(keycode == '13'){
                            var text = $('.xlzn_mk_edit input').val();
                            $(self.currMarker.getContent()).find('.xlzn_mk_tip').text(text);
                            if(self.ifPostData){//已审核通过路点营地是否编辑后数据提交
                                var _id = $(this).attr('data-id'),
                                    _postData = {
                                        road_point_id: _id,
                                        flag_txt: text
                                    }
                                if(_id){
                                    postMarkerData('update', _postData);
                                }
                            }
                            currInfoWindow.close();
                            
                        }
                    });
                }else{
                    //标注位置
                    $(document).delegate('#xlznMarkLocation', 'click', function() {
                        mapObjTarget = self.contextMenuPositon;
                        self.mapObj.clearMap();
                        self.mouseTool.close();
                        var marker = new AMap.Marker({
                            map: self.mapObj,
                            position: self.contextMenuPositon, //基点位置
                            draggable: true, //是否可拖动
                            icon: "http://webapi.amap.com/images/marker_sprite.png", //marker图标，直接传递地址url
                            offset: {
                                x: -8,
                                y: -34
                            } //相对于基点的位置
                        });
                        AMap.event.addListener(marker, 'dragend', function(e){
                            var $target = $(e.target.getContent()),
                                lng = e.lnglat.lng,
                                lat = e.lnglat.lat;
                            $('[name="lngi"]').val(lng);
                            $('[name="lati"]').val(lat);
                            $('#lnglat').text(lng + ', ' + lat);    
                        });
                        self.contextMenu.close();
                        $('[name="lngi"]').val(mapObjTarget.lng);
                        $('[name="lati"]').val(mapObjTarget.lat);
                        $('#lnglat').text(mapObjTarget.lng + ', ' + mapObjTarget.lat).show();
                        $('[data-tipfor="lngi"]').hide();
                        if(self.relativeMap){
                            self.relativeMap.destroy();
                            var typeId = $('[name="route_type_id"]:checked').val() || $('[name="route_type_id"]').val(),
                            title = $('[name="route_name"]').val();
                            var map = new xlznMap();
                            map.init('xlznMap',mapObjTarget, typeId, title);
                            map.addMenu(true);
                            self.relativeMap = map.getMap();
                            window.roadMap = self.relativeMap;
                            window.roadMap.ifSetViewFit = true;
                            window.xlznRoadData = {};
                            if(window.route_info){
                                route_info.map_line_id = null;
                            }
                        }
                    });

                    $(document).delegate('[id^="chooseMarker"]', 'click', function() {
                        var i = this.id.split('chooseMarker')[1];

                        mapObjTarget = self.poiArr[i];
                        self.mapObj.clearMap();
                        var marker = new AMap.Marker({
                            map: self.mapObj,
                            position: self.poiArr[i].location, //基点位置
                            draggable: true, //是否可拖动
                            icon: "http://webapi.amap.com/images/marker_sprite.png", //marker图标，直接传递地址url
                            offset: {
                                x: -8,
                                y: -34
                            } //相对于基点的位置
                        });
                        AMap.event.addListener(marker, 'dragend', function(e){
                            var $target = $(e.target.getContent()),
                                lng = e.lnglat.lng,
                                lat = e.lnglat.lat;
                            $('[name="lngi"]').val(lng);
                            $('[name="lati"]').val(lat);
                            $('#lnglat').text(lng + ', ' + lat);    
                        });
                        $('[name="dest_node_name"]').val(mapObjTarget.name.replace(/\([^\)]*\)/g,""));
                        $('[name="lngi"]').val(mapObjTarget.location.lng);
                        $('[name="lati"]').val(mapObjTarget.location.lat);
                        $('#lnglat').text(mapObjTarget.location.lng + ', ' + mapObjTarget.location.lat).show();
                        $('[data-tipfor="lngi"]').hide();
                        if(self.relativeMap){
                            self.relativeMap.destroy();
                            var map = new xlznMap();
                            var typeId = $('[name="route_type_id"]:checked').val() || $('[name="route_type_id"]').val(),
                            title = $('[name="route_name"]').val();
                            map.init('xlznMap',{'lng': mapObjTarget.location.lng,'lat': mapObjTarget.location.lat}, typeId, title);
                            map.addMenu(true);
                            self.relativeMap = map.getMap();
                            window.roadMap = self.relativeMap;
                            window.roadMap.ifSetViewFit = true;
                            window.xlznRoadData = {};
                            if(window.route_info){
                                route_info.map_line_id = null;
                            }
                        }
                    });
                }
                
            }

            //轨迹
            self.polyLine = function(arr,color){
                self.lineArr = [];
                var _elevationMax = arr[0].Alt,
                    _elevationMin = arr[0].Alt;
                $(arr).each(function(i, obj){
                    /*var _result = GPS.gcj_decrypt(obj.Lat,obj.Lng),
                        _lng = _result.lon,
                        _lat = _result.lat;

                     self.lineArr.push(new AMap.LngLat(_lng, _lat)); */
                     self.lineArr.push(new AMap.LngLat(obj.Lng, obj.Lat)); 
                     var _alt = parseFloat(obj.Alt);
                     if(_alt > _elevationMax){
                        _elevationMax = _alt;
                     }
                     if(_elevationMin > _alt){
                        _elevationMin = _alt;
                     }
                });
                if(!color)color="#a75cde";
                //绘制轨迹
                var polyline = new AMap.Polyline({
                    map:self.mapObj,
                    path:self.lineArr,
                    strokeColor:color,//线颜色
                    strokeOpacity:10,//线透明度
                    strokeWeight:3,//线宽
                    strokeStyle:"solid"//线样式
                });
                
                /*var centerObj = {
                    lat: arr[arr.length-1].Lat,
                    lng: arr[arr.length-1].Lng
                }
                self.addMarker(centerObj, self.markerType.end, '终点');*/
                self.mapObj.setFitView();
                return {
                    eMax: _elevationMax,
                    eMin: _elevationMin
                }
            }

            self.getMap = function(){
                return self.mapObj;
            }
            function postMarkerData(type, postData){
                if(type == 'delete'){
                    $.post("/route/del_road_point",postData,function(data){
                        self.currMarker.setMap(null);
                        currInfoWindow.close();
                    });
                }
                if(type == 'update'){
                    $.post("/route/mdf_road_point",postData,function(data){
                        
                    });
                }
            }
            self.disabledPostedMarker = function(){//已提交路点营地禁止操作
                if(self._unpostMarkerArr.length>0){
                    for(var i = 0,len = self._unpostMarkerArr.length; i < len; i++){
                        for(var _ev in self._unpostMarkerArr[i]._event){
                            AMap.event.removeListener(self._unpostMarkerArr[i]._event[_ev])
                        }
                        self._unpostMarkerArr[i].marker.setDraggable(false);
                    }
                }
            }
        }
    })
}(jQuery);
