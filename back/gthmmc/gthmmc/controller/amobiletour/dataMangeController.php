<?php
header("Access-Control-Allow-Origin:*");
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
require_once dirname(__FILE__) . '/../../common/log.php';
require_once dirname(__FILE__) . '/common.php';
require_once dirname(__FILE__) . '/../../common/datacenter_cloud.php';
//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__) . '/../../logs/'.date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class dataMangeController extends SController{
	private $WCommon;
	private $destination_id;
  	private $code_standard;
	private $code_resource;
	private $code_model;
	private $code_modeltable;

	function __construct() {
		parent::__construct();
		$this->SetWhiteList(array('queryResourceTree', 'queryResource', 'addResource',
								  'modifyResource', 'deleteResource', 'queryResourceField', 'queryDataOfResource',
									'addDataOfResource', 'modifyDataOfResource', 'deleteDataOfResource',
								  'getstandard','addstandard','deletestandard','modifystandard',
								  'queryModelTree', 'addModel', 'modifyModel', 'deleteModel',
								  'queryModelTable','getResourcefield','addResourcefield',
								  'deleteResourcefield','modifyResourcefield','outputplan',
								  'addModelTable','modifyModelTable','deleteModelTable','inputWork',
								  'outputplanmodel','completeStatisticsdata',
								  'activeStatisticsdata','deletebatchdata','modifybatchData','requestbodytest',
									'addlog'
								));
		date_default_timezone_set(PRC);
		$this->WCommon = new WCommon();
		$this->datacenter = new datacenterCloud();
		$this->code_standard='standard';
		$this->code_resource='resourcedirectory';
		$this->code_model='dataModel';
		$this->code_modeltable='dataModelfield';
	}
	public function before(){
//		$this->WCommon->ssoCheck();
//		$getUser = $this->WCommon->getUser();
		$this->destination_id=600;
		$this->logArr['system']="TBDMS";
		$this->logArr['destination_id']=$this->destination_id;
		$this->logArr['account']= 'admin';
		$this->logArr['name']= '系统管理员';
	}


	public function addlog($con){
				$content='系统操作';
				if(!empty($con)){
						$content=$con;
				}
				$this->logArr['content']=$content;
				$ip='127.0.1';
				if(!empty( $_SERVER["REMOTE_ADDR"])){
					$ip= $_SERVER["REMOTE_ADDR"];
				}
				$this->logArr["ip"] = $ip;
				$this->datacenter->addresources($this->logArr,"log");
  }
	/**
	 *
	 * 查询资源数据-树型结构
	 */
	public function queryResourceTree(){
		$pageNo = 1;
		$pageNum = 999;
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data['destination_id']=$this->destination_id;
		$data['order_by']="row_id asc";


		$directory_code=$this->code_resource;
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";

		$res = $this->datacenter->getresources($data, $directory_code, $pageNo, $pageNum);
		if (!empty($res) && $res["errcode"] == 0){
			$alldata=$res["data"]["list"];
			$res = $this->queryResourceTreeData(0,$alldata);
			$responce["data"] = $res;
			$responce["alldata"] = $alldata;
			$responce["errcode"] = 0;
		}
		echo json_encode($responce);
	}
	private function queryResourceTreeData($parent_id,$alldata){
		$getData = $this->search_resource($parent_id,$alldata);
		$getData = array_filter($getData);

		if (!empty($getData)){
			$i=0;
			foreach ($getData as $value){
					$responce[$i]=new stdClass();
					$responce[$i]->label = $value["name"];
					$responce[$i]->row_id = $value["row_id"];
					$responce[$i]->name = $value["name"];
					$responce[$i]->code = $value["code"];
					$responce[$i]->table_name = $value["table_name"];
					$responce[$i]->description = $value["description"];
					$responce[$i]->remark = $value["remark"];
					$responce[$i]->parent_id = $value["parent_id"];
					$responce[$i]->is_edit = $value["is_edit"];
					$responce[$i]->is_map = $value["is_map"];
					$responce[$i]->is_relation = $value["is_relation"];
					$responce[$i]->is_statistics = $value["is_statistics"];
					$responce[$i]->is_check = $value["is_check"];
					$responce[$i]->tableDisabled = $value["table_name"]!='';
					$responce[$i]->isInput = false;
					$parentId1 = $value["row_id"];
					//查询子结点
					 $responce[$i]->children = $this->queryResourceTreeData($parentId1,$alldata);
					$i++;
			}
		}
		return $responce;
	}
	//查询资源数据
	public function queryResource(){
		
		$pageNo = $this->controller->get_gp("pageNo");
		$pageNum = $this->controller->get_gp("pageNum");
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data['destination_id']=$this->destination_id;
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$res = $this->datacenter->getresources($data, $this->code_resource, $pageNo, $pageNum);
		if (!empty($res) && $res["errcode"] == 0){
			$responce["total"] = $res["data"]["total"];
			$responce["data"] = $res["data"]["list"];
			$responce["errcode"] = 0;
		}else{
			$responce["errMsg"] = $res["errMsg"];
		}
		echo json_encode($responce);
	}
	//新增资源数据
	public function addResource(){
		$data = $this->controller->get_gp("data"); //数据
		$data = stripslashes($data);
		$data = json_decode($data,true);

		$responce["errcode"] = -1;
		if (empty($data["name"])){
			$responce["errMsg"] = "资源名称不能为空";
			echo json_encode($responce);
			return;
		}
		if (empty($data["code"])){
			$responce["errMsg"] = "资源编码不能为空";
			echo json_encode($responce);
			return;
		}
		if (empty($data["table_name"])){
			$responce["errMsg"] = "资源表名不能为空";
			echo json_encode($responce);
			return;
		}
		//去除多余结构
		unset($data["children"]);
		$res = $this->datacenter->addResources($data, $this->code_resource);
		Log::DEBUG("新增资源数据返回：" . json_encode($res));
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"]["result"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	//修改资源数据
	public function modifyResource(){
		$data = $this->controller->get_gp("data"); //数据
		$data = stripslashes($data);
		$data = json_decode($data,true);

		 //$data=array_filter($data);

		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		if (empty($data["row_id"])){
			$responce["errMsg"] = "id不能为空";
			echo json_encode($responce);
			return;
		}
		if (empty($data["name"])){
			$responce["errMsg"] = "资源名称不能为空";
			echo json_encode($responce);
			return;
		}
		if (empty($data["code"])){
			$responce["errMsg"] = "资源编码不能为空";
			echo json_encode($responce);
			return;
		}
		// if (empty($data["table_name"])){
		// 	$responce["errMsg"] = "资源表名不能为空";
		// 	echo json_encode($responce);
		// 	return;
		// }

		unset($data["isInput"]);
		unset($data["children"]);
		unset($data["label"]);
		unset($data["row_id"]);
		unset($data["tableDisabled"]);
		$res = $this->datacenter->modifyresources($data, $this->code_resource, $row_id);
		Log::DEBUG("修改资源数据返回：" . json_encode($res));
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	//删除资源数据
	public function deleteResource(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		if (empty($data["row_id"])){
			$responce["errMsg"] = "row_id不能为空";
			echo json_encode($responce);
			return;
		}
		$res = $this->datacenter->deleteresources($row_id, $this->code_resource);
		Log::DEBUG("删除资源数据返回：" . json_encode($res));
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	/**
	 *
	 * 查询资源字段数据
	 */
	public function queryResourceField(){
		//TODO
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		/*
		$res = $this->datacenter->getresources($data, $directory_code, $pageNo, $pageNum);
		if (!empty($res) && $res["errcode"] == 0){
			$alldata=$res["data"]["list"];
			$res = $this->queryResourceTreeData(0,$alldata);
			$responce["data"] = $res;
			$responce["errcode"] = 0;
		}*/
		//测试数据
		for($i=0;$i<5;$i++){
			$res[$i]["row_id"] = $i;
			$res[$i]["id"] = $i;
			$res[$i]["name"] = "名称名称" . $i;
			$res[$i]["en_name"] = "name" . $i;
			$res[$i]["code"] = "varchar";
			$res[$i]["constraint"] = "1";
			$res[$i]["type"] = 6;
			$res[$i]["is_edit"] = "1"; //是否可编辑
			$res[$i]["is_intable"] = rand(0, 1);  //是否显示在表格中
			$res[$i]["associate"] = "travel_agency";
		}
		$responce["data"] = $res;
		$responce["errcode"] = 0;
		//
		echo json_encode($responce);
	}

	//查询资源对应数据
	public function queryDataOfResource(){
		$pageNo = $this->controller->get_gp("pageNo");
		$pageNum = $this->controller->get_gp("pageNum");
		$directory_code = $this->controller->get_gp("directory_code");
		$data = $this->controller->get_gp("data");
		$str = stripslashes($data);
		$data = json_decode($str,true);
		$data['destination_id']=$this->destination_id;

		$response["errcode"] = -1;
		$response["errMsg"] = "";
		$res = $this->datacenter->getresources($data, $directory_code, $pageNo, $pageNum);
		if (!empty($res) && $res["errcode"] == 0){
			$response["total"] = $res["data"]["total"];
			$response["data"] = $res["data"]["list"];
			$response["directory_code"] = $directory_code;
			$response["errcode"] = 0;
		}else{
			$response["errMsg"] = $res["errmsg"];
		}
		/*
		//测试数据
		for($i=0;$i<100;$i++){
			$resData[$i]["row_id"] = $i;
			$resData[$i]["name"] = "测试";
			$resData[$i]["name1"] = "https://www.baidu.com/img/flexible/logo/pc/result@2.png";
			$resData[$i]["name2"] = "测试2";
			$resData[$i]["name3"] = "测试3";
		}
		$responce["total"] = 100;
		$responce["data"] = $resData;
		$responce["errcode"] = 0;*/
		//
		echo json_encode($response);

	}
	//新增资源对应数据
	public function addDataOfResource(){
		$params = file_get_contents('php://input');
		$params = json_decode($params, TRUE);
		$data = $params['data'];
		$directory_code =$params['directory_code'];
		$data['destination_id']=$this->destination_id;
		$responce["errCode"] = 0; //TODO
		$responce["errMsg"] = "";
		$res = $this->datacenter->addresources($data, $directory_code);
		if (!empty($res) && $res["errCode"] == 0){
			$responce["errCode"] = 0;
			$responce["data"] = $res["data"]["result"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		if($params['params']['currenttreeName']!=''){
			$this->addlog('新增'.$params['params']['currenttreeName']);
		}
		echo json_encode($responce);
	}
	//修改资源对应数据
	public function modifyDataOfResource(){
		//$data = $this->controller->get_gp("data"); //数据
		$params = file_get_contents('php://input');
		$params = json_decode($params, TRUE);
		$data = $params['data'];
		$directory_code =$params['directory_code'];
		// $data = stripslashes($data);
		// $data = json_decode($data,true);
		$data["destination_id"] = $this->destination_id; //目的地id
		$responce["errCode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		//foo 之前为 $this->resourceCode 邓旭阳修改 20201208 10:16
		$res = $this->datacenter->modifyresources($data, $directory_code, $row_id);
		if (!empty($res) && $res["errCode"] == 0){
			$responce["errCode"] = 0;
			$responce["data"] = $res["data"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		if($params['params']['currenttreeName']!=''){
			$this->addlog('修改'.$params['params']['currenttreeName']);
		}
		
		echo json_encode($responce);
	}
	//删除资源对应数据
	public function deleteDataOfResource(){
		$data = $this->controller->get_gp("data");
		$directory_code = $this->controller->get_gp("directory_code");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$responce["errCode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		if (empty($data["row_id"])){
			$responce["errMsg"] = "row_id不能为空";
			echo json_encode($responce);
			return;
		}
		//foo 之前为 $this->resourceQysbn 邓旭阳修改 20201208 10:22
		$res = $this->datacenter->deleteresources($row_id, $directory_code);
		if (!empty($res) && $res["errCode"] == 0){
			$responce["errCode"] = 0;
			$responce["data"] = $res["data"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		if($data['currenttreeName']!=''){
			$this->addlog('删除'.$data['currenttreeName']);
		}
		echo json_encode($responce);
	}
	private function search_resource($parent_id,$alldata){
		$newarr = array();
		for ($i=0;$i<count($alldata);$i++){
			if($alldata[$i]['parent_id']==$parent_id){
				array_push($newarr, $alldata[$i]);
			}
		}
	 	return $newarr;
   	}
	/**
	 *
	 * 获取数据列表
	 */
	 public function getstandard(){
			 $pageNo = $this->controller->get_gp("pageNo");
			 $pageNum = $this->controller->get_gp("pageNum");
			 $data = $this->controller->get_gp("data");
			 $data = stripslashes($data);
			 $data = json_decode($data,true);
			 $data['destination_id']=$this->destination_id ;
		   $directory_code=$this->code_standard;
			 $getData=$this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum);
      echo json_encode($getData);
	 }

	/**
	 *
	 * 新增数据
	 */
	public function addstandard(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data['destination_id']=$this->destination_id ;
		$directory_code=$this->code_standard;
		$getData=$this->datacenter->addresources($data,$directory_code);
		echo json_encode($getData);
	}

	/**
	 *
	 * 修改数据
	 */
	public function modifystandard(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$directory_code=$this->code_standard;
		$row_id= $this->controller->get_gp("row_id");
		$getData=$this->datacenter->modifyresources($data,$directory_code,$row_id);
		echo json_encode($getData);
	}
	/**
	 *
	 * 回收数据
	 */
	public function deletestandard(){
		$directory_code=$this->code_standard;
		$row_id= $this->controller->get_gp("row_id");
		if(!empty($row_id)){
      	$getData=$this->datacenter->deleteresources($row_id,$directory_code);
		}
		echo json_encode($getData);
	}
	/**
	 *
	 * 查询模型数据-树型结构
	 */
	public function queryModelTree(){
		$pageNo = 1;
		$pageNum = 999;
		$data['destination_id']=$this->destination_id;
		$data['order_by']="row_id asc";
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$res = $this->datacenter->getresources($data, $this->code_model, $pageNo, $pageNum);
		// 测试数据
		// unset($res);
		// $res["errcode"] = 0;
		// $res["data"]["list"][0] = array(row_id => 1, label =>"景区景点", name => "景区景点", parent_id => 0);
		// $res["data"]["list"][1] = array(row_id => 2, label =>"景区景点表", name => "景区景点表", parent_id => 1);
		// $res["data"]["list"][2] = array(row_id => 3, label =>"景区景点", name => "景区景点", parent_id => 0);
		// $res["data"]["list"][3] = array(row_id => 4, label =>"景区景点", name => "景区景点", parent_id => 0);
		// $res["data"]["list"][4] = array(row_id => 5, label =>"景区景点", name => "景区景点", parent_id => 0);

		if (!empty($res) && $res["errcode"] == 0){
			$alldata=$res["data"]["list"];
			$res = $this->queryModelTreeData(0, $alldata);
			$responce["data"] = $res;
			$responce["errcode"] = 0;
		}
		echo json_encode($responce);
	}
	private function queryModelTreeData($parent_id,$alldata){
		$getData = $this->search_resource($parent_id,$alldata);
		$getData = array_filter($getData);
		if (!empty($getData)){
			$i=0;
			foreach ($getData as $value){
				$responce[$i]=new stdClass();
				$responce[$i]->label = $value["title"];
				$responce[$i]->row_id = $value["row_id"];
				$responce[$i]->parent_id = $value["parent_id"];
				$responce[$i]->type = $value["type"];
				$responce[$i]->isInput = false;
				$parentId1 = $value["row_id"];
				//查询子结点
			 	$responce[$i]->children = $this->queryModelTreeData($parentId1,$alldata);
				$i++;
			}
		}
		return $responce;
	}
	//新增模型数据
	public function addModel(){
		$data = $this->controller->get_gp("data"); //数据
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data["destination_id"] = $this->destination_id; //目的地id
		$responce["errcode"] = -1;
		if (empty($data["title"])){
			$responce["errMsg"] = "模型名称不能为空";
			echo json_encode($responce);
			return;
		}
		$res = $this->datacenter->addResources($data, $this->code_model);
		//测试数据 TODO
		// unset($res);
		// $res["errcode"] = 0;
		// $res["data"]["result"] =  rand(20, 1000);
		//
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"]["result"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	//修改模型数据
	public function modifyModel(){
		$data = $this->controller->get_gp("data"); //数据
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data["destination_id"] = $this->destination_id; //目的地id
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		if (empty($data["row_id"])){
			$responce["errMsg"] = "row_id不能为空";
			echo json_encode($responce);
			return;
		}
		if (empty($data["title"])){
			$responce["errMsg"] = "模型名称不能为空";
			echo json_encode($responce);
			return;
		}
		$res = $this->datacenter->modifyresources($data, $this->code_model, $row_id);
		//测试数据 TODO
		unset($res);
		$res["errcode"] = 0;
		$res["data"]["result"] =  1;
		//
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"]["result"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	//删除模型数据
	public function deleteModel(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$row_id = $data["row_id"];
		if (empty($data["row_id"])){
			$responce["errMsg"] = "row_id不能为空";
			echo json_encode($responce);
			return;
		}
		$res = $this->datacenter->deleteresources($row_id, $this->code_model);
		//测试数据 TODO
		unset($res);
		$res["errcode"] = 0;
		$res["data"]["result"] =  1;
		//
		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"]["result"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	//查询模型字段数据
	public function queryModelTable(){
		$pageNo = $this->controller->get_gp("pageNo");
		$pageNum = $this->controller->get_gp("pageNum");
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data['destination_id']=$this->destination_id;
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$res = $this->datacenter->getresources($data, $this->code_modeltable, $pageNo, $pageNum);
		// 测试数据
		// unset($res);
		// $res["errcode"] = 0;
		// $res["data"]["list"][0] = array(row_id => 1, name =>'标题', en_name =>'title', code =>'title', type=>'varchar(200)',constraint=>'1',show_type=>'1');
		// $res["data"]["list"][1] = array(row_id => 2, name =>'摘要', en_name =>'depict', code =>'depict', type=>'text',constraint=>'0',show_type=>'2');
		// $res["data"]["list"][2] = array(row_id => 3, name =>'图片', en_name =>'image', code =>'image', type=>'varchar(255)',constraint=>'0',show_type=>'5');
		// $res["data"]["list"][3] = array(row_id => 4, name =>'标题', en_name =>'title', code =>'title', type=>'varchar(200)',constraint=>'1',show_type=>'1');
		// $res["data"]["list"][4] = array(row_id => 5, name =>'标题', en_name =>'title', code =>'title', type=>'varchar(200)',constraint=>'1',show_type=>'1');
		// $res["data"]["total"] = 5;
		//
		if (!empty($res) && $res["errcode"] == 0){
			$responce["total"] = $res["data"]["total"];
			$responce["data"] = $res["data"]["list"];
			$responce["errcode"] = 0;
		}else{
			$responce["errMsg"] = $res["errMsg"];
		}
		echo json_encode($responce);
	}
/**
	 *
	 * 新增模型字段数据
	 */
	public function addModelTable(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data['destination_id']=$this->destination_id ;
		//$directory_code=$this->code_standard;
		$getData=$this->datacenter->addresources($data,$this->code_modeltable);
		echo json_encode($getData);
	}

	/**
	 *
	 * 修改数据
	 */
	public function modifyModelTable(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$directory_code=$this->code_standard;
		$row_id= $this->controller->get_gp("row_id");
		$getData=$this->datacenter->modifyresources($data,$this->code_modeltable,$row_id);
		echo json_encode($getData);
	}
	/**
	 *
	 * 回收数据
	 */
	public function deleteModelTable(){
		$directory_code=$this->code_standard;
		$row_id= $this->controller->get_gp("row_id");
		if(!empty($row_id)){
      	$getData=$this->datacenter->deleteresources($row_id,$this->code_modeltable);
		}
		echo json_encode($getData);
	}




	/**
	 *
	 * 获取数据列表
	 */
	 public function getResourcefield(){
			 $pageNo = $this->controller->get_gp("pageNo");
			 $pageNum = $this->controller->get_gp("pageNum");
			 $data = $this->controller->get_gp("data");
		   	 $directory_code= $this->controller->get_gp("directory_code");
      		 $type='3';
			 $data = stripslashes($data);
	 	 	 $data = json_decode($data,true);
		  	 $data['is_delete']="0" ;
			 $getData=$this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum,$type);
      echo json_encode($getData);
	 }

	/**
	 *
	 * 新增数据
	 */
	public function addResourcefield(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
       $type='3';
	   $directory_code= $this->controller->get_gp("directory_code");
		$getData=$this->datacenter->addresources($data,$directory_code,$type);
		echo json_encode($getData);
	}

	/**
	 *
	 * 修改数据
	 */
	public function modifyResourcefield(){
		$data = $this->controller->get_gp("data");
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$directory_code= $this->controller->get_gp("directory_code");
		$row_id= $this->controller->get_gp("row_id");
		 $type='3';
		$getData=$this->datacenter->modifyresources($data,$directory_code,$row_id,$type);
		echo json_encode($getData);
	}
	/**
	 *
	 * 回收数据
	 */
	public function deleteResourcefield(){
		  $directory_code= $this->controller->get_gp("directory_code");
		$row_id= $this->controller->get_gp("row_id");
		 $type='3';
		if(!empty($row_id)){
      	$getData=$this->datacenter->deleteresources($row_id,$directory_code,$type);
		}
		echo json_encode($getData);
	}
	//实时统计数据
	public function activeStatisticsdata(){
		$arr = $this->controller->get_gp("data");
		$arr = stripslashes($arr);
		$arr = json_decode($arr,true);
		$directory_code=$this->controller->get_gp("directory_code");
		$type='count';
		$group= 'destination_id';
		$arr['destination_id']=$this->destination_id;
		$getData=$this->datacenter->activeStatistics($arr,$directory_code,$group,$type);
		echo json_encode($getData);
	}
	//统计数据
	public function completeStatisticsdata(){
		$arr = $this->controller->get_gp("data");
		$arr = stripslashes($arr);
		$arr = json_decode($arr,true);
		$directory_code= $this->controller->get_gp("directory_code");
		$directory_code= $directory_code.'statistics';
		$type=$this->controller->get_gp("type");
		 $arr['destination_id']=$this->destination_id;
		$getData=$this->datacenter->completeStatistics($arr,$directory_code,$type);
		echo json_encode($getData);
	}
	//导出
	public function outputplan(){
		$pageNo = 1;
		$pageNum = 999;
		$data = $this->controller->get_gp("data");
		$directory_code=$this->controller->get_gp("directory_code");
		$str = stripslashes($data);
		$data = json_decode($str,true);
		$data['destination_id']=$this->destination_id ;
		$getData= $this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum);
		$res=$getData['data']['list'];
		//获取资源字段
		$type='3';
		 $getFieldData=$this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum,$type);
		 $resField=$getFieldData['data']['list'];
		ob_end_clean();
		$title='导出测试';
		header("Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8");
		//header("Content-Type:application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$title.xlsx");//文件名自已取
		header("Pragma: no-cache");
		header("Expires: 0");
		$str="";
		$strfield = "";

		foreach($resField as $f)
		{
			$strfield.="<td>".$f['name']."</td>";
		}
		$str="<tr>
		$strfield
		</tr>";
			foreach($res as $v)
		{
			$strb = "";
			foreach($resField as $af)
			{
			$strb.="
			<td>".$v[$af['en_name']]."</td>
			";
		}
		$str.="<tr>
		$strb
		</tr>";
		}
		// print_r($str);
		// exit();
		//echo iconv("UTF-8","GB2312//IGNORE",$str);

		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
							 xmlns="http://www.w3.org/TR/REC-html40">
		 <head>
				<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
				<meta http-equiv=Content-Type content="text/html; charset=gb2312">
				<!--[if gte mso 9]><xml>
				<x:ExcelWorkbook>
				<x:ExcelWorksheets>
					<x:ExcelWorksheet>
					<x:Name></x:Name>
					<x:WorksheetOptions>
						<x:DisplayGridlines/>
					</x:WorksheetOptions>
					</x:ExcelWorksheet>
				</x:ExcelWorksheets>
				</x:ExcelWorkbook>
				</xml><![endif]-->
		</head>';
		echo "<style>
		  td {
						border:0.5px solid #ccc
					}
			  </style>";
		echo "<table>";
		echo  mb_convert_encoding($str,"GB2312", "UTF-8");
		echo "</table>";
	}

	//批量导入工作

	public function inputWork(){
		require_once dirname(__FILE__) . '/phpexcel/PHPExcel.php';
		$pageNo = 1;
		$pageNum = 999;
		$file=$this->controller->get_gp("file");
		$data = $this->controller->get_gp("data");
		$directory_code=$this->controller->get_gp("directory_code");
		$str = stripslashes($data);
		$data = json_decode($str,true);
		$data['destination_id']=$this->destination_id ;
		//获取资源字段
		$type='3';
		 $getFieldData=$this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum,$type);
		 $resField=$getFieldData['data']['list'];
		if(!empty($file)){
			$filePath = $file;
			$PHPReader = new PHPExcel_Reader_Excel2007();

		//echo $PHPReader->canRead($filePath);
			if(!$PHPReader->canRead($filePath)) {
				$PHPReader = new PHPExcel_Reader_Excel5();
				// if(!$PHPReader->canRead($filePath)) {
				// 	echo 'no Excel';
				// 	exit;
				// }
			}
			 if(!$PHPReader->canRead($filePath)){
				$PHPReader = new PHPExcel_Reader_HTML();
			}
			$PHPExcel = $PHPReader->load($filePath);
			/**读取excel文件中的第一个工作表*/
			$currentSheet = $PHPExcel->getSheet(0);
			/**取得最大的列号*/
			$allColumn = $currentSheet->getHighestColumn();
			/**取得一共有多少行*/
			$allRow = $currentSheet->getHighestRow();
			unset($workArr);
			unset($zhNameArr);
			/**从第二行开始输出，因为excel表中第一行为列名*/
			$j=0;
			for($currentRow = 1;$currentRow <= $allRow;$currentRow++){
				/**从第A列开始输出*/
				$i=0;
				for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
					$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
					//echo  $currentColumn." ";
					//echo iconv('utf-8','utf-8', $val)."\t"."</br>";
				    /**如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出*/
					//echo iconv('utf-8','gb2312', $val)."\t"."</br>";
					$tempArray[$i]=iconv('utf-8','utf-8', $val);
				   $i++;
				}
				if($currentRow==1){
					//保存中文名称 用于导入时对比
					$zhNameArr = $tempArray;
				}else{
					$workArr[$j]=$tempArray;
					$j++;
				}


				// echo "</br>";
		   }
		   //导入的数据
		   for ($i=0;$i<count($workArr);$i++){
			   //导入的字段
			for ($a=0;$a<count($resField);$a++){
				//导入字段的中文名
				for ($x=0;$x<count($zhNameArr);$x++){
					if($resField[$a]["name"]==$zhNameArr[$x]){
						$data[$resField[$a]["en_name"]]=$workArr[$i][$x];
					}
				}
			}
			$res=$this->datacenter->addresources($data, $directory_code);
			}
			echo json_encode($res);
	}
}
	//导出
	public function outputplanmodel(){
		$pageNo = 1;
		$pageNum = 999;
		$data = $this->controller->get_gp("data");
		$directory_code=$this->controller->get_gp("directory_code");
	
		$str = stripslashes($data);
		$data = json_decode($str,true);
		$data['destination_id']=$this->destination_id ;
		// $getData= $this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum);
		// $res=$getData['data']['list'];
		//获取资源字段
		$type='3';
		$data = stripslashes($data);
		$data = json_decode($data,true);
	   	$data['is_delete']="0" ;
		 $getFieldData=$this->datacenter->getresources($data,$directory_code,$pageNo,$pageNum,$type);
		 $resField=$getFieldData['data']['list'];

		ob_end_clean();
		$title='模板';
		header("Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8");
		//header("Content-Type:application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$title.xlsx");//文件名自已取
		header("Pragma: no-cache");
		header("Expires: 0");
		$str="";
		$strfield = "";
		$strModelData="";
		foreach($resField as $f)
		{
			if($f['name']!='行号'&&$f['name']!='创建时间'&&$f['name']!='是否删除'&&$f['name']!='目的地id'&&$f['name']!='目的地'){
			$strfield.="<td>".$f['name']."</td>";
			if($f['type']=='datetime'||$f['type']=='date'){
				$strModelData.="<td>".date('Y-m-d', time())."</td>";
			}else{
				$strModelData.="<td>1</td>";

			}

		}

		}
		$str="<tr>
		$strfield
		</tr>"
		."<tr>
		$strModelData
		</tr>"
		;

		echo iconv("UTF-8","GB2312//IGNORE",$str);

		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
							 xmlns="http://www.w3.org/TR/REC-html40">
		 <head>
				<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
				<meta http-equiv=Content-Type content="text/html; charset=gb2312">
				<!--[if gte mso 9]><xml>
				<x:ExcelWorkbook>
				<x:ExcelWorksheets>
					<x:ExcelWorksheet>
					<x:Name></x:Name>
					<x:WorksheetOptions>
						<x:DisplayGridlines/>
					</x:WorksheetOptions>
					</x:ExcelWorksheet>
				</x:ExcelWorksheets>
				</x:ExcelWorkbook>
				</xml><![endif]-->
		</head>';
		echo "<style>
		  td {
						border:0.5px solid #ccc
					}
			  </style>";
		echo "<table>";
		echo  mb_convert_encoding($str,"GB2312", "UTF-8");
		echo "</table>";
	}
	//批量删除
public function deleteBatchData(){
	//standard
	$directory_code=$this->controller->get_gp("directory_code");
	$rows= $this->controller->get_gp("rows");
	$type = $this->controller->get_gp("type");
	foreach($rows as $f)
		{
			$row_id = $f;
			if(!empty($row_id)&&!empty($type)){
				$getData=$this->datacenter->deleteresources($row_id,$directory_code,$type);
			}else{
				$getData=$this->datacenter->deleteresources($row_id,$directory_code);
			}
		}

	echo json_encode($getData);
}
	//批量修改
	public function modifybatchData(){
		$resourceCode = $this->controller->get_gp("resourceCode");
		$data = $this->controller->get_gp("data"); //数据
		$data = stripslashes($data);
		$data = json_decode($data,true);
		$data["destination_id"] = $this->destination_id; //目的地id
		$responce["errcode"] = -1;
		$responce["errMsg"] = "";
		$rows = $data["rows"];
		foreach($rows as $f)
		{
			$row_id = $f;
			$res = $this->datacenter->modifyresources($data, $resourceCode, $row_id);
		}
		//foo 之前为 $this->resourceCode 邓旭阳修改 20201208 10:16

		if (!empty($res) && $res["errcode"] == 0){
			$responce["errcode"] = 0;
			$responce["data"] = $res["data"];
		}else{
			$responce["errMsg"] = $res["errmsg"];
		}
		echo json_encode($responce);
	}
	public function requestbodytest(){
	$data = file_get_contents('php://input');
	$data = json_decode($data, TRUE);
	print_r($data['data']);
	}
}
