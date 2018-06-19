@extends('admin.layout.main')
@section('content')
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-header">
            <button class="btn btn-default btn-lg " style="margin-left:75%" id="create_btn" type="button">新增区域</button>
        </div>
        <div class="box-body">
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
    @include('admin.modal.create_campusCategory')
@endsection