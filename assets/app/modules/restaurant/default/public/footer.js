$(function () {

    $('.menu-item').click(function () {
        console.log($(this).attr('role'));
    });

    $('.input-group-addon').click(function () {
        var input = $(this).parents('.input-group').find('input');
        if($(this).attr('role') == 'plus'){
            input.val(parseInt(input.val()) + 1);
        }else{
            var num = parseInt(input.val()) - 1;
            input.val(num <= 0 ? 0 : num);
        }


    });
});