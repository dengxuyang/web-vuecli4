<?php
require_once(SUPERTPHP_PATH . "/initphp/init/exception.init.php");

class ExceptionSuper extends exceptionInit{
	public function errorMessage() {
		$InitPHP_conf = InitPHP::getConfig();
		$msg = $this->message;
		if (!$InitPHP_conf['is_debug'] && $this->code == 10000) {
			$msg = '系统繁忙，请稍后再试';
		}
		if ($this->is_ajax()) {
			$arr = array('status' => 0, 'message' => $msg, 'data' => array('code' => $this->code));
			echo json_encode($arr);
		} else {
			echo '<div style="-moz-box-shadow:0 0 5px #EAEAEA;
			background:none repeat scroll 0 0 #FFFEF5;
			font-size:12px;
			border:3px solid #DCC7AB;
			color:#000000;
			font:12px/1.5 Arial,Microsoft Yahei,Simsun;
			margin:50px auto;
			padding:20px;
			width:500px;">
			<span style="font-weight:bold; font-size:14px;margin-right:10px;">
			SuperPHP Error Message:</span>
			'.$msg.'</div>';	
		}
	}

	/**
	 * @return bool
	 */
	private function is_ajax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
		if ($_POST['initphp_ajax'] || $_GET['initphp_ajax']) return true; //程序中自定义AJAX标识
		return false;
	}
}