<?php
/*********************************************************************************
 * 过滤敏感词类
 *-------------------------------------------------------------------------------
 * 版权所有: runca
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2015-11-24
 ***********************************************************************************/
require_once dirname(__FILE__) . '/cacheSuper.php';

class filterSuper{
	private $filterWord;
	function __construct() {
		$wordCache = new cacheSuper();
		//敏感词缓存是否存在
		if ($wordCache->has('filterWord')){
			$this->filterWord = $wordCache->get('filterWord');
		}else{
			//读取敏感词库
			$srcData = file_get_contents('./data/sensitive.txt');
			$srcArr = json_decode($srcData, true);
			$fromArr = array();
			$toArr = array();
			foreach ($srcArr as $value){
				array_push($fromArr, $value['from']);
				array_push($toArr, $value['to']);
			}
			$this->filterWord = array_combine($fromArr, $toArr);
			$wordCache->set('filterWord', $this->filterWord, 3600000);
		}
	}
	/**
	 * 
	 * 过滤敏感词
	 * @param 处理后的字符串
	 */
	public function filterContent($content){
		return strtr($content, $this->filterWord);
	}
}