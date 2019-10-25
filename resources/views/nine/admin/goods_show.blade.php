@extends('layouts.admin')
@section('title')
    商品展示
@endsection

@section('content')
    <p></p>
    <form class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail3">分类</label>
            <select name="cate" class="form-control">
                <option value="">请选择</option>
                @foreach($cate_data as $v)
                    <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword3">商品名称</label>
            <input type="text" class="form-control" value="" name="goods_name" id="exampleInputPassword3" placeholder="商品名称">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <table class="table table-hover">
        <tr>
            <td>商品名称</td>
            <td>商品价格</td>
            <td>商品货号</td>
            <td>商品图片</td>
            <td>商品分类</td>
            <td>商品类型</td>
            <td>操作</td>
        </tr>
        @foreach($goods_data as $v)
        <tr id="{{$v->goods_id}}">
            <td ><span class="goods_name">{{$v->goods_name}}</span><input type="text" value="" name="goods_name" class="name" style="display:none"></td>
            <td>{{$v->price}}</td>
            <td>{{$v->letm}}</td>
            <td><img src="{{$v->goods_img}}" width="50" alt=""></td>
            <td>{{$v->cate_name}}</td>
            <td>{{$v->type_name}}</td>
            <td>操作</td>
        </tr>
        @endforeach
    </table>
    {{ $goods_data->links() }}
    <script>
        $('.goods_name').on('click',function () {
            var goods_name=$(this).text();
            $(this).hide();
            $(this).next().show().val(goods_name).focus();
            // input.focus();
        })
        $(document).on('blur','.name',function(){
            //获取input
            var input=$(this);
            //获取 input的同胞的上一个标签
            var span=input.prev();
            //input隐藏
            input.hide();
            //span显示
            span.show();
            //获取input的值 放入span标签里
            var names=input.val();
            //获取行ID
            var id=input.parent().parent().attr('id');
            // alert(id);
            span.text(names);
            //发送ajax请求
            $.ajax({
                url:'{{url("nine/goods_that")}}',
                data:{goods_name:names,goods_id:id},
                success:function(res){

                }
            })
        })
    </script>
@endsection
