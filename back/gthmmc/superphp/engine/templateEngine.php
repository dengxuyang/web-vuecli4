<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 模板引擎接口及抽象类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2013-9-13
 ***********************************************************************************/
require_once("tagAdapter.php");
require_once("engineDriver.php");

interface ISTemplateEngine{
	function setTagAdapter($tagAdapter);
	function assign($key, $value);
	function compile($template);
}

class STemplateEngine implements ISTemplateEngine{
	private $template_path      = 'template';   //模板目录
	private $template_c_path    = 'template_c'; //编译目录
	private $template_type      = 'html'; //模板文件类型
	private $template_c_type    = 'tpl.php'; //模板编译文件类型
	private $template_tag_left  = '<!--['; //左标签
	private $template_tag_right = ']-->'; //右标签
	private $is_compile 		= true; //是否需要每次编译
	private $template_config;        //模板配置
	private static $driver      = NULL; //定义默认的一个模板编译驱动模型

	protected $controller;
	protected $variable = array(); //模板变量
	protected $_tagAdapter;        //标签适配器
	protected $_engineDriver;


	function __construct($config, $controler){
		//$this->_engineDriver = new SEngineDriver();
		$this->controller = $controler;
		$this->template_config = $config;
		if (isset($this->template_config['template_path'])) {
			$this->template_path = $this->template_config['template_path'];
		}
		if (isset($this->template_config['template_c_path'])) {
			$this->template_c_path = $this->template_config['template_c_path'];
		}
		if (isset($config['template_type'])){
			$this->template_type = $config['template_type'];
		}
		if (isset($config['template_c_type'])){
			$this->template_c_type = $config['template_c_type'];
		}
		if (isset($config['template_tag_left'])) {
			$this->template_tag_left = $config['template_tag_left'];
		}
		if (isset($config['template_tag_right'])) {
			$this->template_tag_right = $config['template_tag_right'];
		}
		if (isset($config['is_compile'])) {
			$this->is_compile = $config['is_compile'];
		}
		$this->get_driver($this->template_config['driver']);
	}

	function setTagAdapter($tagAdapter){
		$this->_tagAdapter = $tagAdapter;
	}

	function assign($key, $value){
		$this->variable[$key] = $value;
	}

	public function compile($template){
		ob_start();//开启缓冲
		if (self::$driver === NULL){
			//super设置的驱动不存在，调用initphp驱动，【调用initphp未实现动态】
			if (is_array($this->variable)) {
				foreach ($this->variable as $key => $val) {
					$this->controller->compileAssign($key, $val);
				}
			}
			$this->controller->compileDisplay($template);
		}else{
			$this->display($template);
		}
		$compileStr = ob_get_contents();
		ob_end_clean();
		return $compileStr;
	}

	private function display($file_name) {
		$this->check_path(); //检测模板目录和编译目录
		list($template_file_name, $compile_file_name) = $this->get_file_name($file_name);
		if (($this->is_compile == true) || ($this->is_compile == false && !file_exists($compile_file_name))) { //是否强制编译
			$str = $this->readTemplate($template_file_name);
			if ($this->_tagAdapter){
				$str = $this->_tagAdapter->compile($str, $this->template_tag_left, $this->template_tag_right);
			}
			if (is_array($this->variable)) {
				if ($InitPHP_conf['isviewfilter']) $this->out_put($this->variable);
				foreach ($this->variable as $key => $val) {
					$$key = $val;
				}
			}
			//$str = $this->layout($str); //layout模板页面中加载模板页
			$str = $this->driverRun($str);
			//$str = $this->compile_version($str, $template_file_name);
			//TODO 去掉在目录中生成编译模板文件
			$this->saveCompileTemplate($compile_file_name, $str);
		}
		if (!file_exists($compile_file_name)) {
			SuperPHP::superError($compile_file_name. ' is not exist!');
		}

		include($compile_file_name);
		//echo $str;
	}

	private function readTemplate($template_file_name) {
		if (!file_exists($template_file_name)){
			return "";
		}
		return @file_get_contents($template_file_name);
	}

	private function driverRun($str) {
		if (self::$driver === NULL){
			return null;
		}else{
			return self::$driver->compile($str, $this->template_tag_left, $this->template_tag_right); //编译
		}
	}

	private function saveCompileTemplate($compile_file_name, $str) {
		if (($path = dirname($compile_file_name)) !== $this->template_c_path) { //自动创建文件夹
			$this->create_dir($path);
		}
		@file_put_contents($compile_file_name, $str);
	}

	private function create_dir($path) {
		if (is_dir($path)) return false;
		$this->create_dir(dirname($path));
		@mkdir($path);
		@chmod($path, 0777);
		return true;
	}
	private function get_file_name($file_name) {
		$filetype= strrchr($file_name, ".");
		$fileName=str_replace($filetype,"",$file_name);
		return array(
		$this->template_path .'/'. $fileName . '.' . $this->template_type, //组装模板文件路径
		$this->template_c_path .'/'. $fileName . '.' . $this->template_c_type //模板编译路径
		);
	}

	private function check_path() {
		if (!is_dir($this->template_path) || !is_readable($this->template_path)) InitPHP::initError('template path is unread!');
		if (!is_dir($this->template_c_path) || !is_readable($this->template_c_path)) InitPHP::initError('compiled path is unread!');
		return true;
	}

	private function get_driver($driver) {
		$diver_path = SUPERTPHP_PATH . '/engine/driver/' . $driver . '.super.php';
		if (self::$driver === NULL && file_exists($diver_path)) {
			require_once($diver_path);
			$class = $driver . 'Super';
			if (!class_exists($class)) {
				return null;
			}
			$init_class = new $class;
			self::$driver = $init_class;
		}
		return self::$driver;
	}
	/**
	 * 模板-模板变量输出过滤
	 * @param  array  $arr 视图存放器数组
	 * @return array
	 */
	private function out_put(&$value) {
		$value = (array) $value;
		foreach ($value as $key => $val) {
			if (is_array($val)) {
				self::out_put($value[$key]);
			} elseif (is_object($val)) {
				$value[$key] = $val;
			} else {
				if (function_exists('htmlspecialchars')) {
					$value[$key] =  htmlspecialchars($val);
				} else {
					$value[$key] =  str_replace(array("&", '"', "'", "<", ">", "%3C", "%3E"), array("&amp;", "&quot;", "&#039;", "&lt;", "&gt;", "&lt;", "&gt;"), $val);
				}
			}
		}
	}
}