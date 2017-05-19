<?php
session_start();//为向AJAX/zs.php中传b,s值
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzs.php");
include("../label.php");
if (@$_GET["action"]=='clear_cookies'){
	setcookie("zzcmseditor",'xxx',1,"/");
	setcookie("zzcmseditor","",time()-3600);
	setcookie("zzcmscpid","",time()-3600);
	echo "<script>location.href='zs.php'</script>";
}
if (isset($_GET["px"])){
	$px=$_GET["px"];
	if ($px!='hit' && $px!='id' && $px!='sendtime'){
		$px="sendtime";
	}
	setcookie("pxzs",$px,time()+3600*24*360);
}else{
	if (isset($_COOKIE["pxzs"])){
		$px=$_COOKIE["pxzs"];
	}else{
		$px="sendtime";
	}
}
if (isset($_GET["page_size"])){
	$page_size=$_GET["page_size"];
	checkid($page_size);
	setcookie("page_size_zs",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zs"])){
		$page_size=$_COOKIE["page_size_zs"];
	}else{
		$page_size=pagesize_qt;
	}
}

if (isset($_GET["ys"])){
	$ys=$_GET["ys"];
	setcookie("yszs",$ys,time()+3600*24*360);
}else{
	if (isset($_COOKIE["yszs"])){
		$ys=$_COOKIE["yszs"];
	}else{
		$ys="list";
	}
}
if (strpos($siteskin,'mobile')!==false){
	$ys="window";//如果是手机版则设为window
}

$b = isset($_GET['b'])?$_GET['b']:"";
$_SESSION['zs_b']=$b;

$s = isset($_GET['s'])?$_GET['s']:"";
$_SESSION['zs_s']=$s;

if (isset($_GET['province'])){
	$provinceNew=$_GET['province'];
	setcookie("zsprovince",$provinceNew,time()+3600*24);
	$province=$provinceNew;
}else{
	if (isset($_COOKIE['zsprovince'])){
		$province=$_COOKIE['zsprovince'];
	}else{
		$province="";
	}
}

if (isset($_GET['p_id'])){
	$p_idNew=$_GET['p_id'];
	setcookie("zsp_id",$p_idNew,time()+3600*24);
	$p_id=$p_idNew;
}else{
	if (isset($_COOKIE['zsp_id'])){
		$p_id=$_COOKIE['zsp_id'];
	}else{
		$p_id="";
	}
}

$descriptions="";
$keywords="";
$titles="";
$bigclassname="";

$descriptionsx="";
$keywordsx="";
$titlesx="";
$smallclassname="";

if ($b<>""){
	$sql="select * from zzcms_zsclass where classzm='".$b."'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	if ($row){
		$descriptions=$row["discription"];
		$keywords=$row["keyword"];
		$titles=$row["title"];
		$bigclassname=$row["classname"];
	}
}

if ($s<>"") {
	$sql="select * from zzcms_zsclass where classzm='".$s."'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	if ($row){
		$descriptionsx=$row["discription"];
		$keywordsx=$row["keyword"];
		$titlesx=$row["title"];
		$smallclassname=$row["classname"];
	}
}
if ($titlesx!=''){
	$pagetitle=$titlesx;
}elseif($titles!=''){
	$pagetitle=$titles;
}else{
	$pagetitle=zslisttitle;
}
if ($keywordsx!=''){
	$pagekeyword=$keywordsx;
}elseif($keywords!=''){
	$pagekeyword=$keywords;
}else{
	$pagekeyword=zslistkeyword;
}
if ($descriptionsx!=''){
	$pagedescription=$descriptionsx;
}elseif($descriptions!=''){
	$pagedescription=$descriptions;
}else{
	$pagedescription=zslistdescription;
}

$station=getstation($b,$bigclassname,$s,$smallclassname,"","","zs");

if( isset($_GET["page"]) && $_GET["page"]!="") {
	$page=$_GET['page'];
	checkid($page);
}else{
	$page=1;
}

function formbigclass(){
	$str="";
	$sql = "select * from zzcms_zsclass where parentid='A'";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if (!$row){
		$str= "请先添加类别名称。";
	}else{
		while($row=mysql_fetch_array($rs)){
			$str=$str. "<a href=/zs/search.php?b=".$row["classzm"].">".$row["classname"]."</a>&nbsp;";
		}
	}
	return $str;
}

function formprovince(){
	$str="";
	global $citys;
	$city=explode("#",$citys);
	$c=count($city);//循环之前取值
	for ($i=0;$i<$c;$i++){
		$location_p=explode("*",$city[$i]);//取数组的第一个就是省份名，也就是*左边的
		$str=$str . "<a href=/zs/search.php?province=".$location_p[0]."&p_id=".$i.">".$location_p[0]."</a>&nbsp;&nbsp;";
	}
	return $str;
}

if ($b=="") {
	$zsclass=bigclass(6,2);
}else{
	$zsclass= showzssmallclass($b,$s,10,'');
}

$form_px= "<select name='menu2' onChange=MM_jumpMenu('parent',this,0)>";
if ($px=="id") {
	$form_px=$form_px . "<option value=/zs/zs.php?b=".$b."&s=".$s."&px=id selected>最近发布</option>";
}else{
	$form_px=$form_px . "<option value=/zs/zs.php?b=".$b."&s=".$s."&px=id >最近发布</option>";
}
if( $px=="sendtime") {
	$form_px=$form_px . "<option value='/zs/zs.php?b=".$b."&s=".$s."&px=sendtime' selected>最近更新</option>";
}else{
	$form_px=$form_px . "<option value='/zs/zs.php?b=".$b."&s=".$s."&px=sendtime'>最近更新</option>";
}
if ($px=="hit") {
	$form_px=$form_px . "<option value='/zs/zs.php?b=".$b."&s=".$s."&px=hit' selected>最热点击</option>";
}else{
	$form_px=$form_px . "<option value='/zs/zs.php?b=".$b."&s=".$s."&px=hit'>最热点击</option>";
}
$form_px=$form_px . "</select>&nbsp;";

$showselectpage=showselectpage("zs",$page_size,$b,$s,$page);

$form_xs="&nbsp;<a href='/zs/zs.php?b=".$b."&s=".$s."&page=".$page."&ys=list'>";
if ($ys=="list") {
	$form_xs=$form_xs . "<img src='/image/showlist.gif' border='0' title='图文显示' style='filter:gray'/>";
}else{
	$form_xs=$form_xs . "<img src='/image/showlist.gif' border='0' title='图文显示' />";
}
$form_xs=$form_xs . "</a> ";

$form_xs=$form_xs . "<a href='/zs/zs.php?b=".$b."&s=".$s."&page=".$page."&ys=window'>";
if ($ys=="window") {
	$form_xs=$form_xs . "<img src='/image/showwindow.gif' border='0' title='橱窗显示' style='filter:gray'/>";
}else{
	$form_xs=$form_xs . "<img src='/image/showwindow.gif' border='0' title='橱窗显示' />";
}
$form_xs=$form_xs . "</a> ";

$fp="../template/".$siteskin."/zs.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$sql="select count(*) as total from zzcms_main where passed<>0 ";
$sql2='';
if ($b<>""){
	$sql2=$sql2. "and bigclasszm='".$b."' ";
}
if ($s<>"") {
	$sql2=$sql2." and smallclasszm ='".$s."'  ";
}
$rs = mysql_query($sql.$sql2);
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_main where passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by ".$px." desc limit $offset,$page_size";
$rs = mysql_query($sql);

$zs=strbetween($strout,"{zs}","{/zs}");
$list_list=strbetween($strout,"{loop_list}","{/loop_list}");
$list_window=strbetween($strout,"{loop_window}","{/loop_window}");
if ($ys=="window"){
	$proname_num=strbetween($list_window,"{#proname:","}");
}else{
	$proname_num=strbetween($list_list,"{#proname:","}");
}
if(!$totlenum){
	$strout=str_replace("{zs}".$zs."{/zs}","暂无信息",$strout) ;
}else{

	$list2="";
	$i=0;
	$keyword="";
	$province="";
	while($row= mysql_fetch_array($rs)){
		//$zslist=$zslist.$row['proname']
		if ($ys=="window"){
			$list2 = $list2. str_replace("{#id}",$row["id"],$list_window) ;
		}else{
			$list2 = $list2. str_replace("{#id}",$row["id"],$list_list) ;
		}
		$list2 =str_replace("{#i}",$i,$list2) ;
		$list2 =str_replace("{#url}",getpageurlzs($row["editor"],$row["id"]),$list2) ;
		$list2 =str_replace("{#proname:".$proname_num."}",cutstr($row["proname"],$proname_num),$list2) ;
		$list2 =str_replace("{#img}",getsmallimg($row["img"]),$list2) ;
		$list2 =str_replace("{#imgbig}" ,$row["img"],$list2) ;
		$list2 =str_replace("{#comane}",$row["comane"],$list2) ;
		$list2 =str_replace("{#province}",$row["province"],$list2) ;
		$list2 =str_replace("{#city}",$row["city"],$list2) ;
		$list2 =str_replace("{#xiancheng}",$row["xiancheng"],$list2) ;
		$list2 =str_replace("{#address}",$row["address"],$list2) ;
		$list2 =str_replace("{#groupid}",$row["groupid"],$list2) ;
		$list2 =str_replace("{#userid}",$row["userid"],$list2) ;
		$list2 =str_replace("{#zturl}",getpageurl("zt",$row["userid"]),$list2) ;//展厅地址

		if ($row["renzheng"]==1) {
			$list2 =str_replace("{#renzheng}" ,"<img src='/image/ico_renzheng.png' alt='认证会员'>",$list2) ;
		}else{
			$list2 =str_replace("{#renzheng}" ,"",$list2) ;
		}

		if ($row["elite"]>0) {
			$list2 =str_replace("{#elite}" ,"<img src='/image/ico_jian.png' alt='tag:".$row["elite"]."' >",$list2) ;
		}else{
			$list2 =str_replace("{#elite}" ,"",$list2) ;
		}

		if ($row["qq"]!=''){
			$showqq="<a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$row["qq"]."&Site=".sitename."&MMenu=yes><img border='0' src='http://wpa.qq.com/pa?p=1:".$row["qq"].":10' alt='QQ交流'></a> ";
			$list2 =str_replace("{#qq}",$showqq,$list2) ;
		}else{
			$list2 =str_replace("{#qq}","",$list2) ;
		}

		$shuxing_value = explode("|||",$row["shuxing_value"]);
		for ($n=0; $n< count($shuxing_value);$n++){
			$list2=str_replace("{#shuxing".$n."}",$shuxing_value[$n],$list2);
		}

		$list2 =str_replace("{#prouse}",cutstr($row["prouse"],40),$list2) ;
		$list2 =str_replace("{#tz}",$row["tz"],$list2) ;
		$list2 =str_replace("{#sendtime}",$row["sendtime"],$list2) ;

		//echo "select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."";
		$rsn=mysql_query("select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."");
		$rown=mysql_fetch_array($rsn);
		if ($rown){
			$list2 =str_replace("{#grouppic}" ,"<img src=".$rown["grouppic"]." alt=".$rown["groupname"].">",$list2) ;
		}

		if (showdlinzs=="Yes") {
			$rsn=mysql_query("select id from zzcms_dl where saver='".$row["editor"]."' and passed=1");
			$list2 =str_replace("{#dl_num}","(代理留言<font color='#FF6600'><b>".mysql_num_rows($rsn)."</b></font>条)",$list2) ;
		}else{
			$list2 =str_replace("{#dl_num}","",$list2) ;
		}

		$i=$i+1;
	}

	if ($ys=="window"){
		$strout=str_replace("{loop_window}".$list_window."{/loop_window}",$list2,$strout) ;
		$strout=str_replace("{loop_list}".$list_list."{/loop_list}","",$strout) ;
	}else{
		$strout=str_replace("{loop_list}".$list_list."{/loop_list}",$list2,$strout) ;
		$strout=str_replace("{loop_window}".$list_window."{/loop_window}","",$strout) ;
	}
	$strout=str_replace("{#fenyei}",showpage2("zs"),$strout) ;
	$strout=str_replace("{zs}","",$strout) ;
	$strout=str_replace("{/zs}","",$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#station}",$station,$strout) ;
$strout=str_replace("{#zsclass}",$zsclass,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
$strout=str_replace("{#formprovince}",formprovince(),$strout);
$strout=str_replace("{#form_px}",$form_px,$strout);
$strout=str_replace("{#showselectpage}",$showselectpage,$strout);
$strout=str_replace("{#form_xs}",$form_xs,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo $strout;
?>