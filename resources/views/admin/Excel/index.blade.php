@extends("admin.layout.main")
@section("content")
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <form id="excel_form" action="/admin/excel/index" method="get">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true" name="year" onchange="$('#excel_form').submit()">
                                <option value="">全部年份</option>
                                <option value="{{$years[0]-1}}" @if( $year == $years[0]-1) selected @endif>{{$years[0]-1}}</option>
                                @foreach($years as $item)
                                <option value="{{$item}}" @if( $year == $item) selected @endif>{{$item}}</option>
                                @endforeach
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="season" class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true" onchange="$('#excel_form').submit()">
                                <option value="">全部季节</option>
                                <option value="春季" @if( $season == '春季') selected @endif>春季</option>
                                <option value="暑期" @if( $season == '暑期') selected @endif>暑期</option>
                                <option value="秋季" @if( $season == '秋季') selected @endif>秋季</option>
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="type" class="form-control select2 select2-hidden-accessible search_size"
                                    tabindex="-1" aria-hidden="true" onchange="$('#excel_form').submit()">
                                <option value="">全部学部</option>
                                <option value="小学数学" @if( $type == '小学数学') selected @endif>小学数学</option>
                                <option value="初中数学" @if( $type == '初中数学') selected @endif>初中数学</option>
                                <option value="初中物理" @if( $type == '初中物理') selected @endif>初中物理</option>
                            </select>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    @if($year || $season || $type)
                        <a href="/admin/excel/index" class="text-info">重置条件</a>
                    @endif()
                    <button class="btn btn-default btn-lg" type="button" id="create_btn" style="margin-left:10px">新增课表</button>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>年份</th>
                                    <th>季节</th>
                                    <th>学部</th>
                                    <th>老师数</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($excels as  $excel)
                                    <tr>
                                        <td>{{$excel->year}}</td>
                                        <td>{{$excel->season}}</td>
                                        <td>{{$excel->type}}</td>
                                        <td>1</td>
                                        <td>
                                            @if($excel->status == 1)
                                                启用
                                            @else
                                                冻结
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-danger"
                                               href="javascript:deleteExcel({{$excel->id}})">删除</a>
                                            <a class="text-muted" href="/admin/excel/changeStatus/{{$excel->id}}/">
                                                @if($excel->status == 1)
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
            {{$excels->links()}}
        </div>
    </div>
    @include('admin.modal.create_excel')
@endsection