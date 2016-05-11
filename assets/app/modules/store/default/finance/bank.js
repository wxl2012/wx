$(function () {

    $('#payment_type').change(function () {
        $('.list-group-item,#btnBindWechat').hide();
        $('.list-group-item:eq(0),#btnSave').show();

        if($(this).val() == '1'){
            $('#labAccount').parents('li').css('display', 'block');
            $('#labName').parents('li').css('display', 'block');
            $('#labAccount').next().find('input').attr('placeholder', '手机号或邮箱地址');
            $('#labName').text('姓名');
            $('#labName').next().find('input').attr('placeholder', '真实姓名');
        }else if($(this).val() == 'bank'){
            $('#labBanks,#labBank').css('display', 'block');
            $('#labAccount').parents('li').css('display', 'block');
            $('#labName').parents('li').css('display', 'block');

            $('#labAccount').next().find('input').attr('placeholder', '银行卡号');
            $('#labName').text('户名');
            $('#labName').next().find('input').attr('placeholder', '开户人姓名');
        }else if($(this).val() == '2'){
            $('#btnBindWechat').show();
            $('#btnSave').hide();
        }
    });

    $('#btnSave').click(function () {
        var _phoneReg = /((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)|(^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57]|170)[0-9]{8}$)/;
        var _emailReg = /^([a-zA-Z0-9_\.\-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        var msg = '';
        if($('#bank_name').val().length < 1 && $('#payment_type').val() == 'bank'){
            msg = '请填写开户行';
        }else if($('#account_name').val().length < 1){
            msg = '请填户名';
        }else if($('#account').val().length < 1){
            msg = '请填写账号!';
        }else if($('#payment_type').val() == 'alipay'){
            if( ! (_emailReg.test($('#account').val()) || _phoneReg.test($('#account').val()))){
                msg = '请输入合法的支付宝帐户!';
            }
        }

        if(msg != ''){
            $('#errorMsg').parent().show();
            $('#errorMsg').removeClass('alert-success').addClass('alert-danger').text(msg);
            return;
        }

        $.post('',
            $('#frmBank').serialize(),
            function (data) {
                if(data.status == 'err'){
                    $('#errorMsg').parent().show();
                    $('#errorMsg').removeClass('alert-success').addClass('alert-danger').text(data.msg);
                    return;
                }

                localStorage.setItem('new_account', JSON.stringify(data.data));
                $('#errorMsg').parent().show();
                $('#errorMsg').removeClass('alert-danger').addClass('alert-success').text('添加成功');
                window.history.back();

            }, 'json');
    });

    $('#btnBindWechat').click(function () {

    });
    
});