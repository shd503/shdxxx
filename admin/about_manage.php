<?php
include("admin.php");

//checkadminisdo("bottomlink");
if(checkadminhaspower("bottomlink") =="no") {
  echo "没有操作权限！页面不显示！";
  return;
}

if (isset($_REQUEST["action"])){
  $action=$_REQUEST["action"];
}else{
  $action="";
}
if (isset($_REQUEST["id"])){
  $id=$_REQUEST["id"];
}else{
  $id="";
}
if ($action=="del")
{
  if ($id<>"" ){
    mysql_query("delete from zzcms_about where id='$id'") ;
  }
  echo "<script>location.href='about_manage.php'</script>";
}
?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="style.css" rel="stylesheet" type="text/css">
  <body>
  <script language="JavaScript" type="text/JavaScript">

    function ConfirmDelBig()
    {
      if(confirm("确定要删除此栏目吗？"))
        return true;
      else
        return false;
    }
  </script>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="admintitle">网站底部链接管理</td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center" class="border"><a href="about.php?action=add">添加网站底部链接</a></td>
    </tr>
  </table>
<?php
$sql="Select * From zzcms_about";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
  echo "暂无信息";
}else{
  ?>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr class="title">
      <td width="118" height="25" align="center" class="border">ID</td>
      <td width="119" align="center" class="border">公司信息名称</td>
      <td width="499" align="center" class="border">链接地址</td>
      <td width="260" height="20" align="center" class="border">操作选项</td>
    </tr>
    <?php
    while($row = mysql_fetch_array($rs)){
      ?>
      <tr bgcolor="#FFFFFF" class="tdbg">
        <td width="118" height="22" align="center" bgcolor="#FFFFFF"><?php echo $row["id"]?></td>
        <td width="119" height="22" align="center" bgcolor="#FFFFFF"><?php echo $row["title"]?></td>
        <td width="499" height="22" align="center" bgcolor="#FFFFFF"><?php echo $row["link"]?></td>
        <td align="center" class="docolor"> <a href="about.php?action=modify&id=<?php echo $row["id"]?>">修改</a>
          | <a href="about_manage.php?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDelBig();">删除</a></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
}
mysql_close($conn);
?>