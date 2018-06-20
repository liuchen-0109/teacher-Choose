//新增教师时开启模态框
$("#create_btn").bind('click', function () {
    $("#create_modal").modal('show');
})


$("#store_btn").bind('click', function () {
    $.ajax({
        url: '/admin/campus/create',
        type: 'post',
        data: $('#campus_form').serialize(),
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