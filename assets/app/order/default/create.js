$(function(){

    $('#btnPay').click(function(){
        $('#btnPay').addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> 处理中...');
        if( ! checkData()){
            return;
        }

        var params = {
            order_name: _order_name,
            order_body: _order_body,
            order_url: '',
            payment_id: $('#payment').val(),
            total_fee: _total_fee,
            original_fee: _original_fee,
            preferential_fee: _preferential_fee,
            order_status: 'WAI_PAYMENT',
            order_type: _order_type,
            preferential:[
                {
                    coupon_id: 1,   //优惠券ID
                    fee: 10,        //抵价
                    value: 0,       //优惠券折扣值或者减免值
                }
            ],
            transport:{
                address_id: _address_id,
            },
            details : [

            ]
        };

        $.post('',
            params,
            function (data) {
                if(data.status == 'err'){
                    return;
                }

                console.log('是否需要支付,或者使用某种支付方式!');
            }, 'json');

    });
});

function checkData() {
    var flag = false;

    return flag;
}