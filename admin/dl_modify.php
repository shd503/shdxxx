<?php
include ("admin.php");
checkadminisdo("dl");
$id=$_REQUEST["id"];
if ($id<>""){
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_dl where id='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.cp.value==""){
    alert("请填写您要求代理的产品名称！");
	document.myform.cp.focus();
	return false;
  }
  if (document.myform.content.value=="") {
    alert("请填写代理商介绍！");
	document.myform.content.focus();
	return false;
  }
    if (document.myform.truename.value==""){
    alert("请填写真实姓名！");
	document.myform.truename.focus();
	return false;
  }  
  if (document.myform.tel.value==""){
    alert("请填写代联系电话！");
	document.myform.tel.focus();
	return false;
  }
}
</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="admintitle"> 修改代理信息</div>
<form action="dl_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">             
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr> 
      <td align="right" class="border">产品 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="cp" type="text" id="cp" value="<?php echo $row["cp"]?>" size="45" maxlength="45">      </td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border">内容：</td>
      <td class="border"> <textarea name="content" cols="45" rows="6" id="content"><?php echo $row["content"]?></textarea> 
        <input name="dlid" type="hidden" id="dlid" value="<?php echo $row["id"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_REQUEST["page"]?>">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="truename" type="text" id="truename" value="<?php echo $row["dlsname"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">电话 <font color="#FF0000">*</font></td>
      <td class="border"><input name="tel" type="text" id="tel" value="<?php echo $row["tel"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">地址：</td>
      <td class="border"> <input name="address" type="text" id="address" value="<?php echo $row["address"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" value="<?php echo $row["email"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr>
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($row["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input name="Submit" type="submit" class="buttons" value="修 改"> 
        <input name="action" type="hidden" id="action3" value="modify"></td>
    </tr>
  </table>
</form>
</body>
</html>