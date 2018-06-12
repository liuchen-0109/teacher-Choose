function upload_headimg() {
    headimg_upload = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,
        //可重复上传
        duplicate :true,
        // swf文件路径
        swf: '/WebUploader/Uploader.swf',

        // 文件接收服务端。
        server: '/api/upload_img',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#headimg_upload',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'jpg,png',
            mimeTypes: 'image/*'
        }
    });


    headimg_upload.on( 'uploadSuccess', function( file,data ) {
        loading2('',0);
     if(data.ret == 1){
         $('#headimg_container').find('img').attr('src',data.path);
         $('input[name = "headimg_url"]').val(data.path);
     }else{
         alert('上传失败，请重试');
     }
    });

// 文件上传失败，显示上传出错。
    headimg_upload.on('uploadError', function (file) {
       alert('上传失败，请重试');
    });

}

function upload_photo() {
    photo_upload = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,
        //可重复上传
        duplicate :true,
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
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    // 当有文件添加进来的时候
    photo_upload.on('fileQueued', function (file) {
        // $list为容器jQuery实例
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        photo_upload.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img = `<div class="img_container" id="photo_`+file.id+`">
                        <img  src="`+src+`" class="photo" >
                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource('photo_`+file.id+`')" >
                        <input type="hidden" name="photos[]" value="">
                    </div>`;
            $("#photo_container").append($img)
        }, 75, 75);
    });
    photo_upload.on( 'uploadSuccess', function( file,data ) {
        loading2('',0);
        $("#photo_"+file.id).children("input").val(data.path)

    });

// 文件上传过程中创建进度条实时显示。
    photo_upload.on( 'uploadProgress', function( file, percentage ) {
        loading2('上传中');
    });

// 文件上传失败，显示上传出错。
    photo_upload.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // // 避免重复创建
        // if (!$error.length) {
        //     $error = $('<div class="error"></div>').appendTo($li);
        // }

        $error.text('上传失败');
    });

}

function upload_voice() {
    voice_upload = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        //可重复上传
        duplicate :true,
        // swf文件路径
        swf: '/WebUploader/Uploader.swf',

        // 文件接收服务端。
        server: '/api/upload_img',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#voice_upload',

        // 只允许选择mp3文件。
        accept: {
            title: 'voice',
            extensions: 'mp3',
            mimeTypes: 'audio/mp3'
        }
    });

    // 当有文件添加进来的时候
    voice_upload.on('fileQueued', function (file) {

        $img = `<div class="img_container" id="voice_`+file.id+`">
                        <img  src="/image/admin/voice.png" class="voice" >
                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource('voice_`+file.id+`')" >
                        <input type="hidden" name="voices[]" value="">
                    </div>`;
        $("#photo_container").append($img);

    });

    voice_upload.on( 'uploadSuccess', function( file,data) {
        loading2('',0);
        $("#voice_"+file.id).children("input").val(data.path);

    });

// 文件上传过程中创建进度条实时显示。
    voice_upload.on( 'uploadProgress', function( file, percentage ) {
        loading2('上传中');
    });

// 文件上传失败，显示上传出错。
    voice_upload.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }
        $error.text('上传失败');
    });

}

//删除上传图片/语音
function delete_resource(id) {
    $('#'+id).remove();
}




