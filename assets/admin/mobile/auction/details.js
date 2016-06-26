$(function () {
    $('#btnEnd').click(function () {

        $.post('/admin/auction/lot/end/' + _id,
            function (data) {
                if(data.status == 'err'){
                    alert(data.msg);
                    return;
                }

                alert('成功');
            }, 'json');
    });
});