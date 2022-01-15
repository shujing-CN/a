<?php
include('inc.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'pay_cz':
	$orderid = date("YmdHis").mt_rand(100,999);
	$qq=daddslashes($_POST['qq']);
	$time_sql = get_row("SELECT * FROM `zan_pay` WHERE `uid`=".$qq." ORDER BY `addtime` DESC");
	if(strtotime($time)-strtotime($time_sql['addtime'])<5){
		exit(json_encode(array('code'=>0,'msg'=>'您的操作频繁,请 5 秒后再试~')));
	}
	$res = $DB->query("INSERT INTO `zan_pay` (`orderno`, `addtime`, `money`, `status`, `jifen`,`uid`) VALUES ('".$orderid."', '".$time."', '6.00', '0', '12888', '".$qq."');");
	if($res){
		echo json_encode(array('code'=>1,'orderno'=>$orderid,'money'=>'6.00'));
	}
break;
case 'getcookies':
	$qq=isset($_POST['qq'])?daddslashes($_POST['qq']):exit(json_encode(array('code'=>'0','msg'=>'参数不完整！')));
	$skey=isset($_POST['skey'])?daddslashes($_POST['skey']):exit(json_encode(array('code'=>'0','msg'=>'参数不完整！')));
	$pskey=isset($_POST['pskey'])?daddslashes($_POST['pskey']):exit(json_encode(array('code'=>'0','msg'=>'参数不完整！')));
	$logins_config=json_decode(config('qqlogin'),true);
	if($logins_config['is_yz']==1){
		if(jiance_qqzt($qq,$pskey)=='0')exit(json_encode(array('code'=>'0','msg'=>'登录效验失败！')));//检测QQ是否正常
	}
	$invite_qq=isset($_COOKIE['invite_qq'])?daddslashes($_COOKIE['invite_qq']):null;
	$name=daddslashes($_POST['name']);
	$num=getnum("SELECT * FROM `zan_users` WHERE `qq` LIKE '$qq'");
	if($num==0){
		$DB->query("INSERT INTO `zan_users` (`id`, `status`, `qq`, `skey`, `pskey`, `addtime`, `logintime`, `zan_time`, `fail_time`, `jifen`, `name`, `yishangxian`, `beizan_time`, `vip_time`, `edu`) VALUES (NULL, '1', '$qq', '$skey', '$pskey', '$time', '$time', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '0', '$name', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '0')");
		$users=get_row("SELECT * FROM zan_users WHERE qq='$qq' limit 1");
		if($invite_qq!=null){
			$invite=get_row("SELECT * FROM zan_users WHERE qq='$invite_qq' and qq!=$qq limit 1");
			if($invite){
				$DB->query("INSERT INTO `zan_logs` (`qid`, `type`, `jifen`, `addtime`, `msg`, `qq`) VALUES ('{$invite['id']}', '邀请新人', '6000', '$time', '成功邀请了Ta', '$qq')");
				$DB->query("UPDATE `zan_users` SET `jifen` = jifen+6000 WHERE `zan_users`.`id` = {$invite['id']}");
				
				$DB->query("INSERT INTO `zan_logs` (`qid`, `type`, `jifen`, `addtime`, `msg`, `qq`) VALUES ('{$users['id']}', '被邀奖励', '2888', '$time', '成功被ta邀请', '{$invite['qq']}')");
				$DB->query("UPDATE `zan_users` SET `jifen` = jifen+2888 WHERE `zan_users`.`qq` = $qq");
			}
			$is_invite=1;
		}
	}else{
		$DB->query("UPDATE `zan_users` SET `status` = '1', `skey` = '$skey', `pskey` = '$pskey',`name` = '$name', `logintime` = '$time' WHERE `zan_users`.`qq` = $qq");
	}
	$users=get_row("SELECT * FROM zan_users WHERE qq='$qq' limit 1");
	setcookie('user_id',$users['id'],time()+172800,"/");
	setcookie('user_token',md5($users['qq'].$users['skey'].$users['id'].'1'),time()+172800,"/");
	echo json_encode(array('code'=>'1','invite'=>$is_invite,'msg'=>'登录成功'));
break;

case 'duihuan':
	$id=isset($_POST['id'])?daddslashes($_POST['id']):null;
	if($islogin2==0)exit(json_encode(array("code"=>-1,"msg"=>'请先登录')));
	if($id==1){
		$jf=12888;$name='兑换一个月VIP';$date=query_vip($users['vip_time'],31);
	}elseif($id==2){
		$jf=32888;$name='兑换三个月VIP';$date=query_vip($users['vip_time'],93);
	}elseif($id==3){
		$jf=3288;$name='兑换50被赞额度';$num=50;
	}elseif($id==4){
		$jf=6299;$name='兑换99被赞额度';$num=99;
	}else exit(json_encode(array("code"=>0,"msg"=>'您选择的奖品不在范围内！')));
	if($users['jifen']<$jf)exit(json_encode(array("code"=>0,"msg"=>'您的积分不足，先去推广赚赚吧 ！')));
	if($id==1||$id==2){
		$DB->query("UPDATE `zan_users` SET `vip_time` = '$date',`jifen` = jifen-$jf WHERE `zan_users`.`id` = {$users['id']}");
		$DB->query("INSERT INTO `zan_logs` (`qid`, `type`, `jifen`, `addtime`, `msg`) VALUES ('{$users['id']}', '积分兑换', '$jf', '$time', '$name')");
	}
	if($id==3||$id==4){
		$DB->query("UPDATE `zan_users` SET `edu` = edu+$num,`jifen` = jifen-$jf WHERE `zan_users`.`id` = {$users['id']}");
		$DB->query("INSERT INTO `zan_logs` (`qid`, `type`, `jifen`, `addtime`, `msg`) VALUES ('{$users['id']}', '积分兑换', '$jf', '$time', '$name')");
		$is_edu=1;
	}
	exit(json_encode(array("code"=>1,"msg"=>'成功'.$name,"xufei"=>$vip,"is_edu"=>$is_edu)));
break;

case 'fhurl':
	if($islogin2==0)exit(json_encode(array("code"=>-1,"msg"=>'请先登录')));
	$fhapi=config('fhurl');
	if($fhapi=='0')$fhapi='http://auth.nb.huzanbao.cn:88/getfh.php?longurl=';
	$url=$fhapi.urlencode('http://'.$_SERVER['HTTP_HOST'].'/?invite_qq='.$users['qq']);
	$data=file_get_contents($url);
	$arr = json_decode($data,true);
	if($arr['msg']=='succ' || $arr['code']==1){
		$dwz = $arr['ae_url'];
		if($arr['msg']=='succ')$dwz = $arr['dwz1'];
		$content=''."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".'【'.config('sitename').'】'."\r\n".''."\r\n".'每天扫一扫，轻松五千赞！'."\r\n".''."\r\n".'还不快来用？互赞没烦恼！'."\r\n".''."\r\n".'复制网址到浏览器打开：'."\r\n".''.$dwz;
		exit(json_encode(array("code"=>1,"msg"=>'可以试试这在线互赞助手，一键自动帮你互赞，轻松几千赞，链接：'.$dwz.'<br><center><button class="btn btn-block btn-warning" data-clipboard-text="可以试试这在线互赞助手，一键自动帮你互赞，轻松几千赞，链接：'.$dwz.'" id="copy-btn">一键复制</button></center><style>.btn-block{display:block;width:100%;}.btn-warning{color:#fff;background-color:#f0ad4e;border-color:#eea236;}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px;}</style><script>var clipboard=new Clipboard("#copy-btn");clipboard.on("success",function(e){layer.msg("复制成功，可以发送给朋友啦！",{icon:1})});clipboard.on("error",function(e){layer.msg("复制失败，请长按链接后手动复制",{icon:2})});</script>')));
	}else{
		exit(json_encode(array("code"=>0,"msg"=>'生成失败：'.$arr['msg'].'<hr><center>站长可尝试更换防红接口</center>')));
	}
break;

case 'getzan':
	if($islogin2==0)exit(json_encode(array("code"=>-1,"msg"=>'请先登录')));
	$id=!empty($_POST['id'])?daddslashes($_POST['id']):exit(json_encode(array("code"=>0,"msg"=>'参数不完整！')));
	$key=!empty($_POST['key'])?daddslashes($_POST['key']):exit(json_encode(array("code"=>0,"msg"=>'参数不完整！')));
	$num=substr_count($users['yishangxian'], ',');
	if($num>=$user_edu && $vip!=1){
	setcookie('zidong',0,time()+172800,"/");exit(json_encode(array("code"=>-3,"msg"=>'<center>今日被赞次数已达上限！<hr>今日被赞：'.$num.'/'.$user_edu.'人（普通用户）<hr>开通VIP可享无限额度哦！<hr><a style="color:orange" href="?mod=jifen">邀人送积分，免费兑换VIP > ></center>')));//判断是否上限
	}
	$row=get_row("SELECT * FROM `zan_users` WHERE `id`='$id' limit 1");
	if($row){
		if(md5($row['qq']*2)!=$key)exit(json_encode(array("code"=>0,"msg"=>'签名效验失败！')));//签名效验
		$data=get_mpz($row['qq'],$row['skey'],$row['pskey'],$users['qq'],$server);
		if($data=='点赞成功'){
			$DB->query("UPDATE `zan_users` SET `beizan_time` = '$time',`yishangxian` =CONCAT(yishangxian,'{$row['qq']},') WHERE `zan_users`.`qq` = {$users['qq']}");
			$DB->query("UPDATE `zan_users` SET `zan_time` = '$time' WHERE `zan_users`.`id` = {$row['id']}");
			exit(json_encode(array("code"=>1,"msg"=>'点赞成功！')));
		}elseif($data=='点赞上限'){
			if(strpos(','.$users['yishangxian'],$row['qq'])){exit(json_encode(array("code"=>-2,"msg"=>'暂时没有匹配到赞友，准备重新匹配！')));}
			$DB->query("UPDATE `zan_users` SET `beizan_time` = '$time',`yishangxian` =CONCAT(yishangxian,'{$row['qq']},') WHERE `zan_users`.`qq` = {$users['qq']}");
			setcookie($row['qq'],'yishangxian');
			exit(json_encode(array("code"=>-2,"msg"=>'暂时没有匹配到赞友，准备重新匹配！')));
		}elseif($data=='登录失效'){
			$DB->query("UPDATE `zan_users` SET `status` = '0' WHERE `zan_users`.`id` = {$row['id']}");
			exit(json_encode(array("code"=>-2,"msg"=>'暂时没有匹配到赞友，准备重新匹配！')));
		}elseif($data=='权限异常'){
			exit(json_encode(array("code"=>-1,"msg"=>'请打开“允许陌生人点赞”选项！')));
		}else{
			if($data=='无法连接到点赞服务器'||$data=='点赞失败'){
				exit(json_encode(array("code"=>-2,"msg"=>'暂时没有匹配到赞友，准备重新匹配！')));
			}
			exit(json_encode(array("code"=>0,"msg"=>$data)));
		}
	}else{
		exit(json_encode(array("code"=>-2,"msg"=>'暂时没有匹配到赞友，准备重新匹配！')));
	}
break;

case 'qiandao':
	if($islogin2==0)exit(json_encode(array("code"=>-1,"msg"=>'请先登录')));
	$code=getnum("SELECT count(*) FROM `zan_logs` WHERE `qid` = {$users['id']} AND `addtime` LIKE '%$date%' AND `msg` LIKE '%签到%'");
	if($code==0){
		$DB->query("INSERT INTO `zan_logs` (`id`, `qid`, `type`, `jifen`, `addtime`, `msg`, `qq`) VALUES ('0', '{$users['id']}', '签到', '90', '$time', '签到奖励', '')");
		$DB->query("UPDATE `zan_users` SET `jifen` = jifen+90 WHERE `zan_users`.`qq` = {$users['qq']}");
		exit(json_encode(array("code"=>1,"msg"=>'签到成功，赠送积分90点')));
	}else{
		exit(json_encode(array("code"=>0,"msg"=>'签到失败，您今日已签过到！')));
	}
break;
case 'stop':
	if($_POST['xf_jifen']){
		$DB->query("UPDATE `zan_users` SET `jifen` = jifen-".$_POST['xf_jifen']." WHERE `zan_users`.`qq` = {$users['qq']}");
	}
		$DB->query("UPDATE `zan_users` SET `status` = 0 WHERE `zan_users`.`qq` = {$users['qq']}");
	exit(json_encode(array("code"=>1,"msg"=>'停止成功')));
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}