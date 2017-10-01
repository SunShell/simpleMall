var sp,
    theToken;

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    initToastr();

    //请求数据
    sp = $('#mlContainer').shellPaginate({
        token: theToken,
        table: 'set_messages',
        orderBy: 'order by created_at desc',
        delFun: delMessage,
        listObj: [
            {
                type : 'checkbox',
                value : 'id',
                width : '10%'
            },
            {
                type : 'content',
                value : 'name',
                showName : '联系人',
                orderField : 'name'
            },
            {
                type : 'content',
                value : 'phone',
                showName : '联系方式',
                orderField : 'phone'
            },
            {
                type : 'content',
                value : 'content',
                showName : '留言内容',
                orderField : 'content'
            },
            {
                type : 'content',
                value : 'created_at',
                showName : '添加时间',
                orderField : 'created_at'
            },
            {
                type : 'operation',
                value : { 'del' : 'id' },
                showName : '操作'
            }
        ]
    });

    $('.spOpContainer').on('click','.btn-primary',function () {
        queryMessage();
    }).on('click','.btn-danger',function () {
        delMessage();
    });
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}

//搜索操作
function queryMessage() {
    var queryContent = $('#queryContent').val().trim();

    sp.reList("(name like '%" + queryContent + "%' or phone like '%" + queryContent + "%' or content like '%" + queryContent + "%')");
}

//删除操作
function delMessage(id) {
    var ids = [];

    if(id){
        ids.push(id);
    }else{
        $('.spListOne:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length < 1) {
            toastr["error"]("请选择要删除的数据！");
            return false;
        }
    }

    if(!confirm('删除后数据不可恢复，确认删除所选数据吗？')) return false;

    $.ajax({
        type: 'post',
        url: '/admin/set/messageDel',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            delId: ids.join(',')
        },
        success: function (res) {
            switch (res.flag){
                case 'success':
                    toastr["success"]("删除成功！");
                    sp.reList();
                    break;
                default:
                    toastr["error"]("删除失败！");
                    break;
            }
        }
    });
}
