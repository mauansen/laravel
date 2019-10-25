@extends('layouts.admin')
@section('title')
    类型展示
@endsection

@section('content')
    <p></p>
    <select name="type_id" id="select">
        <option value="0">所有</option>
        @foreach($type_data as $v)
        <option value="{{$v->type_id}}">{{$v->type_name}}</option>
        @endforeach
    </select>
    <table class="table table-hover">
        <tr>
            <td><input type="checkbox" class="selection">编号</td>
            <td>属性名称</td>
            <td>商品类型</td>
        </tr>
        <tbody id="list">
            @foreach($attr_data as $v)
                <tr>
                    <td><input type="checkbox" name="checkboxes[]" value="{{$v->attr_id}}">{{$v->attr_id}}</td>
                    <td>{{$v->attr_name}}</td>
                    <td>{{$v->type_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-danger button">删除</button>
    <script>
        $('#select').on('change',function () {
            var type_id=$(this).val();
            $.ajax({
                url:"{{url('nine/type_attr_show')}}",
                data:{type_id:type_id},
                dataType: "json",
                success:function (res) {
                    console.log(res);
                    $('#list').empty();
                    $.each(res.type_attr,function (k,v) {
                        var tr=$('<tr></tr>');
                        tr.append('<td><input type="checkbox" name="checkboxes[]" value="'+v.attr_id+'">'+v.attr_id+'</td>');
                        tr.append('<td>'+v.attr_name+'</td>');
                        tr.append('<td>'+v.type_name+'</td>');
                        $('#list').append(tr);
                    });
                }
            })
        })
        $('.selection').click(function () {
            $('[name="checkboxes[]"]').prop('checked',$(this).prop('checked'));

        })
        $('.button').click(function () {
            var obj=$('[name="checkboxes[]"]:checked');
            var arr =new Array();
            $.each(obj,function(){
                var gid=$(this).val();
                arr.push(gid);
            })
            $.axaj({
                url:"{{url('nine/attr_del')}}",
                data:{attr_id:arr},
                dataType:"json",
                success:function(res){
                    if(res){
                        alert('批量删除成功');
                    }else{
                        alert('批量删除失败');
                    }
                }
            })
        })
    </script>
@endsection
