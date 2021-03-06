<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>展示</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <table class="table">
        <tr>
            <td>新闻编号</td>
            <td>新闻标题</td>
            <td>新闻内容</td>
            <td>新闻发布时间</td>
            <td>新闻发布网站</td>
            <td>新闻发布多少时间</td>
        </tr>
@foreach($value as $v)
        <tr>
            <td>{{$v['new_id']}}</td>
            <td>{{$v['title']}}</td>
            <td>{{$v['content']}}</td>
            <td>{{$v['pdate_src']}}</td>
            <td>{{$v['src']}}</td>
            <td>{{$v['pdate']}}</td>
        </tr>
@endforeach
    </table>
</div>
</body>
</html>
