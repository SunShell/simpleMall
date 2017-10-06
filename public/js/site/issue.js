var itemNum,
    theToken,
    pageId = 1;

$(function () {
    initSth();
});

function initSth() {
    itemNum = $('#itemNum').val();
    theToken = $('#theToken').val();

    getPageData();
}

function getPageData() {
    $.ajax({
        type: 'post',
        url: '/service/getIssues',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            pageId: pageId
        },
        success: function (res) {
            renderData(res.data);
        }
    });
}

function renderData(data) {
    var html = '<h3>问题列表</h3><ul class="issueList">';

    $(data).each(function (i) {
        html += '<li class="issueOne"><a href="/service/issue/'+this.id+'">'+(i+1)+'.&nbsp;'+this.name+'</a></li>';
    });

    html += '</ul>';

    html += getPageHtml(itemNum,pageId,10);

    $('#containerDiv').html(html);

    bindOp();
}

function bindOp() {
    //翻页操作
    $('.mainPageBar').on('click', 'a', function () {
        if($(this).hasClass('active')) return false;

        var type = $(this).attr('class'),
            goId = type === 'pageG' ? $(this).attr('pageId') : '';

        var nextId = getNextNum(type,itemNum,pageId,goId,10);

        if(nextId !== pageId){
            pageId = nextId;
            getPageData();
        }
    });
}
