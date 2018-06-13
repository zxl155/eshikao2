Array.prototype.elementRemove = function(dx)
{
	if(isNaN(dx)|| dx > this.length)
	{
		return false;
	}
	
	this.splice(dx,1);
}

function dateDiff(str2, str1)
{
	var tmp1 = str1.split('-');
	var tmp2 = str2.split('-');

	var date1 = new Date(tmp1[0], tmp1[1] - 1, tmp1[2]);
	var date2 = new Date(tmp2[0], tmp2[1] - 1, tmp2[2]);

	var days = date2 - date1;

	days = days / 86400 / 1000 + 1;

	return days;
}

function date(format, timestamp)
{
    var that = this,
        jsdate, f, formatChr = /\\?([a-z])/gi, formatChrCb,
        _pad = function (n, c) {
            if ((n = n + "").length < c) {
                return new Array((++c) - n.length).join("0") + n;
			} else {
                return n;
            }
        },
        txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur",
			"January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"],
        txt_ordin = {
            1: "st",
            2: "nd",            
			3: "rd",
            21: "st", 
            22: "nd",
            23: "rd",
            31: "st"
		};
    formatChrCb = function (t, s) {
        return f[t] ? f[t]() : s;
    };
    f = {    
		// Day
        d: function () { 
			// Day of month w/leading 0; 01..31
            return _pad(f.j(), 2);
        },
        D: function () { 
			// Shorthand day name; Mon...Sun            
			return f.l().slice(0, 3);
        },
        j: function () { 
			// Day of month; 1..31
            return jsdate.getDate();
        },        
		l: function () { 
			// Full day name; Monday...Sunday
            return txt_words[f.w()] + 'day';
        },
        N: function () { 
			// ISO-8601 day of week; 1[Mon]..7[Sun]
            return f.w() || 7;
		},
        S: function () { 
			// Ordinal suffix for day of month; st, nd, rd, th
            return txt_ordin[f.j()] || 'th';
        },
        w: function () { 
			// Day of week; 0[Sun]..6[Sat]            
			return jsdate.getDay();
        },
        z: function () { 
			// Day of year; 0..365
            var a = new Date(f.Y(), f.n() - 1, f.j()),
                b = new Date(f.Y(), 0, 1);            
			return Math.round((a - b) / 864e5) + 1;
        },
 
    // Week
        W: function () { 
			// ISO-8601 week number            
			var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
                b = new Date(a.getFullYear(), 0, 4);
            return 1 + Math.round((a - b) / 864e5 / 7);
        },
     // Month
        F: function () { 
			// Full month name; January...December
            return txt_words[6 + f.n()];
        },
        m: function () { 
			// Month w/leading 0; 01...12            
			return _pad(f.n(), 2);
        },
        M: function () { 
			// Shorthand month name; Jan...Dec
            return f.F().slice(0, 3);
        },        
		n: function () { 
			// Month; 1...12
            return jsdate.getMonth() + 1;
        },
        t: function () { 
			// Days in month; 28...31
            return (new Date(f.Y(), f.n(), 0)).getDate();
		},
 
    // Year
        L: function () { 
			// Is leap year?; 0 or 1
            var y = f.Y(), a = y & 3, b = y % 4e2, c = y % 1e2;
			return 0 + (!a && (c || !b));
        },
        o: function () { 
			// ISO-8601 year
            var n = f.n(), W = f.W(), Y = f.Y();
            return Y + (n === 12 && W < 9 ? -1 : n === 1 && W > 9);
		},
        Y: function () { 
			// Full year; e.g. 1980...2010
            return jsdate.getFullYear();
        },
        y: function () { 
			// Last two digits of year; 00...99
			return (f.Y() + "").slice(-2);
        },
 
    // Time
        a: function () { 
			// am or pm            
			return jsdate.getHours() > 11 ? "pm" : "am";
        },
        A: function () { 
			// AM or PM
            return f.a().toUpperCase();
        },        
		B: function () { 
			// Swatch Internet time; 000..999
            var H = jsdate.getUTCHours() * 36e2, // Hours
                i = jsdate.getUTCMinutes() * 60, // Minutes
                s = jsdate.getUTCSeconds(); // Seconds
            return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
		},
        g: function () { 
			// 12-Hours; 1..12
            return f.G() % 12 || 12;
        },
        G: function () { 
			// 24-Hours; 0..23            
			return jsdate.getHours();
        },
        h: function () { 
			// 12-Hours w/leading 0; 01..12
            return _pad(f.g(), 2);
        },        
		H: function () { 
			// 24-Hours w/leading 0; 00..23
            return _pad(f.G(), 2);
        },
        i: function () { 
			// Minutes w/leading 0; 00..59
            return _pad(jsdate.getMinutes(), 2);
		},
        s: function () { 
			// Seconds w/leading 0; 00..59
            return _pad(jsdate.getSeconds(), 2);
        },
        u: function () { 
			// Microseconds; 000000-999000
			return _pad(jsdate.getMilliseconds() * 1000, 6);
        },
 
    // Timezone
        e: function () { 
			// Timezone identifier; e.g. Atlantic/Azores, ...
			// The following works, but requires inclusion of the very large
			// timezone_abbreviations_list() function.
			/*              return this.date_default_timezone_get();
			*/
            throw 'Not supported (see source code of date() for timezone on how to add support)';        },
        I: function () { 
			// DST observed?; 0 or 1
            // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
            // If they are not equal, then DST is observed.
            var a = new Date(f.Y(), 0), // Jan 1                
				c = Date.UTC(f.Y(), 0), // Jan 1 UTC
                b = new Date(f.Y(), 6), // Jul 1
                d = Date.UTC(f.Y(), 6); // Jul 1 UTC
            return 0 + ((a - c) !== (b - d));
        },       
		O: function () { 
			// Difference to GMT in hour format; e.g. +0200
            var a = jsdate.getTimezoneOffset();
            return (a > 0 ? "-" : "+") + _pad(Math.abs(a / 60 * 100), 4);
        },
        P: function () { 
			// Difference to GMT w/colon; e.g. +02:00            
			var O = f.O();
            return (O.substr(0, 3) + ":" + O.substr(3, 2));
        },
        T: function () { 
			// Timezone abbreviation; e.g. EST, MDT, ...
            return 'UTC';
		},
        Z: function () { 
			// Timezone offset in seconds (-43200...50400)
            return -jsdate.getTimezoneOffset() * 60;
        },
     // Full Date/Time
        c: function () { 
			// ISO-8601 date.
            return 'Y-m-d\\Th:i:sP'.replace(formatChr, formatChrCb);
        },
        r: function () { 
			// RFC 2822            
			return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
        },
        U: function () { 
			// Seconds since UNIX epoch
            return jsdate.getTime() / 1000 | 0;
        }
	};
    this.date = function (format, timestamp) {
        that = this;
        jsdate = (
            (typeof timestamp === 'undefined') ? new Date() : // Not provided
			(timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
            new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
        );
        return format.replace(formatChr, formatChrCb);
    };

	return this.date(format, timestamp);
}

function strtotime (str, now) {

    var i, match, s, strTmp = '', parse = '';

    strTmp = str;
    strTmp = strTmp.replace(/\s{2,}|^\s|\s$/g, ' '); // unecessary spaces
    strTmp = strTmp.replace(/[\t\r\n]/g, ''); // unecessary chars

    if (strTmp == 'now') {
        return (new Date()).getTime()/1000; // Return seconds, not milli-seconds
    } else if (!isNaN(parse = Date.parse(strTmp))) {
        return (parse/1000);
    } else if (now) {
        now = new Date(now*1000); // Accept PHP-style seconds
    } else {
        now = new Date();
    }

    strTmp = strTmp.toLowerCase();

    var __is =
    {
        day:
        {
            'sun': 0,
            'mon': 1,
            'tue': 2,
            'wed': 3,
            'thu': 4,
            'fri': 5,
            'sat': 6
        },
        mon:
        {
            'jan': 0,
            'feb': 1,
            'mar': 2,
            'apr': 3,
            'may': 4,
            'jun': 5,
            'jul': 6,
            'aug': 7,
            'sep': 8,
            'oct': 9,
            'nov': 10,
            'dec': 11
        }
    };

    var process = function (m) {
        var ago = (m[2] && m[2] == 'ago');
        var num = (num = m[0] == 'last' ? -1 : 1) * (ago ? -1 : 1);

        switch (m[0]) {
            case 'last':
            case 'next':
                switch (m[1].substring(0, 3)) {
                    case 'yea':
                        now.setFullYear(now.getFullYear() + num);
                        break;
                    case 'mon':
                        now.setMonth(now.getMonth() + num);
                        break;
                    case 'wee':
                        now.setDate(now.getDate() + (num * 7));
                        break;
                    case 'day':
                        now.setDate(now.getDate() + num);
                        break;
                    case 'hou':
                        now.setHours(now.getHours() + num);
                        break;
                    case 'min':
                        now.setMinutes(now.getMinutes() + num);
                        break;
                    case 'sec':
                        now.setSeconds(now.getSeconds() + num);
                        break;
                    default:
                        var day;
                        if (typeof (day = __is.day[m[1].substring(0, 3)]) != 'undefined') {
                            var diff = day - now.getDay();
                            if (diff == 0) {
                                diff = 7 * num;
                            } else if (diff > 0) {
                                if (m[0] == 'last') {diff -= 7;}
                            } else {
                                if (m[0] == 'next') {diff += 7;}
                            }
                            now.setDate(now.getDate() + diff);
                        }
                }
                break;

            default:
                if (/\d+/.test(m[0])) {
                    num *= parseInt(m[0], 10);

                    switch (m[1].substring(0, 3)) {
                        case 'yea':
                            now.setFullYear(now.getFullYear() + num);
                            break;
                        case 'mon':
                            now.setMonth(now.getMonth() + num);
                            break;
                        case 'wee':
                            now.setDate(now.getDate() + (num * 7));
                            break;
                        case 'day':
                            now.setDate(now.getDate() + num);
                            break;
                        case 'hou':
                            now.setHours(now.getHours() + num);
                            break;
                        case 'min':
                            now.setMinutes(now.getMinutes() + num);
                            break;
                        case 'sec':
                            now.setSeconds(now.getSeconds() + num);
                            break;
                    }
                } else {
                    return false;
                }
                break;
        }
        return true;
    };

    match = strTmp.match(/^(\d{2,4}-\d{2}-\d{2})(?:\s(\d{1,2}:\d{2}(:\d{2})?)?(?:\.(\d+))?)?$/);
    if (match != null) {
        if (!match[2]) {
            match[2] = '00:00:00';
        } else if (!match[3]) {
            match[2] += ':00';
        }

        s = match[1].split(/-/g);

        for (i in __is.mon) {
            if (__is.mon[i] == s[1] - 1) {
                s[1] = i;
            }
        }
        s[0] = parseInt(s[0], 10);

        s[0] = (s[0] >= 0 && s[0] <= 69) ? '20'+(s[0] < 10 ? '0'+s[0] : s[0]+'') : (s[0] >= 70 && s[0] <= 99) ? '19'+s[0] : s[0]+'';
        return parseInt(this.strtotime(s[2] + ' ' + s[1] + ' ' + s[0] + ' ' + match[2])+(match[4] ? match[4]/1000 : ''), 10);
    }

    var regex = '([+-]?\\d+\\s'+
        '(years?|months?|weeks?|days?|hours?|min|minutes?|sec|seconds?'+
        '|sun\\.?|sunday|mon\\.?|monday|tue\\.?|tuesday|wed\\.?|wednesday'+
        '|thu\\.?|thursday|fri\\.?|friday|sat\\.?|saturday)'+
        '|(last|next)\\s'+
        '(years?|months?|weeks?|days?|hours?|min|minutes?|sec|seconds?'+
        '|sun\\.?|sunday|mon\\.?|monday|tue\\.?|tuesday|wed\\.?|wednesday'+
        '|thu\\.?|thursday|fri\\.?|friday|sat\\.?|saturday))'+
        '(\\sago)?';

    match = strTmp.match(new RegExp(regex, 'gi')); // Brett: seems should be case insensitive per docs, so added 'i'
    if (match == null) {
        return false;
    }

    for (i = 0; i < match.length; i++) {
        if (!process(match[i].split(' '))) {
            return false;
        }
    }

    return (now.getTime()/1000);
}

function getBirthday(string)
{
	var yyyy;
	var mm;
	var dd;
	var birthday;
	
	if (string.length == 15)
	{
		yyyy= "19" + string.substring(6, 8);
		mm= string.substring(8, 10);
		dd= string.substring(10, 12);

		if (mm <= 0 || mm > 12)
		{
			return flase;
		}

		if (dd <= 0 || dd > 31)
		{
			return false;
		}

		birthday = yyyy + "-" + mm + "-" +dd;

		return birthday;
	}
	else if (string.length == 18)
	{
		yyyy= string.substring(6, 10);
		mm= string.substring(10, 12);
		dd= string.substring(12, 14);

		if (mm <= 0 || mm > 12)
		{
			return flase;
		}

		if (dd <= 0 || dd > 31)
		{
			return false;
		}

		birthday = yyyy + "-" + mm + "-" +dd;

		return birthday;
	}
	else
	{
		return false;
	}
}

function calcAge(birth, date)
{
	var bdstr;
	var datestr;
	
	var tmp = birth.split('-');
	bdstr = tmp[1] + tmp[2];
	birth = new Date(tmp[0], tmp[1] - 1, tmp[2]);

	tmp = date.split('-');

	datestr = tmp[1] + tmp[2];
	date = new Date(tmp[0], tmp[1] - 1, tmp[2]);

	var age = date.getFullYear() - birth.getFullYear();

	age = bdstr > datestr ? age - 1  : age;

	return age;
}

function checkAge(age, agemin, agemax)
{
	if (age < agemin || age > agemax)
	{
		return false;
	}

	return true;
}

// tabify

(function($){

	$.fn.extend({
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
})(jQuery);

$(document).ready(function() {

	$('a[rel="external"]').click( function() {
		window.open( $(this).attr('href') );
		return false;
	});

});