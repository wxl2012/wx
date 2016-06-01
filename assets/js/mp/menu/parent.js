var menuItem = null;
var synFlag = false;
var media_id = 0;
var menu = MPMenuAction

$(function(){

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('#category,#action,#value').click(function(){
        synFlag = false;
    });

    $('#btnAddMenuItem').click(function () {
        syn('addMenu');
    });

    $('#btnRemoveMenuItem').click(function () {
        syn('removeMenu');
    });

    $('#btnPublish').click(function () {
        syn('publish');
    });

    /**
     * 设置动作分类
     */
    $('#category').change(function() {
        cats = menu.subcategories($(this).val());
        addOptionToSelect($('#action'), cats);
        $('#action').val(menuItem.type).trigger('change');

        if(! synFlag){
            syn('', null);
        }
    });

    /**
     * 设置动作
     */
    $('#action,#value').change(function() {
        if(! synFlag) {

            if($(this).attr('id') == 'action'){
                if($(this).val() == 'media_id' || $(this).val() == 'view_limited'){
                    $('#current_menu_content').text('');
                    $('#content-input,table').show();
                    loadMaterials();
                }
            }

            syn('', null);
        }
    });

    /**
     * 初始化动作分类
     */
    var cats = menu.categories();
    addOptionToSelect($('#category'), cats);
});

/**
 * 向select中添加options
 *
 * @param element
 * @param items
 */
function addOptionToSelect(element, items) {
    $(element).empty();
    $(element).append('<option value="0">请选择</option>');
    for(var i = 0; i < items.length; i ++){
        $(element).append('<option value="' + items[i].id + '">' + items[i].title + '</option>');
    }
}

/**
 * 由子窗体调用的方法, 同步当前窗体中的内容
 * @param data
 */
function setMenuInfo(data) {
    synFlag = true;
    menuItem = data;

    //设置当前操作菜单信息
    $('#current_menu_name').text(data.name);
    $('#current_menu_level').text(data.level);
    $('#current_menu_action').text(data.type);
    //设置菜单动作
    $('#select-category').show();
    $('#category').val(data.category).trigger('change');
    $('#content-input,#labelTip,#value,table').hide();

    //设置菜单附带内容
    switch (data.type){
        case 'click':
            $('#current_menu_content').text(data.key);
            $('#value').val(data.key);
            $('#content-input,#labelTip,#value').show();
            break;
        case 'view':
            $('#current_menu_content').text(data.url);
            $('#value').val(data.url);
            $('#content-input,#labelTip,#value').show();
            break;
        case 'media_id':
            $('#current_menu_content').text(data.media_id);
            $('#value').val(data.media_id);
            $('#content-input,table').show();
            loadMaterials();
            break;
        case 'view_limited':
            $('#current_menu_content').text(data.media_id);
            $('#value').val(data.media_id);
            $('#content-input,table').show();
            loadMaterials();
            break;
    }
}

/**
 * 同步子菜单
 */
function syn(action) {
    var cWin = document.getElementById('menu-panel').contentWindow;
    switch (action){
        case 'addMenu':
            cWin.addMenu();
            break;
        case 'removeMenu':
            cWin.removeMenu();
            break;
        case 'publish':
            cWin.publish();
            break;
        default:
            menuItem.category = $('#category').val();
            menuItem.type = $('#action').val();
            if(menuItem.type == 'view'){
                menuItem.url = $('#value').val();
            }else if(menuItem.type == 'click'){
                menuItem.key = $('#value').val();
            }else if(menuItem.type == 'media_id' || menuItem.type == 'view_limited'){
                menuItem.media_id = media_id;
            }

            cWin.setMenuItem(menuItem);
            break;
    }
}

function loadMaterials() {
    $.get('/api/mp/material.json?access_token=' + _access_token + '&id=' + _account_id,
        function (data) {
            if(data.status == 'err'){
                return;
            }
            var items = data.data;
            for(var key in items){
                $('#materials').append(tr, items[key], null);
            }
            $('#pagination').html(data.pagination);
            $('#materials input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $('#materials input[name=media_id]').on('ifChecked', function(event){
                media_id = $(this).val();
                syn('');
            });
        }, 'json');
}