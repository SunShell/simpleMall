$(function () {
    initSth();
});

function initSth() {
    bindImage();

    $('.photoAll').vmcarousel({
        centered: true,
        start_item: 1,
        autoplay: false,
        infinite: false
    });
}
