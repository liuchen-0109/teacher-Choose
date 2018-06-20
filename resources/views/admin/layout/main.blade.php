<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>平行线VIP后台管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/adminlte/dist/css/skins/_all-skins.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/css/admin.css">
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/WebUploader/webuploader.css">


    <!--引入JS-->
    <script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.js"type="text/javascript"></script>
    <script type="text/javascript" src="/WebUploader/webuploader.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/adminlte/https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="/adminlte/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- jQuery 3 -->
<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/adminlte/bower_components/raphael/raphael.min.js"></script>
<script src="/adminlte/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- daterangepicker -->
<script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!--引入JS-->
<script type="text/javascript" src="/WebUploader/webuploader.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<div class="wrapper">

@include("admin.layout.header")
<!-- Left side column. contains the logo and sidebar -->
@include("admin.layout.sidebar")
<!-- Left side column. contains the logo and sidebar -->
@include("admin.layout.sidebar")



<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
        @include("admin.modal.password")
    </div>

<!-- ./wrapper -->


</div>
<div id="mask"><div class='loading'></div></div>
</body>
<script>
    var pathname = window.location.pathname;
    $("li a").each(function() {
        var href = $(this).attr("href");
        if(pathname == href){
            $(this).parents("ul").parent("li").addClass("active");
            $(this).parent("li").addClass("active");
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function changePassword(){
        $('#password_modal').modal('show');
    }
    // 清除数据
    $('body').on('hidden.bs.modal', '.modal', function () {
        document.getElementById("password_form").reset();
    });

    function storePassword(id){

        var newpassword = $('input[name="newpassword"]').val();
        var repassword = $('input[name="repassword"]').val();
        var password = $('input[name="password"]').val();
        if(!password || !repassword || !password){
            alert('密码不能为空!')
            return;
        }
            var reg = new RegExp(/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/);
            if (!reg.test(newpassword)) {
                alert('密码必须包含字母和数子的组合！');
                return ;
            }
            if(newpassword != repassword){
                alert('两次密码输入不一致！');
                return;
            }
        loading2('处理中...');
        $.ajax({
            url:'/admin/user/changePassword/'+id,
            type:'post',
            data:$('#password_form').serialize(),
            dataType:'json',
            success:function(data){
                if(data.ret == 1){
                    alert('操作成功');
                    location.reload();
                }else{
                    loading2('',0);
                    alert(data.msg);
                }
            },
            error:function(){
                loading2('',0);
                alert('服务器连接失败');
            }
        })
    }
</script>
</html>
