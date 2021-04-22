<?php
session_start();
$getData = $_SESSION["accountData"];
if(empty($getData)){
	echo "<script>";
	echo "alert('信息已过期,请重新登陆!');";
	echo "parent.window.location.href = '../../index.php?m=tomms';";
	echo "</script>";
	exit;
}
$_POST['username'] = 'admin'; 
require_once( dirname(__FILE__).'/index.php');
?>