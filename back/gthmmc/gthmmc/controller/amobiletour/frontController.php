<?php
header("Access-Control-Allow-Origin:*");
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
require_once dirname(__FILE__) . '/../../common/log.php';
require_once dirname(__FILE__) . '/common.php';
require_once dirname(__FILE__) . '/../../common/datacenter_cloud.php';
//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__) . '/../../logs/'.date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class frontController extends SController{
	private $WCommon;
	private $destination_id;
	private $code_standard;
	private $code_resource;
	private $code_model;
	private $code_modeltable;

	function __construct() {
		parent::__construct();
		$this->SetWhiteList(array( 'queryDataOfResource','addDataOfResource',	'addDataOfResource', 'modifyDataOfResource', 'deleteDataOfResource',
                'login','logout','addmember'
								));
		date_default_timezone_set(PRC);
		$this->WCommon = new WCommon();
		$this->datacenter = new datacenterCloud();
		$this->code_standard='standard';
		$this->code_resource='resourcedirectory';
		$this->code_model='dataModel';
		$this->code_modeltable='dataModelfield';
	  $this->code_member="member";
	}
		public function before(){
	//		$this->WCommon->ssoCheck();
	//		$getUser = $this->WCommon->getUser();
			$this->destination_id=600;
		  $destination_id=$this->controller->get_gp("destination_id");
			if(!empty($destination_id)){
					$this->destination_id=$destination_id;
			}
			$this->logArr['system']="AMG";
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
			echo json_encode($response);
		}
		//新增资源对应数据
		public function addDataOfResource(){
			$data = $this->controller->get_gp("data");
			$directory_code = $this->controller->get_gp("directory_code");
			$str = stripslashes($data);
			$data = json_decode($str,true);
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
			echo json_encode($responce);
		}
		//修改资源对应数据
		public function modifyDataOfResource(){
			$data = $this->controller->get_gp("data");
			$directory_code = $this->controller->get_gp("directory_code");
			$str = stripslashes($data);
			$data = json_decode($str,true);
			$data["destination_id"] = $this->destination_id; //目的地id
			$responce["errCode"] = -1;
			$responce["errMsg"] = "";
			$row_id = $data["row_id"];
			$res = $this->datacenter->modifyresources($data, $directory_code, $row_id);
			if (!empty($res) && $res["errCode"] == 0){
				$responce["errCode"] = 0;
				$responce["data"] = $res["data"];
			}else{
				$responce["errMsg"] = $res["errmsg"];
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


			/**
	  	 *
	  	 * 登录处理
	  	 */
	  public function login(){

			$account= $this->controller->get_gp('account');
			$password = $this->controller->get_gp('password');
	    $openid = $this->controller->get_gp('openid');
	    $type= $this->controller->get_gp('type');
			$responce['errCode'] = "-1";
			$responce['errMsg'] = "用户不存在，请先注册";
	    if(empty($account)&&empty($openid)){
				$responce['errMsg'] = "登录失败,参数有误";
			}else{
	      if($type=="1"){    // 网页
	        $data['account']=$account;
	        $data['password']=md5($password);
	      	$data['destination_id']=$this->destination_id ;
	      }
	      if($type=="2"){  // 小程序
	        $data['openid']=$openid;
	      	$data['destination_id']=$this->destination_id ;
	      }
		    $directory_code=$this->code_member;
	      $data['searchmodel']="exact" ;
	      $res = $this->datacenter->getresources($data, $directory_code, 1, 999);

	      if( $res["data"]["total"]==0){
	        	echo json_encode($responce);
	          return;
	      }
	      $getData=$res["data"]["list"][0];
	  		$responce['errMsg'] = "登录失败，可能原因：帐户不存在或密码不正确!";
	  		$getSession = $this->getUtil('session');
				if (!empty($getData)){
					$getSession->set('member_row_id',  $getData['row_id']);
					$getSession->set('member_isLogon', 1);
					$getSession->set('member_type', $getData['type']);
					$getSession->set('member_name', $getData['name']);
					$getSession->set('member_account', $getData['account']);
					$getSession->set('member_head_image', $getData['head_image']);
					$responce["errCode"] = '0';
					$responce["errMsg"] = '';
					$responce["data"]["row_id"] =  $getData['row_id'];
					$responce["data"]["type"] =  $getData['type'];
					$responce["data"]["account"] =  $getData['account'];
					$responce["data"]["name"] =  $getData['name'];
					$responce["data"]["mobile"] =  $getData['mobile'];
					$responce["data"]["head_image"] =  $getData['head_image'];
				}else {
					$getSession->set("member_isLogon", 0);
				}
			}
			echo json_encode($responce);
		}
	  /**
		 *
		 * 退出
		 */
		public function logout(){
			$getSession = $this->getUtil("session");
			$getSession->set("member_isLogon", 0);
			session_destroy();
			$responce["result"] = true;
			echo json_encode($responce);
		}


		public function addmember(){
	    $response["errcode"] = -1;
	    $response["errMsg"] = "数据有误";
	 		//$data = $this->controller->get_gp("data");
	    $account= $this->controller->get_gp('account');
		  $password = $this->controller->get_gp('password');
	    $openid = $this->controller->get_gp('openid');
	    $type= $this->controller->get_gp('type');
	    $directory_code=$this->code_member;
	    if(empty($type)){
	      echo json_encode($response);
	      return;
	    }
	    if($type=="1"){    // 网页
	      $data['account']=$account;
	      $data['password']=md5($password);
	    	$data['destination_id']=$this->destination_id ;
	      //检查是否存在
	      $newData['account']=$account;
	      $newData['destination_id']=$this->destination_id ;
	    }
	    if($type=="2"){  // 小程序
	      $data['openid']=$openid;
	    	$data['destination_id']=$this->destination_id ;
	      //检查是否存在
	      $newData['openid']=$openid;
	      $newData['destination_id']=$this->destination_id ;
	    }
	    $newData['searchmodel']="exact" ;
	    $res = $this->datacenter->getresources($newData, $directory_code, 1, 999);

	    if( $res["data"]["total"]==0){
	      $getData=$this->datacenter->addresources($data,$directory_code);
	      $response["errcode"] = 0;
	      $response["errMsg"] = $getData;
	    }else{
	      $response["errMsg"] = "账号已经存在！";
	    }
	    echo json_encode($response);
	 	}





}
