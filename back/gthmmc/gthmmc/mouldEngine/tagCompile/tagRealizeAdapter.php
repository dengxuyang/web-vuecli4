<?php
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
require_once dirname(__FILE__) . '/../../../superphp/engine/tagAdapter.php';
require_once dirname(__FILE__) . '/../mouldEngineManager.php';
require_once dirname(__FILE__) . '/../tags.php';
require_once dirname(__FILE__) . '/../contents.php';

class TTagRealizeAdapter extends SController implements ISTagAdapter{
	public $contentTable;
	public $siteAlias;
	public $moduleName;

	public function compile($str, $left, $right){
		//系统字符替换
		$getStr = $this->sysStrReplace($str, $left, $right);
		//标签处理
		preg_match_all("/<!--\[#(([a-zA-Z]+)\s+(.*))\]-->/", $getStr, $m);
		$result = $getStr;
		for($i=0; $i<count($m[0]); $i++){
			$allStr = $m[1][$i];  //匹配得到的全字符
			$module = $m[2][$i];  //标签模块名称
			$paramStr = $m[3][$i];//全部参数字符数组
			//preg_match_all("/([a-z_A-Z]+)=\"([\$]?[0-9_a-zA-Z]*)\"/", $paramStr, $p);
			//preg_match_all("/([a-z_A-Z]+)=[\"\']([\$]?[0-9_,a-zA-Z\[\]\"\'\@]*)[\"\']/", $paramStr, $p);
			preg_match_all("/([a-z_A-Z]+)=\"(.+?)\"/", $paramStr, $p);
			$splitParamArr = array();
			for($b=0; $b<count($p[0]); $b++){
				$param = $p[1][$b];       //参数名
				$paramValue = $p[2][$b];  //参数对应的数值
				$splitParamArr[$param] = $paramValue;
			}
			//解析标签
			$compileStr = $this->compileTag($module, $splitParamArr);
			//替换标签
			//$result = str_replace("<!--[#" . $allStr . "]-->", $compileStr,$result);
			$result = preg_replace("/".preg_quote($left)."#\s*" . preg_quote($allStr) . "\s*" . preg_quote($right) ."/", $compileStr,$result);
		}
		return $result;
	}

	/**
	 *
	 * 解析标签
	 * @param 字符串 $module 标签模块名称
	 * @param array $paramArr 标签参数数组
	 */
	private function compileTag($module, $paramArr){
		//$bFlag = true;
		$result = "";
		switch ($module){
			case "System":
				switch ($paramArr["action"]){
					case "loadFunction":         //加载函数
						//$result = $this->compileTagFunc($module, $paramArr);
						$result = "<?php " . $this->addFunc() . " ?>";
						//$bFlag = false;
						break;
					case "sql":                  //加载SQL
						$result = $this->compileTagForSql($module, $paramArr);
						break;
					case "plugin":  //调用插件方法
						$result = $this->compileTagForPlugin($module, $paramArr);
						break;
						//case "allSearch":            //全文检索
						//	$result = $this->compileTagForAllSearch($module, $paramArr);
						//	break;
					default :
						$result = $this->compileTagDao($module, $paramArr);
						break;
				}
				break;
			case "Plugin":
				$result =  $this->compileTagPlugin($module, $paramArr);
				break;
			default:
				$result =  $this->compileTagDao($module, $paramArr);
				break;
		}

		/*
		 if ($module == "System"){
			switch ($paramArr["action"]){
			case "loadFunction":         //加载函数
			//$result = $this->compileTagFunc($module, $paramArr);
			$result = $this->addFunc();
			$bFlag = false;
			break;
			}
			}else if ($module == "Plugin"){    //插件标签
			$result =  $this->compileTagPlugin($module, $paramArr);
			$bFlag = false;
			}

			if ($bFlag){
			$result =  $this->compileTagDao($module, $paramArr);
			}
			*/
		return $result;
		//return $this->compileTagDao($module, $paramArr);
	}
	/**
	 *
	 * 解析加载函数库标签
	 * @param 字符串 $module 标签模块名称
	 * @param array $paramArr 标签参数数组
	 */
	/*
	 private function compileTagFunc($module, $paramArr){
		$funStr = "<?";
		$funStr .= "if(!function_exists('getColumnListPath')){";
		$funStr .= "  function getColumnListPath(\$columnAlias){";
		$funStr .= "	require_once APP_MANAGER_PATH . '/mouldEngine/mouldEngineManager.php';";
		$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias));";
		$funStr .= "	\$config = SuperPHP::getConfig();";
		$funStr .= "	if (\$getCData[1] > 0){";
		$funStr .= "		\$columnId = \$getCData[0][0][\"parent_id\"];";
		$funStr .= "		\$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false;";
		$funStr .= "	    \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false;";
		$funStr .= "		if (!empty(\$columnId)){";
		$funStr .= "			if(\$isActive){";
		//$funStr .= "			    \$result = \$columnAlias . \$config[\"listFilePre\"] . \".php\";";
		$funStr .= "			    \$result = 'op.php?c=' . \$columnAlias . \$config[\"listFilePre\"];";
		$funStr .= "		    }else{";
		$funStr .= "			    if (\$isPage){";
		$funStr .= "				    \$result = \$columnAlias . \$config[\"listFilePre\"] . \"1.html\";";
		$funStr .= "			    }else{";
		$funStr .= "				    \$result = \$columnAlias . \$config[\"listFilePre\"] . \".html\";";
		$funStr .= "			    }";
		$funStr .= "		        getColumnListPathOp(\$columnId, \$result);";
		$funStr .= "		    }";
		$funStr .= "		}";
		$funStr .= "	}";
		$funStr .= "	return  \$result;";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= "if(!function_exists('getColumnListPagePath')){";
		$funStr .= "  function getColumnListPagePath(\$columnAlias){";
		$funStr .= "	require_once APP_MANAGER_PATH. '/mouldEngine/mouldEngineManager.php';";
		$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias));";
		$funStr .= "	\$config = SuperPHP::getConfig();";
		$funStr .= "	if (\$getCData[1] > 0){";
		$funStr .= "		\$columnId = \$getCData[0][0][\"parent_id\"];";
		$funStr .= "		\$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false;";
		$funStr .= "	    \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false;";
		$funStr .= "		if (!empty(\$columnId)){";
		$funStr .= "			if(\$isActive){";
		$funStr .= "			    \$result = 'op.php?c=' . \$columnAlias . \$config['listFilePre'] . '&%s';";
		$funStr .= "		    }else{";
		$funStr .= "			    if (\$isPage){";
		$funStr .= "				    \$result = \$columnAlias . \$config['listFilePre'] . '%s.html';";
		$funStr .= "			    }";
		$funStr .= "		        getColumnListPathOp(\$columnId, \$result);";
		$funStr .= "		    }";
		$funStr .= "		}";
		$funStr .= "	}";
		$funStr .= "	return  \$result;";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= "if(!function_exists('getColumnPageNum')){";
		$funStr .= "  function getColumnPageNum(\$columnAlias){";
		$funStr .= "	require_once APP_MANAGER_PATH. '/mouldEngine/mouldEngineManager.php';";
		$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias));";
		$funStr .= "	\$config = SuperPHP::getConfig();";
		$funStr .= "	if (\$getCData[1] > 0){";
		$funStr .= "		\$pageNum = \$getCData[0][0][\"pageNum\"];";
		$funStr .= "	}";
		$funStr .= "	return  \$pageNum;";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= "if(!function_exists('getColumnDetailPath')){";
		$funStr .= "function getColumnDetailPath(\$columnAlias){";
		$funStr .= "require_once APP_MANAGER_PATH . '/mouldEngine/mouldEngineManager.php';";
		$funStr .= "\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias));";
		$funStr .= "\$config = SuperPHP::getConfig();";
		$funStr .= "if (\$getCData[1] > 0){";
		$funStr .= "	\$currentId = \$getCData[0][0][\"row_id\"];";
		$funStr .= "	\$columnId = \$getCData[0][0][\"parent_id\"];";
		$funStr .= "	if (!empty(\$columnId)){";
		$funStr .= "		\$result = \$columnAlias;";
		$funStr .= "		\getColumnListPathOp(\$columnId, \$result);";
		$funStr .= "	}";
		$funStr .= "  }";
		$funStr .= "  return  \$result;";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= "if(!function_exists('getColumnListPathOp')){";
		$funStr .= " function getColumnListPathOp(\$columnId, &\$sPath){";
		$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"row_id\"=>\$columnId));";
		$funStr .= "	if (\$getCData[1] > 0){";
		$funStr .= "		\$columnId = \$getCData[0][0][\"parent_id\"];";
		$funStr .= "		\$columnAlias = \$getCData[0][0][\"column_alias\"];";
		$funStr .= "		\$sPath = \$columnAlias . \"/\" . \$sPath;";
		$funStr .= "		if (!empty(\$columnId)){";
		$funStr .= "			getColumnListPathOp(\$columnId, \$sPath);";
		$funStr .= "		}";
		$funStr .= "	}";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= " ?>";
		return $funStr;
		}
		*/
	/**
	 *
	 * 加载函数库
	 */
	private function addFunc(){
		$funStr .= "if(!function_exists('getColumnLinkedUrl')){ \n";
		$funStr .= "  function getColumnLinkedUrl(\$columnAlias){ \n";
		$funStr .= "	\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		$funStr .= "    session_start();";
		$funStr .= "    \$siteId = \$_SESSION['siteId'];";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias,\"site_id\"=>\$siteId)); \n";
		$funStr .= "	\$config = SuperPHP::getConfig(); \n";
		$funStr .= "	if (\$getCData[1] > 0){ \n";
		$funStr .= "		\$columnId = \$getCData[0][0][\"row_id\"]; \n";
		$funStr .= "		\$parentColumnId = \$getCData[0][0][\"parent_id\"]; \n";
		$funStr .= "		\$level = \$getCData[0][0][\"level\"]; \n";
		$funStr .= "		\$templateId = \$getCData[0][0][\"template_id\"]; \n";
		$funStr .= "		\$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false; \n";
		$funStr .= "	    \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false; \n";
		$funStr .= "	    \$templateId = \$getCData[0][0][\"template_id\"]; \n";
		$funStr .= "	    \$pageNum = \$getCData[0][0][\"pageNum\"]; \n";
		$funStr .= "		if (!empty(\$columnId)){ \n";
		$funStr .= "			\$blag=true; \n";
		$funStr .= "			if(\$level == 0){ \n";
		$funStr .= "			    if(\$isActive){ \n";
		$funStr .= "			       \$result = 'op.php?m=" . $this->moduleName . "&c=' . \$columnAlias . \$config[\"listFilePre\"] . '&pageNo=1&pageNum=' . \$pageNum; \n";
		$funStr .= "			       \$blag=false; \n";
		$funStr .= "		        }else{ \n";
		$funStr .= "			       if (!empty(\$templateId)){ \n";
		$funStr .= "		               \$result = \$columnAlias . \".html\"; \n";
		$funStr .= "		           }else{ \n";
		$funStr .= "			           if (\$isPage){ \n";
		$funStr .= "				           \$result = \$columnAlias . \$config[\"listFilePre\"] . \"1.html\"; \n";
		$funStr .= "			           }else{ \n";
		$funStr .= "				           \$result = \$columnAlias . \$config[\"listFilePre\"] . \".html\"; \n";
		$funStr .= "			           } \n";
		$funStr .= "		           } \n";
		$funStr .= "		        } \n";
		$funStr .= "		    }else{ \n";
		$funStr .= "		        if (\$templateId > 0) {\n";
		$funStr .= "		           \$result = \$columnAlias . \".html\"; \n";
		$funStr .= "		        }else{ \n";
		$funStr .= "	               \$result = getColumnLinkedUrlOp(\$columnAlias, \$columnId); \n";
		$funStr .= "		           if (strpos(\$result, 'op.php?') === 0) {\n";
		$funStr .= "			          \$blag=false; \n";
		$funStr .= "		           } \n";
		/*
		 $funStr .= "	               \$getCData = \$contentObj->queryData(array(\"parent_id\"=>\$columnId)); \n";
		 $funStr .= "	               if (\$getCData[1] > 0){ \n";
		 $funStr .= "		              \$level = \$getCData[0][0][\"level\"]; \n";
		 $funStr .= "		              \$columnAliasC = \$getCData[0][0][\"column_alias\"]; \n";
		 $funStr .= "		              \$templateId = \$getCData[0][0][\"template_id\"]; \n";
		 $funStr .= "		              \$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false; \n";
		 $funStr .= "	                  \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false; \n";
		 $funStr .= "	                  \$pageNum = \$getCData[0][0][\"pageNum\"]; \n";
		 $funStr .= "			          if(\$level == 0){ \n";
		 $funStr .= "			             if(\$isActive){ \n";
		 $funStr .= "			                \$result = 'op.php?m=tomms&c=' . \$columnAliasC . \$config[\"listFilePre\"] . '&pageNo=1&pageNum=' . \$pageNum; \n";
		 $funStr .= "			                \$blag=false; \n";
		 $funStr .= "		                 }else{ \n";
		 $funStr .= "			                if (!empty(\$templateId)){ \n";
		 $funStr .= "		                        \$result = \$columnAlias . '/' . \$columnAliasC . \".html\"; \n";
		 $funStr .= "		                    }else{ \n";
		 $funStr .= "			                    if (\$isPage){ \n";
		 $funStr .= "				                    \$result = \$columnAlias . '/' . \$columnAliasC . \$config[\"listFilePre\"] . \"1.html\"; \n";
		 $funStr .= "			                    }else{ \n";
		 $funStr .= "				                    \$result = \$columnAlias . '/' . \$columnAliasC . \$config[\"listFilePre\"] . \".html\"; \n";
		 $funStr .= "			                    } \n";
		 $funStr .= "		                    } \n";
		 $funStr .= "		                 } \n";
		 $funStr .= "		              }else{ \n";
		 $funStr .= "				          \$result = \$columnAlias . '/' . \$columnAliasC . \".html\"; \n";
		 $funStr .= "		              } \n";
		 $funStr .= "		            }else{ \n";
		 $funStr .= "				       \$result = \$columnAlias . \".html\"; \n";
		 $funStr .= "		            }";
		 */
		$funStr .= "		       }";
		$funStr .= "		    }";
		$funStr .= "			if (\$blag){ \n";
		$funStr .= "		        getColumnParentLinkedUrl(\$parentColumnId, \$result); \n";
		$funStr .= "		    } \n";
		$funStr .= "		} \n";
		$funStr .= "	} \n";
		$funStr .= "	return  \$result; \n";
		$funStr .= " } \n";
		$funStr .= "} \n";


		$funStr .= "if(!function_exists('getColumnLinkedUrlOp')){ \n";
		$funStr .= " function getColumnLinkedUrlOp(\$columnAlias, \$columnId){ \n";
		$funStr .= "	  \$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		$funStr .= "	  \$getCData = \$contentObj->queryData(array(\"parent_id\"=>\$columnId, \"is_delete\"=>0)); \n";
		$funStr .= "	  if (\$getCData[1] > 0){ \n";
		$funStr .= "	      \$columnPId = \$getCData[0][0][\"row_id\"]; \n";
		$funStr .= "	      \$level = \$getCData[0][0][\"level\"]; \n";
		$funStr .= "	      \$columnAliasC = \$getCData[0][0][\"column_alias\"]; \n";
		$funStr .= "	      \$templateId = \$getCData[0][0][\"template_id\"]; \n";
		$funStr .= "	      \$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false; \n";
		$funStr .= "	      \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false; \n";
		$funStr .= "	      \$pageNum = \$getCData[0][0][\"pageNum\"]; \n";
		$funStr .= "	      \$config = SuperPHP::getConfig(); \n";
		$funStr .= "	      if(\$level == 0){ \n";
		$funStr .= "			   if(\$isActive){ \n";
		$funStr .= "			       \$result = 'op.php?m=" . $this->moduleName . "&c=' . \$columnAliasC . \$config[\"listFilePre\"] . '&pageNo=1&pageNum=' . \$pageNum; \n";
		$funStr .= "		       }else{ \n";
		$funStr .= "			       if (!empty(\$templateId)){ \n";
		$funStr .= "		                \$result = \$columnAlias . '/' . \$columnAliasC . \".html\"; \n";
		$funStr .= "		           }else{ \n";
		$funStr .= "			            if (\$isPage){ \n";
		$funStr .= "				             \$result = \$columnAlias . '/' . \$columnAliasC . \$config[\"listFilePre\"] . \"1.html\"; \n";
		$funStr .= "			            }else{ \n";
		$funStr .= "				             \$result = \$columnAlias . '/' . \$columnAliasC . \$config[\"listFilePre\"] . \".html\"; \n";
		$funStr .= "			            } \n";
		$funStr .= "		           } \n";
		$funStr .= "		       } \n";
		$funStr .= "		  }else{ \n";
		$funStr .= "		        if (\$templateId > 0) {\n";
		$funStr .= "		           \$result = \$columnAlias . '/' . \$columnAliasC . \".html\"; \n";
		$funStr .= "		        }else{ \n";
		$funStr .= "                   \$result = getColumnLinkedUrlOp(\$columnAlias . '/' . \$columnAliasC, \$columnPId);";
		$funStr .= "		        } \n";
		$funStr .= "		  } \n";
		$funStr .= "	 }else{ \n";
		$funStr .= "		 \$result = \$columnAlias . \".html\"; \n";
		$funStr .= "	 } \n";
		$funStr .= "     return \$result; \n";
		$funStr .= " } \n";
		$funStr .= "} \n";


		$funStr .= "if(!function_exists('getDetailLinkedUrl')){ \n";
		$funStr .= "function getDetailLinkedUrl(\$columnAlias){ \n";
		//$funStr .= "require_once APP_MANAGER_PATH . '/mouldEngine/mouldEngineManager.php';";
		//$funStr .= "\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		$funStr .= "session_start();";
		$funStr .= "\$siteId = \$_SESSION['siteId'];";
		$funStr .= "\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias,\"site_id\"=>\$siteId)); \n";
		$funStr .= "\$config = SuperPHP::getConfig(); \n";
		$funStr .= "if (\$getCData[1] > 0){ \n";
		$funStr .= "	\$currentId = \$getCData[0][0][\"row_id\"]; \n";
		$funStr .= "	\$columnId = \$getCData[0][0][\"parent_id\"]; \n";
		$funStr .= "	\$result = \$columnAlias; \n";
		$funStr .= "	if (!empty(\$columnId)){ \n";
		$funStr .= "		getColumnParentLinkedUrl(\$columnId, \$result); \n";
		$funStr .= "	} \n";
		$funStr .= "  } \n";
		$funStr .= "  return  \$result; \n";
		$funStr .= " } \n";
		$funStr .= "} \n";
		$funStr .= "if(!function_exists('getPaginationUrl')){ \n";
		$funStr .= "  function getPaginationUrl(\$columnAlias){ \n";
		//$funStr .= "	require_once APP_MANAGER_PATH. '/mouldEngine/mouldEngineManager.php';";
		//$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "	\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		$funStr .= "    session_start();";
		$funStr .= "    \$siteId = \$_SESSION['siteId'];";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias,\"site_id\"=>\$siteId)); \n";
		$funStr .= "	\$config = SuperPHP::getConfig(); \n";
		$funStr .= "	if (\$getCData[1] > 0){ \n";
		$funStr .= "		\$columnId = \$getCData[0][0][\"parent_id\"]; \n";
		$funStr .= "		\$isActive = \$getCData[0][0][\"is_active\"] == \"1\"? true:false; \n";
		$funStr .= "	    \$isPage = \$getCData[0][0][\"is_page\"] == \"1\"? true:false; \n";
		$funStr .= "		if(\$isActive){ \n";
		$funStr .= "			\$result = 'op.php?m=" . $this->moduleName . "&c=' . \$columnAlias . \$config['listFilePre'] . '&%s'; \n";
		$funStr .= "		}else{ \n";
		$funStr .= "			if (\$isPage){ \n";
		$funStr .= "				\$result = \$columnAlias . \$config['listFilePre'] . '%s.html'; \n";
		$funStr .= "		    } \n";
		$funStr .= "		    if (!empty(\$columnId)){ \n";
		$funStr .= "		        getColumnParentLinkedUrl(\$columnId, \$result); \n";
		$funStr .= "		    } \n";
		$funStr .= "		} \n";
		$funStr .= "	} \n";
		$funStr .= "	return  \$result; \n";
		$funStr .= " }";
		$funStr .= "}";
		$funStr .= "if(!function_exists('getColumnParentLinkedUrl')){ \n";
		$funStr .= " function getColumnParentLinkedUrl(\$columnId, &\$sPath){ \n";
		//$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass(); \n";
		$funStr .= "	\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"row_id\"=>\$columnId)); \n";
		$funStr .= "	if (\$getCData[1] > 0){ \n";
		$funStr .= "		\$columnId = \$getCData[0][0][\"parent_id\"]; \n";
		$funStr .= "		\$columnAlias = \$getCData[0][0][\"column_alias\"]; \n";
		$funStr .= "		\$sPath = \$columnAlias . \"/\" . \$sPath; \n";
		$funStr .= "		if (!empty(\$columnId)){ \n";
		$funStr .= "			getColumnParentLinkedUrl(\$columnId, \$sPath); \n";
		$funStr .= "		} \n";
		$funStr .= "	} \n";
		$funStr .= " } \n";
		$funStr .= "} \n";
		$funStr .= "if(!function_exists('getColumnPageNum')){";
		$funStr .= "  function getColumnPageNum(\$columnAlias){";
		//$funStr .= "	require_once APP_MANAGER_PATH. '/mouldEngine/mouldEngineManager.php';";
		$funStr .= "	\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
		//$funStr .= "	\$contentObj = TMouldEngineManager::getContentClass();";
		$funStr .= "    session_start();";
		$funStr .= "    \$siteId = \$_SESSION['siteId'];";
		$funStr .= "	\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\$columnAlias,\"site_id\"=>\$siteId)); \n";
		$funStr .= "	\$config = SuperPHP::getConfig();";
		$funStr .= "	if (\$getCData[1] > 0){";
		$funStr .= "		\$pageNum = \$getCData[0][0][\"pageNum\"];";
		$funStr .= "	}";
		$funStr .= "	return  \$pageNum;";
		$funStr .= " }";
		$funStr .= "}";
		return $funStr;
	}
	/**
	 *
	 * 解析连接数据库标签
	 * @param 字符串 $module 标签模块名称
	 * @param array $paramArr 标签参数数组
	 */
	private function compileTagDao($module, $paramArr){
		/*return "<? require_once '../superphp/core/dao/sdao.php';\$dao = new SDao();\$data=\$dao->getDao()->db->get_all_sql(\"select * from t_moulds\");echo \"abc\";?>";*/
		//根据模块名和action查找属于哪个模型
		//获取首页模板id
		$tagClass = $this->_GetTagDao();// TMouldEngineManager::getTagClass();
		$getData = $tagClass->queryData(array("isQuerySub"=>"0", "query_filter"=>array("tag_name"=>$module, "tag_action"=>$paramArr["action"])));
		$tagId = $getData[0][0][row_id];
		$mouldId = $getData[0][0]["mould_id"];
		$dataResult = $getData[0][0]["tag_result"];
		$mouldTable = "";
		if (empty($mouldId)){    //$mouldId=0;表示标签没有对应模型表，属于模型引擎定义的表，此类标签对应表使用switch判断
			$mouldTable = $this->getSystemTagTable($module, $paramArr);
		}else {
			//获取模型对应的表
			$mouldClass = $this->_GetMouldDao();// TMouldEngineManager::getMouldClass();
			$getData = $mouldClass->queryData(array("isQuerySub"=>"0", "query_filter"=>array("row_id"=>$mouldId)));
			$mouldTable = $getData[0][0]["mould_table"];
		}
		if (!isset($paramArr["site_id"])){
			$getSession = $this->getUtil("session");
			$siteId = $getSession->get("siteId");
			$paramArr["site_id"] = $siteId;
		}
		//if (empty($mouldTable)){
		//	return "";
		//}
		//系统自动带上参数
		$this->addParam($paramArr);
		//过滤标签定义的参数
		$paramFilter = array();
		$getData = $tagClass->queryData(array("isQuerySub"=>"1", "query_filter"=>array("tag_id"=>$tagId)));
		foreach ($paramArr as $key=>$value){
			foreach ($getData[0] as $sValue){
				if ($key == $sValue["param_name"]){
					$paramFilter[$key] = $value;
					break;
				}
			}
		}

		if (!empty($paramArr["result"])){
			$dataResult = $paramArr["result"];
		}

		//生成连接数据库语句
		$daoStr = "<? date_default_timezone_set(PRC);";
		$daoStr = $daoStr . "require_once APP_MANAGER_PATH . '/../superphp/core/dao/sdao.php'; \n";
		$daoStr = $daoStr . $this->addFunc();      //加载函数库
		$daoStr = $daoStr . "\$dao = new SDao(); \n";

		if (empty($mouldTable)){
			if ($module == "System" && $paramArr["action"] == "allSearch"){
				if (substr($paramArr["alias"], 0, 1) == "$"){
					$daoStr .= "\$columnAlias=" . $paramArr["alias"] . "; \n";
					$daoStr .= "\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\");\n";
					$daoStr .= "\$getCData = \$contentObj->getAllTableOfAlias(\$columnAlias); \n";
					$daoStr .= "\$tableArr = array();";
					$daoStr .= "foreach (\$getCData as \$value){";
					$daoStr .= "	array_push(\$tableArr, \$value['mould_table']);";
					$daoStr .= "}";
					$daoStr .= "\$mouldTable = implode(',', \$tableArr);";
					$mouldTable = "\$mouldTable";
				}
			}else{
				//$daoStr .= "require_once APP_MANAGER_PATH . '/mouldEngine/mouldEngineManager.php'; \n";

				//$daoStr .= "\$contentObj = TMouldEngineManager::getContentClass(); \n";
				$daoStr .= "\$contentObj = SuperPHP::getDao(\"content\", \"" . $this->moduleName . "\"); \n";
				if (!empty($paramArr["column_id"])){
					$daoStr .= "\$getCData = \$contentObj->queryData(array(\"row_id\"=>" . $paramArr["column_id"] . ")); \n";
				}else{
					if (!empty($paramArr["site_id"])){
						$daoStr .= "\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\"" . $paramArr["column_alias"] . "\",\"site_id\"=>" . $paramArr["site_id"] . ")); \n";
					}else{
						$daoStr .= "\$getCData = \$contentObj->queryData(array(\"column_alias\"=>\"" . $paramArr["column_alias"] . "\")); \n";
					}
				}
					
				$daoStr .="if (\$getCData[1] > 0){ \n";
				$daoStr .="\$mouldId = \$getCData[0][0][\"mould_id\"]; \n";
				$daoStr .="}\n";
				//$daoStr .="\$mouldObj = TMouldEngineManager::getMouldClass(); \n";
				$daoStr .="\$mouldObj = SuperPHP::getDao(\"mould\", \"" . $this->moduleName . "\");\n";
				$daoStr .="\$getMData = \$mouldObj->queryData(array(\"isQuerySub\"=>\"0\", \"query_filter\"=>array(\"row_id\"=>\$mouldId))); \n";
				$daoStr .="\$getMData = array_filter(\$getMData); \n";
				$daoStr .="if(!empty(\$getMData)){ \n";
				$daoStr .="	\$mouldTable = \$getMData[0][0][\"mould_table\"]; \n";
				$daoStr .="}  \n";
				$mouldTable = "\$mouldTable";
			}
		}else{
			$mouldTable = "'" . $mouldTable . "'";
		}

		$funStr = "require_once APP_MANAGER_PATH . '/../superphp/core/controller/scontroller.php'; \n";
		$funStr .= $this->addSuperPhpFunc();  //super php的library中的函数库
		/*
		 $funStr = $funStr . "\$cObj = new SController();";
		 $funStr = $funStr . "\$dateObj = \$cObj->getLibrary('dateSuper');";
		 $funStr = $funStr . "\$pageObj = \$cObj->getLibrary('pageSuper');";
		 */
		//$queryStr = "select * from " . $mouldTable;   //以后需要给标签加操作类型，如select、update、delete
		//$index = 0;
		$pageNoStr = "\$pageNoTmp=1; \n";
		$pageNumStr = "\$pageNumTmp=99999999; \n";
		$sortKeyStr = "\$sortKeyTmp='row_id'; \n";
		$sortStr = "\$sortTmp='desc'; \n";
		$showKey = "\$showKey='*'; \n";
		if (!empty($paramArr["showKey"])){
			$showKey = "\$showKey='" . $paramArr["showKey"] . "'; \n";
		}
		$queryStr = "\$query_filterTmp=array(); \n";

		foreach ($paramFilter as $key=>$value){
			if ($key == "pageNo"){
				if (substr($value, 0, 1) == "$"){
					//$pageNoStr .= "if (!empty(" . $value . ")){";
					$pageNoStr .= "if (!(" . $value . "==='')){ \n";
					$pageNoStr .= "\$pageNoTmp=" . $value . "; \n";
					$pageNoStr .= "} \n";
				}else{
					$pageNoStr .= "\$pageNoTmp=" . $value . "; \n";
				}
			}else if ($key == "pageNum"){
				if (substr($value, 0, 1) == "$"){
					//$pageNumStr .= "if (!empty(" . $value . ")){";
					$pageNumStr .= "if (!(" . $value . "==='')){ \n";
					$pageNumStr .= "\$pageNumTmp=" . $value . "; \n";
					$pageNumStr .= "} \n";
				}else{
					$pageNumStr .= "\$pageNumTmp=" . $value . "; \n";
				}
			}else if ($key == "sortKey"){
				$sortKeyStr = "\$sortKeyTmp=" . $value . "; \n";
			}else if ($key == "sort"){
				$sortStr = "\$sortTmp=" . $value . "; \n";
			}else{
				if (substr($value, 0, 1) == "$"){
					$sepArr = explode('@', $value);
					//$queryStr .= "if (!empty(" . $sepArr[0] . ")){";
					$queryStr .= "if (!(" . $sepArr[0] . "==='')){ \n";
					$queryStr .= "\$valueArr=array();";

					if (count($sepArr) > 1){
						$queryStr .= "\$valueArr[" . $sepArr[0] . "]='" . $sepArr[1] . "'; \n";
					}else{
						$queryStr .= "\$valueArr[" . $sepArr[0] . "]=''; \n";
					}

					$queryStr .= "\$query_filterTmp['" . $key . "']=\$valueArr; \n";
					$queryStr .= "}";
				}else{
					if (!($value==='')){
						$queryStr .= "\$valueArr=array(); \n";

						$sepArr = explode('@', $value);
						if (count($sepArr) > 1){
							$queryStr .= "\$valueArr['" . $sepArr[0] . "']='" . $sepArr[1] . "'; \n";
						}else{
							$queryStr .= "\$valueArr['" . $sepArr[0] . "']=''; \n";
						}
							
						$queryStr .= "\$query_filterTmp['" . $key . "']=\$valueArr; \n";
					}
				}
			}
		}
		$queryStr .= "if (!isset(\$query_filterTmp['is_delete'])){ \n";
		$queryStr .= "   \$valueArr=array(); \n";
		$queryStr .= "   \$valueArr['0']=''; \n";
		$queryStr .= "   \$query_filterTmp['is_delete']= \$valueArr;\n";
		$queryStr .= "} \n";

		$offsetStr = "\$offsetTmp=(\$pageNoTmp - 1) * \$pageNumTmp; \n";
		//$sqlStr = "\$resultCount=\$dao->getDao()->db->get_count(" . $mouldTable . ",\$query_filterTmp" . ");";
		$sqlStr .= "\$" . $dataResult . " = \$dao->get_all(" . $mouldTable . ",\$pageNumTmp,\$offsetTmp,\$query_filterTmp,\$sortKeyTmp,\$sortTmp,\$showKey);";
		//$sqlStr .= "array_push(" . "\$" . $dataResult . ","  . "\$resultCount);";
		$daoStr = $daoStr . $funStr . $pageNoStr . $pageNumStr . $sortKeyStr . $sortStr . $showKey . $queryStr . $offsetStr . $sqlStr;
		//"\$" . $dataResult . " = \$" . $dataResult . "[0];";
		$daoStr = $daoStr . "?>";

		return $daoStr;
	}
	/**
	 *
	 * 直接加载SQL标签
	 * @param unknown_type $module
	 * @param unknown_type $paramArr
	 */
	public function compileTagForSql($module, $paramArr){
		$dataResult = "data";
		if (!empty($paramArr["result"])){
			$dataResult = $paramArr["result"];
		}
		if (empty($paramArr["sql"])){
			return "";
		}
		$sql = $paramArr["sql"];
		//生成连接数据库语句
		$daoStr = "<?";
		$daoStr .= "require_once APP_MANAGER_PATH . '/../superphp/core/dao/sdao.php'; \n";
		$daoStr .=  $this->addFunc();      //加载函数库
		$daoStr .= "require_once APP_MANAGER_PATH . '/../superphp/core/controller/scontroller.php'; \n";
		$daoStr .= $this->addSuperPhpFunc();  //super php的library中的函数库
		$daoStr .=  "\$dao = new SDao();\n";
		$daoStr .= "\$" . $dataResult . " = \$dao->getDao()->db->get_all_sql(" . $sql . ");";
		$daoStr .= "?>";
		return $daoStr;
	}
	/**
	 *
	 * 直接调用插件方法标签
	 * @param unknown_type $module
	 * @param unknown_type $paramArr
	 */
	public function compileTagForPlugin($module, $paramArr){
		$dataResult = "data";
		if (!empty($paramArr["result"])){
			$dataResult = $paramArr["result"];
		}
		if (empty($paramArr['p']) || empty($paramArr['m']) || empty($paramArr['c']) || empty($paramArr['a'])){
			return "";
		}
		$pm = $paramArr['pm'];
		$p = $paramArr['p'];
		$m = $paramArr['m'];
		$c = $paramArr['c'];
		$a = $paramArr['a'];
		//调用插件方法
		$pluginStr = "<?";
		$pluginStr .=  $this->addFunc();      //加载函数库
		$pluginStr .= "require_once APP_MANAGER_PATH . '/../superphp/core/controller/scontroller.php'; \n";
		$pluginStr .= $this->addSuperPhpFunc();  //super php的library中的函数库
		$http = 'https';
		if (empty($_SERVER['HTTPS'])){
			$http = 'http';
		}
		$http = $http . "://"  . $_SERVER['HTTP_HOST'] . ':'  . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];
		$pluginStr .= "\$pluginUrl = '" . $http . "/../plugin.php?pm=$pm&p=$p&m=$m&c=$c&a=$a" . "';\n";
		$pluginParam = "\$paramArr=array();\n";
		foreach ($paramArr as $key=>$value){
			if ($key == 'p' || $key == 'm' || $key == 'c' || $key =='a' || $key =='result'){
				continue;
			}
			if (substr($value, 0, 1) == "$"){
				$pluginParam .= "\$paramArr['" . $key . "']=" . $value . ";\n";
			}else{
			    $pluginParam .= "\$paramArr['" . $key . "']='" . $value . "';\n";
			}
		}
		$pluginStr .= $pluginParam;
		$pluginStr .= "\$getData = \$curlObj->post(\$pluginUrl, \$paramArr);\n";
		$pluginStr .= "\$" . $dataResult . " = json_decode(\$getData, true);\n";

		$pluginStr .= "?>";
		return $pluginStr;
	}
	/**
	 *
	 * 插件标签
	 * @param unknown_type $module
	 * @param unknown_type $paramArr
	 */
	public function compileTagPlugin($module, $paramArr){
		if (empty($paramArr["action"]) || empty($paramArr["c"]) || empty($paramArr["a"])){
			return "";
		}
		if (empty($paramArr["m"])){
			$m = "app";
		}
		$plugin = $paramArr["action"];
		$c = $paramArr["c"];
		$a = $paramArr["a"];
		$pm = $paramArr["pm"];
		//$result = "../../admin/plugin/" . $this->moduleName . "/" . $plugin . "/?m=" . $m . "&c=" . $c . "&a=" . $a;
		if (empty($pm)){
			$result = "plugin.php?p=" . $plugin . "&m=" . $m . "&c=" . $c . "&a=" . $a;
		}else{
			$result = "plugin.php?p=" . $plugin . "&pm=" . $pm . "&m=" . $m . "&c=" . $c . "&a=" . $a;
		}
		
		//$result = "../../admin?m=" . $this->moduleName . "&c=plugin&a=runPlugin&pl=" . $plugin . "&tm=" . $m . "&tc=" . $c . "&ta=" . $a;
		return $result;
	}
	/**
	 *
	 * 加入super php中的library中的函数库
	 */
	private function addSuperPhpFunc(){
		$funStr = "\$cObj = new SController();\n";
		$funStr .= "\$dateObj = \$cObj->getLibrary('dateSuper');\n";
		$funStr .= "\$pageObj = \$cObj->getLibrary('pageSuper');\n";
		$funStr .= "\$stringObj = \$cObj->getLibrary('stringSuper');\n";
		$funStr .= "\$curlObj = \$cObj->getLibrary('curl');\n";
		return $funStr;
	}

	/**
	 *
	 * 获取系统标签，由模型引擎定义的表
	 */
	private function getSystemTagTable($module, &$paramArr){
		$getSession = $this->getUtil("session");
		$siteId = $getSession->get("siteId");
		$mouldTable = "";
		if ($module == "System"){
			switch ($paramArr["action"]){
				case "getColumn":         //获取栏目
					if (!isset($paramArr["site_id"])){
						$paramArr["site_id"] = $siteId;
					}
					if (!isset($paramArr["is_delete"])){
						$paramArr["is_delete"] = "0";
					}
					$mouldTable = $this->contentTable;// "t_contents";
					break;
				case "getContentList":    //获取栏目内容列表
					if (!isset($paramArr["is_delete"])){
						$paramArr["is_delete"] = "0";
					}
					break;
				case "allSearch":         //全文检索
					if (substr($paramArr["alias"], 0, 1) != "$"){
						$columnAlias = $paramArr["alias"];
						$contentDao = $this->_GetContentDao();
						$getData = $contentDao->getAllTableOfAlias($columnAlias);
						$tableArr = array();
						foreach ($getData as $value){
							array_push($tableArr, $value["mould_table"]);
						}
						$mouldTable = implode(',', $tableArr);
					}
					break;
			}
		}
		return $mouldTable;
	}
	/**
	 * 系统自动带上参数
	 */
	private function addParam(&$paramArr){
		//if (array_key_exists("account_id", $paramArr)){
		if (isset($paramArr["account_id"]) && empty($paramArr["account_id"])){
			$getSession = $this->getUtil("session");
			$accountData = $getSession->get("accountData");
			$accountId = $accountData["siteId"];
			$paramArr["account_id"] = $accountId;
		}
		//}
	}
	/**
	 *
	 * 系统字符替换(把模板中的模块替换成编译后的路径，
	 * 如：<!--[include "footer_template.html"]--> 转化成<!--[include "template_c/siteTemplate/xsww/footer_template.tpl.php"]-->
	 */
	private function sysStrReplace($str, $left, $right){
		//$getSession = $this->getUtil("session");
		//$siteAlias = $getSession->get("siteAlias");
		/*
		 $accountData = $getSession->get("accountData");
		 $siteNameEn = $accountData["account_name_en"];
		 */
		$result = $str;
		//preg_match_all("/<!--\[\s*include\s+[\'\"](.*)[\'\"]\s*\]-->/", $result, $m);
		preg_match_all("/".preg_quote($left). "(\s*include\s+[\'\"](.*)[\'\"]\s*)" . preg_quote($right) ."/", $result, $m);

		for($i=0; $i<count($m[1]); $i++){
			$allStr = $m[1][$i];  //匹配得到的全字符
			$module = $m[2][$i];  //模块名称

			$strArr = explode(":", $module, 2);
			if (count($strArr) > 1){
				$fileNameArr = explode('.', $strArr[1]);
				$fileName = $fileNameArr[0];
				//$templateFileTmp = "siteTemplate/" . $strArr[0] . "/" . $fileName . ".tpl.php";
				$templateFileTmp = $strArr[0] . "/" . $fileName . ".tpl.php";
			}else{
				$fileNameArr = explode('.', $strArr[0]);
				$fileName = $fileNameArr[0];
				$templateFileTmp = $fileName . ".tpl.php";
			}
			$config = SuperPHP::getConfig();
			if (!empty($this->siteAlias)){
				$templateFileTmp = $config['siteTemplateDir'] . "/" . $this->siteAlias . "/" . $templateFileTmp;
			}

			$result = preg_replace("/".preg_quote($left). preg_quote($allStr) . preg_quote($right) ."/", $left . "include \"" . $config['template']['template_c_path'] . "/" . $templateFileTmp . "\"" . $right, $result);

			//$result = str_replace($allStr, $left . "include \"" . $config['template']['template_path'] . "/" . $templateFile . "\"" . $right, $result);
		}
		//$result = preg_replace("/(<!--\[\s*include\s+[\'\"]\s*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_$\x7f-\xff\[\]\'\']*)\.?.*(\s*[\'\"]\s*\]-->)/","\\1.tpl.php\\2", $str);
		return $result;
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
	private function _GetTagDao(){
		return SuperPHP::getDao("tag", $this->moduleName);
	}
}
