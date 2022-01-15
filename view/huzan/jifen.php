<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = '积分商城';
include 'head.php';
$count1=getnum("SELECT count(*) FROM `zan_logs` WHERE `qid` = {$users['id']} and `type`='邀请新人'");
?>
        <section class="aui-flexView">
            <header class="aui-navBar aui-navBar-fixed b-line">
                <a onclick="chongzhi()" class="aui-navBar-item">
                    <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/nav-002.png" width="55%"/>
                </a>
                <div class="aui-center">
                    <span class="aui-center-title">积分商城</span>
                </div>
                <a class="aui-navBar-item">
                    <?php echo '总共邀请：'.$count1.'人';?>
                </a>
            </header>
            <section class="aui-scrollView">
                <div class="aui-flex aui-flex-color">
                    <div class="aui-flex-box">
                        <h2>您拥有的积分: <em><?php echo $users['jifen']?></em></h2>
                    </div>
                    <div class="aui-arrow"><small><a onclick="jf_logs()">积分明细</a></small></div></div>
                </div><br>
                <center><a onclick="tuiguang()"><img src="http://oss.v8tao.cn/img/img_d60f0c96b23aa02bc1dc7c0e772a8a0b.png" width="95%"/></a></center>
                <div class="aui-list-theme">
                    <a href="javascript:;" class="aui-list-theme-item">
                        <div class="aui-list-img">
                            <h2><em>￥</em>3.28</h2>
                            <h3></h3>
                            <h4>每日被赞额度<br>提升50人</h4>
                        </div>
                        <div class="aui-list-title">
                            <h3><em>3288</em>积分</h3>
                            <button onclick="duihuan(3)">兑换</button>
                        </div>
                    </a>
                    <a href="javascript:;" class="aui-list-theme-item">
                        <div class="aui-list-img">
                            <h2><em>￥</em>6.29</h2>
                            <h3></h3>
                            <h4>每日被赞额度<br>提升99人</h4>
                        </div>
                        <div class="aui-list-title">
                            <h3><em>6299</em>积分</h3>
                            <button onclick="duihuan(4)">兑换</button>
                        </div>
                    </a>
                    <a href="javascript:;" class="aui-list-theme-item">
                        <div class="aui-list-img">
                            <h2><em>￥</em>12.8</h2>
                            <h3>全站功能免费用</h3>
                            <h4>会员卡一个月</h4>
                        </div>
                        <div class="aui-list-title">
                            <h3><em>12888</em>积分</h3>
                            <button onclick="duihuan(1)">兑换</button>
                        </div>
                    </a>
                    <a href="javascript:;" class="aui-list-theme-item">
                        <div class="aui-list-img">
                            <h2><em>￥</em>32.8</h2>
                            <h3>全站功能免费用</h3>
                            <h4>会员卡三个月</h4>
                        </div>
                        <div class="aui-list-title">
                            <h3><em>32888</em>积分</h3>
                            <button onclick="duihuan(2)">兑换</button>
                        </div>
                    </a>
                </div>
                <br><br>
                <?php
                //邀请
                $imgs[]='yaoqing';
                //兑换额度
                if($users['jifen']>=3288)$imgs[]='edu_tisheng';
                //兑换VIP
                if($users['jifen']>=12888){
                	if($vip==1){
                		$imgs[]='xufei_vip';
                	}else{
                		$imgs[]='duihuan_vip';
                	}
                }
                //积分不足
                if($users['jifen']<3288)$imgs[]='fail_duihuan';
                foreach ($imgs as $img){
                	echo '<img src="http://oss.v8tao.cn/img/'.$img.'.png" width="0" height="0">'."\r\n";
                }
                ?>
            </section>
        </section>
<?php
	include 'foot.php';
?>
	<script src="//cdn.staticfile.org/modernizr/2.8.3/modernizr.min.js"></script>
	<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
    </body>
</html>