<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 扩展类，新增的核心工具及扩展类库存放到suerpphp/core/util和suerpphp/library目录下
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/
class Extension {
	protected static $instance = array(); //单例容器 
	private $super_path = array(
				'u' => '/core/util/', //核心工具
				'l' => '/library/', //扩展类库
				);	
	

	/**
	 *	【私有】获取superPHP系统类文件路径
	 *  @param  string  $class_name  类名称
	 *  @param  string  $type        类所属类型
	 *  @return string
	 */
	private function get_class_path($class_name, $type) {
		$class_path = $this->super_path[$type] . $class_name . '.php';
		$class_path = SUPERTPHP_PATH . $class_path;
		return $class_path;
	}
	/**
	 *	【私有】获取superPHP系统类完整名称
	 *  @param  string  $class_name  类名称
	 *  @return string
	 */
	private function get_class_name($class_name) {
		return $class_name;
	}
	/**
	 * 【私有】实例化类，类实例为单例模式
	 * @param string $class_name 类名称
	 * @param string $type 类别
	 */
	private function load($class_name, $type) {
		$class_path = $this->get_class_path($class_name, $type);
		$class_name = $this->get_class_name($class_name);

		if (!file_exists($class_path)) {
			return null;
		}
		if (!isset(self::$instance['superphp'][$class_name])) {
			require_once($class_path);
			if (!class_exists($class_name)) {
				return null;
			}
			$init_class = new $class_name;
			self::$instance['superphp'][$class_name] = $init_class;
		}
		return self::$instance['superphp'][$class_name];
	}
	/**
	 *	superPHP系统获取library下面的类
	 *  @param  string  $class_name  类名称
	 *  @return object
	 */
	public function getLibrary($class, $parent="") {
		$class = $this->load($class, "l");
	    if ($class) {
			return $class;
		}
		return null;
	}
	/**
	 *	superPHP系统获取Util类函数
	 *  @param  string  $class_name  类名称
	 *  @return object
	 */
	public function getUtil($class, $parent="") {
		$loadClass = $this->load($class, "u");
	    if ($loadClass) {
			return $loadClass;
		}
		return null;
	}
}