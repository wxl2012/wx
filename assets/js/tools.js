String.prototype.trim = function() {
    var str = this,
    str = str.replace(/^\s\s*/, ''),
    ws = /\s/,
    i = str.length;
    while (ws.test(str.charAt(--i)));
    return str.slice(0, i + 1);
}

/**
* 
* 使用方法：
*  "{0}-{1}-01".format(year, month, day);
*/
String.prototype.format = function(){    
    var args = arguments;    
    return this.replace(/\{(\d+)\}/g,                    
        function(m,i){    
            return args[i];    
        });    
}

String.prototype.replaceAll = function(reallyDo, replaceWith, ignoreCase) { 
    if (!RegExp.prototype.isPrototypeOf(reallyDo)) {
        return this.replace(new RegExp(reallyDo, (ignoreCase ? "gi": "g")), replaceWith); 
    } else { 
        return this.replace(reallyDo, replaceWith); 
    } 
}


function getStringBytesCount(str) { 
    if (str == null) { 
        return 0; 
    } else { 
        return (str.length + str.replace(/[\u0000-\u00ff]/g, "").length); 
    } 
}

Array.prototype.remove = function ( dx ) {
    if (isNaN(dx) || dx > this.length) {
        return false;
    }
    for (var i = 0, n = 0; i < this.length; i++) {
        if (this[i] != this[dx]) {
            this[n++] = this[i]
        }
    }
    this.length -= 1
}

Array.prototype.is_exist = function ( value ) {
    if (value == undefined || value == 'undefined') {
        return false;
    }
    for (var i = 0; i < this.length; i++) {
        if (this[i] == value) {
            return true;
        }
    }
    return false;
}

/**
功能：
    倒计时
参数：
    unixtime      截止时间戳
    elementDay    显示剩余天数的元素
    elementHour   显示剩余小时数的元素
    elementMinute 显示剩余分钟数的元素
    elementSecond 显示剩余秒数的元素
返回：
    日期时间串
示例：


*/
function countDown(unixtime, elementDay, elementHour, elementMinute, elementSecond){
    var now = new Date();
    var endDate = new Date(unixtime*1000);
    var leftTime = endDate.getTime()-now.getTime();
    var leftsecond = parseInt(leftTime/1000);
    var day = Math.floor(leftsecond/(60*60*24));
    var hour = Math.floor((leftsecond-day*24*60*60)/3600);
    var minute = Math.floor((leftsecond-day*24*60*60-hour*3600)/60);
    var second = Math.floor(leftsecond-day*24*60*60-hour*3600-minute*60);
    
    if(elementDay != undefined){
        $('#' + elementDay).html(day < 10 && day > 0 ? "0" + day : day);
    }
    
    $('#' + elementHour).html((hour < 10 ? '0' : '') + hour);
    $('#' + elementMinute).html((minute < 10 ? '0' : '') + minute);
    $('#' + elementSecond).html((second < 10 ? '0' : '') + second);
}


/**
功能：
    获取n天前的日期
参数：
    n      天数
返回：
    日期时间串
示例：
alert(getBeforeDate(7)); 
alert(getBeforeDate(30));

*/
function getBeforeDate(n){
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    var day = date.getDate();
    if(day <= n){
        if(month > 1) {
            month = month - 1;
        } else {
            year = year - 1;
            month = 12;
        }
    }

    date.setDate(date.getDate() - n);
    year = date.getFullYear();
    month = date.getMonth() + 1;
    day = date.getDate();
    return "{0}-{1}-{2}".format(year, month < 10 ? "0" + month : month, day < 10 ? "0" + day : day);
} 

function nowtime(){

}

/**
功能：
    日期转换为时间戳
参数：
    str_time    日期
返回：
    时间戳
示例：
alert(strtotime(7)); 
alert(strtotime(30));

*/
function strtotime(str_time){
    var new_str = str_time.replace(/:/g,'-');
    new_str = new_str.replace(/ /g,'-');
    var arr = new_str.split("-");
    var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
    return datum.getTime() / 1000;
}

/**
功能：
	时间戳转换为指定格式日期
参数：
	format 		转换的格式
	timestamp 	时间戳
返回：
	日期时间串
示例：
alert(timetodate('Y-m-d H:i:s',(new Date).getTime()/1000)); 
alert(timetodate('Y-m-d',(new Date).getTime()/1000)); 
alert(timetodate('Y-m-d H:i:s','1355252653'));

*/
function timetodate(format, timestamp){   
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());  
    var pad = function(n, c){  
        if((n = n + "").length < c){  
            return new Array(++c - n.length).join("0") + n;  
        } else {  
            return n;  
        }  
    };  
    var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];  
    var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"};  
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];   
    var f = {  
        // Day  
        d: function(){return pad(f.j(), 2)},  
        D: function(){return f.l().substr(0,3)},  
        j: function(){return jsdate.getDate()},  
        l: function(){return txt_weekdays[f.w()]},  
        N: function(){return f.w() + 1},  
        S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'},  
        w: function(){return jsdate.getDay()},  
        z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0},  
        
        // Week  
        W: function(){  
            var a = f.z(), b = 364 + f.L() - a;  
            var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;  
            if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){  
                return 1;  
            } else{  
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){  
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");  
                    return date("W", Math.round(nd2.getTime()/1000));  
                } else{  
                    return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);  
                }  
            }  
        },  
        
        // Month  
        F: function(){return txt_months[f.n()]},  
        m: function(){return pad(f.n(), 2)},  
        M: function(){return f.F().substr(0,3)},  
        n: function(){return jsdate.getMonth() + 1},  
        t: function(){  
            var n;  
            if( (n = jsdate.getMonth() + 1) == 2 ){  
                return 28 + f.L();  
            } else{  
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){  
                    return 31;  
                } else{  
                    return 30;  
                }  
            }  
        },  
        
        // Year  
        L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},  
        //o not supported yet  
        Y: function(){return jsdate.getFullYear()},  
        y: function(){return (jsdate.getFullYear() + "").slice(2)},  
        
        // Time  
        a: function(){return jsdate.getHours() > 11 ? "pm" : "am"},  
        A: function(){return f.a().toUpperCase()},  
        B: function(){  
            // peter paul koch:  
            var off = (jsdate.getTimezoneOffset() + 60)*60;  
            var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;  
            var beat = Math.floor(theSeconds/86.4);  
            if (beat > 1000) beat -= 1000;  
            if (beat < 0) beat += 1000;  
            if ((String(beat)).length == 1) beat = "00"+beat;  
            if ((String(beat)).length == 2) beat = "0"+beat;  
            return beat;  
        },  
        g: function(){return jsdate.getHours() % 12 || 12},  
        G: function(){return jsdate.getHours()},  
        h: function(){return pad(f.g(), 2)},  
        H: function(){return pad(jsdate.getHours(), 2)},  
        i: function(){return pad(jsdate.getMinutes(), 2)},  
        s: function(){return pad(jsdate.getSeconds(), 2)},  
        //u not supported yet  
        
        // Timezone  
        //e not supported yet  
        //I not supported yet  
        O: function(){  
            var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);  
            if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;  
            return t;  
        },  
        P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))},  
        //T not supported yet  
        //Z not supported yet  
        
        // Full Date/Time  
        c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()},  
        //r not supported yet  
        U: function(){return Math.round(jsdate.getTime()/1000)}  
    };  
        
    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){  
        if( t!=s ){  
            // escaped  
            ret = s;  
        } else if( f[s] ){  
            // a date function exists  
            ret = f[s]();  
        } else{  
            // nothing special  
            ret = s;  
        }  
        return ret;  
    });  
}

//获取某月的最后一天
function getMonthLastDayByYearMonth(year, month) { 
    var date = new Date();
    date.setFullYear(year, month, 1);

    var MonthNextFirstDay=new Date(date.getFullYear(), date.getMonth(),1); 
    var MonthLastDay=new Date(MonthNextFirstDay - 86400000); 
    return MonthLastDay;
}

//取得本月最后一天 
function getMonthLastDay(formattype) { 
    var Nowdate = new Date(); 
    var MonthNextFirstDay=new Date(Nowdate.getFullYear(),Nowdate.getMonth()+1,1); 
    var MonthLastDay=new Date(MonthNextFirstDay-86400000); 
    return formatDate(MonthLastDay,formattype);
}

//对javascript日期进行格式化
//formattype是返回的时间类型
//返回：返回时间串
function formatDate(date,formattype){
    var dateString = "";

    var thisyear = formatYear(date.getFullYear());
    var thismonth = appendZero(date.getMonth()+1);
    var thisday = appendZero(date.getDate());
    var thishour = appendZero(date.getHours());
    var thismin  = appendZero(date.getMinutes());
    var thissec  = appendZero(date.getSeconds());

    switch (formattype){
        case 0:
            dateString = thisyear + "年" + thismonth + "月" + thisday + "日";
            break;
        case 1:
            dateString = thisyear + "-" + thismonth + "-" + thisday;
            break;
        case 2:
            dateString = thisyear + "-" + thismonth + "-" + thisday+ " " + appendZero(thishour) + ":" + appendZero(thismin) + ":" + appendZero(thissec);
            break;

        default:
            dateString = thisyear + "-" + thismonth + "-" + thisday;
    }
    return dateString;
}

//把年份格式化成4位 
function formatYear(theYear){
    var tmpYear = parseInt(theYear,10);
    if (tmpYear < 100){
        tmpYear += 1900;
        if (tmpYear < 1940){
            tmpYear += 100;
        }
    }

    if (tmpYear < this.MinYear){
        tmpYear = this.MinYear;
    }
    if (tmpYear > this.MaxYear){
        tmpYear = this.MaxYear;
    }
    return(tmpYear);
}

//日期自动补零程序
function appendZero(n) {
    return(("00"+ n).substr(("00"+ n).length-2));
}

