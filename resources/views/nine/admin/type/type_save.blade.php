@extends('layouts.admin')
@section('title')
    类型添加
@endsection

@section('content')
    <p></p>
    <form method="post" action="{{url('nine/type_save_do')}}">
        <div class="form-group">
            @csrf
            <label for="exampleInputEmail1">类型名称</label>
            <input type="text" name="type_name" class="form-control" id="exampleInputEmail1" placeholder="类型名称">
            <span class="span" style="color:red;"></span>
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>
    <script>
        $('.btn').click(function () {
            var type_name=$('[name="type_name"]').val();
            if(type_name=="")
            {
                $('.span').text('不能为空');
                event.preventDefault();
            }
        })
    </script>
@endsection
