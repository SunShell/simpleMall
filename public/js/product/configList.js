var theToken,
    configData = {},
    configHtml = '',
    categoryData = {},
    categoryHtml = '<option value="">请选择</option>';

$(function () {
    initSth();
});

//初始化操作
function initSth() {
    theToken = $('#theToken').val();
    configData = $.parseJSON($('#configData').val());
    categoryData = $.parseJSON($('#categoryData').val());

    for(var o in configData){
        configHtml += '<label class="configLabel"><input type="checkbox" name="configIpt" value="'+configData[o].id+'">&nbsp;'+configData[o].name+'</label>';
    }

    for(var p in categoryData){
        categoryHtml += '<option value="'+p+'">'+categoryData[p]+'</option>';
    }
    
    initToastr();

    //绑定添加
    $('.spOpContainer').on('click','.btn-success',function () {
        addConfig();
    }).on('click', '.btn-primary', function () {//绑定参数
        setConfig();
    });

    //绑定修改
    $('.spListTable').on('click', '.spListModify', function () {
        modifyConfig(this);
    }).on('click', '.spListDel', function () {//绑定删除
        delConfig(this);
    });
}

//修改参数
function modifyConfig(obj) {
    addConfig($(obj).attr('data-value'),$(obj).attr('data-name'));
}

//添加参数
function addConfig(id,name) {
    layer.open({
        type: 1,
        title: (id ? '修改' : '添加') + '产品参数',
        area: ['400px', '200px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="configName">参数名称</label>'+
        '<input type="text" class="form-control" id="configName" name="configName" placeholder="参数名称" value="'+(name||'')+'">'+
        '</div>'+
        '<button type="button" class="btn btn-primary btn-block" id="addConfig">'+(id ? '修 改' : '添 加')+'</button>'+
        '</form>',
        success: function(layero, index){
            $('.spAddForm').on('keydown', function () {
                if(event.keyCode === 13) return false;
            });

            //保存数据
            $('.spAddForm').on('click','#addConfig',function () {
                var configName = $('#configName').val(),
                    tip = id ? '修改' : '添加';

                if(!configName){
                    toastr["error"]("请填写参数名称！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: id ? '/admin/product/configModify' : '/admin/product/configAdd',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        configId: id || '',
                        configName: configName
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'exist':
                                toastr["error"]("已存在相同名称的参数，无法" + tip + "！");
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

//绑定参数
function setConfig() {
    layer.open({
        type: 1,
        title: '配置参数',
        area: ['600px', '600px'],
        zIndex: 1500,
        content: '<form class="spAddForm">'+
        '<div class="form-group">'+
        '<label for="categoryId">产品分类</label>'+
        '<select class="form-control" id="categoryId">'+categoryHtml+'</select>'+
        '</div>'+
        '<div class="form-group">'+
        '<label>参数选择</label><br>'+configHtml+
        '</div>'+
        '<button type="button" class="btn btn-primary btn-block" id="setCategoryConfig">保存</button>'+
        '</form>',
        success: function(layero, index){
            $('.spAddForm').on('keydown', function () {
                if(event.keyCode === 13) return false;
            });

            //保存数据
            $('.spAddForm').on('change', '#categoryId', function () {
                var categoryId = $('#categoryId').val();

                $('input[name="configIpt"]').prop('checked', false);

                if(!categoryId) return false;

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
                        var arr = res.data;

                        $('input[name="configIpt"]').each(function(){
                            if(arr.indexOf(+$(this).val()) > -1){
                                $(this).prop('checked', true);
                            }
                        });
                    }
                });
            }).on('click','#setCategoryConfig',function () {
                var categoryId = $('#categoryId').val();

                if (!categoryId) return false;

                var configIds = '';

                $('input[name="configIpt"]').each(function(){
                    if(!$(this).prop('checked')) return true;
                    if(configIds) configIds += ',';
                    configIds += $(this).val();
                });

                if (!configIds) {
                    toastr["error"]("请选择参数！");
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: '/admin/product/setCategoryConfig',
                    headers: {
                        'X-CSRF-TOKEN': theToken
                    },
                    data: {
                        categoryId: categoryId,
                        configIds: configIds
                    },
                    success: function (res) {
                        switch (res.flag){
                            case 'success':
                                toastr["success"]("配置成功！");
                                break;
                            default:
                                toastr["error"]("配置失败！");
                                break;
                        }
                    }
                });
            });
        }
    });
}

//删除参数
function delConfig(obj) {
    if(!confirm('将同时删除所有产品对应的参数且数据不可恢复，确认删除所选数据吗？')) return false;

    $.ajax({
        type: 'post',
        url: '/admin/product/configDel',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            configId: $(obj).attr('data-value')
        },
        success: function (res) {
            switch (res.flag){
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

//提示框参数设置
function initToastr() {
    toastr.options = {
        "positionClass": "toast-top-center"
    };
}
