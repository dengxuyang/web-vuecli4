<?php
define("APP_PATH", dirname(__FILE__));
define("APP_MANAGER_PATH", ".");
header("Content-Type:text/html;charset=utf-8");
require_once APP_PATH . '/../superphp/superphp.php';
require_once APP_PATH .'/conf/conf.php';
require_once APP_PATH . '/common/commonDef.php';
SuperPHP::start();
