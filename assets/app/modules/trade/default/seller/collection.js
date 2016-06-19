$(function () {

    $('#btnSubmit').click(function () {

        $('#errorMsg').hide();

        var msg = '';
        if($('#payment').val() == ''){
            msg = '请填写收款金额';
            $('#payment').parent().addClass('has-error');
        }else if(isNaN($('#total_fee').val()) || $('#total_fee').val().length < 1){
            msg = '付款金额必须是数字';
            $('#total_fee').parent().addClass('has-error');
        }

        if(msg){
            $('#errorMsg').show().addClass('alert-danger').text(msg);
            return;
        }

        $.post('',
            $('#frmCollection').serialize(),
            function (data) {
                if(data.status == 'err'){
                    $('#errorMsg').show().addClass('alert-danger').text(msg);
                    return;
                }

                if($('#payment').val() == 'wxpay'){
                    wxpay();
                }else if($('#payment').val() == 'score'){
                    $('#imgQrcode').attr('src', '/common/qrcode/generate?content=' + _base_url + 'trade/user/create?id=' + data.key);
                }

                $('#payment,#total_fee,#remark,#btnSubmit').hide();
                $('#btnCancel').show();
                
            }, 'json');
    });
    
    $('#btnCancel').click(function () {
        window.location.reload();
    });
});


function wxpay() {
    $.get('/wxpay/wxpay_qrcode?goods_id=1',
        function (data) {
            if(data.status == 'err'){
                return;
            }

            $('#imgQrcode').attr('src', '/common/qrcode/generate?content=' + data.data);

        }, 'json');

}