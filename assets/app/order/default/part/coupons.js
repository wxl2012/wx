$(function(){

    $('#btnGetCoupon').click(function(){
        //根据SN码获取优惠券
    });

    //加载优惠券
    var params = {
        fee: 0,
        category_ids: [0, 1, 2, 3]
    };

    $.post('/api/member/coupons',
        params,
        function (data) {
            if(data.status == 'err'){
                $('#coupons').append('<li class="list-group-item text-center">您没有可用优惠券</li>', null, null);
                return;
            }
            var items = data.data;
            for (var i = 0; i < items.length; i ++){
                items[i].unit = items[i].coupon.type == 'AMOUNT' ? '元' : '折';
                $('#coupons').append(couponItem, items[i], null);
            }
        }, 'json');

});