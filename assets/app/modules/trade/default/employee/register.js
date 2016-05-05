$(function () {

    $('#btnSubmit').click(function () {

        var msg = '';

        if($('#first_name').val().length < 1
            || $('#last_name').val().length < 1){
            msg = '姓氏与名字为必填项!';
            $('#first_name').parents('.row').addClass('has-error');
            $('#first_name').parents('.row').find('.help-block').text(msg);
        }

        if(msg != ''){
            return;
        }

        $.post('',
            $('#frmRegister').serialize(),
            function (data) {
                if(data.status == 'err'){
                    $('.alert').addClass('alert-danger').text('注册失败!');
                    return;
                }
                $('.alert').addClass('alert-success').text('注册成功!');
            });
    });

    $('#first_name,#last_name').click(function () {
        $(this).parents('.row').removeClass('has-error');
        $(this).parents('.row').find('.help-block').text('');
    });

});