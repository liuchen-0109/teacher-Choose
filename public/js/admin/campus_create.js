//新增教师时开启模态框
$("#create_btn").bind('click', function () {
    $("#create_modal").modal('show');
})

$(function(){
    upload_photo()
})

$("#store_btn").bind('click', function () {
    loading2('处理中...');
    $.ajax({
        url: '/admin/campus/create',
        type: 'post',
        data: $('#campus_form').serialize(),
        dataType: 'json',
        success: function (data) {
            if (data.ret == 1) {
                location.reload();
            } else {
                alert(data.msg)
                loading2('', 0);
            }
        },
        error: function () {
            alert('服务器链接失败');
            loading2('', 0);
        }
    })
})

function edit(id) {
    loading2('处理中...');
    $.ajax({
        url: '/admin/campus/info/' + id,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.id) $('input[name="id"]').val(data.id);
            if (data.name) $('input[name="name"]').val(data.name);
            if (data.pid) $('select[name="pid"]').val(data.pid);
            if (data.province) {
                $('select[name="province"]').val(data.province);
                $('select[name="province"]').trigger('change');
            }
            if (data.city) {
                $('select[name="city"]').val(data.city);
                $('select[name="city"]').trigger('change');
            }
            if (data.district) $('select[name="district"]').val(data.district);
            if (data.address) $('input[name="address"]').val(data.address);
            if (data.tel) $('input[name="tel"]').val(data.tel);
            if (data.lng && data.lat) {
                deleteOverlays()
                map.panTo(new qq.maps.LatLng(data.lat, data.lng));
                addMarker(new qq.maps.LatLng(data.lat, data.lng));
                $('input[name="lng"]').val(data.lng);
                $('input[name="lat"]').val(data.lat);
            }
            if(data.photo) {
                $('input[name = "photo"]').val(data.photo);
                var img = `<img src="`+data.photo+`" style="width: 110px;height:80px">`;
                $('#photo_container').append(img);

            }

            loading2('',0);
            $("#create_modal").modal('show');

        },
        error: function () {
            loading2('',0);

            alert('服务器连接失败');
        }
    })
}

// 清除数据
$('body').on('hidden.bs.modal', '.modal', function () {
    document.getElementById("campus_form").reset();
    $('select[name="province"]').trigger('change');
    $('select[name="city"]').trigger('change');
    $('#photo_container').find('img').remove();
    $('input[name = "photo"]').val('');
});

function deleteCampus(id){
    var r = confirm('删除后数据无法恢复，请确认操作');
    if(!r) return;
    loading2('处理中...');
    $.ajax({
        url:'/admin/campus/delete/'+id,
        type:'post',
        dataType:'json',
        success:function(data){
            if(data.ret == 1){
                location.reload();
            }else{
                loading2('',0);
                alert('操作失败');
            }
        },
        error:function(){
            loading2('',0);
            alert('服务器连接失败');
        }
    })
}

function upload_photo() {
    photo_upload = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        //可重复上传
        duplicate: true,

        // swf文件路径
        swf: '/WebUploader/Uploader.swf',

        // 文件接收服务端。
        server: '/api/upload_img',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#photo_upload',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'jpg,png',
            mimeTypes: 'image/*'
        }

    });

    photo_upload.on('uploadSuccess', function (file, data) {
        loading2('', 0);
        if (data.ret == 1) {
            $('#photo_container').find('img').remove();
            var img = `<img src="`+data.path+`" style="width: 110px;height:80px">`;
            $('#photo_container').append(img);
            $('input[name = "photo"]').val(data.path);
        } else {
            alert('上传失败，请重试');
        }
    });

    // 文件上传过程中创建进度条实时显示。
    photo_upload.on('uploadProgress', function (file, percentage) {
        loading2('上传中');
    });

// 文件上传失败，显示上传出错。
    photo_upload.on('uploadError', function (file) {
        loading2('', 0);
        alert('上传失败');
    });
}