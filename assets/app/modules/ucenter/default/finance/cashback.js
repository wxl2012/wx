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
            show(msg, '');
            return;
        }

        $.post('/api/user/cashback_apply.json?seller_id=' + _seller_id + '&access_token=' + _access_token,
            {
                'money': $('#money').val(),
                'account_id': _account_id
            },
            function (data) {
                if(data.status == 'err'){
                    show(data.msg, '');
                    return;
                }
                show('申请已提交,请耐心等待审核!', 'notice');

                if(typeof(wx)!= 'undefined'){
                    wx.closeWindow();
                }else{
                    window.close();
                }

            }, 'json');
    });

    initBank();
});

function initBank() {
    var account = localStorage.getItem('new_account');
    if(account != undefined){
        setBank(JSON.parse(account));
        return;
    }

    $.get('/api/user/bank_default.json?access_token=' + _access_token,
        function (data) {
            if(data.status == 'err'){
                return;
            }
            _account_id = data.data.id;
            setBank(data.data);
        }, 'json');
}

function setBank(account) {
    _account_id = account.id;
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
}

function show(text, type) {
    var notification = new NotificationFx({
        message: '<p>' + text + '</p>',
        layout: 'growl',
        effect : 'genie',
        type: type == '' ? 'warning' : type,
        ttl: 3000,
        onClose: function () {

        }
    });

    notification.show();
}