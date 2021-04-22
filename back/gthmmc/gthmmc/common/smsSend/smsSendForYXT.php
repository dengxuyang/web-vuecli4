<?php
/*********************************************************************************
 * 短信发送实现类 smsSendBase 用于易信通 
 * $Author:林维锋
 * $Dtime:2014-06-12
 ***********************************************************************************/
require_once dirname(__FILE__) . '/smsSendBase.php';

class smsSendBaseForYXT extends smsSendBase{
	function __construct() {
		$user = "liugongxun";
		$pwd = "c9f4d341e4115aecb7234792892460a3";
		$this->setAccount($user, $pwd);
		$sFormat = sprintf("?cusername=%s&cpassword=%s", $user, $pwd);
		$sFormat .= "&smsnumber=106&to=%s&content=%s&plantime=&id=%s";
		$this->setHttp("http://interface.extsms.com/c_sendsms.aspx", $sFormat);
	}
	/**
	 * 
	 * 发送短信
	 * @param unknown_type $telphone
	 */
	public function sendSms($telphone = array(), $content){
		$res = new stdClass();
		$res->result = false;
		$sendTelphone = empty($telphone)?$telphone:array_filter($telphone);
		if (empty($sendTelphone)){
		   $res->error = urlencode("手机号码不能为空");
		   return $res;
		}
		$resArr = parent::sendSms($sendTelphone, $content);
		if ($resArr->isOk ==  "1"){
		    $res->result = true;
		}else{
			$res->error = $resArr->message;
		}
		return $res;
	}
}