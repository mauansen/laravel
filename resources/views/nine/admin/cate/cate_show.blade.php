@extends('layouts.admin')
@section('title')
    分类展示
@endsection

@section('content')
    <table class="table table-hover">
        <tr>
            <td>分类名称</td>
            <td>商品数量</td>
        </tr>
        @foreach($cate_data as $v)
        <tr>
            <td>{{str_repeat('--',$v->level-1).$v->cate_name}}</td>
            <td>{{$v->number}}</td>
        </tr>
        @endforeach
    </table>
@endsection
