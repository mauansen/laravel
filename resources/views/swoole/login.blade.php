@extends('layouts.admin')
@section('title')
    直播
@endsection

@section('content')
    <div style=" height:50px;"></div>
    <form action="{{url('swoole/login_do')}}" method="post" class="form-horizontal">
        <div class="form-group">
            @csrf
            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="用户名">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" name="pwd" class="form-control" id="inputPassword3" placeholder="密码">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">登录</button>
            </div>
        </div>
    </form>
@endsection
