<?php
include("../inc/conn.php");
include("check.php");
$title=trim($_POST["title"]);	
$img=trim($_POST["img"]);
if ($_GET["action"]=="add"){
mysql_query("Insert into zzcms_licence(title,img,editor,sendtime) values('$title','$img','$username','".date('Y-m-d H:i:s')."')") ; 
}elseif ($_GET["action"]=="modify"){
$oldimg=trim($_POST["oldimg"]);
	$id=$_POST["id"];
	if ($id=="" || is_numeric($id)==false){
		$FoundErr=1;
		$ErrMsg="<li>参数不足！</li>";
		WriteErrMsg($ErrMsg);
	}else{
	mysql_query("update zzcms_licence set title='$title',img='$img',sendtime='".date('Y-m-d H:i:s')."',passed=0 where id='$id'");
		if ($oldimg<>$img && $oldimg<>"/image/nopic.gif"){
			$f="../".$oldimg;
			if (file_exists($f)){
			unlink($f);
			}
			$fs="../".str_replace(".","_small.",$oldimg)."";
			if (file_exists($fs)){
			unlink($fs);		
			}
		}		
	}
}
mysql_close($conn);
echo "<script>location.href='licence.php'</script>";
?>