$(function () {

    $('#btnSubmit').click(function () {
        var msg = '';
        if( ! /^-?\d+$|^(-?\d+)(\.\d+)?$/.test($('#money').val())){
            msg = '提现金额必须是数字';
        }else if(parseFloat($('#money').val()) > _balance){
            msg = '提现金额不能大于可用金额';
        }else if(parseFloat($('#money').val()) < 100){
            msg = '提现金额不能低于100元';
        }else if(_account_id <= 0){
            msg = '请选择提现方式';
        }

        if(msg != ''){
            $('#errorMsg').parent().show();
            $('#errorMsg').text(msg);
            return;
        }

        $.post('',
            {
                'money': $('#money').val(),
                'account_id': _account_id
            },
            function (data) {
                if(data.status == 'err'){
                    alert(data.msg);
                    return;
                }

                alert('申请已提交,请耐心等待!');

                if(typeof(wx)!= 'undefined'){
                    wx.closeWindow();
                }else{
                    window.close();
                }

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

    setBank();

});

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