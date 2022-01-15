<?php
include('inc.php');
$logins_config=json_decode(config('qqlogin'),true);
if($logins_config['login_api']!='')exit(file_get_contents($logins_config['login_api'].'?'.$_SERVER["QUERY_STRING"]));
//配置代理IP
$proxy='';//不需要则为空
error_reporting(0);
require 'login.class.php';
$login=new qq_login();
if($proxy!='' && $proxy){
	$login->setProxy($proxy);
}
if($_GET['do']=='getqrpic'){
	$array=$login->getqrpic();
}
elseif($_GET['do']=='qrlogin'){
	if(isset($_GET['findpwd']))session_start();
	$array=$login->qrlogin($_GET['qrsig']);
}
echo json_encode($array);