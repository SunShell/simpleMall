var bannerObj = null;

$(function () {
    initBase();
});

function initBase() {
    if($('.mainBannerDot').length > 1) initBanner();

    //banner图跳转
    $('.mainBanner').on('click', 'li', function () {
        var hrefData = $(this).attr('hrefData');

        if(hrefData === '#') return false;

        if(hrefData.indexOf('http://') > -1 ||hrefData.indexOf('https://') > -1){
            window.open(hrefData);
        }else{
            window.open('http://' + hrefData);
        }
    });

    //banner图点击切换
    $('.mainBannerDot').on('click', function () {
        bannerObj && clearTimeout(bannerObj);

        if($('.mainBannerDot').length <= 1) return false;

        var one = +$('.mainBannerDotSel').attr('banner'),
            two = +$(this).attr('banner');

        if(one === two){
            initBanner();
            return false;
        }

        $('#mainBanner'+one).animate({opacity : 0},1000).css('zIndex', 0);
        $('#mainBanner'+two).animate({opacity : 1},1000).css('zIndex', 100);

        $('#mainDot'+one).removeClass('mainBannerDotSel');
        $(this).addClass('mainBannerDotSel');

        initBanner();
    });

    //新闻分类切换
    $('.indexArticle .left .one').on('mouseover' , function () {
        var num = $(this).attr('num');

        if($(this).hasClass('active')) return false;

        $(this).addClass('active');

        $(this).siblings('.one').each(function () {
            $(this).removeClass('active');
        });

        $('.indexArticle .right ul').each(function () {
            if($(this).attr('num') === num){
                $(this).addClass('active');
            }else{
                $(this).removeClass('active');
            }
        });
    });
}

//banner图轮播
function initBanner(){
    var one = +$('.mainBannerDotSel').attr('banner'),
        two = one + 1,
        len = $('.mainBannerDot').length;

    if(two > len) two = 1;

    bannerObj = setTimeout(function(){
        $('#mainBanner'+one).animate({opacity : 0},1000).css('zIndex', 0);
        $('#mainBanner'+two).animate({opacity : 1},1000).css('zIndex', 100);

        $('#mainDot'+one).removeClass('mainBannerDotSel');
        $('#mainDot'+two).addClass('mainBannerDotSel');

        initBanner();
    },5000);
}