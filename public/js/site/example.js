$(function () {
    $('.categoryOne').on('click', function () {
        window.location.href = '/example/detail/' + $(this).attr('exampleId');
    });
});