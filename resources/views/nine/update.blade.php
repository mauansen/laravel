@extends('layouts.admin')
@section('title')
    注册
@endsection

@section('content')
    <center>
        <div>

            <h1 class="logo-name">h</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>
        <div class="form-group">
            用户名： <input type="text" name="name" value="" class="form-control" placeholder="用户名" required="">
        </div>
        <div class="form-group">
            年龄:<input type="email" name="age"value="" class="form-control" placeholder="年龄" required="">
        </div>
        <button type="button" class="btn btn-primary block full-width m-b">修 改</button>

    </center>
    <script>
        function getUrlParam(name){
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r!=null) return unescape(r[2]); return null;
        }
        var url="http://w3.la.cn/api/user";
        var id=getUrlParam('id');
        $.ajax({
            url:url+"/"+id,
            dataType:"json",
            success:function (res) {
                $('[name="name"]').val(res.data.name);
                $('[name="age"]').val(res.data.age);
            }
        })

        $('.btn').click(function () {
            var name=$('[name="name"]').val();
            var age=$('[name="age"]').val();
            $.ajax({
                url:url+"/"+id,
                data:{name:name,age:age,"_method":"put"},
                dataType:"json",
                type:"POST",
                success:function (res) {
                    alert(res.msg);
                    if(res.code == '1')
                    {
                        location.href="http://w3.la.cn/nine/show";
                    }
                }
            })
        })
    </script>
@endsection