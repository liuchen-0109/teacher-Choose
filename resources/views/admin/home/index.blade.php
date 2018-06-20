@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- small box -->
            <div style="width:50%;height:300px;border: 1px #ccc solid;padding:10px;display: flex">
                <div>
                    <h3>前台登录密码 ：{{$password->password}}</h3>
                    <h5>更新时间 ：{{$password->created_at}}</h5>
                </div>
                <div>
                    <a class="btn btn-default" style="margin: 15px 70px;" href="/admin/password">强制更新</a>
                </div>
            </div>


        </div>
    </section>
@endsection