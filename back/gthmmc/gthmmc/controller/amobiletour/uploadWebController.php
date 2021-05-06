<?php
require_once dirname(__FILE__) . '/../../../superphp/core/controller/scontroller.php';

class uploadWebController extends SController{
	function __construct() {
		parent::__construct();
		$this->SetWhiteList(array("imageUpload", "voiceUpload","videoUpload", "editorUpload", "logoUpload","fileUpload", "cropImgae"));
	}
	public function before(){
		//require_once dirname(__FILE__) . '/../../common/sessionExpire.php';
	}
	/**
	 *
	 * 默认文件上传
	 */
	public function run(){
	}
	/**
	 *
	 * 单个图片上传
	 */
	public function imageUpload(){
		$config = SuperPHP::getConfig();
		$targetFolder = $config['uploadPath'];

		$response=array(
			'result'=>-1,  //上传结果代码，0表示成功，－1表示失败
	        'message'=>'未知上传错误',
	        'path'=>'',
	        'width'=>100,
	        'height'=>100,
		);

		if (!empty($_FILES)) {
			$tempFile = str_replace('\\\\', '\\', $_FILES['Filedata']['tmp_name']);
			$targetPath = $targetFolder;
			$fileTypes = array('jpg','jpeg','gif','png');
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				if ( file_exists($tempFile)){
					$targetPath = rtrim($targetPath ,'/') . "/" . "imageLibrary/images/" . date("Ymd");
					//$this->create_dir($targetPath);
					$this->create_dir(dirname(__FILE__) . "/../../" . $targetPath);
					//获得文件扩展名
					$temp_arr = explode(".", $_FILES['Filedata']['name']);
					$file_ext = array_pop($temp_arr);
					$file_ext = trim($file_ext);
					$file_ext = strtolower($file_ext);
					//新文件名
					$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
					$targetFile = rtrim($targetPath,'/') . '/' . $new_file_name;
					//move_uploaded_file($tempFile,$targetFile);
					move_uploaded_file($tempFile,dirname(__FILE__) . "/../../" . $targetFile);
					$response["result"] = 0;
					$response["message"] = "图片上传成功";
					$response["path"] = $targetFile;
					//获取图像的高度与宽度
					$fileName=iconv("utf-8","gb2312",$targetFile);
					list($width,$height)=getimagesize($fileName);

					if($width>1000||$height>1000){    //小于5K
					    //  $this->autoImageCrop($targetFile,1000,1000);
					}
					$response["result"]="1";
					$response["width"]=$width;
					$response["height"]=$height;

					//echo $targetFile;
				}
			} else {

				$response["message"] = "Invalid file type.";
			}
		}
		echo json_encode($response);
	}
	/**
	 *
	 * 图片自动裁剪
	 */
	public function autoImageCrop($imagePath,$width,$height){

		$libObj = $this->getLibrary("imageSuper");
		$libObj->cutImage($imagePath, $imagePath, $width, $height);
		//$response["result"] = true;
		echo ok;
		//echo json_encode($response);
	}
	/**
	 *
	 * 单个文件上传
	 */
	public function fileUpload(){

		$config = SuperPHP::getConfig();
		$targetFolder = $config['uploadPath'];//'../upload';
		$response=array(
				'result'=>-1,  //上传结果代码，0表示成功，－1表示失败
				'message'=>'未知上传错误',
				'path'=>'',
				'width'=>100,
				'height'=>100,
		);
		if (!empty($_FILES)) {
			$tempFile = str_replace('\\\\', '\\', $_FILES['Filedata']['tmp_name']);
			$targetPath = $targetFolder;

			$fileTypes = array('rar','zip','docx','.doc','xls','xlsx');
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				if ( file_exists($tempFile)){
					$targetPath = rtrim($targetPath ,'/') . "/" . "fileLibrary/files/" . date("Ymd");
					$this->create_dir($targetPath);

					//获得文件扩展名
					$temp_arr = explode(".", $_FILES['Filedata']['name']);
					$file_ext = array_pop($temp_arr);
					$file_ext = trim($file_ext);
					$file_ext = strtolower($file_ext);
					//新文件名
					$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
					$targetFile = rtrim($targetPath,'/') . '/' . $new_file_name;

					move_uploaded_file($tempFile,$targetFile);


					$response["result"]="1";
					$response["message"] = "上传成功";
					$response["path"] = $targetFile;
				}
			} else {
				$response["message"] = "Invalid file type.";
			}
		}

		echo json_encode($response);
	}
	/**
	 *
	 * 单个语音上传  			$fileTypes = array('mp3','wma','wav','amr');
	 */
	public function voiceUpload(){
 ;
		$config = SuperPHP::getConfig();
		echo '[00]';
		$targetFolder = $config['uploadPath'];
		$response=array(
				'result'=>-1,  //上传结果代码，0表示成功，－1表示失败
				'message'=>'未知上传错误',
				'path'=>'',
		);
		echo '[01]';
		if (!empty($_FILES)) {
			$tempFile = str_replace('\\\\', '\\', $_FILES['Filedata']['tmp_name']);
			$targetPath = $targetFolder;
	        $fileTypes = array('mp3','wma','wav','amr');
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$response["name"] = $fileParts;
			echo '[02]';
			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				echo '[03]';
				if ( file_exists($tempFile)){
					echo '[04]';
					$targetPath = rtrim($targetPath ,'/') . "/" . "videoLibrary/video/" . date("Ymd");
					//$this->create_dir($targetPath);
					$this->create_dir(dirname(__FILE__) . "/../../" . $targetPath);
					//获得文件扩展名
					$temp_arr = explode(".", $_FILES['Filedata']['name']);
					$file_ext = array_pop($temp_arr);
					$file_ext = trim($file_ext);
					$file_ext = strtolower($file_ext);
					//新文件名
					$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
					$targetFile = rtrim($targetPath,'/') . '/' . $new_file_name;
					//move_uploaded_file($tempFile,$targetFile);
					move_uploaded_file($tempFile,dirname(__FILE__) . "/../../" . $targetFile);
					$response["result"]="1";
					$response["message"] = "音频上传成功";
					$response["path"] = $targetFile;
				}
			} else {
				$response["message"] = "Invalid file type.";
			}
		}
		echo json_encode($response);
	}
	/**
	 *
	 * 单个视频上传
	 */
	public function videoUpload(){

		$config = SuperPHP::getConfig();
		$targetFolder = $config['uploadPath'];
		$response=array(
				'result'=>-1,  //上传结果代码，0表示成功，－1表示失败
				'message'=>'未知上传错误',
				'path'=>'',
		);

		if (!empty($_FILES)) {
			$tempFile = str_replace('\\\\', '\\', $_FILES['Filedata']['tmp_name']);
			$targetPath = $targetFolder;
			$fileTypes = array('rm','rmvb','wmv','avi','mpg','mpeg','mp4','mp3','wma','wav','amr');
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$response["name"] = $fileParts;
			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				if ( file_exists($tempFile)){
					$targetPath = rtrim($targetPath ,'/') . "/" . "videoLibrary/video/" . date("Ymd");
					//$this->create_dir($targetPath);
					$this->create_dir(dirname(__FILE__) . "/../../" . $targetPath);
					//获得文件扩展名
					$temp_arr = explode(".", $_FILES['Filedata']['name']);
					$file_ext = array_pop($temp_arr);
					$file_ext = trim($file_ext);
					$file_ext = strtolower($file_ext);
					//新文件名
					$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
					$targetFile = rtrim($targetPath,'/') . '/' . $new_file_name;
					//move_uploaded_file($tempFile,$targetFile);
					move_uploaded_file($tempFile,dirname(__FILE__) . "/../../" . $targetFile);
					$response["result"]="1";
					$response["message"] = "视频上传成功";
					$response["path"] = $targetFile;
				}
			} else {
				$response["message"] = "Invalid file type.";
			}
		}
		echo json_encode($response);
	}
	/**
	 *
	 * 企业logo上传
	 */
	public function logoUpload(){
		$config = SuperPHP::getConfig();
		$targetFolder = $config['uploadPath']; //相对于admin目录
		if (!empty($_FILES)) {
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$tempFile = str_replace('\\\\', '\\', $_FILES['Filedata']['tmp_name']);//realpath($_FILES['Filedata']['tmp_name']);
			$targetPath = $targetFolder;//$_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$this->create_dir($targetPath);
			$getSession = $this->getUtil("session");
			$accountData = $getSession->get("accountData");
			$targetFile = rtrim($targetPath,'/') . '/imageLibrary/uploadLogo' . $accountData["row_id"] . '.' . strtolower($fileParts['extension']);

			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions


			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				if ( file_exists($tempFile)){
					move_uploaded_file($tempFile,$targetFile);
					echo $targetFile;
				}
			} else {
				echo 'Invalid file type.';
			}
		}
	}
	/**
	 *
	 * 编辑器文件上传
	 */
	public function editorUpload(){
		//$php_path = dirname(__FILE__) . '/';
		$config = SuperPHP::getConfig();
		$php_url = dirname($_SERVER['PHP_SELF']) . '/';

		//文件保存目录路径
		//$save_path = $php_path . '../attached/';
		$save_path = $config['uploadPath'];//"../upload";
		$this->create_dir($save_path);
		//文件保存目录URL
		$save_url = $php_url .  rtrim($save_path ,'/') . "/";//'../upload/';
		//定义允许上传的文件扩展名
		$ext_arr = array(
						'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
						'flash' => array('swf', 'flv'),
						'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
						'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//最大文件大小
		$max_size = 1000000;
		$save_path = realpath($save_path) . '/';
		//PHP上传失败
		if (!empty($_FILES['imgFile']['error'])) {
			switch($_FILES['imgFile']['error']){
				case '1':
					$error = '超过php.ini允许的大小。';
					break;
				case '2':
					$error = '超过表单允许的大小。';
					break;
				case '3':
					$error = '图片只有部分被上传。';
					break;
				case '4':
					$error = '请选择图片。';
					break;
				case '6':
					$error = '找不到临时目录。';
					break;
				case '7':
					$error = '写文件到硬盘出错。';
					break;
				case '8':
					$error = 'File upload stopped by extension。';
					break;
				case '999':
				default:
					$error = '未知错误。';
			}
			$this->alert($error);
		}
		//有上传文件时
		if (empty($_FILES) === false) {
			//原文件名
			$file_name = $_FILES['imgFile']['name'];
			//服务器上临时文件名
			$tmp_name = str_replace('\\\\', '\\', $_FILES['imgFile']['tmp_name']);// $_FILES['imgFile']['tmp_name'];
			//文件大小
			$file_size = $_FILES['imgFile']['size'];
			//检查文件名
			if (!$file_name) {
				$this->alert("请选择文件。");
			}
			//检查目录
			if (@is_dir($save_path) === false) {
				$this->alert("上传目录不存在。");
			}
			//检查目录写权限
			if (@is_writable($save_path) === false) {
				$this->alert("上传目录没有写权限。");
			}
			//检查是否已上传
			if (@is_uploaded_file($tmp_name) === false) {
				$this->alert("上传失败。" . $tmp_name);
			}
			//检查文件大小
			if ($file_size > $max_size) {
				$this->alert("上传文件大小超过限制。");
			}
			//检查目录名
			$dir_name = empty($_GET['dir']) ? 'imageLibrary/images' : trim($_GET['dir']);
			if (empty($ext_arr[$dir_name])) {
				$this->alert("目录名不正确。");
			}
			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
				$this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
			}
			//创建文件夹
			if ($dir_name !== '') {
				$save_path .= $dir_name . "/";
				$save_url .= $dir_name . "/";
				if (!file_exists($save_path)) {
					mkdir($save_path);
				}
			}
			$ymd = date("Ymd");
			$save_path .= $ymd . "/";
			$save_url .= $ymd . "/";
			if (!file_exists($save_path)) {
				mkdir($save_path);
			}
			//新文件名
			$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
			//移动文件
			$file_path = $save_path . $new_file_name;
			if (move_uploaded_file($tmp_name, $file_path) === false) {
				//$this->alert("上传文件失败。");
				$this->alert($tmp_name . ";" . $file_path);
			}
			@chmod($file_path, 0644);
			$file_url = $save_url . $new_file_name;

			header('Content-type: text/html; charset=UTF-8');

			echo json_encode(array('error' => 0, 'url' => $file_url));
		}
	}
	/**
	 *
	 * 上传图象剪裁
	 */
	public function cropImgae($type,$myarray){
		//去掉反斜杠
		$dataJson = stripslashes($_POST['data']);
		if($type==1){
		 $dataArray=$myarray;
		$x=$dataArray["x1"];
		$y=$dataArray["y1"];
		$scale=$dataArray["scale"];
		$cropWidth=$dataArray["cropWidth"];
		$cropHeight=$dataArray["cropHeight"];
		$path=$dataArray["path"];
		}else{
		 $dataArray = json_decode($dataJson);
		$x=$dataArray->x1;
		$y=$dataArray->y1;
		$scale=$dataArray->scale;
		$cropWidth=$dataArray->cropWidth;
		$cropHeight=$dataArray->cropHeight;
		$path=$dataArray->path;
		}

		$response = new stdClass();
		$response->result = false;
		$response->width = $cropWidth;
		$response->height = $cropHeight;

		$realX=$x/$scale;
		$realY=$y/$scale;
		$realWidth=$cropWidth/$scale;
		$realHeight=$cropHeight/$scale;
		$res = $this->imageCrop($path, $realX, $realY, $realWidth, $realHeight);
		$response->result = $res["result"];
		$response->path = $res["path"];
		$response->src = $res["path"] . '?' . time();

		echo json_encode($response);
	}
	/**
	 *
	 * 图片裁剪
	 * @param unknown_type $image
	 * @param unknown_type $x
	 * @param unknown_type $y
	 * @param unknown_type $w
	 * @param unknown_type $h
	 */
	private function imageCrop($imagePath, $x, $y, $w, $h)
	{
		$result = array("result"=>false,"path"=>"");
		$ext = strtolower(strrchr($imagePath,'.'));
		switch ($ext){
			case ".jpg":
				$image = imagecreatefromjpeg($imagePath);
				break;
			case ".gif":
				$image = imagecreatefromgif($imagePath);
				break;
			case ".png":
				$image = imagecreatefrompng($imagePath);
				imagesavealpha($image, true);
				break;
		}

		$tw = imagesx($image);
		$th = imagesy($image);
		if ($x > $tw || $y > $th || $w > $tw || $h > $th){
			return false;
		}

		//echo "path:" . $imagePath . "w:" . $tw . ",h:" . $th;
		$temp = imagecreatetruecolor($w, $h);
		imagecopyresampled($temp, $image, 0, 0, $x, $y, $w, $h, $w, $h);
		$dirName = dirname($imagePath);
		$fileName = basename($imagePath);
		$fileExt = strrchr($fileName, '.');
		$tofilename = $dirName . "/" . date("YmdHis") . '_' . rand(10000, 99999) . $fileExt;
		$result["path"] = $tofilename;
		//$tofilename=iconv("utf-8","gb2312",$imagePath);
		switch ($ext){
			case ".jpg":
				$result["result"] = imagejpeg($temp,$tofilename);
				break;
			case ".gif":
				$result["result"] = imagegif($temp,$tofilename);
				break;
			case ".png":

				$result["result"] = imagepng($temp,$tofilename);
				break;
		}
		return $result;
	}
	/**
	 *	创建目录
	 * 	@param  string  $path   目录
	 *  @return
	 */
	private function create_dir($path) {
		if (is_dir($path)) return false;
		$this->create_dir(dirname($path));
		@mkdir($path);
		@chmod($path, 0777);
		return true;
	}
	private function alert($msg) {
		header('Content-type: text/html; charset=UTF-8');
		echo json_encode(array('error' => 1, 'message' => $msg));
		exit;
	}
}
