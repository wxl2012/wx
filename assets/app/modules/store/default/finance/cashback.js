$(function () {

    $('#btnSubmit').click(function () {
        var msg = '';
        if( ! /^-?\d+$|^(-?\d+)(\.\d+)?$/.test($('#money').val())){
            msg = '提现金额必须是数字';
        }else if(parseFloat($('#money').val()) > _balance){
            msg = '提现金额不能大于可用金额';
        }else if(parseFloat($('#money').val()) < 100){
            msg = '提现金额不能大于可用金额';
        }else if(_account_id <= 0){
            msg = '请选择提现方式';
        }
        console.log(msg);
        if(msg != ''){
            $('#errorMsg').parent().show();
            $('#errorMsg').text(msg);
            return;
        }

        alert('提交');
    });

});