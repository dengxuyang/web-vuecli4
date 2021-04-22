<?php
$config = SuperPHP::getConfig();
define("ADDRESS",$config['dbUrl']);
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';
class tokenController extends SController{
	private $gettoken;

	function __construct() {
		
       //获取token
       $this->gettoken="http://".ADDRESS."/cgi-bin/token";
	
	}


    public function gettoken(){
    	$arr["appid"]='appid';
    	$arr["secret"]='appsecret';
    	$arr["grant_type"]='client_credentials';
        $getData = $this->post($this->gettoken, $arr);
        $getData=json_decode($getData,true);
		return $getData["access_token"];
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