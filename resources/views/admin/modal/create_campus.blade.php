<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="create_modal">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">新增/编辑教师</h4>
            </div>
            <div class="modal-body">
                <form id="campus_form">
                    <input type="hidden" name="id" value="">
                    <div style="margin:0 auto">
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>组织架构</label>
                                <select class="form-control" name="pid" data-placeholder="选择市区">
                                    @if($cates)
                                        @foreach($cates->allChildrenCategory as $cate)
                                            @foreach($cate->allChildrenCategory as $item)
                                                <option value="{{$item->id}}">总部 -{{$cate->name}}
                                                    - {{$item->name}}</option>

                                            @endforeach
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>校区名称</label>
                                <input type="text" name="name" class="form-control" placeholder="请输入..."
                                       maxlength="12">
                            </div>
                        </div>
                        <label>地址选择</label>
                        <div class="row row_container">

                            <div class="col-md-4">
                                <select name="province" class="form-control" onchange="GetArea('province','city');">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="city" class="form-control" onchange="GetArea('city','district');">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="district" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>详细地址</label>
                                <input type="text" name="address" class="form-control" placeholder="请输入..."
                                       maxlength="50">
                            </div>
                        </div>
                        <div class="row row_container">
                            <div class="col-md-12">
                                <label>联系电话</label>
                                <input type="tel" name="tel" class="form-control" placeholder="请输入..."
                                       maxlength="11">
                            </div>
                        </div>
                        {{csrf_field()}}
                    </div>
                    <label>地图定位</label>
                    <input type="hidden" name="lat">
                    <input type="hidden" name="lng">
                    <div id="container" style="height:300px;width: 100%;"></div>
                    <input type="hidden" name="id" val="">
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button id="store_btn" type="button" class="btn btn-primary">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script src="/js/area.js" type="text/javascript"></script>
<script src="/js/map.js" type="text/javascript"></script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script charset="utf-8" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js "></script>
<script>
    AreaInit();
    //调用初始化函数地图
    init();

</script>



