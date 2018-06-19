//新增校区时开启模态框
$("#create_btn").bind('click', function () {
    $("#create_modal").modal('show');
})

//保存数据
$("#stroe_btn").bind('click', function () {
    var pid = $("select[name='pid']").val();
    var name = $("input[name='name']").val();
    if (!name || !pid) {
        alert('请选择分类并填写区域名称')
        return;
    }
    loading2('处理中');
    $.ajax({
        url: '/admin/campusCategory/create',
        type: 'post',
        data: $('#campusCategory_form').serialize(),
        dataType: 'json',
        success: function (data) {
            if (data.ret == 1) {
                location.reload();
            } else {
                alert('操作失败')
                loading2('', 0);
            }
        },
        error: function () {
            alert('服务器链接失败');
            loading2('', 0);
        }
    })
})

//点击编辑按钮  查找信息并填入模态框
function edit(id) {
    $.ajax({
        url: '/admin/campusCategory/info/' + id,
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.name) $('input[name="name"]').val(data.name);
            if (data.id) $('input[name="id"]').val(data.id);
            if (data.pid) $('select[name="pid"]').val(data.pid);
            if(data.pid == 1){
                $('select[name="pid"]').attr('disabled','disabled');
            }
            $("#create_modal").modal('show');
        },
        error: function () {
            alert('服务器链接失败');
            loading2('', 0);
        }
    })
}

//删除分类
function deleteCategory(id) {
    var r = confirm('删除后数据无法恢复，请确认操作！');
    if(!r) return;
    loading2('处理中...');
    $.ajax({
        url: '/admin/campusCategory/delete/' + id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if(data.ret == 1){
                location.reload();
            }else{
                alert(data.msg);
                loading2('',0);
            }
        },
        error: function () {
            alert('服务器链接失败');
            loading2('', 0);
        }
    })
}

// 清除数据
$('body').on('hidden.bs.modal', '.modal', function () {
    document.getElementById("campusCategory_form").reset();
    $("input[name='id']").val();
    $('select[name="pid"]').removeAttr('disabled');
});
