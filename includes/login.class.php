<?php
class qq_login{
	private $ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
	private $trace_x;
	private $trace_y;
	private $trace_time;
	private $tokenid;
	private $referrer;
	public function setProxy($url){
		$this->proxy = $url;
	}
	public function getqrpic(){
		$url='https://ssl.ptlogin2.qq.com/ptqrshow?appid=549000912&e=2&l=M&s=4&d=72&v=4&t=0.5409099'.time().'&daid=5';
		$arr=$this->get_curl_split($url);
		preg_match('/qrsig=(.*?);/',$arr['header'],$match);
		if($qrsig=$match[1])
			return array('saveOK'=>0,'qrsig'=>$qrsig,'data'=>base64_encode($arr['body']));
		else
			return array('saveOK'=>1,'msg'=>'二维码获取失败');
	}
	public function qrlogin($qrsig){
		if(empty($qrsig))return array('saveOK'=>-1,'msg'=>'qrsig不能为空');
		$url='https://ssl.ptlogin2.qq.com/ptqrlogin?u1=https%3A%2F%2Fqzs.qq.com%2Fqzone%2Fv5%2Floginsucc.html%3Fpara%3Dizone&ptqrtoken='.$this->getqrtoken($qrsig).'&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-0-'.time().'0000&js_ver=10194&js_type=1&login_sig='.$sig.'&pt_uistyle=40&aid=549000912&daid=5&';
		$ret = $this->get_curl($url,0,$url,'qrsig='.$qrsig.'; ',1);
		if(preg_match("/ptuiCB\('(.*?)'\)/", $ret, $arr)){
			$r=explode("','",str_replace("', '","','",$arr[1]));
			if($r[0]==0){
				preg_match('/uin=(\d+)&/',$ret,$uin);
				$uin=$uin[1];
				preg_match('/skey=@(.{9});/',$ret,$skey);
				preg_match('/superkey=(.*?);/',$ret,$superkey);
				$data=$this->get_curl($r[2],0,0,0,1);
				if($data) {
					preg_match("/p_skey=(.*?);/", $data, $matchs);
					$pskey = $matchs[1];
				}
				if($pskey){
					if(isset($_GET['findpwd'])){
						$_SESSION['findpwd_qq']=$uin;
					}
					return array('saveOK'=>0,'uin'=>$uin,'skey'=>'@'.$skey[1],'pskey'=>$pskey,'superkey'=>$superkey[1],'nick'=>$r[5]);
				}else{
					return array('saveOK'=>6,'msg'=>'登录成功，获取相关信息失败！'.$r[2]);
				}
			}elseif($r[0]==65){
				return array('saveOK'=>1,'msg'=>'二维码已失效。');
			}elseif($r[0]==66){
				return array('saveOK'=>2,'msg'=>'二维码未失效。');
			}elseif($r[0]==67){
				return array('saveOK'=>3,'msg'=>'正在验证二维码。');
			}else{
				return array('saveOK'=>6,'msg'=>$r[4]);
			}
		}else{
			return array('saveOK'=>6,'msg'=>$ret);
		}
	}
	private function getqrtoken($qrsig){
        $len = strlen($qrsig);
        $hash = 0;
        for($i = 0; $i < $len; $i++){
            $hash += (($hash << 5) & 2147483647) + ord($qrsig[$i]) & 2147483647;
			$hash &= 2147483647;
        }
        return $hash & 2147483647;
	}
	private function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0){
		$ch = curl_init();
		if($this->proxy){
			$arr = explode(':',$this->proxy);
			curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_PROXY, $arr[0]);
			curl_setopt($ch, CURLOPT_PROXYPORT, $arr[1]?$arr[1]:80);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		}
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept: application/json";
		$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
		$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
		$httpheader[] = "Connection: keep-alive";
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
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
		if($ua){
			curl_setopt($ch, CURLOPT_USERAGENT,$ua);
		}else{
			curl_setopt($ch, CURLOPT_USERAGENT,$this->ua);
		}
		if($nobaody){
			curl_setopt($ch, CURLOPT_NOBODY,1);

		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	private function get_curl_split($url){
		$ch = curl_init();
		if($this->proxy){
			$arr = explode(':',$this->proxy);
			curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_PROXY, $arr[0]);
			curl_setopt($ch, CURLOPT_PROXYPORT, $arr[1]?$arr[1]:80);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		}
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept: */*";
		$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
		$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
		$httpheader[] = "Connection: keep-alive";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT,$this->ua);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($ret, 0, $headerSize);
		$body = substr($ret, $headerSize);
		$ret=array();
		$ret['header']=$header;
		$ret['body']=$body;
		curl_close($ch);
		return $ret;
	}
}