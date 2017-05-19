<?php
include("admin.php");


checkadminisdo("userclass");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig()
{
   if(confirm("确定要删除此关键词吗？"))
     return true;
   else
     return false;	 
}
function CheckForm()
{  
if (document.form1.bigclassname.value=="")
  {
    alert("名称不能为空！");
	document.form1.bigclassname.focus();
	return false;
  }
}
</script>
</head>
<body>
<?php
if (isset($_REQUEST['dowhat'])){
$dowhat=$_REQUEST['dowhat'];
}else{
$dowhat="";
}
switch ($dowhat){
case "addtag";
addtag();
break;
case "modifytag";
modifytag();
break;
default;
showtag();
}
function showtag(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if ($action=="px") {
$sql="Select * From zzcms_userkind";
$rs=mysql_query($sql);
while ($row=mysql_fetch_array($rs)){
$xuhao=$_POST["xuhao".$row["bigclassid"].""];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhao) == "" || is_numeric($xuhao) == false) {
	       $xuhao = 0;
	   }elseif ($xuhao < 0){
	       $xuhao = 0;
	   }else{
	       $xuhao = $xuhao;
	   }
mysql_query("update zzcms_userkind set xuhao='$xuhao' where bigclassid=".$row['bigclassid']."");
}
}
if ($action=="del"){
checkadminisdo("siteconfig");
$bigclassid=trim($_REQUEST["bigclassid"]);
if ($bigclassid<>""){
	$sql="delete from zzcms_userkind where bigclassid=" .$bigclassid. " ";
	mysql_query($sql);
}    
echo "<script>location.href='?'</script>";
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">用户所属行业类别管理</td>
  </tr>
</table>
 
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="center" class="border">
      <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='?dowhat=addtag'" value="添加">
      </td>
  </tr>
</table>
	<?php
	$sql="Select * From zzcms_userkind order by xuhao asc";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if (!$row){
	echo "暂无信息";
	}else{
?>
      <form name="form1" method="post" action="?action=px">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="1" >
    <tr> 
      <td width="265" height="25" align="center" class="border">关键词</td>
      <td width="237" align="center" class="border">排序</td>
      <td width="170" height="25" align="center" class="border">操作选项</td>
    </tr>
    <?php
	while ($row=mysql_fetch_array($rs)){
?>
    <tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
      <td width="265" height="22" align="center"><?php echo $row["bigclassname"]?><a name="B<?php echo $row["bigclassid"]?>"></a></td>
      <td width="237" height="22" align="center"><input name="<?php echo "xuhao".$row["bigclassid"]?>" type="text" id="<?php echo "xuhao".$row["bigclassid"]?>" value="<?php echo $row["xuhao"]?>" size="4" maxlength="4"> 
        <input type="submit" name="Submit" value="更新序号"></td>
      <td align="center" class="docolor"> <a href="?dowhat=modifytag&bigclassid=<?php echo $row["bigclassid"]?>">修改名称</a> 
        | <a href="?action=del&bigclassid=<?php echo $row["bigclassid"]?>" onClick="return ConfirmDelBig();">删除</a></td>
    </tr>
    <?php
	}
	?>
  </table>
	  </form>
<?php
}
}

function addtag(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_POST['bigclassname'])){
$bigclassname=trim($_POST['bigclassname']);
}else{
$bigclassname="";
}

if ($action=="add"){
		$sql="select * from zzcms_userkind where bigclassname='" . $bigclassname . "'";
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row) {
			$FoundErr=1;
			$ErrMsg="<li>问题“" . $bigclassname . "”已经存在！</li>";
			WriteErrMsg($ErrMsg);
		}else{
		mysql_query("insert into zzcms_userkind (bigclassname)VALUES('$bigclassname') ");	
    	echo "<script>location.href='?'</script>";
		}
}else{	
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">添加用户所属行业类别</td>
  </tr>
</table>
<form name="form1" method="post" action="?dowhat=addtag" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td width="30%" align="right"> 类别名称：</td>
      <td width="70%"> <input name="bigclassname" type="text" size="50" maxlength="50"> 
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <input name="action" type="hidden" id="action" value="add"> <input name="add" type="submit" value=" 添加 "> 
      </td>
    </tr>
  </table>
</form>
<?php
}
}

function modifytag(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_REQUEST['bigclassid'])){
$bigclassid=$_REQUEST['bigclassid'];
}else{
$bigclassid="";
}
if (isset($_POST['bigclassname'])){
$bigclassname=trim($_POST['bigclassname']);
}else{
$bigclassname="";
}

if ($bigclassid==""){
mysql_close($conn);
echo "<script>location.href='?'</script>";
}

if ($action=="modify"){
	$sql="Select * from zzcms_userkind where bigclassid=" . $bigclassid."";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if (!$row){
		$FoundErr==1;
		$ErrMsg="<li>此问题不存在！</li>";
		WriteErrMsg($ErrMsg);
	}else{
	mysql_query("update zzcms_userkind set bigclassname='$bigclassname' where bigclassid=". $bigclassid." ");
	}	
	echo "<script>location.href='?#B".$bigclassid."'</script>";
}else{
$sql="Select * from zzcms_userkind where bigclassid=".$bigclassid."";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">修改用户所属行业类别</td>
  </tr>
</table>
<form name="form1" method="post" action="?dowhat=modifytag" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td width="30%" align="right">类别名称：</td>
      <td width="70%"> <input name="bigclassname" type="text" id="bigclassname" value="<?php echo $row["bigclassname"]?>" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="bigclassid" type="hidden" id="bigclassid" value="<?php echo $row["bigclassid"]?>"> 
        <input name="action" type="hidden" id="action" value="modify"> <input name="save" type="submit" id="save" value=" 修改 "> 
      </td>
    </tr>
  </table>
</form>
<?php
}
}
?>
</body>
</html>
<?php
mysql_close($conn);
?>