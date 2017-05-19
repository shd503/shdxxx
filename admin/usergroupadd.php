<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
$FoundErr=0;
$ErrMsg="";
if ($action=="add") {
checkadminisdo("usergroup");
$groupname=trim($_POST["groupname"]);
$grouppic=trim($_POST["grouppic"]);
$groupid=trim($_POST["groupid"]);
$RMB=trim($_POST["RMB"]);

$config="";
if (isset($_POST['config'])){
foreach( $_POST['config'] as $i){$config .=$i."#";}
$config=substr($config,0,strlen($config)-1);//去除最后面的"#"
}
$looked_dls_number_oneday=trim($_POST["looked_dls_number_oneday"]);
	$sql="Select * From zzcms_usergroup Where groupid=".$groupid."";
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
			$FoundErr=1;
			$ErrMsg="<li>用户组ID“" . $groupid . "”已经存在！</li>";
		}
	
	if ($FoundErr==0){
		$sql="select * from zzcms_usergroup where groupname='" . $groupname . "'";
		$rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . "<li>“" . $groupname . "”已经存在！</li>";
		}else{	
		mysql_query("insert into zzcms_usergroup (
		groupname,grouppic,groupid,RMB,config,looked_dls_number_oneday
		)values(
		'$groupname','$grouppic','$groupid','$RMB','$config','$looked_dls_number_oneday'
		)");
		echo "<script>location.href='usergroupmanage.php'</script>";  
		}
	}
}
if ($FoundErr==1) {
	WriteErrMsg($ErrMsg);
}else{
?>
<script language="JavaScript" type="text/JavaScript">
function checkform(){
  if (document.form1.groupname.value==""){
    alert("用户组名称不能为空！");
    document.form1.groupname.focus();
    return false;
  }

//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.form1.groupid.value)) {
alert("用户组ID只能填数字！"); 
document.form1.groupid.focus(); 
return false; 
}

if(!strP.test(document.form1.RMB.value)) {
alert("所需费用只能填数字！"); 
document.form1.RMB.focus(); 
return false; 
}  


if(!strP.test(document.form1.looked_dls_number_oneday.value)) {
alert("每天查看代理商信息数需填写数字！"); 
document.form1.looked_dls_number_oneday.focus(); 
return false; 
} 
}

function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.Name != "chkAll"){
	e.checked = form.chkAll.checked;
	}   
	}
}
</script>
<div class="admintitle">添加用户组</div>
<form name="form1" method="post" action="?action=add" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="20%" align="right" class="border">用户组名称</td>
      <td width="80%" class="border"><input name="groupname" type="text" maxlength="30"></td>
    </tr>
    
	<tr>
      <td align="right" class="border">等级图片</td>
      <td class="border"><input name="grouppic" type="text" id="grouppic" maxlength="30"></td>
    </tr>
	
    <tr>
      <td align="right" class="border">用户组ID</td>
      <td class="border"><input name="groupid" type="text" id="groupid" maxlength="30">
        （填数字 ）</td>
    </tr>
	
    <tr>
      <td align="right" class="border">所需费用</td>
      <td class="border"><input name="RMB" type="text" id="RMB" maxlength="30">        (积分/年，填数字) </td>
    </tr>
	
    <tr>
      <td align="right" class="border">给权限<label for="chkAll"></label></td>
      <td class="border"><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
          <label for="chkAll">全选/取消全选</label>
          <br>
          <label for="checkbox">
          <input type="checkbox" name="config[]" value="look_dls_data" id="look_dls_data">
        </label>
        <label for="look_dls_data">查看代理商数据库联系方式</label>
          <input type="checkbox" name="config[]" value="look_dls_liuyan" id="look_dls_liuyan">
        <label for="look_dls_liuyan">查看代理商留言联系方式</label>
        <br>
          <input type="checkbox" name="config[]" value="dls_print" id="dls_print">
          <label for="dls_print">打印代理留言</label>
          <input type="checkbox" name="config[]" value="dls_download" id="dls_download">
          <label for="dls_download">下载代理留言</label>
          <input type="checkbox" name="config[]" value="set_text_adv" id="set_text_adv">
          <label for="set_text_adv">抢占广告位</label>
          <input type="checkbox" name="config[]" value="uploadflv" id="uploadflv">
          <label for="uploadflv">上传视频</label>
          <input type="checkbox" name="config[]" value="passed" id="passed">
          <label for="passed">信息免审</label></td>
    </tr>
	
    <tr>
      <td align="right"  class="border">每天查看代理商信息数</td>
      <td  class="border"><input name="looked_dls_number_oneday" type="text" id="looked_dls_number_oneday" maxlength="30">(填999为不限制)</td>
    </tr>
	
    <tr>
      <td  class="border">&nbsp;</td>
      <td  class="border"><input name="add" type="submit" value=" 添 加 "></td>
    </tr>
  </table>
</form>
<?php
}
mysql_close($conn);
?>