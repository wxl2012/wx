$(function () {

    $('#btnBid').click(function () {
        $('.input-panel').fadeIn();
    });

    $('#btnClose').click(function () {
        $('.input-panel').fadeOut();
    });

    $('#btnSubmit').click(function () {

        var msg = '';

        if(isNaN($('#price').val()) || $('#price').val().length < 1){
            msg = '请输入您的出价金额';
        }else if(parseFloat($('#price').val()) <= _max_price){
            msg = '出价金额必须大于领先价格';
        }else if(parseFloat($('#price').val()) - _max_price < _range){
            msg = '每次加价幅度最少' + _range + '元';
        }

        if(msg != ''){
            $('#help-panel').fadeIn().find('.help-block').text(msg);
            setTimeout(function () {
                $('#help-panel').fadeOut();
            }, 3000);
            return;
        }
        $.post('/auction/lot/bid/' + _id,
            {
                bid: $('#price').val()
            },
            function (data) {
                if(data.status == 'err'){
                    alert(data.msg);
                    return;
                }

                alert('出价成功');
            }, 'json');
    });
});