var sp,
    layerIndex,
    theToken,
    ue = null;

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    initToastr();

    //请求数据
    sp = $('#ilContainer').shellPaginate({
        token: theToken,
        table: 'service_issues',
        orderBy: 'order by created_at desc',
        nameStr: 'users.userId.name',
        modifyFun: modifyIssue,
        delFun: delIssue,
        listObj: [
            {
                type : 'checkbox',
                value : 'id',
                width : '10%'
            },
            {
                type : 'content',
                value : 'name',
                showName : '问题名称',
                orderField : 'name'
            },
            {
                type : 'content',
                value : 'addUser',
                showName : '添加人',
                orderField : 'addUser',
                matchField : 'users_userId'
            },
            {
                type : 'content',
                value : 'created_at',
                showName : '添加时间',
                orderField : 'created_at'
            },
            {
                type : 'operation',
                value : { 'modify' : 'id', 'del' : 'id' },
                showName : '操作'
            }
        ]
    });

    $('.spOpContainer').on('click','.btn-primary',function () {
        queryIssue();
    }).on('click','.btn-success',function () {
        addIssue();
    }).on('click','.btn-danger',function () {
        delIssue();
    });
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}

//搜索操作
function queryIssue() {
    var queryCN = $('#queryCN').val().trim();

    sp.reList("name like '%" + queryCN + "%'");
}

//修改操作
function modifyIssue(id) {
    $.ajax({
        type: 'post',
        url: '/admin/service/issueGet',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            issueId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'success':
                    addIssue(id,res.data);
                    break;
                default:
                    toastr["error"]("未知错误！");
                    break;
            }
        }
    });
}

//添加和修改操作
function addIssue(id,data) {
    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '问题',
        area: ['800px', '600px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="issueName">问题名称</label>'+
        '<input type="text" class="form-control" id="issueName" name="issueName" placeholder="问题名称" value="'+(data ? data.name : '')+'">'+
        '</div>'+
        '<div class="form-group">'+
        '<label for="issueContent">问题内容</label>'+
        '<script id="issueContent" type="text/plain">'+(data ? data.content : '')+'</script>'+
        '</div>'+
        '<button type="button" class="btn btn-primary btn-block" id="addIssue">'+(id ? '修 改' : '添 加')+'</button>'+
        '</form>',
        success: function(layero, index){
            layerIndex = index;

            //初始化ue
            ue = UE.getEditor('issueContent', {
                initialFrameWidth: '100%',
                initialFrameHeight: '250',
                enableAutoSave: false,
                autoSyncData: false,
                saveInterval: 1000*600,
                toolbars: ueToolbars
            });

            ue.ready(function() {
                ue.execCommand('serverparam', '_token', theToken);
            });

            //保存数据
            $('#addIssue').on('click', function () {
                var issueName = $('#issueName').val(),
                    issueContent = ue.getContent(),
                    tip = id ? '修改' : '添加';

                if(!issueName){
                    toastr["error"]("请填写问题名称！");
                    return false;
                }

                if(!issueContent){
                    toastr["error"]("请填写问题内容！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/service/issueModify' : '/admin/service/issueAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        issueId: id || '',
                        issueName: issueName,
                        issueContent: issueContent
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'exist':
                                toastr["error"]("已存在相同名称的问题，无法" + tip + "！");
                                break;
                            case 'success':
                                toastr["success"](tip + "成功！");
                                sp.reList();
                                closeLayer();
                                break;
                            default:
                                toastr["error"](tip + "失败！");
                                break;
                        }
                    }
                });
            });
        }
    });
}

//删除操作
function delIssue(id) {
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
        url: '/admin/service/issueDel',
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

//关闭弹窗
function closeLayer() {
    if(ue) ue.destroy();
    if(layerIndex) layer.close(layerIndex);
    layerIndex = '';
}
