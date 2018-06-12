$(function () {
    upload_headimg(); //头像上传初始化
    upload_photo();//照片上传初始化
    upload_voice();//语音简介初始化

    //控制数字input最大最小值的
    $("input[type=number]").bind('change', function () {
        var value = parseInt($(this).val());
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if (value > max) {
            $(this).val(max);
        } else if (value < min) {
            $(this).val(min);
        }

    })

    //新增教师时开启模态框
    $("#create_btn").bind('click', function () {
        $("#create_modal").modal('show');
    })

    //保存教师数据
    $("#store_btn").bind('click', function () {
        $.ajax({
            type: 'POST',
            url: '/admin/teacher/create',
            data: $('#teacher_form').serialize(),
            success: function (data) {
                if (data.ret > 0) {
                    location.href = '/admin/teacher/index';
                } else {
                    alert(data.msg);
                }
            },
            error: function (data) {
                alert('服务器连接失败，请重试');
            },
            dataType: 'json'
        });
    })

    // 清除数据
    $('body').on('hidden.bs.modal', '.modal', function () {
        document.getElementById("teacher_form").reset();
        $(".headimg_picture").attr('src', '/image/admin/admin.png');
        $("input[name='headimg_url']").val('');
        $("#photo_container").children('div').remove();
        $("#photo_container").find('input').remove();
    });

})

function deleteTeacher(id) {
    $r = confirm('确认删除教师数据？');
    if (!$r) return;
    $.ajax({
        type: 'get',
        url: '/admin/teacher/delete/' + id,
        success: function (data) {
            if (data.ret > 0) {
                location.href = '/admin/teacher/index';
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

//修改教师数据
function edit(id) {
    $.ajax({
        url: '/admin/teacher/teacherInfo/' + id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.headimg_url) {
                $(".headimg_picture").attr('src', data.headimg_url);
                $('input[name="headimg_url"]').val(data.headimg_url);
            }
            if (data.photos) {
                $.each(data.photos, function (index, element) {
                    if (element) {
                        var id = `photo_` + index + ``;
                        $photo = `<div class="img_container" id="` + id + `">
                                        <img  src="` + element + `" class="photo"  style="width:75px;height:75px">
                                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource('` + id + `')" >
                                        <input type='hidden' value="` + element + `" name="photos[]">
                                      </div>`;
                        $("#photo_container").append($photo);
                    }
                })
            }
            if (data.voices) {
                $.each(data.voices, function (index, element) {
                    if (element) {
                        var id = `voice_` + index + ``;
                        $voice = `<div class="img_container" id="` + id + `">
                                        <img  src="/image/admin/voice.png" class="voice" >
                                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource('` + id + `')" >
                                        <input type='hidden' value="` + element + `" name="voices[]">
                                      </div>`;
                        $("#photo_container").append($voice);
                    }
                })
            }
            $("input[name='id']").val(id);
            $("input[name='name']").val(data.name);
            $("input[name='mobile']").val(data.mobile);
            $("input[name='job_number']").val(data.job_number);
            $("input[name='email']").val(data.email);
            $("select[name='work_status']").val(data.work_status);
            $("select[name='level']").val(data.level);
            $("input[name='extend']").val(data.extend);
            $("input[name='logic']").val(data.logic);
            $("input[name='base']").val(data.base);
            $("input[name='habit']").val(data.habit);
            $("input[name='planning']").val(data.planning);
            $("input[name='strict']").val(data.strict);
            $("input[name='interaction']").val(data.interaction);
            $("input[name='humor']").val(data.humor);
            $("input[name='excellence']").val(data.excellence);
            $("input[name='passion']").val(data.passion);
            $("select[name='subject']").val(data.subject);
            $("input[name='emergency_contact']").val(data.emergency_contact);
            $("input[name='contact_mobile']").val(data.contact_mobile);
            $("select[name='compus']").val(data.compus);
            $("input[name='address']").val(data.address);
            $("select[name='sex']").val(data.sex);
            $("input[name='age']").val(data.age);
            $("input[name='birthday']").val(data.birthday);
            $("input[name='nation']").val(data.nation);
            $("input[name='political_status']").val(data.political_status);
            $("select[name='is_married']").val(data.is_married);
            $("input[name='native_place']").val(data.native_place);
            $("input[name='domicile']").val(data.domicile);
            $("input[name='id_number']").val(data.id_number);
            $("input[name='experience_age']").val(data.experience_age);
            $("input[name='college']").val(data.college);
            $("input[name='department']").val(data.department);
            $("select[name='education']").val(data.education);
            $("textarea[name='describe']").val(data.describe);
            $("textarea[name='particular']").val(data.particular);
            $("textarea[name='achievement']").val(data.achievement);
            $("#create_modal").modal('show');
        },
        error: function (data) {
            alert('请求失败');
        }
    })
}