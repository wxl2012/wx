$(function () {

    var params = {
        access_token: _access_token,
        ids: _ids
    };

    $.get('/api/trolley.json',
        params,
        function (data) {
            if(data.status == 'err'){
                return;
            }

            $('#goodsBody').empty();

            var index = 0;
            var total_num = 0;
            var total_fee = 0;

            var items = data.data;
            if(items instanceof Array){
                $('#goodsFooter').hide();
                $('#goodsBody').append('<li class="list-group-item text-center">未找到商品数据</li>');
                return;
            }
            for (var key in items){
                if(index < 1) {
                    $('#goodsFirst').append(goodsItem, items[key], null);
                }else{
                    $('#goodsBody').append(goodsItem, items[key], null);
                }

                _order_name += items[key].goods.name + '、';
                _order_body += items[key].goods.name + '(' + items[key].num + ')、';
                total_fee += items[key].price * items[key].num;
                total_num += items[key].num;
                index ++;
            }

            _order_name = _order_name.substring(0, _order_name.length - 1);
            _order_body = _order_body.substring(0, _order_body.length - 1);

            $('.bill-field:first').find('em:first').text(total_num);
            $('.bill-field:first').find('em:last').text(total_fee);
            _total_fee = total_fee;
            $('#totalFee').text(total_fee);
            statement();

            if($('#goodsItems').find('li').length > 2){
                $('#goodsFooter').find('.pull-right').show();

                $('#goodsBody').find('li:first').css('border-top-width', '0px');
                $('#goodsBody').slideToggle();
            }

        }, 'json');
    
    $('#goodsItems').delegate('#btnGoodsMore', 'click', function () {

        $('#goodsBody').slideToggle(function () {
            var text = $('#goodsFooter').find('.pull-right').text();
            $('#goodsFooter').find('.pull-right').text(text == '查看更多' ? '收起' : '查看更多');
        });
    })
});