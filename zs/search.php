<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../inc/fy.php");
include("subzs.php");
include("../label.php");
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
		$ys="window";//默认设为window，为手机版所用
	}
}
if (isset($_GET['yiju'])){
	$yiju=$_GET['yiju'];
}else{
	$yiju="Pname";
}

if (isset($_GET['keyword'])){
	$keywordNew=trim($_GET['keyword']);
	setcookie("keyword",$keywordNew,time()+3600*24);
	setcookie("b","xxx",1);
	setcookie("s","xxx",1);
	setcookie("province","xxx",1);
	setcookie("city","xxx",1);
	setcookie("xiancheng","xxx",1);
	setcookie("p_id","xxx",1);
	setcookie("c_id","xxx",1);
	setcookie("tz","xxx",1);
	echo "<script>location.href='search.php'</script>";
	$keyword=$keywordNew;
}else{
	if (isset($_COOKIE['keyword'])){
		$keyword=trim($_COOKIE['keyword']);
	}else{
		$keyword="";
	}
}

if (isset($_GET['b'])){
	$bNew=$_GET['b'];
	setcookie("b",$bNew,time()+3600*24);
	setcookie("s","xxx",1);
	echo "<script>location.href='search.php'</script>";
	$b=$bNew;
}else{
	if (isset($_COOKIE['b'])){
		$b=$_COOKIE['b'];
	}else{
		$b="";
	}
}

if (isset($_GET['s'])){
	$sNew=$_GET['s'];
	setcookie("s",$sNew,time()+3600*24);
	$s=$sNew;
}else{
	if (isset($_COOKIE['s'])){
		$s=$_COOKIE['s'];
	}else{
		$s="";
	}
}

if (isset($_GET['province'])){
	$provinceNew=$_GET['province'];
	setcookie("province",$provinceNew,time()+3600*24);
	$province=$provinceNew;
	if  (@$_COOKIE['city']<>""){
		setcookie("city","xxx",1);
		setcookie("c_id","xxx",1);
		setcookie("xiancheng","xxx",1);
		echo "<script>location.href='search.php'</script>";
	}
}else{
	if (isset($_COOKIE['province'])){
		$province=$_COOKIE['province'];
	}else{
		$province="";
	}
}

if (isset($_GET['p_id'])){
	$p_idNew=$_GET['p_id'];
	setcookie("p_id",$p_idNew,time()+3600*24);
	$p_id=$p_idNew;
}else{
	if (isset($_COOKIE['p_id'])){
		$p_id=$_COOKIE['p_id'];
	}else{
		$p_id="";
	}
}

if (isset($_GET['city'])){
	$cityNew=$_GET['city'];
	setcookie("city",$cityNew,time()+3600*24);
	$city=$cityNew;
}else{
	if (isset($_COOKIE['city'])){
		$city=$_COOKIE['city'];
	}else{
		$city="";
	}
}

if (isset($_GET['c_id'])){
	$c_idNew=$_GET['c_id'];
	setcookie("c_id",$c_idNew,time()+3600*24);
	$c_id=$c_idNew;
}else{
	if (isset($_COOKIE['c_id'])){
		$c_id=$_COOKIE['c_id'];
	}else{
		$c_id="";
	}
}

if (isset($_GET['xiancheng'])){
	$xianchengNew=$_GET['xiancheng'];
	setcookie("xiancheng",$xianchengNew,time()+3600*24);
	$xiancheng=$xianchengNew;
}else{
	if (isset($_COOKIE['xiancheng'])){
		$xiancheng=$_COOKIE['xiancheng'];
	}else{
		$xiancheng="";
	}
}

if (isset($_GET['tz'])){
	$tzNew=$_GET['tz'];
	setcookie("tz",$tzNew,time()+3600*24);
	$tz=$tzNew;
}else{
	if (isset($_COOKIE['tz'])){
		$tz=$_COOKIE['tz'];
	}else{
		$tz='';
	}
}

if (isset($_GET['delb'])){
	setcookie("b","xxx",1);
	echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
	setcookie("s","xxx",1);
	echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delprovince'])){
	setcookie("province","xxx",1);
	setcookie("city","xxx",1);
	setcookie("p_id","xxx",1);
	setcookie("c_id","xxx",1);
	setcookie("xiancheng","xxx",1);
	echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delcity'])){
	setcookie("city","xxx",1);
	setcookie("c_id","xxx",1);
	setcookie("xiancheng","xxx",1);
	echo "<script>location.href='search.php'</script>";
}

if (isset($_GET['delxiancheng'])){
	setcookie("xiancheng","xxx",1);
	echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['deltz'])){
	setcookie("tz","xxx",1);
	echo "<script>location.href='search.php'</script>";
}

$pagetitle="搜索招商信息-".sitename;
$pagekeyword="搜索招商信息-".sitename;
$pagedescription="搜索招商信息-".sitename;
if ($b<>""){
	$sql="select * from zzcms_zsclass where classzm='".$b."'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	if ($row){
		$bigclassname=$row["classname"];
	}
}else{
	$bigclassname="";
}
if ($s<>"") {
	$sql="select * from zzcms_zsclass where classzm='".$s."'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	if ($row){
		$smallclassname=$row["classname"];
	}
}else{
	$smallclassname="";
}

if( isset($_GET["page"]) && $_GET["page"]!="") {
	$page=$_GET['page'];
	checkid($page_size);
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
			$str=$str. "<a href=?b=".$row["classzm"].">".$row["classname"]."</a>&nbsp;";
		}
	}
	return $str;
}

function formsmallclass($b){
	$str="";
	$sql="select * from zzcms_zsclass where parentid='" .$b. "' order by xuhao asc";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if ($row){
		while($row=mysql_fetch_array($rs)){
			$str=$str. "<a href=?s=".$row["classzm"].">".$row["classname"]."</a>&nbsp;";
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
		$str=$str . "<a href=?province=".$location_p[0]."&p_id=".$i.">".$location_p[0]."</a>&nbsp;&nbsp;";
	}
	return $str;
}

function formcity(){
	global $citys,$p_id;
	$str="";
	if ($p_id<>"") {
		$city=explode("#",$citys);
		$location_cs=explode("*",$city[$p_id]);//取指定省份下的
		$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
		$c=count($location_cs2);//循环之前取值
		for ($i=0;$i<$c;$i++){
			$location_cs3=explode(",",$location_cs2[$i]);//取指定省份下的
			$str=$str . "<a href=?city=".$location_cs3[0]."&c_id=".$i.">".$location_cs3[0]."</a>&nbsp;&nbsp;";
		}
	}else{
		$city="";
	}
	return $str;
}

function formxiancheng(){
	global $citys,$p_id,$c_id;
	$str="";
	if ($p_id<>"" && $c_id<>"") {
		$city=explode("#",$citys);
		$location_cs=explode("*",$city[$p_id]);//取指定省份下的
		$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
		$location_cs3=explode(",",$location_cs2[$c_id]);//取指定市和县下的
		$c=count($location_cs3);//循环之前取值
		for ($i=1;$i<$c;$i++){ //从1开始，0对应的是，前面的市名，市名不要，这里只显示县名。
			$str=$str . "<a href=?xiancheng=".$location_cs3[$i].">".$location_cs3[$i]."</a>&nbsp;&nbsp;";
		}
	}else{
		$xiancheng="";
	}
	return $str;
}

if ($b<>"" || $s<>""|| $province<>"" || $city<>"" || $xiancheng<>"" || $tz<>"") {
	setcookie("keyword","xxx",1);//当有筛选条件时，则清空关键词，使两者独立搜索，否则删除这行代码即可。
	$selected="<tr>";
	$selected=$selected."<td align='right'>已选：</td>";
	$selected=$selected."<td class='a_selected'>";
	if ($b<>"") {
		$selected=$selected."<a href='?delb=Yes' title='删除已选'>".$bigclassname."×</a>&nbsp;";
	}
	if ($s<>""){
		$selected=$selected."<a href='?dels=Yes' title='删除已选'>".$smallclassname."×</a>&nbsp;";
	}
	if ($province<>""){
		$selected=$selected."<a href='?delprovince=Yes' title='删除已选'>".$province."×</a>&nbsp;";
	}
	if ($city<>""){
		$selected=$selected."<a href='?delcity=Yes' title='删除已选'>".$city."×</a>&nbsp;";
	}
	if ($xiancheng<>""){
		$selected=$selected."<a href='?delxiancheng=Yes' title='删除已选'>".$xiancheng."×</a>&nbsp;";
	}
	if ($tz<>"") {
		$selected=$selected."<a href='?deltz=Yes' title='删除已选'>".$tz."×</a>&nbsp;";
	}

	$selected=$selected."</td>";
	$selected=$selected."</tr>";
}else{
	$selected="";
}

$fp="../template/".$siteskin."/zs_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$sql="select count(*) as total from zzcms_main where passed<>0 ";
$sql2='';

if ($b<>""){
	$sql2=$sql2."and bigclasszm='".$b."' ";
}

if ($s<>"") {
	$sql2=$sql2." and smallclasszm ='".$s."'  ";
}
if ($xiancheng<>"") {
	$sql2=$sql2."and xiancheng like '%".$xiancheng."%' ";
}elseif ($city<>"") {
	$sql2=$sql2."and city like '%".$city."%' ";
}elseif ($province<>"") {
	$sql2=$sql2."and province like '%".$province."%' ";
}
if ($tz!="" ){
	$sql2=$sql2."and tz='". $tz ."' ";
}

if ($keyword!=''){
	switch ($yiju){
		case "Pname";
			$sql2=$sql2. " and proname like '%".$keyword."%' ";//加括号,否则后面的条件无效
			//echo  $sql;
			break;
		case "Pcompany";
			$sql2=$sql2."and comane like '%".$keyword."%' " ;
			//strwhere=" editor in (select username from zzcms_user where comane like '%"&keyword&"%') "
			break;
	}
}

$rs = mysql_query($sql.$sql2);
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);
$sql="select * from zzcms_main where passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by elite desc,".$px." desc limit $offset,$page_size";
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

	$strout=str_replace("{#totlenum}",$totlenum,$strout) ;
	$i=0;
	$list2='';

	$i=0;
	while($row= mysql_fetch_array($rs)){
		//$zslist=$zslist.$row['proname']
		if ($ys=="window"){
			$list2 = $list2. str_replace("{#id}",$row["id"],$list_window) ;
		}else{
			$list2 = $list2. str_replace("{#id}",$row["id"],$list_list) ;
		}
		$list2 =str_replace("{#i}" ,$i,$list2) ;
		$list2 =str_replace("{#url}" ,getpageurlzs($row["editor"],$row["id"]),$list2) ;
		$list2 =str_replace("{#proname:".$proname_num."}",cutstr($row["proname"],$proname_num),$list2) ;
		$list2 =str_replace("{#img}" ,getsmallimg($row["img"]),$list2) ;
		$list2 =str_replace("{#imgbig}" ,$row["img"],$list2) ;
		$list2 =str_replace("{#comane}" ,$row["comane"],$list2) ;
		$list2 =str_replace("{#province}" ,$row["province"],$list2) ;
		$list2 =str_replace("{#city}" ,$row["city"],$list2) ;
		$list2 =str_replace("{#xiancheng}",$row["xiancheng"],$list2) ;
		$list2 =str_replace("{#address}",$row["address"],$list2) ;
		$list2 =str_replace("{#groupid}" ,$row["groupid"],$list2) ;
		$list2 =str_replace("{#userid}" ,$row["userid"],$list2) ;
		$list2 =str_replace("{#zturl}" ,getpageurl("zt",$row["userid"]),$list2) ;//展厅地址

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

		$list2 =str_replace("{#gg}" ,$row["gg"],$list2) ;
		$list2 =str_replace("{#prouse}" ,cutstr($row["prouse"],40),$list2) ;
		$list2 =str_replace("{#tz}" ,$row["tz"],$list2) ;
		$list2 =str_replace("{#sendtime}" ,$row["sendtime"],$list2) ;

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
	$strout=str_replace("{#fenyei}",showpage1(),$strout) ;
	$strout=str_replace("{zs}","",$strout) ;
	$strout=str_replace("{/zs}","",$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#station}",getstation(0,"",0,"","",$keyword,"zs"),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
if ($b=="") {//当小类为空显示大类，否则只显小类
	$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
}else{
	$strout=str_replace("{#formbigclass}","",$strout);
}
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);

if ($province=="") {
	$strout=str_replace("{#formprovince}",formprovince(),$strout);
}else{
	$strout=str_replace("{#formprovince}","",$strout);
}
if ($city=="") {
	$strout=str_replace("{#formcity}",formcity(),$strout);
}else{
	$strout=str_replace("{#formcity}","",$strout);
}

$strout=str_replace("{#formxiancheng}",formxiancheng(),$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#formkeyword}",$keyword,$strout);
$strout=str_replace("{#keyword}",cutstr($keyword,6),$strout);
$strout=str_replace("{#showkeyword}",showkeyword("zs",60,20,$keyword),$strout);
$strout=str_replace("{#showzsforsearch}",showzsforsearch(10,10,"id",$b,false,$keyword),$strout);
$strout=str_replace("{#showzsorder}",showzsorder(10,10,$keyword),$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
mysql_close($conn);
echo  $strout;
?>