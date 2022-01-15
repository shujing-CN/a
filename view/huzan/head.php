<?php	
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <title><?php echo config('sitename');?> - <?php echo $title;?></title>
	    <meta name="Description" content="<?php echo config('Description');?>"/>
	    <meta name="keywords" content="<?php echo config('keywords')?>"/>
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <link rel="shortcut icon" href="/favicon.ico"/>
		<link rel="bookmark"href="/favicon.ico"/>
		<link href="//lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <?php
        	if(empty($mod)){
        		echo '<link href="'.$HTTP_HOST.'/assets/huzan/css/index_style.css?ver='.config('ver').'" rel="stylesheet" type="text/css">';
        	}else{
        		echo '<link href="'.$HTTP_HOST.'/assets/huzan/css/'.$mod.'_style.css?ver='.config('ver').'" rel="stylesheet" type="text/css">';
        	}
        ?>
        <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
        <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
        <script type="text/javascript" src="<?php echo $HTTP_HOST;?>/assets/huzan/js/slider.js"></script>
        <script src="//lib.baomitu.com/clipboard.js/1.7.1/clipboard.min.js"></script>
        <script type="text/javascript" src="<?php echo $HTTP_HOST;?>/assets/huzan/js/main.js?ver=<?php echo config('ver')?>"></script>
<style>
@media (min-width: 300px) {
	body{
		min-width: 100%;
	}
	.contain {
	    margin-top: 45px;
	}
	.aui-footer{
		width:100%;
	}
	.auto{
		width:100%;
	}
	.auto-width{
		width:100%;
	}
	.auto-layer{
		width:calc(100% - 23px);
	}
}
@media (min-width: 375px) {
	.auto-layer{
		width:calc(100% - 23px);
	}
}
@media (min-width: 500px) {
	body{
		min-width: unset;
		margin-left:40.1%;
	}
	.aui-footer{
		width:380px;
	}
	.auto{
		width:380px;
		margin-left:40.1%;
	}
	.auto-width{
		width:380px;
	}
	.auto-layer{
		width:350px;
	}
}
@media (min-width: 768px) {
	body{
		min-width: unset;
		margin-left:25.7%;
	}
	.auto{
		width:380px;
		margin-left:25.7%;
	}
}
@media (min-width: 900px) {
	body{
		min-width: unset;
		margin-left:35.7%;
	}
	.auto{
		width:380px;
		margin-left:35.7%;
	}
}

@media (min-width: 1366px) {
	body{
		min-width: unset;
		margin-left:37.1%;
	}
	.auto{
		width:380px;
		margin-left:37.1%;
	}
}/*
@media (min-width: 1400px) {
	body{
		min-width: unset;
		margin-left:40.1%;
	}
	.auto{
		width:380px;
		margin-left:40.1%;
	}
}*/
</style>
    </head>
    <body>
    <style>.beijing_kong{box-shadow:none;background-color:transparent;}</style>
<?php if($islogin2!=1 && $mod!='index'){?>
<style>
body{background:#f5f5f5}
</style>
<script>
login();
</script><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center style="max-width:380px;"><h1><font color="#c5c5c5">刷新重新登录</font></h1><center>
<?php
include 'foot.php';
exit;
}?>