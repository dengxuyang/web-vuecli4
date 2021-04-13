<?php
require_once dirname(__FILE__) . '/mouldEngine.php';

class TContents extends TMouldEngine {
	public function queryDataForPage($field = array(), $num = 99999999, $offest = 0, $sork_key = 'row_id', $sort = 'DESC'){
		return $this->_GetDao()->queryDataForPage($field, $num, $offest, $sork_key, $sort);
	}
	public function queryData($arr){
		return $this->_GetDao()->queryData($arr);
	}
	public function addData($arr){
		return $this->_GetDao()->addData($arr);
	}
	public function modifyData($arr){
		return $this->_GetDao()->modifyData($arr);
	}
	public function deleteData($arr){
		$this->_GetDao()->deleteData($dataId);
	}
	public function updateByField($data, $field){
	 	$this->_GetDao()->updateByField($data, $field);
	}
	/**
	 * 
	 * 获取ContentDao数据操作类
	 */
	private function _GetDao(){
		return SuperPHP::getDao("content", "wyb");
	}
}