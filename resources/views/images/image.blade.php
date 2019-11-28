<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post" action="http://upload-z1.qiniup.com"
      enctype="multipart/form-data">
    <input name="token" type="hidden" value="{{$token}}">
    <input name="file" type="file" />
    <input type="submit" value="上传文件" />
</form>
</body>
</html>
