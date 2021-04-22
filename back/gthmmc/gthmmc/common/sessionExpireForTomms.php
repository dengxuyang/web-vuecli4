<?php
$session_id=$_REQUEST['SESSION_ID'];
if($session_id && $session_id!=session_id()){
    session_destroy();
    session_id($session_id);
    @session_start();    
}
    
$getData = $this->getUtil("session")->get("accountData");
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//ajax请求过期
	if(empty($getData)){
		echo "timeout";
		exit;
	}
}else if(empty($getData) || empty($_COOKIE['PHPSESSID'])){
	print_r($getData);
	//正常请求过期
	echo "<script>";
	echo "alert('信息已过期,请重新登陆!');";
	echo "parent.window.parent.window.location.href = '?m=tomms';";
	echo "</script>";
	exit;
}
