@extends('admin.layout.main')
@section('content')
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <form action="/admin/teacher/index" method="get">

                <div class="col-md-3" style="margin-left:50%">
                    <div class="form-group pull-right">
                        <div class="box-tools">
                            <div class="input-group">
                                <input type="text" name="word"
                                       class="form-control pull-right search_size" placeholder="请输入区域/城市名"
                                       value="{{$word}}">
                                <div class="input-group-btn">
                                    <input type="submit" style="height:50px" class="btn btn-default" value="搜索">
                                </div>
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                @if($word)
                    <a href="/admin/teacher/index" class="text-info">重置条件</a>
                @endif()
                <button class="btn btn-default btn-lg " id="create_btn" type="button">新增区域</button>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th style="width:20px"></th>
                                    <th>区域名称</th>
                                    <th>区域类型</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($cates->allChildrenCategory as  $cate)
                                    <tr>
                                        <td></td>
                                        <td>{{$cate->name}}</td>
                                        <td>{{$cate->type}}</td>
                                        <td>
                                            <a class="text-info" id="edit_btn"
                                               href="javascript:edit({{$cate->id}})">编辑</a>
                                            <a class="text-danger"
                                               href="javascript:deleteCategory({{$cate->id}})">删除</a>
                                        </td>
                                    </tr>
                                    @foreach($cate->allChildrenCategory as  $item)
                                        <tr>
                                            <td></td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;┠{{$item->name}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>
                                                <a class="text-info" id="edit_btn"
                                                   href="javascript:edit({{$item->id}})">编辑</a>
                                                <a class="text-danger"
                                                   href="javascript:deleteCategory({{$item->id}})">删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>

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
                                    @foreach($cates->allChildrenCategory as $cate)
                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach()
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-sm-6">
                                <label>上级分类</label>
                                <input name="name" value="" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="id" valus="">
                        {{csrf_field()}}
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="stroe_btn">保存</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <script>
        //新增教师时开启模态框
        $("#create_btn").bind('click', function () {
            $("#create_modal").modal('show');
        })

        $("#stroe_btn").bind('click', function () {
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
    </script>
@endsection