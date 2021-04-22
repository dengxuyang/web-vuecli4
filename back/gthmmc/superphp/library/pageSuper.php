<?php
class pageSuper  {
	//定义函数pageft(),三个参数的含义为：
	//$totle：信息总数；
	//$displaypg：每页显示信息数，这里设置为默认是20；
	//$url：分页导航中的链接，除了加入不同的查询信息“page”外的部分都与这个URL相同。
	//　　　默认值本该设为本页URL（即$_SERVER["REQUEST_URI"]），但设置默认值的右边只能为常量，所以该默认值设为空字符串，在函数内部再设置为本页URL。
	function pageft($totle,$displaypg=20,$pageNo, $shownum=0,$showtext=0,$showselect=0,$showlvtao=7,$pageUrl='',$cssPath){
		$page = $pageNo;
		$url = str_replace("'","&#039;",$pageUrl);
		$url = str_replace("\"","&quot;",$url);
		if(!$page) $page=1;

		//页码计算：
		$lastpg=ceil($totle/$displaypg); //最后页，也是总页数
		$page=min($lastpg,$page);
		$prepg=$page-1; //上一页
		$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
		$firstcount=($page-1)*$displaypg;

		$pagenav = "<div class='pageShow'>";// $this->getPageCss($cssType);
		$pagenav .= "<link rel='stylesheet' type='text/css' href='" . $cssPath . "' />";
		//开始分页导航条代码：
		if ($showtext==1){
			$pagenav.="<span class='disabled'>".($totle?($firstcount+1):0)."-".min($firstcount+$displaypg,$totle)."/$totle record</span><span class='disabled'>$page/$lastpg page</span>";  //记录  
		}
		/*
		 else{
			$pagenav="";
			}
			*/
		//如果只有一页则跳出函数：
		if($lastpg<=1) return false;

		if($prepg) {
			$pagenav.="<a href='" . sprintf($url, 1)  . "'>home</a>";   //首页
		}else {
			$pagenav.='<span class="disabled">home</span>';  //首页
		}
		if($prepg) {
			$pagenav.="<a href='" .  sprintf($url, $prepg) . "'>previous</a>";    //上一页
		}
		else {
			$pagenav.='<span class="disabled">previous</span>';    //上一页
		}
		if ($shownum==1){
			$o=$showlvtao;//中间页码表总长度，为奇数
			$u=ceil($o/2);//根据$o计算单侧页码宽度$u
			$f=$page-$u;//根据当前页$currentPage和单侧宽度$u计算出第一页的起始数字
			//str_replace('{p}',,$fn)//替换格式
			if($f<0){$f=0;}//当第一页小于0时，赋值为0
			$n=$lastpg;//总页数,20页
			if($n<1){$n=1;}//当总数小于1时，赋值为1
			if($page==1){
				$pagenav.='<span class="current">1</span>';
			}else{
				//$pagenav.="<a href='$url=1'>1</a>";
				$pagenav.="<a href='" . sprintf($url, 1) . "'>1</a>";
			}
			///////////////////////////////////////
			for($i=1;$i<=$o;$i++){
				if($n<=1){break;}//当总页数为1时
				$c=$f+$i;//从第$c开始累加计算
				if($i==1 && $c>2){
					$pagenav.='...';
				}
				if($c==1){continue;}
				if($c==$n){break;}
				if($c==$page){
					$pagenav.='<span class="current">'.$page.'</span>';
				}else{
					//$pagenav.="<a href='$url=$c'>$c</a>";
					$pagenav.="<a href='" . sprintf($url, $c) . "'>$c</a>";
				}
				if($i==$o && $c<$n-1){
					$pagenav.='...';
				}
				if($i>$n){break;}//当总页数小于页码表长度时
			}
			if($page==$n && $n!=1){
				$pagenav.='<span class="current">'.$n.'</span>';
			}else{
				//$pagenav.="<a href='$url=$n'>$n</a>";
				$pagenav.="<a href='" . sprintf($url, $n) . "'>$n</a>";
			}
		}

		//if($nextpg) $pagenav.="<a href='$url=$nextpg'>下一页</a>"; else $pagenav.='<span class="disabled">下一页</span>';
		//if($nextpg) $pagenav.="<a href='$url=$lastpg'>尾页</a>"; else $pagenav.='<span class="disabled">尾页</span>';
		if($nextpg) {
			$pagenav.="<a href='" . sprintf($url, $nextpg) . "'>next</a>";   //下一页
		}else{
			$pagenav.='<span class="disabled">next</span>';    //下一页
		}
		if($nextpg) {
		   $pagenav.="<a href='" . sprintf($url, $lastpg) . "'>last</a>";    //尾页
		}
		else {
		   $pagenav.='<span class="disabled">last</span>';   //尾页
		}
		if ($showselect==1){
			//下拉跳转列表，循环列出所有页码：
			//$pagenav.="跳至<select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
			//$pagenav.="跳至<select name='topage' size='1' onchange='window.location=\"" . $url . "\"+this.value+\".html\"'>\n";
			//跳至
			$pagenav.="goto<select name='topage' size='1' onchange='var url=\"" . $url ."\";url=url.replace(\"%s\",this.value);window.location=url;'>\n";

			for($i=1;$i<=$lastpg;$i++){
				if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n";
				else $pagenav.="<option value='$i'>$i</option>\n";
			}
			$pagenav.="</select>page";   //页
		}
		$pagenav .= "</div>";
		return $pagenav;
	}
	//定义函数pageftCn(),三个参数的含义为：
	//$totle：信息总数；
	//$displaypg：每页显示信息数，这里设置为默认是20；
	//$url：分页导航中的链接，除了加入不同的查询信息“page”外的部分都与这个URL相同。
	//　　　默认值本该设为本页URL（即$_SERVER["REQUEST_URI"]），但设置默认值的右边只能为常量，所以该默认值设为空字符串，在函数内部再设置为本页URL。
	function pageftCn($totle,$displaypg=20,$pageNo, $shownum=0,$showtext=0,$showselect=0,$showlvtao=7,$pageUrl='',$cssPath){
		$page = $pageNo;
		$url = str_replace("'","&#039;",$pageUrl);
		$url = str_replace("\"","&quot;",$url);
		if(!$page) $page=1;

		//页码计算：
		$lastpg=ceil($totle/$displaypg); //最后页，也是总页数
		$page=min($lastpg,$page);
		$prepg=$page-1; //上一页
		$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
		$firstcount=($page-1)*$displaypg;

		$pagenav = "<div class='pageShow'>"; //$this->getPageCss($cssType);
		$pagenav .= "<link rel='stylesheet' type='text/css' href='" . $cssPath . "' />";
		//开始分页导航条代码：
		if ($showtext==1){
			$pagenav.="<span class='disabled'>".($totle?($firstcount+1):0)."-".min($firstcount+$displaypg,$totle)."/$totle record</span><span class='disabled'>$page/$lastpg page</span>";  //记录  
		}
		/*
		 else{
			$pagenav="";
			}
			*/
		//如果只有一页则跳出函数：
		if($lastpg<=1) return false;

		if($prepg) {
			$pagenav.="<a href='" . sprintf($url, 1)  . "'>首页</a>";   //首页
		}else {
			$pagenav.='<span class="disabled">首页</span>';  //首页
		}
		if($prepg) {
			$pagenav.="<a href='" .  sprintf($url, $prepg) . "'>上一页</a>";    //上一页
		}
		else {
			$pagenav.='<span class="disabled">上一页</span>';    //上一页
		}
		if ($shownum==1){
			$o=$showlvtao;//中间页码表总长度，为奇数
			$u=ceil($o/2);//根据$o计算单侧页码宽度$u
			$f=$page-$u;//根据当前页$currentPage和单侧宽度$u计算出第一页的起始数字
			//str_replace('{p}',,$fn)//替换格式
			if($f<0){$f=0;}//当第一页小于0时，赋值为0
			$n=$lastpg;//总页数,20页
			if($n<1){$n=1;}//当总数小于1时，赋值为1
			if($page==1){
				$pagenav.='<span class="current">1</span>';
			}else{
				//$pagenav.="<a href='$url=1'>1</a>";
				$pagenav.="<a href='" . sprintf($url, 1) . "'>1</a>";
			}
			///////////////////////////////////////
			for($i=1;$i<=$o;$i++){
				if($n<=1){break;}//当总页数为1时
				$c=$f+$i;//从第$c开始累加计算
				if($i==1 && $c>2){
					$pagenav.='...';
				}
				if($c==1){continue;}
				if($c==$n){break;}
				if($c==$page){
					$pagenav.='<span class="current">'.$page.'</span>';
				}else{
					//$pagenav.="<a href='$url=$c'>$c</a>";
					$pagenav.="<a href='" . sprintf($url, $c) . "'>$c</a>";
				}
				if($i==$o && $c<$n-1){
					$pagenav.='...';
				}
				if($i>$n){break;}//当总页数小于页码表长度时
			}
			if($page==$n && $n!=1){
				$pagenav.='<span class="current">'.$n.'</span>';
			}else{
				//$pagenav.="<a href='$url=$n'>$n</a>";
				$pagenav.="<a href='" . sprintf($url, $n) . "'>$n</a>";
			}
		}

		//if($nextpg) $pagenav.="<a href='$url=$nextpg'>下一页</a>"; else $pagenav.='<span class="disabled">下一页</span>';
		//if($nextpg) $pagenav.="<a href='$url=$lastpg'>尾页</a>"; else $pagenav.='<span class="disabled">尾页</span>';
		if($nextpg) {
			$pagenav.="<a href='" . sprintf($url, $nextpg) . "'>下一页</a>";   //下一页
		}else{
			$pagenav.='<span class="disabled">下一页</span>';    //下一页
		}
		if($nextpg) {
		   $pagenav.="<a href='" . sprintf($url, $lastpg) . "'>尾页</a>";    //尾页
		}
		else {
		   $pagenav.='<span class="disabled">尾页</span>';   //尾页
		}
		if ($showselect==1){
			//下拉跳转列表，循环列出所有页码：
			//$pagenav.="跳至<select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
			//$pagenav.="跳至<select name='topage' size='1' onchange='window.location=\"" . $url . "\"+this.value+\".html\"'>\n";
			//跳至
			$pagenav.="跳至<select name='topage' size='1' onchange='var url=\"" . $url ."\";url=url.replace(\"%s\",this.value);window.location=url;'>\n";

			for($i=1;$i<=$lastpg;$i++){
				if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n";
				else $pagenav.="<option value='$i'>$i</option>\n";
			}
			$pagenav.="</select>页";   //页
		}
		$pagenav .= "</div>";
		return $pagenav;
	}
	/**
	 *
	 * 获取分页显示的样式
	 * @param unknown_type $index
	 */
	private function getPageCss($index){
		$result = "<div class='digg'>";
		switch($index){
			case 0:
				$result = "<div class='digg'>";
				break;
			case 1:
				$result = "<div class='yahoo'>";
				break;
			case 2:
				$result = "<div class='meneame'>";
				break;
			case 3:
				$result = "<div class='flickr'>";
				break;
			case 4:
				$result = "<div class='sabrosus'>";
				break;
			case 5:
				$result = "<div class='scott'>";
				break;
			case 6:
				$result = "<div class='quotes'>";
				break;
			case 7:
				$result = "<div class='black'>";
				break;
			case 8:
				$result = "<div class='black2'>";
				break;
			case 9:
				$result = "<div class='black-red'>";
				break;
			case 10:
				$result = "<div class='grayr'>";
				break;
			case 11:
				$result = "<div class='yellow'>";
				break;
			case 12:
				$result = "<div class='jogger'>";
				break;
			case 13:
				$result = "<div class='starcraft2'>";
				break;
			case 14:
				$result = "<div class='tres'>";
				break;
			case 15:
				$result = "<div class='megas512'>";
				break;
			case 16:
				$result = "<div class='technorati'>";
				break;
			case 17:
				$result = "<div class='youtube'>";
				break;
			case 18:
				$result = "<div class='msdn'>";
				break;
			case 19:
				$result = "<div class='badoo'>";
				break;
			case 20:
				$result = "<div class='green-black'>";
				break;
			case 21:
				$result = "<div class='viciao'>";
				break;
			case 22:
				$result = "<div class='yahoo2'>";
				break;

		}
		return $result;
	}
}