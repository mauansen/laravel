@extends('layouts.admin')
@section('title')
    音乐分类添加
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
            <td>{{$v->music_cate_name}}</td>
            <td>
                <a href="http://w3.la.cn/music/music_del?cate_id={{$v->cate_id}}"  class="btn btn-danger" >删除</a>
                <a  class="btn btn-warning" href="http://w3.la.cn/music/music_up?cate_id={{$v->cate_id}}">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
