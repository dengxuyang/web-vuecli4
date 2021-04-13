<?php
require_once dirname(__FILE__) . '/../tagCompile/tagRealizeAdapterForWyb.php';
require_once dirname(__FILE__) . '/createSite.php';

class createSiteForWyb extends createSite{
	function __construct() {
		$this->tagRealizeAdapter = new TTagRealizeAdapterForWyb();
		$this->moduleName = "wyb";
		$this->createTwoDir = "wybSite";
		$this->siteTemplateDir = "wybTemplate";
		parent::__construct();
	}
}