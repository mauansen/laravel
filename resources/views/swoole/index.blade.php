@extends('layouts.admin')
@section('title')
    直播
@endsection
@section('content')
    <div style=" height:50px;"></div>
    <p>@if($res) {{$res}} @endif</p>
    <div style="border:1px solid black; width:1140px; height: 500px;" id="msg" ></div>
    <div style=" height:50px;"></div>
    <input type="text" class="form-control" >
    <div style=" height:50px;"></div>
    <button class="form-control" style="background-color: #00A1FF" id="but">发表评论</button>
    <div style=" height:50px;"></div>
    <button class="form-control" style="background-color: #00A1FF" id="login">登录</button>
    <script>
        if(window.WebSocket){
            var ws=new WebSocket('ws://swoole.mayansen.cn:9501');
            ws.onopen=function(event){
                var json = '{"type":"login","content":"{{$res}}"}';
                ws.send(json);
            }
            ws.onmessage=  function (event) {
                var msg=event.data;
                $('#msg').append(msg);
                console.log(event);
            }
            $(document).on('click','#but',function () {
                var content=$('.form-control').val();
                var userss='{"type":"talk","content":"'+content+'"}';
                ws.send(userss);
            })
        }
        $(document).on('click','#login',function () {
            window.location.href ="http://w3.la.cn/swoole/login";
        })
    </script>
@endsection
