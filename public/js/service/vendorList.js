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
    sp = $('#vlContainer').shellPaginate({
        token: theToken,
        table: 'service_vendors',
        orderBy: 'order by created_at desc',
        nameStr: 'users.userId.name',
        modifyFun: modifyVendor,
        delFun: delVendor,
        listObj: [
            {
                type : 'checkbox',
                value : 'id',
                width : '10%'
            },
            {
                type : 'content',
                value : 'number',
                showName : '经销商编号',
                orderField : 'number'
            },
            {
                type : 'content',
                value : 'name',
                showName : '经销商编号',
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
        queryVendor();
    }).on('click','.btn-success',function () {
        addVendor();
    }).on('click','.btn-danger',function () {
        delVendor();
    });
}

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}

//搜索操作
function queryVendor() {
    var queryCN = $('#queryCN').val().trim();

    sp.reList("(number like '%" + queryCN + "%' or name like '%" + queryCN + "%')");
}

//修改操作
function modifyVendor(id) {
    $.ajax({
        type: 'post',
        url: '/admin/service/vendorGet',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            vendorId: id
        },
        success: function (res) {
            switch (res.flag){
                case 'success':
                    addVendor(id,res.data);
                    break;
                default:
                    toastr["error"]("未知错误！");
                    break;
            }
        }
    });
}

//添加和修改操作
function addVendor(id,data) {
    var datePath = cuiDatePath;

    if(id){
        var tmpArr = data.created_at.substr(0,10).split('-');
        datePath = tmpArr[0] + '/' + +tmpArr[1] + '/' + +tmpArr[2];
    }

    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '经销商',
        area: ['400px', '520px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="vendorNumber">经销商编号</label>'+
        '<input type="text" class="form-control" id="vendorNumber" name="vendorNumber" placeholder="经销商编号" value="'+(data ? data.number : '')+'">'+
        '</div>'+
        '<div class="form-group">'+
        '<label for="vendorName">经销商名称</label>'+
        '<input type="text" class="form-control" id="vendorName" name="vendorName" placeholder="经销商名称" value="'+(data ? data.name : '')+'">'+
        '</div>'+
        '</form>'+
        '<form id="cuiForm" action="/commonUploadImage" enctype="multipart/form-data" method="post" style="padding: 0 20px 10px;">'+
        '<input type="hidden" name="_token" value="'+theToken+'">'+
        '<div class="form-group">'+
        '<label for="cuiValue">经销商资质照</label>'+
        '<div class="uploadImageContainer" id="uploadImageContainer">'+getImageDiv(id ? (datePath + '/' + data.image) : '')+'</div>'+
        '<div>'+
        '<input type="file" id="cuiValue" name="cuiValue" style="display: inline-block;">'+
        '<input type="hidden" id="cuiPath" name="cuiPath" value="service/'+datePath+'">'+
        '<button type="button" class="btn btn-sm btn-success" id="cuiBtn" style="display: inline-block;">上 传</button>'+
        '</div>'+
        '</div>'+
        '</form>'+
        '<div class="text-center" style="padding: 0 20px;">'+
        '<button type="button" class="btn btn-primary btn-block" id="addVendor">'+(id ? '修 改' : '添 加')+'</button>'+
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

            //保存数据
            $('#addVendor').on('click', function () {
                var vendorNumber = $('#vendorNumber').val(),
                    vendorName = $('#vendorName').val(),
                    vendorImage = $('#uploadImageContainer .uploadImageDiv a').attr('filename'),
                    tip = id ? '修改' : '添加';

                if(!vendorNumber){
                    toastr["error"]("请填写经销商编号！");
                    return false;
                }

                if(!vendorName){
                    toastr["error"]("请填写经销商名称！");
                    return false;
                }

                if(!vendorImage){
                    toastr["error"]("请上传经销商资质照！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/service/vendorModify' : '/admin/service/vendorAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        vendorId: id || '',
                        vendorNumber: vendorNumber,
                        vendorName: vendorName,
                        vendorImage: vendorImage
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'exist':
                                toastr["error"]("该经销商信息已存在，无法" + tip + "！");
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
function delVendor(id) {
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
        url: '/admin/service/vendorDel',
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
    if(layerIndex) layer.close(layerIndex);
    layerIndex = '';
}
