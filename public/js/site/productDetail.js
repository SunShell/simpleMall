$(function () {
    initSth();
});

function initSth() {
    bindImage();

    $('.photoAll').vmcarousel({
        centered: true,
        start_item: 0,
        autoplay: false,
        infinite: true
    });
}