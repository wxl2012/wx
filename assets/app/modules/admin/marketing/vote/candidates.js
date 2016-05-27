
$(function() {

    $('#btnAdd').click(function () {
        if($('tbody tr').length <= 1){
            if($('tbody tr td').find('.empty').length > 0){
                $('tbody').empty();
            }
        }
        $('tbody').append(tr, {}, null);
    });

    $('tbody').delegate('a[role=btnSave]', 'click', function () {
        var tr = $(this).parents('tr');
        var a = $(this);
        a.text('处理中...').addClass('disable');
        $.post('',
            {
                id: tr.attr('data-id'),
                no: $(tr).find('input[role=no]').val(),
                keyword: $(tr).find('input[role=keyword]').val(),
                title: $(tr).find('input[role=title]').val(),
                total_gain: $(tr).find('input[role=total_gain]').val(),
                marketing_id: marketing_id
            },
            function (data) {
                a.text('保存').removeClass('disable');
                if(data.status == 'err'){
                    $(tr).find('input').css('color', '#d9534f');
                    return;
                }
                $(tr).find('input').css('color', '#5cb85c');
                $(tr).attr('data-id', data.data.id);
            }, 'json');
    });
});