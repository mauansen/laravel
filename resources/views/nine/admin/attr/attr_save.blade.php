@extends('layouts.admin')
@section('title')
    类型展示
@endsection

@section('content')
    <p></p>
    <form method="post" action="{{url('nine/attr_save_do')}}">
        <div class="form-group">
            @csrf
            <label for="exampleInputEmail1">属性名称</label>
            <input type="text" name="attr_name" class="form-control" id="exampleInputEmail1" placeholder="属性名称">
            <span class="span" style="color:red;"></span>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">所属商品类型</label>
            <select class="form-control" name="goods_type">
                @foreach($type_data as $v)
                <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">属性是否可选</label>
            <div class="radio">
                <label>
                    <input type="radio" name="is_attr" id="blankRadio1" checked value="1" aria-label="...">参数
                </label>
                <label>
                    <input type="radio" name="is_attr" id="blankRadio1" value="0" aria-label="...">规格
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@endsection
