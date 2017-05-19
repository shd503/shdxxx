<?php
include("admin.php");
include("../inc/fy.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
checkadminisdo("dl");

$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';
$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';
$showwhat=isset($_REQUEST["showwhat"])?$_REQUEST["showwhat"]:'';

$isread=isset($_REQUEST["isread"])?$_REQUEST["isread"]:'';

if ($action=="pass"){
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	$sql="select passed from zzcms_dl where id ='$id'";
	$rs = mysql_query($sql); 
	$row = mysql_fetch_array($rs);
		if ($row['passed']=='0'){
		mysql_query("update zzcms_dl set passed=1 where id ='$id'");
		}else{
		mysql_query("update zzcms_dl set passed=0 where id ='$id'");
		}
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";	
}
?>
</head>
<body>
<div class="admintitle">代理商信息库管理</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr> 
    <td  align="right"> 
      <form name="form1" method="post" action="?">
	   <label> <input type="radio" name="kind" value="cpmc" <?php if ($kind=="cpmc") { echo "checked";}?>>
        按产品名称</label> 
       <label> <input name="kind" type="radio" value="tel" <?php if ($kind=="tel") { echo "checked";}?> >
        按电话 </label>
        <label><input type="radio" name="kind" value="editor" <?php if ($kind=="editor") { echo "checked";}?>>
        按发布人 </label>
       <label> <input type="radio" name="kind" value="saver" <?php if ($kind=="saver") { echo "checked";}?>>
        按接收人</label> 
        <input name="keyword" type="text" id="keyword2" value="<?php echo $keyword?>"> 
        <input type="submit" name="Submit" value="查找">
        <a href="?isread=no">未查看的</a> 
      </form>
		</td>
    </tr>
  </table>
 
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_dl where id<>0  ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($isread=="no") {
$sql2=$sql2." and saver<>'' and looked=0";
}
if ($keyword<>"") {
	switch ($kind){
	case "editor";
	$sql2=$sql2. " and editor like '%".$keyword."%' ";
	break;
	case "cpmc";
	$sql2=$sql2. " and cp like '%".$keyword."%'";
	break;
	case "saver";
	$sql2=$sql2. " and saver like '%".$keyword."%'";
	break;
	case "tel";
	$sql2=$sql2. " and tel like '%".$keyword."%'";
	break;		
	default:
	$sql2=$sql2. " and cp like '%".$keyword."%'";
	}
}
$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_dl where id<>0 ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input type="submit"  onClick="myform.action='?action=pass';myform.target='_self'" value="【取消/审核】选中的信息">
        <input name="submit" type="submit" onClick="myform.action='dl_sendmail.php';myform.target='_blank' "  value="给接收者发邮件提醒">
        <input name="submit23" type="submit" onClick="myform.action='dl_sendsms.php';myform.target='_blank' "  value="给接收者发手机短信提醒"> 
        <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="pagename" type="hidden"  value="dl_manage.php?b=<?php echo $b?>&shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_dl"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="10%" class="border">代理品种</td>
      <td width="10%" class="border">联系人</td>
      <td width="10%" class="border">电话</td>
      <td width="5%" align="center" class="border">接收者</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="5%" align="center" class="border">信息状态</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
    <?php
while($row = mysql_fetch_array($rs)){
?>
    <tr bgcolor="#FFFFFF" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center"> <input name="id[]" type="checkbox"  value="<?php echo $row["id"]?>"></td>
      <td><a href="<?php echo getpageurlzs($row["saver"])?>" target="_blank"><?php echo $row["cp"] ?></a></td>
      <td><?php echo $row["dlsname"]?></td>
      <td><?php echo $row["tel"]?></td>
      <td align="center"> 
        <?php if ($row["saver"]<>"") { echo"<a href='usermanage.php?keyword=".$row["saver"]."' target='_blank'>".$row["saver"]."</a>";}else{ echo"无";}?>      </td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center"> 
        <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?>
        <br> 
        <?php
	if ($row["saver"]<>"") {
		if ($row["looked"]==0) { 
		echo"<font color='red'>未查看</font><br>" ;
		}else{
		echo "已查看" ;
		}
	}
		?>
      </td>
      <td align="center" class="docolor"> <a href="dl_modify.php?id=<?php echo $row["id"]?>&page=<?php echo $page ?>">修改</a>      </td>
    </tr>
    <?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
        <input type="submit"  onClick="myform.action='?action=pass';myform.target='_self'" value="【取消/审核】选中的信息">
        <input name="submit2" type="submit" onClick="myform.action='dl_sendmail.php';myform.target='_blank' "  value="给接收者发邮件提醒">
        <input name="submit232" type="submit" onClick="myform.action='dl_sendsms.php';myform.target='_blank' "  value="给接收者发手机短信提醒"> 
        <input name="submit3" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
      </td>
    </tr>
  </table>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}
mysql_close($conn);
?>
</body>
</html>