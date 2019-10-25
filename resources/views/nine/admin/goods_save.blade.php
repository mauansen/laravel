@extends('layouts.admin')
@section('title')
商品添加
@endsection

@section('content')
    <h3>商品添加</h3>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;" name='basic'>基本信息</a></li>
        <li role="presentation" ><a href="javascript:;" name='attr'>商品属性</a></li>
        <li role="presentation" ><a href="javascript:;" name='detail'>商品详情</a></li>
    </ul>
    <br>
    <form action='{{url("nine/goods_save_do")}}' method="POST" enctype="multipart/form-data" id='form'>
@csrf
        <div class='div_basic div_form'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" class="form-control" name='goods_name'>
                @php echo($errors->first('goods_name')) ;@endphp
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品分类</label>
                <select class="form-control" name='cate'>
                    <option value="">请选择分类</option>
                    @foreach($cate_data as $v)
                    <option value='{{$v->cate_id}}'>{{$v->cate_name}}</option>
                    @endforeach
                </select>
                @php echo($errors->first('cate')) ;@endphp
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品价钱</label>
                <input type="text" class="form-control" name='price'>
                @php echo($errors->first('price')) ;@endphp
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品货号</label>
                <input type="text" class="form-control" name='letm'>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">商品图片</label>
                <input type="file" name='goods_img'>
                <img src="" alt="">
            </div>
        </div>
        <div class='div_detail div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputFile">商品详情</label>
                <textarea class="form-control" rows="3" name="desc"></textarea>
            </div>
        </div>
        <div class='div_attr div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品类型</label>
                <select  class="form-control type" name='type_id' >
                    <option value=""> 请选择</option>
                    @foreach($type_data as $v)
                    <option  value="{{$v->type_id}}">{{$v->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <br>

            <table width="100%" class='table'>
                <tbody class="parameter">

                </tbody>
                <tbody class="Specifications">

                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-default" id='btn'>添加</button>
    </form>
    <script type="text/javascript">
        //标签页 页面渲染
        $(".nav-tabs a").on("click",function(){
            $(this).parent().siblings('li').removeClass('active');
            $(this).parent().addClass('active');
            var name = $(this).attr('name');  // attr basic
            $(".div_form").hide();
            $(".div_"+name).show();  // $(".div_"+name)
        })
        $(".type").on('change',function(){
            //模拟表单对象  FormData
            var attr_id=$(this).val();
            $.ajax({
                url:"{{url('nine/type_attr')}}",
                data:{attr_id:attr_id},
                dataType:"json",
                success:function(res){
                    $('.Specifications').empty();
                    $('.parameter').empty();
                    $.each(res.type_attr_data,function (k,v) {
                        var tr=$("<tr class='tr'></tr>");
                        if(v.is_attr==1)
                        {
                            tr.append('<td><a class="clone" href="javascript:;">[+]</a>'+v.attr_name+'</td>');
                            tr.append('<td><input type="hidden" name="attr_id[]" value="'+v.attr_id+'"><input name="attr_value_list[]" type="text" value="" size="20">属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10"></td>');
                            $('.Specifications').append(tr);
                        }else{
                            tr.append('<td>'+v.attr_name+'</td>');
                            tr.append('<td><input type="hidden" name="attr_id[]" value="'+v.attr_id+'"><input name="attr_value_list[]" type="text" value="" size="20"><input type="hidden" name="attr_price_list[]" value="" size="5" maxlength="10"></td>');
                            $('.parameter').append(tr);
                        }
                    });

                }
            });
        });
        //    克隆
        $(document).on('click','.clone',function(){
            var sign = $(this).html();
            if (sign == "[+]") {
                var tr = $(this).parent().parent().clone();
                $(this).parent().parent().before(tr);
                $(this).html('[-]');
            }else{
                $(this).parent().parent().remove();
            }
        })
    </script>
@endsection
