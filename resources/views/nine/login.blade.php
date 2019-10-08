<!DOCTYPE html>
<html>

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">h</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" role="form" action="{{url('nine/login_int')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="email" name="name" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="pwd" class="form-control" placeholder="密码" required="">
            </div>
            <div class="form-group">
                <input type="text" name="code" class="form-control" placeholder="验证码" required="">
            </div>
            <input type="button" class="btn btn-primary block full-width m-b code" value="获取验证码" required="">

            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            <div>
                登陆请先扫码关注
                <img src="{{env('APP_URL')}}storage/img/0.jpg" width="100" alt="">
            </div>

            <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
            </p>

        </form>
    </div>
</div>
<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<script>
    $('.code').click(function(){
        var name=$('[name="name"]').val();
        var pwd=$('[name="pwd"]').val();
        // alert(pwd);
        $.ajax({
            url:'{{url("nine/send")}}',
            data:{name:name,pwd,pwd},
            dataType:"json",
            success:function (res) {
                alert(res.msg);
            }
        })
    })
</script>



</body>

</html>
