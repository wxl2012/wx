$(function () {

    $('#payment_type').change(function () {
        $('.list-group-item,#btnBindWechat').hide();
        $('.list-group-item:eq(0),#btnSave').show();

        if($(this).val() == 'alipay'){
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
        }else if($(this).val() == 'wxpay'){
            $('#btnBindWechat').show();
            $('#btnSave').hide();
        }
    });
    
});