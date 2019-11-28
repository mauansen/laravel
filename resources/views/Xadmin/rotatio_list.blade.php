@extends('layouts.admin')
@section('title')
    轮播上传
@endsection

@section('content')
    <div class="page-header">

    </div>
    <table class="table">
        <tr>
            <td>音乐分类名称</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td><img src="{{$v->rotatio}}" alt="" width="40"></td>
                <td>
                    <a class="btn btn-danger" >删除</a>
                    <a href="{{url('music/rotatio_enable')}}?rotatio_id={{$v->rotatio_id}}}" class="btn btn-info">启用</a>
                    <a class="btn btn-warning">修改</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
