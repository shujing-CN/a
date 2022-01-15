<?php
if(!defined('IN_CRONLITE'))exit('<script>location.href="/"</script>');
$title = '企鹅助手';
include 'head.php';
if($qie_config['yjqd']=='')$qie_config['yjqd']=0;
?>
        <?php
        function tool_bottom($code,$task,$msg,$jf,$is_qd=0){
        	if($is_qd==1 && $code==0){
        		return '<div class="aui-button-get2" onclick="yjqd(1,'.$jf.')"><button>签到</button></div>';
        	}elseif($is_qd==1 && $code==1){
        		return '<div class="aui-button-get2" onclick="yjqd(1,0)"><button>签到</button></div>';
        	}
        	if($code==0){
        		return '<div class="aui-button-get2" onclick="do_task(\''.$task.'\',\''.$msg.'\','.$jf.')"><button>兑换</button></div>';
        	}else{
        		return '<div class="aui-button-get2" onclick="submit_task(\''.$task.'\',\''.$msg.'\')"><button>使用</button></div>';
        	}
        }
        function xc1($txt,$vip){
        	if($vip==1){
        		return '正在享受VIP免费特权';
        	}else{
        		return $txt;
        	}
        }
        ?>
        <section class="aui-flexView">
            <header class="aui-navBar aui-navBar-fixed">
                <a href="?mod=jifen" class="aui-navBar-item">
                    <div class="aui-jf2">积分<?php echo $users['jifen']?></div>
                </a>
                <div class="aui-center">
                    <span class="aui-center-title">企鹅助手</span>
                </div>
                <a onclick="tuiguang()" class="aui-navBar-item">
                    <div class="aui-jf">赚积分</div>
                </a>
            </header>
            <section class="aui-scrollView">
                <div class="aui-mine-list">
                	<a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/libao.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>一键QQ签到</h3>
                            <p>快速帮您签到多个QQ网站</p>
                            <span><?php if($vip==1){echo '正在享受VIP免费特权';}else{
                            	if($qie_config['yjqd']==0){echo '免费使用中~';}else{
                            		echo '普通用户每日免费签到'.$qie_config['yjqd'].'项';
                            	}
                            }?></span>
                        </div>
						<?php echo tool_bottom($vip,'yjqd','一键签到',$qie_config['yjqd'],1);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/delss.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>批量删除说说</h3>
                            <p>手动太累？来，我来帮你~</p>
                            <span><?php echo xc1('消耗：'.$qie_config['delss'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'delss','批量删除说说',$qie_config['delss']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/delly.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>批量删除留言</h3>
                            <p>提交一次可删除多条哦！</p>
                            <span><?php echo xc1('消耗：'.$qie_config['delly'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'delly','删除空间留言',$qie_config['delly']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/tmtx.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>设置透明头像</h3>
                            <p>不过还得是QQ会员才能用哦！</p>
                            <span><?php echo xc1('消耗：'.$qie_config['tmtx'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'tmtx','设置透明头像',$qie_config['tmtx']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/kbwm.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>设置空白网名</h3>
                            <p>嘿嘿，别人也看不到哦！</p>
                            <span><?php echo xc1('消耗：'.$qie_config['kbwm'].'积分',$vip)?></span>
                        </div>
<?php echo tool_bottom($vip,'kbwm','设置空白网名',$qie_config['kbwm']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/jjtj.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>设置拒绝添加</h3>
                            <p>突破限制，拒绝所有人添加！</p>
                            <span><?php echo xc1('消耗：'.$qie_config['jjtj'].'积分',$vip)?></span>
                        </div>
                        <?php echo tool_bottom($vip,'jjtj','设置拒绝添加',$qie_config['jjtj']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/ycss.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>设置隐藏搜索</h3>
                            <p>设置后别人搜索你到你到QQ！</p>
                            <span><?php echo xc1('消耗：'.$qie_config['ycss'].'积分',$vip)?></span>
                        </div>
    				  <?php echo tool_bottom($vip,'ycss','设置隐藏搜索',$qie_config['ycss']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/regtime.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>注册时间查询</h3>
                            <p>你也来看你是啥时候注册的吧？</p>
                            <span><?php echo xc1('消耗：'.$qie_config['regtime'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'regtime','查询注册时间',$qie_config['regtime']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/tbgx.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>特别关心查询</h3>
                            <p>有多少人将你置为特别关心？</p>
                            <span><?php echo xc1('消耗：'.$qie_config['tbgx'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'tbgx','查询特别关心',$qie_config['tbgx']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/lysh.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>留言审核关闭</h3>
                            <p>代关闭空间留言审核权限</p>
                            <span><?php echo xc1('消耗：'.$qie_config['lysh'].'积分',$vip)?></span>
                        </div>
						<?php echo tool_bottom($vip,'lysh','留言审核关闭',$qie_config['lysh']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/plsh.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>评论审核关闭</h3>
                            <p>代关闭空间评论审核权限</p>
                            <span><?php echo xc1('消耗：'.$qie_config['plsh'].'积分',$vip)?></span>
                        </div>
					<?php echo tool_bottom($vip,'plsh','评论审核关闭',$qie_config['plsh']);?>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/hysc.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>好友时长查询</h3>
                            <p>你是啥时候认识Ta的呢？</p>
                            <span><?php echo xc1('消耗：'.$qie_config['hysc'].'积分/次',$vip)?></span>
                        </div>
                        <div class="aui-button-get2" onclick="hysc()">
                            <button>查询</button>
                        </div>
                    </a>
                    <a href="javascript:;" class="aui-flex b-line">
                        <div class="aui-mine-img">
                            <img src="<?php echo $HTTP_HOST;?>/assets/huzan/img/money.png" alt="">
                        </div>
                        <div class="aui-flex-box">
                            <h3>账户余额查询</h3>
                            <p>查询Q币数量与积分~</p>
                            <span><?php echo xc1('消耗：'.$qie_config['money'].'积分',$vip)?></span>
                        </div><?php echo tool_bottom($vip,'money','账户余额查询',$qie_config['money']);?>
                    </a>
                </div>
                <img src="http://oss.v8tao.cn/img/yaoqing.png" width="0" height="0">
            </section>
       <br><br>
<?php include 'foot.php';?>
</section>
    </body>
</html>