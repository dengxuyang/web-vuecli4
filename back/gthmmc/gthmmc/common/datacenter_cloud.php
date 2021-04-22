<?php

require_once dirname(__FILE__) . '/../../superphp/core/controller/scontroller.php';
class datacenterCloud extends SController{
    //定义token
    private $gettoken;
    //查询
    private $getData;
    //新增
    private $addData;
    //修改
    private $modifyData;
    //删除
    private $deleteData;

	private $cloudUrl = '';

    private $appid = 'appid';

    private $secret = 'appsecret';

    private $statistics;

    function __construct() {
        parent::__construct();//
		$config = SuperPHP::getConfig();
		$this->cloudUrl=$config['cloudUrl'];
        //查询
        $this->getData="http://".$this->cloudUrl."/cgi-bin/basic/resource/get?access_token=%s";
        //新增
        $this->addData="http://".$this->cloudUrl."/cgi-bin/basic/resource/add?access_token=%s";
        //修改
        $this->modifyData="http://".$this->cloudUrl."/cgi-bin/basic/resource/modify?access_token=%s";
        //删除
        $this->deleteData="http://".$this->cloudUrl."/cgi-bin/basic/resource/delete";
        //实时统计
        $this->statistics="http://".$this->cloudUrl."/cgi-bin/basic/resource/activeStatistics";
        //完整统计
        $this->completeStatistics="http://".$this->cloudUrl."/cgi-bin/basic/resource/completeStatistics";

        //获取token
        $this->dbToken = "http://".$this->cloudUrl."/cgi-bin/token?appid=%s&secret=%s&grant_type=client_credentials";

    }


    /*
     *获取token
     */

//获取数据访问access_token
    public function getToken(){
        $appid = $this->appid;
        $secret = $this->secret;
        $url = sprintf($this->dbToken, $appid, $secret);
        $curl = $this->getLibrary("curl");
        $resData = $curl->post($url, null);
        $resData = json_decode($resData,true);
        return $resData["access_token"];
    }

    /**
     * 查询资源
     */
    public function getresources($arr,$directory_code,$pageNo,$pageNum,$type){
      $newData['access_token']=$this->getToken() ;
      $newData['directory_code']=$directory_code;
      $newData['pageNo']=$pageNo;
      $newData['pageNum']= $pageNum;
      if(!empty($type)){
          $newData['type']= $type;
      }
      if(!empty($arr)){

          $newData['datajson']=  str_replace("\u00a0"," ",json_encode($arr));;
      }

      $getData = $this->post($this->getData, $newData);
      $getData=json_decode($getData,true);
      return  $getData;
    }

 /**
  * 新增资源
  *
  */
    public function addresources($arr,$directory_code,$type){
        $newData['access_token']=$this->getToken() ;
        $newData['directory_code']=$directory_code;
        if(!empty($type)){
            $newData['type']= $type;
        }
        if(!empty($arr)){
            $newData['datajson']=json_encode($arr);
        }

        $getData = $this->post($this->addData, $newData);
        $getData=json_decode($getData,true);
        return  $getData;
    }

   /**
    * 修改资源
    */
    public function modifyresources($arr,$directory_code,$row_id,$type,$wherejson){
        $newData['access_token']=$this->getToken() ;
        $newData['directory_code']=$directory_code;
        $newData['row_id']=$row_id;
        if(!empty($type)){
            $newData['type']= $type;
        }
        if(!empty($arr)){
            $newData['datajson']=json_encode($arr);
        }
        if(!empty($wherejson)){
            $newData['wherejson']= json_encode($wherejson);
        }
        $getData = $this->post($this->modifyData, $newData);
        $getData=json_decode($getData,true);
        return  $getData;
    }

    /**
     * 删除资源
     *
     */
    public function deleteresources($row_id,$directory_code,$type){
        $arr['access_token']=$this->getToken() ;
        $arr['directory_code']=$directory_code;
        $arr['row_id']=$row_id;
        if(!empty($type)){
            $arr['type']= $type;
        }
        $getData = $this->get($this->deleteData, $arr);
        $getData=json_decode($getData,true);
        return  $getData;

    }


    /**
     * 统计资源
     */


    public function activeStatistics($arr,$directory_code,$group,$type,$sumfield,$otherfield){
      $newData['access_token']=$this->getToken() ;
      $newData['directory_code']=$directory_code;
      if(!empty($type)){
          $newData['type']= $type;
      }
      if(!empty($arr)){
          $newData['datajson']=json_encode($arr);
      }
      if(!empty($group)){
          $newData['group']= $group;
      }
      if(!empty($sumfield)){
          $newData['sumfield']= $sumfield;
      }
      if(!empty($otherfield)){
          $newData['otherfield']= $otherfield;
      }
      $getData = $this->post($this->statistics, $newData);
      $getData=json_decode($getData,true);
      return  $getData;
    }

    /**
     * 统计资源
     */


    public function completeStatistics($arr,$directory_code,$type){
      $newData['access_token']=$this->getToken() ;
      $newData['directory_code']=$directory_code;
      if(!empty($type)){
          $newData['type']= $type;
      }
      if(!empty($arr)){
          $newData['datajson']=json_encode($arr);
      }
      $newData['group']= "1";
      $getData = $this->post($this->completeStatistics, $newData);
      $getData=json_decode($getData,true);
      return  $getData;
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



    public function get($url,$data){
    $getdata = http_build_query(
        $data
    );
    $result = file_get_contents($url.'?'. $getdata);
    return $result;
}
}
