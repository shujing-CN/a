<?php
include './includes/inc.php';
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

if($act=='pay'){
	$qq=isset($_GET['qq'])?daddslashes($_GET['qq']):exit('{"code":0,"msg":"请输入账号"}');
	$jifen=isset($_GET['jifen'])?daddslashes($_GET['jifen']):exit('{"code":0,"msg":"请输入充值积分"}');
	if(is_numeric($qq)==false&&is_numeric($jifen)==false)exit('{"code":0,"msg":"请输入正确的账号或积分"}');
	if($_GET['key']==md5(config('login_user').config('login_pwd')) && $qq && $_GET['jifen']){
		$qq_id = get_row("SELECT * FROM zan_users WHERE qq='$qq'");
		if($qq_id){
			if($DB->exec('UPDATE `zan_users` SET `jifen`=`jifen`+'.$jifen.' WHERE `qq`='.daddslashes($qq).'')){
				add_sql_show($qq_id['id'],'接口充值','自助充值',$_GET['jifen'].'积分');
				exit('{"code":0,"msg":"充值成功"}');
			}else{
				exit('{"code":-1,"msg":"充值失败"}');
			}
		}else{
			exit('{"code":-1"msg":"无此用户"}');
		}
	}else{
		exit('{"code":-1,"msg":"签名校检失败"}');
	}
}else{
	exit('{"code":-1,"msg":"Not act！"}');
}