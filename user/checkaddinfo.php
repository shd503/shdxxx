<?php
$ErrMsg="";
$FoundErr=0;
$rs=mysql_query("select passed,username from zzcms_user where username='".$_COOKIE["UserName"]."' ");
$row=mysql_fetch_array($rs);
if ($row["passed"]==0 && isaddinfo=="No") {		
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>注册用户经审核后才可发布信息</li>";
}
if ($FoundErr==1){
WriteErrMsg($ErrMsg);
mysql_close($conn);
exit;
}
?>