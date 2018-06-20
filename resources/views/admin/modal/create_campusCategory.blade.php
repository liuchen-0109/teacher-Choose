
<div class="modal fade" tabindex="-1" role="dialog" id="create_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">新增/修改区域</h4>
            </div>
            <div class="modal-body">
                <form id="campusCategory_form">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>上级分类</label>
                            <select name="pid" class="form-control">
                                <option value='1'>总部</option>
                                @if($cates)
                                @foreach($cates->allChildrenCategory as $cate)
                                    <option value="{{$cate->id}}">{{$cate->name}}</option>
                                @endforeach()
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-6">
                            <label>区域名称</label>
                            <input name="name" value="" class="form-control">
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
<script src="/js/admin/campusCategory_create.js" type="text/javascript"></script>