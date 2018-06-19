$(function(){
    upload_excel();
    $('#create_btn').bind('click',function(){
        $("#create_modal").modal('show');
    });
    $('#store_btn').bind('click',function(){
        $name = $("#info_container").children("input").val();
        if(!$name){
            alert('请上传课表');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/admin/excel/check',
            data: $('#create_form').serialize(),
            success: function (data) {
                if (data.ret > 0) {
                    create()
                } else {
                   var r =  confirm('课表已存在，确定重新上传并覆盖原有课表？');
                   if(!r) return;
                    create();
                }
            },
            error: function (data) {
                alert('服务器连接失败，请重试');
            },
            dataType: 'json'
        });
    });

    // 清除数据
    $('body').on('hidden.bs.modal', '.modal', function () {
        $("#info_container").children("span").html('');
        $("#info_container").children("input").val('');
        $('select[name="year"]').prop('selectedIndex', 0);
        $('select[name="season"]').prop('selectedIndex', 0);
        $('select[name="type"]').prop('selectedIndex', 0);

    });

})


function create(){
    $.ajax({
        type: 'POST',
        url: '/admin/excel/create',
        data: $('#create_form').serialize(),
        success: function (data) {
            if (data.ret > 0) {
                location.href = '/admin/excel/index';
            } else {
                alert(data.msg);
            }
        },
        error: function (data) {
            alert('服务器连接失败，请重试');
        },
        dataType: 'json'
    });
}
function upload_excel() {
    excel_upload = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        //可重复上传
        duplicate: true,

        // swf文件路径
        swf: '/WebUploader/Uploader.swf',

        // 文件接收服务端。
        server: '/api/upload_excel',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#excel_upload',

    });

    excel_upload.on('uploadSuccess', function (file, data) {
        loading2('', 0);
        if(data.ret == 0){
            alert(data.msg);
        }else{
            $("#info_container").children("span").html(file.name);
            $("#info_container").children("input").val(file.name);
        }


    });

    // 文件上传过程中创建进度条实时显示。
    excel_upload.on('uploadProgress', function (file, percentage) {
        loading2('上传中');
    });

// 文件上传失败，显示上传出错。
    excel_upload.on('uploadError', function (file) {
        loading2('',0);
        alert('上传失败');
    });
}

function deleteExcel(id) {
    $r = confirm('删除后数据不可恢复，确认删除数据？');
    if (!$r) return;
    $.ajax({
        type: 'get',
        url: '/admin/excel/delete/' + id,
        success: function (data) {
            if (data.ret > 0) {
                location.href = '/admin/excel/index';
            } else {
                alert('操作失败');
            }
        },
        error: function (data) {
            alert('请求失败');
        },
        dataType: 'json'
    });
}
