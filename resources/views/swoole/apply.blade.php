@extends('layouts.admin')
@section('title')
    申请聊天室
@endsection
@section('content')
    <form action="{{url('swoole/apply_do')}}" method="post">
        <div class="form-group">
            @csrf
            <label for="inputEmail3" class="col-sm-2 control-label">申请聊天室名字</label>
            <div class="col-sm-10">
                <input type="text" name="apply" class="form-control" id="inputEmail3" placeholder="申请聊天室名字">
                <input type="hidden" name="username" value="{{$username}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">申请</button>
            </div>
        </div>
    </form>
@endsection
