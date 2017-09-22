var sp,
    layerIndex,
    theToken;

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    initToastr();

    //请求数据
    sp = $('#alContainer').shellPaginate({
        token: theToken,
        table: 'article_categories',
        orderBy: 'order by created_at desc',
        nameStr: 'users.userId.name',
        modifyFun: modifyCategory,
        delFun: delCategory,
        listObj: [
            {
                type : 'content',
                value : 'name',
                showName : '分类名称',
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
        queryCategory();
    }).on('click','.btn-success',function () {
        addCategory();
    });
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}

//搜索操作
function queryCategory() {
    var queryCN = $('#queryCN').val().trim();

    sp.reList("name like '%" + queryCN + "%'");
}

//修改操作
function modifyCategory(id) {
    $.ajax({
        type: 'post',
        url: '/admin/article/categoryGet',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            categoryId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'success':
                    addCategory(id,res.data);
                    break;
                default:
                    toastr["error"]("未知错误！");
                    break;
            }
        }
    });
}

//添加和修改操作
function addCategory(id,data) {
    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '分类',
        area: ['400px', '250px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="categoryName">分类名称</label>'+
        '<input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="分类名称" value="'+(data ? data.name : '')+'">'+
        '</div>'+
        '<button type="button" class="btn btn-primary btn-block" id="addCategory">'+(id ? '修 改' : '添 加')+'</button>'+
        '</form>',
        success: function(layero, index){
            layerIndex = index;

            $('.spAddForm').on('keydown', function () {
                if(event.keyCode === 13) return false;
            });

            //保存数据
            $('#addCategory').on('click', function () {
                var categoryName = $('#categoryName').val(),
                    tip = id ? '修改' : '添加';

                if(!categoryName){
                    toastr["error"]("请填写分类名称！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/article/categoryModify' : '/admin/article/categoryAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        categoryId: id || '',
                        categoryName: categoryName
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
function delCategory(id) {
    if(!confirm('删除后数据不可恢复，确认删除所选数据吗？')) return false;

    $.ajax({
        type: 'post',
        url: '/admin/article/categoryDel',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            delId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'exist':
                    toastr["error"]("该分类下存在案例，无法删除！");
                    break;
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
    if(layerIndex) layer.close(layerIndex);
    layerIndex = '';
}
