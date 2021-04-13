<?php
/*********************************************************************************
 * session自定义类，比自带session的优点：
 * 1.控制一个帐号只能一个人登录
 * 2.统计在线人数
 * 3.踢出某个在线用户
 * 4.多站点共享session（网络通行证）
 * 5.实现Application变量（多用户共享的全局变量）
 *-------------------------------------------------------------------------------
 * $Author:林维锋
 * $Dtime:2013-10-26
 ***********************************************************************************/
require_once dirname(__FILE__) . '/../../superphp/core/dao/sdao.php';
class sessionSelf {
	private static $_instance;     //保存对象的静态属性
	private $SESS_LIFE = 0;
	private function __construct(){ //私有化构造函数
		session_module_name('user');
		$this->SESS_LIFE = get_cfg_var("session.gc_maxlifetime");
		session_set_save_handler(
				array(&$this, 'session_open'),
				array(&$this, 'session_close'),
				array(&$this, 'session_read'),
				array(&$this, 'session_write'),
				array(&$this, 'session_destroy'),
				array(&$this, 'session_gc')
		);
		session_start();
	}

	private function __clone(){ //禁止克隆
	}

	public static function getInstance(){
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 *
	 * session打开
	 * @param $session_path
	 * @param $session_name
	 */
	public function session_open($session_path, $session_name)
	{
		return true;
	}
	/**
	 *
	 * session关闭
	 */
	public function session_close()
	{
		return true;
	}
	/**
	 *
	 * session读取
	 * @param $SID
	 */
	public function session_read($sID)
	{
		$getData =$this->_GetDao()->sessionRead($sID);
		return $getData;
	}
	/**
	 *
	 * session写入
	 * @param $SID
	 * @param $value
	 */
	public function session_write($sID, $value)
	{
		$this->_GetDao()->sessionWrite($sID, $value);
	}
	/**
	 *
	 * session销毁
	 * @param $SID
	 */
	public function session_destroy($sID)
	{
		$this->_GetDao()->sessionDestroy($sID);
	}
	/**
	 *
	 * session gc回收
	 */
	public function session_gc()
	{
		$this->_GetDao()->sessionGc();
	}
	/**
	 *
	 * 获取session数据操作类
	 */
	private function _GetDao(){
		return SuperPHP::getDao("session");
	}
}