@extends('layouts.admin')
@section('title')
    聊天室列表
@endsection

@section('content')
    <div style=" height:50px;"></div>
    <div style=" height:50px;"><h2 align="center">聊天室列表</h2></div>
    <table class="table">
        <tr>
            <td>LOL</td>
            <td>
                <a href="{{url ('swoole/index/'.$username)}}">进入聊天室</a>
            </td>
        </tr>
        <tr>
            <td>CF</td>
            <td>
                <a href="{{url ('swoole/cf/'.$username)}}">进入聊天室</a>
            </td>
        </tr>
        <tr>
            <td>DNF</td>
            <td>
                <a href="{{url ('swoole/dnf/'.$username)}}">进入聊天室</a>
            </td>
        </tr>
    </table>
@endsection
