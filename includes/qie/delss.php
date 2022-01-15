<?php
//空间删除说说

require 'qq.inc.php';


$qq=isset($_GET['qq']) ? $_GET['qq'] : null;
$skey=isset($_GET['skey']) ? $_GET['skey'] : null;
$pskey=isset($_GET['pskey']) ? $_GET['pskey'] : null;

$method=isset($_GET['method']) ? $_GET['method'] : 2;

if($qq && $skey && $pskey){}else{exit(json_encode(array('code'=>'-1','msg'=>'请先登录QQ空间！')));}


require_once 'qzone.class.php';
$qzone=new qzone($qq,$sid,$skey,$pskey);
	if($method==3){
		$qzone->shuodel(1);
	}else{
		$qzone->shuodel(0);
	}


foreach($qzone->msg as $result){$data.=$result.'<br/>';}
if($result=='获取说说列表成功！')exit(json_encode(array('code'=>'0','msg'=>'说说列表为空！')));
if(strstr($data,"成功[PC]"))exit(json_encode(array('code'=>'1','msg'=>$data)));
echo json_encode(array('code'=>'2','msg'=>$data));

//SKEY失效通知
if($qzone->skeyzt){
	sendsiderr($qq,$skey,'skey');
}

?>