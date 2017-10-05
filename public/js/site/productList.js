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
        url: '/product/getList',
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

    $(data).each(function (i) {
        html += '<div class="listOne" productId="'+this.id+'" '+((i+1)%3===0 ? 'style="margin-right: 0;"' : '')+'>'+
                    '<div class="listOneImg"><img src="'+getDatePath(this.images,this.created_at)+'"></div>'+ this.name +
                '</div>';
    });

    html += '<div class="mainClear"></div>';

    html += getPageHtml(itemNum,pageId);

    $('#containerDiv').html(html);

    bindOp();
}

function bindOp() {
    //绑定产品详情
    $('.listOne').on('click', function () {
        window.location.href = '/product/detail/' + $(this).attr('productId');
    });

    //翻页操作
    $('.mainPageBar').on('click', 'a', function () {
        if($(this).hasClass('active')) return false;

        var type = $(this).attr('class'),
            goId = type === 'pageG' ? $(this).attr('pageId') : '';

        var nextId = getNextNum(type,itemNum,pageId,goId);

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