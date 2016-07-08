var loading = false;

$(function () {

    $('#btnAdd').click(function () {
        if($('tbody tr').length <= 1){
            if($('tbody tr td').find('.empty').length > 0){
                $('tbody').empty();
            }
        }
        $('tbody').append(tr, {}, null);
    });
    
    $('#btnSyn').click(function () {
        if(loading){
            return;
        }
        loading = true;

        var i = $(this).find('i');
        i.addClass('fa-spin');
        $.post('/admin/marketing/vote/syn_redis',
            function (data) {
                i.removeClass('fa-spin');
                if(data.status == 'err'){
                    return;
                }
            }, 'json');
    });

    $('tbody').delegate('a[role=btnSave]', 'click', function () {
        var tr = $(this).parents('tr');
        var a = $(this);
        a.text('处理中...').addClass('disable');
        $.post('/admin/marketing/vote/save/' + tr.attr('data-id'),
            {
                title: $(tr).find('input[name=title]').val(),
                start_at: $(tr).find('input[name=begin_at]').val(),
                end_at: $(tr).find('input[name=end_at]').val(),
                status: $(tr).find('select').val()
            },
            function (data) {
                a.text('保存').removeClass('disable');
                if(data.status == 'err'){
                    $(tr).find('input').css('color', '#d9534f');
                    return;
                }
                if($(tr).attr('data-id') == 0){
                    $(a).parent().append('<a class="btn btn-sm btn-primary" href="/admin/marketing/vote/candidates/' + data.data.id + '">管理被投项目</a>');
                }
                $(tr).find('input').css('color', '#5cb85c');
                $(tr).attr('data-id', data.data.id);
            }, 'json');
    });

    $('tbody').delegate('a[role=btnDel]', 'click', function () {
        var tr = $(this).parents('tr');

        if(tr.attr('data-id') == 0){
            $(tr).remove();
            return;
        }
        var a = $(this);
        a.text('处理中...').addClass('disable');
        $.post('/admin/marketing/vote/candidate_delete/' + tr.attr('data-id'),
            function (data) {
                if(data.status == 'err'){
                    return;
                }
                $(tr).remove();
            }, 'json');
    });

});