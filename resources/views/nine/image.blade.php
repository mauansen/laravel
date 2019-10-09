@extends('layouts.admin')
@section('title')
扫码登陆

@endsection

@section('content')
    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <center>
    <div>

        <h1 class="logo-name">h</h1>

    </div>
    <h3>欢迎使用 hAdmin</h3>
        <img src="http://qr.liantu.com/api.php?text={{$url}}"/>
    </center>
@endsection