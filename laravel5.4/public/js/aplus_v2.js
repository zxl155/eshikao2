!function t(e,n,r){function a(i,u){if(!n[i]){if(!e[i]){var s="function"==typeof require&&require;if(!u&&s)return s(i,!0);if(o)return o(i,!0);throw new Error("Cannot find module '"+i+"'")}var l=n[i]={exports:{}};e[i][0].call(l.exports,function(t){var n=e[i][1][t];return a(n?n:t)},l,l.exports,t,e,n,r)}return n[i].exports}for(var o="function"==typeof require&&require,i=0;i<r.length;i++)a(r[i]);return a}({1:[function(t,e,n){"use strict";function r(t,e){return t&&t.getAttribute?t.getAttribute(e)||"":""}function a(t){return i=i||document.getElementsByTagName("head")[0],u&&!t?u:i?u=i.getElementsByTagName("meta"):[]}function o(t){var e,n,o,i=a(),u=i.length;for(e=0;u>e;e++)n=i[e],r(n,"name")===t&&(o=r(n,"content"));return o||""}var i,u,s=t("@ali/grey-publish").util;n.tryToGetAttribute=r,n.getMetaTags=a,n.getMetaCnt=o,n.indexof=function(t,e){for(var n=0;n<t.length;n++)if(t[n]===e)return n;return-1};var l=function(t,e){return t+="",t.length<e&&(t="0"+t),t};n.getDateMin=function(){var t=new Date,e="";return e+=t.getFullYear(),e+=l(t.getMonth()+1,2),e+=l(t.getDate(),2),e+=l(t.getHours(),2),e+=l(t.getMinutes(),2)},n.loopAddScript=function(t,e){try{if(e&&e instanceof Array){var n=0,r=function(a){a&&s.addScript(t+"/"+a,function(){r(e[++n])})};r(e[n])}}catch(a){}},n.getCdnpath=function(){var t=document,e=t.getElementById("beacon-aplus")||t.getElementById("tb-beacon-aplus"),n="//g.alicdn.com",r=["//assets.alicdn.com/g","//g-assets.daily.taobao.net","//u.alicdn.com","//laz-g-cdn.alicdn.com"],a=new RegExp("//u.alicdn.com");if(e)for(var o=0;o<r.length;o++){var i=new RegExp(r[o]);if(i.test(e.src)){n=r[o],a.test(e.src)&&(n="//assets.alicdn.com/g");break}}return n},n.aplusVersions={V_O:"aplus_o.js",V_2:"aplus_v2.js",V_W:"aplus_wap.js",V_S:"aplus_std.js",V_I:"aplus_int.js",V_U:"aplus_u.js"}},{"@ali/grey-publish":2}],2:[function(t,e,n){"use strict";n.grey=t("./src/grey"),n.util=t("./src/util")},{"./src/grey":3,"./src/util":4}],3:[function(t,e,n){"use strict";function r(t,e){return t+Math.floor(Math.random()*(e-t+1))}function a(t){var e=!1;try{var n=t.bingo_chars||"0aAbBc1CdDeE2fFgGh3HiIjJ4kKlLm5MnNoO6pPqQr7RsStT8uUvVw9WxXyY+zZ",a=l.getCookie(t.bingo_cookiename||"cna")||"";if(a){var o=a.charAt(0),i=n.indexOf(o)/n.length;e=i<=t.ratio/t.base}else e=r(1,t.base)<=t.ratio}catch(u){e=r(1,t.base)<=t.ratio}return e}function o(t,e){var n;for(n in e)e.hasOwnProperty(n)&&(t[n]=e[n]);return t}function i(t,e){return function(n){return t(o(e,n||{}))}}function u(t){var e=window,n=document;if(t)try{var r=n.getElementsByTagName("script")[0],a=n.createElement("script");a.appendChild(n.createTextNode(t)),r.parentNode.insertBefore(a,r)}catch(o){try{(e.execScript||function(t){e.eval(t)})(t)}catch(i){}}}function s(t,e,n){try{var r=[],a=g.get(e);if(a){var o=JSON.parse(a)||[];if(o&&o.length>0)for(var i=new RegExp("^"+n),u=0;u<o.length;u++)i.test(o[u])?r.push(o[u]):g.remove(o[u])}r.push(t),g.set(e,JSON.stringify(r))}catch(s){}}var l=t("./util"),c=function(){},p=function(t){return"function"==typeof t},g={set:function(t,e){try{return localStorage.setItem(t,e),!0}catch(n){return!1}},get:function(t){return localStorage.getItem(t)},test:function(){var t="grey_test_key";try{return localStorage.setItem(t,1),localStorage.removeItem(t),!0}catch(e){return!1}},remove:function(t){localStorage.removeItem(t)}},f={base:1e4},v={_config:f},h=function(t,e){var n=window,r=n.XDomainRequest,a=n.XMLHttpRequest&&"withCredentials"in new n.XMLHttpRequest,o=e.after;if("function"!=typeof o&&(o=c),!e.isDebug&&g.test()&&(a||r)){var i=e.LS_KEY+l.hash(t),p=g.get(i);if(p)try{u(p),o({from:"local"})}catch(f){l.addScript(t,o)}else{var v=navigator.userAgent;l.request(t,v,function(t){g.set(i,t),s(i,e.LS_KEY_CLUSTER,e.LS_KEY),u(t),o({from:"cors"})},function(){l.addScript(t,o)})}}else l.addScript(t,o)};v.load=function(t){t=o({LS_KEY_CLUSTER:"",LS_KEY:"",isLoadDevVersion:c,dev:"",stable:"",grey:"",base:f.base,bingo:""},t);var e,n={},r="function"==typeof t.bingo?t.bingo:a;return t.ratio>=t.base||r(t)?(e=t.grey,n.type="grey"):(e=t.stable,n.type="stable"),p(t.isLoadDevVersion)&&t.isLoadDevVersion()&&(e=t.dev,n.type="dev"),n.url=e,p(t.before)&&t.before(n),t.after=p(t.after)?i(t.after,n):c,h(e,t),this},v.config=function(t){return o(f,t||{}),this},e.exports=v},{"./util":4}],4:[function(t,e,n){"use strict";var r=function(t,e){var n=document,r=n.getElementsByTagName("script")[0],a=n.getElementsByTagName("head")[0],o=n.createElement("script");o.type="text/javascript",o.async=!0,o.src=t,r?r.parentNode.insertBefore(o,r):a&&a.appendChild(o),"function"==typeof e&&e({from:"script"})};n.addScript=r,n.getCookie=function(t){var e=document,n=e.cookie.match(new RegExp("(?:^|;)\\s*"+t+"=([^;]+)"));return n?n[1]:""};var a={base:1e4,timeout:1e4};n.request=function(t,e,n,r){if(/blitz/i.test(e))return void r();var o,i="GET",u=function(){o.responseText?n(o.responseText):r()},s=window.XMLHttpRequest&&"withCredentials"in new XMLHttpRequest;s?(o=new XMLHttpRequest,o.open(i,t,!0)):(o=new XDomainRequest,o.open(i,t)),o.timeout=a.timeout,o.onload=u,o.onerror=r,o.ontimeout=r,o.send()},n.hash=function(t){var e,n,r=1315423911;for(e=t.length-1;e>=0;e--)n=t.charCodeAt(e),r^=(r<<5)+n+(r>>2);return(2147483647&r).toString(16)}},{}],5:[function(t,e,n){"use strict";!function(){var e=window,n="g_aplus_grey_launched";if(!e[n]){e[n]=1;var r=e.goldlog||(e.goldlog={}),a=t("@ali/grey-publish").grey,o=!1;try{var i=location.href.match(/aplusDebug=(true|false)/);i&&i.length>0&&window.localStorage.setItem("aplusDebug",i[1]),o="true"===window.localStorage.getItem("aplusDebug"),r.aplusDebug=o}catch(u){}var s=t("../grey/util"),l=t("./for_aplus_fns"),c={"aplus_o.js":{stable_version:{value:"8.3.13"},grey_version:{value:"8.3.14"},dev_version:{}},"aplus_std.js":{stable_version:{value:"8.3.13"},grey_version:{value:"8.3.14"},dev_version:{}},"aplus_wap.js":{stable_version:{value:"8.3.13"},grey_version:{value:"8.3.14"},dev_version:{}},"aplus_int.js":{stable_version:{value:"8.3.13"},grey_version:{value:"8.3.14"},dev_version:{}},"aplus_u.js":{stable_version:{value:"8.3.13"},grey_version:{value:"8.3.14"},dev_version:{}}},p="APLUS_S_CORE_0.19.21_20180411214439_",g=location.protocol;0!==g.indexOf("http")&&(g="http:");var f=s.getCdnpath();r.getCdnPath=s.getCdnpath;var v=g+f+"/alilog",h=l.getAplusBuVersion(),d=h.v,_=h.BU,m=1e4,b=[],y=function(){var t="";if(b&&b.length>0)for(var e=s.getDateMin(),n=0;n<b.length;n++){var r=b[n].key+"";e>=r&&(t=Math.floor(1e4*b[n].value))}return t},j=t("./utilPlugins"),w=function(t){var e,n=o?[]:j.getFrontPlugins({version:t,fn:d,BU:_}),r=[["s",t,d].join("/")],a=o?[]:j.getPlugins({version:t,fn:d,BU:_});try{var i=[].concat(n,r,a);e=v+"/??"+i.join(",")+"?v=20180411214439"}catch(u){e=v+"/??"+r.join(",")}return e},S=function(){var t,n="aplus_grey_ratio";"number"==typeof e[n]&&(t=Math.floor(1e4*e[n]));var r=location.search.match(new RegExp("\\b"+n+"=([\\d\\.]+)"));return r&&(r=parseFloat(r[1]),isNaN(r)||(t=Math.floor(1e4*r))),t},V=y(),E=S();V&&(m=V),E&&(m=E),r.aplus_cplugin_ver="0.3.19",r.record||(r.record=function(t,n,r,a){(e.goldlog_queue||(e.goldlog_queue=[])).push({action:"goldlog.record",arguments:[t,n,r,a]})});var B=c[d],k=B.stable_version.value||"7.7.0",x=B.grey_version.value||k,C=B.dev_version.value||x;a.load({LS_KEY_CLUSTER:"APLUS_LS_KEY",LS_KEY:p,isDebug:o,isLoadDevVersion:!1,dev:w(C),stable:w(k),grey:w(x),ratio:m,before:function(t){switch(t.type){case"grey":r.lver=C;break;case"stable":r.lver=k;break;case"dev":r.lver=C}o&&s.loopAddScript(v,j.getFrontPlugins({version:r.lver,fn:d,BU:_}))},after:function(){if(o){var t=0,e=function(){if(!(t>=100)){t++;var n=r._$||{};window.setTimeout(function(){"complete"===n.status?s.loopAddScript(v,j.getPlugins({version:r.lver,fn:d,BU:_})):e()},100)}};e()}}})}}()},{"../grey/util":1,"./for_aplus_fns":6,"./utilPlugins":9,"@ali/grey-publish":2}],6:[function(t,e,n){"use strict";var r=t("./util"),a=r.aplusVersions,o=[a.V_O,a.V_S,a.V_I,a.V_W,a.V_U],i=function(){for(var t,e,n=[{version:a.V_O,domains:[/^https?:\/\/(.*\.)?youku\.com/i,/^https?:\/\/(.*\.)?tudou\.com/i,/^https?:\/\/(.*\.)?soku\.com/i,/^https?:\/\/(.*\.)?laifeng\.com/i],BU:"YT"},{version:a.V_I,domains:[/^https?:\/\/(.*\.)?scmp\.com/i,/^https?:\/\/(.*\.)?luxehomes\.com\.hk/i,/^https?:\/\/(.*\.)?ays\.com\.hk/i,/^https?:\/\/(.*\.)?cpjobs\.com/i,/^https?:\/\/(.*\.)?educationpost\.com\.hk/i,/^https?:\/\/(.*\.)?elle\.com\.hk/i,/^https?:\/\/(.*\.)?harpersbazaar\.com\.hk/i,/^https?:\/\/(.*\.)?esquirehk\.com/i],BU:"SCMP"}],r=0;r<n.length;r++)for(var o=n[r].domains,i=n[r].version,u=0;u<o.length;u++)if(location.href.match(o[u]))return{v:i,BU:n[r].BU};return{v:e,BU:t}},u=function(){var t=r.getMetaCnt("aplus-version");return t&&(t+=".js"),r.indexof(o,t)>-1?t:null},s=function(){try{for(var t=document,e=t.getElementsByTagName("script"),n=0;n<e.length;n++){var r=e[n].getAttribute("src");if(/alilog\/mlog\/aplus_\w+\.js/.test(r)||/alicdn\.com\/js\/aplus_\w+\.js/.test(r))return r}return""}catch(a){return""}},l=function(){var t="";try{var e=document,n=e.getElementById("beacon-aplus")||e.getElementById("tb-beacon-aplus");if(n&&(t=n.getAttribute("src")),t||(t=s()),t){var r=t.match(/aplus_\w+\.js/);"object"==typeof r&&r.length>0&&(t=r[0])}}catch(a){t=""}finally{return t}};n.getAplusBuVersion=function(){var t,e;try{t=a.V_S;var n=l();n&&(t=n);var r=i();r&&r.v&&(t=r.v),e=r.BU;var o=u();o&&(t=o),t===a.V_2&&(t=a.V_S)}catch(s){t=t===a.V_O?a.V_W:a.V_S}finally{return{v:t,BU:e}}}},{"./util":8}],7:[function(t,e,n){"use strict";function r(){return!!s.getMetaCnt("aplus-auto-exp")}function a(){return!!s.getMetaCnt("aplus-auto-clk")}function o(){return"1"===s.getMetaCnt("aplus-no-track")||/aplus4web=true/.test(location.search)}var i=document,u=window,s=t("./util"),l=s.aplusVersions,c=(t("@ali/grey-publish").util,u.navigator.userAgent),p=/WindVane/i.test(c),g=/AliBaichuan/i.test(c),f=(parent!==self,/UT4Aplus/i.test(c)),v=function(t){return p&&!u.WindVane&&t.fn!==l.V_O},h=function(t){return(g||p&&!u.WindVane)&&t.fn===l.V_O},d=function(t){return t.fn===l.V_O||"YT"===t.BU},_=function(){return/_a_ig_v=@aplus/.test(location.search)},m=function(t){return!0},b=function(t){return t.fn!==l.V_O&&t.fn!==l.V_U},y=function(){try{var t=u.localStorage,e="aplus_track_debug_id",n=new RegExp("[?|&]"+e+"=(\\w*)"),r=location.href.match(n);if(r&&r.length>0)t.setItem(e,r[1]);else{var a=i.referrer||"",o=a.match(n);if(o&&o.length>0)t.setItem(e,o[1]);else{var s=u.name||"",l=s.match(n);l&&l.length>0&&t.setItem(e,l[1])}}var c=t.getItem(e)||"";return c&&c.length>50?!0:!1}catch(p){return!1}},j=function(){try{return!!/lazada/.test(location.host)}catch(t){return!1}},w=function(){try{return"work.alibaba-inc.com"===location.hostname&&("/"===location.pathname||"/home"===location.pathname||"/work/home"===location.pathname)||/aplus_ws=true/.test(location.search)}catch(t){return!1}};n.getFrontPlugins=function(t){var e="s/"+t.version+"/plugin",n=goldlog.aplus_cplugin_ver;return[{enable:v(t),path:[e,"aplus_windvane2.js"].join("/")},{enable:h(t),path:[e,"aplus_bcbridge.js"].join("/")},{enable:!!f,path:["aplus_cplugin",n,"aplus4ut.js"].join("/")},{enable:!0,path:[e,"aplus_client.js"].join("/")},{enable:!0,path:["aplus_cplugin",n,"toolkit.js"].join("/")},{enable:!0,path:["aplus_cplugin",n,"monitor.js"].join("/")},{enable:o(t),path:["aplus_cplugin",n,"aplus4web.js"].join("/")},{enable:y(),path:["aplus_cplugin",n,"track_deb.js"].join("/")},{enable:j(),path:["aplus_plugin_lazada","lazadalog.js"].join("/")},{enable:w(),path:["aplus_cplugin",n,"aplus_ws.js"].join("/")},{enable:r(),path:[e,"aplus_ae.js"].join("/")},{enable:a(),path:[e,"aplus_ac.js"].join("/")}]},n.getPlugins=function(t){var e="s/"+t.version+"/plugin",n=goldlog.aplus_cplugin_ver;return[{enable:d(t),path:[e,"aplus_urchin2.js"].join("/")},{enable:_(t),path:"aplus_plugin_guide/index.js"},{enable:m(t),path:["aplus_cplugin",n,"aol.js"].join("/")},{enable:b(t),path:[e,"aplus_spmact.js"].join("/")}]}},{"./util":8,"@ali/grey-publish":2}],8:[function(t,e,n){e.exports=t(1)},{"@ali/grey-publish":2}],9:[function(t,e,n){"use strict";var r,a=t("./plugins"),o=document;try{r=o.getElementById("beacon-aplus")||o.getElementById("tb-beacon-aplus")}catch(i){}var u=function(t){var e=[];try{if(r){var n=r.getAttribute(t||e);e=n.split(",")}}catch(a){e=[]}finally{return e}},s=function(t){var e=[];if(t)for(var n=0;n<t.length;n++){var r=t[n].enable,a=t[n].path;r===!0?e.push(a):"function"==typeof r&&r()&&e.push(a)}return e};n.getPlugins=function(t){var e=a.getPlugins(t);return[].concat(s(e),u("plugins"))},n.getFrontPlugins=function(t){var e=a.getFrontPlugins(t);return[].concat(s(e),u("frontPlugins"))}},{"./plugins":7}]},{},[5]);