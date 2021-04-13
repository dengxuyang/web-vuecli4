<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 模板驱动类,super框架中的默认驱动
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *------------------------------------------------------------------------------- 
 * $Author:linwf
 * $Dtime:2013-9-13
***********************************************************************************/

class SDefaultSuper{
	public function compile($str, $left, $right) {
		$strC = $str;
		$leftStr = preg_quote($left);
		$rightStr = preg_quote($right);
		//模板包括
		$strC = preg_replace("/".$leftStr."include\s+(.*)".$rightStr."/","<? include(\\1); ?>",$strC);
		//输出变量
		$strC = preg_replace( "/".$leftStr."(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\"\']*)".$rightStr."/", "<?=\\1;?>", $strC );
	    //if操作
	 	$strC = preg_replace( "/".$leftStr."if([^{]+?)".$rightStr."/", "<? if \\1 { ?>", $strC );
		$strC = preg_replace( "/".$leftStr."else".$rightStr."/", "<? } else { ?>", $strC );
		$strC = preg_replace( "/".$leftStr."else if([^{]+?)".$rightStr."/", "<? } else if \\1 { ?>", $strC );
		$strC = preg_replace( "/".$leftStr."\/if".$rightStr."/", "<? } ?>", $strC );
	    //for操作
	 	$strC = preg_replace( "/".$leftStr."for([^{]+?)".$rightStr."/", "<? for \\1 { ?>", $strC );
		$strC = preg_replace( "/".$leftStr."\/for".$rightStr."/", "<? } ?>", $strC );
		$strC = preg_replace( "/".$leftStr."\s*continue\s*".$rightStr."/", "<? continue; ?>", $strC );
		//foreach操作
		$strC = preg_replace("/".$leftStr."loop\s+(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)\s+(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)".$rightStr."/","<?if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$strC);
		$strC = preg_replace("/".$leftStr."loop\s+(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)\s+(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)\s+(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)".$rightStr."/", "<?if(is_array(\\1)) foreach(\\1 AS \\2=>\\3) { ?>",$strC);
		$strC = preg_replace("/".$leftStr."\/loop".$rightStr."/","<? } ?>",$strC);
	    //switch操作
	 	$strC = preg_replace( "/".$leftStr."switch([^{]+?)".$rightStr."/", "<? switch \\1 { ?>", $strC );
		$strC = preg_replace( "/".$leftStr."(case.*)".$rightStr."/", "<? \\1: ?>", $strC );
		$strC = preg_replace( "/".$leftStr."(break)".$rightStr."/", "<? \\1; ?>", $strC );
		$strC = preg_replace( "/".$leftStr."(default.*)".$rightStr."/", "<? \\1 ?>", $strC );
		$strC = preg_replace( "/".$leftStr."\/switch".$rightStr."/", "<? } ?>", $strC );
		//常量输出
		$strC = preg_replace( "/".$leftStr."\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*".$rightStr."/", "<?=\\1;?>", $strC );
		//模板语法标签解析
	 	$pattern = array('/'.$leftStr.'/', '/'.$rightStr.'/');
		$replacement = array('<? ', '; ?>');
		return preg_replace($pattern, $replacement, $strC);
	}
}