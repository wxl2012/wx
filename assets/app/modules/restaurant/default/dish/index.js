$(function () {

    $('#btnMore').click(function () {
        if(_pageIndex > _totalPage){
            $('#btnMore').text('已经没有下一页了');
            return;
        }

        loadData();
    });

    $('#dishItems').delegate('.input-group-addon', 'click', function () {
        var input = $(this).parents('.input-group').find('input');
        if($(this).attr('role') == 'plus'){
            input.val(parseInt(input.val()) + 1);
        }else{
            var num = parseInt(input.val()) - 1;
            input.val(num <= 0 ? 0 : num);
        }

        synBasket();
    });


    $('input[role=number]').change(function () {
        synBasket();
    });


    setNavbar();

    //initBasket(); 移至列表数据加载完后调用

    //synBasket();

    loadData();
});

function setNavbar() {
    $('#navTitle').text('菜单');
    //$('#navRight').html('<a href="/store/finance/cashback_records">明细</a>');
}

function initBasket() {

    var list = localStorage.getItem('CHOICE_DISH_LIST');
    if(list == null){
        return;
    }

    _dish_list = JSON.parse(list);
    $('input[role=number]').each(function () {

        for(var i = 0; i < _dish_list.length; i ++){
            if(_dish_list[i].goods_id == $(this).parents('.list-group-item').attr('data-id')){
                $(this).val(_dish_list[i].num);
                break;
            }
        }
    });

    synBasket();
}

function loadData() {
    var params = '&start=' + _pageIndex;
    $.get('/api/dish/list.json?access_token=' + _access_token + params,
        function (data) {
            $('#btnMore').text('点击加载更多');
            if(data.status == 'err'){
                return;
            }

            _totalPage = data.total_page;
            _pageIndex = parseInt(data.current_page) + 1;

            var items = data.data;
            for (var key in items){
                $('#dishItems').append(dishItem, items[key], null);
            }

            initBasket();

        });
}

function synBasket() {

    var total_num = 0;

    $('input[role=number]').each(function () {

        total_num += parseInt($(this).val());

        var item = $(this).parents('.list-group-item');
        var index = _dish_list.length;

        for(var i = 0; i < _dish_list.length; i ++){
            if(_dish_list[i].goods_id == item.attr('data-id')){
                index = i;
                break;
            }
        }

        if(parseInt($(this).val()) <= 0){
            if(i != _dish_list.length){
                _dish_list.remove(index);
            }
            return;
        }

        _dish_list[index] = {
            goods_id: item.attr('data-id'),
            num: parseInt($(this).val()),
            name: item.attr('data-name'),
            price: parseFloat(item.attr('data-price'))
        };
    });

    var json = JSON.stringify(_dish_list);
    localStorage.setItem('CHOICE_DISH_LIST', json);

    $('#cartGoodsNum').text(total_num);

    if(parseInt($('#cartGoodsNum').text()) < 1){
        $('#cartGoodsNum').hide();
    }else{
        $('#cartGoodsNum').show();
    }
}