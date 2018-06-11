@extends("admin.layout.main")
@section("content")
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <form action="/admin/teacher/index" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true" name="compus">
                                <option value="">选择学校</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="subject" class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">科目不限</option>
                                <option value="数学" @if($subject == '数学') selected @endif>数学</option>
                                <option value="英语" @if($subject == '英语') selected @endif>英语</option>
                                <option value="语文" @if($subject == '语文') selected @endif>语文</option>
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="box-tools">
                                <div class="input-group">
                                    <input type="text" name="word"
                                           class="form-control pull-right search_size" placeholder="请输入教师姓名/手机号"
                                           value="{{$word}}">
                                    <div class="input-group-btn">
                                        <input type="submit" style="height:50px" class="btn btn-default" value="搜索">
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    @if($subject || $compus || $word)
                        <a href="/admin/teacher/index" class="text-info">重置条件</a>
                    @endif()
                    <button class="btn btn-default btn-lg" id="create_btn" type="button" style="margin-left:10px">新增教师</button>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>姓名</th>
                                    <th>工号</th>
                                    <th>科目</th>
                                    <th>手机号</th>
                                    <th>所属校区</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($teachers as  $teacher)
                                    <tr>
                                        <td>{{$teacher->name}}</td>
                                        <td>{{$teacher->job_number}}</td>
                                        <td>{{$teacher->subject}}</td>
                                        <td>{{$teacher->mobile}}</td>
                                        <td>{{$teacher->compus}}</td>
                                        <td>
                                            @if($teacher->status == 1)
                                                启用
                                            @else
                                                冻结
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-info" id="edit_btn" href="javascript:edit({{$teacher->id}})">编辑</a>
                                            <a class="text-danger"
                                               href="javascript:deleteTeacher({{$teacher->id}})">删除</a>
                                            <a class="text-muted" href="/admin/teacher/changeStatus/{{$teacher->id}}/">
                                                @if($teacher->status == 1)
                                                    冻结
                                                @else
                                                    启用
                                                @endif
                                            </a>
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
            {{$teachers->links()}}
        </div>
    </div>
    @include('admin.modal.create_teacher')
    <link rel="stylesheet" type="text/css" href="/WebUploader/webuploader.css">

    <!--引入JS-->
    <script type="text/javascript" src="/WebUploader/webuploader.js"></script>
    <div id="uploader-demo">
        <!--用来存放item-->
        <div id="fileList" class="uploader-list"></div>
        <input type="file">
        <div id="filePicker" class="webuploader-pick">选择图片</div>
    </div>

    <script>

        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '/WebUploader/Uploader.swf',

            // 文件接收服务端。
            server: 'http://webuploader.duapp.com/server/fileupload.php',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

    </script>
@endsection