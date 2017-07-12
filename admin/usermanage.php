<?php
include("admin.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" src="/js/gg.js"></script>
</head>
<?php
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';

$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'username';

$px=isset($_GET["px"])?$_GET["px"]:'id';
$usersf=isset($_REQUEST["usersf"])?$_REQUEST["usersf"]:'';

if(checkadminhaspower("userreg") =="no") {
	echo "没有操作权限！页面不显示！";
	return;
}


if ($action=="pass"){
	checkadminisdo("userreg");
	if(!empty($_POST['id'])){
		for($i=0; $i<count($_POST['id']);$i++){
			$id=$_POST['id'][$i];
			$sql="select passed from zzcms_user where id ='$id'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			if ($row['passed']=='0'){
				mysql_query("update zzcms_user set passed=1 where id ='$id'");
			}else{
				mysql_query("update zzcms_user set passed=0 where id ='$id'");
			}
		}
	}else{
		echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
	}
	echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";
}
?>
<body>
<div class="admintitle">本站用户管理</div>
<form name="form1" method="post" action="?">
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td class="border"> <input name="kind" id="username" type="radio" value="username" <?php if ($kind=="username") { echo "checked";}?> >
				<label for="username">按用户名</label>
				<input name="kind" type="radio" value="comane" id="comane" checked <?php if ($kind=="comane") { echo "checked";}?>>
				<label for="comane">按公司名 </label>
				<input type="radio" name="kind" value="id" id="id" <?php if ($kind=="id") { echo "checked";}?>>
				<label for="id">按用户ID </label>
				<input type="radio" name="kind" value="email" id="email" <?php if ($kind=="email") { echo "checked";}?>>
				<label for="email">按E-mail</label>
				<input type="radio" name="kind" value="mobile" id="mobile"<?php if ($kind=="mobile") { echo "checked";}?>>
				<label for="mobile">按手机号</label>
				<input type="radio" name="kind" value="tel"  id="tel"<?php if ($kind=="tel") { echo "checked";}?>>
				<label for="tel">按电话号</label>
				<input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>" size="30" maxlength="255">
				<input type="submit" name="Submit2" value="查询">      </td>
		</tr>
		<tr>
			<td class="border">排序方式：<a href="?px=lastlogintime">按登录时间</a> | <a href="?px=logins">按登录次数</a>
				| <a href="?usersf=vip">VIP用户</a> | <a href="?usersf=lockuser">锁定的用户</a>
				| <a href="?usersf=elite">置顶的用户</a> </td>
		</tr>
	</table>
</form>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_user where id<>0  ";
$sql2='';
if ($shenhe=="no") {
	$sql2=$sql2." and passed=0 ";
}

if ($keyword<>"") {
	switch ($kind){
		case "username";
			$sql2=$sql2. " and username like '%".$keyword."%' ";
			break;
		case "id";
			$sql2=$sql2. " and id = '$keyword'";
			break;
		case "comane";
			$sql2=$sql2. " and comane like '%".$keyword."%'";
			break;
		case "email";
			$sql2=$sql2. " and email like '%".$keyword."%'";
			break;
		case "mobile";
			$sql2=$sql2. " and mobile like '%".$keyword."%'";
			break;
		case "tel";
			$sql2=$sql2. " and phone like '%".$keyword."%'";
			break;
		default:
			$sql2=$sql2. " and username like '%".$keyword."%'";
	}
}
switch ($usersf){
	case "vip";
		$sql2=$sql2." and groupid>1";
		break;
	case "lockuser";
		$sql2=$sql2. " and lockuser=1";
		break;
	case "elite";
		$sql2=$sql2. " and elite>0";
		break;
}
$rs = mysql_query($sql.$sql2);
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_user where id<>0 ";
$sql=$sql .$sql2;
$sql=$sql . " order by ".$px." desc limit $offset,$page_size";
$rs = mysql_query($sql);
if(!$totlenum){
	echo "暂无信息";
}else{
	?>
	<form name="myform" method="post" action="">
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
			<tr>
				<td>
					<input name="submit"  type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
					<input name="submit3" type="submit" onClick="deluser(this.form)"value="删除选中的信息">
					<input name="pageurl" type="hidden"  value="usermanage.php?kind=<?php echo $kind?>&keyword=<?php echo $keyword?>&shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>">      </td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="2" cellspacing="1">
			<tr class="title">
				<td width="2%" align="center" class="border">  <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
				<td width="8%" align="center" class="border">用户名</td>
				<td width="10%" align="center" class="border">公司名称</td>
				<td width="3%" align="center" class="border">用户组ID</td>
				<td width="3%" align="center" class="border">登录次数</td>
				<td width="6%" align="center" class="border">最后登录IP</td>
				<td width="4%" align="center" class="border">最后登录</td>
				<td width="4%" align="center" class="border">注册时间</td>
				<td width="3%" align="center" class="border">初始支付</td>
				<td width="2%" align="center" class="border">积分</td>
				<td width="5%" align="center" class="border">邮箱</td>
				<td width="3%" align="center" class="border">状态</td>
				<td width="5%" align="center" class="border">操作</td>
			</tr>
			<?php
			while($row = mysql_fetch_array($rs)){
				?>
				<tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'">
					<td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id2" value="<?php echo $row["id"]?>">
						<a name="<?php echo $row["id"]?>"></a></td>
					<td align="left">
						<?php
						echo str_replace($keyword,"<font color=red>".$keyword."</font>",$row["username"]);
						$rsn=mysql_query("select config from zzcms_admingroup where id=(select groupid from zzcms_admin where pass='".@$_SESSION["pass"]."' and admin='".@$_SESSION["admin"]."')");//只验证密码会出现，两个管理员密码相同的情况，导致出错,前加@防止SESSION失效后出错提示
						$rown=mysql_fetch_array($rsn);
						echo "<br>密码：";
						if(str_is_inarr($rown["config"],'userreg')=='no'){
							echo "无【用户管理】权限，密码不于显示";
						}else{
							if ($row["passwordtrue"]!=''){ echo $row["passwordtrue"];}else{ echo $row["password"];}
						}
						?>
					</td>
					<td>
						<?php if ($row["comane"]<>"") {
							echo  str_replace($keyword,"<font color=red>".$keyword."</font>",$row["comane"]);
						}else{
							echo  "个人用户";
						}
						?>
					</td>
					<td align="center"> <?php echo $row["groupid"]?> </td>
					<td align="center"><?php echo $row["logins"]?></td>
					<td align="center"><?php echo $row["loginip"]?></td>
					<td align="center" title="<?php echo $row["lastlogintime"]?>"><?php echo date("Y-m-d",strtotime($row["lastlogintime"]))?></td>
					<td align="center" title="<?php echo $row["regdate"]?>"><?php echo date("Y-m-d",strtotime($row["regdate"]))?></td>
					<td align="center"><?php echo $row["initRMB"]?></td>
					<td align="center"><?php echo $row["totleRMB"]?></td>
					<td align="center"><?php echo $row["email"]?></td>
					<td align="center">
						<?php
						if ($row["lockuser"]==1) {
							echo  "<font color=red>已锁定</font><br>";
						}else{
							echo  "";
						}

						if ($row["passed"]==1) {
							echo  "已审核";
						}else{
							echo  "<font color=red>未审核</font>";
						}

						if ($row["elite"]>0) {
							echo "<br>已置顶（".$row["elite"]."）";
						}
						?>
					</td>
					<td align="center" class="docolor"><a href="usermodify.php?id=<?php echo $row["id"]?>">修改</a> |

						<?php if ($row["lockuser"]==0) { ?>
							<a href="userlock.php?action=lock&id=<?php echo $row["id"]?>&page=<?php echo $page?>">锁定</a>
							<?php
						}else{
							?>
							<a href="userlock.php?action=cancellock&id=<?php echo $row["id"]?>&page=<?php echo $page?>">解锁</a>
							<?php
						}
						?>
						| <a href="sendmail.php?tomail=<?php echo $row["email"]?>">发信</a>
					</td>
				</tr>
				<?php
			}
			?>
		</table>

		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
			<tr>
				<td><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
					<label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label>
					<input name="submit2"  type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
					<input name="submit4" type="submit" onClick="deluser(this.form)"value="删除选中的信息">
					<input name="page" type="hidden" id="page" value="<?php echo $page?>"> </td>
			</tr>
		</table>
	</form>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
		<tr>
			<td height="30" align="center">	页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong>
				<strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
				<?php

				if ($page<>1) {
					echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=1'>首页</a>】 ";
					echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】 ";
				}else{
					echo "【首页】【上一页】";
				}
				if ($page<>$totlepage) {
					echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】 ";
					echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】 ";
				}else{
					echo "【下一页】【尾页】";
				}
				?>
			</td>
		</tr>
	</table>
	<?php
}
mysql_close($conn);
?>
</body>
</html>