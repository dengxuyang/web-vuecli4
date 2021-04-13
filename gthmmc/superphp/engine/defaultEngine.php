<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 模板实现类，默认
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2013-9-13
 ***********************************************************************************/

require_once("templateEngine.php");

class SDefaultEngine extends STemplateEngine{
	/*
	function compileToHTML($template){
		$compileStr = "";
		if (!file_exists($template)){
			$emplateStr = @file_get_contents($template);
		}
		//标签解析
		if ($this->_tagAnalyze){
			$compileStr = $this->_tagAnalyze->compile($compileStr);
		}
		//模板语法解析
		$compileStr  = $this->_engineDriver->compile($compileStr);
		//生成HTML
		//TODO
		return $compileStr;
	}
	*/
}