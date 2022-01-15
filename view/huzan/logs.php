<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = '积分明细';
include 'head.php';
$num=getnum("SELECT count(*) FROM `zan_logs` WHERE `qid` = {$users['id']}");
?>
<section class="aui-flexView">
    <section class="aui-scrollView">
        <div class="aui-money-list">
<?php
foreach($DB->query("SELECT * FROM `zan_logs` WHERE `qid` = {$users['id']} ORDER BY `zan_logs`.`id` DESC limit 30")->fetchAll() as $row){
	$type='-';$type2='兑换';$dhqq='<p><small>兑换QQ：'.$users['qq'].'</small></p>';$type3='兑换时间';
	if(strpos($row['msg'],'VIP')){$img=$HTTP_HOST.'/assets/huzan/img/vip.png';$dhqq='';}
	if(strpos($row['msg'],'透明头像'))$img=$HTTP_HOST.'/assets/huzan/img/tmtx.png';
	if(strpos($row['msg'],'空白网名'))$img=$HTTP_HOST.'/assets/huzan/img/kbwm.png';
	if(strpos($row['msg'],'拒绝添加'))$img=$HTTP_HOST.'/assets/huzan/img/jjtj.png';
	if(strpos($row['msg'],'隐藏搜索'))$img=$HTTP_HOST.'/assets/huzan/img/ycss.png';
	if(strpos($row['msg'],'空白网名'))$img=$HTTP_HOST.'/assets/huzan/img/kbwm.png';
	if(strpos($row['msg'],'评论审核'))$img=$HTTP_HOST.'/assets/huzan/img/plsh.png';
	if(strpos($row['msg'],'留言审核'))$img=$HTTP_HOST.'/assets/huzan/img/lysh.png';
	if(strpos($row['msg'],'注册时间'))$img=$HTTP_HOST.'/assets/huzan/img/regtime.png';
	if(strpos($row['msg'],'特别关心'))$img=$HTTP_HOST.'/assets/huzan/img/tbgx.png';
	if(strpos($row['msg'],'好友时长')){
$dhqq='<p><small>查询QQ：'.$row['qq'].'</small></p>';$type3='查询时间';$img=$HTTP_HOST.'/assets/huzan/img/hysc.png';
	}
	if(strpos($row['msg'],'被赞额度')){$img=$HTTP_HOST.'/assets/huzan/img/zengjia.png';$dhqq='';}
	if($row['type']=='签到'){$img=$HTTP_HOST.'/assets/huzan/img/jiangli.png';$dhqq='';$type3='奖励时间';$type='+';}
	if(strpos($row['msg'],'名片赞')){
		$img=$HTTP_HOST.'/assets/huzan/logs_img/mpz.png';
		$dhqq='<p>兑换号码：'.$row['qq'].'</p>';
	}if(strpos($row['msg'],'删除留言')){
		$img=$HTTP_HOST.'/assets/huzan/img/delly.png';
		$dhqq='<p>操作QQ：'.$users['qq'].'</p>';
		$type3='删除时间';
	}if(strpos($row['msg'],'删除说说')){
		$img=$HTTP_HOST.'/assets/huzan/img/delss.png';
		$dhqq='<p>操作QQ：'.$users['qq'].'</p>';
		$type3='删除时间';
	}
	if(strpos($row['msg'],'QQ余额')){
		$dhqq='<p><small>查询QQ：'.$users['qq'].'</small></p>';$type3='查询时间';$img=$HTTP_HOST.'/assets/huzan/img/money.png';
	}
	if($row['type']=='邀请新人'){
		$img='http://q4.qlogo.cn/headimg_dl?dst_uin='.$row['qq'].'&spec=100';
		$type='+';$type2='邀请';$type3='邀请时间';$dhqq='<p><small>被邀QQ：'.$row['qq'].'</small></p>';
	}
	if($row['type']=='被邀奖励'){
		$img='http://q4.qlogo.cn/headimg_dl?dst_uin='.$row['qq'].'&spec=100';
		$type='+';$type2='邀请';$type3='邀请时间';$dhqq='<p><small>邀请者：'.$row['qq'].'</small></p>';
	}
	if($row['type']=='充值积分'||$row['type']=='接口充值'){
		$img=$HTTP_HOST.'/assets/huzan/img/pay.png';
		$type='+';$type2='邀请';$type3='充值时间';$dhqq='';
	}
	if($row['type']=='扣除积分'){
		$img=$HTTP_HOST.'/assets/huzan/img/pay.png';
		$type3='扣除时间';$dhqq='';
	}
	if($row['type']=='接口充值'){
		$img=$HTTP_HOST.'/assets/huzan/img/pay.png';
		$type3='充值时间';$dhqq='';
	}
?> 
                    <a href="javascript:;" class="aui-flex">
                        <div class="aui-money-logo">
                            <img src="<?=$img?>">
                        </div>
                        <div class="aui-flex-box">
                            <h2><?=$row['msg']?>  <em <?if($type=='+')echo 'style="color:#0bb02e;"'?>><?=$type?> <?=$row['jifen']?>积分</em></h2>
                            <?=$dhqq?>
                            <p><small><?php echo $type3;?>：<?=$row['addtime']?></small></p>
                        </div>
                    </a>
                    <?$dhqq='';$img='';$type3='';}?>
                    <?if($num==0)echo '<br><br><br><br><br><br><br><br><br><br><br><br><center><big><font color="#cbcac8">空空如也，先去邀人吧</font></big></center>'?>
                </div>
            </section>
        </section>
    </body>
</html>