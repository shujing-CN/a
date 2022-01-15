<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = '用户中心';
include 'head.php';
$count1=getnum("SELECT count(*) FROM `zan_users` WHERE `yishangxian` LIKE '%{$users['qq']}%'");
$qiandao=getnum("SELECT count(*) FROM `zan_logs` WHERE `qid` = {$users['id']} AND `addtime` LIKE '%$date%' AND `msg` LIKE '%签到%'");
$orderid = isset($_GET['orderid'])?daddslashes($_GET['orderid']):'';
if($orderid){$pay_return = get_row("SELECT * FROM `zan_pay` WHERE orderno=".$_GET['orderid']."");}
?>
<style>
.test div.layui-layer-btn{
	padding: 0 20px 12px;
}
</style>
<body>
	<section class="aui-flexView">
	<header class="aui-navBar aui-navBar-fixed">
		<a href="/" class="aui-navBar-item">
			<i class="icon icon-return"></i>
		</a>
		<div class="aui-center">
			<span class="aui-center-title"></span>
		</div>
		<a onclick="logout('成功退出登录！')" class="aui-navBar-item" >
			<i class="icon icon-user"></i>
		</a>
	</header>
	<section class="aui-scrollView">
		<div class="aui-chang-box"></div>
		<div class="aui-chang-list">
			<div class="aui-user-img">
				<img style=" width:100%;height:auto;display:block;border: 0;" src="http://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $users['qq']?>&spec=100" alt="">
			</div>
			<div class="aui-user-text">
				<h1><?php echo $users['name']?></h1>
				<span><?php echo $vip==1?'<button> 本 站 尊 贵 V I P</button>':'<big>普 通 用 户</big>';?></span>
				<br>
				<?php echo $vip==1?'到期时间：'.date("Y-m-d",strtotime($users['vip_time'])):'<button onclick="window.location.href=\'?mod=jifen\';">推广赚积分，免费兑换VIP>></button>';?>
				
			</div>
			<div class="aui-jf">积分<?php echo $users['jifen']?></div>
		</div>
		<div class="aui-palace aui-palace-one">
			<a onclick="qiandao()" class="aui-palace-grid">
				<div class="aui-palace-grid-icon">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/nav-001.png" alt="">
				</div>
				<div class="aui-palace-grid-text">
					<h2>每日签到</h2>
				</div>
			</a>
			<a onclick="chongzhi()" class="aui-palace-grid">
				<div class="aui-palace-grid-icon">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/nav-002.png" alt="">
				</div>
				<div class="aui-palace-grid-text">
					<h2>积分充值</h2>
				</div>
			</a>
			<a href="?mod=jifen" class="aui-palace-grid">
				<div class="aui-palace-grid-icon">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/nav-003.png" alt="">
				</div>
				<div class="aui-palace-grid-text">
					<h2>积分商城</h2>
				</div>
			</a>
			<a onclick="tuiguang()" class="aui-palace-grid">
				<div class="aui-palace-grid-icon">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/nav-004.png" alt="">
				</div>
				<div class="aui-palace-grid-text">
					<h2>赚取积分</h2>
				</div>
			</a>
		</div>             
		<div class="divHeight"></div>
		<div class="aui-list-item">
						<?php if(config('bottom')!=''){?>
			<a class="aui-flex b-line">
				<div class="aui-cou-img">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/gonggao.png" alt="">
				</div>小贴士：
				<div class="aui-flex-box" style="max-width:380px;">
					<p><marquee><big>由于官方限制，原来的后台自动互赞已换成为点赞加速服务</big></marquee></p>
				</div>
			</a>
    <?php }?>
			<a href="javascript:;" class="aui-flex b-line">
				<div class="aui-cou-img">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/shandian.png" alt="">
				</div>
				<div class="aui-flex-box">
					<p>点赞加速：<?php if($vip==1){echo '<i><font color="orange">正在享受VIP速度加成50%</font></i>';}else{echo '<i><font color="gray">成为VIP可享受50%点赞加速~</font></i>';}?></p>
				</div>
			</a>
			<a href="javascript:;" class="aui-flex b-line">
				<div class="aui-cou-img">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-006.png" alt="">
				</div>
				<div class="aui-flex-box">
					<p>自动互赞：<?php echo $_COOKIE['zidong']=='1'?'<button class="xc1" onclick="setCookie(\'zidong\',\'0\');getimg(\'http://oss.v8tao.cn/img/off_success.png\',\'?mod=user\',0,2);">已开启</button>':'<button class="xc3" onclick="setCookie(\'zidong\',\'1\');getimg(\'http://oss.v8tao.cn/img/open_success.png\',\'?mod=user\',0,2);">未开启</button>';?></p>
				</div>
			</a>
			<a href="javascript:;" class="aui-flex b-line">
				<div class="aui-cou-img">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/user-003.png" alt="">
				</div>
				<div class="aui-flex-box">
					<p>今日已赞：<?php echo $count1?> 人 <button class="xc3" onclick="stop(<?php echo $users['qq']?>)">紧急暂停</button></p>
				</div>
			</a>
			<a href="javascript:;" class="aui-flex b-line">
				<div class="aui-cou-img">
					<img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-005.png" alt="">
				</div>
				<div class="aui-flex-box">
					<p>今日被赞：<?php echo $vip==1?substr_count($users['yishangxian'], ',').' / 9999人 <button class="xc2">VIP专享</button>':substr_count($users['yishangxian'], ',').' / '.$user_edu.'人 <button class="xc3">VIP无上限</button>';?>
					</p>
				</div>
			</a>
			<br><br>
    <?php 
		//邀请奖励
		$imgs[]='yaoqing';
		//积分充值
		if(config('payurl')==''){$imgs[]='jf_chongzhi';}else{$imgs[].='chongzhi_fail';}
		//每日签到
		if($qiandao==0){$imgs[]='qg_success';}else{$imgs[]='qiandao_fail';}
		//脚本互赞
		if($_COOKIE['zidong']=='1'||$_COOKIE['zidong']==null){$imgs[]='off_success';}else{$imgs[]='open_success';}
		//var_dump($imgs);
		foreach ($imgs as $img){
			echo '<img src="http://oss.v8tao.cn/img/'.$img.'.png" width="0" height="0">'."\r\n";
		}
	?>
	</section>
	</section>
	<script src="//cdn.staticfile.org/modernizr/2.8.3/modernizr.min.js"></script>
	<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
	<?php
		if($count1>=substr_count($users['yishangxian'], ',')){
			$stop_status = 'true';
		}else{
			$stop_status = 'false';
		}
		if($pay_return['status']=='1'){
			echo '<script>
			layer.alert("恭喜您成功充值12888点积分",{
				icon:1
			},function(){
				window.location.href="?mod=user";
			})
			
			</script>';
		}
	?>
	<script>
		function stop(qq){
			var stop_status = <?php echo $stop_status;?>;
			if(stop_status){
				layer.confirm(1,{
				  title:'友情提示',
				  content:'您确定要停止互赞吗?',
				  btn: ['确定','算了']
				}, function(){
					layer.confirm(1,{
				      title:'友情提示',
					  content:'关闭互赞后',
					  btn: ['确定','算了']
					},function(){
						$.ajax({
						    type: "POST",
						    url: '<?php echo $HTTP_HOST;?>/includes/huzan_ajax.php?act=stop',
					      	data : {qq:qq},
						    dataType: "json",
							success: function(data){
								layer.alert(data.msg,{
									title:'友情提示'
								},function(){
									window.location.reload();
								});
							},
							 error: function(){
								layer.msg('服务器错误，请稍后再试！',{icon:5}); 
							 }
						});
					});
				});
			}else{
				var jifen = '<?php echo $users['jifen']?>';
				var xf_jifen = <?php echo (substr_count($users['yishangxian'], ',')-$count1)*10?>;
				layer.alert(1,{
					skin:'test',
					title:'暂停失败',
					btn:['继续停止（消耗'+xf_jifen+'积分）'],
					content:'<center>已赞人数不能小于被赞人数！<hr>为什么要积分才能暂停：防止白嫖<hr>消耗积分 = 被赞人数 * 10</center>'
				},function(){
					if(jifen<xf_jifen){
						layer.alert('您的积分不足<br>还差'+xf_jifen+'点积分',{
							title:'关闭失败'
						});
					}else{
						$.ajax({
						    type: "POST",
						    url: '<?php echo $HTTP_HOST;?>/includes/huzan_ajax.php?act=stop',
					      	data : {qq:qq,xf_jifen:xf_jifen},
						    dataType: "json",
							success: function(data){
								layer.alert(data.msg,{
									title:'友情提示'
								},function(){
									window.location.reload();
								});
							},
							 error: function(){
								layer.msg('服务器错误，请稍后再试！',{icon:5}); 
							 }
						});
					}
				});
			}
		}
	</script>
</body>
</html>
<?php include 'foot.php'?>
</body>
</html>