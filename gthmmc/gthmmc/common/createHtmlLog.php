<?php
require_once dirname(__FILE__) . '/../../superphp/core/controller/scontroller.php';
/**
 *
 * 站点生成日志类
 * @author linwf
 *
 */
class createHtmlLog extends SController{
	/**
	 * 
	 * 清空日志
	 */
	public  function clearLog(){
		ob_start();
		session_start();
		unset($_SESSION["createHtmlLog"]);
		//unset($_SESSION["isCreate"]);
		session_write_close();
	}
	/**
	 * 
	 * 是否产生日志
	 */
	public function isCreateLog(){
		//$getSession = $this->getUtil("session");
		session_start();
		//$isCreate = $getSession->get("isCreate");
		$isCreate = $_SESSION["isCreate"];
		session_write_close();
		return $isCreate;
	}
	/**
	 * 
	 * 加入日志
	 * @param unknown_type $log
	 */
	public function pushLog($log){
		//$getSession = $this->getUtil("session");
		//$logArr = $getSession->get("createHtmlLog");
		//if (empty($logArr)){
		//	$logArr = Array();
		//}
		//array_push($logArr, $log);
		//$getSession->set("createHtmlLog", $logArr);
		//$getSession->set("isCreate", $log);
		date_default_timezone_set(PRC);
		session_start();
		$logArr = $_SESSION["createHtmlLog"];
		if (empty($logArr)){
			$logArr = Array();
		}
		if ($log == "success"){
			array_push($logArr, $log);
		}else{
			array_push($logArr, "【" . date('Y-m-d H:i:s',time()) . "】" . $log);
		}
		$_SESSION["createHtmlLog"] = $logArr;
		//$_SESSION["isCreate"] = true;
		//echo $log . $_SESSION["isCreate"];
		session_write_close();
	}
	/**
	 * 
	 * 获取日志
	 */
	public function popLog(){
/*		$getSession = $this->getUtil("session");
		$logArr = $getSession->get("createHtmlLog");
		$result = implode("<br>",$logArr);
		$this->getSession->del("createHtmlLog");
		$this->getSession->del("isCreate");*/
		ob_start();
		session_start();
		$logArr = $_SESSION["createHtmlLog"];
		if (!empty($logArr)){
		   $result = array_shift($logArr);
		}
		$_SESSION["createHtmlLog"] = $logArr;
		//$result = implode("<br>",$logArr);
		//unset($_SESSION["createHtmlLog"]);
		//$_SESSION["isCreate"] = false;
		session_write_close();
		return $result;
	}
}