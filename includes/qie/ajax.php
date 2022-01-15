<?php
error_reporting(0);
include('../inc.php');
include('qie.class.php');
include('qd.class.php');
$qqsign = new qqsign($users['qq'],$users['sid'],$users['skey'],$users['pskey']);
if($islogin2!=1)exit(json_encode(array("code"=>0,"msg"=>'登录失效！')));

$act=$_GET['act'];

if($act=='qie'){
	$task=!empty($_POST['task'])?daddslashes($_POST['task']):exit(json_encode(array("code"=>0,"msg"=>'缺少参数！')));
	$num=!empty($_POST['num'])?daddslashes($_POST['num']):null;
	$qq=!empty($_POST['qq'])?daddslashes($_POST['qq']):null;
	if($users['jifen']<$qie_config[$task] && $vip!=1 && $task!='yjqd')exit(json_encode(array("code"=>0,"msg"=>'账户余额不足！')));
	if($task=='qqoem'){
		$skey=!empty($_POST['skey'])?daddslashes($_POST['skey']):null;
		$pt4_token=!empty($_POST['pt4_token'])?daddslashes($_POST['pt4_token']):null;
		$imei=!empty($_POST['imei'])?daddslashes($_POST['imei']):null;
		$desc=!empty($_POST['desc'])?daddslashes($_POST['desc']):null;
		$data=qqoem($users['qq'],$skey,$pt4_token,$imei,$desc);
		//if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['qqoem'],'兑换','使用了透明头像功能');
		exit($data);
	}elseif($task=='tmtx'){
		$data=tmtx($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['tmtx'],'兑换','使用了透明头像功能');
		exit($data);
	}elseif($task=='kbwm'){
		$data=kbwm($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['kbwm'] ,'兑换','使用了空白网名功能');
		exit($data);
	}elseif($task=='jjtj'){
		$data=jjtj($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['jjtj'],'兑换','使用了拒绝添加功能');
		exit($data);
	}elseif($task=='ycss'){
		$data=ycss($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['ycss'],'兑换','使用了隐藏搜索功能');
		exit($data);
	}elseif($task=='lysh'){
		$data=lysh($users['qq'],$users['skey'],$users['pskey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['lysh'],'兑换','使用了留言审核功能');
		exit($data);
	}elseif($task=='plsh'){
		$data=plsh($users['qq'],$users['skey'],$users['pskey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['plsh'],'兑换','使用了评论审核功能');
		exit($data);
	}elseif($task=='money'){
		$data=money($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['money'],'兑换','查询了QQ余额一次');
		exit($data);
	}elseif($task=='tbgx'){
		$data=query_tbgx($users['qq'],$users['pskey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['tbgx'],'兑换','查询特别关心一次');
		exit($data);
	}elseif($task=='regtime'){
		$data=regtime($users['qq'],$users['skey']);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['regtime'],'兑换','查询了注册时间一次');
		exit($data);
	}elseif($task=='hysc'){
		$data=hysc($users['qq'],$users['skey'],$users['pskey'],$qq);
		if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config['hysc'],'兑换','查询了好友时长一次',$qq);
		exit($data);
	}elseif($task=='delss'||$task=='delly'){
		$msg='批量删除留言一次';
		if($task=='delss')$msg='批量删除说说一次';
	    $data = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/includes/qie/'.$task.'.php?qq='.$users['qq'].'&skey='.$users['skey'].'&pskey='.$users['pskey']);
	    if(strpos($data,'"code":"1"') && $vip!=1)user_jf($users['id'],$qie_config[$task],'兑换',$msg,$qq);
	    exit($data);
	}elseif($task=='yjqd'){
			if($num==1){
				$qqsign->weishi();
			}elseif($num==2){
				$qqsign->buluo(1);
			}elseif($num==3){
				$qqsign->buluo(2);
			}elseif($num==4){
				$qqsign->buluo(2);
				//$qqsign->qqtask(); //需要$superkey 
			}elseif($num==5){
				$qqsign->gameqd(1);
			}elseif($num==6){
				$qqsign->gameqd(2);
			}elseif($num==7){
				$qqsign->gameqd(3);
			}elseif($num==8){
				$qqsign->weiyun();
			}elseif($num==9){
				$qqsign->qqmusic(1);
			}elseif($num==10){
				$qqsign->qqmusic(2);
			}elseif($num==11){
				$qqsign->qqmusic(3);
			}elseif($num==12){
				$qqsign->checkin();
			}elseif($num==13){
				$qqsign->qqgame();
			}elseif($num==14){
				$qqsign->mqq();
			}elseif($num==15){
				$qqsign->vipqd(1);
			}elseif($num==16){
				$qqsign->vipqd(2);
			}elseif($num==17){
				$qqsign->vipqd(3);
			}elseif($num==18){
				$qqsign->vipqd(4);
			}elseif($num==19){
				$qqsign->vipqd(5);
			}elseif($num==20){
				$qqsign->vipqd(6);
			}elseif($num==21){
				$qqsign->vipqd(7);
			}elseif($num==22){
				$qqsign->bigvip(1);
			}elseif($num==23){
				$qqsign->bigvip(2);
			}elseif($num==24){
				$qqsign->yqd(1);
			}elseif($num==25){
				$qqsign->yqd(2);
			}elseif($num==26){
				$qqsign->dldqd();
			}elseif($num==27){
				$qqsign->gameqd(4);
			}elseif($num==28){
				$qqsign->gameqd(5);
			}elseif($num==29){
				$qqsign->gameqd(6);
			}elseif($num==30){
				$qqsign->bookqd(1);
			}elseif($num==31){
				$qqsign->bookqd(2);
			}elseif($num==32){
				$qqsign->bookqd(3);
			}elseif($num==33){
				$qqsign->bookqd(4);
			}elseif($num==34){
				$qqsign->bookqd(5);
			}elseif($num==35){
				$qqsign->gameqd(7);
			}elseif($num==36){
				$qqsign->yundong();
			}elseif($num==37){
				$qqsign->qqllq();
			}
	}else{
		exit(json_encode(array("code"=>0,"msg"=>'您选择的工具不在范围内！')));
	}
	//exit(json_encode(array("code"=>1,"msg"=>'设置成功！')));
}else{
	exit(json_encode(array("code"=>0,"msg"=>'not act！')));
}