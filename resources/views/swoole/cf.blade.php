@extends('layouts.admin')
@section('title')
    cf聊天室
@endsection
@section('content')
    <div style=" height:50px;"></div>
    <p>@if($res) {{$res}} @endif</p>
    <div style="border:1px solid black; width:1140px; height: 500px; overflow: auto" id="msg" ></div>
    <button id="huo">火箭</button> <button id="you">游艇</button>
    <div style=" height:50px;"></div>
    <input type="text" class="form-control" >
    <div style=" height:50px;"></div>
    <button class="form-control" style="background-color: #00A1FF" id="but">发表评论</button>
    <script>
        if(window.WebSocket){
            var ws=new WebSocket('ws://swoole.mayansen.cn:8001');
            ws.onopen=function(event){
                var json = '{"type":"login","username":"{{$res}}"}';
                ws.send(json);
            }
            ws.onmessage=  function (event) {
                var msg=event.data;
                $('#msg').append(msg);
                console.log(event);
            }
            $(document).on('click','#but',function () {
                var content=$('.form-control').val();
                var userss='{"type":"talk","content":"'+content+'","name":"{{$res}}"}';
                ws.send(userss);
            })
            $(document).on('click','#huo',function () {
                var content=$(this).text();
                var userss='{"type":"gift","content":"'+content+'","username":"{{$res}}"}';
                ws.send(userss);
            })
            $(document).on('click','#you',function () {
                var content=$(this).text();
                var userss='{"type":"gift","content":"'+content+'","username":"{{$res}}"}';
                ws.send(userss);
            })
        }
    </script>
@endsection
