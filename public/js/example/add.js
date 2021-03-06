var theForm = null,
    ue,
    categoryData;

$(function () {
    initSth();
});

//初始化
function initSth() {
    //初始化提示框参数
    initToastr();

    categoryData = $.parseJSON($('#categoryData').val());

    ue = UE.getEditor('pContents', {
        initialFrameWidth: '100%',
        initialFrameHeight: '300',
        enableAutoSave: false,
        autoSyncData: false,
        saveInterval: 1000*600,
        toolbars: ueToolbars
    });

    ue.ready(function() {
        ue.execCommand('serverparam', '_token', $('#theToken').val());
    });

    //初始化类别
    initCategory();

    //绑定上传图片
    $('.uploadForm').on('click', '.btn-success', function () {
        uploadImage(this);
    });

    //删除图片
    $('.uploadForm .uploadImageContainer').on('click', 'a', function () {
        $(this.parentNode).remove();
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
    var pImage = '';

    $('#pImageDiv .uploadImageDiv a').each(function () {
        if(pImage !== '') pImage += ',';
        pImage += $(this).attr('filename');
    });

    $('#pImage').val(pImage);
    $('#pContent').val(ue.getContent());

    var flag = true;

    $('.storeNeed').each(function() {
        if(!$(this).val()){
            if($(this).attr('id') === 'pImage'){
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

    $('#exampleForm').submit();
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
