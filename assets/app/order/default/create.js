$(function(){

    $('#btnPay').click(function(){

        if( ! checkData()){
            return;
        }

        var params = {
            order_name: _order_name,
            order_body: _order_body,
            order_url: '',
            payment_id: _payment_id,
            total_fee: _total_fee,
            original_fee: _original_fee,
            preferential_fee: _preferential_fee,
            order_status: 'WAI_PAYMENT',
            order_type: _order_type,
            preferential: _preferential,
            address_id: _address_id,
            details : _ids,
            remark: $('#remark').val()
        };

        console.log(JSON.stringify(params));return;
        $('#btnPay').addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> 处理中...');
        $.post('',
            params,
            function (data) {
                if(data.status == 'err'){
                    return;
                }

                if(_original_fee <= 0){
                    console.log('无需支付,直接进入订单列表页.');
                    return;
                }
                console.log('是否需要支付,或者使用某种支付方式!');
            }, 'json');

    });

    $('#btnOpenBill').click(function(){
        $('#bill').slideToggle();
    });

    $('#bill').slideToggle();
});

function checkData() {
    var flag = true;
    if($('input[name=payment_id]').val() == ''){
        flag = false;
    }
    return flag;
}

function statement() {

    var real = parseFloat($('#totalFee').text()) - parseFloat($('#giftFee').text())
        - parseFloat($('#couponFee').text()) - parseFloat($('#scoreFee').text());

    real = Math.round(real * 100) / 100;
    $('#originalFee').text(real);
    $('#originalMoney').text(real);
}