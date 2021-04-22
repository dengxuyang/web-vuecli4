<?php
class stringSuper {
	/**
	 *
	 * 截取中文字符串
	 * @param $str 需要截断的字符串
	 * @param $start 开始截断的位置
	 * @param $len 允许字符串显示的最大长度
	 */
	function mysubstr($str, $start, $len) {
		$tmpstr = "";
		$strlen = $start + $len;
		for($i = 0; $i < $strlen; $i++){
			if(ord(substr($str, $i, 1)) > 0xa0) {
				$tmpstr .= substr($str, $i, 2);
				$i++;
			} else{
				$tmpstr .= substr($str, $i, 1);
			}
		}
		return $tmpstr;
	}
	/**
	 *
	 * 截取utf8字符串
	 * @param $str 需要截断的字符串
	 * @param $from 开始截断的位置
	 * @param $len 允许字符串显示的最大长度
	 */
	function utf8Substr($str, $from, $len){
		$tmpstr = $str;
		if (mb_strlen($str, 'UTF8') > $len){
			$tmpstr = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
						   '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
						   '$1',$str) . "...";
		}
		return $tmpstr;
	}
}