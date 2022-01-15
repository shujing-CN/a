<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = config('title');
include 'head.php';
$count1=getnum("SELECT count(*) FROM `zan_users`");
$count2=getnum("SELECT count(*) from zan_users where addtime>='$thtime'");
?>
<style>
.auto-layer{
	width:300px;
}
</style>
        <section class="aui-flexView">
            <section class="aui-scrollView">
                <div class="m-slider" data-ydui-slider="">
                    <div class="slider-wrapper" style="transform: translate3d(-4374px, 0px, 0px); transition-duration: 300ms;">
                        <div class="slider-item" style="width: 1458px;">
                            <a href="<?php echo config('img1_url');?>">
                                <img src="<?php echo config('img1');?>">
                            </a>
                        </div>
                        <div class="slider-item" style="width: 1458px;">
                            <a href="<?php echo config('img2_url');?>">
                                <img src="<?php echo config('img2');?>">
                            </a>
                        </div>
                        <div class="slider-item" style="width: 1458px;">
                            <a href="<?php echo config('img3_url');?>">
                                <img src="<?php echo config('img3');?>">
                            </a>
                        </div></div>
                    <div class="slider-pagination"><span class="slider-pagination-item"></span><span class="slider-pagination-item"></span><span class="slider-pagination-item slider-pagination-item-active"></span><span class="slider-pagination-item"></span></div>
                </div>
                <div class="aui-flex aui-flex-white">
                    <div class="aui-sml-logo">
                        <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/tj.jpg" alt="">
                    </div>
                    <div class="aui-flex-box">
                        <h2>数据统计</h2>
                        <p>网站用户总数<?php echo $count1;?>人，今日新增<?php echo $count2;?>人~</p>
                    </div>
                </div>
                <div class="aui-list-theme">
                    <a href="<?php if($islogin2==1){echo 'javascript:tuiguang();';}else{echo 'javascript:login();';}?>" class="aui-list-theme-item">
                        <div class="aui-list-title">
                            <h3>赚取积分</h3>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    <span>百万积分等你赚！</span>
                                </div>
                                <div class="aui-flex-icon-sm">
                                    <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-001.png" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="?mod=huzan" style="text-decoration: none" class="aui-list-theme-item aui-list-color">
                        <div class="aui-list-title">
                            <h3>加入互赞</h3>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    <span>每天轻松几千赞~</span>
                                </div>
                                <div class="aui-flex-icon-sm">
                                    <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-003.png" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="?mod=jifen" class="aui-list-theme-item aui-list-color">
                        <div class="aui-list-title">
                            <h3>积分商城</h3>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    <span>今天兑换点啥呢？</span>
                                </div>
                                <div class="aui-flex-icon-sm">
                                    <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-002.png" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="?mod=tool" class="aui-list-theme-item aui-list-color1">
                        <div class="aui-list-title">
                            <h3>企鹅助手</h3>
                            <div class="aui-flex">
                                <div class="aui-flex-box">
                                    <span>这些功能没用过吧~</span>
                                </div>
                                <div class="aui-flex-icon-sm">
                                    <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-004.png" alt="">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="aui-flex">
                    <div class="aui-flex-box">
                        <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/icon-title.png" alt="">
                    </div>
                    <div class="aui-arrow">
                        <a href="?mod=jifen" style="color:red;"><p>更多推荐</p></a>
                    </div>
                </div>
                <?php if($islogin2==1){?>
                <div class="aui-local-box">
                    <div class="aui-flex">
                        <div class="aui-flex-box">
                            <div class="aui-jiu-logo">
                                <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/zuan.png" alt="">
                            </div>
                            <div class="aui-head-info">邀请1人赚6000积分</div>
                        </div>
                        <div class="aui-head-button" onclick="tuiguang()">
                            <button>点击前往</button>
                        </div>
                    </div>
                </div>
                <?php }else{?>
                <div class="aui-local-box">
                    <div class="aui-flex">
                        <div class="aui-flex-box">
                            <div class="aui-jiu-logo">
                                <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/zan.png" alt="">
                            </div>
                            <div class="aui-head-info">一键轻松自动互赞</div>
                        </div>
                        <div class="aui-head-button" onclick="login()">
                            <button>立即体验</button>
                        </div>
                    </div>
                </div>
             <?php }?>
             <?php
                	if(config('kfqq')){
                		echo '<div class="aui-local-box">
                    <div class="aui-flex">
                        <div class="aui-flex-box">
                            <div class="aui-jiu-logo">
                                <img src="'.$HTTP_HOST.'/assets/huzan/img/kf.png" alt="">
                            </div>
                            <div class="aui-head-info">使用过程遇到不懂？</div>
                        </div>
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.config('kfqq').'&site=qq&menu=yes">
	                        <div class="aui-head-button">
	                            <button>联系客服</button>
	                        </div>
                        </a>
                    </div>
                </div>';
                	}
                ?>
            </section>
            <?php include 'foot.php'?>
        </section>
</body>
<?php
	if($_COOKIE['is_gg']){
		if($_COOKIE['is_gg']<strtotime("-720 minutes")){
			echo '<script>var is_gg = true;</script>';
		}else{
			echo '<script>var is_gg = false;</script>';
		}
	}else{
		echo '<script>var is_gg = true;</script>';
	}
?>
</html>