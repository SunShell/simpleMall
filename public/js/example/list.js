var sp,
    theToken,
    categoryObj = {};

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    initToastr();

    initCategory();

    //请求数据
    sp = $('#elContainer').shellPaginate({
        token: theToken,
        table: 'examples',
        orderBy: 'order by created_at desc',
        nameStr: 'example_categories.id.name,users.userId.name',
        modifyFun: modifyFun,
        detailFun: detailFun,
        delFun: delFun,
        listObj: [
            {
                type : 'checkbox',
                value : 'id',
                width : '10%'
            },
            {
                type : 'content',
                value : 'name',
                showName : '案例名称',
                orderField : 'name'
            },
            {
                type : 'content',
                value : 'categoryId',
                showName : '案例分类',
                orderField : 'categoryId',
                matchField : 'example_categories_id'
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
                value : { 'modify' : 'id', 'del' : 'id', 'detail' : 'id' },
                showName : '操作'
            }
        ]
    });

    $('.spOpContainer').on('click','.btn-primary',function () {
        queryFun();
    }).on('click','.btn-danger',function () {
        delFun();
    });
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };

    var storeRes = $('#storeRes').val();

    if(storeRes){
        if(storeRes.indexOf('成功') > -1){
            toastr["success"](storeRes);
        }else{
            toastr["error"](storeRes);
        }
    }
}

//初始化分类
function initCategory() {
    $.ajax({
        type: 'post',
        url: '/admin/example/categoryAll',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        success: function (res) {
            var opt = '<option value="">请选择</option>';

            if(res && res.data){
                categoryObj = res.data;

                for(var p in res.data){
                    opt += '<option value="'+p+'">'+res.data[p]+'</option>';
                }
            }

            $('#queryCategory').html(opt);
        }
    });
}

//搜索操作
function queryFun() {
    var queryCategory = $('#queryCategory').val(),
        queryName = $('#queryName').val().trim(),
        queryCon = "";

    if(queryCategory){
        queryCon = " categoryId = '"+queryCategory+"' ";
    }

    if(queryName){
        if(queryCon) queryCon += " and ";
        queryCon += " name like '%"+queryName+"%' ";
    }

    sp.reList(queryCon);
}

//修改操作
function modifyFun(id) {
    $('#modifyId').val(id);
    $('#modifyForm').submit();
}

//查看详情
function detailFun(id) {
    window.open('/example/detail/' + id);
}

//删除操作
function delFun(id) {
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
        url: '/admin/example/del',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            ids: ids.join(',')
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
