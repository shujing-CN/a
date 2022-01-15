<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = '互赞列表';
include 'head.php';
if($_COOKIE[$users['qq'].'jiasu']<date('Y-m-d 00:00:00')==false)$jiasu=2;//今日已试用
if((strtotime($_COOKIE[$users['qq'].'jiasu'])+30)>=strtotime('now'))$jiasu=1;//试用中
?>
<header class="auto-width" style="height: 35px;">
    <?php
    if($vip==1){
    	echo '<a onclick="getimg(\'http://oss.v8tao.cn/img/jiasu-vip.png\',\'javascript:layer.close(layer.index);\',0,4);"><img src="'.$HTTP_HOST.'/assets/huzan/img/jiasu.png"></a>';
    }elseif($jiasu==1){
    	echo '<a onclick="layer.msg(\'正在试用点赞加速！\')"><img height="80%" src="'.$HTTP_HOST.'/assets/huzan/img/jiasu.png"></a>';
    }elseif($jiasu==2){
    	echo '<a onclick="layer.alert(\'<center>您今天已经领取过加速包啦！<hr>成为VIP，也能享受点赞加速特权哦~</center>\',{\'title\':\'小提示\'})"><img height="80%" src="'.$HTTP_HOST.'/assets/huzan/img/jiasu-off.png"></a>';
    }else{
    	echo '<a onclick="setCookie(\''.$users['qq'].'jiasu\',\''.$time.'\');getimg(\'http://oss.v8tao.cn/img/lq_jsb.png\',\'?mod=huzan\',0,2);"><img height="80%" src="'.$HTTP_HOST.'/assets/huzan/img/jiasu-off.png"></a>';
    }
    
    ?>
    <h5>互赞列表</h5>
    <?php echo $_COOKIE['zidong']=='1'?'<div class="aui-jf3" onclick="setCookie(\'zidong\',\'0\');getimg(\'http://oss.v8tao.cn/img/off_success.png\',\'?mod=huzan\',0,2);">关闭自动</div>':'<div class="aui-jf" onclick="setCookie(\'zidong\',\'1\');getimg(\'http://oss.v8tao.cn/img/open_success.png\',\'?mod=huzan\',0,2);">开启自动</div>';?>
</header>
<div class="contain">
<center>
	<?php
	if($vip==1){
		echo '<a onclick="getimg(\'http://oss.v8tao.cn/img/jiasu-vip.png\',\'javascript:layer.close(layer.index);\',0,4);"><img src="http://oss.v8tao.cn/img/jiasu.gif" width="100%"/></a>';
	}elseif($jiasu==1){
		echo '<a onclick="layer.msg(\'正在试用点赞加速！\')"><img src="http://oss.v8tao.cn/img/jiasu_shiyong.gif" width="100%"/></a>';
	}else{
		echo '<a href="?mod=jifen"><img src="'.$HTTP_HOST.'/assets/huzan/img/banner.gif" width="100%"/></a>';
	}
	?>
</center>
<?
$shangxian=$users['yishangxian'].$users['qq'];
foreach($DB->query("SELECT * FROM `zan_users` WHERE `status` = 1 and `qq` NOT IN ($shangxian) ORDER BY rand() limit 15")->fetchAll() as $row){
if(!$row['name'])$row['name']='无名侠客';
$i++;
if($_COOKIE['huzan_gg']==1 || bottom('huzan')==''){
	if($i==1 && $_COOKIE['zidong']==1)$do='<script>getzan(\''.$row['id'].'\',\''.md5($row['qq']*2).'\',1)</script>';
}
?>
<div class="friend-list">
<div class="avatar">
<img src="http://q4.qlogo.cn/headimg_dl?dst_uin=<?=$row['qq']?>&spec=100" alt="">
</div>
<div class="message">
<p class="nickname"><?=$row['name']?></p><br>
<p class="profile">已加入互赞<?=count_days(strtotime(date("Y-m-d")),strtotime($row['addtime']))?>天</p>
</div>
<div class="operate">
<?if(strpos(','.$users['yishangxian'],$row['qq'])){?>
<button style="color:#7a7977">今日上限</button>
<?}else{?>
<div id="zan_<?=$row['id']?>"><button onclick="getzan('<?=$row['id']?>','<?=md5($row['qq']*2)?>',1)" class="attention">让Ta赞我</button></div>
<?}?>
</div>
</div>
<?php }?>
<?php
$shangxian=$users['yishangxian'].$users['qq'];
foreach($DB->query("SELECT * FROM `zan_users` WHERE `status` = 1 and `qq` IN ($shangxian) and `qq`!='{$user['qq']}' ORDER BY `zan_users`.`zan_time` desc limit 60")->fetchAll() as $row){
	if($row['qq']!=$users['qq']){
	if($row['name']==null||$row['name']=='')$row['name']='无名侠客';
	$i++;
?>
<div class="friend-list">
<div class="avatar">
<img src="http://q4.qlogo.cn/headimg_dl?dst_uin=<?=$row['qq']?>&spec=100" alt="">
</div>
<div class="message">
<p class="nickname"><?=$row['name']?></p><br>
<p class="profile">已加入互赞<?=count_days(strtotime(date("Y-m-d")),strtotime($row['addtime']))?>天</p>
</div>
<div class="operate">
<?if(strpos(','.$users['yishangxian'],$row['qq'])){?>
<button style="color:#7a7977">已赞过你</button>
<?}else{?>
<button onclick="getzan('<?=$row['id']?>','<?=md5($row['qq']*2)?>',1)" class="attention">让Ta赞我</button>
<?}?>
</div>
</div>
<?php 
}
}?>
<?php
if($i==0)echo '<br><br><br><br><br><br><br><br><br><br><center><font color="#bfbeb9">当前系统可用QQ已空空如也<br>快叫上你的朋友一起用吧！</font></center>';
?>
</div>
<br><br>
<?php
//图片预加载
if($_COOKIE['zidong']=='1'){$imgs[]='off_success';}else{$imgs[]='open_success';}
if($jiasu!=1 && $jiasu!=2 && $vip!=1){$imgs[]='lq_jsb';}//加速图片
foreach ($imgs as $img){
	echo '<img src="http://oss.v8tao.cn/img/'.$img.'.png" width="0" height="0">'."\r\n";
}
include 'foot.php';
?>
<script>
function dianzan(){
	var num = 1;
	var interval = setInterval(function(){ 
	  if(num<11){
	 layer.msg('成功进行第'+(num++)+'次点赞');
	}else{
		window.location.reload();
		clearInterval(interval);
	}
	 }, <?php if($vip==1 || $jiasu==1){echo config('pinlv')*0.5;}else{echo config('pinlv');}?>); 
}
</script>
<?php echo $do;?>
</body>
</html>