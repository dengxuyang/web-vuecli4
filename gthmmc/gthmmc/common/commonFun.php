<?php
require_once dirname(__FILE__) . '/../../superphp/core/controller/scontroller.php';
class commonFun extends SController{
	/**
	 *
	 * 获取当前站点Id
	 */
	public function getCurrentSiteId(){
		$getSession = $this->getUtil("session");
		return $getSession->get("siteId");
	}
	/**
	 *
	 * 获取当前站点别名
	 */
	public function getCurrentSiteAlias(){
		$getSession = $this->getUtil("session");
		return $getSession->get("siteAlias");
	}
	/**
	 *
	 * 获取当前登录帐户Id
	 */
	public function getCurrentAccountId(){
		$getSession = $this->getUtil("session");
		$currentData = $getSession->get("accountData");
		return $currentData["row_id"];
	}
	/**
	 *
	 * 获取当前登录帐户权限
	 */
	public function getCurrentAccountRight(){
		$getSession = $this->getUtil("session");
		$currentData = $getSession->get("accountData");
		return $currentData["right"];
	}
}
