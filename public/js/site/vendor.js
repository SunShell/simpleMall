var theToken,
    imagePath;

$(function () {
    theToken = $('#theToken').val();
    imagePath = $('#imagePath').val();

    $('#queryBtn').on('click', queryVendor);
});

function queryVendor(){
    var vendorNumber = $('#vendorNumber').val().trim(),
        vendorName = $('#vendorName').val().trim();

    if(!vendorNumber || !vendorName){
        alert('请同时输入经销商编号和名称！');
        return false;
    }

    $.ajax({
        type: 'post',
        url: '/service/getVendor',
        headers: {
            'X-CSRF-TOKEN': theToken
        },
        data: {
            vendorNumber: vendorNumber,
            vendorName: vendorName
        },
        success: function (res) {
            dealData(res);
        }
    });
}

function dealData(obj) {
    var html = '';

    if(obj.flag === 'no'){
        html = '<p>对不起，您查询的经销商不是大上签约的经销商</p>';
    }else{
        html = '<img src="'+getDatePath(obj.data.image,obj.data.created_at)+'">';
    }

    $('#queryRes').html(html);
}

function getDatePath(val,tm) {
    var tmp,
        arr = val.split(',');

    tmp = '/' + tm.substring(0,4) + '/' + +tm.substring(5,7) + '/' + +tm.substring(8,10) + '/';

    return imagePath + tmp + arr[0];
}