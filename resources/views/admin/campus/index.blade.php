@extends("admin.layout.main")
@section("content")
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <form action="/admin/campus/index" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="pid" class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">全部区域</option>
                                @if($cates)
                                @foreach($cates->allChildrenCategory as $cate)
                                    <option value="{{$cate->id}}"  disabled><b>{{$cate->name}}</b></option>
                                    @foreach($cate->allChildrenCategory as $item)
                                        <option value="{{$item->id}}" @if($pid == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                @endforeach
                                    @endif
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="box-tools">
                                <div class="input-group">
                                    <input type="text" name="word"
                                           class="form-control pull-right search_size" placeholder="请输入校区名称"
                                           value="{{$word}}">
                                    <div class="input-group-btn">
                                        <input type="submit" style="height:50px" class="btn btn-default" value="搜索">
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    @if($pid || $word )
                        <a href="/admin/campus/index" class="text-info">重置条件</a>
                    @endif()
                    <button class="btn btn-default btn-lg" id="create_btn" type="button" style="margin-left:10px">新增校区</button>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>校区名称</th>
                                    <th>上级组织</th>
                                    <th>行政区域</th>
                                    <th>详细地址</th>
                                    <th>电话</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($campus as  $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->parent->name}}</td>
                                        <td>{{$item->getProvince->name}}/{{$item->getCity->name}}/{{$item->getDistrict->name}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->tel}}</td>
                                        <td>{{$item->created_at}}</td>

                                        <td>
                                            <a class="text-info" id="edit_btn" href="javascript:edit({{$item->id}})">编辑</a>
                                            <a class="text-danger"
                                               href="javascript:deleteCampus({{$item->id}})">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            {{$campus->links()}}
        </div>
    </div>
    @include('admin.modal.create_campus')
    <script src="/js/admin/campus_create.js" type="text/javascript"></script>
@endsection