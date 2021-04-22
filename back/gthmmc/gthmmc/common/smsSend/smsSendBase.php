<?php
/*********************************************************************************
 * 短信发送基类 smsSendBase
 * $Author:林维锋
 * $Dtime:2014-06-12
 ***********************************************************************************/
class smsSendBase{
	private $smsUser;
	private $smsPwd;
	private $sendHttp;
	private $sendFormat;
	/**
	 * 
	 * 设置帐户和密码
	 * @param unknown_type $user
	 * @param unknown_type $pwd
	 */
	public function setAccount($user, $pwd){
		$this->smsUser = $user;
		$this->smsPwd = $pwd;
	}
	/**
	 * 
	 * 设置短信提交的地址
	 * @param unknown_type $http
	 */
	public function setHttp($http, $sFormat){
		$this->sendHttp = $http;
		$this->sendFormat = $sFormat;
	}
	/**
	 * 
	 * 发送短信
	 * @param unknown_type $telphone
	 */
	protected  function sendSms($telphone = array(), $content){
		$sendContent = $this->sendHttp . sprintf($this->sendFormat, implode(",", $telphone), $content, 0);
		$sendRes = file_get_contents($sendContent);
		$resArr = simplexml_load_string($sendRes);
		return $resArr;
	}
}