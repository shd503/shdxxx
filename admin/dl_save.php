<?php
include ("admin.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("dl");
if (isset($_POST["page"])){
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["dlid"])){
$dlid=$_POST["dlid"];
}else{
$dlid=0;
}

$cp=$_POST["cp"];
$content=$_POST["content"];
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];
if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}
if ($_POST["action"]=="add"){
if ($cp<>'' && $truename<>'' && $tel<>''){
$addok=mysql_query("Insert into zzcms_dl(cp,content,dlsname,tel,address,email,sendtime) values('$cp','$content','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."')") ;  
}
}elseif ($_POST["action"]=="modify"){
$addok=mysql_query("update zzcms_dl set cp='$cp',content='$content',dlsname='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."',passed='$passed' where id='$dlid'");
}
if ($addok){
echo "<script>location.href='dl_manage.php?page=".$_REQUEST["page"]."'</script>";
}		
?>
</body>
</html>