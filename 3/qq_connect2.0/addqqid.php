<?php
ob_start();//打开缓冲区，可以setcookie
include("../../inc/conn.php");

$qqid=$_POST["qqid"];
if ($qqid==""){
$errmsg=$errmsg . "参数不足";
WriteErrMsg($errmsg);
}else{

$rs=mysql_query("select qqid from zzcms_user where qqid='".$qqid."'");
$row=mysql_num_rows($rs);
if (!$row){
$username=date("YmdHis").rand(100,999);
$password=md5(123456);
$passwordtrue=123456;
mysql_query("insert into zzcms_user (username,password,passwordtrue,qqid,img,totleRMB,regdate,lastlogintime) value 
('$username','$password','$passwordtrue','$qqid','/image/nopic.gif','".jf_reg."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
}
	
//直接登录
mysql_query("UPDATE zzcms_user SET showlogintime = lastlogintime where qqid='".$qqid."'");//更新上次登录时间
mysql_query("UPDATE zzcms_user SET showloginip = loginip where qqid='".$qqid."'");//更新上次登录IP
mysql_query("UPDATE zzcms_user SET logins = logins+1 where qqid='".$qqid."'");
mysql_query("UPDATE zzcms_user SET loginip = '".getip()."' where qqid='".$qqid."'");//更新最后登录IP
if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['lastlogintime'])>86400){
mysql_query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE qqid='".$qqid."'");//登录时加积分
}
mysql_query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE qqid='".$qqid."'");//更新最后登录时间

$rs=mysql_query("select username,password from zzcms_user where qqid='".$qqid."'");
$row=mysql_fetch_array($rs);
if ($CookieDate==1){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
}elseif($CookieDate==0){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
}
echo "<script>parent.location.href='/index.php'</script>";
}
?>