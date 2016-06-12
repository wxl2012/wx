
var _dish_list = [];

$(function () {

    $('input').iCheck({
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('input').on('ifChecked ifUnchecked', function (event) {
        if(event.type == 'ifChecked'){
            var payment = $(this).val() == 'wxpay' ? '微信支付' : '支付宝支付';
            var paymentImg = $(this).val() == 'wxpay' ? '/assets/img/wxpay.png' : '/assets/img/alipay.jpg';
            $('#btnChangePayment').prev().text(payment).prev().attr('src', paymentImg);
            $('#payments').fadeOut();
        }else if(event.type == 'ifUnchecked'){
            
        }
        //if($(this).val()){

        //}
    });

    $('#menuItems').delegate('span[role=minus],span[role=plus]', 'click', function () {
        var input = $(this).parent().find('label');
        if($(this).attr('role') == 'plus'){
            input.text(parseInt(input.text()) + 1);
        }else{
            var num = parseInt(input.text()) - 1;
            input.text(num <= 0 ? 0 : num);
        }

        synBasket();
        reckon();
    });

    $('#btnChangePayment').click(function () {
        $('#payments').fadeIn();
    });
    
    $('#btnPay').click(function () {
        //history.pushState({title: '标题', url: '/wxpay', otherkey: 'test'}, '', '/restaurant/order')

        var dishes = [];

        for (var i = 0;i < _dish_list.length; i ++){
            dishes[dishes.length] = {
                id: _dish_list[i].goods_id,
                num: _dish_list[i].num
            }
        }


        $.post('/api/order/dish/create?access_token=' + _access_token,
            {
                from_id: 1,
                buyer_id: _user_id,
                payment_type: 'wxpay',
                dishes: dishes
            },
            function (data) {
                if(data.status == 'err'){
                    return;
                }
                
                localStorage.removeItem('CHOICE_DISH_LIST')
                history.replaceState(null, '标题', '/wxpay?action=empty');
                wxpay(data.data.id);
            }, 'json');

    });

    setNavbar();

    loadData();

});

/**
 * 读取本地购物车中的数据
 */
function loadData() {

    var list = localStorage.getItem('CHOICE_DISH_LIST');
    _dish_list = JSON.parse(list);

    if(list == null || _dish_list.length < 1){
        $('#menuItems').parents('.list-group').empty().append('<div class="row" style="color: #aaa;">' +
            '<div class="col-xs-12 text-center" style="padding-top: 40px; line-height: 50px; font-size: 60pt;"><i class="fa fa-frown-o"></i></div>' +
            '<div class="col-xs-12 text-center" style="line-height: 50px; font-size: 13pt;">购物车中空空如也!</div>' +
            '</div>');
        $('#btns').hide();
        return;
    }


    for(var i = 0; i < _dish_list.length; i ++){
        $('#menuItems').append(dishItem, _dish_list[i], null);
    }

    reckon();
    synBasket();
}

/**
 * 设置标题栏内容
 */
function setNavbar() {
    $('#navTitle').text('购物车');
    //$('#navRight').html('<a href="/store/finance/cashback_records">明细</a>');
}

/**
 * 设置菜篮子显示的数字
 */
function synBasket() {

    var total_num = 0;

    $('#menuItems label').each(function () {

        total_num += parseInt($(this).text());

        var item = $(this).parents('.row');
        var index = _dish_list.length;

        for(var i = 0; i < _dish_list.length; i ++){
            if(_dish_list[i].goods_id == item.attr('data-id')){
                index = i;
                break;
            }
        }

        if(parseInt($(this).text()) <= 0){
            if(i != _dish_list.length){
                _dish_list.remove(index);
            }
            $(this).parents('.row').remove();
            return;
        }

        _dish_list[index] = {
            goods_id: item.attr('data-id'),
            num: parseInt($(this).text()),
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

/**
 * 计算总金额
 */
function reckon() {

    var list = localStorage.getItem('CHOICE_DISH_LIST');
    if(list == null){
        return;
    }

    _dish_list = JSON.parse(list);

    var total_fee = 0;

    for(var i = 0; i < _dish_list.length; i ++){
        total_fee += _dish_list[i].price * _dish_list[i].num;
    }

    $('#total_fee').text(total_fee.toFixed(2));
}

function wxpay(id) {
    $.get('/wxpay',
        {
            account_id: _account_id,
            openid: _opendid,
            order_id: id
        },
        function (data) {

        }, 'json');
}