<?php
$config = SuperPHP::getConfig();
define("ADDRESS",$config['dbUrl']);
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
class basicController extends SController{

    //查询数据分类定义
    private $getClassification;
    //查询数据元定义
    private $getMetadata;

	function __construct() {
		
        //查询数据分类定义
        $this->getClassification="http://".ADDRESS."/cgi-bin/metadata/classification/get?access_token=%s";
        //查询数据元定义
        $this->getMetadata="http://".ADDRESS."/cgi-bin/metadata/metadata/get?access_token=%s";

	}

	/**
	 * 数据分类
	 *
	 */
	public function getClassification($arr){

		$url =  sprintf($this->getClassification,$arr['access_token']);

		if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
			$url.="&row_id=".urlencode($arr["row_id"]);
		}
		if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
			$url.="&pageNo=".urlencode($arr["pageNo"]);
		}
		if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
			$url.="&pageNum=".urlencode($arr["pageNum"]);
		}

		if(!empty($arr["code"])&&($arr["code"])!=""){
			$url.="&code=".urlencode($arr["code"]);
		}

		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}

	/**
	 * 元数据
	 *
	 */
	public function getMetadata($arr){

		$url =  sprintf($this->getMetadata,$arr['access_token']);

		if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
			$url.="&row_id=".urlencode($arr["row_id"]);
		}
		if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
			$url.="&pageNo=".urlencode($arr["pageNo"]);
		}
		if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
			$url.="&pageNum=".urlencode($arr["pageNum"]);
		}


		if(!empty($arr["classification_id"])&&($arr["classification_id"])!=""){
			$url.="&classification_id=".urlencode($arr["classification_id"]);
		}
		if(!empty($arr["show_type"])&&($arr["show_type"])!=""){
			$url.="&show_type=".urlencode($arr["show_type"]);
		}


		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}









	public function post($url,$data){
		$postdata = http_build_query(
				$data
		);
		$opts = array('http' =>
				array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded;charset=UTF-8',
						'content' => $postdata
							
				)
					
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($url, false, $context);
		return $result;
	}
}