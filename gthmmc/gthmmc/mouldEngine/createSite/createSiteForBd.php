<?php

require_once dirname(__FILE__) . '/../tagCompile/tagRealizeAdapterForBd.php';
require_once dirname(__FILE__) . '/createSiteNew.php';

class createSiteForBd extends createSiteNew{
	function __construct($siteAlias="") {
		parent::__construct();
		$this->tagRealizeAdapter = new TTagRealizeAdapterForBd($siteAlias);
		$this->moduleName = "tomms";
	}
}