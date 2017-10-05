var itemNum,
    theToken,
    categoryId,
    imagePath,
    pageId = 1;

$(function () {
    initSth();
});

function initSth() {
    itemNum = $('#itemNum').val();
    theToken = $('#theToken').val();
    categoryId = $('#categoryId').val();
    imagePath = $('#imagePath').val();

    getPageData();
}

function getPageData() {
    $.ajax({
        type: 'post',
        url: '/article/getList',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            pageId: pageId,
            categoryId: categoryId
        },
        success: function (res) {
            renderData(res.data);
        }
    });
}

function renderData(data) {
    var html = '';

    $(data).each(function () {
        html += '<div class="articleOne">'+
                    '<div class="articleLeft">'+
                        '<img src="'+getDatePath(this.image,this.created_at)+'" class="gtd" articleId="'+this.id+'">'+
                    '</div>'+
                    '<div class="articleRight">'+
                        '<h2 class="gtd" articleId="'+this.id+'">'+this.name+'</h2>'+
                        '<h3>'+this.created_at.substring(0,10)+'</h3>'+
                        '<p>'+this.abstract+'</p>'+
                    '</div>'+
                '</div>';
    });

    html += getPageHtml(itemNum,pageId,5);

    $('#containerDiv').html(html);

    bindOp();
}

function bindOp() {
    //绑定产品详情
    $('.gtd').on('click', function () {
        window.location.href = '/article/detail/' + $(this).attr('articleId');
    });

    //翻页操作
    $('.mainPageBar').on('click', 'a', function () {
        if($(this).hasClass('active')) return false;

        var type = $(this).attr('class'),
            goId = type === 'pageG' ? $(this).attr('pageId') : '';

        var nextId = getNextNum(type,itemNum,pageId,goId,5);

        if(nextId !== pageId){
            pageId = nextId;
            getPageData();
        }
    });
}

function getDatePath(val,tm) {
    var tmp,
        arr = val.split(',');

    tmp = '/' + tm.substring(0,4) + '/' + +tm.substring(5,7) + '/' + +tm.substring(8,10) + '/';

    return imagePath + tmp + arr[0];
}