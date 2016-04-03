$(function () {

    if(typeof(_access_token) == 'undefined'){
        _access_token = 'abcdeft';
    }

    $.get('/api/seller/payments?access_token=' + _access_token,
        function (data) {
            if(data.status == 'err'){
                $('#payment').append('<li class="list-group-item text-center">商家没有开通支付功能!</li>');
                return;
            }
            var items = data.data;
            $('#payment').empty();
            for (var i = 0; i < items.length; i ++){
                $('#payment').append(paymentItem, items[i], null);
            }

            $('#payment').find('input:first').click();

            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-orange',
                radioClass: 'icheckbox_flat-orange'
            });
        }, 'json');

});