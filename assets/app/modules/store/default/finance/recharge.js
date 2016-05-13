$(function () {

    $('#btnSubmit').click(function () {
        var msg = '';
        if( ! /^-?\d+$|^(-?\d+)(\.\d+)?$/.test($('#money').val())){
            msg = '提现金额必须是数字';
        }

        if(msg != ''){
            $('#errorMsg').text(msg).parent().show();
            return;
        }

        $('#errorMsg').parent().hide();

        $(this).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> 处理中...');

        $.post('',
            {
                'money': $('#money').val(),
                'payment': $('#payment').val()
            },
            function (data) {
                if(data.status == 'err'){
                    $('#errorMsg').text(data.msg).parent().show();
                    return;
                }
                if($('#payment').val() == 'wxpay'){
                    alert('调用微信支付');
                }else{
                    alert('调用支付宝支付');
                }

                $('#btnSubmit').removeClass('disabled').html('充值');
            }, 'json');
    });

    //读取默认收款方式
    $.get('',
        function (data) {
            if(data.status == 'err'){
                return;
            }
            alert(data.msg);
        }, 'json');

    setNavbar();

    setBank();

});

function setNavbar() {
    $('#navTitle').text('充值');
    $('#navRight').html('<a href="/store/finance/cashback_records">明细</a>');
}

function setBank() {
    //是否新增
    var account = localStorage.getItem('new_account');
    if(account != undefined){
        account = JSON.parse(account);
        var text = '';
        if(isEmail(account.account)){
            var index = account.account.indexOf('@');
            var last = account.account.substring(index);
            var name = index > 2 ? account.account.substring(0, 2) : '###';
            text = '使用' + account.bank.name + '(' + name + '****' + last + ')收款 <a href="/ucenter/finance/banks">更换</a>';
        }else if(isPhone(account.account)){
            text = '使用' + account.bank.name + '(' + account.account.substring(7) + ')收款 <a href="/ucenter/finance/banks">更换</a>';
        }
        $('#bank').html(text);
        localStorage.removeItem('new_account');
    }
}