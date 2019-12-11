<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.2</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{env('APP_URL')}}xadmin/css/font.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}xadmin/css/xadmin.css">
    <!-- <link rel="stylesheet" href="./css/theme5.css"> -->
    <script src="{{env('APP_URL')}}xadmin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="{{env('APP_URL')}}xadmin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body class="index">
<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a>音乐管理</a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="音乐管理">&#xe6b8;</i>
                    <cite>音乐管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('音乐添加','{{url ("music/add")}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>音乐添加</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('音乐列表','{{url ("music/show")}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>音乐列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('音乐分类添加','{{url ("music/music_cate")}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>音乐分类添加</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('音乐分类列表','{{url ("music/music_cate_list")}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>音乐分类列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('轮播图展示','{{url ("music/rotatio_list")}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>轮播图展示</cite></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home">
                <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd></dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{url ('music/show')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
        <div id="tab_show"></div>
    </div>
</div>
<div class="page-content-bg"></div>
<style id="theme_style"></style>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<script>//百度统计可去掉
    var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>
