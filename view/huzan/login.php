<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>扫码登录</title>
  <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
  <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="<?php echo $HTTP_HOST;?>/assets/huzan/js/qrlogin.js"></script>
</head>
<body>
      <div class="panel-body" style="text-align: center;">
        <div class="list-group">
          <div class="list-group-item list-group-item" style="font-weight: bold;" id="login">
            <span id="loginmsg">使用QQ手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
          </div>
          <div class="list-group-item" id="qrimg">
          </div>
          <div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurl()" class="btn btn-warning btn-block">跳转QQ快捷登录</button><br/><button type="button" onclick="loadScript()" class="btn btn-success btn-block">我已完成登录</button></div>
        </div>
	</div>
</body>
</html>