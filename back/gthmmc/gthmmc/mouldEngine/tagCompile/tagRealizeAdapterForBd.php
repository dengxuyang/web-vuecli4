<?php
require_once dirname(__FILE__) . '/tagRealizeAdapter_bd.php';

class TTagRealizeAdapterForBd extends TTagRealizeAdapter{
	function __construct($siteAlias = "") {
		parent::__construct();
		$this->contentTable = "t_content";
		//$getSession = $this->getUtil("session");
		$this->siteAlias = $siteAlias;// $getSession->get("siteAlias");
		$this->moduleName = "tomms";
	}
}
