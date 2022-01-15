<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在为您跳转到支付页面，请稍候...</title>
    <style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(../assets/load.gif) no-repeat 20px 26px;
            text-indent:22px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
<script>
function open_without_referrer(link){
document.body.appendChild(document.createElement('iframe')).src='javascript:"<script>top.location.replace(\''+link+'\')<\/script>"';
}
</script>
</head>
<body>
<?php
/* *
 * 功能：即时到账交易接口接入页
 * 
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */
require '../includes/inc.php';
require_once("epay.config.php");
require_once("lib/epay_submit.class.php");

	$type=isset($_GET['type'])?daddslashes($_GET['type']):exit('No type!');
	$out_trade_no=isset($_GET['orderid'])?daddslashes($_GET['orderid']):exit('No orderid!');
	$row = get_row("SELECT * FROM zan_pay WHERE orderno=".$out_trade_no."");
	
	$notify_url = $HTTP_HOST."/notify_url.php";
	$return_url = $HTTP_HOST."/return_url.php";
	//exit($return_url);
	//支付方式
	//商品名称
	$name = $_POST['WIDsubject'];
	//付款金额
	$money = $_POST['WIDtotal_fee'];
	//站点名称
	$sitename = $_POST['sitename'];
	//必填

        //订单描述


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"pid" => trim($alipay_config['partner']),
		"type" => $type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"name"	=> '互赞宝积分充值',
		"money"	=> $row['money'],
		"sitename"	=> config('sitename')
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;

?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>