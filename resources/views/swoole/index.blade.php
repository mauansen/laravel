@extends('layouts.admin')
@section('title')
    LOL聊天室
@endsection
@section('content')
    <div style=" height:50px;"></div>
    <p>@if($res) {{$res}} @endif</p>
    <div style="border:1px solid black; width:940px; height: 500px; overflow: auto;float :left;" id="msg" ></div>
    <div style="border:1px solid black; width:200px; height: 500px; overflow: auto;float :right;" id="people" ><p align="center" id="num"></p><ul id="ul"></ul></div>
    <button id="huo">火箭</button> <button id="you">游艇</button><select name="" id=""></select>
    <div style=" height:50px;"></div>
    <input type="text" class="form-control" >
    <div style=" height:50px;"></div>
    <button class="form-control" style="background-color: #00A1FF" id="but">发表评论</button>
    <script>
        if(window.WebSocket){
            var ws=new WebSocket('ws://swoole.mayansen.cn:8000');
            ws.onopen=function(event){
                var json = '{"type":"login","content":"{{$res}}"}';
                ws.send(json);
            }
            ws.onmessage=  function (event) {
                var content=event.data;
                var res = JSON.parse(content)
                if(res.type == 'message' )
                {
                    var msg =res.ressponse;
                    $('#msg').append(msg);
                    $('#num').text('在线人数：'+res.num)
                    $('#ul').empty()
                    $.each(res.onlinelist,function (i,v) {
                       $('#ul').append("<li>"+v.username+"</li>");
                       // alert(v.username);
                    })
                    console.log(res)
                }else if(res.type =='login'){
                    var msg =res.ressponse;
                    $('#msg').append(msg);
                    $('#num').text('在线人数：'+res.num)
                    $('#ul').empty()
                    $.each(res.onlinelist,function (i,v) {
                        $('#ul').append("<li>"+v.username+"</li>");
                        // alert(v.username);
                    })
                }
            }
            $(document).on('click','#but',function () {
                var content=$('.form-control').val();
                var json='{"type":"talk","content":"'+content+'","name":"{{$res}}"}';
                ws.send(json);
            })

        }
    </script>
@endsection
