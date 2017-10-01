$(function () {
    initSth();
});

function initSth() {
    initToastr();

    //绑定保存
    $('#saveBtn').on('click', function () {
        storeContact();
    });
}

//保存操作
function storeContact() {
    var flag = true;

    $('.storeNeed').each(function () {
        if(!$(this).val()){
            toastr["error"]('请填写' + $(this).attr('tip') + '！');
            flag = false;
            return false;
        }
    });

    if(!flag) return false;

    $('#contactForm').submit();
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };

    var store_res = $('#store_res').val();

    if(store_res){
        if(store_res.indexOf('成功') > -1){
            toastr["success"](store_res);
        }else{
            toastr["error"](store_res);
        }
    }
}
