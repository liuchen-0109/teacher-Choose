@extends("admin.layout.main")

@section("content")
    <!-- Main content -->
    <section class="content">
         <div class="row">
            <!-- small box -->
             @if($weather)
            <div style="width:65%;height:400px;border: 1px #ccc solid;padding:10px 30px;display: flex;margin-bottom:10px">
                <div>
                    <div>
                        <h3>{{$weather['basic']['parent_city']}}</h3>
                        更新时间{{$weather['update']['loc']}}
                    </div>
                    <div style="display: flex" style="margin-left:20%">
                        @foreach($weather['daily_forecast'] as $k=>$item)
                            <div style="margin:0 40px">
                            <div>
                                @if($k == 0 )
                                    今日
                                @else
                                    {{$item['date']}}
                                @endif
                            </div>
                            <div>
                                <span style="font-size: 30px">{{$item['tmp_max']}}°</span>{{$item['tmp_min']}}°
                            </div>
                                <div>
                                    {{$item['cond_txt_d']}} <img src="/image/weather/{{$item['cond_code_d']}}.png">
                                </div>
                                <div style="display: flex">
                                    <div style="margin:5px"> 风力 {{$item['wind_sc']}}</div>
                                    <div style="margin:5px"> 相对湿度 {{$item['hum']}}</div>

                                </div>
                                <div style="display: flex;align-content: space-between">
                                    <div style="margin:5px"> 风向 {{$item['wind_dir']}}</div>
                                    <div style="margin:5px"> 大气压强 {{$item['pres']}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div></div>
                    <div></div>
                </div>

            </div>
                 @endif


        </div>
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