var theToken;

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();

    initToastr();

    //绑定添加
    $('.spOpContainer').on('click','.btn-success',function () {
        addBanner();
    });

    //绑定修改
    $('.spListTable').on('click', '.spListModify', function () {
        modifyBanner(this);
    }).on('click', '.spListDel', function () {//绑定删除
        delBanner(this);
    });
}

//修改参数
function modifyBanner(obj) {
    var id = $(obj).attr('data-value');

    $.ajax({
        type: 'post',
        url: '/admin/set/bannerGet',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            bannerId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'success':
                    addBanner(id,res.data);
                    break;
                default:
                    toastr["error"]("未知错误！");
                    break;
            }
        }
    });
}

//添加参数
function addBanner(id,data) {
    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '首页轮播图',
        area: ['400px', '450px'],
        zIndex: 1500,
        content:'<form id="cuiForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 20px 20px 0;">'+
        '<input type="hidden" name="_token" value="'+theToken+'">'+
        '<div class="form-group">'+
        '<label for="cuiValue">轮播图片</label>'+
        '<div class="uploadImageContainer" id="uploadImageContainer">'+getImageDiv(id ? data.image : '')+'</div>'+
        '<div>'+
        '<input type="file" id="cuiValue" name="cuiValue" style="display: inline-block;">'+
        '<input type="hidden" id="cuiPath" name="cuiPath" value="banner">'+
        '<button type="button" class="btn btn-sm btn-success" id="cuiBtn" style="display: inline-block;">上 传</button>'+
        '</div>'+
        '</div>'+
        '</form>'+
        '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="bannerHref">链接地址</label>'+
        '<input type="text" class="form-control" id="bannerHref" name="bannerHref" placeholder="链接地址" value="'+(data ? data.href : '')+'">'+
        '</div>'+
        '<button type="button" class="btn btn-primary btn-block" id="addBanner">'+(id ? '修 改' : '添 加')+'</button>'+
        '</form>',
        success: function(layero, index){
            $('.spAddForm').on('keydown', function () {
                if(event.keyCode === 13) return false;
            });

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

            //保存数据
            $('.spAddForm').on('click','#addBanner',function () {
                var bannerHref = $('#bannerHref').val(),
                    bannerImage = $('#uploadImageContainer .uploadImageDiv a').attr('filename'),
                    tip = id ? '修改' : '添加';

                if(!bannerImage){
                    toastr["error"]("请上传轮播图片！");
                    return false;
                }

                if(!bannerHref){
                    toastr["error"]("请填写链接地址！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/set/bannerModify' : '/admin/set/bannerAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        bannerId: id || '',
                        bannerHref: bannerHref,
                        bannerImage: bannerImage
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'enough':
                                toastr["error"]("最多添加三个轮播图！");
                                break;
                            case 'success':
                                toastr["success"](tip + "成功！");
                                //重新加载
                                location.reload();
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

//删除参数
function delBanner(obj) {
    if(!confirm('删除后数据不可恢复，确认删除所选数据吗？')) return false;

    $.ajax({
        type: 'post',
        url: '/admin/set/bannerDel',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            bannerId: $(obj).attr('data-value')
        },
        success: function (res) {
            switch (res.flag){
                case 'no':
                    toastr["error"]("请至少保留一个轮播图！");
                    break;
                case 'success':
                    toastr["success"]("删除成功！");
                    //重新加载
                    location.reload();
                    break;
                default:
                    toastr["error"]("删除失败！");
                    break;
            }
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

//修改时显示图片
function getImageDiv(img) {
    if(!img) return '';

    var path = $('#thePath').val() + '/' + img;

    return  '<div class="uploadImageDiv">'+
                '<img src="'+path+'">'+
                '<a filename="'+img+'">删除</a>'+
            '</div>';
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}
