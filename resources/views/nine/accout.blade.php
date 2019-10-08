
<!DOCTYPE html>
<html>

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - 绑定账号</title>
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
        <h3>绑定账号</h3>
        <form class="m-t" role="form" action="{{url('nine/accout_do')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="hidden" name="openid" value="{{$openid}}">
                <input type="hidden" name="nickname" value="{{$nickname}}">
                <input type="email" name="name" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="pwd" class="form-control" placeholder="密码" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">绑定账号</button>
        </form>
    </div>
</div>




</body>

</html>
