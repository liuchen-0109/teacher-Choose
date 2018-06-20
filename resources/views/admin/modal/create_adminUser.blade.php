
<div class="modal fade" tabindex="-1" role="dialog" id="create_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">新增/修改管理员</h4>
            </div>
            <div class="modal-body">
                <form id="adminUser_form">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>用户组</label>
                            <select name="type" class="form-control">
                                <option value="1">系统管理员</option>
                                <option value="2">前台管理员</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>用户名</label>
                            <input name="name" value="" class="form-control"  maxlength="15" minlength="2">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>密码</label>
                            <input type="password" name="password" value="" class="form-control" maxlength="15" minlength="6">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>重复密码</label>
                            <input type="password" name="repassword" value="" class="form-control" maxlength="15" minlength="6">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>姓名</label>
                            <input type="text" name="user_name" value="" class="form-control" maxlength="15" minlength="2">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>电话</label>
                            <input type="tel" name="mobile" value="" class="form-control" maxlength="11" >
                        </div>
                    </div>
                    <input type="hidden" name="id" value="">
                    {{csrf_field()}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="stroe_btn">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
