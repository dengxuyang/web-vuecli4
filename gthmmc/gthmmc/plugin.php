<?php 
if (isset($_GET["pm"])){
	$pm = $_GET['pm'];
}
if (empty($pm)){
	$pm = 'tomms';
}
$p = $_GET['p'];
define('PLUGINPTAH', 'plugin/' . $pm . '/' . $p . '/');
require_once PLUGINPTAH . 'index.php';
