var loading = false;

$(function () {

    $('#btnSyn').click(function () {

        if(loading){
            return;
        }
        loading = true;

        $('#btnSyn').find('i').addClass('fa-spin');
        $.get('/admin/mp/material/syn',
            {
                account_id: $('#account_id').val()
            },
            function (data) {

                $('#btnSyn').find('i').removeClass('fa-spin');
                loading = false;
                if(data.status == 'err'){
                    alert(data.msg);
                    return false;
                }

                alert('同步完成');
                window.location.reload();
            });

    });

    $('td select').change(function(){
        var tr = $(this).parents('tr');
        $.post('/admin/mp/material/bind_menu',
            {
                id: $(tr).attr('data-id'),
                menu: $(this).val()
            },
            function (data) {
                if(data.status == 'err'){
                    $(tr).css('color', '#d9534f');
                    return;
                }
                $(tr).css('color', '#5cb85c');
            }, 'json');
    });

});