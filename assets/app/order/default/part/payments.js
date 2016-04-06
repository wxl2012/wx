$(function () {

    $.get('/api/seller/payments',
        {
            access_token: _access_token,
        },
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

            $('input[name="payment_id"]:first').click();
            _payment_id = $('input[name="payment_id"]:first').val();

            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-orange',
                radioClass: 'icheckbox_flat-orange'
            });

            $('input[name="payment_id"]').on('ifClicked', function (event) {
                _payment_id = this.value;
            });

        }, 'json');

});