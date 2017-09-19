var sp,
    layerIndex,
    theToken,
    cuiDatePath = '';

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    var theDate = new Date();

    cuiDatePath = theDate.getFullYear() + '/' + (theDate.getMonth() + 1) + '/' + theDate.getDate();

    initToastr();

    //请求数据
    sp = $('#clContainer').shellPaginate({
        token: theToken,
        table: 'product_categories',
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
                value : 'indexShow',
                showName : '首页展示',
                orderField : 'indexShow',
                matchObj : { 0 : '不展示', 1 : '展示' }
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
        url: '/admin/product/categoryGet',
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
    var datePath = cuiDatePath,
        isShow = false;

    if(id){
        var tmpArr = data.created_at.substr(0,10).split('-');
        datePath = tmpArr[0] + '/' + +tmpArr[1] + '/' + +tmpArr[2];
        if(data && data.indexShow) isShow = true;
    }

    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '产品分类',
        area: ['400px', '680px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
                    '<div class="form-group">'+
                        '<label for="categoryName">分类名称</label>'+
                        '<input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="分类名称" value="'+(data ? data.name : '')+'">'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label>首页展示</label>&nbsp;&nbsp;'+
                        '<input type="checkbox" id="categoryIndexShow" name="categoryIndexShow" '+(isShow ? 'checked' : '')+'>'+
                    '</div>'+
                    '<div class="form-group index-shows '+(isShow ? '' : 'mall-not-show')+'">'+
                        '<label>英文名称</label>'+
                        '<input type="text" class="form-control" id="categoryShowName" name="categoryShowName" placeholder="英文名称" value="'+(isShow ? data.showName : '')+'">'+
                    '</div>'+
                    '<div class="form-group index-shows '+(isShow ? '' : 'mall-not-show')+'">'+
                        '<label>简介</label>'+
                        '<textarea class="form-control" id="categoryBriefIntroduction" name="categoryBriefIntroduction" placeholder="简介" rows="3" style="resize: none;">'+
                        (isShow ? data.briefIntroduction : '')+
                        '</textarea>'+
                    '</div>'+
                 '</form>'+
                 '<form id="cuiForm" class="index-shows '+(isShow ? '' : 'mall-not-show')+'"  action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 0 20px 10px;">'+
                    '<input type="hidden" name="_token" value="'+theToken+'">'+
                    '<div class="form-group">'+
                        '<label for="cuiValue">产品图片</label>'+
                        '<div class="uploadImageContainer" id="uploadImageContainer">'+getImageDiv(isShow ? datePath + '/' + data.image : '')+'</div>'+
                        '<div>'+
                            '<input type="file" id="cuiValue" name="cuiValue" style="display: inline-block;">'+
                            '<input type="hidden" id="cuiPath" name="cuiPath" value="product/'+datePath+'">'+
                            '<button type="button" class="btn btn-sm btn-success" id="cuiBtn" style="display: inline-block;">上 传</button>'+
                        '</div>'+
                    '</div>'+
                 '</form>'+
                 '<div class="text-center" style="padding: 0 20px;">'+
                    '<button type="button" class="btn btn-primary btn-block" id="addCategory">'+(id ? '修 改' : '添 加')+'</button>'+
                 '</div>',
        success: function(layero, index){
            layerIndex = index;

            //绑定图片上传
            $('#cuiBtn').on('click',function () {
                var cuiValue = $('#cuiValue').val();

                if(!cuiValue){
                    toastr["error"]("请选择要上传的图片！");
                    return false;
                }

                if($('#uploadImageContainer .uploadImageDiv').length >= 1){
                    toastr["error"]("只能上传一张图片！");
                    return false;
                }

                $('#cuiForm').ajaxForm({
                    success: showImages,
                    dataType: 'json'
                }).submit();
            });

            //删除图片操作
            $('#uploadImageContainer').on('click', 'a', function () {
                $(this.parentNode).remove();
            });

            //切换首页展示字段
            $('.spAddForm').on('click','#categoryIndexShow', function () {
                if($(this).prop('checked')){
                    $('.index-shows').removeClass('mall-not-show');
                }else{
                    $('.index-shows').addClass('mall-not-show');
                }
            });

            //保存数据
            $('#addCategory').on('click', function () {
                var categoryName = $('#categoryName').val(),
                    categoryIndexShow = $('#categoryIndexShow').prop('checked') ? 1 : 0,
                    categoryShowName = categoryIndexShow ? $('#categoryShowName').val() : '',
                    categoryBriefIntroduction = categoryIndexShow ? $('#categoryBriefIntroduction').val() : '',
                    categoryImage = categoryIndexShow ? $('#uploadImageContainer .uploadImageDiv a').attr('filename') :'',
                    tip = id ? '修改' : '添加';

                if(!categoryName){
                    toastr["error"]("请填写分类名称！");
                    return false;
                }

                if(categoryIndexShow && (!categoryShowName || !categoryBriefIntroduction || !categoryImage)){
                    toastr["error"]("请补全首页展示内容！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/product/categoryModify' : '/admin/product/categoryAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        categoryId: id || '',
                        categoryName: categoryName,
                        categoryIndexShow: categoryIndexShow,
                        categoryShowName: categoryShowName,
                        categoryImage: categoryImage,
                        categoryBriefIntroduction: categoryBriefIntroduction
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'exist':
                                toastr["error"]("已存在相同名称的分类，无法" + tip + "！");
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

//上传图片后显示
function showImages(response) {
    if(response.success){
        toastr["success"]("上传成功！");

        $('#cuiValue').val('');

        var img = '<div class="uploadImageDiv">'+
                    '<img src="'+response.src+'">'+
                    '<a filename="'+response.fileName+'">删除</a>'+
                  '</div>';

        $('#uploadImageContainer').append(img);
    }else{
        toastr["error"](response.error);
    }
}

//修改时显示已上传的图片
function getImageDiv(path) {
    var html = '';

    if(!path) return html;

    var tmpArr = path.split('/');

    path = $('#theSrc').val() + '/' + path;

    html =  '<div class="uploadImageDiv">'+
                '<img src="'+path+'">'+
                '<a filename="'+tmpArr[tmpArr.length-1]+'">删除</a>'+
            '</div>';

    return html;
}

//删除操作
function delCategory(id) {
    if(!confirm('删除后数据不可恢复，确认删除所选数据吗？')) return false;

    $.ajax({
        type: 'post',
        url: '/admin/product/categoryDel',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            delId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'exist':
                    toastr["error"]("该分类下存在产品，无法删除！");
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
