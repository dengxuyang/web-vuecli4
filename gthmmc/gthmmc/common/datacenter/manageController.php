<?php
$config = SuperPHP::getConfig();
define("ADDRESS",$config['dbUrl']);
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
class basicController extends SController{

    //查询数据类型定义
    private $getDatatype;
    //新增数据类型定义
    private $addDatatype;
    //修改数据类型定义
    private $modifyDatatype;
    //删除数据类型定义
    private $deleteDatatype;

    //查询会员
    private $getMember;
    private $addMember;
    private $modifyMember;
    private $deleteMember;

	function __construct() {

        //查询数据类型定义
        $this->getDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/get?access_token=%s";
        //新增数据类型定义
        $this->addDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/add";
        //修改数据类型定义
        $this->modifyDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/modify";
        //删除数据类型定义
        $this->deleteDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/delete?access_token=%s&row_id=%s";

        //查询会员
        $this->getMember="http://".ADDRESS."/cgi-bin/manage/member/get?access_token=%s";
        $this->addMember="http://".ADDRESS."/cgi-bin/manage/member/add?access_token=%s";
        //修改会员
        $this->modifyMember="http://".ADDRESS."/cgi-bin/manage/member/modify";
        //删除会员
        $this->deleteMember="http://".ADDRESS."/cgi-bin/manage/member/delete?access_token=%s&row_id=%s";

	}

	/**
	 * 数据类型
	 *
	 */
	public function getDatatype($arr){

		$url =  sprintf($this->getDatatype,$arr['access_token']);

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
		if(!empty($arr["type"])&&($arr["type"])!=""){
			$url.="&type=".urlencode($arr["type"]);
		}
		if(!empty($arr["metadata_id"])&&($arr["metadata_id"])!=""){
			$url.="&metadata_id=".urlencode($arr["metadata_id"]);
		}
	    if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	public function addDatatype($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addDatatype, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	public function modifyDatatype($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->modifyDatatype, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);

	}
	public function deleteDatatype($arr){
		$access_token =$arr['access_token'];
		$row_id = $arr["row_id"];
		$url =  sprintf($this->deleteDatatype,$access_token,$row_id);
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
    /**
      * 获取会员
      *
      */
    public function getMember($arr){
        $url =  sprintf($this->getMember,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }

        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["account"])&&($arr["account"])!=""){
            $url.="&account=".urlencode($arr["account"]);
        }
        if(!empty($arr["password"])&&($arr["password"])!=""){
            $url.="&password=".urlencode($arr["password"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
    * 新增会员
    *
    */
    public function addMember($arr,$return){
        $getData = $this->post($this->addMember, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 修改会员
     *
     */
    public function modifyMember($arr){

    	$getData = $this->post($this->modifyMember, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);

    }
    /**
     * 删除会员
     *
     */
    public function deleteMember($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteMember,$access_token,$row_id);
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