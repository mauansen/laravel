@extends('layouts.admin')
@section('title')
    轮播上传
@endsection

@section('content')
    <div class="page-header">

    </div>
    <form method="post"  action="{{url('music/rotatio_add_do')}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputPassword">标题</label>
        <input type="text" name="title" id="exampleInputPassword" >
        </div>
        <div class="form-group">
            @csrf
            <label for="exampleInputFile">轮播图片</label>
            <input name="file" type="file" id="exampleInputFile">
        </div>
        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection
