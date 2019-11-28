@extends('layouts.admin')
@section('title')
    音乐添加
@endsection

@section('content')
    <div class="page-header">

    </div>
    <form method="post" action="{{url ('music/music_add_do')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">音乐名称</label>
            <input name="music_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="音乐名称">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">歌手</label>
            <input name="music_singer" type="text" class="form-control" id="exampleInputPassword1" placeholder="歌手">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">音乐分类名称</label>
            <select name="music_cate_name" id="exampleInputPassword1" class="form-control">
                @foreach($music_cate_data as $k=>$v)
                    <option value="{{$v->cate_id}}">{{$v->music_cate_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">音乐</label>
            <input name="music" type="file" id="exampleInputFile">
        </div>
        <button type="submit" class="btn btn-default">上传</button>
    </form>

@endsection
