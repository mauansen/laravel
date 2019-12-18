@extends('layouts.admin')
@section('title')
    申请列表
@endsection

@section('content')
    <div style=" height:50px;"></div>
    <div style=" height:50px;"></div>
    <table class="table">
        <tr>
            <td>申请聊天室名称</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->apply}}</td>
            <td><a href="{{url ('swoole/tong')}}"></a>通过审核</td>
        </tr>
        @endforeach
    </table>
@endsection
