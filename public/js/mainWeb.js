$(function () {
    initBase();
});

function initBase() {

}

function getPageHtml(allNum,pageId,pageSize) {
    if(!pageSize) pageSize = 9;
    var s,e,
        pageNum = Math.ceil(allNum / pageSize) + (allNum === 0 ? 1 : 0);

    s = pageId - 2;
    if(s < 1) s = 1;

    e = s + 4;
    if(e > pageNum) e = pageNum;

    var html =  '<div class="mainPageBar">'+
                '<a class="pageI">首页</a><a class="pageL">上一页</a>';

    for(var i=s;i<=e;i++){
        if(i === pageId){
            html += '<a class="pageG active" pageId="'+i+'">'+i+'</a>';
        }else{
            html += '<a class="pageG" pageId="'+i+'">'+i+'</a>';
        }
    }

    html += '<a class="pageN">下一页</a><a class="pageE">尾页</a>'+
            '</div>';

    return html;
}

function getNextNum(type,allNum,pageId,goId,pageSize) {
    if(!pageSize) pageSize = 9;

    var nextId,
        pageNum = Math.ceil(allNum / pageSize) + (allNum === 0 ? 1 : 0);

    switch (type) {
        case 'pageI':
            nextId = 1;
            break;
        case 'pageL':
            nextId = pageId - 1;
            if(nextId < 1) nextId = 1;
            break;
        case 'pageG':
            nextId = goId;
            break;
        case 'pageN':
            nextId = pageId + 1;
            if(nextId > pageNum) nextId = pageNum;
            break;
        case 'pageE':
            nextId = pageNum;
            break;
    }

    return +nextId;
}

//右侧图片相关操作
function bindImage() {
    $('.rightImg .upDown').on('click', function () {
        var type = $(this).hasClass('up') ? 'up' : 'down',
            obj = $(this).siblings('.imageAll').find('.imageMove'),
            top = +$(obj).css('top').replace('px',''),
            height = $(obj).height();

        if(height < 380) return false;

        if(type === 'up'){
            top += 125;
            if(top > 0) return false;
        }else{
            top -= 125;
            if((height + top) < 370) return false;
        }

        $(obj).css('top', top + 'px');
    });


    $('.rightImg .imageAll .imageMap').on('mouseover', function () {
        var path = $(this).attr('src');

        $('.imageBig').attr('src', path);
    });
}