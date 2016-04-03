$(function(){
    //加载收货地址
    $.get('/api/member/address',
        function (data) {
            if(data.status == 'err'){
                $('#addressItems').append('<li class="list-group-item text-center">您没有收货地址</li>', null, null);
                return;
            }
            var items = data.data;
            for (var i = 0; i < items.length; i ++){
                $('#addressItems').append(addressItem, items[i], null);
            }
            $('#addressItems').append(addNewAddress);
        }, 'json');
});