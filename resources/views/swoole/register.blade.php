@extends('layouts.admin')
@section('title')
    注册
@endsection

@section('content')
    <div style=" height:50px;"></div>
    <div style=" height:50px;"><h2 align="center">用户注册</h2></div>
    <form action="{{url('swoole/register_do')}}" method="post" class="form-horizontal">
        <div class="form-group">
            @csrf
            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="注册用户名">
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
                <button type="submit" class="btn btn-default">注册</button>
            </div>
        </div>
    </form>
@endsection
