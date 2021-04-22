<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 程序运行的入口类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/

require_once("initphp/initphp.php");
require_once("superconf.php");
require_once("common/extension.php");
require_once('exceptionSuper.php');
require_once('common/protect.php'); 

class SuperPHP extends InitPHP{
	private $extensionClass;
	
    function __construct() {
       $this->extensionClass = new Extension();
       parent::__construct();
    }
    
	public static function start() {
		$protect = new protect();
		$protect->handle($_GET['ba']);
		parent::init();
	}
	
	public static function getUtilStatic($class){
		self::getUtil($class);
	}
	
	public function getUtil($class){
		$superUtil = $this->extensionClass->getUtil($class);
		if ($superUtil){
			return $superUtil;
		}else {
			return parent::getUtil($class);
		}
	}
	public function getLibrary($class){
		$superLibrary = $this->extensionClass->getLibrary($class);
		if ($superLibrary){
			return $superLibrary;
		}else{
			return parent::getLibrary($class);
		}
	}
	
	/**
	 * 【静态】框架错误机制
	 * 1. 框架的错误信息输出函数，尽量不要使用在项目中
	 * 全局使用方法：InitPHP::initError($msg)
	 * @param $msg
	 * @return html
	 */
	public static function superError($msg, $code = 10000) {
		throw new ExceptionSuper($msg, $code);
	}
}