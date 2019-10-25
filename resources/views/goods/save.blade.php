@extends('layouts.admin')
@section('title')
    商品添加
@endsection

@section('content')
   <div>
           <div class="form-group">
               <label for="exampleInputEmail1">商品名称</label>
               <input type="text" class="form-control" id="exampleInputEmail1" name="goodsname" placeholder="商品名称">
           </div>
           <div class="form-group">
               <label for="exampleInputPassword1">商品价格</label>
               <input type="" class="form-control" id="exampleInputPassword1" name="price" placeholder="商品价格">
           </div>
           <div class="form-group">
               <label for="exampleInputFile">商品图片</label>
               <input type="file" id="exampleInputFile" name="image">
           </div>
           <button type="submit" class="btn btn-default">提交</button>
   </div>
    <script>
        var url="http://w3.la.cn/api/goods";
        $('.btn').click(function () {
            var goodsname=$('[name="goodsname"]').val();
            var price=$('[name="price"]').val();
            var fd = new FormData();
            fd.append('goodsname',goodsname);
            fd.append('price',price);
            var image = $('[name="image"]')[0].files[0];
            fd.append('image',image);
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
                        location.href="http://w3.la.cn/goods/goods_show";
                    }
                }
            })
        })
    </script>
@endsection