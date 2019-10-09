@extends('layouts.admin')
@section('title')
扫码登陆

@endsection

@section('content')
    <center>
    <div>

        <h1 class="logo-name">h</h1>

    </div>
    <h3>欢迎使用 hAdmin</h3>
        <img src="http://qr.liantu.com/api.php?text={{$url}}"/>
    </center>
    <script>
        var t= setInterval("check()",2000);
        var id = {{$id}};
        function check() {
            $.ajax({
                url:"{{url('nine/code')}}",
                data:{id:id},
                dataType:'json',
                success:function(res){
                    if(res.ret==1){
                        clearInterval(t);
                        alert(res.msg);
                        location.href="{{url('nine/index')}}"
                    }
                }
            })
        }
    </script>
@endsection