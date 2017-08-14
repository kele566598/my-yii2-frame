<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
        .system-message{width:400px;margin:200px auto;text-align:left;border:1px solid #ccc;
            z-index:999999; background:#fff;text-align:center;
            webkit-box-shadow:0 2px 5px 1px rgba(0,0,0,.1);-moz-box-shadow:0 2px 5px 1px rgba(0,0,0,.1);
            -khtml-box-shadow:0 2px 5px 1px rgba(0,0,0,.1);-ms-box-shadow:0 2px 5px 1px rgba(0,0,0,.1);
            box-shadow:0 2px 5px 1px rgba(0,0,0,.1);padding:15px;}
        .system-message h1{ font-size: 36px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 10px;color: #ccc;}
        .system-message .jump a{ color: #999;}
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
        .system-message .success{color:#1b9103;}
        .system-message .error{color:#F57543;}
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
    </style>
</head>
<body>
<div class="system-message">
    <p class="error">:)对不起，您访问的页面不存在！</p><p class="detail"></p>
    <p class="jump">
        页面自动 <a id="href" href="javascript:history.back(-1);">跳转</a> 等待时间： <b id="wait">3</b>
    </p>
</div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>