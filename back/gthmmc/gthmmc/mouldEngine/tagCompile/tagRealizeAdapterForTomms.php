<?php
require_once dirname(__FILE__) . '/tagRealizeAdapter.php';

class TTagRealizeAdapterForTomms extends TTagRealizeAdapter{
	function __construct($siteAlias = "") {
		parent::__construct();
		$this->contentTable = "t_content";
		//$getSession = $this->getUtil("session");
		$this->siteAlias = $siteAlias;// $getSession->get("siteAlias");
		$this->moduleName = "tomms";
	}
}
