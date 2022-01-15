<?php
/*
 *QQ空间多功能操作类
 *Author：消失的彩虹海 & 快乐是福 & 云上的影子
*/
class qzone{
	public $msg;
	public $delend;
	private $qzonetoken = null;
	private $qzonetoken_pc = false;
	public function __construct($uin,$sid=null,$skey=null,$pskey=null,$superkey=null){
		$this->uin=$uin;
		$this->sid=$sid;
		$this->pskey=$pskey;
		$this->gtk=$this->getGTK($skey);
		$this->gtk2=$this->getGTK($pskey);
		if($pskey==null)
			$this->cookie='pt2gguin=o0'.$uin.'; uin=o0'.$uin.'; skey='.$skey.';';
		else{
			$this->cookie='pt2gguin=o0'.$uin.'; uin=o0'.$uin.'; skey='.$skey.'; p_skey='.$pskey.'; p_uin=o0'.$uin.';';
			$this->cookie2='pt2gguin=o0'.$uin.'; uin=o0'.$uin.'; skey='.$skey.';';
		}
	}
	function gift_pc($uin,$con){
		$url = "http://drift.qzone.qq.com/cgi-bin/sendgift?g_tk=".$this->gtk2;
		$post="qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fgift%2Fsend_list.html%23uin%3D%26type%3D%26itemid%3D%26birthday%3D%26birthdaytab%3D0%26lunarFlag%3D0%26source%3D%26nick%3D%26giveback%3D%26popupsrc%3D301%26open%3D%26is_fest_opt%3D0%26festId%3D%26html%3Dsend_list%26startTime%3D1441885072018%26timeoutId%3D2086&fupdate=1&random=0.06927570731103372&charset=utf-8&uin=".$this->uin."&targetuin={$uin}&source=0&giftid=106777&private=0&giveback=&qzoneflag=1&time=&timeflag=0&giftmessage=".urlencode($con)."&gifttype=0&gifttitle=%E8%AE%B8%E6%84%BF%E4%BA%91%E6%8A%B1%E6%9E%95+&traceid=&newadmin=1&birthdaytab=0&answerid=&arch=0&clicksrc=&click_src_v2=01%7C01%7C301%7C0556%7C0000%7C01";
		$json=$this->get_curl($url,$post,0,$this->cookie);
		preg_match('/frameElement\.callback\((.*?)\)\;/is',$json,$jsons);
		$json = $jsons[1];
		$arr = json_decode($json, true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin." 送礼物成功！";
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin." 未登录";
		}elseif($arr['code']==6){
			$this->msg[]=$this->uin." 收礼人设置了权限";
		}else{
			$this->msg[]=$this->uin." 送礼物失败！";
		}
	}
	function gift($uin, $con) {
        $url = "http://mobile.qzone.qq.com/gift/giftweb?g_tk=".$this->gtk2;
        $post = "action=3&itemid=108517&struin={$uin}&content=" . urlencode($con) . "&format=json&isprivate=0";
        $json = $this->get_curl($url, $post,1,$this->cookie);
        $arr = json_decode($json, true);
        if (array_key_exists('code', $arr) && $arr['code'] == 0) {
            $this->msg[] = $this->uin . " 送礼物成功！";
        } elseif ($arr['code'] == - 3000) {
            $this->skeyzt = 1;
            $this->msg[] = $this->uin . " 未登录";
        } elseif ($arr['code'] == - 10000) {
            $this->msg[] = $this->uin . " 收礼人设置了权限";
        } else {
            $this->msg[] = $this->uin . " 送礼物失败！";
        }
    }
	function liuyan_pc($uin,$con){
		$url = 'http://h5.qzone.qq.com/proxy/domain/m.qzone.qq.com/cgi-bin/new/add_msgb?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&g_tk='.$this->gtk2;
		$post = 'qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fmsgboard%2Fmsgbcanvas.html%23page%3D1&content='.urlencode($con).'&hostUin='.$uin.'&uin='.$this->uin.'&format=json&inCharset=utf-8&outCharset=utf-8&iNotice=1&ref=qzone&json=1&g_tk='.$this->gtk;
		$json=$this->get_curl($url,$post,'http://cnc.qzs.qq.com/qzone/msgboard/msgbcanvas.html',$this->cookie);
		$arr = json_decode($json, true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言成功[PC]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言失败[PC]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言失败[PC]！原因:'.$arr['message'];
		}
	}
	function liuyan($uin,$con){
		$url = "http://mobile.qzone.qq.com/msgb/fcg_add_msg?g_tk=".$this->gtk2;
		$post = "res_uin={$uin}&format=json&content=".urlencode($con)."&opr_type=add_comment";
		$json=$this->get_curl($url,$post,1,$this->cookie);
		$arr = json_decode($json, true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言失败[CP]！原因:'.$arr['message'];
		}elseif($arr['code']==-4017){
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言成功[CP]，留言内容将在你审核后展示';
		}else{
			$this->msg[]=$this->uin.' 为 '.$uin.' 刷留言失败[CP]！原因:'.$arr['message'];
		}
	}
	public function zyzan($uin){

		$randuin=rand(111111111,999999999);
		$url='http://w.qzone.qq.com/cgi-bin/likes/internal_dolike_app?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&g_tk='.$this->gtk2;
		$post='qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F'.$randuin.'&appid=7030&face=0&fupdate=1&from=1&query_count=200&format=json&opuin='.$this->uin.'&unikey=http%3A%2F%2Fuser.qzone.qq.com%2F'.$randuin.'&curkey=http%3A%2F%2Fuser.qzone.qq.com%2F'.$uin.'&zb_url=http%3A%2F%2Fi.gtimg.cn%2Fqzone%2Fspace_item%2Fpre%2F10%2F'.rand(10000,99999).'_1.gif';
		$json=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$uin,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 赞 '.$uin.' 主页成功[PC]';
		}elseif($arr[code]==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 赞 '.$uin.' 主页失败[PC]！原因:'.$arr['message'];
		}elseif(array_key_exists('code',$arr)){
			$this->msg[]=$this->uin.' 赞 '.$uin.' 主页失败[PC]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 赞 '.$uin.' 主页失败[PC]！请10秒后再试';
		}
	}
	public static function get_renqi($uin){
		$url='http://h5.qzone.qq.com/proxy/domain/r.qzone.qq.com/cgi-bin/qzone_dynamic_v7.cgi?uin='.$uin.'&param=848';
		$body=get_curl($url);
		$body = str_replace(array('_Callback(', ')'), array('', ''), $body);
		if ($ret = json_decode($body, true)) {
			if (@array_key_exists('code',$ret) && $ret['code'] == 0) {
				$count = $ret['data']['app_848']['data']['modvisitcount'][0]['todaycount'];
				return $count;
			}
		}
		return false;
	}
	public function visitqzone($uin){
		$url='https://h5.qzone.qq.com/webapp/json/friendSetting/reportSpaceVisitor?g_tk='.$this->gtk2.'&uin='.$uin.'&visituin='.$this->uin;
		$json=$this->get_curl($url,0,'http://user.qzone.qq.com/'.$uin,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('ret',$arr) && $arr['ret']==0){
			$this->msg[]=$this->uin.' 访问 '.$uin.' 的空间成功[PC]';
		}elseif(array_key_exists('ret',$arr)){
			$this->msg[]=$this->uin.' 访问 '.$uin.' 的空间失败[PC]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 访问 '.$uin.' 的空间失败[PC]！请10秒后再试';
		}
	}
	public function quantu(){
		if($shuos=$this->getnew()){
			$i=0;
			foreach($shuos as $shuo){
				$albumid='';$lloc='';
				if($shuo['original']['cell_pic']){
					$albumid=$shuo['original']['cell_pic']['albumid'];
					$lloc=$shuo['original']['cell_pic']['picdata'][0]['lloc'];
				}
				if($shuo['pic']){
					$albumid=$shuo['pic']['albumid'];
					$lloc=$shuo['pic']['picdata'][0]['lloc'];
				}
				if(!empty($albumid)) {
					$touin=$shuo['userinfo']['user']['uin'];
					$this->quantu_do($touin,$albumid,$lloc);
					if($this->skeyzt) break;
					++$i;if($i>=6)break;
					usleep(100000);
				}
			}
		}
	}
	public function quantu_do($touin,$albumid,$lloc){
		$url="https://user.qzone.qq.com/proxy/domain/app.photo.qq.com/cgi-bin/app/cgi_annotate_face?g_tk=".$this->gtk2;
		$post="format=json&uin={$this->uin}&hostUin=$touin&faUin={$this->uin}&faceid=&oper=0&albumid=$albumid&lloc=$lloc&facerect=10_10_50_50&extdata=&inCharset=GBK&outCharset=GBK&source=qzone&plat=qzone&facefrom=moodfloat&faceuin={$this->uin}&writeuin={$this->uin}&facealbumpage=quanren&qzreferrer=https://user.qzone.qq.com/{$this->uin}/infocenter?via=toolbar";
		$json=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$uin.'/infocenter?via=toolbar',$this->cookie);
		$json=mb_convert_encoding($json, "UTF-8", "gb2312");
		$arr=json_decode($json,true);
		if(!array_key_exists('code',$arr)){
			$this->msg[]="圈{$touin}的图{$albumid}失败，原因：获取结果失败！";
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]="圈{$touin}的图{$albumid}失败，原因：SKEY已失效！";
		}elseif($arr['code']==0){
			$this->msg[]="圈{$touin}的图{$albumid}成功";
		}else{
			$this->msg[]="圈{$touin}的图{$albumid}失败，原因：".$arr['message'];
		}
	}
	public function getll(){
		$url='http://mobile.qzone.qq.com/list?g_tk='.$this->gtk2.'&res_attach=&format=json&list_type=msg&action=0&res_uin='.$this->uin.'&count=20';
		$get=$this->get_curl($url,0,1,$this->cookie);
		$arr = json_decode($get,true);
		if(!array_key_exists('code',$arr)){
			$this->msg[]="获取留言列表失败";
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]="获取留言列表失败，原因：SKEY已失效！";
		}elseif($arr['code']==0 && $arr['data']['vFeeds']){
			if($arr['data']['vFeeds'])
				return $arr['data']['vFeeds'];
			else
				$this->msg[]='没有留言！';
		}else{
			$this->msg[]="获取留言列表失败，原因：".$arr['message'];
		}
		
	}
	public function getliuyan(){
		$ua='Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0';
		$url='https://user.qzone.qq.com/proxy/domain/m.qzone.qq.com/cgi-bin/new/get_msgb?uin='.$this->uin.'&hostUin='.$this->uin.'&start=0&s=0.860240'.time().'&format=json&num=10&inCharset=utf-8&outCharset=utf-8&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,0,'http://user.qzone.qq.com/',$this->cookie,0,$ua);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='获取留言列表成功！';
			return $arr['data']['commentList'];
		}else{
			$this->msg[]='获取留言列表失败！';
		}
	}
	public function PCdelly($idList,$uinList){
		$url = "https://h5.qzone.qq.com/proxy/domain/m.qzone.qq.com/cgi-bin/new/del_msgb?g_tk=".$this->gtk2;
		$post="qzreferrer=https%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fmsgboard%2Fmsgbcanvas.html%23page%3D1&hostUin=".$this->uin."&idList=".urlencode($idList)."&uinList=".urlencode($uinList)."&format=json&iNotice=1&inCharset=utf-8&outCharset=utf-8&ref=qzone&json=1&g_tk=".$this->gtk2;
		$data = $this->get_curl($url,$post,'https://ctc.qzs.qq.com/qzone/msgboard/msgbcanvas.html',$this->cookie);
		$arr=json_decode($data,true);
		if($arr){
			if(array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]= '删除 '.$uinList.' 留言成功！'.$arr['message'];
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]='删除 '.$uinList.' 留言失败！原因:'.$arr['message'];
			}elseif(array_key_exists('code',$arr)){
				$this->msg[]= '删除 '.$uinList.' 留言失败！'.$arr['message'];
			}
		}else{
			$this->msg[]=  "未知错误，删除失败！";
		}
	}
	public function cpdelly($id,$uin){
		$url = 'http://mobile.qzone.qq.com/operation/operation_add?g_tk='.$this->gtk2;
		$post='opr_type=delugc&res_type=334&res_id='.$id.'&real_del=0&res_uin='.$this->uin.'&format=json';
		$data = $this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($data,true);
		if($arr){
			if(array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]='删除 '.$uin.' 留言成功！';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]='删除 '.$uin.' 留言失败！原因:'.$arr['message'];
			}else{
				$this->msg[]='删除 '.$uin.' 留言失败！原因:'.$arr['message'];
			}
		}else{
			$this->msg[]='未知错误，删除失败！可能留言已删尽';
		}
	}
	public function delly($do=0){
		if($liuyans=$this->getliuyan()){
			$idList='';
			$uinList='';
			foreach($liuyans as $row) {
				$idList.=$row['id'].',';
				$uinList.=$row['uin'].',';
				$exists=true;
			}
			if($exists){
				$idList = trim($idList, ',');
				$uinList = trim($uinList, ',');
				$this->PCdelly($idList,$uinList);
			}else{
				$this->delend = 1;
			}
		}
	}
	public function pczhuanfa($con,$touin,$tid){
		$url='https://user.qzone.qq.com/proxy/domain/taotao.qzone.qq.com/cgi-bin/emotion_cgi_forward_v6?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&g_tk='.$this->gtk2;
		$post='tid='.$tid.'&t1_source=1&t1_uin='.$touin.'&signin=0&con='.urlencode($con).'&with_cmt=0&fwdToWeibo=0&forward_source=2&code_version=1&format=json&out_charset=UTF-8&hostuin='.$this->uin.'&qzreferrer=https%3A%2F%2Fuser.qzone.qq.com%2F'.$this->uin.'%2Finfocenter';
		$json=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$this->uin.'/infocenter',$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			if(array_key_exists('code',$arr) && $arr['code']==0){
				$this->shuotid=$arr[tid];
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说成功[PC]';
			}elseif($arr[code]==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说失败[PC]！原因:'.$arr['message'];
			}elseif(array_key_exists('code',$arr)){
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说失败[PC]！原因'.$json;
			}
		}else{
			$this->msg[]=$this->uin.'获取转发 '.$touin.' 说说结果失败[PC]';
		}
	}
	public function cpzhuanfa($con,$touin,$tid){
		$url='https://mobile.qzone.qq.com/operation/operation_add?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken();
		$post='res_id='.$tid.'&res_uin='.$touin.'&format=json&reason='.urlencode($con).'&res_type=311&opr_type=forward&operate=1';
		$json=$this->get_curl($url,$post,1,$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			if(array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说成功[CP]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说失败[CP]！原因:'.$arr['message'];
			}else{
				$this->msg[]=$this->uin.'转发 '.$touin.' 说说失败[CP]！原因:'.$arr['message'];
			}
		}else{
			$this->msg[]=$this->uin.'获取转发 '.$touin.' 说说结果失败[CP]';
		}
	}
	public function zhuanfa($do=0,$uins=array(),$con=null){
		$myshuoshuo = array();
		if($shuos=$this->getmynew()){
			foreach($shuos as $shuo){
				if(array_key_exists('original',$shuo)){
					$myshuoshuo[]=$shuo['original']['cell_id']['cellid'];
				}
			}
		}
		if(count($uins)==1 && $uins[0]!='') {
			$uin = $uins[0];
			if($shuos=$this->getmynew($uin)){
				$i=0;
				foreach($shuos as $shuo){
					$cellid=$shuo['id']['cellid'];
					if(in_array($cellid,$myshuoshuo))break;
					if($do){
						$this->pczhuanfa($con,$uin,$cellid);
						if($this->skeyzt) break;
					}else{
						$this->cpzhuanfa($con,$uin,$cellid);
						if($this->skeyzt) break;
					}
					++$i;if($i>=3)break;
					usleep(100000);
				}
			}
		} elseif(count($uins)>1) {
			if($shuos=$this->getnew()){
				foreach($shuos as $shuo){
					$uin = $shuo['userinfo']['user']['uin'];
					if(in_array($uin,$uins)) {
						$cellid=$shuo['id']['cellid'];
						if(in_array($cellid,$myshuoshuo))break;
						if($do){
							$this->pczhuanfa($con,$uin,$cellid);
							if($this->skeyzt) break;
						}else{
							$this->cpzhuanfa($con,$uin,$cellid);
							if($this->skeyzt) break;
						}
					}
				}
			}
		} else {
			if($shuos=$this->getnew()){
				foreach($shuos as $shuo){
					$uin = $shuo['userinfo']['user']['uin'];
					$cellid=$shuo['id']['cellid'];
					if(in_array($cellid,$myshuoshuo))break;
					if($do){
						$this->pczhuanfa($con,$uin,$cellid);
						if($this->skeyzt) break;
					}else{
						$this->cpzhuanfa($con,$uin,$cellid);
						if($this->skeyzt) break;
					}
				}
			}
		}
	}
	public function cpqd($content='每日签到'){
		$html = '<!DOCTYPE html><html style="background:transparent;"><head><meta charset="UTF-8"><link rel="stylesheet" type="text/css" href="http://qzonestyle.gtimg.cn/touch/proj-qzone-app/checkin-pc/index.css"></head><body style="background:transparent;"><div class="checkIn-days" style="background: transparent;"><div class="template-area screenshot style-thirteen"><div class="pic-area j-pic-area"><div class="upload-pic j-upload-pic"><img src="https://qzonestyle.gtimg.cn/qzone/qzactStatics/imgs/20180808144259_db402a.jpg"></div> <div class="operate-area j-operate-area" style="background-image: url(&quot;data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7&quot;);"></div> <div class="camera-wrap"><i class="icon icon-camera"></i></div> <div class="date-area"><div class="week week-1"><img src="https://qzonestyle.gtimg.cn/touch/proj-qzone-app/checkin-2017/img/number/style-thirteen/week-1.png" class="week1-img"></div> <div class="date-inner"><div class="day">27</div> <div class="month">August</div></div></div></div> <div class="word-area j-word-area edit-state"><div class="word-main"><p class="word j-word">'.$content.'</p> <textarea class="wordTextarea" style="overflow: hidden;">'.$content.'</textarea><textarea class="wordTextarea" style="overflow: hidden; visibility: hidden; position: absolute;"></textarea></div> <div class="word-side j-edit-btn"><button class="btn-refresh"><i class="icon-refresh"></i></button></div></div></div></div></body></html>';
		$post = json_encode(array('html'=>$html,'viewport'=>array('width'=>820,'height'=>820),'type'=>'png','cache'=>true));
		$url = 'https://h5.qzone.qq.com/services/picGenerator?cmd=stringToUrl&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,$post,'https://h5.qzone.qq.com/checkinv2/editor?type=daily',$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$url='https://h5.qzone.qq.com/webapp/json/publishDiyMood/publishmood?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('https://h5.qzone.qq.com/checkinv2/editor?type=daily');
			$richval='aurl='.urlencode($arr['picUrl']['sOriUrl']).'&s_width=400&s_height=300&murl='.urlencode($arr['picUrl']['sOriUrl']).'&m_width=600&m_length=450&burl='.urlencode($arr['picUrl']['sOriUrl']).'&b_width=800&b_length=600&pic_type=10&templateId=1&who=2';
			$post='uin='.$this->uin.'&content=&issynctoweibo=0&isWinPhone=2&richtype=1&richval='.urlencode($richval).'&sourceName=&frames=10&source.subtype=33&extend_info.checkinfall=%7B%22uuid%22%3A%22'.time().'123%22%7D&right_info.ugc_right=1&stored_extend_info.is_diy=1&stored_extend_info.event_tags=&stored_extend_info.pic_jump_type=0&stored_extend_info.signin_group_id=1&stored_extend_info.signin_seal_id=285&stored_extend_info.signin_op=1&format=json&inCharset=utf-8&outCharset=utf-8';
			$json=$this->get_curl($url,$post,'https://h5.qzone.qq.com/checkinv2/editor?type=daily',$this->cookie);
			$arr=json_decode($json,true);
			if(@array_key_exists('ret',$arr) && $arr['ret']==0){
				$this->msg[]=$this->uin.' 签到成功[CP]';
			}elseif($arr['ret']==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.' 签到失败[CP]！原因:SID已失效，请更新SID';
			}elseif($arr['code']==-3001){
				$this->msg[]=$this->uin.' 签到失败[CP]！原因:需要验证码';
			}elseif(@array_key_exists('ret',$arr)){
				$this->msg[]=$this->uin.' 签到失败[CP]！原因:'.$arr['msg'];
			}else{
				$this->msg[]=$this->uin.' 签到失败[CP]！原因:'.$json;
			}
		}else{
			$this->msg[]=$this->uin.' 生成签到图片失败！'.$arr['msg'];
		}
	}
	public function pcqd($content='',$sealid='50001'){
		$url='http://snsapp.qzone.qq.com/cgi-bin/signin/checkin_cgi_publish?g_tk='.$this->gtk2;
		$post='qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fapp%2Fcheckin_v4%2Fhtml%2Fcheckin.html&plattype=1&hostuin='.$this->uin.'&seal_proxy=&ttype=1&termtype=1&content='.urlencode($content).'&seal_id='.$sealid.'&uin='.$this->uin.'&time_for_qq_tips='.time().'&paramstr=1';
		$get=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		preg_match('/callback\((.*?)\)\; <\/script>/is',$get,$json);
		if($json=$json[1]){
			$arr=json_decode($json,true);
			$arr['feedinfo']='';
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]=$this->uin.' 签到成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:SID已失效，请更新SID';
			}elseif(@array_key_exists('code',$arr)){
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]=$this->uin.' 签到失败[PC]！原因:'.$json;
			}
		}else{
			$this->msg[]=$this->uin.' 获取签到结果失败[PC]';
		}
	}
	public function qiandao($do=0,$content='签到',$sealid=50001){
		$this->cpqd($content);
	}

	public function cpshuo($content,$richval='',$sname='',$lon='',$lat=''){
		$url='https://mobile.qzone.qq.com/mood/publish_mood?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$post='opr_type=publish_shuoshuo&res_uin='.$this->uin.'&content='.urlencode($content).'&richval='.$richval.'&lat='.$lat.'&lon='.$lon.'&lbsid=&issyncweibo=0&is_winphone=2&format=json&source_name='.$sname;
		$result=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($result,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 发布说说成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:SID已失效，请更新SID';
		}elseif($arr['code']==-3001){
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:需要验证码';
		}elseif(@array_key_exists('code',$json)){
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 发布说说失败[CP]！原因:'.$result;
		}
	}
	public function pcshuo($content,$richval=0){
		$url='https://user.qzone.qq.com/proxy/domain/taotao.qzone.qq.com/cgi-bin/emotion_cgi_publish_v6?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
		$post='syn_tweet_verson=1&paramstr=1&pic_template=';
		if($richval){
			$post.="&richtype=1&richval=".$this->uin.",{$richval}&special_url=&subrichtype=1&pic_bo=uAE6AQAAAAABAKU!%09uAE6AQAAAAABAKU!";
		}else{
			$post.="&richtype=&richval=&special_url=";
		}
		$post.="&subrichtype=&con=".urlencode($content)."&feedversion=1&ver=1&ugc_right=1&to_tweet=0&to_sign=0&hostuin=".$this->uin."&code_version=1&format=json&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F".$this->uin."%2F311";
		$ua = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";
		$json=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		$arr=json_decode($json,true);
		$arr['feedinfo']='';
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]=$this->uin.' 发布说说成功[PC]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:SID已失效，请更新SID';
		}elseif($arr['code']==-3001){
			$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:需要验证码';
		}elseif($arr['code']==-10045){
			$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:'.$arr['message'];
		}elseif(@array_key_exists('code',$arr)){
			$this->msg[]=$this->uin.' 发布说说失败[PC]！原因:'.$arr['message'];
		}else{
			$this->msg[]=$this->uin.' 获取发布说说结果失败[PC]';
		}
	}
	public function shuo($do=0,$content,$image=null,$sname='',$delete=false){
		if($delete && $shuos=$this->getmynew(null,1)){
			$cellid=$shuos[0]['id']['cellid'];
			$this->pcdel($cellid);
		}
		if(!empty($image) && $pic=$this->openu($image)){
			$image_size=getimagesize($image);
			$richval=$this->uploadimg($pic,$image_size);
		}else{
			$richval=null;
		}
		if($do){
			$this->pcshuo($content,$richval);
		}else{
			$this->cpshuo($content,$richval,$sname);
		}
	}

	public function pcdel($cellid){
		if(strlen($cellid)==10){
			$url='https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzsharedelete?g_tk='.$this->gtk2;
			$post='notice=1&fupdate=1&platform=qzone&format=json&token='.$this->gtk2.'&owneruin='.$this->uin.'&itemid='.$cellid.'&entryuin='.$this->uin.'&ugcPlatform=300&qzreferrer=https%3A%2F%2Fsns.qzone.qq.com%2Fcgi-bin%2Fqzshare%2Fcgi_qzsharegetmylistbytype%3Fuin%3D'.$this->uin;
		}else{
			$url='https://user.qzone.qq.com/proxy/domain/taotao.qzone.qq.com/cgi-bin/emotion_cgi_delete_v6?g_tk='.$this->gtk2;
			$post='hostuin='.$this->uin.'&tid='.$cellid.'&t1_source=1&code_version=1&format=json&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F'.$this->uin.'%2F311';
		}
		$json=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$this->uin.'/311',$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			if(@array_key_exists('code',$arr) && $arr['code']==0){
				$this->msg[]='删除说说'.$cellid.'成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzt=1;
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:SKEY已失效';
			}elseif(@array_key_exists('code',$json)){
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]='删除说说'.$cellid.'失败[PC]！原因:'.$json;
			}
		}else{
			$this->msg[]=$this->uin.'获取删除结果失败[PC]';
		}
	}
	public function cpdel($cellid,$appid){
		$url='https://mobile.qzone.qq.com/operation/operation_add?g_tk='.$this->gtk2;
		$post='opr_type=delugc&res_type='.$appid.'&res_id='.$cellid.'&real_del=0&res_uin='.$this->uin.'&format=json';
		$json=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='删除说说'.$cellid.'成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:SID已失效，请更新SID';
		}elseif(@array_key_exists('code',$json)){
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:'.$arr['message'];
		}else{
			$this->msg[]='删除说说'.$cellid.'失败[CP]！原因:'.$json;
		}
	}
	public function shuodel($do=0){
		if($shuos=$this->getmynew()){
			//print_r($shuos);exit;
			$i=0;
			foreach($shuos as $shuo){
				$cellid=$shuo['id']['cellid'];
				$this->pcdel($cellid);
				if($this->skeyzt) break;
				++$i;if($i>=10)break;
			}
		}
	}
	public function cpreply($content,$uin,$cellid,$type,$param){
		$post='res_id='.$cellid.'&res_uin='.$uin.'&format=json&res_type='.$type.'&content='.urlencode($content).'&busi_param='.$param.'&opr_type=addcomment';
		$url='https://mobile.qzone.qq.com/operation/publish_addcomment?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='评论 '.$uin.' 的说说成功[CP]';
		}elseif($arr['code']==-3000){
			$this->skeyzts=1;
			$this->msg[]='评论 '.$uin.' 的说说失败[CP]！原因:SID已失效，请更新SID';
		}elseif($arr['code']==-3001){
			$this->msg[]='评论 '.$uin.' 的说说失败[CP]！原因:需要验证码';
		}elseif(@array_key_exists('message',$arr)){
			$this->msg[]='评论 '.$uin.' 的说说失败[CP]！原因:'.$arr['message'];
		}else{
			$this->msg[]='获取评论'.$uin.'的说说结果失败[CP]！';
		}
	}
	public function pcreply($content,$uin,$cellid,$from,$richval=null){
		$post='topicId='.$uin.'_'.$cellid.'__'.$from.'&feedsType=100&inCharset=utf-8&outCharset=utf-8&plat=qzone&source=ic&hostUin='.$uin.'&isSignIn=&platformid=52&uin='.$this->uin.'&format=json&ref=feeds&content='.urlencode($content);
		if($richval){
			$post.='&richval='.urlencode($richval).'&richtype=1';
		}else{
			$post.='&richval=&richtype=';
		}
		$post.='&private=0&paramstr=1&qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F'.$this->uin;
		$url='https://h5.qzone.qq.com/proxy/domain/taotao.qzone.qq.com/cgi-bin/emotion_cgi_re_feeds?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&g_tk='.$this->gtk2;
		$ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
		$json=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$this->uin,$this->cookie,0,$ua);
		$arr=json_decode($json,true);
		$arr['data']['feeds']='';
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='评论 '.$uin.' 的说说成功[PC]';
		}elseif($arr['code']==-3000){
			$this->skeyzts=1;
			$this->msg[]='评论 '.$uin.' 的说说失败[PC]！原因:SID已失效，请更新SID';
		}elseif($arr['code']==-3001){
			$this->msg[]='评论 '.$uin.' 的说说失败[PC]！原因:需要验证码';
		}elseif(@array_key_exists('message',$arr)){
			$this->msg[]='评论 '.$uin.' 的说说失败[PC]！原因:'.$arr['message'];
		}else{
			$this->msg[]='获取评论'.$uin.'的说说结果失败[PC]！';
		}
	}
	public function reply($do=0,$contents=array(),$forbid=array(),$only=array(),$sleep=0,$image=null){
		if($shuos=$this->getnew()){
			$i=0;$e=0;
			foreach($shuos as $shuo){
				$uin=$shuo['userinfo']['user']['uin'];
				if($this->is_comment($this->uin,$shuo['comment']['comments']) && !in_array($uin,$forbid)){
					$appid=$shuo['comm']['appid'];
					if($appid!=311)continue;
					$typeid=$shuo['comm']['feedstype'];
					$curkey=urlencode($shuo['comm']['curlikekey']);
					$uinkey=urlencode($shuo['comm']['orglikekey']);
					$from=$shuo['userinfo']['user']['from'];
					$cellid=$shuo['id']['cellid'];
					if($only[0]!='' && !in_array($uin,$only))continue;
					$content=$contents[array_rand($contents,1)];
					if($do){
						$this->pcreply($content,$uin,$cellid,$from,$image);

					}else{

						$param=$this->array_str($shuo['operation']['busi_param']);
						$this->cpreply($content,$uin,$cellid,$appid,$param);
					}
					if($this->skeyzts) ++$e;
					$this->skeyzts=false;
					++$i;if($i>=6)break;
					if($sleep)sleep($sleep);
					else usleep(100000);
				}
			}
			//if($e>1 && $e==$i)$this->skeyzt=1;
			if($i==0)$this->msg[] = '没有要评论的说说';
		}
	}
	public function cplike($uin,$appid,$unikey,$curkey){
		$post='opuin='.$uin.'&unikey='.$unikey.'&curkey='.$curkey.'&appid='.$appid.'&opr_type=like&format=purejson';
		$url='https://h5.qzone.qq.com/proxy/domain/w.qzone.qq.com/cgi-bin/likes/internal_dolike_app?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,$post,1,$this->cookie);
		if($json){
			$arr=json_decode($json,true);
			if(@array_key_exists('ret',$arr) && $arr['ret']==0){
				$this->msg[]='赞 '.$uin.' 的说说成功[CP]';
			}elseif($arr['ret']==-3000){
				$this->skeyzt=1;
				$this->msg[]='赞'.$uin.'的说说失败[CP]！原因:SKEY已失效';
			}elseif(@array_key_exists('msg',$arr)){
				$this->msg[]='赞 '.$uin.' 的说说失败[CP]！原因:'.$arr['msg'];
			}else{
				$this->msg[]='赞 '.$uin.' 的说说失败[CP]！原因:'.$json;
			}
		}else{
			$this->msg[]='获取赞'.$uin.'的说说结果失败[CP]！';
		}
	}
	public function pclike($uin,$curkey,$unikey,$from,$appid,$typeid,$abstime,$fid){
		$post='qzreferrer=http%3A%2F%2Fuser.qzone.qq.com%2F'.$this->uin.'&opuin='.$this->uin.'&unikey='.$unikey.'&curkey='.$curkey.'&from='.$from.'&appid='.$appid.'&typeid='.$typeid.'&abstime='.$abstime.'&fid='.$fid.'&active=0&fupdate=1';
		$url='https://user.qzone.qq.com/proxy/domain/w.qzone.qq.com/cgi-bin/likes/internal_dolike_app?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
		$get=$this->get_curl($url,$post,'https://user.qzone.qq.com/'.$this->uin,$this->cookie,0,$ua);
		preg_match('/callback\((.*?)\)\;/is',$get,$json);
		if($json=$json[1]){
			$arr=json_decode($json,true);
			if($arr['message']=='succ' || $arr['msg']=='succ'){
				$this->msg[]='赞 '.$uin.' 的说说成功[PC]';
			}elseif($arr['code']==-3000){
				$this->skeyzts=1;
				$this->msg[]='赞 '.$uin.' 的说说失败[PC]！原因:SKEY已失效';
			}elseif(@array_key_exists('message',$arr)){
				$this->msg[]='赞 '.$uin.' 的说说失败[PC]！原因:'.$arr['message'];
			}else{
				$this->msg[]='赞 '.$uin.' 的说说失败[PC]！原因:'.$json;
			}
		}else{
			$this->msg[]='获取赞'.$uin.'的说说结果失败[PC]';
		}
	}
	public function newpclike($forbid=array(),$sleep=0)
	{
		$randserver=array('s1','s2','s5','s6','s7','s8','s11','s12');
		$url = 'https://user.qzone.qq.com/proxy/domain/ic2.qzone.qq.com/cgi-bin/feeds/feeds3_html_more?format=json&begintime=' . time() . '&count=20&uin=' . $this->uin . '&g_tk=' . $this->gtk2;
		$json = $this->get_curl($url, 0, 'https://user.qzone.qq.com/'.$this->uin, $this->cookie);
		$arr = json_decode($json, true);

		if ($arr[code] == -3000) {
			$this->skeyzt = 1;
			$this->msg[] = $this->uin . '获取说说列表失败，原因:SKEY过期！[PC]';
		}
		elseif(strpos($json,'"code":0')) {
			$this->msg[] = $this->uin . '获取说说列表成功[PC]';
			$json = str_replace(array("\\x22", "\\x3C", "\/"), array('"', '<', '/'), $json);
			$i=0;

			if(preg_match_all('/appid:\'(\d+)\',typeid:\'(\d+)\',key:\'([0-9A-Za-z]+)\'.*?,abstime:\'(\d+)\'.*?,uin:\'(\d+)\'.*?,html:\'(.*?)\'/i', $json, $arr)) {
				foreach ($arr[1] as $k => $row ) {
					if(preg_match('/data\-unikey="([0-9A-Za-z\.\-\_\/\:]+)" data\-curkey="([0-9A-Za-z\.\-\_\/\:]+)" data\-clicklog="like" href="javascript\:\;"><i class="fui\-icon icon\-op\-praise"><\/i>/i',$arr[6][$k],$match)){
						$appid = $arr[1][$k];
						$typeid = $arr[2][$k];
						$fid = $arr[3][$k];
						$abstime = $arr[4][$k];
						$touin = $arr[5][$k];
						$unikey = urlencode($match[1]);
						$curkey = urlencode($match[2]);

						if(!in_array($touin,$forbid))
						$this->pclike($touin, $curkey, $unikey, 1, $appid, $typeid, $abstime, $fid);
						++$i;if($i>=8)break;

						if ($this->skeyzt) break;
						if($sleep)sleep($sleep);
						else usleep(100000);
					}
				}
			}
			else {
				$this->msg[] = $this->uin . '没有要赞的说说[PC]';
			}
		}else{
			//$this->msg[] = $this->uin . '没有要赞的说说[PC]';
			$this->like(1,$forbid,$sleep);
		}
	}
	public function like($do=0,$forbid=array(),$sleep=0){
		if ($do==2) {
			$this->newpclike($forbid,$sleep);
		}
		elseif($shuos=$this->getnew()){
			$i=0;$e=0;
			foreach($shuos as $shuo){
				$like=$shuo['like']['isliked'];
				if($like==0 && !in_array($shuo['userinfo']['user']['uin'],$forbid)){
					$appid=$shuo['comm']['appid'];
					$typeid=$shuo['comm']['feedstype'];
					$curkey=urlencode($shuo['comm']['curlikekey']);
					$uinkey=urlencode($shuo['comm']['orglikekey']);
					$uin=$shuo['userinfo']['user']['uin'];
					$from=$shuo['userinfo']['user']['from'];
					$abstime=$shuo['comm']['time'];
					$cellid=$shuo['id']['cellid'];
					if($do){

						$this->pclike($uin,$curkey,$uinkey,$from,$appid,$typeid,$abstime,$cellid);
					}else{
						$this->cplike($uin,$appid,$uinkey,$curkey);
					}
					if($this->skeyzts) ++$e;
					$this->skeyzts=false;
					++$i;if($i>=8)break;
					if($sleep)sleep($sleep);
					else usleep(100000);
				}
			}
			//if($e>1 && $e==$i)$this->skeyzt=1;
			if($i==0)$this->msg[] = '没有要赞的说说';
		}
	}



	public function getnew($do='',$time=0){
		$url='https://h5.qzone.qq.com/webapp/json/mqzone_feeds/getActiveFeeds?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
		$post='res_type=0&res_attach=&refresh_type=2&format=json&attach_info=';
		$json=$this->get_curl($url,$post,1,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='获取说说列表成功！';
			if(isset($arr['data']['vFeeds']))
				return $arr['data']['vFeeds'];
			else
				return $arr['data']['feeds']['vFeeds'];
		}elseif(strpos($arr['message'],'登录') || $arr['code']==-3000){
			$this->msg[]='获取最新说说失败！原因:SKEY已失效';
			$this->skeyzt=1;
			return false;
		}elseif(strpos($arr['message'],'统繁忙')){
			if($time==0){
				return $this->getnew($do,1);
			}else{
				$this->msg[]='获取最新说说失败！原因:'.$arr['message'];
				return false;
			}
		}else{
			$this->msg[]='获取最新说说失败！原因:'.$arr['message'];
			return false;
		}	
	}

	public function getmynew($uin=null, $num=20){
		if(empty($uin))$uin=$this->uin;
		$url='https://mobile.qzone.qq.com/list?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2.'&res_attach=&format=json&list_type=shuoshuo&action=0&res_uin='.$this->uin.'&count='.$num;
		$json=$this->get_curl($url,0,1,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='获取说说列表成功！';
			return $arr['data']['vFeeds'];
		}else{
			$this->msg[]='获取最新说说失败！原因:'.$arr['message'];
			return false;
		}
	}

	public function flower(){
		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/fcg-bin/cgi_plant?g_tk='.$this->gtk2;
		$post = 'fl=1&fupdate=1&act=rain&uin='.$this->uin.'&newflower=1&outCharset=utf%2D8&g%5Ftk='.$this->gtk2.'&format=json';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='浇水成功！';
		}elseif($arr['code']==-6002){
			$this->msg[]='今天浇过水啦！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='浇水失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='浇水失败！'.$arr['message'];
		}

		$post = 'fl=1&fupdate=1&act=love&uin='.$this->uin.'&newflower=1&outCharset=utf%2D8&g%5Ftk='.$this->gtk2.'&format=json';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='修剪成功！';
		}elseif($arr['code']==-6002){
			$this->msg[]='今天修剪过啦！';
		}elseif($arr['code']==-6007){
			$this->msg[]='您的爱心值今天已达到上限！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='修剪失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='修剪失败！'.$arr['message'];
		}

		$post = 'fl=1&fupdate=1&act=sun&uin='.$this->uin.'&newflower=1&outCharset=utf%2D8&g%5Ftk='.$this->gtk2.'&format=json';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='光照成功！';
		}elseif($arr['code']==-6002){
			$this->msg[]='今天日照过啦！';
		}elseif($arr['code']==-6007){
			$this->msg[]='您的阳光值今天已达到上限！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='光照失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='光照失败！'.$arr['message'];
		}

		$post = 'fl=1&fupdate=1&act=nutri&uin='.$this->uin.'&newflower=1&outCharset=utf%2D8&g%5Ftk='.$this->gtk2.'&format=json';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='施肥成功！';
		}elseif($arr['code']==-6005){
			$this->msg[]='暂不能施肥！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='施肥失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='施肥失败！'.$arr['message'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/cgi_pickup_oldfruit?g_tk='.$this->gtk2;
		$post = 'mode=1&g%5Ftk='.$this->gtk2.'&outCharset=utf%2D8&fupdate=1&format=json';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='兑换神奇肥料成功！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='兑换神奇肥料失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='兑换神奇肥料失败！'.$arr['message'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/fg_pickup_fruit?g_tk='.$this->gtk2;
		$post = 'format=json&outCharset=utf-8&random=23552.762577310205';
		$json=$this->get_curl($url,$post,$url,$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='摘果成功！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='摘果失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='摘果失败！'.$arr['message'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/cgi_show_userprop?p=0.37835920085705778&fupdate=1&format=json&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,0,$url,$this->cookie);
		$json=mb_convert_encoding($json, "UTF-8", "gb2312");
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			foreach($arr['data']['prop'] as $row){
				$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/cgi_exchange_prop?g_tk='.$this->gtk2;
				$post = 'op_uin='.$this->uin.'&propid='.$row['propid'].'&num=1&p=0.'.time().'74383277&qzreferrer=http%3A%2F%2Frc.qzone.qq.com%2Fappstore%2Fdailycoupon%3Ffrom%3Dappstore.myInfoBoxBtn&fupdate=1&format=json';
				$this->get_curl($url,$post,'https://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf',$this->cookie);

				$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/cgi_use_mallprop?g_tk='.$this->gtk2;
				$post = 'qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fflower%2Ftool.html%23&propid='.$row['propid'].'&op_uin='.$this->uin.'&p=0.'.time().'84094803&format=json';
				$json=$this->get_curl($url,$post,'https://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf',$this->cookie);
				$json=mb_convert_encoding($json, "UTF-8", "gb2312");
			}
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/fg_get_giftpkg?g_tk='.$this->gtk2;
		$post = 'outCharset=utf-8&format=json';
		$json=$this->get_curl($url,$post,'https://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf',$this->cookie);
		$arr=json_decode($json,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			if($arr['data']['vDailyGiftpkg'][0]['caption']){
				$this->msg[]=$arr['data']['vDailyGiftpkg'][0]['caption'].':'.$arr['data']['vDailyGiftpkg'][0]['content'];
				$giftpkgid=$arr['data']['vDailyGiftpkg'][0]['id'];
				$granttime=$arr['data']['vDailyGiftpkg'][0]['granttime'];
				$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/fg_use_giftpkg?g_tk='.$this->gtk2;
				$post = 'giftpkgid='.$giftpkgid.'&outCharset=utf%2D8&granttime='.$granttime.'&format=json';
				$this->get_curl($url,$post,'https://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf',$this->cookie);
			}else
				$this->msg[]='领取每日登录礼包成功！';
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='领取每日登录礼包失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='领取每日登录礼包失败！'.$arr['message'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/flower.qzone.qq.com/cgi-bin/cgi_get_giftpkg?uin='.$this->uin.'&t=0.8578207577979139&fupdate=1&g_tk='.$this->gtk2;
		$json=$this->get_curl($url,0,'https://ctc.qzs.qq.com/qzone/client/photo/swf/RareFlower/FlowerVineLite.swf',$this->cookie);
	}
	public function sweet_sign(){
		$url = 'https://h5.qzone.qq.com/mood/lover?_wv=3';
		$data = $this->get_curl($url,0,$url,$this->cookie);
		$this->msg[]='情侣空间登录成功！';
		
		$url = 'https://h5.qzone.qq.com/webapp/json/love_ranklist/AddDownloadAppScore?t=0.09518297787128992&g_tk='.$this->gtk2;
		$data = $this->get_curl($url,0,$url,$this->cookie);
		$arr = json_decode($data, true);
		if(array_key_exists('ret',$arr) && $arr['ret']==0){
			$this->msg[]='情侣空间下载客户端成功！';
		}else{
			$this->msg[]='情侣空间签到失败！'.$arr['msg'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/sweet.snsapp.qq.com/v2/cgi-bin/sweet_share_write?version=v2&t=0.0531703351366811&g_tk='.$this->gtk2;
		$post = 'type=501&uin='.$this->uin.'&plat=1&opuin='.$this->uin.'&content=%E5%AE%9D%E8%B4%9D%E4%BD%A0%E5%B0%B1%E6%98%AF%E6%88%91%E5%94%AF%E4%B8%80%EF%BC%81&sync=0&lbs=&appicnum=0&format=html&inCharset=utf-8&outCharset=utf-8';
		$data = $this->get_curl($url,$post,$url,$this->cookie);
		preg_match('/callback\((.*?)\n\);/',$data,$json);
		$arr = json_decode($json[1], true);
		if(array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='情侣空间发表状态成功！';
		}else{
			$this->msg[]='情侣空间发表状态失败！'.$arr['message'];
		}
	}
	public function jfsc(){
		/*$url='http://appstore.qzone.qq.com/cgi-bin/comm/appstore_qq_icon?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&uin='.$this->uin.'&optype=signin&g_tk='.$this->gtk;
		$data = $this->get_curl($url,0,$url,$this->cookie);
		if(strpos($data,'ret:0,')!==false){
			$this->msg[]=$uin.' 空间应用签到成功！';
		}elseif(strpos($data,'ret:1,')!==false){
			$this->msg[]=$uin.' 空间应用签到失败！SKEY已失效';
		}else{
			$this->msg[]=$uin.' 空间应用签到失败！'.$data;
		}*/

		$url='https://h5.qzone.qq.com/proxy/domain/appact.qzone.qq.com/appstore_activity_appinner_fusionapi?uin='.$this->uin.'&g_tk='.$this->gtk2.'&s_code=18&level=1&s_action=gain&type=subscribe_set';
		$data = $this->get_curl($url,0,$url,$this->cookie);
		preg_match('/_Callback\((.*?)\)\;/is',$data,$json);
		$arr=json_decode($json[1],true);
		if(array_key_exists('subcode',$arr) && $arr['subcode']==0) {
			$this->msg[]=$uin.' 应用活动中心签到成功！';
		}elseif($arr['subcode']==-100){
			$this->msg[]=$uin.' 应用活动中心签到失败！SKEY已失效。';
		}else{
			$this->msg[]=$uin.' 应用活动中心签到失败！'.$arr['message'];
		}

		$url = 'https://h5.qzone.qq.com/proxy/domain/activity.qzone.qq.com/fcg-bin/appstore_activity_daily_signing?qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&g_tk='.$this->gtk2.'&r=0.485020522897406646&format=json&action=level&act=5084&uin='.$this->uin.'&_='.time();
		$data = $this->get_curl($url,0,'https://qzs.qq.com/open/store/points/index.html',$this->cookie);
		$arr=json_decode($data,true);
		if(array_key_exists('code',$arr) && $arr['code']==0) {
			$this->msg[]=$uin.' 积分商城签到成功！已连续签到'.$arr['data']['sign_info']['cont_sign_days'].'天';
			$signing_reward = $arr['data']['signing_reward'];
			if($signing_reward[0]['status']==1)$giftid='3';
			elseif($signing_reward[1]['status']==1)$giftid='5';
			elseif($signing_reward[2]['status']==1)$giftid='7';
			if($giftid){
				$url = 'https://h5.qzone.qq.com/proxy/domain/activity.qzone.qq.com/fcg-bin/appstore_activity_daily_signing?g_tk='.$this->gtk2.'&r=0.3299842168601226&action=reward&gift='.$giftid.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1).'&format=json&uin='.$this->uin.'&_='.time();
				$data = $this->get_curl($url,0,'https://qzs.qq.com/open/store/points/index.html',$this->cookie);
			}
		}elseif($arr['code']==-3001){
			$this->msg[]=$uin.' 积分商城签到成功';
		}else{
			$this->msg[]=$uin.' 积分商城签到失败！'.$arr['message'];
		}
	}
	public function check_status(){
		$url = 'http://r.qzone.qq.com/cgi-bin/user/qzone_cgi_msg_getcnt2?uin='.$this->uin.'&bm=0800950000008001&v=1&g_tk='.$this->gtk2.'&g=0.291287'.time();
		$data=$this->get_curl($url,0,'http://cnc.qzs.qq.com/qzone/v6/setting/profile/profile.html',$this->cookie);
		preg_match('/\_Callback\((.*?)\);/is',$data,$json);
		$arr=json_decode($json[1], true);
		if($arr['error']==4004){
			return false;
		}else{
			return true;
		}
	}
	private function getToken($url = 'https://h5.qzone.qq.com/mqzone/index', $pc = false){
		if($this->qzonetoken && $this->qzonetoken_pc==$pc)return $this->qzonetoken;
		$filename = ROOT.'qie/temp/'.md5($this->uin.$this->pskey.$url).'.txt';
		if(file_exists($filename)){
			$result=file_get_contents($filename);
			$this->qzonetoken=$result;
			$this->qzonetoken_pc=$pc;
			return $this->qzonetoken;
		}
		if($pc){
			$ua='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
		}else{
			$ua='Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1';
		}
		$json=$this->get_curl($url,0,0,$this->cookie,0,$ua);
		preg_match('/\(function\(\){ try{*.return (.*?);} catch\(e\)/i',$json,$match);
		if($data=$match[1]){
			$word=array('([]+[][(![]+[])[!+[]+!![]+!![]]+([]+{})[+!![]]+(!![]+[])[+!![]]+(!![]+[])[+[]]][([]+{})[!+[]+!![]+!![]+!![]+!![]]+([]+{})[+!![]]+([][[]]+[])[+!![]]+(![]+[])[!+[]+!![]+!![]]+(!![]+[])[+[]]+(!![]+[])[+!![]]+([][[]]+[])[+[]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(!![]+[])[+[]]+([]+{})[+!![]]+(!![]+[])[+!![]]]((!![]+[])[+!![]]+([][[]]+[])[!+[]+!![]+!![]]+(!![]+[])[+[]]+([][[]]+[])[+[]]+(!![]+[])[+!![]]+([][[]]+[])[+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]+!![]+!![]]+(![]+[])[!+[]+!![]]+([]+{})[+!![]]+([]+{})[!+[]+!![]+!![]+!![]+!![]]+(+{}+[])[+!![]]+(!![]+[])[+[]]+([][[]]+[])[!+[]+!![]+!![]+!![]+!![]]+([]+{})[+!![]]+([][[]]+[])[+!![]])())'=>'https','([][[]]+[])'=>'undefined','([]+{})'=>'[object Object]','(+{}+[])'=>'NaN','(![]+[])'=>'false','(!![]+[])'=>'true');
			$words=array();$i=0;
			foreach($word as $k=>$v){
				$words[$i]=$v;
				$data=str_replace($k,'$words['.$i.']',$data);
				$i++;
			}
			$data=str_replace(array('!+[]','+!![]','+[]'),array('+1','+1','+0'),$data);
			$data=str_replace(array('+(','+$'),array('.(','.$'),$data);
			eval('$result='.$data.';');
			if(!$result){
				$this->msg[]='计算qzonetoken失败！';
				return false;
			}
			file_put_contents($filename,$result);
			$this->qzonetoken=$result;
			$this->qzonetoken_pc=$pc;
			return $this->qzonetoken;
		}elseif($this->check_status()==false){
			$this->msg[]='获取qzonetoken失败！原因:SKEY已失效';
			$this->skeyzt=1;
			return false;
		}else{
			$this->msg[]='获取qzonetoken失败！';
			return false;
		}
    }
	public function get_curl($url,$post=0,$referer=1,$cookie=0,$header=0,$ua=0,$nobaody=0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept: application/json";
		$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
		$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
		$httpheader[] = "Connection: close";
		if($post && substr($post,0,1)=='{')$httpheader[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		if($post){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if($header){
			curl_setopt($ch, CURLOPT_HEADER, TRUE);
		}
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		if($referer){
			if($referer==1){
				curl_setopt($ch, CURLOPT_REFERER, 'https://h5.qzone.qq.com/mqzone/index');
			}else{
				curl_setopt($ch, CURLOPT_REFERER, $referer);
			}
		}
		if($ua){
			curl_setopt($ch, CURLOPT_USERAGENT,$ua);
		}else{
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
		}
		if($nobaody){
			curl_setopt($ch, CURLOPT_NOBODY,1);
		}
		curl_setopt($ch,CURLOPT_TIMEOUT,10);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	public function openu($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept: */*";
		$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
		$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
		$httpheader[] = "Connection: close";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36');
		curl_setopt($ch,CURLOPT_TIMEOUT,10);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	private function getGTK($skey){
        $len = strlen($skey);
        $hash = 5381;
        for ($i = 0; $i < $len; $i++) {
            $hash += ($hash << 5 & 2147483647) + ord($skey[$i]) & 2147483647;
            $hash &= 2147483647;
        }
        return $hash & 2147483647;
    }
	private function getGTK2($skey){
		$salt = 5381;
		$md5key = 'tencentQQVIP123443safde&!%^%1282';
		$hash = array();
		$hash[] = ($salt << 5);
		$len = strlen($skey);
		for($i = 0; $i < $len; $i ++)
		{
			$ASCIICode = mb_convert_encoding($skey[$i], 'UTF-32BE', 'UTF-8');
			$ASCIICode = hexdec(bin2hex($ASCIICode));
			$hash[] = (($salt << 5) + $ASCIICode);
			$salt = $ASCIICode;
		}
		$md5str = md5(implode($hash) . $md5key);
		return $md5str;
	}
	private function is_comment($uin,$arrs){
        if($arrs){
	    	foreach($arrs as $arr){
    	   		if($arr['user']['uin'] == $uin){
        			return false;
            		break;
        		}
    		}
        	return true; 
        }else{
        	return true; 
        }
	}
	private function array_str($array){
    	$str='';
        if($array[-100]){
	        $array100=explode(' ',trim($array[-100]));
    	    $new100=implode('+',$array100);
            $array[-100]=$new100;
        }
 		foreach($array as $k=>$v){
            if($k!='-100'){
	    		$str=$str.$k.'='.$v.'&';
            }
 		}
        $str=urlencode($str.'-100=').$array[-100].'+';
        $str=str_replace(':','%3A',$str);
    	return $str;
    }
	public function setnick($nick){
		$url="http://w.qzone.qq.com/cgi-bin/user/cgi_apply_updateuserinfo_new?g_tk=".$this->gtk2;
		$data="qzreferrer=http%3A%2F%2Fctc.qzs.qq.com%2Fqzone%2Fv6%2Fsetting%2Fprofile%2Fprofile.html%3Ftab%3Dbase&nickname=".urlencode($nick)."&emoji=&sex=1&birthday=2015-01-01&province=0&city=PAR&country=FRA&marriage=6&bloodtype=5&hp=0&hc=PAR&hco=FRA&career=&company=&cp=0&cc=0&cb=&cco=0&lover=&islunar=0&mb=1&uin=".$this->uin."&pageindex=1&nofeeds=1&fupdate=1&format=json";
		$return=$this->get_curl($url,$data,$url,$this->cookie);
		$arr=json_decode($return,true);
		if(@array_key_exists('code',$arr) && $arr['code']==0){
			$this->msg[]='修改昵称成功！当前昵称：'.$nick;
		}elseif($arr['code']==-3000){
			$this->skeyzt=1;
			$this->msg[]='修改昵称失败！原因:SKEY已过期！';
		}else{
			$this->msg[]='修改昵称失败！'.$arr['message'];
		}
	}
	public function getgroupinfo(){
		$ua='Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
		$url='http://r.qzone.qq.com/cgi-bin/tfriend/friend_getgroupinfo.cgi?uin='.$this->uin.'&fuin=&rd=0.808466'.time().'&fupdate=1&format=json&g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
		$return=$this->get_curl($url,0,'http://user.qzone.qq.com/'.$this->uin.'/myhome/friends/ofpmd',$this->cookie,0,$ua);
		$arr=json_decode($return,true);
		return $arr;
	}
	public function addfriend($touin, $groupid=0){
		$ua='Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
		$url='http://w.qzone.qq.com/cgi-bin/tfriend/friend_addfriend.cgi?g_tk='.$this->gtk2.'&qzonetoken='.$this->getToken('https://user.qzone.qq.com/'.$this->uin.'/311',1);
		$post='sid=0&ouin='.$touin.'&uin='.$this->uin.'&fupdate=1&rd=0.017492896'.time().'&fuin='.$touin.'&groupId='.$groupid.'&realname=&flag=&chat=&key=&im=0&from=9&from_source=11&format=json&qzreferrer=http://user.qzone.qq.com/'.$this->uin.'/myhome/friends/ofpmd';
		$return=$this->get_curl($url,$post,'http://user.qzone.qq.com/'.$this->uin.'/myhome/friends/ofpmd',$this->cookie,0,$ua);
		$arr=json_decode($return,true);
		return $arr;
	}
	public function uploadimg($image,$image_size=array()){
		$url='https://mobile.qzone.qq.com/up/cgi-bin/upload/cgi_upload_pic_v2?qzonetoken='.$this->getToken().'&g_tk='.$this->gtk2;
        $post='picture='.urlencode(base64_encode($image)).'&base64=1&hd_height='.$image_size[1].'&hd_width='.$image_size[0].'&hd_quality=90&output_type=json&preupload=1&charset=utf-8&output_charset=utf-8&logintype=sid&Exif_CameraMaker=&Exif_CameraModel=&Exif_Time=&uin='.$this->uin;
        $data=preg_replace("/\s/","",$this->get_curl($url,$post,1,$this->cookie,0,1));
		preg_match('/_Callback\((.*)\);/',$data,$arr);
		$data=json_decode($arr[1],true);
        if($data && array_key_exists('filemd5',$data)){
			$this->msg[]='图片上传成功！';
			$post='output_type=json&preupload=2&md5='.$data['filemd5'].'&filelen='.$data['filelen'].'&batchid='.time().rand(100000,999999).'&currnum=0&uploadNum=1&uploadtime='.time().'&uploadtype=1&upload_hd=0&albumtype=7&big_style=1&op_src=15003&charset=utf-8&output_charset=utf-8&uin='.$this->uin.'&logintype=sid&refer=shuoshuo';
			$img=preg_replace("/\s/","",$this->get_curl($url,$post,1,$this->cookie,0,1));
			preg_match('/_Callback\(\[(.*)\]\);/',$img,$arr);
			$data=json_decode($arr[1],true);
            if($data && array_key_exists('picinfo',$data)){
				if($data[picinfo][albumid]!=""){
					$this->msg[]='图片信息获取成功！';
					return ''.$data['picinfo']['albumid'].','.$data['picinfo']['lloc'].','.$data['picinfo']['sloc'].','.$data['picinfo']['type'].','.$data['picinfo']['height'].','.$data['picinfo']['width'].',,,';
				}else{
					$this->msg[]='图片信息获取失败！';
					return;
				}
            }else{
                $this->msg[]='图片信息获取失败！';
                return;
            }
		}else{
			$this->msg[]='图片上传失败！原因：'.$data['msg'];
            return;
        }
	}
}