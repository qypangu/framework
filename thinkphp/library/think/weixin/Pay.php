<?php

// +----------------------------------------------------------------------
// | Author: 黄建文   
// | email:hjwtp2005@qq.com
// | 微信现金红包接口，https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=1_1
// | 本接口主要用于营销使用，是商家发红包给用户的一个支付工具接口
// | 
// +----------------------------------------------------------------------
namespace think\weixin;
class Pay {
	//证书
	private $apiclient_cert = '';
	private $apiclient_key = '';
	//pay的秘钥值
	private $apikey = "";
	//错误信息
	private $error = '';

	private $mchid = '';//商户号
	private $mchappid = '';//公众号
	private $openid = '';//接收者openid
	private $amount = 100;//金额
	private $partnertradeno = '';//订单号
	private $spbillcreateip = '';//触发ip
	private $checkname = 'NO_CHECK';//校验要求

	private $sendname = '发送者名字';
	private $wishing = '祝福语';
	private $actname = '活动名称';
	private $remark = '有钱，任性';

	private $totalnum =3;
	private $amttype ='ALL_RAND';

	//裂变红包
	private $api_group = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";
    //普通红包
	private $api_single = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
    //企业支付
	private $api_compay = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
	//约包查询
	private $api_redbag_select = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo";
	//企业支付查询
	private $api_compay_select = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo";

	/**
	 * 配置支付商户的信息	 * 
	 * @param 商户号 $config['mch_id']， 公众账号appid$config['wxappid']，api密钥$config['apikey']
	 */
	public function __construct($config){
	    $this->mchid=$config['mch_id']; //商户号
	    $this->mchappid=$config['wxappid'];
	    $this->wxappid=$config['wxappid']; //公众账号appid
	    $this->apikey=$config['apikey']; //api密钥
	    $this->apiclient_cert=$config['cert_pem'];
	    $this->apiclient_key=$config['key_pem'];
	    
	}
	/**
	*公用-支付用商户号
	*@var string
	*/
	public function setMchid($mchid){
		$this->mchid = $mchid;
	}
	/**
	*公用-pay的秘钥值
	*@var string
	*/
	public function setApiKey($apikey){
		$this->apikey = $apikey;
	}


	/**
	*企业支付用微信公众号
	*@var string
	*/
	public function setMchAppid($mchappid){
		$this->mchappid = $mchappid;
	}
	/**
	*企业支付接收用户openid
	*@var string
	*/
	public function setOpenid($openid){
		$this->openid = $openid;
	}

	/**
	*企业支付金额
	*@var integer
	*/
	public function setAmount($amount){
		$this->amount = $amount;
	}
	/**
	*企业支付描述
	*@var string
	*/
	public function setDesc($desc){
		$this->remark = $desc;
	}
	
	/**
	*企业支付订单号
	*@var string
	*/
	public function setPartnerTradeNo($partnertradeno){
		$this->partnertradeno = $partnertradeno;
	}
	/**
	*企业支付触发ip
	*@var string
	*/
	public function setSpbillCreateIp($spbillcreateip){
		$this->spbillcreateip = $spbillcreateip;
	}
	/**
	*企业支付校验规则
	*@var string
	*/
	public function setCheckName($checkname){
		$this->checkname = $checkname;
	}

	/**
	*红包支付公众号
	*@var string
	*/
	public function setWxappid($wxappid){
		$this->mchappid = $wxappid;
	}
	/**
	*红包支付订单号
	*@var string
	*/
	public function setMchBillNo($mchbillno){
		$this->partnertradeno = $mchbillno;
	}
	/**
	*红包支付触发ip
	*@var string
	*/
	public function setClientIp($clientip){
		$this->spbillcreateip = $clientip;
	}
	/**
	*红包接收者/裂一变红包的种子接收者
	*@var string
	*/
	public function setReOpenid($reopenid){
		$this->openid = $reopenid;
	}
	/**
	*红包支付金额
	*@var integer
	*/
	public function setTotalAmount($totalamount){
		$this->amount = $totalamount;
	}
	/**
	*红包支付公众号
	*@var string
	*/
	public function setSendName($sendname){
		$this->sendname = $sendname;
	}
	/**
	*红包支祝福语
	*@var string
	*/
	public function setWishing($wishing){
		$this->wishing = $wishing;
	}
	/**
	*红包支付活动名称
	*@var string
	*/
	public function setActName($actname){
		$this->actname = $actname;
	}
	/**
	*红包支付备注信息
	*@var string
	*/
	public function setRemark($remark){
		$this->remark = $remark;
	}
	/**
	*红包支付个数-裂变专用
	*@var string
	*/
	public function setTotalNum($totalnum){
		$this->totalnum = $totalnum;
	}

	public function setAppId($appid){
		$this->mchappid = $appid;
	}
	/**
	*错误反馈
	*@return string
	*/
	public function error(){
		return $this->error;
	}

	/**
	*普通红包支付
	* $this->mchappid和$this->mchid;在初始化时已设置
	*@return boolean
	*/
	public function RedBag($config){
	    $this->license();
		$obj = array();
		$obj['mch_id'] = $this->mchid;
		$obj['wxappid'] = $this->wxappid;		
		$obj['mch_billno'] = $this->GenBillNo();
		$obj['client_ip'] = $this->ip();
		$obj['re_openid']=$config['openid'];
		$obj['total_amount']=$config['total_amount']*100;
		$obj['total_num']=1;
		$obj['send_name']=$config['send_name'];
		$obj['wishing'] =$config['wishing'];
		$obj['act_name'] =$config['act_name'];
		$obj['remark'] =$config['remark'];
		$url = $this->api_single;
		return $this->Pay($url,$obj);
	}



	/**
	*裂变红包支付
	*@return boolean
	*/
	public function RedBagGroup(){
		if(!$this->inited()) return;
		$obj = array();
		$obj['wxappid'] = $this->mchappid;
		$obj['mch_id'] = $this->mchid;
		$obj['mch_billno'] = $this->partnertradeno;
		$obj['re_openid'] = $this->openid;
		$obj['total_amount'] = $this->amount;
		$obj['total_num'] = $this->totalnum;
		$obj['amt_type'] = $this->amttype;
		$obj['send_name'] = $this->sendname;
		$obj['wishing'] = $this->wishing;
		$obj['act_name'] = $this->actname;
		$obj['remark'] = $this->remark;
		$url = $this->api_single;
		return $this->Pay($url,$obj);
	}
	/**
	*企业支付
	*@return boolean
	*/
	public function ComPay($config){
		if(!$this->inited()) return;
		$obj = array();
		$obj['openid'] =$config['openid'];
		$obj['amount'] =$config['amount'];
		$obj['desc'] =$config['desc'];
		$obj['mch_appid'] = $this->mchappid;
		$obj['mchid'] = $this->mchid;
		$obj['partner_trade_no'] = $this->GenBillNo();
		$obj['spbill_create_ip'] = $this->ip();
		$obj['check_name'] = $this->checkname;
		$url = $this->api_compay;
		$xml=$this->Pay($url,$obj);
// 		$xml='<xml><return_code><![CDATA[SUCCESS]]></return_code>
// <return_msg><![CDATA[]]></return_msg>
// <mch_appid><![CDATA[wx31eb5e7d3aaba48c]]></mch_appid>
// <mchid><![CDATA[1398082002]]></mchid>
// <nonce_str><![CDATA[onMs8pSpissniVC3Ze9m05B6nADI4HZQ]]></nonce_str>
// <result_code><![CDATA[SUCCESS]]></result_code>
// <partner_trade_no><![CDATA[1398082002201902121544008539]]></partner_trade_no>
// <payment_no><![CDATA[1398082002201902120939266078]]></payment_no>
// <payment_time><![CDATA[2019-02-12 16:41:46]]></payment_time>
// </xml>';
		if ($xml) {
		    $rs=$this->xmlToArray($xml);
		    return $rs;
		}else {
		    return false;
		}
		
	}
	/**
	*红包查询
	*@return array
	*/
	public function BagSelect(){
		$this->license();
		$obj = array();
		$obj['appid'] = $this->mchappid;
		$obj['mch_id'] = $this->mchid;
		$obj['mch_billno'] = $this->partnertradeno;
		$obj['bill_type'] = 'MCHT';
		$url = $this->api_redbag_select;
		return $this->Pay($url,$obj);
	}
	/**
	*企业支付查询
	*@return array
	*/
	public function ComPaySelect(){
		$this->license();
		$obj = array();
		$obj['appid'] = $this->mchappid;
		$obj['mch_id'] = $this->mchid;
		$obj['partner_trade_no'] = $this->partnertradeno;
		$url = $this->api_compay_select;
		return $this->Pay($url,$obj);
	}

	/**
	*支付前准备
	*@return boolean
	*/
	private function inited(){
		$inited = true;
		$amount = $this->amount;
		if(!is_numeric($amount)){
			$this->error = "金额参数错误";
			$inited = false;
		}elseif($amount<100){
			$this->error = "金额太小";
			$inited = false;
		}elseif($amount>20000){
			$this->error = "金额太大";
			$inited = false;
		}
		if(!$this->partnertradeno){
			$this->partnertradeno = $this->GenBillNo();
		}
		if(!$this->spbillcreateip)
			$this->spbillcreateip = $_SERVER['REMOTE_ADDR'];
		$this->license();
		return $inited;
	}
	/**
	*证书初始化
	*放在同目录 cacert/文件夹下
	*/
	private function license(){
		if(!$this->apiclient_cert) 
		    $this->apiclient_cert = $_SERVER['DOCUMENT_ROOT']."/cacert/apiclient_cert.pem";
		if(!$this->apiclient_key) 
		    $this->apiclient_key = $_SERVER['DOCUMENT_ROOT']."/cacert/apiclient_key.pem";
	}

	/**
	*生在订单号
	*@return boolean
	*/
	private function GenBillNo(){
		$rnd_num = array('0','1','2','3','4','5','6','7','8','9');
		$rndstr = "";
		while(strlen($rndstr)<10){
			$rndstr .= $rnd_num[array_rand($rnd_num)];    
		}

		return $this->mchid.date("Ymd").$rndstr;
	}

	/**
	*完成支付操作
	*@url string
	*@obj array
	*@return boolean
	*/
	private function Pay($url,$obj){	
		$obj['nonce_str'] = $this->create_noncestr();
		$sign = $this->getSign($obj);
		$obj['sign'] = $sign;
		$postXml = $this->arrayToXml($obj);
		$responseXml = $this->CurlPostSsl($url,$postXml);
		return $responseXml;
	}
	/**
	*创建随机字串
	*@return string
	*/
	private function create_noncestr($length = 32){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for ($i = 0; $i <$length; $i++){
			$str .= substr($chars,mt_rand(0,strlen($chars)-1),1);
		}
		return $str;
	}
	/**
	*创建签名
	*@return string
	*/
	private function getSign($arr){
		ksort($arr); //按照键名排序
		$sign_raw = '';
		foreach($arr as $k => $v){
			$sign_raw .= $k.'='.$v.'&';
		}
		$sign_raw .= 'key='.$this->apikey;

		return strtoupper(md5($sign_raw));
	}

	/**
     * WXHongBao::genXMLParam()
     * 生成post的参数xml数据包
     * @return $xml
     */
	private function arrayToXml($arr){
		$xml ="<xml>";
		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= "<".$key.">".$val."</".$key.">";
			}else{
				$xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
			}
		}
		$xml .= "</xml>";
		return $xml;		
	}
	//将XML转为array
	private function xmlToArray($xml){
	    //禁止引用外部xml实体
	    libxml_disable_entity_loader(true);
	    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	    return $values;
	}

	/**
     * curl提交
     * @return $boolean
     */
	private function CurlPostSsl($url,$xml,$second = 10){
		$ch = curl_init();   	
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);    	
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT,$this->apiclient_cert);
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY,$this->apiclient_key);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);            
			$rsxml = simplexml_load_string($data);
			if($rsxml->return_code == 'SUCCESS' ){
				return $data;
			}else{
				$this->error = $rsxml->return_msg;
				return false;    
			}
		}else{ 
			$this->error = curl_errno($ch);
			curl_close($ch);
			return false;
		}
	}
	/**
	 * 取得IP地址
	 */
	private function ip(){
	    $ip=$_SERVER['REMOTE_ADDR'];
	    return $ip;
	}
}

