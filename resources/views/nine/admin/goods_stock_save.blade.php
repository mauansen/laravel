@extends('layouts.admin')
@section('title')
    商品添加
@endsection

@section('content')
    <form action="{{url('nine/goods_stock_save_do')}}" method="post">
    <h3>货品添加</h3>
    <table width="100%" id="table_list" class='table table-bordered'>
        <tbody>
        <tr>
            <th colspan="20" scope="col">商品名称：{{$goods_data->goods_name}}&nbsp;&nbsp;&nbsp;&nbsp;货号：{{$goods_data->letm}}</th>
        </tr>
        <tr>
            @foreach($data as $k=>$v)
            <!-- start for specifications -->
            <td scope="col"><div align="center"><strong>{{$k}}</strong></div></td>
            <!-- end for specifications -->
            @endforeach
            <td class="label_2">库存</td>
            <td class="label_2">&nbsp;</td>
        </tr>
            @csrf
            <input type="hidden" name="goods_id" value="{{$goods_id}}">
        <tr id="attr_row">
            @foreach($data as $key=>$value)
            <td align="center" style="background-color: rgb(255, 255, 255);">
                <select name="sku_attr_list[]">
                    <option value="" selected="">请选择...</option>
                    @foreach($value as $k=>$v)
                    <option value="{{$v['goods_attr_id']}}">{{$v['attr_value_list']}}</option>
                    @endforeach
                </select>
            </td>
            @endforeach
            <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_number[]" size="10"></td>
            <td style="background-color: rgb(255, 255, 255);"><input type="button" class="button clone" value="+" ></td>
        </tr>
        <tr>
            <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
                <input type="submit" class="button" value=" 保 存 ">
            </td>
        </tr>
        </form>
        </tbody>
    </table>
    <script>
        $(document).on('click','.clone',function () {
            var sign = $(this).val();
            if (sign == "+") {
                var tr = $(this).parent().parent().clone();
                $(this).parent().parent().before(tr);
                $(this).val('-');
            }else{
                $(this).parent().parent().remove();
            }
        })
    </script>
@endsection
