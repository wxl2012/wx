$(function(){
    //加载收货地址
    $.get('/api/member/address.json?access_token=' + _access_token,
        function (data) {

            $('#addressItems').empty();

            if(data.status == 'err'){
                $('#addressItems').append('<li class="list-group-item text-center">' + data.msg + '</li>');
                return;
            }

            var items = data.data;
            if(items.length < 1){
                $('#addressItems').append('<li class="list-group-item text-center">您没有收货地址</li>');
            }else{
                for(var key in items){
                    $('#addressItems').append(addressItem, items[key], null);
                }

                $('input[name="address_id"]:first').click();
                _address_id = $('input[name="address_id"]:first').val();

                $('input[name="address_id"]').on('ifChanged', function (event) {
                    _address_id = this.value;
                });

            }
            $('#addressItems').append(addNewAddress, {}, null);
        }, 'json');


    $('#btnSaveAddress').click(function(){

        $.post('/api/member/address_save?access_token=' + _access_token,
            $('#frmAddressDetail').serialize(),
            function (data) {
                if(data.status == 'err'){
                    return;
                }

                $('#addressItems').prepend(addressItem, data.data, null);
            }, 'json');
    });
    
    $('#province_id,#city_id,#county_id').change(function () {
        if($(this).attr('id') == 'province_id'){
            $('#county_id').css('display', 'none');
        }
        loadRegion($(this).val(), $(this).next());
    });

    loadRegion(1, $('#province_id'));
});

function loadRegion(id, element) {
    $.get('/api/common/region.json',
        {
            id: id,
            access_token: _access_token
        },
        function (data) {

            if(data.status == 'err'){
                return;
            }

            var flag = false;

            $(element).empty();

            var items = data.data;
            $(element).append('<option value="0">请选择</option>');
            for(var key in items){
                $(element).append('<option value="' + items[key].id + '">' + items[key].name + '</option>');
                flag = true;
            }

            if(flag){
                $(element).css('display', 'inline');
            }else{
                $(element).css('display', 'none');
            }

        }, 'json');
}