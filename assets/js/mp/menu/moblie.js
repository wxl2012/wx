
var _current_menuitem;

$(function () {

    $(document).delegate('input', 'click', function(){
        _current_menuitem = $(this);
        syn($(this));
    });

    $(document).delegate('input', 'keyup', function(e){

        syn($(this));

        var num = getStringBytesCount($(this).val());

        if(e.keyCode == 8 || e.keyCode == 46){
            return;
        }
        if(_current_menuitem.parent().is('li')){
            if(num > 40){
                alert('子菜单项名字必须小于40字节(20汉字)');
                return false;
            }
        }else if(_current_menuitem.parent().is('div')){
            if(num > 16){
                alert('一级菜单项名字必须小于10字节(5汉字)');
                return false;
            }
        }
    });

});

/**
 * 同步父窗体内容
 *
 * @param element
 */
function syn(element) {
    var data = JSON.parse(element.attr('data'));
    window.parent.setMenuInfo(data);
}

/**
 * 设置菜单事件
 *
 * @param data
 */
function setMenuItem(data) {
    data.name = _current_menuitem.val();
    _current_menuitem.attr('data', JSON.stringify(data));
}

/**
 * 添加一组菜单
 */
function addMenu() {

    var count = $('#menu-item').find('div').length;
    if(count >= 3){
        alert('最多只允许添加3个菜单项');
        return;
    }

    $('#menu-item').append(menuItemHtml, {index: count}, null);
    $('#submenu-item').append(menuHtml, {index: count}, null);
    autoAdjust(1);
}

/**
 * 移除一组菜单
 */
function removeMenu() {
    if(_current_menuitem == undefined){
        alert('请先选择需要删除的菜单项!');
        return;
    }
    if(_current_menuitem.parent().is('li')){
        _current_menuitem.val('').attr('data', '');
    }
    if(_current_menuitem.parent().is('div')){
        var count = _current_menuitem.parent().parent().find('div').length;
        if(count < 2){
            alert('至少保留1项菜单项,如果不想使用自定义菜单请点“关闭自定义菜单”。');
            return;
        }

        var id = _current_menuitem.parent().attr('id');
        id = id.substring(id.length - 1);

        var current;
        if(id < 2){
            current = $('#menuItem' + id).next();
            sub_current = $('#submenuItem' + id).next();
        }
        $('#menuItem' + id).remove();
        $('#submenuItem' + id).remove();
        for(i = id;i < count - 1; i ++){
            new_id = current.attr('id').substring(current.attr('id').length - 1);
            current.attr('id',  "menuItem" + (new_id - 1));
            current = current.next();

            sub_current.attr('id',  "submenuItem" + (new_id - 1));
            sub_current = sub_current.next();
        }
    }
    current_menu = undefined;
    autoAdjust(0);
}

/**
 * 发布菜单
 */
function publish() {
    var count = 0;
    var flag = true;
    var msg = '';

    var subs = [
    ];

    $('#menu-item').find('input[type=text]').each(function () {

        if( ! flag){
            return;
        }

        var data = JSON.parse($(this).attr('data'));
        data.name = $(this).val();
        data.sub_button = [];
        subs[subs.length] = data;

    });


    $('input[type=text]').each(function (index, element) {

        if( ! flag){
            return;
        }

        var data = JSON.parse($(this).attr('data'));
        if(data.name.length < 1){
            return;
        }
        if($(this).attr('role') != '一级'){
            if(data.type == 'view' && data.url.length < 1){
                alert($(this).attr('placeholder') + '缺少网址参数');
                flag = false;
            }else if(data.type == 'click' && data.key.length < 1){
                alert($(this).attr('placeholder') + '缺少关键字参数');
                flag = false;
            }else if((data.type == 'media_id' || data.type == 'view_limited') && data.media_id.length < 1){
                alert($(this).attr('placeholder') + '缺少素材参数');
                flag = false;
            }else{
                data.key = 'abc';
            }
            subs[parseInt(index / 5)].sub_button[subs[parseInt(index / 5)].sub_button.length] = data;
        }

    });

    if(! flag){
        alert('菜单数据不合法');
        return;
    }

    var menu = {
        button: subs
    }

    $.post('/admin/mp/function/menu_save/' + wx_account_id,
        {
            menu: JSON.stringify(menu)
        },
        function (data) {
            if(data.status == 'err'){
                console.log(data.msg);
                return;
            }
            alert('菜单发布成功!');
        }, 'json');
}

//判断菜单项布局
function autoAdjust(action){
    var search, str;
    if($('#menu-item').find('div').length == 2){
        search = action == 1 ? 12 : 4;
        str = action == 1 ? 6 : 6;
    }else if($('#menu-item').find('div').length == 3){
        search = 6;
        str = 4;
    }else if($('#menu-item').find('div').length == 1){
        search = 6;
        str = 12;
    }

    $('#menu-item').find('div:last').prev().addClass('br');
    $('#menu-item').find('div').removeClass('col-xs-' + search);
    $('#menu-item').find('div').addClass('col-xs-' + str);
    $('#submenu-item').find('div').removeClass('col-xs-' + search);
    $('#submenu-item').find('div').addClass('col-xs-' + str);
}