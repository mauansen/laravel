@extends('layouts.admin')
@section('title')
    商品添加
@endsection

@section('content')
    <div class="form-inline">
        <div class="form-group">
            <div class="input-group">
                <input type="text" value="" name="goodsname" class="form-control" id="exampleInputAmount" placeholder="商品名称">
            </div>

        </div>
        <button class="btn btn-primary hunt">搜索</button>
        <div class="input-group weater table-responsive">
            <table class="table">
            <tr>
                <td class="city"></td>
                <td class="week"></td>
                <td class="wtTemp"></td>
                <td class="wtNm"></td>
            </tr>
            </table>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" value="" name="zone" class="form-control" id="exampleInputAmount" placeholder="北京">
            </div>

        </div>
        <button class="btn btn-primary zone">切换地区</button>
    </div>
    <table class="table table-striped">
        <tr>
            <td>#</td>
            <td>商品名称</td>
            <td>商品价格</td>
            <td>商品图片</td>
            <td>商品操作</td>
        </tr>
        <tbody id="list">

        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
        </ul>
    </nav>
    <script>
        var url="http://w3.la.cn/api/goods";
        $.ajax({
            url:url,
            dataType:"json",
            success:function (res) {
                show(res);
                console.log(res.weater.result.futureDay[0].wtIcon1);

            }
        })
        //分页
        $(document).on('click','.zone',function () {
            var zone=$('[name="zone"]').val();
            $.ajax({
                url:url,
                data:{city:zone},
                dataType:"json",
                success:function (res) {
                    show(res);
                }
            })
        })
        //切换天气
        $(document).on('click','.hunt',function () {
            var goodsname=$('[name="goodsname"]').val();
            $.ajax({
                url:url,
                data:{goodsname:goodsname},
                dataType:"json",
                success:function (res) {
                    show(res);
                }
            })
        })
        //搜索
        $(document).on('click','.hunt',function () {
            var goodsname=$('[name="goodsname"]').val();
            $.ajax({
                url:url,
                data:{goodsname:goodsname},
                dataType:"json",
                success:function (res) {
                    show(res);
                }
            })
        })
        //封装的方法
        function show(res) {
            $('#list').empty();
            $.each(res.data.data,function (k,v) {
                var tr=$("<tr></tr>");
                tr.append('<td>'+v.id+'</td>');
                tr.append('<td>'+v.goodsname+'</td>');
                tr.append('<td>'+v.price+'</td>');
                tr.append('<td><img width="50" src="'+v.image+'" alt=""></td>');
                tr.append('<td><button class="btn btn-warning">删除</button> <button class="btn btn-info">修改</button></td>');
                $('#list').append(tr);
            })
            //
            var weater=$("<b></b>");
            var city=res.weater.result.area_1;
            var week=res.weater.result.realTime.week;
            var wtIcon1=res.weater.result.futureDay[0].wtIcon1;
            var wtIcon2=res.weater.result.futureDay[0].wtIcon2;
            var wtNm=res.weater.result.realTime.wtNm;
            $('.city').text(city);
            $('.week').text(week);
            $('.wtTemp').text(wtIcon1+"~"+wtIcon2+"度");
            $('.wtNm').text(wtNm);
            //天气
            var page=res.data.last_page;
            $('.pagination').empty();
            for (var i = 1;i <= page;i++)
            {
                var li='<li><a href="javascript:" class="page">'+i+'</a></li>';
                $('.pagination').append(li);

            }
        }
    </script>
@endsection
