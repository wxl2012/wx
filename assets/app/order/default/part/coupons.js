$(function(){

    $('#btnGetCoupon').click(function(){
        //根据SN码获取优惠券
    });

    $('#btnCheck').click(function () {
        var row = $(this).parents('.row');
        var no = $(row).find('input[name=no]').val();
        var pwd = $(row).find('input[name=pwd]').val();

        var msg = '';
        if(no.length < 1){
            msg = '优惠码不能为空!';
        }else if(pwd.length < 1){
            msg = '验证码不能为空!';
        }

        if(msg != ''){
            alert(msg);
            return;
        }

        $.post('/api/coupon/check_sn.json?access_token=' + _access_token,
            {
                no: no,
                pwd: pwd
            },
            function (data) {

                if(data.status == 'err'){
                    return;
                }

                $(row).find('input[name=no]').val('');
                $(row).find('input[name=pwd]').val('');

                var flag = false;
                $('#couponSn').find('input[name=coupon_id]').each(function(index, element){
                    if($(element).val() == data.data.id){
                        flag = true;
                        return;
                    }
                });

                if( ! flag){
                    $('#couponSn').prepend(couponSnItem, data.data, null);
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_flat-orange',
                        radioClass: 'icheckbox_flat-orange'
                    });

                    $('input[name="coupon_id"]').on('ifChanged', function (event) {
                        var isAdd = true;
                        for(var i = 0; i < _preferential.length; i ++){
                            if(_preferential[i].id == this.value){
                                if($(this).is(':checked')){
                                    isAdd = false;
                                    break;
                                }else{
                                    $('#couponFee').text(parseFloat($('#couponFee').text()) - _preferential[i].fee);
                                    statement();
                                    _preferential.remove(i);
                                    return;
                                }
                            }
                        }

                        if(isAdd){
                            var fee = $(this).attr('data-type') == 'AMOUNT' ? parseFloat($(this).attr('data-value')) : parseFloat($('#totalFee').text()) * parseFloat($(this).attr('data-value')) / 100;
                            _preferential[_preferential.length] = {
                                id: this.value,
                                type: $(this).attr('data-type'),
                                value: $(this).attr('data-value'),
                                fee: fee
                            };
                            $('#couponFee').text(parseFloat($('#couponFee').text()) + fee);
                            statement();
                        }

                    });

                }
            }, 'json');

    });

    //加载优惠券
    var params = {
        fee: 0,
        category_ids: [0, 1, 2, 3]
    };

    $.post('/api/member/coupons?access_token=' + _access_token,
        params,
        function (data) {
            if(data.status == 'err'){
                $('#coupons').append('<li class="list-group-item text-center">' + data.msg + '</li>');
                return;
            }

            $('#coupons').empty();

            var items = data.data;
            if(items instanceof Array){
                $('#coupons').append('<li class="list-group-item text-center">您没有可用优惠券</li>');
                return;
            }

            for(var key in items){
                items[key].unit = items[key].coupon.type == 'AMOUNT' ? '元' : '折';
                $('#coupons').append(couponItem, items[key], null);
            }
        }, 'json');

});