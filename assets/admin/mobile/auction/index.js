$(function () {
    $('.navbar .list-group .list-group-item').click(function () {
        $('.navbar .active').removeClass('active');
        $(this).addClass('active');
    });
});