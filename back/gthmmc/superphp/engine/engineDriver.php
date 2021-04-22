<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 引擎驱动类，先判断super类中是否定义驱动，
 * 如没有，调用initphp驱动
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/
require_once(SUPERTPHP_PATH . "/initphp/core/view/view.init.php");
require_once(SUPERTPHP_PATH . "/initphp/initphp.php");

class SEngineDriver{
	private $template_tag_left  = '<!--['; //左标签
	private $template_tag_right = ']-->'; //右标签
	
	private $TemplateToFile_conf;
	private static $driver      = NULL; //定义默认的一个模板编译驱动模型
	/**
	 * 初始化 
	 */
	public function __construct() {
		//parent::__construct();
		$getConfig = InitPHP::getConfig();
		
		$this->TemplateToFile_conf = $getConfig['templateToFile'];
		$this->setDriver($this->TemplateToFile_conf['driver']);
		/*
		if (isset($this->InitPHP_conf['template_tag_left'])) {
			$this->template_tag_left = $this->InitPHP_conf['template_tag_left'];
		}
		if (isset($this->InitPHP_conf['template_tag_right'])) {
			$this->template_tag_right = $this->InitPHP_conf['template_tag_right'];
		}
		*/
	}
	/**
	 * 模板编译-获取不同
	 * @param  string $template_name 模板名称
	 * @return string
	 */
	private function setDriver($driver) {
		$diver_path = 'driver/' . $driver . '.super.php';
		if (self::$driver === NULL) {
			require_once($diver_path);
			$class = $driver . 'Super';
			if (!class_exists($class)) {
				return null;
			}
			$super_class = new $class;
			self::$driver = $super_class;
		}
		return self::$driver;
	}

	/**
	 * 模板编译-标签正则替换
	 * @param  string $str 模板文件数据
	 * @return string
	 */
	private function replace_tag($str) {
		if (self::$driver === NULL){
			return "";
		}
	    return self::$driver->compile($str, $this->template_tag_left, $this->template_tag_right); //编译
	}

	/**
	 * 
	 * 模板语法解析
	 * @param unknown_type $str
	 */
	public function compile($str){
		$templateStr = $this->replace_tag($str);
		return $templateStr;
	}
}