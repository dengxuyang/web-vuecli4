<?php
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
require_once dirname(__FILE__) . '/../../../superphp/core/dao/sdao.php';
require_once dirname(__FILE__) . '/../../common/createHtmlLog.php';
error_reporting(E_ALL ^ E_NOTICE);
/*
 require_once dirname(__FILE__) . '/../mouldEngineManager.php';
 require_once dirname(__FILE__) . '/../tagCompile/tagRealizeAdapterForWyb.php';
 */
class createSiteNew extends SController{
	//private $listFilePre = 'list';     //列表页文件名前缀
	//private $detailFilePre = 'detail'; //详情页文件名前缀
	public $tagRealizeAdapter = "";   //标签实现类
	public $moduleName = "";          //产品名称
	public $siteTemplateDir = "";     //站点模板统一存放目录(用于微信宝产品)
	public $createTwoDir = "";        //站点存放二级目录
	private $relativePath = "";       //与主目录偏移路径
	private $createHtmlLog;
	function __construct() {
		parent::__construct();
		$this->createHtmlLog = new createHtmlLog();
		$this->relativePath = (empty($this->siteTemplateDir)?"../../../":"../../../../");
	}
	/**
	 *
	 * 全站生成
	 * @param unknown_type $siteId
	 */
	public function createAll($siteId){

	}
	
	/**
	 *
	 * 生成数据详情页
	 * @param unknown_type $siteId
	 */
 
	public function createDetail($siteId, $siteAlias,$account,$style,$columnAlias,$value,$destination_id){
		
		$_SESSION['siteId']=$siteId;
		$this->relativePath='../../../../../';
		//获取模板id
		$contentClass = $this->_GetContentDao();// TMouldEngineManager::getContentClass();
		$getCData = $contentClass->queryData(array( "column_alias"=>$columnAlias, "site_id"=>$siteId));
		$columnId = $getCData[0][0]["row_id"];
		$templateId = $getCData[0][0]["template_detail_id"];
		$columnAlias = $getCData[0][0]["column_alias"];
		//获取模板存在目录
		$templateClass = $this->_GetTemplateDao();// TMouldEngineManager::getTemplateClass();
		$getTData = $templateClass->queryData(array("row_id"=>$templateId));
		
		$config = SuperPHP::getConfig();
		$getArr = array_filter($getTData);
		if(!empty($getArr)){
 
			$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) ."/" . $style."/" . $getTData[0][0]["template_file"];//$config['siteTemplate'] . $getTData[0][0]["template_file"];
			//模板模块先编译
			$this->createIncludePage($config['template']['template_path'] . "/" .$templateFile, $siteAlias, $siteId,$style);
			//模板编译
			//$this->templateEngine->assign("htmlFilePre", $config["listFilePre"]);//$this->listFilePre);
			//$this->templateEngine->assign("themePath", "../../" . $config['adminName'] . "/" . $config['template']['template_path'] . "/" . dirname($templateFile));
			$this->templateEngine->assign("dataId", $value["row_id"]);
			$this->templateEngine->assign("dataArr", $value);
			
			$this->templateEngine->assign("mudidi", $destination_id);
			$this->templateEngine->assign("project_name", $account);
			$this->templateEngine->assign("web_type", $siteAlias);
			
			$this->templateEngine->assign("themePath", "../..");
			$this->templateEngine->assign("commonThemePath", $this->relativePath . "uiLibrary");       //共用主题地址，包括js及对应 的css
			$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
			$this->templateEngine->assign("siteId", $siteId);                   //站点ID
			$this->templateEngine->assign("relativeIndexPath", "");      //相对于主页路径
			$this->templateEngine->assign("adminPath", $this->relativePath . $config['siteName'] . "/");  //相对于站点管理路径
			$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
			$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
			$getSeo = $this->getSeoData($siteId, 0);
			$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
			$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
			$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
			$getSeo = $this->getSeoData($siteId, $columnId);
			$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
			$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
			$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
			$getSite = $this->getSiteData($siteId);
			$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
			$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
		
			$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
			$str = $this->templateEngine->compile($templateFile);
			//生成站点首页文件
			$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account;
			if(array_key_exists('publish_date', $value)&&!empty($value["publish_date"]) ){
				$publish_date=date("Y-m-d", strtotime($value["publish_date"]));
			}else{
				$publish_date=date("Y-m-d", strtotime($value["create_time"]));
			}
	
			$pathStr=$pathStr."/".$columnAlias."Detail/".$publish_date."/";

			try{
				$this->createFile($str, $pathStr, "detail".$value["row_id"] . ".html");
				$this->createHtmlLog->pushLog($columnAlias.$value["row_id"] ."详情页->生成成功");
			}catch  (Exception $e) {
				$this->createHtmlLog->pushLog($e->getMessage());
			}
		}
		return false;
		
		
		
	}
	
	/**
	 *
	 * 生成首页
	 * @param unknown_type $siteId
	 */
	public function createHomePage($siteId, $siteAlias,$account,$style,$destination_id){

		/*
		 //获取session帐户 信息
		 $getSession = $this->getUtil("session");
		 $accountData = $getSession->get("accountData");
		 $siteId = $accountData["siteId"];
		 $siteAlias = $accountData["site_name_en"];
		 */
		//获取站点数据
		$_SESSION['siteId']=$siteId;
		//获取首页模板id
		$contentClass = $this->_GetContentDao();// TMouldEngineManager::getContentClass();
		$getCData = $contentClass->queryData(array("mould_id"=>"0", "column_type"=>"1", "site_id"=>$siteId));
		$columnId = $getCData[0][0]["row_id"];
		$templateId = $getCData[0][0]["template_id"];
		$columnAlias = $getCData[0][0]["column_alias"];
		//获取模板存在目录
		$templateClass = $this->_GetTemplateDao();// TMouldEngineManager::getTemplateClass();
		$getTData = $templateClass->queryData(array("row_id"=>$templateId));

		$config = SuperPHP::getConfig();
		$getArr = array_filter($getTData);
		if(!empty($getArr)){
			$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) ."/" . $style."/" . $getTData[0][0]["template_file"];//$config['siteTemplate'] . $getTData[0][0]["template_file"];
			//模板模块先编译
			$this->createIncludePage($config['template']['template_path'] . "/" .$templateFile, $siteAlias, $siteId,$style);
			//模板编译
			//$this->templateEngine->assign("htmlFilePre", $config["listFilePre"]);//$this->listFilePre);
			//$this->templateEngine->assign("themePath", "../../" . $config['adminName'] . "/" . $config['template']['template_path'] . "/" . dirname($templateFile));
			$this->templateEngine->assign("style", $style);
            $this->templateEngine->assign("mudidi", $destination_id);
            $this->templateEngine->assign("destination_id", $destination_id);
			$this->templateEngine->assign("project_name", $account);
			$this->templateEngine->assign("web_type", $siteAlias);
			$this->templateEngine->assign("themePath", ".");
			$this->templateEngine->assign("commonThemePath", $this->relativePath . "uiLibrary");       //共用主题地址，包括js及对应 的css
			$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
			$this->templateEngine->assign("siteId", $siteId);                   //站点ID
			$this->templateEngine->assign("relativeIndexPath", "");      //相对于主页路径
			$this->templateEngine->assign("adminPath", $this->relativePath . $config['siteName'] . "/");  //相对于站点管理路径
			$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
			$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
			$getSeo = $this->getSeoData($siteId, 0);
			$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
			$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
			$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
			$getSeo = $this->getSeoData($siteId, $columnId);
			$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
			$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
			$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
			$getSite = $this->getSiteData($siteId);
			$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
			$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码

			$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
			$str = $this->templateEngine->compile($templateFile);
			//生成站点首页文件
			$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account;

			if ($this->createFile($str, $pathStr, $columnAlias . ".shtml")){
				//拷贝皮肤文件
				$this->copyThemeToSite(dirname($config['template']['template_path'] . "/" . $templateFile), $pathStr);
				$this->createPluginFile($siteId, $siteAlias,$account);
				$this->createHtmlLog->pushLog("“首页”->生成成功");

				/*				flush();
				 ob_flush();
				 ob_end_clean();
				 sleep(rand(0, 1));*/
				return true;
			}
		}
		return false;
	}
	
	
	
	/**
	 *
	 * 生成首页   信息发布系统
	 * @param unknown_type $siteId
	 */
	public function createHomePage_idms($siteId, $siteAlias,$template_path,$template_file,$columnName){
		$this->relativePath='../../';
		$_SESSION['siteId']=$siteId;
		$columnAlias ='index';
		$config = SuperPHP::getConfig();
		if(!empty($siteId)){
			$templateFile =$template_path. $template_file;//$config['siteTemplate'] . $getTData[0][0]["template_file"];
			//模板编
			$this->templateEngine->assign("themePath", ".");
			$this->templateEngine->assign("commonThemePath", $this->relativePath . "uiLibrary");       //共用主题地址，包括js及对应 的css
			$this->templateEngine->assign("columnName", $columnName);
			$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
			$this->templateEngine->assign("siteId", $siteId);                   //站点ID
			$this->templateEngine->assign("relativeIndexPath", "");      //相对于主页路径
			$this->templateEngine->assign("adminPath", $this->relativePath . $config['siteName'] . "/");  //相对于站点管理路径
			$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
			$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
 
			$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
			$str = $this->templateEngine->compile($templateFile);
			//生成站点首页文件
			$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias;
			if ($this->createFile($str, $pathStr, $columnAlias . ".shtml")){
				$fileIn= explode('.',$template_file); 		 			 
				//拷贝皮肤文件
				$this->copyThemeToSite($config['template']['template_path'] . "/" . $template_path.$fileIn[0], $pathStr);

				$this->createPluginFile($siteId, $siteAlias);
				$this->createHtmlLog->pushLog("“首页”->生成成功");

				return true;
			}
		}
		return false;
	}
	/**
	 *
	 * 生成栏目页
	 */
	public function createColumnPage($siteId, $siteAlias,$account,$style,$destination_id){
		/*
		 //获取session帐户 信息
		 $getSession = $this->getUtil("session");
		 $accountData = $getSession->get("accountData");
		 $siteId = $accountData["siteId"];
		 $siteAlias = $accountData["site_name_en"];
		 */
		$config = SuperPHP::getConfig();
		$this->createColumnPageOp(0, "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account, $siteId, $siteAlias, "",$account,$style,$destination_id);
	}
	/**
	 *
	 * 生成栏目页
	 */
	public function createColumnPageOp($parentId, $pathStr, $siteId, $siteAlias, $rPath,$account,$style,$destination_id){
		//获取栏目模板id
		$config = SuperPHP::getConfig();
		$contentClass = $this->_GetContentDao();// TMouldEngineManager::getContentClass();
		$getCData = $contentClass->queryData(array("parent_id"=>$parentId, "site_id"=>$siteId));
		$_SESSION['siteId']=$siteId;
		foreach ($getCData[0] as $value){
			$columnId = $value["row_id"];
			$columnName = $value["column_name"];
			$templateId = $value["template_id"];
			$columnAlias = $value["column_alias"];
			$pageNum = $value["pageNum"];
			$this->createColumnPageOp($columnId, $pathStr . "/" . $columnAlias, $siteId, $siteAlias, (empty($rPath)?".." : "../" . $rPath));   //嵌套调用

			if ($templateId > 0 && $columnAlias != "index"){

				//获取模板存在目录
				$templateClass = $this->_GetTemplateDao();
				$getTData = $templateClass->queryData(array("row_id"=>$templateId));
				$getArr = array_filter($getTData);

				if(!empty($getArr)){
					//获取栏目导航
					$parentColumnArr = array();
					$this->getParentColumn($siteId, $parentId, $parentColumnArr);

					$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) . "/" . $style. "/" . $getTData[0][0]["template_file"];
					//$templateFile = "siteTemplate/" . $siteAlias . "/" . $getTData[0][0]["template_file"];//$config['siteTemplate'] . $getTData[0][0]["template_file"];
					//模板模块先编译
					$this->createIncludePage($config['template']['template_path'] . "/" . $templateFile, $siteAlias, $siteId,$style);

					//模板编译
					$this->templateEngine->assign("style", $style);
                    $this->templateEngine->assign("mudidi", $destination_id);
			        $this->templateEngine->assign("project_name", $account);
			        $this->templateEngine->assign("web_type", $siteAlias);
					$this->templateEngine->assign("columnId", $columnId);                       //栏目ID
					$this->templateEngine->assign("columnName", $columnName);                   //栏目名
					$this->templateEngine->assign("columnAlias", $columnAlias);                 //栏目别名
					$this->templateEngine->assign("pageNum", $pageNum);                         //每页显示条数
					$this->templateEngine->assign("siteId", $siteId);                           //站点ID
					$this->templateEngine->assign("parentColumnId", $parentId);                    //父栏目ID
					$this->templateEngine->assign("parentColumn", $parentColumnArr);            //所在栏目的上级栏目
					//$this->templateEngine->assign("themePath",$rPath . "../../" . $config['adminName'] . "/" . $config['template']['template_path'] . "/siteTemplate/" . $siteAlias);//站点主题地址
					$rPathTmp = (empty($rPath)?".":$rPath);
					$this->templateEngine->assign("themePath",$rPathTmp);//站点主题地址
					$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
					$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                   //相对于主页路径
					$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");          //相对于主页路径
					$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
					$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
					$getSeo = $this->getSeoData($siteId, 0);
					$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSeo = $this->getSeoData($siteId, $columnId);
					$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSite = $this->getSiteData($siteId);
					$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
					$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
					$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
					try{
						$str = $this->templateEngine->compile($templateFile);
						$this->createFile($str, $pathStr, $columnAlias . ".html");

						$this->createHtmlLog->pushLog("“" . $columnName . "”->栏目页生成成功");
					}catch  (Exception $e) {
						$this->createHtmlLog->pushLog($e->getMessage());
					}
				}
			}
		}
	}
	/**
	 *
	 * 生成栏目页(根据指定的栏目)
	 */
	public function createColumnPageForColumnId($siteId, $siteAlias,$columnId){

 	    $config = SuperPHP::getConfig();
 		
		if(empty($columnId)){
			$this->createColumnPageOp(0, "../" . $config['siteName']. "/" . $siteAlias, $siteId, $siteAlias, "");
	    }else{
            $this->createColumnPageOpForColumnId($columnId, "../" . $config['siteName']. "/" . $siteAlias, $siteId, $siteAlias, "");	    
	    }
	}	
	/**
	 *
	 * 生成栏目页(根据指定的栏目)
	 */
	public function createColumnPageOpForColumnId($columnId, $pathStr, $siteId, $siteAlias, $rPath){
		//获取栏目模板id
		$config = SuperPHP::getConfig();
		$contentClass = $this->_GetContentDao();// TMouldEngineManager::getContentClass();
		//$getCData = $contentClass->queryData(array("parent_id"=>$parentId, "column_type"=>"0", "level"=>$level, "site_id"=>$siteId));
		//$getCData = $contentClass->queryData(array("parent_id"=>$parentId, "column_type"=>"0", "site_id"=>$siteId));
		$getCData = $contentClass->queryData(array("row_id"=>$columnId, "site_id"=>$siteId));
		//foreach ($getCData[0] as $value){
       if ($getCData[1] > 0){
			//$rowId = $getCData[0][0]["row_id"];
			$columnName = $getCData[0][0]["column_name"];
			$columnImage = $getCData[0][0]["column_image"];
			$templateId = $getCData[0][0]["template_id"];
			$columnAlias = $getCData[0][0]["column_alias"];
			$pageNum =$getCData[0][0]["pageNum"]; 
			$parentId =$getCData[0][0]["parent_id"]; 
			//获取栏目导航
			$parentColumnArr = array();
			$this->getParentColumn($siteId, $parentId, $parentColumnArr);	
       		$createPath = "";
			foreach($parentColumnArr as $valueSub){
				$createPath .= $valueSub["column_alias"] . "/";
			}					                  
		    $this->createColumnPageOp($columnId, $pathStr . "/" .$createPath."/". $columnAlias, $siteId, $siteAlias, "../" . $rPath);   //嵌套调用
			
			//$this->createColumnPageOp($columnId, $level + 1, $pathStr . "/" . $columnAlias, $siteId, $siteAlias, "../" . $rPath);
			if ($templateId > 0 && $columnAlias != "index"){
				//获取模板存在目录
				$templateClass = $this->_GetTemplateDao();// TMouldEngineManager::getTemplateClass();
				$getTData = $templateClass->queryData(array("row_id"=>$templateId));
				$getArr = array_filter($getTData);
				if(!empty($getArr)){
					//获取栏目导航
				//	$parentColumnArr = array();
				//	$this->getParentColumn($siteId, $parentId, $parentColumnArr);

					$templateFile = "siteTemplate/" . $siteAlias . "/" . $getTData[0][0]["template_file"];//$config['siteTemplate'] . $getTData[0][0]["template_file"];
					//模板模块先编译
					$this->createIncludePage($config['template']['template_path'] . "/" .$templateFile, $siteAlias, $siteId);
					//模板编译
					$this->templateEngine->assign("columnId", $columnId);                       //栏目ID
					$this->templateEngine->assign("columnName", $columnName);                   //栏目名
					$this->templateEngine->assign("columnAlias", $columnAlias);                 //栏目别名
					$this->templateEngine->assign("columnImage", $columnImage);                 //栏目图片
					$this->templateEngine->assign("parentColumnId", $parentId);                 //栏目Id
					$this->templateEngine->assign("pageNum", $pageNum);                         //每页显示条数
					$this->templateEngine->assign("siteId", $siteId);                           //站点ID
					$this->templateEngine->assign("parentColumn", $parentColumnArr);            //所在栏目的上级栏目
					empty($rPath)?".." : "../" . $rPath;
					$rPathTmp = (empty($rPath)?".":$rPath);
					$this->templateEngine->assign("themePath",$rPathTmp);//站点主题地址
					$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
					/*					
					$this->templateEngine->assign("themePath",
					                              $rPath . "../../" . $config['adminName'] . "/" . $config['template']['template_path'] . "/siteTemplate/" . $siteAlias);//站点主题地址
					//$this->templateEngine->assign("commonThemePath", $rPath . "../../" . $config['adminName'] . "/uiLibrary");//共用主题地址，包括js及对应 的css
					$this->templateEngine->assign("commonThemePath", $rPath . "../../uiLibrary");//共用主题地址，包括js及对应 的css  
					*/
					$this->templateEngine->assign("relativeIndexPath", $rPath);                   //相对于主页路径
					$this->templateEngine->assign("adminPath", $rPath . "../../". $config['adminName'] . "/");          //相对于主页路径
					$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
					$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
					$getSeo = $this->getSeoData($siteId, 0);
					$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSeo = $this->getSeoData($siteId, $columnId);
					$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSite = $this->getSiteData($siteId);
					$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
					$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
					$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
					try{
						$str = $this->templateEngine->compile($templateFile);
						//生成站点首页文件
						//$pathStr = "../" . $config['siteName']. "/" . $siteAlias;
						$this->createFile($str, $pathStr."/".$createPath, $columnAlias . ".html");

						$this->createHtmlLog->pushLog("“" . $columnName . "”->栏目页生成成功");
					}catch  (Exception $e) {
						$this->createHtmlLog->pushLog($e->getMessage());
					}
				}
			}
		}
	}		
	/**
	 *
	 * 生成内容页(全站生成)
	 */
	public function createContentPage($siteId, $siteAlias){
		//获取终级栏目
		$contentObj = $this->_GetContentDao();
		//$getCData = $contentObj->queryData(array("column_type"=>"0", "level"=>0, "site_id"=>$siteId));
		$getCData = $contentObj->queryData(array("level"=>0, "site_id"=>$siteId));
		$getCData = array_filter($getCData);
		if (!empty($getCData)){
			foreach ($getCData[0] as $value){
				$columnId = $value["row_id"];                        //栏目ID
				//生成内容页，包括栏目列表页和详情页
				$this->createListPageOfColumnId($siteId, $columnId, $siteAlias);
				$this->createDetailPageOfColumnId($siteId, $columnId, $siteAlias);

				//测试
				//if ($columnId == 18){
				//	$this->createListPageOfColumnId($siteId, $columnId, $siteAlias);
				//}
			}
		}
	}
	/**
	 *
	 * 生成内容页(根据指定的栏目)
	 */
	public function createContentPageForColumnId($siteId, $siteAlias, $columnId){
		$this->createListPageOfColumnId($siteId, $columnId, $siteAlias);
		$this->createDetailPageOfColumnId($siteId, $columnId, $siteAlias);
	}
	/**
	 *
	 * 生成列表页(根据指定的数据ID)
	 */
	public function createListPage($siteId, $siteAlias, $columnId){
		$this->createListPageOfColumnId($siteId, $columnId, $siteAlias);
	}
	/**
	 *
	 * 生成详情页(根据指定的数据ID)
	 */
	public function createDetailPage($siteId, $siteAlias, $columnId, $dataId){
		//$this->createListPageOfColumnId($siteId, $columnId, $siteAlias);
		return $this->createDetailPageOfColumnId($siteId, $columnId, $siteAlias, $dataId);
	}
	
	
	public function createListPageOfColumnAlias($siteId, $columnAlias, $siteAlias,$account,$style,$destination_id,$data){
		//获取栏目列表页模板id和详情页模板id
		$config = SuperPHP::getConfig();
		$contentObj = $this->_GetContentDao();
		$getCData = $contentObj->queryData(array("column_alias"=>$columnAlias, "site_id"=>$siteId));
		if ($getCData[1] > 0){
			$templateId = $getCData[0][0]["template_list_id"];              //栏目列表页对应的【模板ID】
			$columnName = $getCData[0][0]["column_name"];                   //栏目名称
			$columnAlias = $getCData[0][0]["column_alias"];                 //栏目别名
			$pageNum = $getCData[0][0]["pageNum"];                          //每页显示页数
			$isPage = true;        //静态页是否分页
		}else{
			return;
		}
		$templateObj = $this->_GetTemplateDao();
		$getTData = $templateObj->queryData(array("row_id"=>$templateId));
		$getTData = array_filter($getTData);
		
		$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) . "/" . $style. "/" . $getTData[0][0]["template_file"];
		$this->createIncludePage($config['template']['template_path'] . "/" . $templateFile, $siteAlias, $siteId,$style);
		if ($isPage){      //需要分页
			 //总条数
             $recordCount=count($data);
			$pageCount = ceil($recordCount / $pageNum);  //总条数
 
			if ($pageCount > 0){
				for($i=0;$i<$pageCount;$i++){
					
					
					$start=$i*$pageNum;//偏移量，当前页-1乘以每页显示条数
					$listData = array_slice($data,$start,$pageNum);
	
					$this->templateEngine->assign("listData", $listData);
					$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);

					$this->templateEngine->assign("style", $style);
					$this->templateEngine->assign("mudidi", $destination_id);
					$this->templateEngine->assign("destination_id", $destination_id);
					$this->templateEngine->assign("project_name", $account);
					$this->templateEngine->assign("web_type", $siteAlias);
					$this->templateEngine->assign("themePath", ".");
					$this->templateEngine->assign("commonThemePath", $this->relativePath . "uiLibrary");       //共用主题地址，包括js及对应 的css
					$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
					$this->templateEngine->assign("siteId", $siteId);                   //站点ID
					$this->templateEngine->assign("relativeIndexPath", "");      //相对于主页路径
					$this->templateEngine->assign("adminPath", $this->relativePath . $config['siteName'] . "/");  //相对于站点管理路径			
					
					$this->templateEngine->assign("pageNum", $pageNum);                           //每页显示条数
					$this->templateEngine->assign("recordCount", $recordCount);                   //总记录数
					$this->templateEngine->assign("pageNo", $i + 1);                              //当前页码
					$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
					$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
					$rPathTmp = (empty($rPath)?".":$rPath);
					$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址

					$this->templateEngine->assign("pagePath", $columnAlias . $config["listFilePre"]."%s.html");
					try{
						$str = $this->templateEngine->compile($templateFile);
						$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account;
						//$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") .$siteAlias . "/" . $createPath;
						$this->createFile($str, $pathStr, $columnAlias . $config["listFilePre"] . ($i + 1) . ".html");

						$this->createHtmlLog->pushLog("“" . $columnName . "”->列表页(第" . ($i + 1) . "页)生成成功");
					}catch  (Exception $e) {
						$this->createHtmlLog->pushLog($e->getMessage());
					}
				}
			}else{
				$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
				$this->templateEngine->assign("siteId", $siteId);                           //站点Id
				$this->templateEngine->assign("columnId", $columnId);                         //栏目Id
				$this->templateEngine->assign("columnName", $columnName);                     //栏目名
				$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
				$this->templateEngine->assign("pageNum", $pageNum);                           //每页显示条数
				$this->templateEngine->assign("recordCount", $recordCount);                   //总记录数
				$this->templateEngine->assign("pageNo", 1);                                   //当前页码
				$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
				$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
				$rPathTmp = (empty($rPath)?".":$rPath);
				$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址
				$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                   //相对于主页路径
				$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");          //相对于主页路径
				$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css

				try{
					$str = $this->templateEngine->compile($templateFile);
					//生成列表静态不分页文件
					$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account;
					$this->createFile($str, $pathStr, $columnAlias . $config["listFilePre"] . "1.html");
					$this->createHtmlLog->pushLog("“" . $columnName . "”->列表页(第1页)生成成功");
				}catch  (Exception $e) {
					$this->createHtmlLog->pushLog($e->getMessage());
				}
			}
		}		
		
		
	}
	
	/**
	 *
	 * 生成列表页
	 * @param unknown_type $siteId
	 */
	public function createListPageOfColumnId($siteId, $columnId, $siteAlias){
		//获取栏目列表页模板id和详情页模板id
		$contentObj = $this->_GetContentDao();
		$getCData = $contentObj->queryData(array("row_id"=>$columnId, "site_id"=>$siteId));
		if ($getCData[1] > 0){
			$templateId = $getCData[0][0]["template_list_id"];              //栏目列表页对应的【模板ID】
			$deTailTemplateId = $getCData[0][0]["template_detail_id"];      //栏目详情页对应的【模板ID】
			$mouldId = $getCData[0][0]["mould_id"];                         //栏目对应的【模型ID】
			$columnName = $getCData[0][0]["column_name"];                   //栏目名称
			$columnAlias = $getCData[0][0]["column_alias"];                 //栏目别名
			$pageNum = $getCData[0][0]["pageNum"];                          //每页显示页数
			$isActive = $getCData[0][0]["is_active"] == "1"? true:false;    //是否生成动态页
			$isPage = $getCData[0][0]["is_page"] == "1"? true:false;        //静态页是否分页
			$parentId = $getCData[0][0]["parent_id"];                       //栏目对应的【父栏目ID】
			$targetAlias = $getCData[0][0]["target_alias"];                 //栏目对应的【目标栏目别名】
			//获取父栏目别名
			$getCData = $contentObj->queryData(array("row_id"=>$parentId, "site_id"=>$siteId));
			if ($getCData[1] > 0){
				$columnAliasP = $getCData[0][0]["column_alias"];            //栏目别名
				$columnNameP = $getCData[0][0]["column_name"];              //栏目别名
			}
		}
		//获取栏目导航
		$parentColumnArr = array();
		$this->getParentColumn($siteId, $parentId, $parentColumnArr);
		//获取兄弟栏目导航
		$brotherColumnArr = $this->getBrotherColumn($siteId, $parentId);
		//全局配置
		$config = SuperPHP::getConfig();
		//获取栏目列表页模板对应的模板文件
		$templateObj = $this->_GetTemplateDao();

		$getTData = $templateObj->queryData(array("row_id"=>$templateId));
		$getTData = array_filter($getTData);

		if(!empty($getTData)){
			$rPath = "";
			$this->getRelativeIndexPath($siteId, $columnId, $rPath);


			$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) . "/" . $getTData[0][0]["template_file"];  //模板文件路径
			//模板模块先编译
			$this->createIncludePage($config['template']['template_path'] . "/" . $templateFile, $siteAlias, $siteId);

			$createPath = "";
			foreach($parentColumnArr as $value){
				$createPath .= $value["column_alias"] . "/";
			}

			if($isActive){   //生成动态页
				//获取栏目模型对应的表
				$mouldObj = $this->_GetMouldDao();
				$getMData = $mouldObj->queryData(array("isQuerySub"=>"0", "query_filter"=>array("row_id"=>$mouldId)));
				$getMData = array_filter($getMData);
				if(!empty($getMData)){
					$mouldTable = $getMData[0][0]["mould_table"];  //模型对应的表
				}
				$this->createSiteMVC($mouldTable, $templateFile ,$siteId, $config['siteName'], $siteAlias, $columnId, $columnName, $columnAlias, $parentId, $columnAliasP, $columnNameP,
				$config["listFilePre"], $config["detailFilePre"], $this->relativePath . "/" . $config['adminName'] . "/" . $config['template']['template_path'] . "/siteTemplate/" . $siteAlias,
				$rPath, $this->relativePath . "uiLibrary", $parentColumnArr, $brotherColumnArr, $mouldId);   //生成动态访问的MVC
			}else{           //生成静态页
				if ($isPage){      //需要分页
					//获取栏目模型对应的表
					$mouldObj = $this->_GetMouldDao();
					$getMData = $mouldObj->queryData(array("isQuerySub"=>"0", "query_filter"=>array("row_id"=>$mouldId)));
					$getMData = array_filter($getMData);
					if(!empty($getMData)){
						$mouldTable = $getMData[0][0]["mould_table"];  //模型对应的表
					}
					$dao = new SDao();

					if(empty($targetAlias)){
						$recordCount = $dao->getDao()->db->get_count($mouldTable, array("is_delete"=>0, "column_id"=>$columnId)); //获取记录总数
					}else{
						$recordCount = $dao->getDao()->db->get_count($mouldTable, array("is_delete"=>0, "column_alias"=>$targetAlias)); //获取记录总数
					}
					//$pageCount = floor(($recordCount - 1) / $pageNum) + 1;  //总条数
					$pageCount = ceil($recordCount / $pageNum);  //总条数
					if ($pageCount > 0){
						for($i=0;$i<$pageCount;$i++){
							$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
							$this->templateEngine->assign("siteId", $siteId);                           //站点Id
							$this->templateEngine->assign("columnId", $columnId);                         //栏目Id
							$this->templateEngine->assign("columnName", $columnName);                     //栏目名
							$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
							$this->templateEngine->assign("parentColumnId", $parentId);                   //栏目Id
							$this->templateEngine->assign("parentColumnAlias", $columnAliasP);            //父栏目别名
							$this->templateEngine->assign("parentColumnName", $columnNameP);              //父栏目名称
							$this->templateEngine->assign("pageNum", $pageNum);                           //每页显示条数
							$this->templateEngine->assign("recordCount", $recordCount);                   //总记录数
							$this->templateEngine->assign("pageNo", $i + 1);                              //当前页码
							$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
							$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
							$rPathTmp = (empty($rPath)?".":$rPath);
							$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址
							$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                   //相对于主页路径
							$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");          //相对于主页路径
							$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
							$this->templateEngine->assign("parentColumn", $parentColumnArr);              //所在栏目的上级栏目
							$this->templateEngine->assign("brotherColumn", $brotherColumnArr);            //所在栏目的兄弟栏目
							$getSeo = $this->getSeoData($siteId, 0);
							$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
							$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
							$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
							$getSeo = $this->getSeoData($siteId, $columnId);
							$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
							$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
							$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
							$getSite = $this->getSiteData($siteId);
							$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
							$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
							try{
								$str = $this->templateEngine->compile($templateFile);
								//生成列表静态不分页文件
								$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") .$siteAlias . "/" . $createPath;
								$this->createFile($str, $pathStr, $columnAlias . $config["listFilePre"] . ($i + 1) . ".html");

								$this->createHtmlLog->pushLog("“" . $columnName . "”->列表页(第" . ($i + 1) . "页)生成成功");
							}catch  (Exception $e) {
								$this->createHtmlLog->pushLog($e->getMessage());
							}
						}
					}else{
						$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
						$this->templateEngine->assign("siteId", $siteId);                           //站点Id
						$this->templateEngine->assign("columnId", $columnId);                         //栏目Id
						$this->templateEngine->assign("columnName", $columnName);                     //栏目名
						$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
						$this->templateEngine->assign("parentColumnId", $parentId);                   //栏目Id
						$this->templateEngine->assign("parentColumnAlias", $columnAliasP);            //父栏目别名
						$this->templateEngine->assign("parentColumnName", $columnNameP);              //父栏目名称
						$this->templateEngine->assign("pageNum", $pageNum);                           //每页显示条数
						$this->templateEngine->assign("recordCount", $recordCount);                   //总记录数
						$this->templateEngine->assign("pageNo", 1);                                   //当前页码
						$this->templateEngine->assign("htmlFileListPre", $config["listFilePre"]);     //列表页文件名前缀
						$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
						$rPathTmp = (empty($rPath)?".":$rPath);
						$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址
						$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                   //相对于主页路径
						$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");          //相对于主页路径
						$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
						$this->templateEngine->assign("parentColumn", $parentColumnArr);              //所在栏目的上级栏目
						$this->templateEngine->assign("brotherColumn", $brotherColumnArr);            //所在栏目的兄弟栏目
						$getSeo = $this->getSeoData($siteId, 0);
						$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
						$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
						$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
						$getSeo = $this->getSeoData($siteId, $columnId);
						$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
						$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
						$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
						$getSite = $this->getSiteData($siteId);
						$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
						$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
						try{
							$str = $this->templateEngine->compile($templateFile);
							//生成列表静态不分页文件
							$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") .$siteAlias . "/" . $createPath;
							$this->createFile($str, $pathStr, $columnAlias . $config["listFilePre"] . "1.html");
							$this->createHtmlLog->pushLog("“" . $columnName . "”->列表页(第1页)生成成功");
						}catch  (Exception $e) {
							$this->createHtmlLog->pushLog($e->getMessage());
						}
					}
				}else{             //不需要分页
					$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
					$this->templateEngine->assign("columnId", $columnId);                         //栏目Id

					$this->templateEngine->assign("columnAlias", $columnAlias);                   //栏目别名
					$this->templateEngine->assign("columnName", $columnName);                     //栏目名
					$this->templateEngine->assign("siteId", $siteId);                             //站点ID
					$this->templateEngine->assign("parentColumnId", $parentId);                   //栏目Id
					$this->templateEngine->assign("parentColumnAlias", $columnAliasP);            //父栏目别名
					$this->templateEngine->assign("parentColumnName", $columnNameP);              //父栏目名称
					$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]); //详情页文件名前缀
					$this->templateEngine->assign("pageNum", "");                                 //每页显示条数
					$this->templateEngine->assign("pageNo", "");                                  //当前页码
					$rPathTmp = (empty($rPath)?".":$rPath);
					$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址
					$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                  //相对于主页路径
					$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");
					$this->templateEngine->assign("commonThemePath", $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
					$this->templateEngine->assign("parentColumn", $parentColumnArr);             //所在栏目的上级栏目
					$this->templateEngine->assign("brotherColumn", $brotherColumnArr);           //所在栏目的兄弟栏目
					$getSeo = $this->getSeoData($siteId, 0);
					$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSeo = $this->getSeoData($siteId, $columnId);
					$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
					$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
					$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
					$getSite = $this->getSiteData($siteId);
					$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
					$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
					try{
						$str = $this->templateEngine->compile($templateFile);
						//生成列表静态不分页文件
						$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias . "/" . $createPath;
						$this->createFile($str, $pathStr, $columnAlias . $config["listFilePre"] . ".html");
						$this->createHtmlLog->pushLog("“" . $columnName . "”->列表页生成成功");
					}catch  (Exception $e) {
						$this->createHtmlLog->pushLog($e->getMessage());
					}
				}
			}
		}
	}
	/**
	 *
	 * 生成详情页(根据栏目生成全部详情页)
	 */
	public function createDetailPageOfColumnId($siteId, $columnId, $siteAlias, $cDataId = ""){
		//全局配置
		$config = SuperPHP::getConfig();
		//获取栏目列表页模板id和详情页模板id
		$contentObj = $this->_GetContentDao();//TMouldEngineManager::getContentClass();
		$getCData = $contentObj->queryData(array("row_id"=>$columnId, "site_id"=>$siteId));
		if ($getCData[1] > 0){
			$deTailTemplateId = $getCData[0][0]["template_detail_id"]; //栏目详情页对应的【模板ID】
			$mouldId = $getCData[0][0]["mould_id"];                    //栏目对应的【模型ID】
			$columnName = $getCData[0][0]["column_name"];              //栏目名称
			$columnAlias = $getCData[0][0]["column_alias"];            //栏目别名
			$parentId = $getCData[0][0]["parent_id"];                  //栏目对应的【父栏目ID】
			$targetAlias = $getCData[0][0]["target_alias"];                 //栏目对应的【目标栏目别名】
			//获取父栏目别名
			$getCData = $contentObj->queryData(array("row_id"=>$parentId, "site_id"=>$siteId));
			if ($getCData[1] > 0){
				$columnAliasP = $getCData[0][0]["column_alias"];        //栏目别名
				$columnNameP = $getCData[0][0]["column_name"];          //栏目别名
			}
		}

		$resultPath = "";
		if (!empty($deTailTemplateId)){
			//获取栏目导航
			$parentColumnArr = array();
			$this->getParentColumn($siteId, $parentId, $parentColumnArr);
			//获取兄弟栏目导航
			$brotherColumnArr = $this->getBrotherColumn($siteId, $parentId);
			//获取模板所在目录
			$templateClass =  $this->_GetTemplateDao();
			$getTData = $templateClass->queryData(array("row_id"=>$deTailTemplateId));

			$getTData = array_filter($getTData);
			if(!empty($getTData)){
				$rPath = "";
				$this->getRelativeIndexPath($siteId, $columnId, $rPath);
				$templateFile = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) . "/" . $getTData[0][0]["template_file"];//$config['siteTemplate'] . $getTData[0][0]["template_file"];
                //模板模块先编译
			    $this->createIncludePage($config['template']['template_path'] . "/" . $templateFile, $siteAlias, $siteId);
				
				//获取栏目模型对应的表
				$mouldObj = $this->_GetMouldDao();// TMouldEngineManager::getMouldClass();
				$getMData = $mouldObj->queryData(array("isQuerySub"=>"0", "query_filter"=>array("row_id"=>$mouldId)));
				$getMData = array_filter($getMData);
				if(!empty($getMData)){
					$mouldTable = $getMData[0][0]["mould_table"];  //模型对应的表
				}
				$dao = new SDao();
				if(empty($targetAlias)){
					$sql = "select * from %s where column_id=%s and is_delete=0";
					$sql = sprintf($sql, $mouldTable, $columnId);
				}else{
					$sql = "select * from %s where column_alias='%s' and is_delete=0";
					$sql = sprintf($sql, $mouldTable, $targetAlias);
				}

				if (!empty($cDataId)){
					$sql .= " and row_id=" . $cDataId;
				}
					
				//$sql = sprintf($sql, $mouldTable, $columnId);
				$getData = $dao->getDao()->db->get_all_sql($sql); //获取数据
				$i = 0;
				if (is_array($getData)){
					foreach ($getData as $value){
						$dataId = $value["row_id"];
						$publishDate = $value["publish_date"];
						//生成详情页
						//详情模板编译
						$this->templateEngine->assign("dataId", $dataId);                           //数据Id
						$pDataId = "";
						$pDataTitle = "";
						if ($i > 0){
							$pDataId = $getData[$i - 1]["row_id"];
							$pDataTitle = $getData[$i - 1]["title"];
							$pDataPublishDate = $getData[$i - 1]["publish_date"];
						}
						$this->templateEngine->assign("pDataId", $pDataId);                         //前一条数据Id
						$this->templateEngine->assign("pDataTitle", $pDataTitle);                   //前一条数据标题
						$this->templateEngine->assign("pDataPublishDate", $pDataPublishDate);       //前一条数据发布日期
						$nDataId = "";
						$nDataTitle = "";
						if ($i < count($getData) - 1){
							$nDataId = $getData[$i + 1]["row_id"];
							$nDataTitle = $getData[$i + 1]["title"];
							$nDataPublishDate = $getData[$i + 1]["publish_date"];
						}
						$i++;
						$this->templateEngine->assign("nDataId", $nDataId);                         //后一条数据Id
						$this->templateEngine->assign("nDataTitle", $nDataTitle);                   //后一条数据标题
						$this->templateEngine->assign("nDataPublishDate", $nDataPublishDate);                   //后一条数据发布日期

						$this->templateEngine->assign("siteId", $siteId);                           //站点Id
						$this->templateEngine->assign("columnId", $columnId);                       //栏目Id
						$this->templateEngine->assign("columnName", $columnName);                   //栏目名
						$this->templateEngine->assign("columnAlias", $columnAlias);                 //栏目别名
						$this->templateEngine->assign("parentColumnId", $parentId);                   //栏目Id
						$this->templateEngine->assign("parentColumnAlias", $columnAliasP);          //父栏目别名
						$this->templateEngine->assign("parentColumnName", $columnNameP);            //父栏目名称
						$this->templateEngine->assign("htmlFileDetailPre", $config["detailFilePre"]);
						$rPathTmp = (empty($rPath)?"..":"../".$rPath);
						$this->templateEngine->assign("themePath", $rPathTmp);//站点主题地址
						$this->templateEngine->assign("relativeIndexPath", $rPathTmp . "/");                 //相对于主页路径
						$this->templateEngine->assign("adminPath", $rPathTmp . "/" . $this->relativePath . $config['siteName'] . "/");        //相对于主页路径
						$this->templateEngine->assign("commonThemePath",  $rPathTmp . "/" . $this->relativePath . "uiLibrary");//共用主题地址，包括js及对应 的css
						$this->templateEngine->assign("parentColumn", $parentColumnArr);            //所在栏目的上级栏目
						$this->templateEngine->assign("brotherColumn", $brotherColumnArr);          //所在栏目的兄弟栏目
						$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
						$getSeo = $this->getSeoData($siteId, 0);
						$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
						$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
						$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
						$getSeo = $this->getSeoData($siteId, $columnId);
						$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
						$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
						$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
						$getSite = $this->getSiteData($siteId);
						$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
						$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
						try {
							$str = $this->templateEngine->compile($templateFile);
							//设置详情页生成静态页
							$sql = "update %s set is_create=1 where row_id=%s";
							$sql = sprintf($sql, $mouldTable, $dataId);
							//$dao->getDao()->db->get_all_sql($sql);

							$dao->getDao()->db->query($sql);

							$createPath = "";
							foreach($parentColumnArr as $valueSub){
								$createPath .= $valueSub["column_alias"] . "/";
							}

							//生成站点详情文件
							$pathStr = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias . "/" . $createPath . $columnAlias;
							//$this->createFile($str, $pathStr, $config["detailFilePre"] . $dataId . ".html");
							//$resultPath = $pathStr . "/" . $config["detailFilePre"] . $dataId . ".html";
							$this->createFile($str, $pathStr, $config["detailFilePre"] . $publishDate . "-" . $dataId . ".html");
							$resultPath = $pathStr . "/" . $config["detailFilePre"] . $publishDate . "-" . $dataId . ".html";
							$this->createHtmlLog->pushLog("“" . $columnName . "”->标题：‘" . $value["title"] . "’->详情页生成成功");
						}catch  (Exception $e) {
							$this->createHtmlLog->pushLog($e->getMessage());
						}
					}
				}
			}
		}
		return $resultPath;
	}
	/**
	 *
	 * 生成被包含的模块页
	 */
	public function createIncludePage($templateFile, $siteAlias, $siteId="",$style){
		$config = SuperPHP::getConfig();
 
		$str = @file_get_contents($templateFile);
		
		preg_match_all("/<!--\[\s*include\s+[\'\"](.*)[\'\"]\s*\]-->/", $str, $m);

		$m = array_filter($m);
		if(!empty($m)){
			foreach ($m[1] as $value){
				$strArr = explode(":", $value, 2);
			
				if (count($strArr) > 1){
					$templateFileTmp = $strArr[0] . "/" . $strArr[1];
					$templateFileTmp =$strArr[1];
				}else{
					$templateFileTmp = $strArr[0];
				}
 
				$config = SuperPHP::getConfig();
				if (!empty($siteAlias)){
					$templateFileTmp = $config['siteTemplateDir'] . "/" . (empty($this->siteTemplateDir) ? $siteAlias : $this->siteTemplateDir) . "/$style/" . $templateFileTmp;
				}

				$this->createIncludePage($config['template']['template_path'] . "/" . $templateFileTmp, $siteAlias, $siteId); //嵌套调用，生成模块中的模块
				//$this->createHtmlLog->pushLog($config['template']['template_path'] . "/" . $templateFileTmp);
				//模板编译
				//$this->templateEngine->assign("filePath", $filePath);
				$this->templateEngine->assign("siteId", $siteId);
				$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
 
				$this->templateEngine->compile($templateFileTmp);
			}
		}
	}
	/**
	 *
	 * 生成动态访问的MVC
	 */
	private function createSiteMVC($mouldTable, $templateFile, $siteId, $siteMainName, $siteAlias, $columnId, $columnName, $columnAlias, $columnIdP,
	$columnAliasP, $columnNameP,	$htmlFileListPre, $htmlFileDetailPre, $themePath, $relativeIndexPath,
	$commonThemePath, $parentColumnArr, $brotherColumnArr, $mouldId){
		//全局配置
		$config = SuperPHP::getConfig();
		//生成站点控制器主入口类
		$str = "<?php \n";
		//$str .= "define('accountId'," . $siteId . ");\n";        //帐户ID定义
		$str .= "define('APP_MANAGER_PATH','../../" . $config['adminName'] . "');\n";
		$str .= "header('Content-Type:text/html;charset=utf-8');\n";
		$str .= "require_once dirname(__FILE__) . '/../../superphp/superphp.php';\n";
		$str .= "require_once dirname(__FILE__) .'/../../" . $config['adminName'] . "/conf/conf.php';\n";
		$str .= "\$InitPHP_conf['template']['template_path'] = '../../" . $config['adminName'] . "/template';\n";
		$str .= "\$InitPHP_conf['template']['template_c_path'] = '../../" . $config['adminName'] . "/template_c';\n";
		$str .= "\$InitPHP_conf['dao']['path'] = dirname(__FILE__) . '/../../" . $config['adminName'] . "/dao/';\n";
		$str .= "\$InitPHP_conf['controller']['path'] = dirname(__FILE__) . '/controller/';\n";
		$str .= "SuperPHP::start();\n";
		//生成文件
		$pathStr = "../" . $siteMainName. "/" . $siteAlias;
		$this->createFile($str, $pathStr, "op.php");
		//生成控制器类
		$str = "<?php \n";
		$str .= "require_once dirname(__FILE__) . '/../../../../superphp/core/controller/scontroller.php';\n";
		$str .= "require_once dirname(__FILE__) . '/../../../../" . $config['adminName'] . "/mouldEngine/tagCompile/tagRealizeAdapterForTomms.php';\n";
		$str .= "require_once dirname(__FILE__) . '/../../../../" . $config['adminName'] . "/mouldEngine/createSite/createSiteForTomms.php';\n";
		$str .= "class " . $columnAlias . $htmlFileListPre . "Controller extends SController{\n";
		$str .= "	function __construct() {\n";
		$str .= "		parent::__construct();\n";
		$str .= "		\$this->SetWhiteList(array('run'));\n";
		$str .= "	}\n";
		$str .= "	public function run(){\n";
		$str .= "       \$recordCount = \$_GET['recordCount'];\n";
		$str .= "       \$pageNo = \$_GET['pageNo'];\n";
		$str .= "       \$pageNum = \$_GET['pageNum'];\n";
		//
		$mouldObj = $this->_GetMouldDao();
		$getData = $mouldObj->queryData(array("isQuerySub"=>"1", "query_filter"=>array("mould_id"=>$mouldId)));
		$getData = array_filter($getData);
		if(!empty($getData)){
			foreach($getData[0] as $value){
				$str .= "       \$filterArray['" . $value["field_name"] . "'] = \$_GET['" . $value["field_name"] . "'];\n";
			}
		}
		$str .= "	    \$this->getUtil('session')->set('siteId','" . $siteId . "');\n";
		$str .= "       \$siteId = '" . $siteId . "';\n";
		$str .= "       \$mouldTable = '" . $mouldTable . "';\n";
		$str .= "       \$templateFile = '" . $templateFile . "';\n";
		$str .= "       \$siteAlias = '" . $siteAlias . "';\n";
		$str .= "       \$commonThemePath = '" . $commonThemePath . "';\n";
		$str .= "       \$columnId = '" . $columnId . "';\n";
		$str .= "       \$columnName = '" . addslashes($columnName) . "';\n";
		$str .= "       \$columnAlias = '" . addslashes($columnAlias) . "';\n";
		$str .= "       \$columnIdP = '" . addslashes($columnIdP) . "';\n";
		$str .= "       \$columnNameP = '" . addslashes($columnNameP) . "';\n";
		$str .= "       \$columnAliasP = '" . addslashes($columnAliasP) . "';\n";
		$str .= "       \$htmlFileListPre = '" . $htmlFileListPre . "';\n";
		$str .= "       \$htmlFileDetailPre = '" . $htmlFileDetailPre . "';\n";
		$str .= "       \$themePath = '" . $themePath . "';\n";
		$str .= "       \$relativeIndexPath = '" . $relativeIndexPath . "';\n";
		$str .= "       \$parentColumnArr = array();\n";
		foreach ($parentColumnArr as $key=>$value){
			foreach ($value as $subKey=>$subValue){
				$str .= "       \$oneArr[" . $subKey . "]='" . addslashes($subValue) . "';\n";
			}
			$str .= "       array_push(\$parentColumnArr, \$oneArr);\n";
		}
		$str .= "       \$brotherColumnArr = array();\n";
		foreach ($brotherColumnArr as $key=>$value){
			foreach ($value as $subKey=>$subValue){
				$str .= "       \$oneArr[" . $subKey . "]='" . addslashes($subValue) . "';\n";
			}
			$str .= "       array_push(\$brotherColumnArr, \$oneArr);\n";
		}

		$str .= "       \$createSite = new createSiteForTomms(\$siteAlias);\n";
		$str .= "       echo \$createSite->createActivePage(\$mouldTable, \$templateFile, \$siteAlias, \$recordCount, \$pageNo, \$pageNum, \$filterArray, \$columnId, \$columnName, \$columnAlias, \$columnIdP, \$columnNameP,\$columnAliasP,
		                              \$htmlFileListPre, \$htmlFileDetailPre, \$themePath, \$relativeIndexPath, \$commonThemePath, \$parentColumnArr, \$brotherColumnArr,\$siteId);\n";
		$str .= "	}\n";
		$str .= "}";
		//生成文件
		$pathStr = "../" . $siteMainName. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias . "/controller/" . $this->moduleName;  //tomms";
		$this->createFile($str, $pathStr, $columnAlias . $htmlFileListPre . "Controller.php");
	}
	/**
	 *
	 * 生成插件访问文件
	 * @param unknown_type $siteMainName
	 * @param unknown_type $siteAlias
	 */
	private function createPluginFile($siteId, $siteAlias,$account){
		//全局配置
		$config = SuperPHP::getConfig();
		$str = "<?php \n";
	    $str .= "if (isset(\$_GET['pm'])){ \n";
	    $str .= "   \$pm = \$_GET['pm']; \n";
        $str .= "} \n";
        $str .= "if (empty(\$pm)){ \n";
        $str .= "	\$pm = '" . $this->moduleName . "'; \n";
        $str .= "} \n";
		$str .= "\$p = \$_GET['p'];\n";
		$str .= "define('PLUGINPTAH', '" . $this->relativePath . $config['adminName'] . "/plugin/' . \$pm . '/' . \$p . '/');\n";
		$str .= "require_once PLUGINPTAH . 'index.php';\n";
		//生成文件
		$targetPath = "../" . $config['siteName']. "/" . (empty($this->createTwoDir)?"": $this->createTwoDir . "/") . $siteAlias."/".$account;
		$this->createFile($str, $targetPath, "plugin.php");
		//拷贝插件样式到站点
		$confDao = $this->_GetConfDao();
		$pluginData = $confDao->queryPluginData($siteId);
		$pluginData = empty($pluginData)?$pluginData:array_filter($pluginData);
		if (!empty($pluginData)){
			foreach ($pluginData as $valueP){
				if (!empty($valueP["app_alias"])){
					$valueP["name"] = $valueP["app_alias"];
				}
				$srcPath = "plugin/" . $this->moduleName . "/" . $valueP["name"] . "/" . $config['template']['template_path'] . "/" . $config['siteTemplateDir'];
				$targetPathTmp = $targetPath . "/plugin/" . $valueP["name"];  
				$this->delDirAndFile($targetPathTmp . "/images");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的images”->删除成功");
				$this->delDirAndFile($targetPathTmp . "/css");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的css”->删除成功");
				$this->delDirAndFile($targetPathTmp . "/js");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的js”->删除成功");
				$this->recurse_copy($srcPath . "/images", $targetPathTmp . "/images");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的images”->拷贝成功");
				$this->recurse_copy($srcPath . "/css", $targetPathTmp . "/css");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的css”->拷贝成功");
				$this->recurse_copy($srcPath . "/js", $targetPathTmp . "/js");
				$this->createHtmlLog->pushLog("“站点插件" . $valueP["name"] . "的js”->拷贝成功");
			}
		}
		
		
		//扩展目录生成
		$expandArr=array();
		$expandArr["name"]='expand';
		$moduleName='tecmp';
		$srcPath = "plugin/" . $moduleName . "/" . $expandArr["name"] . "/" . $config['template']['template_path'] . "/" . $config['siteTemplateDir'];
		$targetPathTmp = $targetPath . "/plugin/" . $expandArr["name"];
		$this->delDirAndFile($targetPathTmp . "/images");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的images”->删除成功");
		$this->delDirAndFile($targetPathTmp . "/css");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的css”->删除成功");
		$this->delDirAndFile($targetPathTmp . "/js");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的js”->删除成功");
		$this->recurse_copy($srcPath . "/images", $targetPathTmp . "/images");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的images”->拷贝成功");
		$this->recurse_copy($srcPath . "/css", $targetPathTmp . "/css");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的css”->拷贝成功");
		$this->recurse_copy($srcPath . "/js", $targetPathTmp . "/js");
		$this->createHtmlLog->pushLog("“站点插件" . $expandArr["name"] . "的js”->拷贝成功");
		
		
	}
	/**
	 *
	 * 生成动态访问页
	 * @param $recordCount
	 * @param $pageNo
	 * @param $pageNum
	 * @param $queryContent
	 * @param $columnId
	 * @param $columnName
	 * @param $columnAlias
	 * @param $columnNameP
	 * @param $columnAliasP
	 * @param $htmlFileListPre
	 * @param $htmlFileDetailPre
	 * @param $themePath
	 * @param $relativeIndexPath
	 * @param $parentColumnArr
	 * @param $brotherColumn
	 */
	public function createActivePage($mouldTable, $templateFile, $siteAlias, $recordCount, $pageNo, $pageNum, $filterArray, $columnId, $columnName, $columnAlias,$columnIdP, $columnNameP,$columnAliasP,
	$htmlFileListPre, $htmlFileDetailPre, $themePath, $relativeIndexPath, $commonThemePath, $parentColumnArr, $brotherColumnArr, $siteId){
		$config = SuperPHP::getConfig();
		//模板模块先编译
		$this->createIncludePage($config['template']['template_path'] . "/" . $templateFile, $siteAlias, $siteId);

		$this->templateEngine->setTagAdapter($this->tagRealizeAdapter);
		if (!empty($filterArray)){
			foreach ($filterArray as $key=>$value){
				$this->templateEngine->assign($key, $value);
			}
		}
		$this->templateEngine->assign("columnId", $columnId);                        //栏目Id
		$this->templateEngine->assign("columnName", $columnName);                    //栏目名
		$this->templateEngine->assign("columnAlias", $columnAlias);                  //栏目别名
		$this->templateEngine->assign("parentColumnId", $columnIdP);                 //父栏目Id
		$this->templateEngine->assign("parentColumnAlias", $columnAliasP);           //父栏目别名
		$this->templateEngine->assign("parentColumnName", $columnNameP);             //父栏目名称
		$this->templateEngine->assign("pageNum", $pageNum);                          //每页显示条数
		$this->templateEngine->assign("recordCount", $recordCount);                  //总记录数
		$this->templateEngine->assign("pageNo", $pageNo);                            //当前页码

		$this->templateEngine->assign("htmlFileListPre", $htmlFileListPre);          //列表页文件名前缀
		$this->templateEngine->assign("htmlFileDetailPre", $htmlFileDetailPre);      //详情页文件名前缀
		//$this->templateEngine->assign("themePath",$themePath);                     //站点主题地址
		//$this->templateEngine->assign("themePath", $config['template']['template_path'] . "/siteTemplate/" . $siteAlias);
		$this->templateEngine->assign("themePath", ".");     //站点主题地址
		//$this->templateEngine->assign("relativeIndexPath", $relativeIndexPath);    //相对于主页路径
		$this->templateEngine->assign("relativeIndexPath", "");                      //相对于主页路径
		$this->templateEngine->assign("adminPath", $this->relativePath . $config['siteName'] . "/");
		$this->templateEngine->assign("commonThemePath", $commonThemePath);
		$this->templateEngine->assign("parentColumn", $parentColumnArr);             //所在栏目的上级栏目
		$this->templateEngine->assign("brotherColumn", $brotherColumnArr);           //所在栏目的兄弟栏目
		$getSeo = $this->getSeoData($siteId, 0);
		$this->templateEngine->assign("siteTitle", $getSeo["title"]);                     //网站title
		$this->templateEngine->assign("siteMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
		$this->templateEngine->assign("siteMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
		$getSeo = $this->getSeoData($siteId, $columnId);
		$this->templateEngine->assign("columnTitle", $getSeo["title"]);                     //网站title
		$this->templateEngine->assign("columnMetaKeywords", $getSeo["metaKeywords"]);       //网站metaKeywords
		$this->templateEngine->assign("columnMetaDescription", $getSeo["metaDescription"]); //网站metaDescription
		$getSite = $this->getSiteData($siteId);
		$this->templateEngine->assign("siteIcp", $getSite[0][0]["site_icp"]);                     //网站icp
		$this->templateEngine->assign("siteStatisticsCode", $getSite[0][0]["countCode"]);         //网站统计代码
		return $this->templateEngine->compile($templateFile);
	}
	/**
	 *
	 * 获取相对于主页的相对路径，如果栏目是1级栏目，返回"";2级栏目，返回"../"
	 * @param $columnId
	 */
	private function getRelativeIndexPath($siteId, $columnId, &$rPath){
		//获取父栏目id
		$contentClass = $this->_GetContentDao();
		$getCData = $contentClass->queryData(array("row_id"=>$columnId, "site_id"=>$siteId));
		$getCData = array_filter($getCData);
		if(!empty($getCData)){
			$parentId = $getCData[0][0]["parent_id"];
			if (!empty($parentId))
			{
				$rPath = empty($rPath)?".." : $rPath . "/..";
				$this->getRelativeIndexPath($siteId, $parentId, $rPath);
			}
		}
	}
	/**
	 *
	 * 获取父级栏目数组
	 * @param unknown_type $columnId
	 */
	private function getParentColumn($siteId, $columnId, &$resultArr){
		//栏目
		$contentClass = $this->_GetContentDao();
		$getCData = $contentClass->queryData(array("row_id"=>$columnId, "site_id"=>$siteId));
		$getCData = array_filter($getCData);
		if(!empty($getCData) && $getCData[1] > 0){
			$parentId = $getCData[0][0]["parent_id"];
			$columnName = $getCData[0][0]["column_name"];
			$columnAlias = $getCData[0][0]["column_alias"];
			$columnId = $getCData[0][0]["row_id"];
			if (!empty($parentId)){
				//array_push($resultArr, $this->getParentColumn($siteId, $parentId, $resultArr));
				$this->getParentColumn($siteId, $parentId, $resultArr);
			}
			$oneArr["column_name"] = $columnName;
			$oneArr["column_alias"] = $columnAlias;
			$oneArr["row_id"] = $columnId;
			array_push($resultArr, $oneArr);
		}
	}

	/**
	 *
	 * 获取兄弟栏目导航
	 * @param unknown_type $columnId
	 */
	private function getBrotherColumn($siteId, $columnId){
		$resultArr=array();
		//栏目
		$contentClass = $this->_GetContentDao();
		$getCData = $contentClass->queryData(array("parent_id"=>$columnId, "site_id"=>$siteId));//"is_show"=>1,
		$getCData = array_filter($getCData);
		if(!empty($getCData)){
			foreach ($getCData[0] as $value){
				$oneArr["column_name"] = $value["column_name"];
				$oneArr["column_alias"] = $value["column_alias"];
				array_push($resultArr, $oneArr);
			}
		}
		return $resultArr;
	}
	/**
	 *
	 * 生成文件
	 * @param unknown_type $htmlStr
	 * @param unknown_type $siteId
	 * @param unknown_type $fileName
	 */
	private function createFile($htmlStr, $filePath, $fileName){
     	/*
		 $config = SuperPHP::getConfig();
		 $pathStr = "../" . $config['siteName'];
		 if(!is_dir($pathStr)){
		 @mkdir($pathStr);
		 @chmod($pathStr, 0777);
		 }
		 $pathStr = $pathStr . "/" . $siteId;
		 if(!is_dir($pathStr)){
		 @mkdir($pathStr);
		 @chmod($pathStr, 0777);
		 }
		 $pathStr = $pathStr . "/" . $fileName;
		 */
		$this->create_dir($filePath);
		@file_put_contents($filePath . "/" . $fileName, $htmlStr);
		return true;
	}

	/**
	 *	创建目录
	 * 	@param  string  $path   目录
	 *  @return
	 */
	private function create_dir($path) {
		if (is_dir($path)) return false;
		$this->create_dir(dirname($path));
		@mkdir($path);
		@chmod($path, 0777);
		return true;
	}
	/**
	 *
	 * 拷贝皮肤文件(css,image,js)到站点目录中
	 */
	public  function copyThemeToSite($src, $dst){
 
		$this->delDirAndFile($dst . "/images");
		$this->createHtmlLog->pushLog("“站点images”->删除成功");
		$this->delDirAndFile($dst . "/css");
		$this->createHtmlLog->pushLog("“站点css”->删除成功");
		$this->delDirAndFile($dst . "/js");
		$this->createHtmlLog->pushLog("“站点js”->删除成功");
		$this->recurse_copy($src . "/images", $dst . "/images");
		$this->createHtmlLog->pushLog("“站点images”->拷贝成功");
		$this->recurse_copy($src . "/css", $dst . "/css");
		$this->createHtmlLog->pushLog("“站点css”->拷贝成功");
		$this->recurse_copy($src . "/js", $dst . "/js");
		$this->createHtmlLog->pushLog("“站点js”->拷贝成功");
	}
	/**
	 *
	 * 拷贝目录下的文件，原目录复制到目的目录
	 * @param unknown_type $src
	 * @param unknown_type $dst
	 */
	private function recurse_copy($src,$dst) {
		if (!is_dir($src)) return false;
		$dir = opendir($src);
		//@mkdir($dst);
		$this->create_dir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
	/**
	 *
	 * 循环删除目录和文件
	 * @param unknown_type $src
	 * @param unknown_type $dst
	 */
	private function delDirAndFile($dirName){
		if (!is_dir($dirName)) return false;
		if ( $handle = opendir( "$dirName" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dirName/$item" ) ) {
						$this->delDirAndFile( "$dirName/$item" );
					} else {
						if( unlink( "$dirName/$item" ) ){
							//echo "成功删除文件： $dirName/$item<br />\n";
						}
					}
				}
			}
			closedir( $handle );
			if(rmdir($dirName)){
				//echo "成功删除目录： $dirName<br />\n";
			}
		}
	}
	/**
	 *
	 * 获取seo数据
	 */
	private function getSeoData($siteId, $columnId){
		$confDao = $this->_GetConfDao();
		$getSeoData = $confDao->queryData_seo(array("column_id"=>$columnId, "site_id"=>$siteId, "is_delete"=>0));
		$getSeoData = empty($getSeoData)?$getSeoData:array_filter($getSeoData);
		if ($getSeoData[1] > 0){
			return $getSeoData[0][0];
		}
		return null;
	}
	/**
	 *
	 * 获取站点数据
	 */
	private function getSiteData($siteId){
		$confDao = $this->_GetConfDao();
		$getSiteData = $confDao->querySiteData(array("is_delete"=>0,"row_id"=>$siteId));
		return empty($getSiteData)?$getSiteData:array_filter($getSiteData);
	}
	/**
	 *
	 * 获取contentDao数据操作类
	 */
	private function _GetContentDao(){
		return SuperPHP::getDao("content", $this->moduleName);
	}
	/**
	 *
	 * 获取mouldDao数据操作类
	 */
	private function _GetMouldDao(){
		return SuperPHP::getDao("mould", $this->moduleName);
	}
	/**
	 *
	 * 获取templateDao数据操作类
	 */
	private function _GetTemplateDao(){
		return SuperPHP::getDao("template", $this->moduleName);
	}

	/**
	 *
	 * 获取confDao数据操作类
	 */
	private function _GetConfDao(){
		return SuperPHP::getDao("conf", $this->moduleName);
	}
}