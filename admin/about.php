<?php
include("admin.php");
if(checkadminhaspower("bottomlink") =="no") {
    echo "没有操作权限！页面不显示！";
    return;
}
checkadminisdo("bottomlink");
$go=0;
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if ($action=="savedata" ){
	$saveas=trim($_REQUEST["saveas"]);
	$title=trim($_REQUEST["title"]);
	$content=trim($_REQUEST["info_content"]);
	$link=trim($_REQUEST["link"]);
	if ($saveas=="add"){
	mysql_query("insert into zzcms_about (title,content)VALUES('$title','$content') ");
	$go=1;
	//echo "<script>location.href='about_manage.php'<//script>";	
	}elseif ($saveas=="modify"){
	mysql_query("update zzcms_about set title='$title',content='$content',link='$link' where id=". $_POST['id']." ");
	$go=1;
	//echo "<script>location.href='about_manage.php'<//script>";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language="JavaScript">
function CheckForm()
{
if (document.myform.title.value=="")
  {
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  }
} 
</script>
</head>
<body>
<?php 
if ($action=="add") {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="admintitle">添加公司信息</td>
  </tr>
</table>
<form action="?action=savedata&saveas=add" method="POST" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="23%" align="right" class="border">名称</td>
      <td width="77%" class="border"><input name="title" type="text" id="title"></td>
    </tr>
    <tr> 
      <td align="right" class="border">内容</td>
      <td class="border"> <textarea name="info_content" id="info_content" ></textarea> 
       	<script type="text/javascript">CKEDITOR.replace('info_content');	</script>
      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><input name="link" type="hidden" id="link3" value=""></td>
      <td class="border"> 
        <input type="submit" name="Submit" value="提 交" ></td>
    </tr>
</table>
 </form>
<?php
}
if ($action=="modify") {
$sql="select * from zzcms_about where id=".$_REQUEST["id"]."";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="admintitle">修改公司信息</td>
  </tr>
</table>
  
<form action="?action=savedata&saveas=modify" method="POST" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="23%" align="right" class="border">名称</td>
      <td width="77%" class="border"><input name="title" type="text" id="title" value="<?php echo $row["title"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">内容</td>
      <td class="border"> <textarea name="info_content" id="info_content" ><?php echo $row["content"]?></textarea> 
	  	<script type="text/javascript">CKEDITOR.replace('info_content');	</script>
        </td>
    </tr>
    <tr> 
      <td align="right" class="border">链接地址：</td>
      <td class="border"><input name="link" type="text" id="link" value="<?php if ($row["link"]<>"") { echo $row["link"]; }else{ echo "/one/siteinfo.php?id=".$row["id"]."";}?>"> </td>
    </tr>
    <tr>
      <td align="right" class="border"><input name="id" type="hidden" id="id2" value="<?php echo $row["id"]?>"></td>
      <td class="border">
<input type="submit" name="Submit2" value="提 交"></td>
    </tr>
</table>
  </form>
<?php
}
if ($go==1){
echo "<script>location.href='about_manage.php'</script>";
}
?>
</body>
</html>