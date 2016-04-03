$(function () {

    $.get('/api/trolley.json',
        {
            ids: _ids
        },
        function (data) {
            if(data.status == 'err'){
                return;
            }

            $('#goodsBody').empty();

            var index = 0;
            var total_num = 0;
            var total_fee = 0;

            var items = data.data;
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

            $('#goodsFooter').find('em:first').text(total_num);
            $('#goodsFooter').find('em:last').text(total_fee);

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