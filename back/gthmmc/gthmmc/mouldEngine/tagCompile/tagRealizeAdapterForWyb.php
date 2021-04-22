<?php
require_once dirname(__FILE__) . '/tagRealizeAdapter.php';

class TTagRealizeAdapterForWyb extends TTagRealizeAdapter{
	function __construct() {
		parent::__construct();
		$this->contentTable = "wyb_content";
		$this->moduleName = "wyb";
	}
}
