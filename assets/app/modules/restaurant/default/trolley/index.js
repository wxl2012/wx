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

    $('#btnChangePayment').click(function () {
        $('#payments').fadeIn();
    });

    setNavbar();

});

function setNavbar() {
    $('#navTitle').text('购物车');
    //$('#navRight').html('<a href="/store/finance/cashback_records">明细</a>');
}