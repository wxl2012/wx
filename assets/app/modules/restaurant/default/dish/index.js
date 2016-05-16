$(function () {


    $('.input-group-addon').click(function () {
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

    initBasket();

    synBasket();
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
}

function synBasket() {

    var total_num = 0;

    $('input[role=number]').each(function () {

        total_num += parseInt($(this).val());

        var flag = false;
        for(var i = 0; i < _dish_list.length; i ++){
            if(_dish_list[i].goods_id == $(this).parents('.list-group-item').attr('data-id')){
                _dish_list[i].num = parseInt($(this).val());
                flag = true;
                break;
            }
        }

        if(flag || parseInt($(this).val()) <= 0){
            return;
        }

        _dish_list[_dish_list.length] = {
            goods_id: $(this).parents('.list-group-item').attr('data-id'),
            num: parseInt($(this).val())
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