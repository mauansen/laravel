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
            用户名： <input type="text" name="name" class="form-control" placeholder="用户名" >
        </div>
        <div class="form-group">
            年龄:<input type="email" name="age" class="form-control" placeholder="年龄">
        </div>
        <div class="form-group">
            图片:<input type="file" name="img" placeholder="">
        </div>
        <button type="button" class="btn btn-primary block full-width m-b">登 录</button>

    </center>
    <script>
        var url="http://w3.la.cn/api/user";
        $('.btn').click(function () {
            var name=$('[name="name"]').val();
            var age=$('[name="age"]').val();
            var fd = new FormData();
            fd.append('name',name);
            fd.append('age',age);
            var file = $('[name="img"]')[0].files[0];
            fd.append('file',file);
            console.log(fd);
            $.ajax({
                url:url,
                data:fd,
                dataType:"json",
                contentType:false,   //post数据类型  unlencode
                processData:false,   //处理数据
                type:"POST",
                success:function (res) {
                    alert(res.msg);
                    if(res.code == '1')
                    {
                        // location.href="http://w3.la.cn/nine/show";
                    }
                }
            })
        })
    </script>
@endsection