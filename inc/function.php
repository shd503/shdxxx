<?php
function WriteErrMsg($ErrMsg){
	$strErr="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";//有些文件不能设文件头
	$strErr=$strErr."<html xmlns='http://www.w3.org/1999/xhtml' lang='zh-CN'>" ;
	$strErr=$strErr."<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$strErr=$strErr."<div style='text-align:center;font-size:14px;line-height:25px;padding:10px'>" ;
	$strErr=$strErr . "<div style='border:solid 1px #dddddd;margin:0 auto;background-color:#FFFFFF'>";
	$strErr=$strErr . "<div style='background-color:#f1f1f1;border-bottom:solid 1px #ddd;font-weight:bold'>禁止操作</div>";
	$strErr=$strErr . "<div style='padding:20px;text-align:left'>" .$ErrMsg."</div>";
	$strErr=$strErr . "<div style='background-color:#f1f1f1'><a href='javascript:history.go(-1)'>【返回上页】</a> <a href=# onClick='window.opener=null;window.close()'>【关闭窗口】</a></div>";
	$strErr=$strErr . "</div>";
	$strErr=$strErr . "</div>" ;
	$strErr=$strErr . "</html>" ;
	echo $strErr;
}
//显示信息
function showmsg($msg, $zc_url = 'back'){
	$strErr="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";//有些文件不能设文件头
	$strErr=$strErr."<html xmlns='http://www.w3.org/1999/xhtml' lang='zh-CN'>" ;
	$strErr=$strErr."<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	if($zc_url && $zc_url!='back'){
		$strErr=$strErr.("<script>alert('$msg');self.location=\"$zc_url\";</script>");
	}else{
		$strErr=$strErr.("<script>alert(\"$msg\");history.go(-1);</script>");
	}
	echo $strErr;
	exit;
}

function CutFenGeXian($str,$xian){
	for($i=0; $i<substr_count($str,$xian);$i++){
		if (substr($str,-1,1)==$xian){//去最后一个|
			$str=substr($str,0,strlen($str)-1);
		}
		if (substr($str,0,1)==$xian){//去第一个|
			$str=substr($str,1);
		}
	}
	return $str;
}

function checkid($id,$classid=0,$msg=''){
	if ($id<>''){
		if (is_numeric($id)==false){
			showmsg('参数有误！相关信息不存在。');
		}elseif ($id>100000000){//因为clng最大长度为9位
			showmsg('参数超出了数字表示范围！系统不与处理。');
		}
		if ($classid==0){//查大小类ID时这里设为1
			if ($id<1){//翻页中有用
				showmsg('参数有误！相关信息不存在。');
			}
		}
	}
}

function nohtml($str){
	$str=trim($str);//清除字符串两边的空格
	$str=strip_tags($str,"");//利用php自带的函数清除html格式
	$str=str_replace("&nbsp;","",$str);//空白符
	$str=str_replace("　","",$str);//table 所产生的空格
	$str=preg_replace("/\t/","",$str);//使用正则表达式匹配需要替换的内容，如空格和换行，并将替换为空
	$str=preg_replace("/\r\n/","",$str);
	$str=preg_replace("/\r/","",$str);
	$str=preg_replace("/\n/","",$str);
	$str=preg_replace("/ /","",$str);//匹配html中的空格
	return trim($str);//返回字符串
}
function getip(){
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip = getenv("REMOTE_ADDR");
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip = $_SERVER['REMOTE_ADDR'];
	else
		$ip = "unknown";
	return($ip);
}

//$_SERVER['HTTP_REFERER'];//上页来源
function markit(){
	$userip=$_SERVER["REMOTE_ADDR"];
	//$userip=getip();
	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	mysql_query("insert into zzcms_bad (username,ip,dose,sendtime)values('".$_COOKIE["UserName"]."','$userip','$url','".date('Y-m-d H:i:s')."')") ;
}
function admindo(){
	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$f=zzcmsroot."/admindoes.txt";
	$fp=fopen($f,"a+");//fopen()的其它开关请参看相关函数
	$str=date('Y-m-d H:i:s')."  ".$_SESSION["admin"]."  ".$url."\r\n";
	fputs($fp,$str);
	fclose($fp);
//mysql_query("insert into zzcms_admindo (admin,dose,sendtime)values('".$_SESSION["admin"]."','$url','".date('Y-m-d H:i:s')."')") ;     
}
function getpageurl($channel,$id){
	if (whtml=="Yes") {return "/". $channel . "/show-" . $id . ".htm" ;}else {return "/" . $channel . "/show.php?id=" . $id;}
}

function getpageurlzs($editor,$id=0){
	global $siteskin;
	if(sdomain=="Yes" && strpos($siteskin,"mobile")===false){//手机版不用二级域名链接，因为二级域名直接从首页读zs/show页，判断手机代码无法生效，注意这里用的是===
		return "http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1);
	}elseif($id<>0){
		return siteurl.getpageurl("zs",$id);
	}else{
		return "/zs/show.php?editor=" . $editor;
	}
}
function getpageurlzx($channel,$b){
	if (whtml=="Yes"){
		$str="/" . $channel."/class";
		if ($b<>"") {$str=$str."/" . $b ."";}
	}else{
		$str="/" .$channel."/class.php";
		if ($b<>""){$str=$str."?b=" . $b ."";}
	}
	return $str;
}
function getpageurl2($channel,$b,$s){
	if (whtml=="Yes"){
		$str="/" . $channel;
		if ($b<>"") {$str=$str."/" . $b ."";}
		if ($s<>"") {$str=$str."/" . $s ."";}
		//$str=$str.".html";
	}else{
		$str="/" .$channel."/" .$channel . ".php";
		if ($b<>""){$str=$str."?b=" . $b ."";}
		if ($s<>""){$str=$str. "&s=" . $s ."";}
	}
	return $str;
}

function getpageurl3($pagename){
	if (whtml=="Yes"){return $pagename . ".htm" ;}else {return $pagename . ".php";}
}

function addzero($str,$longs=2){
	if (strlen($str)<$longs){
		$result=0;
		for ($i=1;$i<$longs-strlen($str);$i++){
			$result=$result."0";
		}
		$str= $result.$str;
	}else{
		$str= $str;
	}
	return $str;
}

function addhttp($url){
	if ($url<>"" && substr($url,0,4)<>"http"){return "http://".$url;}else{return $url;}
}

function getstation($bid,$bname,$sid,$sname,$title,$keyword,$channel){
	$str="<li class='start'><a href='".siteurl."'>首页</a></li>";
	if (whtml=="Yes") {
		$str=$str."<li><a href='/".$channel."/index.htm'>".getchannelname($channel)."</a></li>" ;
		if ($bid<>""){$str=$str. "<li><a href='/".$channel."/".$bid."'>".$bname."</a></li>";}
		if ($sid<>"") {$str=$str. "<li><a href='/".$channel."/".$bid."/".$sid."'>".$sname."</a></li>";}
		if ($title<>"") {$str=$str. "<li>".$title."</li>";}
		if ($keyword<>"") {$str=$str. "<li>关键字中含有“".$keyword."”的".getchannelname($channel)."</li>";}
	}else{
		$str=$str. "<li><a href='".$channel.".php'>".getchannelname($channel)."</a></li>" ;
		if ($bid<>"") {$str=$str. "<li><a href='/".$channel."/".$channel.".php?b=".$bid."'>".$bname."</a></li>";}
		if ($sid<>"") {$str=$str. "<li><a href='/".$channel."/".$channel.".php?b=".$bid."&s=".$sid."'>".$sname."</a></li>";}
		if ($title<>"") {$str=$str."<li>".$title."</li>";}
		if ($keyword<>"") {$str=$str. "<li>关键字中含有“".$keyword."”的".getchannelname($channel)."</li>";}
	}
	return $str;
}

function getchannelname($channel){
	switch ($channel){
		case "zs";return "店家";break;
		case "pp";return "品牌";break;
		case "dl";return "代理";break;
		case "zh";return "展会";break;
		case "zx";return "资讯";break;
		case "company";return "企业";break;
	}
}
function checkyzm($yzm){
	if($yzm!=$_SESSION["yzm_math"]){showmsg('验证问题答案错误！');}
}

function getimgincontent($content,$num=1){
	preg_match_all("/<[img].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.bmp]))[\'|\"].*?[\/]?>/i",$content,$match);
	switch ($num){
		case 1;return @$match[1][0];break;//只取第一个
		case 2;return @$match[1];break;//取出所有，返回的是一个数组
	}
}

function cutstr($tempstr,$tempwid){
	if (strlen($tempstr)>$tempwid*3){//汉字占三个字符长度
//		return mb_substr($tempstr,0,$tempwid,'utf8').".";
		return mb_substr($tempstr,0,$tempwid,'utf8');
	}else{
		return $tempstr;
	}
}

function showannounce($cs){
	$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
	$numbers=isset($cs[0])?$cs[0]:2;checkid($numbers);
	$titlelong=isset($cs[1])?$cs[1]:20;checkid($titlelong);
	if (isset($_COOKIE['closegg'])){
		$str='';
	}else{
		$n=1;
		$str='';
		$sql="select title,id,content from zzcms_help where classid=2 and elite=1 order by id desc limit 0,$numbers";
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
//			$str=$str ."<div id='gonggao'><span onclick=\"gonggao.style.display='none'\"><a href=javascript:delCookie('closegg')>×</a></span>";
			$str=$str ."<div id='gonggao'><span onclick=\"gonggao.style.display='none'\"></span>";
			while ($row=mysql_fetch_array($rs)){
				$str=$str ."【公告". $n ."】<a href=javascript:openwindow('/one/announce_show.php?id=".$row["id"]."',700,300)>".cutstr(strip_tags($row["title"]),$titlelong)."</a>&nbsp;&nbsp;<br>";
				$n++;
			}
			$str=$str ."</div>";
		}
	}
	return $str;
}

function showselectpage($pagename,$page_size,$b,$s,$page){
	$str="<select name='menu1' onchange=MM_jumpMenu('parent',this,0)>";
	$cs="/".$pagename."/".$pagename.".php?b=".$b."&s=".$s."&page=".$page;
	if ($page_size=="20"){
		$str=$str . "<option value='".$cs."&page_size=20' selected >20条/页</option>";
	}else{
		$str=$str . "<option value='".$cs."&page=".$page."&page_size=20' >20条/页</option>";
	}

	if ($page_size=="50") {
		$str=$str . "<option value='".$cs."&page=".$page."&page_size=50' selected >50条/页</option>";
	}else{
		$str=$str . "<option value='".$cs."&page_size=50' >50条/页</option>";
	}

	if ($page_size=="100"){
		$str=$str . "<option value='".$cs."&page_size=100' selected >100条/页</option>";
	}else{
		$str=$str . "<option value='".$cs."&page_size=100' >100条/页</option>";
	}
	$str=$str . "</select>";
	return $str;
}

function getsmallimg($img){
	if (substr($img,0,4) == "http"){
		return $img;//复制的网上的图片，不生成小图片，直接显示大图
	}else{
		return siteurl.str_replace(".jpeg","_small.jpeg",str_replace(".png","_small.png",str_replace(".gif","_small.gif",str_replace(".jpg","_small.jpg",$img))));
	}
}

function makesmallimg($img){
	$imgbig=zzcmsroot.$img;
	$imgsmall=str_replace(siteurl,"",getsmallimg($imgbig));
	$sImgName =$imgsmall;
	$sImgSize=120;
	$data=GetImageSize($imgbig);//取得GIF、JPEG、PNG或SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
	if($data[2]!=4){//文件类型不为4，4为swf格式
		switch ($data[2]) {
			case 1 :$sImg = imagecreatefromgif($imgbig);break;
			case 2 :$sImg = imagecreatefromjpeg($imgbig);break;
			case 3 :$sImg = imagecreatefrompng($imgbig);break;
			case 6 :$sImg = imagecreatefromwbmp($imgbig);break;
			//default :echo "不支持的文件类型，无法生成缩略图";
		}
		//生成小图
		if ($data[1]>$data[0]){
			$newwidth=$sImgSize*($data[0]/$data[1]) ;
			$newheight= $sImgSize;
		}else{
			$newwidth=$sImgSize;
			$newheight=$sImgSize*($data[1]/$data[0]) ;
		}
		$sImgDate = imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($sImgDate,$sImg, 0, 0, 0, 0, $newwidth, $newheight, $data[0],$data[1]);
		switch ($data[2]) {
			case 1 :imagegif($sImgDate, $sImgName);break;
			case 2 :imagejpeg($sImgDate, $sImgName);break;
			case 3 :imagepng($sImgDate, $sImgName);break;
			case 6 :imagewbmp($sImgDate, $sImgName);break;
		}
		imagedestroy($sImgDate);
		$isok=imagedestroy($sImg);
		//if ($isok){echo "生成小图片成功:".$sImgName;}	
	}
}

function grabimg($url,$filename="") {
	if($url==""):return false;endif;
	if($filename=="") {
		$ext=strrchr($url,".");
		if($ext!=".gif" && $ext!=".jpg" && $ext!=".png"&& $ext!=".bmp"):return false;endif;
		$filename_dir=zzcmsroot.'uploadfiles/'.date("Y-m"); //上传文件地址 采用绝对地址方便upload.php文件放在站内的任何位置
		if (!file_exists($filename_dir)) {
			@mkdir($filename_dir,0777,true);
		}
		$filename=$filename_dir."/".date("YmdHis").rand(100,999).$ext;
	}

	ob_start();
	readfile($url);
	$img = ob_get_contents();
	ob_end_clean();
	$size = strlen($img);

	$fp2=@fopen($filename, "a");
	fwrite($fp2,$img);
	fclose($fp2);
	return $filename;
}

function showprovince($cs){
	global $province,$city_array;
	$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
	$channel=isset($cs[0])?$cs[0]:'';
	$column=isset($cs[1])?$cs[1]:5;
	$str="<table width='100%' border='0' cellpadding='5' cellspacing='1' class='bgcolor3'><tr>";
	$i=0;
	foreach ($city_array as $citys){//以省份名为关键字，用foreach调用
		if ($citys[0]==$province){
			$str=$str . "<td align='center' bgcolor='#FFFFFF' style='font-weight:bold'>" ;
		}else{
			$str=$str . "<td align='center' class='bgcolor1' onMouseOver='PSetBg(this)' onMouseOut='PReBg(this)'>" ;
		}
		if ($channel=="area") {
			$str=$str ."<a href='".siteurl."/".$channel."/".getpageurl($channel,$i)."'>".$citys[0]."</a>";
		}else{
			$str=$str . "<a href='/".$channel."/search.php?province=".$citys[0]."'>".$citys[0]."</a>";
		}
		$str=$str . "</td>" ;
		if (($i+1) % $column==0) {
			$str=$str."</tr>";
		}
		$i++;
	}
	$str=$str. "</table>";
	return $str;
}

function showkeyword($cs){
	global $keyword,$siteskin,$f_array_fun;
	$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
	$channel=isset($cs[0])?$cs[0]:'zs';
	$numbers=isset($cs[1])?$cs[1]:10;checkid($numbers);
	$column=isset($cs[2])?$cs[2]:5;checkid($column);

	if ($channel=='zs'){
		$fpath=zzcmsroot."cache/zskeyword.txt";
	}elseif ($channel=='zx'){
		$fpath=zzcmsroot."cache/zxkeyword.txt";
	}

	if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
		return file_get_contents($fpath);
	}else{
		if ($channel=='zs'||$channel=='dl'){
			$sql= "select keyword,url from zzcms_tagzs order by xuhao asc";
		}elseif($channel=='zx'){
			$sql= "select keyword,url from zzcms_tagzx order by xuhao asc";
		}
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
			$str="";
			$liwidth=100/$column-10;
			while ($row=mysql_fetch_array($rs)){
				if ($row["keyword"]==$keyword) {
					$str=$str . "<li style='font-weight:bold;width:".$liwidth."%;display:inline-block'>";
				}else{
					$str=$str . "<li style='width:".$liwidth."%;display:inline-block'>";
				}
				$str=$str . "<a href='/".$channel."/search.php?keyword=".$row["keyword"]."'>".$row["keyword"]."</a></li>\r\n";
			}
		}else{
			$str= $f_array_fun[14];
		}
		unset ($f_array_fun);
		return $str;

		if ($channel=='zs'||$channel=='dl'){
			$fpath=zzcmsroot."cache/zskeyword.txt";
		}elseif ($channel=='zx'){
			$fpath=zzcmsroot."cache/zxkeyword.txt";
		}
		if (!file_exists("../cache")) {mkdir("../cache",0777,true);}
		$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
		fputs($fp,$str);//写入文件
		fclose($fp);
	}
}

function isaddsiteurl($str){
	if (strpos("http",substr($str,0,4))!==false) {//有http时用的是网络图片前面就不加siteurl了
		return $str;
	}else{
		return siteurl.$str;
	}
}

function showad($cs){
	global $siteskin;
	$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
	$b=isset($cs[0])?$cs[0]:'';
	$s=isset($cs[1])?$cs[1]:'';
	$num=isset($cs[2])?$cs[2]:'';
	$imgwidth=isset($cs[3])?$cs[3]:0;
	$imgheight=isset($cs[4])?$cs[4]:0;
	$titlelong=isset($cs[5])?$cs[5]:0;
	$bianhao=isset($cs[6])?$cs[6]:'';
	$fp=zzcmsroot."cache/".$siteskin."/adv_".pinyin($b)."_".pinyin($s).".htm";//广告中文类别名转换成拼音字母来给缓存文件命名
	if (cache_update_time!=0 && file_exists($fp) && filesize($fp)>10 && time()-filemtime($fp)<3600*24*cache_update_time ) {
//按管理员设定的时间更新,//utf-8有文件头，空文件大小为3字节
		$fso = fopen($fp,'r');
		$fcontent = fread($fso,filesize($fp));
		fclose($fso);
		return $fcontent;
	}else{
		$n=1;
		$str='';
//sql= "select * from zzcms_ad where endtime>= '"&date()&"' "
		$sql= "select * from zzcms_ad where bigclassname='".$b."' and smallclassname='".$s."' order by xuhao asc,id asc ";
		if ($num<>0){$sql= $sql. " limit 0,$num";}
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
			$str="<ul>";
			while ($row=mysql_fetch_array($rs)){
				if ($row["img"]<>"" and $row["imgwidth"]<>0 ) {//有图片且宽度不为0，宽度设为0的以文字广告形式显示
					$str=$str."<li> ";
					if (isshowad_when_timeend=="No" && $row["endtime"]<=date('Y-m-d H:i:s')){ //到期的
						$str=$str. showadtext;
					}else{
						$str=$str. "<a href='".$row["link"]."' target='_blank' style='color:".$row["titlecolor"]."'>";
						if ($imgwidth!=0){//参数里设值的按所设值显示，未设值的按广告管理中所设的值显示
							$str=$str. "<img src='".isaddsiteurl($row["img"])."' data-original='".isaddsiteurl($row["img"])."' height='$imgheight' width='$imgwidth'  alt='".$row["title"]."'/>";
						}else{
							$str=$str. "<img stc='".isaddsiteurl($row["img"])."' data-original='".isaddsiteurl($row["img"])."' height='".$row["imgheight"]."' width='".$row["imgwidth"]."' alt='".$row["title"]."'/>";
						}
						if ($titlelong!=0){
							$str=$str.'<br/>';
							if ($bianhao=='yes'){$str=$str.addzero($n,2)."-";}
							if ($titlelong!=0){$str=$str.cutstr($row["title"],$titlelong);}else{$str=$str.$row["title"];}
						}
						$str=$str."</a>";
					}
					$str=$str."</li>\n";
				}else{//文字类的广告，或是图片设为0宽度的图片广告,都以文字显示
					$str=$str."<li> ";
					if (isshowad_when_timeend=="No" && $row["endtime"]<=date('Y-m-d H:i:s')){ //到期的
						$str=$str. showadtext;
					}else{
						if ($row['img']<>''){//传了图片的文字广告
							$str=$str."<div id='ad_layer".$row["id"]."' class='hiddiv'></div>";
							$str=$str."<a href='".$row["link"]."' target='_blank' onMouseOver=\"showfilter(ad_layer".$row["id"].");window.document.getElementById('ad_layer".$row["id"]."').innerHTML='<img src=".isaddsiteurl($row["img"])." width=200px>'\" onMouseOut='showfilter(ad_layer".$row["id"].")'>";
						}else{
							$str=$str."<a href='".$row["link"]."' target='_blank' style='color:".$row["titlecolor"]."'>";
						}
						if ($bianhao=='yes'){$str=$str.addzero($n,2)."-";}
						if ($titlelong!=0){$str=$str.cutstr($row["title"],$titlelong);}else{$str=$str.$row["title"];}
						$str=$str. "</a>";
					}
					$str=$str."</li>\n";
				}
				$n=$n+1;
			}
			$str=$str."</ul>";
		}
		if (cache_update_time!=0){
			$fp=zzcmsroot."cache/".$siteskin."/adv_".pinyin($b)."_".pinyin($s).".htm";
			if (!file_exists(zzcmsroot."cache/".$siteskin)) {mkdir(zzcmsroot."cache/".$siteskin,0777,true);}
			$f=fopen($fp,"w+");//fopen()的其它开关请参看相关函数
			fputs($f,$str);
			fclose($f);
		}
		return $str;
	}
}

function checkver($str){
	if(strpos($str,base64_decode('enpjbXMubmV0Pjxmb250IGNvbG9yPSNGRjY2MDAgZmFjZT1BcmlhbD5aWg=='))==false){
		WriteErrMsg(base64_decode('PGRpdiBzdHlsZT0nZm9udC1zaXplOjIwcHgnPuWFjei0ueeJiCzli7/liKDmlLlaWkNNU+agh+ivhu+8gei/mOWOn+WQjizliJnkuI3lho3mj5DnpLo8L2Rpdj4='));
	}
}

function lockip(){
	$badip=getip();
	$sql="select * from zzcms_bad where ip='".$badip."' and lockip=1";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if ($row){
		echo "此IP被封,不能访问本站!";
//mysql_close($conn);
		exit;
	}
}

function stripfxg($string) {
	$string=stripslashes($string);//去反斜杠,不开get_magic_quotes_gpc 的情况下，在stopsqlin中都加上了，这里要去了
	$string=htmlspecialchars_decode($string);//转html实体符号
	return $string;
}

function strbetween($str,$start,$end,$startadd=0) {
	$a= strpos($str,$start)+strlen($start)+$startadd;//在起始标识$start所在位后追加数字，如取src="后的字符时，双引号无法直接表示，所以加这个startadd可以解决这种问题
	if (strpos($str,$start)!==false){
		$b= strpos($str,$end,$a);//必须定起始位置
		return substr($str,$a,$b-$a);
	}
}

//取得拼音
function pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
	$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
		"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
		"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
		"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
		"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
		"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
		"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
		"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
		"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
		"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
		"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
		"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
		"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
		"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
		"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
		"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
	$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
		"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
		"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
		"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
		"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
		"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
		"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
		"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
		"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
		"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
		"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
		"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
		"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
		"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
		"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
		"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
		"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
		"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
		"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
		"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
		"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
		"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
		"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
		"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
		"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
		"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
		"|-10270|-10262|-10260|-10256|-10254";
	$_TDataKey   = explode('|', $_DataKey);
	$_TDataValue = explode('|', $_DataValue);
	$_Data = array_combine($_TDataKey, $_TDataValue);
	arsort($_Data);
	reset($_Data);
	if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String);
	$_Res = '';
	for($i=0; $i<strlen($_String); $i++) {
		$_P = ord(substr($_String, $i, 1));
		if($_P>160) {
			$_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
		}
		$_Res .= _pinyin($_P, $_Data);
	}
	return preg_replace("/[^a-z0-9A-Z]*/", '', $_Res);
}
function _pinyin($_Num, $_Data){
	if($_Num>0 && $_Num<160 ){
		return chr($_Num);
	}elseif($_Num<-20319 || $_Num>-10247){
		return '';
	}else{
		foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
		return $k;
	}
}
function _U2_Utf8_Gb($_C){
	$_String = '';
	if($_C < 0x80){
		$_String .= $_C;
	}elseif($_C < 0x800) {
		$_String .= chr(0xC0 | $_C>>6);
		$_String .= chr(0x80 | $_C & 0x3F);
	}elseif($_C < 0x10000){
		$_String .= chr(0xE0 | $_C>>12);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	}elseif($_C < 0x200000) {
		$_String .= chr(0xF0 | $_C>>18);
		$_String .= chr(0x80 | $_C>>12 & 0x3F);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	}
	return iconv('UTF-8', 'GB2312', $_String);
}
function province_zm2hz($zm){
	$province='';
	$zm=strtolower($zm);
	switch ($zm){
		case'beijing':$province='北京';break;
		case'shanghai':$province='上海';break;
		case'tianjin':$province='天津';break;
		case'chongqing':$province='重庆';break;
		case'hebei':$province='河北';break;
		case'shanxi':$province='山西';break;
		case'liaoning':$province='辽宁';break;
		case'jilin':$province='吉林';break;
		case'heilongjiang':$province='黑龙江';break;
		case'jiangshu':$province='江苏';break;
		case'zejinag':$province='浙江';break;
		case'anhui':$province='安徽';break;
		case'fujian':$province='福建';break;
		case'jiangxi':$province='江西';break;
		case'shandong':$province='山东';break;
		case 'henan':$province='河南';break;
		case'hubei':$province='湖北';break;
		case'hunan':$province='湖南';break;
		case'guangdong':$province='广东';break;
		case'guangxi':$province='广西';break;
		case'neimenggu':$province='内蒙古';break;
		case'hainan':$province='海南';break;
		case'shichuan':$province='四川';break;
		case'guizhou':$province='贵州';break;
		case'yunnan':$province='云南';break;
		case'xizhang':$province='西藏';break;
		case'shanxi':$province='陕西';break;
		case'ganshu':$province='甘肃';break;
		case'ningxia':$province='宁夏';break;
		case'qinghai':$province='青海';break;
		case'xinjiang':$province='新疆';break;
		case'hongkong':$province='香港';break;
		case'aomen':$province='澳门';break;
		default:$province=$zm;
	}
	return $province;
}
function passed($table){
	global $username;
	if(check_user_power('passed')=='yes'){
		mysql_query("update `$table` set passed=1 where editor='".$username."'");
	}
}

function getIPLoc_sina($queryIP){
	$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
	$ch = curl_init($url);
//curl_setopt($ch,CURLOPT_ENCODING ,'utf8');     
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
	$location = curl_exec($ch);
	$location = json_decode($location);
	curl_close($ch);
	$loc = "";
	if($location===FALSE) return "";
	if (empty($location->desc)) {
		@$loc = $location->province.$location->city.$location->district.$location->isp;
	}else{
		$loc = $location->desc;
	}
	return $loc;
}

function sitecount($cs){
	global $siteskin;
	$fpath=zzcmsroot."/cache/".$siteskin."/sitecount.txt";
	if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
		return file_get_contents($fpath);
	}else{
		$str='';
		$cs=explode(",",$cs); //传入的$cs是一个整体字符串
		$users=isset($cs[0])?$cs[0]:'';
		$zs=isset($cs[1])?$cs[1]:'';
		$dl=isset($cs[2])?$cs[2]:'';
		$zx=isset($cs[3])?$cs[3]:'';

		if ($users=='users'){
			$sql="select id from zzcms_user";
			$rs=mysql_query($sql);
			$row=mysql_num_rows($rs);
			$str=$str. "<li>用户<span>".$row."</span>条</li>";
		}
		if ($zs=='zs'){
			$sql="select id from zzcms_main";
			$rs=mysql_query($sql);
			$row=mysql_num_rows($rs);
			$str=$str."<li>招商<span>".$row."</span>条</li>";
		}
		if ($dl=='dl'){
			$sql="select id from zzcms_dl";
			$rs=mysql_query($sql);
			$row=mysql_num_rows($rs);
			$str=$str."<li>代理<span>".$row."</span>条 </li>";
		}

		if ($zx=='zx'){
			$sql="select id from zzcms_zx";
			$rs=mysql_query($sql);
			$row=mysql_num_rows($rs);
			$str=$str."<li>资讯<span>".$row."</span>条</li>";
		}
		if (cache_update_time!=0){
			$fpath=zzcmsroot."cache/".$siteskin."/sitecount.txt";
			$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
			fputs($fp,stripfxg($str));//写入文件
			fclose($fp);
		}
		return $str;
	}
}

function removeBOM($str = ''){
	if (substr($str,0,3) == pack("CCC",0xef,0xbb,0xbf)) {
		$str = substr($str, 3);
	}
	return $str;
}

function del_dirandfile( $dir ){
	if (file_exists($dir)){
		if ( $handle = opendir( "$dir" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dir/$item" ) ) {
						del_dirandfile( "$dir/$item" );
					} else {
						if( unlink( "$dir/$item" ) )echo "成功删除文件： $dir/$item<br /> ";
					}
				}
			}
			closedir( $handle );
			if( rmdir( $dir ) )echo "成功删除目录： $dir<br /> ";
		}
	}else{
		echo $dir."目录已不存在，已完成清理<br />";
	}
//echo "缓存已被清理<br />";
}

function checkadminisdo($str){
	$rs=mysql_query("select config from zzcms_admingroup where id=(select groupid from zzcms_admin where pass='".@$_SESSION["pass"]."' and admin='".@$_SESSION["admin"]."')");//只验证密码会出现，两个管理员密码相同的情况，导致出错,前加@防止SESSION失效后出错提示
	$row=mysql_fetch_array($rs);
	$config=$row["config"];
	if(str_is_inarr($config,$str)=='no'){
		showmsg('没有操作权限!');
	}
}

function checkadminhaspower($str){
	$rs=mysql_query("select config from zzcms_admingroup where id=(select groupid from zzcms_admin where pass='".@$_SESSION["pass"]."' and admin='".@$_SESSION["admin"]."')");//只验证密码会出现，两个管理员密码相同的情况，导致出错,前加@防止SESSION失效后出错提示
	$row=mysql_fetch_array($rs);
	$config=$row["config"];
	if (str_is_inarr($config,$str)=='yes'){return 'yes';}else{return 'no';}
}

function check_user_power($str){
	global $username;
	if (!isset($username)){
		$username=$_COOKIE["UserName"];
	}
	$sql="select config from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	$config=$row["config"];
	if (str_is_inarr($config,$str)=='yes'){return 'yes';}else{return 'no';}
}

function str_is_inarr($arrs,$str){
	if(strpos($arrs,'#')!==false){//多个,循环值后对比,内容较多，要转换成数组，如果只用strpos字符判断，有重复的字符
		$arr=explode("#",$arrs); //转换成数组
		if(in_array($str,$arr)){return 'yes';}else{return 'no';}
	}else{//单个,直接对比
		if($arrs==$str){return 'yes';}else{return 'no';}
	}
}

function get_zhuyuming($str){
	$houzhui_array = array(".com",".net",".org",".gov",".edu","com.cn",".cn",".tv",".cc");
	for($i=0; $i<count($houzhui_array);$i++){
		$str=str_replace($houzhui_array[$i],'',$str);
	}
	return $str;
}

function check_isip($str){
	if(preg_match("/[\d]{2,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}/", $str))
		return true;
	return false;
}
?>