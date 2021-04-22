<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 控制器类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/

require_once(SUPERTPHP_PATH . "/initphp/initphp.php");
require_once(SUPERTPHP_PATH . "/common/extension.php");
require_once(SUPERTPHP_PATH . "/engine/defaultEngine.php");

class SController extends Controller{
	public $initphp_list;     //白名单
	private $extensionClass;  //super实现util和library工具类
	protected $templateEngine;//模板引擎
	
    function __construct() {
       parent::__construct();
       $this->extensionClass = new Extension();
       $InitPHP_conf = SuperPHP::getConfig();
       $this->templateEngine = new SDefaultEngine($InitPHP_conf['template'], $this);
    }
    /**
     * 
     * 设置白名单，在这个名单中的方法，可执行；如果不在，执行默认方法
     * @param unknown_type $whiteList
     */
	public function SetWhiteList($whiteList){
		$this->initphp_list = $whiteList;
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
	
	public function compileAssign($key, $val){
		$this->view->assign($key, $val);
	}
	
	public function compileDisplay($template){
		$this->view->display($template);
	}
}