@extends('layouts.admin')
@section('title')
    音乐分类添加
@endsection

@section('content')
    <div class="page-header">

    </div>
    <form method="post" action="{{url ('music/music_cate_do')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">音乐分类名称</label>
            <input name="music_cate_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="音乐分类名称">
        </div>
        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection
