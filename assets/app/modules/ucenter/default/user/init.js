$(function () {

    $('#btnSubmit').click(function () {

        var msg = '';
        if($('#first_name').val().length < 1
            || $('#last_name').val().length < 1){
            msg = '请填写姓名';
            //$('#first_name').parent().addClass('has-error');
        }else if($('#username').val().length < 1){
            msg = '请填写用户名';
            //$('#username').parents('.row').addClass('has-error');
        }else if($('#password').val().length < 1){
            msg = '请填写密码';
        }else if($('#birthday').val().length < 1){
            msg = '请填写生日';
        }else if($('#phone').val().length < 1){
            msg = '请填写手机号码';
        }

        if(msg != ''){
            $('#errorMsg').parent().show();
            $('#errorMsg').text(msg);
            return;
        }

    });

});