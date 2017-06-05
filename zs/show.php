<?php
if(!isset($_SESSION)){session_start();}
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("../zx/subzx.php");
include("subzs.php");

$token = md5(uniqid(rand(), true));
$_SESSION['token']= $token;

if (isset($_REQUEST["id"])){
	$cpid=trim($_REQUEST["id"]);
	checkid($cpid);
}else{
	$cpid=0;
}

if (isset($_REQUEST["editor"])<>"") {
	$editor=$_REQUEST["editor"];
}else{
	$editor='';
}

if($editor<>""){
	$sql="select * from zzcms_user where username='".$editor."'";
}elseif ($cpid<>0){
	$sql="select * from zzcms_user where username=(Select editor From zzcms_main where id='$cpid')";
}

$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
$startdate=$row["startdate"];
$comane=$row["comane"];
$gsjj=nl2br($row["content"]);
$somane=$row["somane"];
$userid=$row["id"];
$sex=$row["sex"];
$phone=$row["phone"];
$user_tel=$row["phone"];//项目单页中有用，避免被下面产品留言中的$phone覆盖这里另取名$tel
$fox=$row["fox"];
$user_mobile=$row["mobile"];
$qq=$row["qq"];
$email=$row["email"];

if($editor<>""){
	$sql="select * from zzcms_main where editor='$editor'";
}elseif ($cpid<>0){
	$sql="select * from zzcms_main where id='$cpid'";
}

$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if (!$row){
	echo showmsg("不存在相关信息！");
}else{
	$cpid=$row["id"];

	if (isset($_COOKIE["zzcmscpid"])){
		if ($cpid<>$_COOKIE["zzcmscpid"]){
			setcookie("zzcmscpid",$cpid.",".$_COOKIE["zzcmscpid"],time()+3600*24*360);//setcookie() 函数必须位于 <html> 标签之前。
		}else{
			setcookie("zzcmscpid",$cpid,time()+3600*24*360);
		}
	}else{
		setcookie("zzcmscpid",$cpid,time()+3600*24*360);
	}

	mysql_query("update zzcms_main set hit=hit+1 where id='$cpid'");
	mysql_query("update zzcms_sitecount set hit=hit+1");
	$editor=$row["editor"];
	$bigclasszm=$row["bigclasszm"];
	$smallclasszm=$row["smallclasszm"];
	$flv=$row["flv"];
	$bodybg=$row["bodybg"];
	$bodybgrepeat=$row["bodybgrepeat"];
	$swf=$row["swf"];
	if ($swf==''){
		$swf='qipao4.swf';
	}
	$hit=$row["hit"];
	$img=$row["img"];
	$title=$row["title"];
	$keywords=$row["keywords"];
	$description=$row["description"];
//$sm=$row["sm"];
	$phone=$row["phone"];
	$mobile=$row["mobile"];
	$qq=$row["qq"];
	$province=$row["province"];
	$city=$row["city"];
	$xiancheng=$row["xiancheng"];
	$tz=$row["tz"];
	$shuxing_value = explode("|||",$row["shuxing_value"]);
	function showflv($flv){
		global $img;
		if ($flv!=""){
			$str="<div class='box' style='text-align:center'>";
			if (substr($flv,-3)=="flv") {
				$str=$str . "<span id='container'></span>";
				$str=$str . "<script src='/js/swfobject.js' type='text/javascript'></script>";
				$str=$str . "<script type='text/javascript'>";
				$str=$str . "var s1 = new SWFObject('/image/player.swf','ply','500','360','9','#FFFFFF');";
				$str=$str . "s1.addParam('allowfullscreen','true');";
				$str=$str . "s1.addParam('allowscriptaccess','always');";
				$str=$str . "s1.addParam('flashvars','file=".$flv."&backcolor=&frontcolor=&image=".$img."&logo=".logourl."&autostart=false');";
				$str=$str . "s1.write('container');";
				$str=$str . "</script>";
			}elseif (substr($flv,-3)=="swf"){
				$str=$str . "<embed src='".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=500 height=360></embed>";
			}
			$str=$str . "</div>" ;
			return  $str;
		}
	}

	$rs=mysql_query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
	$row=mysql_fetch_array($rs);
	if ($row){
		$bigclassname=$row["classname"];
	}else{
		$bigclassname="大类已删除";
	}

	$smallclassname='';
	if ($smallclasszm<>""){
		$rs=mysql_query("select classname from zzcms_zsclass where classzm='".$smallclasszm."'");
		$row=mysql_fetch_array($rs);
		if ($row){
			$smallclassname=$row["classname"];
		}else{
			$smallclassname="小类已删除";
		}
	}



	$fp="../template/".$siteskin."/zsshow.htm";
	$f = fopen($fp,'r');
	$strout = fread($f,filesize($fp));
	fclose($f);

	$fp="../web/".$editor."/index.htm";
	if (file_exists($fp)==false){
		WriteErrMsg($fp.'目录不存在');
		exit;
	}
	$f = fopen($fp,'r');
	$sm = fread($f,filesize($fp));
	fclose($f);

	$licence=strbetween($strout,"{licence}","{/licence}");
	$rs=mysql_query("select img,title,passed,editor from zzcms_licence where editor='" .$editor. "' and passed=1");
	$row=mysql_num_rows($rs);
	if ($row){
		$n=0;
		$licence2='';
		while ($row=mysql_fetch_array($rs)){
			$licence2 = $licence2. str_replace("{#img}",getsmallimg($row['img']),$licence) ;
			$licence2 =str_replace("{#imgbig}",siteurl.$row['img'],$licence2) ;
			$licence2 =str_replace("{#link}",siteurl.$row['img'],$licence2) ;
			$licence2 =str_replace("{#title}",cutstr($row["title"],6),$licence2) ;

			$n=$n+1;
			($n % 6==0)?$tr="<tr>":$tr="";
			$licence2 =str_replace("{tr}",$tr,$licence2) ;
		}
		$strout=str_replace("{licence}".$licence."{/licence}",$licence2,$strout) ;
	}else{
		$strout=str_replace("{licence}".$licence."{/licence}","暂无信息",$strout) ;
	}

	$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
	$strout=str_replace("{#siteurl}",siteurl,$strout) ;
	$strout=str_replace("{#sitename}",sitename,$strout) ;
	if ($title<>"") {
		$strout=str_replace("{#pagetitle}",$title."-".zsshowtitle,$strout);
	}else{
		$strout=str_replace("{#pagetitle}",$title,$strout);
	}
	$strout=str_replace("{#pagekeywords}",$keywords,$strout);
	$strout=str_replace("{#pagedescription}",$description,$strout);
	$strout=str_replace("{#flv}",showflv($flv),$strout);

	$strout=str_replace("{#bigclassname}",$bigclassname,$strout);
	$strout=str_replace("{#smallclassname}",$smallclassname,$strout);

	$strout=str_replace("{#bodybg}",$bodybg,$strout);
	$strout=str_replace("{#bodybgrepeat}",$bodybgrepeat,$strout);
	$strout=str_replace("{#swf}",$swf,$strout);
	$strout=str_replace("{#sm}",$sm,$strout);
	$strout=str_replace("{#tel}",$phone,$strout);
	$strout=str_replace("{#kfqq}",$qq,$strout);
	$strout=str_replace("{#fbr}",$editor,$strout);
	$strout=str_replace("{#token}",$token,$strout);
	$strout=str_replace("{#hit}",$hit,$strout);
	$strout=str_replace("{#imgbig}",$img,$strout);
	$strout=str_replace("{#province}",$province,$strout);
	$strout=str_replace("{#city}",$city,$strout);
	$strout=str_replace("{#xiancheng}",$xiancheng,$strout);
	$strout=str_replace("{#tz}",$tz,$strout);
	for ($i=0; $i< count($shuxing_value);$i++){
		$strout=str_replace("{#shuxing".$i."}",$shuxing_value[$i],$strout);
	}

	$strout=str_replace("{#user_tel}",$user_tel,$strout);
	$strout=str_replace("{#user_mobile}",$user_mobile,$strout);
	$strout=str_replace("{#comane}",$comane,$strout);
	$strout=str_replace("{#gsjj}",$gsjj,$strout);

	$strout=str_replace("{#sitetop}",sitetop(),$strout);
	$strout=str_replace("{#sitebottom}",sitebottom(),$strout);

	if (dl_liuyan_set == "No") {
		$strout = str_replace("{#starthtmlnotes}", '<!--', $strout);
		$strout = str_replace("{#endhtmlnotes}", '-->', $strout);
	}
	$strout=showlabel($strout);
	mysql_close($conn);
	echo  $strout;
}
?>