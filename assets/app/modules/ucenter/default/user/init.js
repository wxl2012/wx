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

        $.post('',
            $('#frmReg').serialize(),
            function (data) {
                if(data.status == 'err'){
                    $('#errorMsg').addClass('text-center');
                    $('#errorMsg').parent().show();
                    $('#errorMsg').text('');
                    $('#errorMsg').append(data.msg);

                    if(data.data != undefined){
                        $('#errorMsg').removeClass('text-center');
                        $('#errorMsg').append('<ul>');
                        for(var i = 0; i < data.data.length; i ++){
                            $('#errorMsg').append('<li>' + data.data[i] + '</li>');
                        }
                        $('#errorMsg').append('</ul>');
                    }
                    return;
                }

                alert('注册成功');
                wx.closeWindow();
            }, 'json');

    });

});