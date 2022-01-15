<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
	function check($name,$mod){
		if($mod==$name){
			return 'aui-tabBar-item-active';
		}
	}
?>
<footer class="aui-footer aui-footer-fixed auto" >
    <a href="/" style="text-decoration: none" class="aui-tabBar-item <?php echo check('index',$mod);?>">
        <span class="aui-tabBar-item-icon">
            <i class="fa fa-home fa-tanget"></i>
        </span>
        <span class="aui-tabBar-item-text">首页</span>
    </a>
    <a href="?mod=tool" style="text-decoration: none" class="aui-tabBar-item <?php echo check('tool',$mod);?>">
        <span class="aui-tabBar-item-icon">
            <i class="fa fa-star-half-o"></i>
        </span>
        <span class="aui-tabBar-item-text">助手</span>
    </a>
    <a href="?mod=huzan" style="text-decoration: none" class="aui-tabBar-item <?php echo check('huzan',$mod);?>">
        <span class="aui-tabBar-item-icon">
            <i class="fa fa-thumbs-o-up"></i>
        </span>
        <span class="aui-tabBar-item-text">互赞</span>
    </a>
    <a href="?mod=jifen" style="text-decoration: none" class="aui-tabBar-item <?php echo check('jifen',$mod);?>">
        <span class="aui-tabBar-item-icon">
            <i class="fa fa-diamond"></i>
        </span>
        <span class="aui-tabBar-item-text">积分</span>
    </a>
    <a href="?mod=user" style="text-decoration: none" class="aui-tabBar-item <?php echo check('user',$mod);?>">
        <span class="aui-tabBar-item-icon">
            <i class="fa fa-user"></i>
        </span>
        <span class="aui-tabBar-item-text">我的</span>
    </a>
</footer>
<script>
function bottom(mod){
	layer.open({
	   type: 2,
	   skin: 'layui-layer-molv',
	   title: '网站公告',
	   closeBtn:0,
	   btn:['已阅读'],
	   area: ['310px', '420px'],
	   content: '?mod=gonggao&page='+mod
	});
	$('.layui-layer-btn0').attr("onclick",'gg_ok(\''+mod+'\')');
}
function gg_ok(mod){
		setCookie(mod+'_gg',1);
		setCookie('is_'+mod,<?php echo time();?>);
		layer.close(layer.index);
}
</script>
<?php
	if($_COOKIE['is_'.$mod.'']<strtotime("-360 minutes") && $islogin2==1 && $mod!='index' && bottom($mod)){
		echo "<script>setCookie('".$mod."_gg',0);bottom('".$mod."')</script>";
	}elseif($mod=='index' && $_COOKIE['is_'.$mod.'']<strtotime("-360 minutes") && bottom($mod)){
		echo "<script>bottom('".$mod."')</script>";
	}
?>
<script>
<?php if($_GET['do']=='tg'){?>tuiguang()<?php }?>
function chongzhi(){
<?php if(config('is_pay')==1){echo 'getimg(\'http://oss.v8tao.cn/img/jf_chongzhi.png"\',\'javascript:pay_cz('.$users['id'].');\',1,3);';}else{echo 'getimg(\'http://oss.v8tao.cn/img/chongzhi_fail.png\',\'javascript:layer.close(layer.index);\',0);';}?>
}
</script>