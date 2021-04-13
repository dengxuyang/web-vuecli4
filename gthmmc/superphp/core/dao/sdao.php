<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 数据操作类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2013-9-13
 ***********************************************************************************/
require_once(SUPERTPHP_PATH . "/initphp/initphp.php");
require_once(SUPERTPHP_PATH . "/common/extension.php");

class SDao extends Dao{
	private $extensionClass;

	function __construct() {
		parent::__construct();
		$this->extensionClass = new Extension();
	}

	public function getDao(){
		return $this->dao;
	}
	/**
	 * SQL操作-获取全部数据(nopage)
	 * DAO中使用方法：$this->dao->db->get_all()
	 * @param string $table_name 表名
	 * @param array  $field 条件语句
	 * @param int    $num 分页参数
	 * @param int    $offest 获取总条数
	 * @param int    $key_id KEY值
	 * @param string $sort 排序键
	 * @return array array(数组数据，统计数)
	 */
	public function get_all_nopage($table_name, $field = array()) {
		$where = $this->build_all_where($field);
		$sql = sprintf("SELECT * FROM %s %s", $table_name, $where);
		$temp = $this->dao->db->get_all_sql($sql);

		return $temp;
	}
	/**
	 * SQL操作-获取全部数据
	 * DAO中使用方法：$this->dao->db->get_all()
	 * @param string $table_name 表名
	 * @param array  $field 条件语句
	 * @param int    $num 分页参数
	 * @param int    $offest 获取总条数
	 * @param int    $key_id KEY值
	 * @param string $sort 排序键
	 * @return array array(数组数据，统计数)
	 */
	public function get_all($table_name, $num = 20, $offest = 0, $field = array(), $id_key = 'id', $sort = 'DESC', $showKey = "*") {
		$where = $this->build_all_where($field);
		$limit = $this->dao->db->build_limit($offest, $num);
		$tableArr = explode(",", $table_name);
		if (count($tableArr) == 1){
		   $sql = sprintf("SELECT %s FROM %s %s ORDER BY %s %s %s", $showKey, $table_name, $where, $id_key, $sort, $limit);
		}else if (count($tableArr) > 1){
			$index = 0;
			foreach ($tableArr as $table){
				if ($index == 0){
					$sql = sprintf("SELECT %s FROM %s %s", $showKey, $table, $where);
				}else{
					$sql .= sprintf(" union all SELECT %s FROM %s %s ", $showKey, $table, $where);
				}
				$index++;
			}
			$sql =  "select * from (" . $sql . sprintf(") as A ORDER BY %s %s %s", $id_key, $sort, $limit);
		}
		$temp = $this->dao->db->get_all_sql($sql);
		if (count($tableArr) == 1){
		    $sql = sprintf("SELECT COUNT(*) as count FROM %s %s LIMIT 1", $table_name, $where);
		}else if (count($tableArr) > 1){
			$index = 0;
			foreach ($tableArr as $table){
				if ($index == 0){
					$sql = sprintf("SELECT %s FROM %s %s", $showKey, $table, $where);
				}else{
					$sql .= sprintf(" union all SELECT %s FROM %s %s ", $showKey, $table, $where);
				}
				$index++;
			}
			$sql =  "select COUNT(*) as count from (" . $sql . ") as A LIMIT 1";
		}
		$result = $this->dao->db->get_all_sql($sql);
		return array($temp, $result[0]["count"]);
		/*
		$where = $this->build_all_where($field);
		$limit = $this->dao->db->build_limit($offest, $num);
		$sql = sprintf("SELECT %s FROM %s %s ORDER BY %s %s %s", $showKey, $table_name, $where, $id_key, $sort, $limit);
		$temp = $this->dao->db->get_all_sql($sql);
		$sql = sprintf("SELECT COUNT(*) as count FROM %s %s LIMIT 1", $table_name, $where);
		$result = $this->dao->db->get_all_sql($sql);
		return array($temp, $result[0]["count"]);
		*/
	}
	/**
	 * SQL组装-根据指定符号组装的WHERE语句
	 * $val格式：array("key"=>array("value"=>"like",...),...)
	 * 返回：WHERE a e 'a' AND b = 'b'
	 * @return string
	 */
	public function build_all_where($val) {
		if (!is_array($val) || empty($val)) return '';

		$temp = array();
		foreach ($val as $k => $v) {
			$temp[] = $this->build_all_kv($k, $v);
		}
		return ' WHERE ' . implode(' AND ', $temp);
	}
	/**
	 * SQL组装-组装KEY =/like VALUE形式
	 * 返回：a = 'a'或a like 'a'等
	 * @return string
	 */
	public function build_all_kv($k, $v) {
		$result = "";
		foreach ($v as $key=>$value) {
			$connect = "=";
			if (!empty($value)){
				$connect = $value;
			}
			$queryValue = $key;
			if ($connect == 'like'){
				$queryValue = '%' . $queryValue . '%';
				$temp[] = $this->dao->db->build_escape($k, 1) . ' ' . $connect . ' ' .  $this->dao->db->build_escape($queryValue);
			}else if ($connect == 'in' || $connect == 'not in'){
				$queryValue = '(' . $queryValue . ')';
				$temp[] = $this->dao->db->build_escape($k, 1) . ' ' . $connect . ' ' .  $queryValue;
			}else{
				$temp[] = $this->dao->db->build_escape($k, 1) . ' ' . $connect . ' ' .  $this->dao->db->build_escape($queryValue);
			}
			
		}
		$result = implode(' OR ', $temp);
		
		if (count($temp) > 1){
			$result = "("  . $result . ")";
		}
		
		return $result;
	}
	/**
	 * SQL组装-组装AND符号的WHERE语句(无where字符)
	 * 返回：WHERE a = 'a' AND b = 'b'
	 * DAO中使用方法：$this->dao->db->build_where($val)
	 * @param array $val array('key' => 'val')
	 * @return string
	 */
	public function build_arr($val) {
		if (!is_array($val) || empty($val)) return '';
		$temp = array();
		foreach ($val as $k => $v) {
			$temp[] = $this->dao->db->build_kv($k, $v);
		}
		return implode(' AND ', $temp);
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