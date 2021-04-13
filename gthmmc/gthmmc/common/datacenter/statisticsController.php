<?php
$config = SuperPHP::getConfig();
define("ADDRESS",$config['dbUrl']);
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
class statisticsController extends SController{

    //旅游经营场所
    private $businessPlace;
    private $addBusinessPlace;
    private $modifyBusinessPlace;
    private $deleteBusinessPlace;

    //旅游从业人员数量
    private $travelPractitioner;
    private $addTravelPractitioner;
    private $modifyTravelPractitioner;
    private $deleteTravelPractitioner;

    //多媒体数据统计
    private $mediaStatistics;
    private $addMediaStatistics;
    private $modifyMediaStatistics;
    private $deleteMediaStatistics;

    //旅游机构
    private $travelAgency;
    private $addTravelAgency;
    private $modifyTravelAgency;
    private $deleteTravelAgency;

    //旅游公共基础设施
    private $travelpublicutilities;
    private $addTravelpublicutilities;
    private $modifyTravelpublicutilities;
    private $deleteTravelpublicutilities;

    /**
       业务数据
    **/
    //门票销金额统计
    private $scenicTicketsalesmoneyData;
    private $addScenicTicketsalesmoneyData;
    private $modifyScenicTicketsalesmoneyData;
    private $deleteScenicTicketsalesmoneyData;

    //门票销售量统计
    private $scenicTicketsalesamountData;
    private $addScenicTicketsalesamountData;
    private $modifyScenicTicketsalesamountData;
    private $deleteScenicTicketsalesamountData;

    //景区客流量统计
    private $touristTrafficData;
    private $addTouristTrafficData;
    private $modifyTouristTrafficData;
    private $deleteTouristTrafficData;

    //运营数据统计
    private $getMemberstatistic;
    private $addMemberstatistic;
    private $modifyMemberstatistic;
    private $deleteMemberstatistic;

    //运营数据统计
    private $touristsAnalysisData;
    private $addTouristsAnalysisData;
    private $modifyTouristsAnalysisData;
    private $deleteTouristsAnalysisData;



    private $getTouristroute;
    private $addTouristroute;
    private $modifyTouristroute;
    private $deleteTouristroute;

    private $getUnionpaymoney;
    private $addUnionpaymoney;
    private $modifyUnionpaymoney;
    private $deleteUnionpaymoney;

    private $getOtaorderamount;
    private $addOtaorderamount;
    private $modifyOtaorderamount;
    private $deleteOtaorderamount;

    private $getOtaordermoney;
    private $addOtaordermoney;
    private $modifyOtaordermoney;
    private $deleteOtaordermoney;

    function __construct() {

		//旅游经营场所
		$this->businessPlace 	        = "http://".ADDRESS."/cgi-bin/statistics/basic/businessplace/query?access_token=%s";
		$this->addBusinessPlace 	    = "http://".ADDRESS."/cgi-bin/statistics/basic/businessplace/add";
		$this->modifyBusinessPlace 	    = "http://".ADDRESS."/cgi-bin/statistics/basic/businessplace/modify";
		$this->deleteBusinessPlace 	    = "http://".ADDRESS."/cgi-bin/statistics/basic/businessplace/delete?access_token=%s&row_id=%s";

		//从业人员统计
		$this->travelPractitioner       ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpractitioner/query?access_token=%s";
		$this->addTravelPractitioner    ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpractitioner/add";
		$this->modifyTravelPractitioner ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpractitioner/modify";
		$this->deleteTravelPractitioner ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpractitioner/delete?access_token=%s&row_id=%s";

		//旅游机构
		$this->travelAgency 	        ="http://".ADDRESS."/cgi-bin/statistics/basic/travelagencystatistic/query?access_token=%s";
		$this->addTravelAgency 	        ="http://".ADDRESS."/cgi-bin/statistics/basic/travelagencystatistic/add";
		$this->modifyTravelAgency 	    ="http://".ADDRESS."/cgi-bin/statistics/basic/travelagencystatistic/modify";
		$this->deleteTravelAgency 	    ="http://".ADDRESS."/cgi-bin/statistics/basic/travelagencystatistic/delete?access_token=%s&row_id=%s";

		//多媒体数据
		$this->mediaStatistics 	        ="http://".ADDRESS."/cgi-bin/statistics/basic/mediastatistic/query?access_token=%s";
		$this->addMediaStatistics 	    ="http://".ADDRESS."/cgi-bin/statistics/basic/mediastatistic/add";
		$this->modifyMediaStatistics 	="http://".ADDRESS."/cgi-bin/statistics/basic/mediastatistic/modify";
		$this->deleteMediaStatistics 	="http://".ADDRESS."/cgi-bin/statistics/basic/mediastatistic/delete?access_token=%s&row_id=%s";

		//公共设施统计
		$this->travelpublicutilities        ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpublicutilities/query?access_token=%s";
		$this->addTravelpublicutilities     ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpublicutilities/add";
		$this->modifyTravelpublicutilities  ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpublicutilities/modify";
		$this->deleteTravelpublicutilities  ="http://".ADDRESS."/cgi-bin/statistics/basic/travelpublicutilities/delete?access_token=%s&row_id=%s";

        /**
                             业务数据
        **/
        //门票销金额统计
		$this->scenicTicketsalesmoneyData       ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesmoney/get?access_token=%s";
		$this->addScenicTicketsalesmoneyData    ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesmoney/add";
		$this->modifyScenicTicketsalesmoneyData ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesmoney/modify";
		$this->deleteScenicTicketsalesmoneyData ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesmoney/delete?access_token=%s&row_id=%s";

        //门票销售量统计
		$this->scenicTicketsalesamountData       ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesamount/get?access_token=%s";
		$this->addScenicTicketsalesamountData    ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesamount/add";
		$this->modifyScenicTicketsalesamountData ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesamount/modify";
		$this->deleteScenicTicketsalesamountData ="http://".ADDRESS."/cgi-bin/statistics/ticketsalesamount/delete?access_token=%s&row_id=%s";

        //实时客流统计
		$this->touristTrafficData        ="http://".ADDRESS."/cgi-bin/statistics/passengerflow/get?access_token=%s";
		$this->addTouristTrafficData     ="http://".ADDRESS."/cgi-bin/statistics/passengerflow/add";
		$this->modifyTouristTrafficData  ="http://".ADDRESS."/cgi-bin/statistics/passengerflow/modify";
		$this->deleteTouristTrafficData  ="http://".ADDRESS."/cgi-bin/statistics/passengerflow/delete?access_token=%s&row_id=%s";

        //
		$this->touristsAnalysisData         ="http://".ADDRESS."/cgi-bin/statistics/domesticsource/get?access_token=%s";
		$this->addTouristsAnalysisData      ="http://".ADDRESS."/cgi-bin/statistics/domesticsource/add";
		$this->modifyTouristsAnalysisData   ="http://".ADDRESS."/cgi-bin/statistics/domesticsource/modify";
		$this->deleteTouristsAnalysisData   ="http://".ADDRESS."/cgi-bin/statistics/domesticsource/delete?access_token=%s&row_id=%s";


		//旅游线路touristroute
		$this->getTouristroute         ="http://".ADDRESS."/cgi-bin/statistics/touristroute/get?access_token=%s";
		$this->addTouristroute         ="http://".ADDRESS."/cgi-bin/statistics/touristroute/add";
		$this->modifyTouristroute         ="http://".ADDRESS."/cgi-bin/statistics/touristroute/modify";
		$this->deleteTouristroute         ="http://".ADDRESS."/cgi-bin/statistics/touristroute/delete?access_token=%s&row_id=%s";

		//银联消费额统计unionpaymoney

		$this->getUnionpaymoney         ="http://".ADDRESS."/cgi-bin/statistics/unionpaymoney/get?access_token=%s";
		$this->addUnionpaymoney         ="http://".ADDRESS."/cgi-bin/statistics/unionpaymoney/add";
		$this->modifyUnionpaymoney         ="http://".ADDRESS."/cgi-bin/statistics/unionpaymoney/modify";
		$this->deleteUnionpaymoney         ="http://".ADDRESS."/cgi-bin/statistics/unionpaymoney/delete?access_token=%s&row_id=%s";

		//OTA订单量otaorderamount";
		$this->getOtaorderamount         ="http://".ADDRESS."/cgi-bin/statistics/otaorderamount/get?access_token=%s";
		$this->addOtaorderamount         ="http://".ADDRESS."/cgi-bin/statistics/otaorderamount/add";
		$this->modifyOtaorderamount         ="http://".ADDRESS."/cgi-bin/statistics/otaorderamount/modify";
		$this->deleteOtaorderamount         ="http://".ADDRESS."/cgi-bin/statistics/otaorderamount/delete?access_token=%s&row_id=%s";

		//OTA订单额otaordermoney
		$this->getOtaordermoney         ="http://".ADDRESS."/cgi-bin/statistics/otaordermoney/get?access_token=%s";
		$this->addOtaordermoney         ="http://".ADDRESS."/cgi-bin/statistics/otaordermoney/add";
		$this->modifyOtaordermoney         ="http://".ADDRESS."/cgi-bin/statistics/otaordermoney/modify";
		$this->deleteOtaordermoney         ="http://".ADDRESS."/cgi-bin/statistics/otaordermoney/delete?access_token=%s&row_id=%s";

		//会员数据统计memberstatistic
		$this->getMemberstatistic         ="http://".ADDRESS."/cgi-bin/statistics/memberstatistic/get?access_token=%s";
		$this->addMemberstatistic         ="http://".ADDRESS."/cgi-bin/statistics/memberstatistic/add";
		$this->modifyMemberstatistic         ="http://".ADDRESS."/cgi-bin/statistics/memberstatistic/modify";
		$this->deleteMemberstatistic         ="http://".ADDRESS."/cgi-bin/statistics/memberstatistic/delete?access_token=%s&row_id=%s";

    }
    /**
     * 旅游经营场所
     *
     */
    public function getBusinessPlaceNumData($arr){
        $url =  sprintf($this->businessPlace,$arr['access_token']);
        if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if($arr["showtype"]!=""){
            $url.="&showtype=".urlencode($arr["showtype"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
        }
        if(!empty($arr["start_yearmonth"])&&($arr["start_yearmonth"])!=""){
            $url.="&start_yearmonth=".urlencode($arr["start_yearmonth"]);
        }
        if(!empty($arr["end_yearmonth"])&&($arr["end_yearmonth"])!=""){
            $url.="&end_yearmonth=".urlencode($arr["end_yearmonth"]);
        }
        if(!empty($arr["start_year"])&&($arr["start_year"])!=""){
            $url.="&start_year=".urlencode($arr["start_year"]);
        }
        if(!empty($arr["end_year"])&&($arr["end_year"])!=""){
            $url.="&end_year=".urlencode($arr["end_year"]);
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
    public function addBusinessPlaceNum($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addBusinessPlace, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyBusinessPlaceNum($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyBusinessPlace, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteBusinessPlaceNum($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteBusinessPlace,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
	*   旅游机构统计
	*
	*/
    public function getTravelAgency($arr){
        $url =  sprintf($this->travelAgency,$arr['access_token']);

       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if($arr["showtype"]!=""){
            $url.="&showtype=".urlencode($arr["showtype"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
        }
        if(!empty($arr["start_yearmonth"])&&($arr["start_yearmonth"])!=""){
            $url.="&start_yearmonth=".urlencode($arr["start_yearmonth"]);
        }
        if(!empty($arr["end_yearmonth"])&&($arr["end_yearmonth"])!=""){
            $url.="&end_yearmonth=".urlencode($arr["end_yearmonth"]);
        }
        if(!empty($arr["start_year"])&&($arr["start_year"])!=""){
            $url.="&start_year=".urlencode($arr["start_year"]);
        }
        if(!empty($arr["end_year"])&&($arr["end_year"])!=""){
            $url.="&end_year=".urlencode($arr["end_year"]);
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
    public function addTravelAgency($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addTravelAgency, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyTravelAgency($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyTravelAgency, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteTravelAgency($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteTravelAgency,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
    *   从业人员统计
    *
    */
    public function getTravelPractitionerData($arr){
        $url =  sprintf($this->travelPractitioner,$arr['access_token']);

       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if($arr["showtype"]!=""){
            $url.="&showtype=".urlencode($arr["showtype"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
        }
        if(!empty($arr["start_yearmonth"])&&($arr["start_yearmonth"])!=""){
            $url.="&start_yearmonth=".urlencode($arr["start_yearmonth"]);
        }
        if(!empty($arr["end_yearmonth"])&&($arr["end_yearmonth"])!=""){
            $url.="&end_yearmonth=".urlencode($arr["end_yearmonth"]);
        }
        if(!empty($arr["start_year"])&&($arr["start_year"])!=""){
            $url.="&start_year=".urlencode($arr["start_year"]);
        }
        if(!empty($arr["end_year"])&&($arr["end_year"])!=""){
            $url.="&end_year=".urlencode($arr["end_year"]);
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
    public function addTravelPractitionerData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addTravelPractitioner, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyTravelPractitionerData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyTravelPractitioner, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteTravelPractitionerData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteTravelPractitioner,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
    *   多媒体统计
    *
    */
    public function getMediaStatisticsData($arr){
        $url =  sprintf($this->mediaStatistics,$arr['access_token']);

       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if($arr["showtype"]!=""){
            $url.="&showtype=".urlencode($arr["showtype"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
        }
        if(!empty($arr["start_yearmonth"])&&($arr["start_yearmonth"])!=""){
            $url.="&start_yearmonth=".urlencode($arr["start_yearmonth"]);
        }
        if(!empty($arr["end_yearmonth"])&&($arr["end_yearmonth"])!=""){
            $url.="&end_yearmonth=".urlencode($arr["end_yearmonth"]);
        }
        if(!empty($arr["start_year"])&&($arr["start_year"])!=""){
            $url.="&start_year=".urlencode($arr["start_year"]);
        }
        if(!empty($arr["end_year"])&&($arr["end_year"])!=""){
            $url.="&end_year=".urlencode($arr["end_year"]);
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
    public function addMediaStatisticsData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addMediaStatistics, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyMediaStatisticsData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyMediaStatistics, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteMediaStatisticsData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteMediaStatistics,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
    *   旅游公共设施数据
    *
    */
    public function getTravelpublicutilities($arr){
        $url =  sprintf($this->travelpublicutilities,$arr['access_token']);

       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if($arr["showtype"]!=""){
            $url.="&showtype=".urlencode($arr["showtype"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
        }
        if(!empty($arr["start_yearmonth"])&&($arr["start_yearmonth"])!=""){
            $url.="&start_yearmonth=".urlencode($arr["start_yearmonth"]);
        }
        if(!empty($arr["end_yearmonth"])&&($arr["end_yearmonth"])!=""){
            $url.="&end_yearmonth=".urlencode($arr["end_yearmonth"]);
        }
        if(!empty($arr["start_year"])&&($arr["start_year"])!=""){
            $url.="&start_year=".urlencode($arr["start_year"]);
        }
        if(!empty($arr["end_year"])&&($arr["end_year"])!=""){
            $url.="&end_year=".urlencode($arr["end_year"]);
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
    public function addTravelpublicutilities($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addTravelpublicutilities, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyTravelpublicutilities($arr){

        $access_token =$arr['access_token'];
        print_r($arr);
        $getData = $this->post($this->modifyTravelpublicutilities, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteTravelpublicutilities($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteTravelpublicutilities,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
    *   景区门票销售金额数据
    *
    */
    public function getScenicTicketsalesmoneyData($arr){
        $url =  sprintf($this->scenicTicketsalesmoneyData,$arr['access_token']);
        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
       if($arr["type2"]!=""){
            $url.="&type2=".urlencode($arr["type2"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addScenicTicketsalesmoneyData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addScenicTicketsalesmoneyData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyScenicTicketsalesmoneyData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyScenicTicketsalesmoneyData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteScenicTicketsalesmoneyData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteScenicTicketsalesmoneyData,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
    *   景区门票销售量数据
    *
    */
    public function getScenicTicketsalesamountData($arr){
        $url =  sprintf($this->scenicTicketsalesamountData,$arr['access_token']);



        if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
            $url.="&pageNo=".urlencode($arr["pageNo"]);
        }
        if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
            $url.="&pageNum=".urlencode($arr["pageNum"]);
        }
       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
       if($arr["type2"]!=""){
            $url.="&type2=".urlencode($arr["type2"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addScenicTicketsalesamountData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addScenicTicketsalesamountData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyScenicTicketsalesamountData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyScenicTicketsalesamountData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteScenicTicketsalesamountData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteScenicTicketsalesamountData,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }

    /**
    *   景区游客流量数据
    *
    */
    public function getTouristTrafficData($arr){
        $url =  sprintf($this->touristTrafficData,$arr['access_token']);

        if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
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
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addTouristTrafficData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addTouristTrafficData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyTouristTrafficData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyTouristTrafficData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteTouristTrafficData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteTouristTrafficData,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }


    /**
    *   游客人员构成统计
    *
    */
    public function getTouristsAnalysisData($arr){
        $url =  sprintf($this->touristsAnalysisData,$arr['access_token']);

       if($arr["type"]!=""){
            $url.="&type=".urlencode($arr["type"]);
        }
        if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
            $url.="&destination_id=".urlencode($arr["destination_id"]);
        }
        if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
            $url.="&start_date=".urlencode($arr["start_date"]);
        }
        if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
            $url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addTouristsAnalysisData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->addTouristsAnalysisData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function modifyTouristsAnalysisData($arr){

        $access_token =$arr['access_token'];
        $getData = $this->post($this->modifyTouristsAnalysisData, $arr);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }
    public function deleteTouristsAnalysisData($arr){

        $access_token =$arr['access_token'];
        $row_id = $arr["row_id"];
        $url =  sprintf($this->deleteTouristsAnalysisData,$access_token,$row_id);
        $getData = file_get_contents($url);
        $getData=json_decode($getData,true);
        echo json_encode($getData);
    }





    /**
     *   旅游线路统计
     *
     */
    public function getTouristroute($arr){
    	$url =  sprintf($this->getTouristroute,$arr['access_token']);

    	if($arr["type"]!=""){
    		$url.="&type=".urlencode($arr["type"]);
    	}
    	if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
    		$url.="&destination_id=".urlencode($arr["destination_id"]);
    	}
    	if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
    		$url.="&start_date=".urlencode($arr["start_date"]);
    	}
    	if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
    		$url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addTouristroute($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addTouristroute, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifyTouristroute($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifyTouristroute, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function deleteTouristroute($arr){

    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteTouristroute,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    /**
     *   银联消费额统计
     *
     */
    public function getUnionpaymoney($arr){
    	$url =  sprintf($this->getUnionpaymoney,$arr['access_token']);

    	if($arr["type"]!=""){
    		$url.="&type=".urlencode($arr["type"]);
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
    	if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
    		$url.="&start_date=".urlencode($arr["start_date"]);
    	}
    	if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
    		$url.="&end_date=".urlencode($arr["end_date"]);
    	}
      if(!empty($arr["pageNo"])&&($arr["pageNo"])!=""){
          $url.="&pageNo=".urlencode($arr["pageNo"]);
      }
      if(!empty($arr["pageNum"])&&($arr["pageNum"])!=""){
          $url.="&pageNum=".urlencode($arr["pageNum"]);
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
    public function addUnionpaymoney($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addUnionpaymoney, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifyUnionpaymoney($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifyUnionpaymoney, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function deleteUnionpaymoney($arr){

    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteUnionpaymoney,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    /**
     *   OTA订单量
     *
     */
    public function getOtaorderamount($arr){
    	$url =  sprintf($this->getOtaorderamount,$arr['access_token']);

    	if($arr["type"]!=""){
    		$url.="&type=".urlencode($arr["type"]);
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
    	if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
    		$url.="&start_date=".urlencode($arr["start_date"]);
    	}
    	if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
    		$url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addOtaorderamount($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addOtaorderamount, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifyOtaorderamount($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifyOtaorderamount, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function deleteOtaorderamount($arr){

    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteOtaorderamount,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    /**
     *   OTA订单额
     *
     */
    public function getOtaordermoney($arr){
    	$url =  sprintf($this->getOtaordermoney,$arr['access_token']);

    	if($arr["type"]!=""){
    		$url.="&type=".urlencode($arr["type"]);
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
    	if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
    		$url.="&start_date=".urlencode($arr["start_date"]);
    	}
    	if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
    		$url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addOtaordermoney($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addOtaordermoney, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifyOtaordermoney($arr){
    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifyOtaordermoney, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function deleteOtaordermoney($arr){

    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteOtaordermoney,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    /**
     *  会员数据统计
     *
     */
    public function getMemberstatistic($arr){
    	$url =  sprintf($this->getMemberstatistic,$arr['access_token']);

    	if($arr["type"]!=""){
    		$url.="&type=".urlencode($arr["type"]);
    	}
    	if(!empty($arr["destination_id"])&&($arr["destination_id"])!=""){
    		$url.="&destination_id=".urlencode($arr["destination_id"]);
    	}
    	if(!empty($arr["start_date"])&&($arr["start_date"])!=""){
    		$url.="&start_date=".urlencode($arr["start_date"]);
    	}
    	if(!empty($arr["end_date"])&&($arr["end_date"])!=""){
    		$url.="&end_date=".urlencode($arr["end_date"]);
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
    public function addMemberstatistic($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->addMemberstatistic, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function modifyMemberstatistic($arr){

    	$access_token =$arr['access_token'];
    	$getData = $this->post($this->modifyMemberstatistic, $arr);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }
    public function deleteMemberstatistic($arr){

    	$access_token =$arr['access_token'];
    	$row_id = $arr["row_id"];
    	$url =  sprintf($this->deleteMemberstatistic,$access_token,$row_id);
    	$getData = file_get_contents($url);
    	$getData=json_decode($getData,true);
    	echo json_encode($getData);
    }


///////////////////////////////////////////////////////////////////////

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
