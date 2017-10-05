$(function () {
    $('.categoryOne').on('click', function () {
        window.location.href = '/product/detail/' + $(this).attr('productId');
    });
});