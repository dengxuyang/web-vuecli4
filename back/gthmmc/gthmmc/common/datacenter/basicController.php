<?php
$config = SuperPHP::getConfig();
define("ADDRESS",$config['dbUrl']);
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
class basicController extends SController{

    //查询景区景点
	private $getplay;
	//新增景区景点
	private $addplay;
	//修改景区景点
	private $modifyplay;
	//删除景区景点
	private $deleteplay;

	//查询多媒体
	private $getmedia;
	//新增多媒体
	private $addmedia;
	//修改多媒体
	private $modifymedia;
	//删除多媒体
	private $deletemedia;

    //查询娱乐场所
	private $getamuse;
	//新增娱乐场所
	private $addamuse;
	//修改娱乐场所
	private $modifyamuse;
	//删除娱乐场所
	private $deleteamuse;

    //房间
    private $getroom;
    private $addroom;
    private $modifyroom;
    private $deleteroom;

    //查询酒店
    private $getstay;
    private $addstay;
    private $modifystay;
    private $deletestay;

    //查询餐馆
	private $getrestaurant;
	//新增餐馆
	private $addrestaurant;
	//修改餐馆
	private $modifyrestaurant;
	//删除餐馆
	private $deleterestaurant;

	//查询导游信息
	private $getGuide;

    //查询公共厕所
	private $gettoilet;
	//新增公共厕所
	private $addtoilet;
	//修改公共厕所
	private $modifytoilet;
	//删除公共厕所
	private $deletetoilet;

    //查询医院
	private $gethospital;
	//新增医院
	private $addhospital;
	//修改医院
	private $modifyhospital;
	//删除医院
	private $deletehospital;

    //查询加油站
	private $getgas;
	//新增加油站
	private $addgas;
	//修改加油站
	private $modifygas;
	//删除加油站
	private $deletegas;

	//查询停车场
	private $getcarpark;
	//新增停车场
	private $addcarpark;
	//修改停车场
	private $modifycarpark;
	//删除停车场
	private $deletecarpark;

	function __construct() {
		
		//查询景点
		$this->getplay="http://".ADDRESS."/cgi-bin/basic/play/get?access_token=%s";
	    //新增景区景点
        $this->addplay="http://".ADDRESS."/cgi-bin/basic/play/add";
        //修改景区景点
        $this->modifyplay="http://".ADDRESS."/cgi-bin/basic/play/modify";
        //删除景区景点

        $this->deleteplay="http://".ADDRESS."/cgi-bin/basic/play/delete?access_token=%s&row_id=%s";
        //查询多媒体
        $this->getmedia="http://".ADDRESS."/cgi-bin/basic/media/get?access_token=%s";
        //新增多媒体
        $this->addmedia="http://".ADDRESS."/cgi-bin/basic/media/add";
        //修改多媒体
        $this->modifymedia="http://".ADDRESS."/cgi-bin/basic/media/modify";
        //删除多媒体
        $this->deletemedia="http://".ADDRESS."/cgi-bin/basic/media/delete?access_token=%s&row_id=%s";

        //查询娱乐场所
        $this->getamuse="http://".ADDRESS."/cgi-bin/basic/amuse/get?access_token=%s";
        //新增娱乐场所
        $this->addamuse="http://".ADDRESS."/cgi-bin/basic/amuse/add";
        //修改娱乐场所
        $this->modifyamuse="http://".ADDRESS."/cgi-bin/basic/amuse/modify";
        //删除娱乐场所
        $this->deleteamuse="http://".ADDRESS."/cgi-bin/basic/amuse/delete?access_token=%s&row_id=%s";

        //查询酒店
        $this->getstay="http://".ADDRESS."/cgi-bin/basic/stay/get?access_token=%s";
        //新增酒店
        $this->addstay="http://".ADDRESS."/cgi-bin/basic/stay/add";
        //修改酒店
        $this->modifystay="http://".ADDRESS."/cgi-bin/basic/stay/modify";
        //删除酒店
        $this->deletestay="http://".ADDRESS."/cgi-bin/basic/stay/delete?access_token=%s&row_id=%s";

        //查询房间
        $this->getroom="http://".ADDRESS."/cgi-bin/basic/room/get?access_token=%s";
        //新增房间
        $this->addroom="http://".ADDRESS."/cgi-bin/basic/room/add";
        //修改房间
        $this->modifyroom="http://".ADDRESS."/cgi-bin/basic/room/modify";
        //删除房间
        $this->deleteroom="http://".ADDRESS."/cgi-bin/basic/room/delete?access_token=%s&row_id=%s";

	    //查询餐馆
		$this->getrestaurant="http://".ADDRESS."/cgi-bin/basic/restaurant/get?access_token=%s";
		//新增餐馆
		$this->addrestaurant="http://".ADDRESS."/cgi-bin/basic/restaurant/add";
		//修改餐馆
		$this->modifyrestaurant="http://".ADDRESS."/cgi-bin/basic/restaurant/modify";
		//删除餐馆
		$this->deleterestaurant="http://".ADDRESS."/cgi-bin/basic/restaurant/delete?access_token=%s&row_id=%s";

        //查询导游信息
        $this->getGuide="http://".ADDRESS."/cgi-bin/basic/travelers/get?access_token=%s";

        //查询公共厕所
        $this->gettoilet="http://".ADDRESS."/cgi-bin/basic/toilet/get?access_token=%s";
        //新增公共厕所
        $this->addtoilet="http://".ADDRESS."/cgi-bin/basic/toilet/add";
        //修改公共厕所
        $this->modifytoilet="http://".ADDRESS."/cgi-bin/basic/toilet/modify";
        //删除公共厕所
        $this->deletetoilet="http://".ADDRESS."/cgi-bin/basic/toilet/delete?access_token=%s&row_id=%s";

        //查询医院
        $this->gethospital="http://".ADDRESS."/cgi-bin/basic/hospital/get?access_token=%s";
        //新增医院
        $this->addhospital="http://".ADDRESS."/cgi-bin/basic/hospital/add";
        //修改医院
        $this->modifyhospital="http://".ADDRESS."/cgi-bin/basic/hospital/modify";
        //删除医院
        $this->deletehospital="http://".ADDRESS."/cgi-bin/basic/hospital/delete?access_token=%s&row_id=%s";

        //查询加油站
        $this->getgas="http://".ADDRESS."/cgi-bin/basic/gas/get?access_token=%s";
        //新增加油站
        $this->addgas="http://".ADDRESS."/cgi-bin/basic/gas/add";
        //修改加油站
        $this->modifygas="http://".ADDRESS."/cgi-bin/basic/gas/modify";
        //删除加油站
        $this->deletegas="http://".ADDRESS."/cgi-bin/basic/gas/delete?access_token=%s&row_id=%s";

        //查询停车场
        $this->getcarpark="http://".ADDRESS."/cgi-bin/basic/carpark/get?access_token=%s";
        //新增停车场
        $this->addcarpark="http://".ADDRESS."/cgi-bin/basic/carpark/add";
        //修改停车场
        $this->modifycarpark="http://".ADDRESS."/cgi-bin/basic/carpark/modify";
        //删除停车场
        $this->deletecarpark="http://".ADDRESS."/cgi-bin/basic/carpark/delete?access_token=%s&row_id=%s";
	}

	/**
	 * 获取景点
	 *    
	 */
	public function getplay($arr,$mode){

        $url =  sprintf($this->getplay,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
            $url.="&is_recommend=".urlencode($arr["is_recommend"]);
        }
        if($arr["is_sale"]!=""){
        	$url.="&is_sale=".urlencode($arr["is_sale"]);
        }
        if(($arr["parent_id"])!=""){
        	$url.="&parent_id=".urlencode($arr["parent_id"]);
        }   
        if(!empty($arr["name_chn"])&&($arr["name_chn"])!=""){
        	$url.="&name_chn=".urlencode($arr["name_chn"]);
        }
 
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
        	return $getData;
        }else{
        	echo json_encode($getData);
        }
	}

    public function addplay($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addplay, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
    public function modifyplay($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->modifyplay, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);

	}
	public function deleteplay($arr){
		$access_token =$arr['access_token'];
		$row_id = $arr["row_id"];
		$url =  sprintf($this->deleteplay,$access_token,$row_id);
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
    /**
	 * 图片，文件  媒体
	 *
	 */
	public function getmedia($arr,$mode){

        $url =  sprintf($this->getmedia,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }

        if(!empty($arr["data_id"])&&($arr["data_id"])!=""){
            $url.="&data_id=".urlencode($arr["data_id"]);
        }
        if(!empty($arr["type"])&&($arr["type"])!=""){
        	$url.="&type=".urlencode($arr["type"]);
        }
        if(!empty($arr["file_type"])&&($arr["file_type"])!=""){
        	$url.="&file_type=".urlencode($arr["file_type"]);
        }
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}

	public function addmedia($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addmedia, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	public function modifymedia($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->modifymedia, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);

	}
	public function deletemedia($arr){
		$access_token =$arr['access_token'];
		$row_id = $arr["row_id"];
		$url =  sprintf($this->deletemedia,$access_token,$row_id);
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
    /**
	 * 房间
	 *
	 */
	public function getRoom($arr,$mode){

		$url =  sprintf($this->getroom,$arr['access_token']);

		if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
			$url.="&row_id=".urlencode($arr["row_id"]);
		}
		if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
			$url.="&pageNo=".urlencode($arr["pageNo"]);
		}
		if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
			$url.="&pageNum=".urlencode($arr["pageNum"]);
		}
		if(!empty($arr["stay_id"])&&($arr["stay_id"])!=""){
			$url.="&stay_id=".urlencode($arr["stay_id"]);
		}
		if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
			$url.="&is_recommend=".urlencode($arr["is_recommend"]);
		}

		if($arr["return"] == "return") {
			$getData = file_get_contents($url);
			return $getData;
		} else {
			$getData = file_get_contents($url);
			$getData=json_decode($getData,true);
			echo json_encode($getData);
		}

	}
	public function addroom($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addroom, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	public function modifyroom($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->modifyroom, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);

	}
	public function deleteroom($arr){
		$access_token =$arr['access_token'];
		$row_id = $arr["row_id"];
		$url =  sprintf($this->deleteroom,$access_token,$row_id);
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	/**
     * 娱乐场所
     *
     */
    public function getamuse($arr,$mode){

        $url =  sprintf($this->getamuse,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
            $url.="&is_recommend=".urlencode($arr["is_recommend"]);
        }

        if($arr["return"] == "return") {
            $getData = file_get_contents($url);
            return $getData;
        } else {
            $getData = file_get_contents($url);
            $getData=json_decode($getData,true);
            echo json_encode($getData);
        }

    }
    public function addamuse($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addamuse, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyamuse($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyamuse, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);

    }
    public function deleteamuse($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteamuse,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    /**
     * 获取酒店
     *
     */
    public function getstay($arr,$mode){
        $url =  sprintf($this->getstay,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
            $url.="&is_recommend=".urlencode($arr["is_recommend"]);
        }
        if(!empty($arr["is_sale"])&&($arr["is_sale"])!=""){
        	$url.="&is_sale=".urlencode($arr["is_sale"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
        	return $getData;
        }else{
        	echo json_encode($getData);
        }
    }
    public function addstay($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addstay, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifystay($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifystay, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);

    }
    public function deletestay($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deletestay,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    /**
     * 获取餐饮
     *
     */
    public function getrestaurant($arr,$mode){
        $url =  sprintf($this->getrestaurant,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
            $url.="&is_recommend=".urlencode($arr["is_recommend"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
    }
    public function addrestaurant($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addrestaurant, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyrestaurant($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyrestaurant, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);

    }
    public function deleterestaurant($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleterestaurant,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
     * 获取导游信息
     */
    public function getGuide($arr,$mode){
        $url =  sprintf($this->getGuide,$arr['access_token']);

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
        if(!empty($arr["type"])&&($arr["type"])!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
    }
    //查询公共厕所
	public function gettoilet($arr,$mode){
	    $url =  sprintf($this->gettoilet,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
	}
    public function addtoilet($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addtoilet, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifytoilet($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyrestaurant, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);

    }
    public function deletetoilet($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleterestaurant,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    //查询医院
	public function gethospital($arr,$mode){
	    $url =  sprintf($this->gethospital,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
	}
    public function addhospital($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addhospital, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyhospital($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyhospital, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);

    }
    public function deletehospital($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deletehospital,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    //查询加油站
	public function getgas($arr,$mode){
	    $url =  sprintf($this->getgas,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
	}
    public function addgas($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addgas, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifygas($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifygas, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);

    }
    public function deletegas($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deletegas,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    //查询停车场
	public function getcarpark($arr,$mode){
	    $url =  sprintf($this->getcarpark,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["is_check"])&&($arr["is_check"])!=""){
            $url.="&is_check=".urlencode($arr["is_check"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
	}
    public function addcarpark($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->addcarpark, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifycarpark($arr){
        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifycarpark, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deletecarpark($arr){
        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deletecarpark,$access_token,$row_id);
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