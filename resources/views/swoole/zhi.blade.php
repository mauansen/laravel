<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.7/skins/default/aliplayer-min.css" />
    <script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.7/aliplayer-min.js"></script>
</head>
<body>
<div class="prism-player" id="player-con"></div>
<script>
    var player = new Aliplayer({
            "id": "player-con",
            "source": "http://bo.mayansen.cn/1902/mayansen.m3u8?auth_key=1576657145-0-0-011b482b40b3737a424e4743b8fe33b4",
            "width": "100%",
            "height": "500px",
            "autoplay": true,
            "isLive": true,
            "rePlay": false,
            "showBuffer": true,
            "snapshot": false,
            "showBarTime": 5000,
            "useFlashPrism": true,
            "skinLayout": [
                {
                    "name": "bigPlayButton",
                    "align": "blabs",
                    "x": 30,
                    "y": 80
                },
                {
                    "name": "errorDisplay",
                    "align": "tlabs",
                    "x": 0,
                    "y": 0
                },
                {
                    "name": "infoDisplay"
                },
                {
                    "name": "controlBar",
                    "align": "blabs",
                    "x": 0,
                    "y": 0,
                    "children": [
                        {
                            "name": "liveDisplay",
                            "align": "tlabs",
                            "x": 15,
                            "y": 25
                        },
                        {
                            "name": "fullScreenButton",
                            "align": "tr",
                            "x": 10,
                            "y": 25
                        },
                        {
                            "name": "volume",
                            "align": "tr",
                            "x": 10,
                            "y": 25
                        }
                    ]
                }
            ]
        }, function (player) {
            console.log("The player is created");
        }
    );
</script>
</body>
</html>
