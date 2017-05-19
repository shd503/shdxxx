<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="content">
<div class="admintitle"><span>
<form name="form1" method="post" action="?">
        联系人姓名： 
              <input name="lxr" type="text" id="lxr2" value="<?php $lxr?>"> 
              <input type="submit" name="Submit" value="查找">
      </form>
</span>代理商留言</div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}
if (isset($_GET['page_size'])){
$page_size=$_GET['page_size'];
}else{
$page_size=pagesize_ht;  //每页多少条数据
}
$offset=($page-1)*$page_size;
$sql="select * from zzcms_dl where passed=1 and del=0 and saver='".$username."' ";
$rs = mysql_query($sql,$conn); 
$totlenum= mysql_num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

if (isset($_POST["lxr"])){ 
$lxr=trim($_POST["lxr"]);
}else{
$lxr="";
}

if ($lxr<>"") {
$sql=$sql."and name like '%".$lxr."%' ";
}
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = mysql_query($sql,$conn); 
$row= mysql_num_rows($rs);//返回记录数
if(!$row){
echo "暂无信息";
}else{
?>

<form action="" method="post" name="myform" id="myform">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td align="right" class="border"> 
        <select name="FileExt" id="FileExt">
          <option selected="selected" value="xls">选择下载文件类型</option>
          <option value="xls">excel表格文件</option>
          <option value="doc">word文件</option>
        </select>
        <select name="page_size" id="page_size" onchange="MM_jumpMenu('self',this,0)">
          <option value="?lxr=<?php echo $lxr ?>&page_size=10" <?php if ($page_size==10) { echo "selected";}?>>10条/页</option>
          <option value="?lxr=<?php echo $lxr ?>&page_size=20" <?php if ($page_size==20) { echo "selected";}?>>20条/页</option>
          <option value="?lxr=<?php echo $lxr ?>&page_size=50" <?php if ($page_size==50) { echo "selected";}?>>50条/页</option>
          <option value="?lxr=<?php echo $lxr ?>&page_size=100" <?php if ($page_size==100) { echo "selected";}?>>100条/页</option>
          <option value="?lxr=<?php echo $lxr ?>&page_size=200" <?php if ($page_size==200) { echo "selected";}?>>200条/页</option>
        </select>
        <input name="submit"  type="submit" class="buttons" value="删除" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()"  > 
        <input name="submit2"  type="submit" class="buttons"  value="打印" onClick="myform.action='dls_print.php';myform.target='_blank'"> 
        <input name="submit22"  type="submit" class="buttons"  value="下载" onClick="myform.action='dls_download.php';myform.target='_self'">
        <input name="pagename" type="hidden" id="page2" value="dls_message_manage.php?page=<?php echo $page ?>" /> 
              <input name="tablename" type="hidden" id="tablename" value="zzcms_dlly" /> 
              <label><input name="chkAll" type="checkbox" onclick="CheckAll(this.form)" value="checkbox" />全选</label></td>
    </tr>
  </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr> 
            <td width="20%" class="border">              联系人</td>
            <td width="20%" class="border">代理品种</td>
            <td width="20%" class="border">申请时间</td>
            <td width="10%" align="center" class="border">状态</td>
            <td width="10%" align="center" class="border">操作</td>
            <td width="10%" align="center" class="border">选取</td>
          </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
          <tr bgcolor="#FFFFFF" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td><?php echo $row["dlsname"]?></td>
            <td><?php echo $row["cp"]?></td>
            <td><?php echo $row["sendtime"]?></td>
            <td align="center"><?php if($row["looked"]==0) { echo "<span class='buttons'>未读</span>";}else{ echo "已读";}?></td>
            <td align="center"><a href="dls_show.php?id=<?php echo $row["id"]?>" target="_blank">查看联系方式</a></td>
            <td align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row["id"]?>" /></td>
          </tr>
          <?php
}
?>
        </table>
  </form>
<div class="border1">
<?php echo showpage()?>
</div>
<?php
}
?>
</div>
</div>
</div>
</div>
</body>
</html>