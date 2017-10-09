var layerMainIndex = '';

$(function () {
    initMessage();
});

function initMessage() {
    $('.smSiteBottom .bottomRight').on('click', '#bottomMessageSave', messageSave).on('click', '#bottomMessageClear', function () {
        $('#bottomMessageContent').val('');
    });
}

function messageSave() {
    var messageToken = $('#bottomMessageToken').val(),
        messageContent = $('#bottomMessageContent').val().trim();

    if(!messageContent){
        alert('请输入留言内容！');
        return false;
    }

    layer.open({
        type: 1,
        title: '提交留言',
        area: ['400px', '300px'],
        zIndex: 1500,
        content: '<div class="bottomMessageContainer">'+
            '<div>'+
                '<label for="bottomMessageName">姓名</label>'+
                '<input type="text" id="bottomMessageName" name="bottomMessageName" placeholder="姓名">'+
            '</div>'+
            '<div>'+
                '<label for="bottomMessagePhone">联系方式</label>'+
                '<input type="text" id="bottomMessagePhone" name="bottomMessagePhone" placeholder="联系方式">'+
            '</div>'+
            '<button type="button" id="bottomMessageStore">提&nbsp;交</button>'+
        '</div>',
        success: function(layero, index){
            layerMainIndex = index;

            //保存数据
            $('#bottomMessageStore').on('click', function () {
                var messageName = $('#bottomMessageName').val().trim(),
                    messagePhone = $('#bottomMessagePhone').val().trim();

                if(!messageName){
                    alert('请填写姓名！');
                    return false;
                }

                if(!messagePhone){
                    alert('请填写联系方式');
                    return false;
                }

                if(!isPoneAvailable(messagePhone) && !isTelAvailable(messagePhone)){
                    alert('请填写正确的手机号码或者座机号码！');
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: '/message/store',
                    headers: {
                        'X-CSRF-TOKEN': messageToken
                    },
                    data: {
                        messageName: messageName,
                        messagePhone: messagePhone,
                        messageContent: messageContent
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'success':
                                alert("添加成功！");
                                $('#bottomMessageContent').val('');
                                closeMainLayer();
                                break;
                            default:
                                alert("添加失败！");
                                break;
                        }
                    }
                });
            });
        }
    });
}

function closeMainLayer() {
    if(layerMainIndex) layer.close(layerMainIndex);
    layerMainIndex = '';
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

function isPoneAvailable (num) {
    var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;

    return myreg.test(num);
}

function isTelAvailable (num) {
    var myreg = /^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;

    return myreg.test(num);
}
