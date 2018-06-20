//新增教师时开启模态框
$("#create_btn").bind('click', function () {
    $("#create_modal").modal('show');
})

$(function () {
    $("#stroe_btn").bind('click', function () {
        var password = $("input[name='password']").val();
        var repassword = $("input[name='repassword']").val();
        var name = $("input[name='name']").val();
        var user_name = $("input[name='user_name']").val();
        var mobile = $("input[name='mobile']").val();
        if (!name) {
            alert('姓名不能为空！');
            return;
        } else if (!password || !repassword) {
            alert('请输入密码！');
            return;
        } else if (repassword !== password) {
            alert('两次密码输入不一致');
            return;
        } else if (!user_name) {
            alert('用户名不能为空！');
            return;
        } else if (!mobile) {
            alert('电话不能为空！');
            return;
        }else if(!check(password)){
            alert('密码必须包含字母和数子的组合！')
            return;
        }
        loading2('处理中');
        $.ajax({
            url: '/admin/user/create',
            type: 'post',
            data: $('#adminUser_form').serialize(),
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

    // 清除数据
    $('body').on('hidden.bs.modal', '.modal', function () {
        document.getElementById("adminUser_form").reset();
    });
})
function check(str)
{
    var str = str;
    var reg = new RegExp(/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/);
    if (reg.test(str)) {
        return true;
    } else {
        return false;
    }
}

 function deleteAdminUser(id){
     $r = confirm('删除后数据不可恢复，确认删除数据？');
     if (!$r) return;
     loading2('处理中...');
     $.ajax({
         type: 'get',
         url: '/admin/user/delete/' + id,
         success: function (data) {
             if (data.ret > 0) {
                 location.href = '/admin/user/index';
             } else {
                 alert(data.msg);
                 loading2('', 0);
             }
         },
         error: function (data) {
             alert('请求失败');
             loading2('', 0);
         },
         dataType: 'json'
     });
}

function edit(id) {
    loading2('处理中...');
    $.ajax({
        url: '/admin/user/info/' + id,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.id) $('input[name="id"]').val(data.id);
            if (data.name) $('input[name="name"]').val(data.name);
            if (data.type) $('select[name="type"]').val(data.type);
            if (data.user_name) $('input[name="user_name"]').val(data.user_name);
            if (data.mobile) $('input[name="mobile"]').val(data.mobile);
            loading2('',0);
            $("#create_modal").modal('show');
        },
        error: function () {
            loading2('',0);
            alert('服务器连接失败');
        }
    })
}