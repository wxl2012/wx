$(function () {

    $('.alert').click(function () {
        $('.alert').css('border', '1px solid #eed3d7');
        $(this).css('border', '5px solid #000');

        _bank_id = $(this).attr('data-id');
        _bank = $(this).attr('data-json');
    });
    
    $('#btnChoice').click(function () {
        if(_bank_id == 0){
            show('请选择收款方式');
            return;
        }

        localStorage.setItem('new_account', _bank);
        window.history.back();
    });
});

function show(text) {
    var notification = new NotificationFx({
        message: '<p>' + text + '</p>',
        layout: 'growl',
        effect : 'genie',
        type: 'warning',
        ttl: 60000,
        onClose: function () {

        }
    });

    notification.show();
}