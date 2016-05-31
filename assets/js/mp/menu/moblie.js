
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
    if(current_menu == undefined){
        alert('请先选择需要删除的菜单项!');
        return;
    }
    if(current_menu.parent().is('li')){
        current_menu.val('').attr('data', '');
    }
    if(current_menu.parent().is('div')){
        var count = current_menu.parent().parent().find('div').length;
        if(count < 2){
            alert('至少保留1项菜单项,如果不想使用自定义菜单请点“关闭自定义菜单”。');
            return;
        }

        var id = current_menu.parent().attr('id');
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
    console.log('发布菜单');
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