<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            @if(\Auth::guard("admin")->user()->type == 0 || \Auth::guard("admin")->user()->type == 1)
            <li><a href="/admin/teacher/index"><i class="fa fa-book"></i> <span>教师管理</span></a></li>
            <li><a href="/admin/excel/index"><i class="fa fa-book"></i> <span>课表管理</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>校区管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/campusCategory/index">区域管理</a></li>
                    <li><a href="/admin/campus/index">校区管理</a></li>
                </ul>
            </li>
            @endif
            @if(\Auth::guard("admin")->user()->type == 0)
                <li><a href="/admin/user/index"><i class="fa fa-book"></i> <span>权限管理</span></a></li>

            @endif

        </ul>
    </section>
</aside>

