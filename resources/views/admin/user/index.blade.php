@extends("admin.layout.main")
@section("content")
    <div class="box box-default">
        <div class="box-header">
            <button class="btn btn-default btn-lg pull-right" id="create_btn" type="button" style="margin-right:20%">新增管理员</button>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>姓名</th>
                                    <th>用户名</th>
                                    <th>电话</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($users as  $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->user_name}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>
                                            @if($user->type == 1)
                                                后台管理员
                                                @elseif($user->type == 2)
                                                前台管理员
                                            @endif</td>
                                        <td>
                                            <a class="text-info" id="edit_btn" href="javascript:edit({{$user->id}})">编辑</a>
                                            <a class="text-danger"
                                               href="javascript:deleteAdminUser({{$user->id}})">删除</a>
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
            {{$users->links()}}
        </div>
    </div>
    @include('admin.modal.create_adminUser')
    <script type="text/javascript" src="/js/admin/adminUser_create.js"></script>
@endsection