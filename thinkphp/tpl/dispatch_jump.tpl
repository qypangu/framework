{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; text-align:center;}
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 10px; }
        .system-message .jump a{ color: #333; }
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
    <div class="system-message">
        <?php switch ($code) {?>
            <?php case 1:?>
            <img src="data:image/png;base64,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" />
            <p class="success"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
            <?php case 0:?>
            <img src="data:image/png;base64,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" width="93px"/>
            <p class="error"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
        <?php } ?>
        <p class="detail"></p>
        <p class="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </p>
    </div>
    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
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