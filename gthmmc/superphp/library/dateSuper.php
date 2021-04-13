<?php
class dateSuper  {
	private $Month_E = array(1  => "January",
	2  => "February",
	3  => "March",
	4  => "April",
	5  => "May",
	6  => "June",
	7  => "July",
	8  => "August",
	9  => "September",
	10 => "October",
	11 => "November",
	12 => "December");
	/**
	 *
	 * 数字月份转化为英文
	 * @param $Num
	 */
	public function Month_E($Num){
		return $this->Month_E[$Num];
	}
	/**
	 *
	 * 比较两个日期相差多少天
	 * @param $endTimestamp
	 * @param $startTimestamp
	 */
	function count_days($endTimestamp, $startTimestamp){
		$e_dt=getdate($endTimestamp);
		$s_dt=getdate($startTimestamp);
		$e_new=mktime(12,0,0,$e_dt['mon'],$e_dt['mday'],$e_dt['year']);
		$s_new=mktime(12,0,0,$s_dt['mon'],$s_dt['mday'],$s_dt['year']);
		return round(abs($e_new-$s_new)/86400);
	}
	/**
	 *
	 * 将秒（非时间戳）转化成 ** 小时 ** 分
	 * @param $sec
	 */
	function sec2time($sec){
		$sec = round($sec/60);
		if ($sec >= 60){
			$hour = floor($sec/60);
			$min = $sec%60;
			$res = $hour.'小时';
			$min != 0  &&  $res .= $min.'分';
		}else{
			$res = $sec.'分钟';
		}
		return $res;
	}
}