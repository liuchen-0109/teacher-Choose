@extends("admin.layout.main")
@section("content")
    <style type="text/css">
        #campus_main_container {
            display: flex;
        }

        #main_container_left {
            width: 20%;
        }

        #main_container_right {
            width: 80%;
        }

        li {
            list-style-type: none;
        }

        #main_container_left a {
            text-decoration: none;
            color: black;
            display: block;
            height: 25px;
            line-height: 25px;
            width: 53%;

        }

        #main_container_left {
            position: relative;
        }

        #campus_btn_container {
            display: flex;
            flex-direction: column;
            position: absolute;
            right: 0px;
            top: -5px;
        }

        #campus_btn_container div {
            margin: 5px;

        }
    </style>
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <button class="btn btn-default btn-lg pull-right" id="create_btn" type="button"
                        style="margin-right:30px">
                    新增校区
                </button>
            </div>
        </div>
    </div>
    {{--主区域--}}
    <div id="campus_main_container">
        <div id="main_container_left">
            <div id="campus_btn_container">
                <div>
                    <btn  onclick="location.href='/admin/campusCategory/index'" class="btn btn-xs btn-default"> 区域管理</btn>
                </div>
            </div>
            <ul class="tree" data-widget="tree">
                <li class="treeview">
                    <a href="#">
                        {{--<div style="height:35px;line-height: 35px">--}}
                        <span>总部</span>
                        <span class="pull-right-container" style="margin-left: 59px">
                            <img src="/image/admin/u933.png">
                            {{--<i class="fa  fa-chevron-down pull-right"></i>--}}
                        </span>
                    </a>

                        <ul class="treeview-menu" style="display:none;">
                            @foreach($cates->allChildrenCategory as $cate)
                        <li class="treeview">
                            <a href="#">
                                <span>{{$cate->name}}</span>
                                <span class="pull-right-container" style="margin-left: 10px">
                                   <img src="/image/admin/u933.png">
                                </span>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                @foreach($cate->allChildrenCategory as $item)
                                <li class="treeview">
                                    <a href="#"></i> {{$item->name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                        </li>
                            @endforeach
                    </ul>

                </li>
            </ul>
        </div>
        <div id="main_container_right">
        </div>
    </div>



@endsection