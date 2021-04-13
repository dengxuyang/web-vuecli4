<?php
define("ADDRESS","bd.winyeahs.com:8080");
require_once dirname(__FILE__) . '/../../superphp/core/controller/scontroller.php';
class datacentertTecmp extends SController{

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
	
	//查询景区门票
	private $getticket;
	//新增景区门票
	private $addticket;
	//修改景区门票
	private $modifyticket;
	//删除景区门票
	private $deleteticket;


    //查询酒店
    private $getstay;
    private $addstay;
    private $modifystay;
    private $deletestay;
    //房间
    private $getroom;
    private $addroom;
    private $modifyroom;
    private $deleteroom;
    //查询线路
    private $getLine;



    private $getCommodity;
    private $addCommodity;
    private $modifyCommodity;
    private $deleteCommodity;
    
    
    private $getplayproject;
    private $addplayproject;
    private $modifyplayproject;
    private $deleteplayproject;    
 
    //查询会员
    private $getMember;
    private $addMember;
    private $modifyMember;
    private $deleteMember;
  

    //查询订单
    private $getOrder;

    private $addOrder;

    //修改订单
    private $modifyOrder;
    //删除订单
    private $deleteOrder;


    private $addOrderContact;
    private $addOrderDetail;

    //查询评论
    private $getComment;
    private $addComment;

    //查询评论评分
    private $getCommentScore;
    private $addCommentScore;
    private $modifyCommentScore;


    //查询线路出发日期
    private $getSetoutDate;

    //查询线路类别
    private $getCategory;

    //查询租车信息
    private $getCarRental;

    //查询导游信息
    private $getGuide;

    //查询获取预订订单联系人详细表
    private $getOrderContact;

    //查询获取预订订单详细表
    private $getOrderDetail;

    //查询购物车
    private $getShoppingCart;

    //查询购物车
    private $getLinedDtePrice;

    //查询数据元定义
    private $getMetadata;
    //查询数据类型定义
    private $getDatatype;
    //新增数据类型定义
    private $addDatatype;
    //修改数据类型定义
    private $modifyDatatype;
    //删除数据类型定义
    private $deleteDatatype;
    
    private $getClassification;

	function __construct() {
		
       //查询数据分类定义
       $this->getClassification="http://".ADDRESS."/cgi-bin/metadata/classification/get?access_token=%s";
		
		
		
		//查询数据元定义
		$this->getMetadata="http://".ADDRESS."/cgi-bin/metadata/metadata/get?access_token=%s";

		//查询数据类型定义
		$this->getDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/get?access_token=%s";
		//新增数据类型定义
		$this->addDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/add";
		//修改数据类型定义
		$this->modifyDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/modify";
		//删除数据类型定义
		$this->deleteDatatype="http://".ADDRESS."/cgi-bin/manage/datatype/delete?access_token=%s&row_id=%s";
		
		//查询景区景点
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
		
		//查询景区门票
		$this->getticket="http://".ADDRESS."/cgi-bin/business/ticket/get?access_token=%s";
		//新增景区门票
		$this->addticket="http://".ADDRESS."/cgi-bin/business/ticket/add";
		//修改景区门票
		$this->modifyticket="http://".ADDRESS."/cgi-bin/business/ticket/modify";
		//删除景区门票
		$this->deleteticket="http://".ADDRESS."/cgi-bin/business/ticket/delete?access_token=%s&row_id=%s";


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
        
        
        

        //查询线路
        $this->getLine="http://".ADDRESS."/cgi-bin/business/line/get?access_token=%s";

 

        //查询商品
        $this->getCommodity="http://".ADDRESS."/cgi-bin/business/commodity/get?access_token=%s";
        
        //新增商品
        $this->addCommodity="http://".ADDRESS."/cgi-bin/business/commodity/add";
        //修改商品
        $this->modifyCommodity="http://".ADDRESS."/cgi-bin/business/commodity/modify";
        //删除商品
        $this->deleteCommodity="http://".ADDRESS."/cgi-bin/business/commodity/delete?access_token=%s&row_id=%s";
        
        
        
        
        //查询游玩项目
        $this->getplayproject="http://".ADDRESS."/cgi-bin/business/playproject/get?access_token=%s";
        //新增游玩项目
        $this->addplayproject="http://".ADDRESS."/cgi-bin/business/playproject/add";
        //修改游玩项目
        $this->modifyplayproject="http://".ADDRESS."/cgi-bin/business/playproject/modify";
        //删除游玩项目
        $this->deleteplayproject="http://".ADDRESS."/cgi-bin/business/playproject/delete?access_token=%s&row_id=%s";
        

        //查询会员
        $this->getMember="http://".ADDRESS."/cgi-bin/manage/member/get?access_token=%s";
        $this->addMember="http://".ADDRESS."/cgi-bin/manage/member/add?access_token=%s";
        //修改会员
        $this->modifyMember="http://".ADDRESS."/cgi-bin/manage/member/modify";
        //删除会员
        $this->deleteMember="http://".ADDRESS."/cgi-bin/manage/member/delete?access_token=%s&row_id=%s";
        
        //查询订单
        $this->getOrder="http://".ADDRESS."/cgi-bin/business/order/get?access_token=%s";

        $this->addOrder="http://".ADDRESS."/cgi-bin/business/order/add?access_token=%s";


        //修改订单
        $this->modifyOrder="http://".ADDRESS."/cgi-bin/business/order/modify";
        //删除订单
        $this->deleteOrder="http://".ADDRESS."/cgi-bin/business/order/delete?access_token=%s&row_id=%s";



        $this->addOrderContact="http://".ADDRESS."/cgi-bin/business/ordercontact/add?access_token=%s";
        $this->addOrderDetail="http://".ADDRESS."/cgi-bin/business/orderdetail/add?access_token=%s";

        //查询评论
        $this->getComment="http://".ADDRESS."/cgi-bin/business/comment/get?access_token=%s";
        $this->addComment="http://".ADDRESS."/cgi-bin/business/comment/add?access_token=%s";

        //查询评论得分
        $this->getCommentScore="http://".ADDRESS."/cgi-bin/business/commentscore/get?access_token=%s";
        $this->addCommentScore="http://".ADDRESS."/cgi-bin/business/commentscore/add?access_token=%s";
        $this->modifyCommentScore="http://".ADDRESS."/cgi-bin/business/commentscore/modify?access_token=%s";

        //查询线路出发日期
        $this->getSetoutDate="http://".ADDRESS."/cgi-bin/business/setoutdate/get?access_token=%s";

        //查询线路类别
        $this->getCategory="http://".ADDRESS."/cgi-bin/business/category/get?access_token=%s";

        //查询租车信息
        $this->getCarRental="http://".ADDRESS."/cgi-bin/business/carrental/get?access_token=%s";

        //查询导游信息
        $this->getGuide="http://".ADDRESS."/cgi-bin/basic/travelers/get?access_token=%s";

        //查询获取预订订单联系人详细表
        $this->getOrderContact="http://".ADDRESS."/cgi-bin/business/ordercontact/get?access_token=%s";

        //查询获取预订订单详细表
        $this->getOrderDetail="http://".ADDRESS."/cgi-bin/business/orderdetail/get?access_token=%s";

        //查询购物车
        $this->getShoppingCart="http://".ADDRESS."/cgi-bin/business/shoppingcart/get?access_token=%s";

        //查询线路出发日期和价格
        $this->getLinedDtePrice="http://".ADDRESS."/cgi-bin/business/linedateprice/get?access_token=%s";

	}


    public function addOrder($arr){
        $getData = $this->post($this->addOrder, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    public function addOrderContact($arr){
        $getData = $this->post($this->addOrderContact, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    public function addOrderDetail($arr){
        $getData = $this->post($this->addOrderDetail, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    public function modifyCommentScore($arr){
        $getData = $this->post($this->modifyCommentScore, $arr);
        $getData=json_decode($getData,true);
        //echo json_encode($getData);
        return $getData;
    }

    public function addCommentScore($arr){
        $getData = $this->post($this->addCommentScore, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    public function addComment($arr,$mode){
        $getData = $this->post($this->addComment, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
        if($mode=='return'){
            return $getData;
        }else{
            echo json_encode($getData);
        }
    }


    /**
     * 查询线路出发日期和价格
     */
    public function getLinedDtePrice($arr){
        $url =  sprintf($this->getOrderContact,$arr['access_token']);

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
        if(!empty($arr["line_id"])&&($arr["line_id"])!=""){
            $url.="&line_id=".urlencode($arr["line_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }




    /**
     * 查询购物车
     */
    public function getShoppingCart($arr){
        $url =  sprintf($this->getOrderContact,$arr['access_token']);

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
        if(!empty($arr["member_id"])&&($arr["member_id"])!=""){
            $url.="&member_id=".urlencode($arr["member_id"]);
        }


        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 获取获取预订订单详细表
     */
    public function getOrderDetail($arr){
        $url =  sprintf($this->getOrderContact,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["order_id"])&&($arr["order_id"])!=""){
            $url.="&order_id=".urlencode($arr["order_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 获取获取预订订单联系人详细表
     */
    public function getOrderContact($arr){
        $url =  sprintf($this->getOrderContact,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["order_id"])&&($arr["order_id"])!=""){
            $url.="&order_id=".urlencode($arr["order_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
     * 获取导游信息
     */
    public function getGuide($arr){
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
        echo json_encode($getData);
    }

    /**
     * 获取租车信息
     *
     */
    public function getCarRental($arr){
        $url =  sprintf($this->getCarRental,$arr['access_token']);

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

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 获取线路类别
     *
     */
    public function getCategory($arr){
        $url =  sprintf($this->getCategory,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["line_id"])&&($arr["line_id"])!=""){
            $url.="&line_id=".urlencode($arr["line_id"]);
        }
        if(!empty($arr["is_recommend"])&&($arr["is_recommend"])!=""){
            $url.="&is_recommend=".urlencode($arr["is_recommend"]);
        }
        if(!empty($arr["member_id"])&&($arr["member_id"])!=""){
            $url.="&member_id=".urlencode($arr["member_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 获取线路出发日期
     *
     */
    public function getSetoutDate($arr){
        $url =  sprintf($this->getSetoutDate,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["line_id"])&&($arr["line_id"])!=""){
            $url.="&line_id=".urlencode($arr["line_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
     * 获取评论得分
     *
     */
    public function getCommentScore($arr,$mode){
        $url =  sprintf($this->getCommentScore,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["comment_id"])&&($arr["comment_id"])!=""){
            $url.="&comment_id=".urlencode($arr["comment_id"]);
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

    /**
     * 获取评论
     *
     */
    public function getComment($arr,$type){
        $url =  sprintf($this->getComment,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["data_id"])&&($arr["data_id"])!=""){
            $url.="&data_id=".urlencode($arr["data_id"]);
        }
        if(!empty($arr["type"])&&($arr["type"])!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }

        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        if($type=="return") {
            return $getData;
        } else {
            echo json_encode($getData);
        }
    }

    /**
     * 获取订单
     *
     */
    public function getOrder($arr){
     
        $url =  sprintf($this->getOrder,$arr['access_token']);

        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if($arr["status"]!=""){
            $url.="&status=".urlencode($arr["status"]);
        }

        if(!empty($arr["number"])&&($arr["number"])!=""){
            $url.="&number=".urlencode($arr["number"]);
        }
        if(!empty($arr["type "])&&($arr["type "])!=""){
        	$url.="&type =".urlencode($arr["type "]);
        }
 
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    /**
     * 修改订单
     *
     */
    public function modifyOrder($arr){

    	$getData = $this->post($this->modifyOrder, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    
    }
    /**
     * 删除订单
     *
     */
    public function deleteOrder($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteOrder,$access_token,$row_id);
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
     * 修改订单
     *
     */
    public function modifyMember($arr){
    
    	$getData = $this->post($this->modifyMember, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    
    }
    /**
     * 删除订单
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
    /**
     * 获取商品
     *
     */
    public function getCommodity($arr,$mode){
        $url =  sprintf($this->getCommodity,$arr['access_token']);

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
        if(!empty($arr["play_id"])&&($arr["play_id"])!=""){
            $url.="&play_id=".urlencode($arr["play_id"]);
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

    /**
     * 新增商品
     *
     */
    public function addCommodity($arr,$mode){
    	$getData = $this->post($this->addCommodity, $arr);
    	$getData=json_decode($getData,true);
    	if($mode=='none'){		
    	}else{
    		echo json_encode($getData);
    	}
    
    }
    
    /**
     * 修改商品
     *
     */
    public function modifyCommodity($arr){

    	$getData = $this->post($this->modifyCommodity, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    
    }
    /**
     * 删除商品
     *
     */
    public function deleteCommodity($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteCommodity,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }    
    
 
    
    /**
     * 获取游玩项目
     *
     */
    public function getplayproject($arr,$mode){
    	$url =  sprintf($this->getplayproject,$arr['access_token']);
    
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
    	if(!empty($arr["play_id"])&&($arr["play_id"])!=""){
    		$url.="&play_id=".urlencode($arr["play_id"]);
    	}
 
    
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	if($mode=='return'){
    		return $getData;
    	}else{
    		echo json_encode($getData);
    	}
    }
    
    /**
     * 新增游玩项目
     *
     */
    public function addplayproject($arr,$return){

    	$getData = $this->post($this->addplayproject, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    
    /**
     * 修改游玩项目
     *
     */
    public function modifyplayproject($arr){
    
    	$getData = $this->post($this->modifyplayproject, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    
    }
    /**
     * 删除游玩项目
     *
     */
    public function deleteplayproject($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteplayproject,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    
 
    /**
     * 获取线路
     *
     */
    public function getLine($arr){
        $url =  sprintf($this->getLine,$arr['access_token']);

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
        if(!empty($arr["name_chn"])&&($arr["name_chn"])!=""){
        	$url.="&name_chn=".urlencode($arr["name_chn"]);
        }
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }



    /**
     * 获取酒店
     *
     */
    public function getStay($arr,$mode){
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
        if(!empty($arr["name_chn"])&&($arr["name_chn"])!=""){
            $url.="&name_chn=".urlencode($arr["name_chn"]);
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
    public function addStay($arr,$mode){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addstay, $arr);
    	$getData=json_decode($getData,true);
        if($mode=='none'){
		}else{
			echo json_encode($getData);
		}
    }
    public function modifyStay($arr,$mode){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifystay, $arr);
    	$getData=json_decode($getData,true);
    	if($mode=='none'){
		}else{
			echo json_encode($getData);
		}
    
    }
    public function deleteStay($arr){
    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deletestay,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
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
        if(!empty($arr["is_sale"])&&($arr["is_sale"])!=""){
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
	public function addplay($arr,$mode){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addplay, $arr);
		$getData=json_decode($getData,true);
		if($mode=='none'){
		}else{
			echo json_encode($getData);
		}
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
	 * 门票
	 *
	 */
	public function getticket($arr){
        $url =  sprintf($this->getticket,$arr['access_token']);

        if(!empty($arr["row_id"])&&($arr["row_id"])!=""){
            $url.="&row_id=".urlencode($arr["row_id"]);
        }
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
        if(!empty($arr["play_id"])&&($arr["play_id"])!=""){
            $url.="&play_id=".urlencode($arr["play_id"]);
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

	public function addticket($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->addticket, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	public function modifyticket($arr){
		$access_token =$arr['access_token'];
		$getData = $this->post($this->modifyticket, $arr);
		$getData=json_decode($getData,true);
		echo json_encode($getData);

	}
	public function deleteticket($arr){
		$access_token =$arr['access_token'];
		$row_id = $arr["row_id"];
		$url =  sprintf($this->deleteticket,$access_token,$row_id);
		$getData = file_get_contents($url);
		$getData=json_decode($getData,true);
		echo json_encode($getData);
	}
	/**
	 * 图片，文件  媒体
	 *
	 */
	public function getmedia($arr){

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
	public function getRoom($arr){
	 
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