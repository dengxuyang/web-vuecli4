<?php
class netInterfaceSuper  {
	
	/**
	 * 
	 * 
	 */
	public function getCityOfIp(){
		$ip = $this->get_client_ip();
		return file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip);
	}
	//获取用户真实IP
	public function get_client_ip() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
			$ip = getenv("HTTP_CLIENT_IP");
		}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");

		}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
			$ip = getenv("REMOTE_ADDR");
		}else if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']
			&& strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
			$ip = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip = "unknown";
		}
		return ($ip);
	}
}