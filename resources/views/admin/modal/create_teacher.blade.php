<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="create_modal">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">新增/编辑教师</h4>
            </div>
            <div class="modal-body">
                <form id="teacher_form">
                    <input type="hidden" name="id" value="">
                    <div>
                        <p><h4>基本信息</h4></p>
                        <div class="row row_container">
                            <div class="col-md-12" style="display:flex">
                                <div id="uploader-demo">
                                    <!--用来存放item-->
                                    <div id="headimg_container" style="margin-right:15px">
                                        <img src="/image/admin/admin.png" class="headimg_picture"
                                             style="width: 75px;height:75px">
                                        <input name="headimg_url" type="hidden" value="">
                                    </div>
                                </div>
                                {{--更改头像按钮--}}
                                <div class="filePicker_container pull-right">
                                    <div id="headimg_upload" class="filePicker" style="margin-right:5px">更改头像</div>
                                </div>
                                <div id="photo_container">
                                </div>
                                {{--添加生活照按钮--}}
                                <div class="filePicker_container pull-right">
                                    <div id="photo_upload" class="filePicker" style="margin:0 5px">添加生活照</div>
                                </div>
                                {{--添加语音按钮--}}
                                <div class="filePicker_container pull-right" style="text-align: right;">
                                    <div id="voice_upload" class="filePicker">添加语音</div>
                                </div>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>姓名</label>
                                <input type="text" name="name" class="form-control " placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>手机号</label>
                                <input type="text" name="mobile" class="form-control" placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>工号</label>
                                <input type="text" name="job_number" class="form-control" placeholder="请输入..."
                                       maxlength="8">
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>邮箱</label>
                                <input type="email" name="email" class="form-control" placeholder="请输入...">
                            </div>
                            <div class="col-md-4">
                                <label>岗位性质</label>
                                <select name="work_status" class="form-control">
                                    <option value="全职">全职</option>
                                    <option value="兼职">兼职</option>
                                    <option value="特聘">特聘</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>级别</label>
                                <select name="level" class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-2 sign_input_container">
                                <label>拓展</label>
                                <div class="input-group">
                                    <input type="number" name="extend" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>逻辑</label>
                                <div class="input-group">
                                    <input type="number" name="logic" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>基础</label>
                                <div class="input-group">
                                    <input type="number" name="base" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>习惯</label>
                                <div class="input-group sing_input">
                                    <input type="number" name="habit" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>规划</label>
                                <div class="input-group sing_input">
                                    <input type="number" name="planning" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-2 sign_input_container">
                                <label>严格</label>
                                <div class="input-group">
                                    <input type="number" name="strict" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>互动</label>
                                <div class="input-group">
                                    <input type="number" name="interaction" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>幽默</label>
                                <div class="input-group">
                                    <input type="number" name="humor" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>专业</label>
                                <div class="input-group sing_input">
                                    <input type="number" name="excellence" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 sign_input_container">
                                <label>激情</label>
                                <div class="input-group sing_input">
                                    <input type="number" name="passion" value="0" class="form-control"
                                           style="width: 70px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn sign_btn"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn sign_btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>授课科目</label>
                                <select name="subject" class="form-control">
                                    <option value="数学">数学</option>
                                    <option value="化学">化学</option>
                                    <option value="物理">物理</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>紧急联系人</label>
                                <input name="emergency_contact" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>联系人电话</label>
                                <input name="contact_mobile" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="12">
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>所属校区</label>
                                <select name="compus" class="form-control">
                                    <option>选择校区</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>详细住址</label>
                                <input name="address" type="text" placeholder="请输入" class="form-control" maxlength="50">
                            </div>
                        </div>
                        {{--更多信息--}}
                        <p><h4>更多信息</h4></p>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>性别</label>
                                <select name="sex" class="form-control">
                                    <option value="男">男</option>
                                    <option value="女">女</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>年龄</label>
                                <input name="age" type="number" class="form-control" placeholder="请输入...">
                            </div>
                            <div class="col-md-4">
                                <label>出生日期</label>
                                <input name="birthday" type="date" class="form-control" placeholder="请输入...">
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>民族</label>
                                <input name="nation" type="text" class="form-control " placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>政治面貌</label>
                                <input name="political_status" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>婚姻状况</label>
                                <select name="is_married" class="form-control">
                                    <option value="已婚">已婚</option>
                                    <option value="未婚">未婚</option>
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>籍贯</label>
                                <input name="native_place" type="text" class="form-control " placeholder="请输入..."
                                       maxlength="12">
                            </div>
                            <div class="col-md-4">
                                <label>户籍所在地</label>
                                <input name="domicile" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="50">
                            </div>
                            <div class="col-md-4">
                                <label>身份证号</label>
                                <input name="id_number" type="text" style="text-transform:uppercase"
                                       class="form-control"
                                       placeholder="请输入..." maxlength="18">
                            </div>
                        </div>
                        {{--教师资历--}}
                        <p><h4>教师资历</h4></p>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>教师年限</label>
                                <input name="experience_age" type="number" class="form-control " placeholder="请输入...">
                            </div>
                            <div class="col-md-4">
                                <label>毕业院校</label>
                                <input name="college" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="50">
                            </div>
                            <div class="col-md-4">
                                <label>专业</label>
                                <input name="department" type="text" class="form-control" placeholder="请输入..."
                                       maxlength="50">
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-4">
                                <label>最高学历</label>
                                <select name="education" id="" class="form-control">
                                    <option valur="博士后">博士后</option>
                                    <option value="博士">博士</option>
                                    <option value="硕士">硕士</option>
                                    <option value="本科">本科</option>
                                    <option value="大专">大专</option>
                                    <option value="高中及中专">高中及中专</option>
                                    <option value="小学">小学</option>
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>教师简介</label>
                                <textarea name="describe" placeholder="请输入..." class="form-control" rows="3"
                                          maxlength="1000"></textarea>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>教学特点</label>
                                <textarea name="particular" placeholder="请输入..." class="form-control" rows="3"
                                          maxlength="1000"></textarea>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>教学成果</label>
                                <textarea name="achievement" placeholder="请输入..." class="form-control" rows="3"
                                          maxlength="1000"></textarea>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button id="store_btn" type="button" class="btn btn-primary">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script src="/js/adminUploader/uploader.js" type="text/javascript"></script>
<script>
    $(function () {
        upload_headimg();
        upload_photo();
        upload_voice();
    })

    $("#create_btn").bind('click', function () {

        $("#create_modal").modal('show');
    })

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
                            $photo = `<div class="img_container" >
                                        <img  src="` + element + `" class="photo"  style="width:75px;height:75px">
                                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource()" >
                                        <input type='hidden' value="`+element+`" name="photos[]">
                                      </div>`;
                            $("#photo_container").append($photo);
                        }
                    })
                }
                if (data.voices) {
                    $.each(data.voices, function (index, element) {
                        if (element) {
                            $voice = `<div class="img_container" >
                                        <img  src="/image/admin/voice.png" class="voice" >
                                        <img  src="/image/admin/delete.png" class="delete" onclick="delete_resource()" >
                                        <input type='hidden' value="`+element+`" name="voices[]">
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
</script>
