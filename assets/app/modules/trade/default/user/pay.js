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

        //$('.input-panel').hide();
    });

    $('#txtFee,#txtRemark').click(function(){
        $(this).parent().removeClass('has-error');
        $(this).next().text('');
    });
});