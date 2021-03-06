var theForm = null;

$(function () {
    initSth();
});

//初始化
function initSth() {
    //初始化提示框参数
    initToastr();

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

//上传图片
function uploadImage(obj) {
    var file = $(obj).siblings('[name="cuiValue"]').val();

    if(!file){
        toastr["error"]("请选择要上传的图片！");
        return false;
    }

    theForm = obj.parentNode.parentNode.parentNode;

    if($(theForm).find('.uploadImageDiv').length >= 1){
        toastr["error"]("只能上传一张图片！");
        return false;
    }

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
    var pLogo = '',
        pIcon = '',
        pQr = '';

    $('#pLogoDiv .uploadImageDiv a').each(function () {
        pLogo = $(this).attr('filename');
    });

    $('#pIconDiv .uploadImageDiv a').each(function () {
        pIcon = $(this).attr('filename');
    });

    $('#pQrDiv .uploadImageDiv a').each(function () {
        pQr = $(this).attr('filename');
    });

    $('#pSiteLogo').val(pLogo);
    $('#pSiteIcon').val(pIcon);
    $('#pSiteQr').val(pQr);

    var flag = true;

    $('.storeNeed').each(function() {
        if(!$(this).val()){
            if(['pSiteLogo','pSiteIcon','pSiteQr'].indexOf($(this).attr('id')) > -1){
                toastr["error"]("请上传" + $(this).attr('tip') + "！");
            }else{
                toastr["error"]("请填写" + $(this).attr('tip') + "！");
            }

            flag = false;
            return false;
        }
    });

    if(!flag) return false;

    $('#commonForm').submit();
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };

    var storeRes = $('#store_res').val();

    if(storeRes){
        if(storeRes.indexOf('成功') > -1){
            toastr["success"](storeRes);
        }else{
            toastr["error"](storeRes);
        }
    }
}
