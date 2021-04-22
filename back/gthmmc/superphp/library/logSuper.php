<?php
/*********************************************************************************
 * 日志类
 *-------------------------------------------------------------------------------
 * 版权所有: runca
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2016-09-01
 ***********************************************************************************/
class logSuper  {
	private $log;
	public function __construct(){
		$this->init();
	}
	public function init(){
		$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
		$this->log = new Log($logHandler, 15);
	}
	/**
	 *
	 * 保存debug日志
	 * @param unknown_type $msg 内容
	 */
	public function DEBUG($msg){
		$this->log->DEBUG($msg);
	}
	/**
	 *
	 * 保存warn日志
	 * @param unknown_type $msg 内容
	 */
	public function WARN($msg){
		$this->log->WARN($msg);
	}
	/**
	 *
	 * 保存error日志
	 * @param unknown_type $msg 内容
	 */
	public function ERROR($msg){
		$this->log->ERROR($msg);
	}
	/**
	 *
	 * 保存info日志
	 * @param unknown_type $msg 内容
	 */
	public function INFO($msg){
		$this->log->INFO($msg);
	}
}

//以下为日志

interface ILogHandler{
	public function write($msg);

}

class CLogFileHandler implements ILogHandler
{
	private $handle = null;

	public function __construct($file = ''){
		$this->handle = fopen($file,'a');
	}

	public function write($msg){
		fwrite($this->handle, $msg);
	}

	public function __destruct(){
		fclose($this->handle);
	}
}

class Log{
	private $handler = null;
	private $level = 15;

	public function __construct($handler = null,$level = 15){
		$this->handler = $handler;
		$this->level = $level;
	}

	public function Init($handler = null,$level = 15){
		$this->handler = $handler;
		$this->level = $level;
	}

	public function DEBUG($msg){
		$this->write(1, $msg);
	}

	public function WARN($msg){
		$this->write(4, $msg);
	}

	public function ERROR($msg){
		$debugInfo = debug_backtrace();
		$stack = "[";
		foreach($debugInfo as $key => $val){
			if(array_key_exists("file", $val)){
				$stack .= ",file:" . $val["file"];
			}
			if(array_key_exists("line", $val)){
				$stack .= ",line:" . $val["line"];
			}
			if(array_key_exists("function", $val)){
				$stack .= ",function:" . $val["function"];
			}
		}
		$stack .= "]";
		$this->write(8, $stack . $msg);
	}

	public function INFO($msg){
		$this->write(2, $msg);
	}

	private function getLevelStr($level){
		switch ($level)
		{
			case 1:
				return 'debug';
				break;
			case 2:
				return 'info';
				break;
			case 4:
				return 'warn';
				break;
			case 8:
				return 'error';
				break;
			default:
		}
	}

	protected function write($level,$msg){
		if(($level & $this->level) == $level )
		{
			$msg = '['.date('Y-m-d H:i:s').']['.$this->getLevelStr($level).'] '.$msg."\n";
			$this->handler->write($msg);
		}
	}
}
