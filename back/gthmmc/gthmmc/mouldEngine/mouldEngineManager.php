<?php
require_once dirname(__FILE__) . '/mouldEngine.php';
require_once dirname(__FILE__) . '/moulds.php';
require_once dirname(__FILE__) . '/tags.php';
require_once dirname(__FILE__) . '/templates.php';
require_once dirname(__FILE__) . '/contents.php';

class TMouldEngineManager {
	public static function getMouldClass(){
		return new TMoulds();
	}
	public static function getContentClass(){
		return new TContents();
	}
	public static function getTagClass(){
		return new TTags();
	}
	public static function getTemplateClass(){
		return new TTemplates();
	}
	public static function getTagRuleClass(){
		return new TTagRules();
	}
}