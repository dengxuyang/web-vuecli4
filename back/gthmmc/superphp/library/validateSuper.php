<?php
class validateSuper  {
	/**
	 *  将15位身份证升级到18位
	 * @param string $idcard 15位身份证号
	 * @return bool
	 */
	public function idcard_15to18($idcard){
		if(strlen($idcard)!=15) return false;
		else {
			//如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
			if(array_search(substr($idcard,12,3),array('996','997','998','999'))!==false){
				$idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
			}
			else{
				$idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
			}
		}
		$idcard=$idcard.  self::idcard_verify_number($idcard);
		return $idcard;
	}
	/**
	 * 18位身份证校验码有效性检查
	 * @param string $idcard 18位身份证号
	 * @return bool
	 */
	public function idcard_checksum18($idcard){
		if(strlen($idcard)!=18) return false;
		$idcard_base=substr($idcard,0,17);
		if( self::idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))) {
			return false;
		}
		return true;
	}
	/**
	 * 
	 * 验证身份证是否为可用
	 * @param unknown_type $idcard_base 身份证号
	 */
	public function idcard_verify_number($idcard_base){
		if(strlen($idcard_base)!=17){
			return false;
		}
		//加权因子
		$factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
		//效验码对应值
		$verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
		$checksum=0;
		for($i=0;$i<strlen($idcard_base);$i++){
			$checksum += (int)substr($idcard_base,$i,1) * $factor[$i];
		}
		$mod=$checksum % 11;
		$verify_number=$verify_number_list[$mod];
		return $verify_number;
	}
	/**
	 * 
	 * 验证身份证是否正确
	 * @param unknown_type $personID 身份证号
	 */
	public function personID_format_err($personID=null){
		if (!is_numeric($personID) && strpos(strtolower($personID), 'x')===false) {
			return false;
		}
		// 15位身份证升级到18位
		if(strlen($personID) == 15){
			$personID_ch = self::idcard_15to18($personID);
		}
		elseif(strlen($personID) == 18)  {
			$personID_ch = $personID;
		}
		else {
			return false;
		}
		if(! self::idcard_checksum18($personID_ch)) {
			return false;
		}
		return true;
	}
}