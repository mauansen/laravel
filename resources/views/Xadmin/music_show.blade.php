@extends('layouts.admin')
@section('title')
    音乐展示
@endsection

@section('content')
    <div class="page-header">

    </div>
    <table class="table">
        <tr>
            <td>音乐名称</td>
            <td>音乐分类名称</td>
            <td>歌手</td>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td>{{$v->music_name}}</td>
                <td>{{$v->music_cate_name}}</td>
                <td>{{$v->music_singer}}</td>
            </tr>
        @endforeach
    </table>
@endsection
