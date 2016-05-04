$(function(){

    $('#btnPay').click(function(){
        if($('#txtFee').val().length < 1){
            $('#txtFee').parent().addClass('has-error');
            $('#txtFee').next().text('请填写付款金额');
        }else if(isNaN($('#txtFee').val())){
            $('#txtFee').parent().addClass('has-error');
            $('#txtFee').next().text('付款金额必须是数字');
        }
        if($('#txtRemark').val().length < 1){
            $('#txtRemark').parent().addClass('has-error');
            $('#txtRemark').next().text('请填写备注');
        }

        $.post('',
            {
                total_fee: $('#txtFee').val(),
                remark: $('#txtRemark').val()
            },
            function (data) {
                if(data.status == 'err'){
                    alert('发起付款失败');
                    return;
                }
                $('#imgQrcode').attr('src', '/common/qrcode/generate?content=trade/seller/create?id=' + data.key);
                $('#txtFee,#txtRemark,#btnPay').hide();
                $('#btnCancelPay').show();
            }, 'json');
        //$('.input-panel').hide();
    });

    $('#txtFee,#txtRemark').click(function(){
        $(this).parent().removeClass('has-error');
        $(this).next().text('');
    });

    $('#btnCancelPay').click(function(){
        $.post('',
            {
                total_fee: $('#txtFee').val(),
                remark: $('#txtRemark').val()
            },
            function (data) {
                if(data.status == 'err'){
                    alert('发起付款失败');
                    return;
                }
                $('#imgQrcode').attr('src', _base_url + '/common/qrcode/generate?content=trade/seller/create?id=' + data.key);
                $('#txtFee,#txtRemark,#btnPay').hide();
                $('#btnCancelPay').show();
            }, 'json');
    });
});