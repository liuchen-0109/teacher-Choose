<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="create_modal">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">课表导入</h4>
            </div>
            <div class="modal-body">
                <form id="create_form">
                    <div class="row row_container" >
                        <div class="col-md-2">
                                <div id="excel_upload" class="filePicker" style="top:0px">上传</div>
                        </div>
                        <div class="col-md-5" id="info_container">
                            <span></span>
                            <input type="hidden" value="" name="name">
                        </div>
                    </div>
                    <div class="row row_container">
                        <div class="col-md-3">
                            <select name="year" id="" class="form-control">
                                @foreach($years as $item)
                                    <option value="{{$item}}" >{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="season" id="season" class="form-control">
                                <option value="春季">春季</option>
                                <option value="暑期">暑期</option>
                                <option value="秋季">秋季</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value="小学数学">小学数学</option>
                                <option value="初中数学">初中数学</option>
                                <option value="初中物理">初中物理</option>
                            </select>
                        </div>
                    </div>
                    {{csrf_field()}}
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button id="store_btn" type="button" class="btn btn-primary">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/js/admin/excel_create.js"></script>


