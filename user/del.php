<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>
<body>
<?php
include("../inc/conn.php");
include("check.php");
$pagename=trim($_POST["pagename"]);
$tablename=trim($_POST["tablename"]);
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if (!isset($id) || $id==""){
showmsg('操作失败！至少要选中一条信息。');
}

switch ($tablename){
case "zzcms_main";
if (strpos($id,",")>0){
		$sql="select img,flv,editor from zzcms_main where id in (".$id.")";
	}else{
		$sql="select img,flv,editor from zzcms_main where id ='$id'";
	}
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while ($row=mysql_fetch_array($rs)){
	if ($row["editor"]<>$username){
	markit();
	mysql_close($conn);
	showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
	}
	if ($row['img']<>"/image/nopic.gif"){
			$f="../".substr($row['img'],1);
			if (file_exists($f)){
			unlink($f);
			}
			$fs="../".substr(str_replace(".","_small.",$row['img']),1)."";
			if (file_exists($fs)){
			unlink($fs);		
			}
	}

	if ($row['flv']<>''){//flv里没有设默认值
			$f="../".substr($row['flv'],1);
			if (file_exists($f)){
			unlink($f);
			}
	}
}
}
break;
case "zzcms_licence";
if (strpos($id,",")>0){
		$sql="select img,editor from zzcms_licence where id in (".$id.")";
	}else{
		$sql="select img,editor from zzcms_licence where id ='$id'";
	}
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while ($row=mysql_fetch_array($rs)){
	if ($row["editor"]<>$username){
	markit();
	mysql_close($conn);
	showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
	}
	if ($row['img']<>"/image/nopic.gif"){
			$f="../".substr($row['img'],1);
			if (file_exists($f)){
			unlink($f);
			}
			$fs="../".substr(str_replace(".","_small.",$row['img']),1)."";
			if (file_exists($fs)){
			unlink($fs);		
			}
	}
}
}
break;
}

if ($tablename=='zzcms_dlly'){
if (strpos($id,",")>0){	
	$sql="select id,saver from zzcms_dl where id in (".$id.")";
}else{	
	$sql="select id,saver from zzcms_dl where id ='$id'";
}
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while ($row=mysql_fetch_array($rs)){	
	if ($row["saver"]<>$username){
	markit();
	mysql_close($conn);
	showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
	}
	mysql_query("delete from zzcms_dl where id =".$row['id']."");		
}
mysql_close($conn);
echo "<script>location.href='".$pagename."';</script>";
}

}else{
if (strpos($id,",")>0){	
	$sql="select id,editor from ".$tablename." where id in (". $id .")";
}else{	
	$sql="select id,editor from ".$tablename." where id ='$id'";
}
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while ($row=mysql_fetch_array($rs)){	
	if ($row["editor"]<>$username){
	markit();
	mysql_close($conn);
	showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
	}
	mysql_query("delete from ".$tablename." where id =".$row['id']."");	
}
mysql_close($conn);
echo "<script>location.href='".$pagename."';</script>";
}

}
?>
</body>
</html>