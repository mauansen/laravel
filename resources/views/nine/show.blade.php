@extends('layouts.admin')
@section('title')
    注册
@endsection

@section('content')
    <center>
        <h3>展示</h3>
        <div class="form-inline">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" value="" name="name" class="form-control" id="exampleInputAmount" placeholder="姓名">
                </div>
            </div>
            <button class="btn btn-primary hunt">搜索</button>
        </div>

        <table class="table ">
            <tr>
                <td>id</td>
                <td>姓名</td>
                <td>年龄</td>
                <td>操作</td>
            </tr>
            <tbody id="list">

            </tbody>
        </table>

    </center>
    <nav aria-label="Page navigation">
        <ul class="pagination">



        </ul>
    </nav>
    <script>
//展示
        var url="http://w3.la.cn/api/user";
        $.ajax({
                url:url,
                dataType:"json",
                success:function (res) {
                    show(res);
            }
        })
        //搜索
        $('.hunt').click(function () {
            var name=$('[name="name"]').val();
            $.ajax({
                url:url,
                data:{name:name},
                dataType:"json",
                success:function (res) {
                    // console.log(res);
                    show(res);
                }
            })
        })
        //删除
        $(document).on('click','.del',function () {
            var id=$(this).attr('delid');
            var _this=$(this);
            var page=$('.page').text();
            $.ajax({
                url:url+"/"+id,
                dataType:"json",
                type:"delete",
                success:function (res) {
                    if(res.code==1){
                        alert(res.msg);
                        _this.parent().parent().remove();
                        show(res);
                    }else if(res.code!=1){
                        alert(res.msg);
                    }
                    // $.each(res.data,function(k,v){
                    //     var tr=$("<tr></tr>");
                    //     tr.append("<td>"+v.id+"</td>");
                    //     tr.append("<td>"+v.name+"</td>");
                    //     tr.append("<td>"+v.age+"</td>");
                    //     tr.append('<td><button class="btn btn-danger del" delid='+v.id+' >删除</button></td>');
                    //     tr.append('<td><button class="btn btn-success" updateid='+v.id+' >修改</button></td>');
                    //     $('#list').append(tr);
                    // })
                }
            })
        })
        function show(res)
        {
            $('#list').empty();
            $.each(res.data.data,function(k,v){
                var tr=$("<tr></tr>");
                tr.append("<td>"+v.id+"</td>");
                tr.append("<td>"+v.name+"</td>");
                tr.append("<td>"+v.age+"</td>");
                tr.append('<td><button class="btn btn-danger del" delid='+v.id+' >删除</button></td>');
                tr.append('<td><a href="http://w3.la.cn/nine/update?id='+v.id+'" class="btn btn-success update" updateid='+v.id+' >修改</a></td>');
                $('#list').append(tr);
            })
            // alert(res.data.last_page);
            var page=res.data.last_page;
            $('.pagination').empty();
            for (var i = 1;i <= page;i++)
            {
                var li='<li><a href="javascript:" class="page">'+i+'</a></li>';
                $('.pagination').append(li);

            }
        }
        //分页
        $(document).on('click','.page',function () {
            var page=$(this).text();
            var name=$('[name="name"]').val();
            $.ajax({
                url:url,
                data:{page:page,name:name},
                dataType:"json",
                success:function (res) {
                    show(res);
                }
            })
        })
        //修改
        $(document).on('click','.update',function () {
            location.href="http://w3.la.cn/nine/update";

        })
    </script>
@endsection
