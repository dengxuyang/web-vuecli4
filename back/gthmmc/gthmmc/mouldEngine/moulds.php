<?php
require_once dirname(__FILE__) . '/mouldEngine.php';

class TMoulds extends TMouldEngine{
	public function queryData($arr){
		return $this->_GetDao()->queryData($arr);
	}
	public function addData($arr){
		return $this->_GetDao()->addData($arr);
	}
	public function modifyData($arr){
		$this->_GetDao()->modifyData($arr);
	}
	public function deleteData($arr){
		$this->_GetDao()->deleteData($arr);
	}
	/**
	 * 
	 * 获取ModuldDao数据操作类
	 */
	private function _GetDao(){
		return SuperPHP::getDao("mould", "wyb");
	}
}