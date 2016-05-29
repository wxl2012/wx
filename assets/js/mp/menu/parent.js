var _category_value = 0;
var _action_value = 0;
var _value = '';

var menu = MPMenuAction

$(function(){

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('#btnAddMenuItem').click(function () {
        syn('addMenu', null);
    });

    $('#btnRemoveMenuItem').click(function () {
        syn('removeMenu', null);
    });

    $('#btnPublish').click(function () {
        syn('publish', null);
    });

    /**
     * 设置动作分类
     */
    $('#category').change(function() {
        cats = menu.subcategories($(this).val());
        addOptionToSelect($('#action'), cats);
        $('#action').trigger('change');
        syn();
    });

    /**
     * 设置动作
     */
    $('#action').change(function() {
        setContent($('#category').val(), $(this).val(), _value);
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
    _category_value = data.category;
    _action_value = data.action;
    _value = data.content;

    $('#current_menu_name').text(data.name);
    $('#current_menu_level').text(data.level);
    $('#current_menu_content').text(data.content);
    $('#current_menu_action').text(menu.showPath(_category_value, _action_value));

    if(_category_value == undefined){
        _category_value = _action_value = 0;
        _value = '';
    }

    $('#select-category').show();
    setSelectValue($('#category'), _category_value);
    $('#category').trigger('change');
    setSelectValue($('#action'), _action_value);
    $('#action').trigger('change');

    if(_category_value == 1){
        _value = data.url != undefined ? data.url : data.key;
    }else if(_category_value == 3){
        _value = data.media_id;
    }
    setContent(_category_value, _action_value, _value);
}

/**
 * 设置select中的默认值
 *
 * @param element
 * @param value
 */
function setSelectValue(element, value) {
    if(value.length < 1){
        return;
    }
    $(element).val(value);
}

/**
 * 设置内容项的操作
 *
 * @param category  动作分类
 * @param action    动作
 * @param value     对应值
 */
function setContent(category, action, value) {
    if(category == 2){
        $('#content-input').hide();
        return;
    }

    $('#content-input').show();
    $('#labelTip,#value,table').hide();

    if(category == 1){
        $('#labelTip,#value').show();
        switch (parseInt(action)){
            case 1:
                $('#labelTip').text('关键字：');
                $('#value').attr('type', 'text');
                break;
            case 2:
                $('#labelTip').text('网址：');
                $('#value').attr('type', 'url');
                break;
        }

        $('#value').val(value);
    }else if(category == 3){
        $('table').show();
    }
}

/**
 * 同步子菜单
 */
function syn(action, data) {
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
            var data = {
                category: $('#category').val(),
                action: $('#action').val(),
                value: ''
            };
            cWin.setMenuItem(data);
            break;
    }
    //cWin.addMenuItem('')
}