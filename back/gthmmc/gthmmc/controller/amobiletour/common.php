<?php
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';

class WCommon extends SController{

	private $dbUrl = '';
	private $ssoUrl = '';
	private $systemId = 'AMG';
	private $appid = 'appid';
	private $secret = 'appsecret';
	private $authorizeUrl;
	private $tokenUrl;
	private $getUserUrl;
	private $getRightUrl;
	private $logout;
	private $dbToken;

	function __construct() {
		parent::__construct();
		$config = SuperPHP::getConfig();
		$this->dbUrl=$config['dbUrl'];
		$this->ssoUrl=$config['ssoUrl'];
		$this->authorizeUrl = "http://$this->ssoUrl/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=code&scope=read";
		$this->tokenUrl = "http://$this->ssoUrl/cgi-bin/token?grant_type=authorization_code&appid=%s&secret=%s&redirect_uri=%s&code=%s";
		$this->getUserUrl = "http://$this->ssoUrl/cgi-bin/getUser?access_token=%s";
		$this->getRightUrl = "http://$this->ssoUrl/cgi-bin/getRight?access_token=%s&system=%s";
		$this->logout = "http://$this->ssoUrl/j_spring_security_logout?redirect_uri=%s";
		$this->dbToken = "http://$this->dbUrl/cgi-bin/token?grant_type=client_credentials&appid=%s&secret=%s";
		//$this->getRight = "http://$this->dbUrl/cgi-bin/manage/right/get?access_token=%s&system=%s";
		$this->addlog="http://$this->dbUrl/cgi-bin/manage/log/add";
	}
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
	 *
	 * 单点登录验证
	 */
	public function ssoCheck(){
		$authorizeUrl = $this->authorizeUrl;
		$tokenUrl = $this->tokenUrl;
		$getUserUrl = $this->getUserUrl;
		$logout = $this->logout;
		$getRightUrl = $this->getRightUrl;
		$appid = $this->appid;
		$secret = $this->secret;
		session_start();
		$curl = $this->getLibrary("curl");
		$c_sso = $_COOKIE['sso'];
		$s_sso = $_SESSION['sso'];
		//echo $c_sso . '-' . $s_sso . ';' . $_SESSION['systemId'] . '-' . $this->systemId;
		if (empty($c_sso) || $c_sso != $s_sso||$_SESSION['systemId']!=$this->systemId){
			$code = $_GET['code'];
			$redirect_uri = $this->getRedirecturi();
			if (empty($code)){
				$authorizeUrl = sprintf($authorizeUrl, $appid, $redirect_uri);
				$_SESSION['login_page'] = $_GET['login_page'];
				$_SESSION['title'] = $_GET['t'];
				$_SESSION['logo'] = $_GET['l'];
				$_SESSION['style'] = $_GET['style'];
				header("Location: " . $authorizeUrl);
			}else{
				$tokenUrl = sprintf($tokenUrl, $appid, $secret, $redirect_uri, $code);
				$data = $curl->post($tokenUrl,$data);
				$dataObj = json_decode($data, true);
				$token = $dataObj['access_token'];
				if (!empty($token)){
					$getUserUrl = sprintf($getUserUrl, $token);
					$data = $curl->get($getUserUrl);
					$dataObj = json_decode($data, true);
					if ($dataObj['errcode'] == '0'){
						$user = $dataObj['data'];
						$deadline = $user['deadline'];
						$logoutUrl = $this->getLogoutUrl();
						if ($user['is_nolimit'] == "0" && strtotime(date("Y-m-d")) > strtotime($deadline)){
							header("Location: $logoutUrl");
						}else{
							$type = $user['type'];
							//$dataToken = $this->getToken();
							$getRightUrl = sprintf($getRightUrl, $token, $this->systemId);
							$allRight = $curl->get($getRightUrl);
							$getData = json_decode($allRight, true);
							if (!empty($getData) && $getData['errcode'] == 0){
								foreach ($getData['data']['list'] as $value){
									$allRightArr[$value['name']] = $value['right_value'];
								}
							}
							$allThisRightArr[$this->systemId] = $allRightArr;
							$allThisRight = json_encode($allThisRightArr);
							$right = '';
							$flag = false;
							switch ($type){
								case "0": //0：超级用户
									$right = $allThisRight;
									$flag = true;
									break;
								case "1":  //1：管理用户
									$system = $user['system'];
									if (strpos($system, $this->systemId) !== false){
										$right = $allThisRight;
										$flag = true;
									}
									break;
								case "2":  //2：普通用户
									$right = $user['right'];
									break;
							}
							$rightArr = json_decode($right, true);
							$thisRightArr = $rightArr[$this->systemId];
							if ($flag || !empty($thisRightArr)){
								$_SESSION['right'] = $thisRightArr;
								$_SESSION['allRight'] = $allRightArr;
								$_SESSION['user'] = $user;
								$_SESSION['sso'] = $code;
								$_SESSION['systemId'] = $this->systemId;
								setcookie("sso", $_SESSION['sso'], time() + 7200);
							}else {
								header("Location: $logoutUrl");
							}
						}
					}
				}else{
					header("Location: $redirect_uri");
				}
			}
		}
	}
	/**
	 *
	 * 获取登录帐户操作权限
	 */
	public function getOpRight(){
		$allRightArr = $_SESSION['allRight'];
		$thisRightArr =	$_SESSION['right'];
		foreach ($allRightArr as $key=>$value){
			$rigthArr[$key] = false;
			foreach ($thisRightArr as $value1){
				if (strpos($value1, $value) === 0){
					$rigthArr[$key] = true;
				}
			}
		}
		return $rigthArr;
	}

	/**
	 *
	 * 获取当前的访问url
	 */
	public function getRedirecturi($out){
		$redirect_uri = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		if ($_SERVER["SERVER_PORT"] == '80'){
			$redirect_uri = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		}
		$urlArray = explode('?', $redirect_uri);
		$redirect_uri = $urlArray[0];
		if (count($urlArray) > 1){
			$paramArray = explode('&', $urlArray[1]);
			$index = -1;
			foreach ($paramArray as $key=>$value){
				if (strpos($value, 'code') === 0){
					$index = $key;
					break;
				}
			}
			if ($index >= 0){
				array_splice($paramArray, $index,1);
			}
			if($out){
	        	$param = implode('&', $paramArray);
			}else{
						$param = implode('%26', $paramArray);
			}
		}
		if (!empty($param)){
			$redirect_uri = $redirect_uri . '?' . $param;
		}
		return $redirect_uri;
	}
	/**
	 *
	 * 获取注销URL
	 */
	public function getLogoutUrl(){
		$loginPage = $_SESSION['login_page'];
		$title = $_SESSION['title'];
		$logo = $_SESSION['logo'];
		$out=true;
		$sRedirecturi = $this->getRedirecturi($out);
		if (!empty($loginPage)){
			$loginPage = '&login_page=' . $loginPage . '&t=' . $title . '&l=' . $logo;
			$sRedirecturi .= $loginPage;
		}
		return sprintf($this->logout, $sRedirecturi);
	}
	/**
	 *
	 * 获取数据访问地址
	 */
	public function getDbUrl(){
		return $this->DbUrl;
	}
	/**
	 *
	 * 获取单点登录访问地址
	 */
	public function getSsoUrl(){
		return $this->ssoUrl;
	}
	/**
	 *
	 * 获取用户信息
	 */
	public function getUser(){
		return $_SESSION['user'];
	}

	/**
	 *
	 * 新增系统日志
	 */
	public function addlog($arr){

		$ip='';
		if(!empty( $_SERVER["REMOTE_ADDR"])){
			$ip= $_SERVER["REMOTE_ADDR"];
		}
		$arr["ip"] = $ip;

		$getData = $this->post($this->addlog, $arr);
	}


	/**********************以下以后删除*************************/

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

	public  function object_array($array) {
		if(is_object($array)) {
			$array = (array)$array;
		} if(is_array($array)) {
			foreach($array as $key=>$value) {
				$array[$key] = object_array($value);
			}
		}
		return $array;
	}



	/**
	 *
	 * get提交
	 * @param unknown_type $url
	 * @param unknown_type $proxy
	 * @param unknown_type $timeout
	 * @throws Exception
	 */
	public function get($url, $proxy = null, $timeout = 10) {
		if (!$url) return false;
		$ssl = substr($url, 0, 8) == 'https://' ? true : false;
		$curl = curl_init();
		if (!is_null($proxy)) curl_setopt ($curl, CURLOPT_PROXY, $proxy);
		curl_setopt($curl, CURLOPT_URL, $url);
		if ($ssl) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		}
		curl_setopt($curl, CURLOPT_SSLVERSION, 4);  //传递一个包含SSL版本的长参数。默认PHP将被它自己努力的确定，在更多的安全中你必须手工设置
		//$cookie_file = $this->get_cookie_file();
		//curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file); //连接结束后保存cookie信息的文件。
		//curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);//包含cookie数据的文件名，cookie文件的格式可以是Netscape格式，或者只是纯HTTP头部信息存入文件。
		//curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。
		curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //文件流形式
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数。

		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1"); //重要，必须有
		curl_setopt($curl, CURLINFO_CONTENT_TYPE, "application/x-www-form-urlencoded");  //重要，必须有

		$content = curl_exec($curl);
		$curl_errno = curl_errno($curl);

		if ($curl_errno > 0) {
			//throw new Exception($curl_errno);
			echo 'Error:'.curl_error($curl);//捕抓异常
			curl_close($curl);
			return false;
		}
		curl_close($curl);
		return $content;
	}
	/**
	 * 获取COOKIE存放文件的地址
	 */
	public function get_cookie_file() {
		return APP_PATH . $this->cookie;
	}

}
