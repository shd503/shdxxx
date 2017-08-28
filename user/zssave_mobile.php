<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title></title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<?php
include("../inc/conn.php");
include("check.php");
$cpid=trim($_POST["cpid"]);
$bigclassid=@trim($_POST["bigclassid"]);
$smallclassid=@trim($_POST["smallclassid"]);
$cp_name=$_POST["name"];
$gnzz=$_POST["gnzz"];
$sm=str_replace("'","",stripfxg(trim($_POST["sm"])));
$img=$_POST["img"];
if ($img==''){
	$img='/image/nopic.gif';
}
$img2=$_POST["img2"];
$bodybgrepeat=$_POST["bodybgrepeat"];
$swf=@$_POST["swf"];
$flv=@$_POST["flv"];
$province=trim($_POST["province"]);
$city=trim($_POST["city"]);
$xiancheng=trim($_POST["xiancheng"]);
$address=trim($_POST["address"]);
$jiameng=trim($_POST["jiameng"]);
$tz=$_POST["tz"];
$shuxing_value="";
if(!empty($_POST['sx'])){
	for($i=0; $i<count($_POST['sx']);$i++){
		$shuxing_value=$shuxing_value.($_POST['sx'][$i].'|||');
	}
	$shuxing_value=substr($shuxing_value,0,strlen($shuxing_value)-3);//去除最后面的"|||"
}
$title=$_POST["title"];
if ($title==""){$title=$cp_name;}
$keyword=$_POST["keyword"];
if ($keyword==""){$keyword=$cp_name;}

$discription=$_POST["discription"];
if ($discription==""){$discription=$cp_name;}

$rs=mysql_query("select groupid,qq,phone,mobile,comane,id,renzheng from zzcms_user where username='".$username."'");
$row=mysql_fetch_array($rs);
$qq=$row["qq"];
$phone=$row["phone"];
$mobile=$row["mobile"];
$comane=$row["comane"];
$renzheng=$row["renzheng"];
$userid=$row["id"];
$oldimg=trim($_POST["oldimg"]);
$oldimg2=trim($_POST["oldimg2"]);
$oldflv=trim($_POST["oldflv"]);

$rs=mysql_query("SELECT id FROM zzcms_main where editor ='".$username."'");//长内容无法保存的情况，可以不用SM字段入库，会直接存到Web文件中，但文件清理功能不要用，否则会删除上传的图片
$row=mysql_num_rows($rs);
if (!$row){
	$isok=mysql_query("insert into zzcms_main (proname,bigclasszm,smallclasszm,prouse,jiameng,tz,shuxing_value,sm,img,bodybg,bodybgrepeat,swf,flv,province,city,xiancheng,address,title,keywords,description,sendtime,
userid,comane,renzheng,qq,phone,mobile,passed,editor
)values(
'$cp_name','$bigclassid','$smallclassid','$gnzz','$jiameng','$tz','$shuxing_value','$sm','$img','$img2','$bodybgrepeat','$swf','$flv','$province','$city','$xiancheng','$address','$title','$keyword','$discription','".date('Y-m-d H:i:s')."',
'$userid','$comane','$renzheng','$qq','$phone','$mobile',0,'".$username."')");
}else{
	$isok=mysql_query("update zzcms_main set proname='$cp_name',bigclasszm='$bigclassid',smallclasszm='$smallclassid',prouse='$gnzz',jiameng='$jiameng',tz='$tz',shuxing_value='$shuxing_value',sm='$sm',img='$img',bodybg='$img2',bodybgrepeat='$bodybgrepeat',swf='$swf',flv='$flv',province='$province',city='$city',xiancheng='$xiancheng',address='$address',title='$title',keywords='$keyword',description='$discription',sendtime='".date('Y-m-d H:i:s')."',userid='$userid',comane='$comane',renzheng='$renzheng',qq='$qq',phone='$phone',mobile='$mobile',passed=0 where id='$cpid'");
}

if ($oldimg<>$img && $oldimg<>"image/nopic.gif") {
	//deloldimg
	$f=$oldimg;
	if (file_exists($f)){
		unlink($f);
	}
	$fs=str_replace(".","_small.",$oldimg);
	if (file_exists($fs)){
		unlink($fs);
	}
}
if ($oldimg2<>$img2 && $oldimg2<>"image/nopic.gif") {
	//deloldimg
	$f=$oldimg2;
	if (file_exists($f)){
		unlink($f);
	}
	$fs=str_replace(".","_small.",$oldimg2);
	if (file_exists($fs)){
		unlink($fs);
	}
}
if ($oldflv<>$flv && $oldflv<>"image/nopic.gif"){
	//deloldflv
	$f="../".$oldflv;
	if (file_exists($f)){
		unlink($f);
	}
}

passed('zzcms_main');
$fdir="../web/".$username;
//创建文件目录
if (!file_exists($fdir)) {
	mkdir($fdir);
}
$fp=$fdir."/index.htm";
$f=fopen($fp,"w+");
fwrite($f,$sm);
fclose($f);
if ($isok){
	showmsg('修改完成','zs_mobile.php');
}else{
	showmsg('失败');
}
?>
</body>
</html>