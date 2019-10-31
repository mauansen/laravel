<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>班级</title>
</head>
<body>
<div class="container">
        <table class="table" >
            <tr>
                <td>班级id</td>
                <td>班级名称</td>
                <td>班级人数</td>
            </tr>
            @foreach($ClassData as $v)
            <tr>
                <td>{{$v->class_id}}</td>
                <td>{{$v->class}}</td>
                <td>{{$v->number}}</td>
            </tr>
            @endforeach
        </table>
        <div style="height:65px;"></div>
        <table class="table">
            <tr>
                <td>班级id</td>
                <td>班级名称</td>
                <td>学生信息</td>
            </tr>
            @foreach($student as $k=>$v)
            <tr>
                <td>{{$v->class_id}}</td>
                <td>{{$v->class}}</td>
                <td>
                    <table class="table table-bordered">
                        @foreach($v->news as $key=>$value)
                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->age}}岁</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            @endforeach
        </table>
</div>
</body>
</html>
