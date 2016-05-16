$(function () {

    $('.menu-item').click(function () {
        window.location.href = $(this).attr('action');
    });
});