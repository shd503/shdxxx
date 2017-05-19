<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<?php
//有用，因编码必须为gb2312所以，把此页单出来了，在dl_liuyan_save.php中有调用
include("../../inc/config.php");
include ("inc.php");
	$mobile=$_GET['mobile'];
	$msg=$_GET['msg'];
	$tourl=$_GET['tourl'];
	
	$result = sendSMS(smsusername,smsuserpass,$mobile,$msg,apikey_mobile_msg);
	//echo $result."<br>";	
echo "<script>alert('ok');location.href='$tourl'</script>";
?>