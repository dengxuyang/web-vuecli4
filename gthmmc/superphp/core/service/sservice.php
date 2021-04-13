<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 业务服务类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/

require_once(SUPERTPHP_PATH . "/initphp/initphp.php");
require_once(SUPERTPHP_PATH . "/common/extension.php");

class SService extends Service{
	private $extensionClass;
	
    function __construct() {
       $this->extensionClass = new Extension();
       parent::__construct();
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
}