<?php

require_once dirname(__FILE__) . '/../tagCompile/tagRealizeAdapterForTomms.php';
require_once dirname(__FILE__) . '/createSite.php';

class createSiteForTomms extends createSite{
	function __construct($siteAlias="") {
		parent::__construct();
		$this->tagRealizeAdapter = new TTagRealizeAdapterForTomms($siteAlias);
		$this->moduleName = "tomms";
	}
}