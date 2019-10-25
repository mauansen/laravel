@extends('layouts.admin')
@section('title')
    类型展示
@endsection

@section('content')
    <table class="table table-hover">
        <tr>
            <td>商品类型名称</td>
            <td>属性数</td>
            <td>操作</td>
        </tr>
        @foreach($type_data as $v)
        <tr>
            <td>{{$v->type_name}}</td>
            <td>{{$v->attr_number}}</td>
            <td><a href="javascript:">属性列表</a></td>
        </tr>
            @endforeach
    </table>
@endsection
