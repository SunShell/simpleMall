var theToken,
    theForm = null,
    ue,
    configArr = [],
    categoryData,
    configData;

$(function () {
    initSth();
});

//初始化
function initSth() {
    //初始化提示框参数
    initToastr();

    theToken = $('#theToken').val();
    categoryData = $.parseJSON($('#categoryData').val());
    configData = $.parseJSON($('#configData').val());

    ue = UE.getEditor('pIntroduces', {
        initialFrameWidth: '100%',
        initialFrameHeight: '300',
        enableAutoSave: false,
        autoSyncData: false,
        saveInterval: 1000*600,
        toolbars: ueToolbars
    });

    ue.ready(function() {
        ue.execCommand('serverparam', '_token', theToken);
    });

    //初始化类别
    initCategory();

    //按类型切换参数
    $('#pCategory').on('change', function () {
        getCategoryConfig();
    });

    //绑定上传图片
    $('.uploadForm').on('click', '.btn-success', function () {
        uploadImage(this);
    });

    //删除图片
    $('.uploadForm .uploadImageContainer').on('click', 'a', function () {
        $(this.parentNode).remove();
    });

    //添加性能参数
    $('#productAttrAddBtn').on('click', addAttr);

    //删除性能参数
    $('#attrContainer').on('click', '.product-attr-remove', function () {
        $(this.parentNode.parentNode.parentNode.parentNode).remove();
    });

    //保存
    $('#saveBtn').on('click', saveData);
}

//初始化分类
function initCategory() {
    var initCategory = $('#initCategory').val(),
        html = '';

    for(var p in categoryData){
        if(initCategory && p === initCategory){
            html += '<option value="'+p+'" selected>'+categoryData[p]+'</option>';
        }else{
            html += '<option value="'+p+'">'+categoryData[p]+'</option>';
        }
    }

    $('#pCategory').append(html);

    if(initCategory){
        $.ajax({
            type: 'post',
            url: '/admin/product/getCategoryConfig',
            headers: {
                'X-CSRF-TOKEN': theToken
            },
            data: {
                categoryId: initCategory
            },
            success: function (res) {
                configArr = res.data;
            }
        });
    }
}

//按类型切换参数
function getCategoryConfig() {
    var categoryId = $('#pCategory').val();

    $('.product-attr-table').remove();

    if(!categoryId){
        configArr = [];
        return false;
    }

    $.ajax({
        type: 'post',
        url: '/admin/product/getCategoryConfig',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            categoryId: categoryId
        },
        success: function (res) {
            configArr = res.data;
        }
    });
}

//添加型号和参数
function addAttr() {
    if(!$('#pCategory').val()){
        return false;
    }

    if(configArr.length < 1){
        toastr["error"]("当前产品分类尚未配置参数，请先在参数管理中进行配置！");
        return false;
    }

    var html = '<table class="table table-bordered product-attr-table">' +
        '<tbody>' +
        '<tr>' +
        '<td width="50%">型号&nbsp;&nbsp;<a class="product-attr-remove" title="删除"><i class="fa fa-times"></i></a></td>' +
        '<td>' +
        '<input type="text" class="pcModel">' +
        '</td>' +
        '</tr>';

    for(var p in configArr){
        html += '<tr>' +
            '<td>' + configData[configArr[p]] + '</td>' +
            '<td>' +
            '<input type="text" class="pcAttr" data-value="'+configArr[p]+'">' +
            '</td>' +
            '</tr>';
    }

    html += '</tbody>' +
            '</table>';

    $('#attrContainer').append(html);
}

//上传图片
function uploadImage(obj) {
    var file = $(obj).siblings('[name="cuiValue"]').val();

    if(!file){
        toastr["error"]("请选择要上传的图片！");
        return false;
    }

    theForm = obj.parentNode.parentNode.parentNode;

    $(theForm).ajaxForm({
        success: showImages,
        dataType: 'json'
    }).submit();
}

//显示已上传的图片
function showImages(response) {
    if(response.success){
        toastr["success"]("上传成功！");

        $(theForm).find('[name="cuiValue"]').val('');

        var img = '<div class="uploadImageDiv">'+
            '<img src="'+response.src+'">'+
            '<a filename="'+response.fileName+'">删除</a>'+
            '</div>';

        $(theForm).find('.uploadImageContainer').append(img);
    }else{
        toastr["error"](response.error);
    }

    theForm = null;
}

//保存数据
function saveData() {
    var pImages = '',
        pPhotos = '',
        pAttr = '';

    $('#pImageDiv .uploadImageDiv a').each(function () {
        if(pImages !== '') pImages += ',';
        pImages += $(this).attr('filename');
    });

    $('#pPhotoDiv .uploadImageDiv a').each(function () {
        if(pPhotos !== '') pPhotos += ',';
        pPhotos += $(this).attr('filename');
    });

    var tmpVal = '';

    $('.product-attr-table').each(function(){
        tmpVal = $(this).find('.pcModel').val();

        if(!tmpVal) return true;

        tmpVal += '\2';

        $(this).find('.pcAttr').each(function(){
            tmpVal += $(this).attr('data-value') + '\4' + ($(this).val() ? $(this).val() : '-') + '\3';
        });

        pAttr += tmpVal + '\1';
    });

    $('#pImages').val(pImages);
    $('#pPhotos').val(pPhotos);
    $('#pIntroduce').val(ue.getContent());
    $('#pAttr').val(pAttr);

    var flag = true;

    $('.storeNeed').each(function() {
        if(!$(this).val()){
            if($(this).attr('id') === 'pImages' || $(this).attr('id') === 'pPhotos'){
                toastr["error"]("请上传" + $(this).attr('tip') + "！");
            }else if($(this).attr('id') === 'pCategory'){
                toastr["error"]("请选择" + $(this).attr('tip') + "！");
            }else{
                toastr["error"]("请填写" + $(this).attr('tip') + "！");
            }

            flag = false;
            return false;
        }
    });

    if(!flag) return false;

    $('#productForm').submit();
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
