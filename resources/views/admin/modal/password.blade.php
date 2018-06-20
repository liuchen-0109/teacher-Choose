
<div class="modal fade" tabindex="-1" role="dialog" id="password_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <form id="password_form">
                    <input  name="name" class="form-control" type="hidden" value="{{\Auth::guard("admin")->user()->name}}">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>旧密码</label>
                           <input  name="password" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>新密码</label>
                            <input name="newpassword" value="" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>确认新密码</label>
                            <input name="repassword" value="" class="form-control" type="password">
                        </div>
                    </div>
                    {{csrf_field()}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="password_btn" onclick="storePassword({{\Auth::guard("admin")->user()->id}})">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>