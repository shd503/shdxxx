<?php
include("../inc/conn.php");
include("check.php");
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>首页文字广告设置</title>
		<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
	</head>
<body>
<?php
if (qiangad=="No"){
	mysql_close($conn);
	echo "系统关闭了此功能";
	exit;
}

$rs=mysql_query("select * from zzcms_ad");
$row=mysql_num_rows($rs);
if ($row){
	while($row = mysql_fetch_array($rs)){
		if (time()-strtotime($row['sendtime'])>24*3600*showadvdate and $row['elite']==0){
			mysql_query("Update zzcms_ad set username='' where id=".$row['id']."");
		}
	}
}

if (isset($_REQUEST["action"])){
	$action=$_REQUEST["action"];
}else{
	$action="";
}

function setAdv($ispay){
	$rs=mysql_query("select * from zzcms_main where editor='".$_COOKIE["UserName"]."'");
	$row=mysql_num_rows($rs);
	if (!$row){
		$a=0;
	}else{
		$a=1;
	}

	if ($a==0){
		echo "<script>alert('您尚未发布信息，不能抢占广告位！请先发布招商信息。');";
		echo "location.replace('zs.php')</script>";
	}else{
		$rs=mysql_query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
		$row=mysql_num_rows($rs);
		if (!$row){
			echo "<script>alert('您目前没有设置文字广告信息，请先设置广告语。');";
			echo "location.replace('adv.php')</script>";
		}else{
			$rs=mysql_query("select * from zzcms_ad where username='".$_COOKIE["UserName"]."' or nextuser='".$_COOKIE["UserName"]."'");
			$row=mysql_num_rows($rs);
			if ($row){
				echo "<script>alert('您已有了一个广告位置，不能再参与抢占。');";
				echo "history.back(-1);</script>";
			}else{
				$rs=mysql_query("select * from zzcms_ad where id=".$_POST["id"]."");//'使用From 传值为防止通过地址栏直接提交数值，造成非法抢占。
				$row=mysql_fetch_array($rs);
				if ($row["nextuser"]<>""){//当几个用户点击同一个抢占按纽时(即抢占同一样位置)，这里就会有最先抢得的那个用户名
					echo "<script>alert('抢占失败，此位置被".$row["nextuser"]."先一步抢得');";
					echo "location.replace('adv2.php')</script>";
				}else{
					if ($ispay==1){//当用户组没有权限参占时，扣费
						$rsn=mysql_query("select totleRMB from zzcms_user where username='".$_COOKIE["UserName"]."'");
						$rown=mysql_fetch_array($rsn);

						if ($rown["totleRMB"]>=jf_set_adv){
							mysql_query("update zzcms_user set totleRMB=totleRMB-".jf_set_adv." where username='".$_COOKIE["UserName"]."'");//'扣除积分
							mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".@$_COOKIE['UserName']."','抢占广告位','-".jf_set_adv."','-".jf_set_adv."','".date('Y-m-d H:i:s')."')");
							echo "<script>alert('消费金币".jf_set_adv."个')</script>";
						}else{
							showmsg("您的金币不足".jf_set_adv."无法抢占");
						}
					}
					mysql_query("update zzcms_ad set nextuser='".$_COOKIE["UserName"]."' where id=".$_POST["id"]."");
					//在表中记录抢占人以备下面显示用，另一作用就是以此为标记，此位置未被审核之前，不再让此用户抢占其它广告位，审核后通过后，这里的值会被清空
					mysql_query("update zzcms_textadv set newsid='".$_POST["id"]."',passed=0 where username='".$_COOKIE["UserName"]."'"); //把占得的ID值写入到表textadv中
					//passed=0只要抢占位置了，不管以前审核是否通过，现在要重审，重审的目的是执行表中内容的复制由textadv至news
					$rs=mysql_query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
					$row=mysql_fetch_array($rs);
					if (time()-strtotime($row['gxsj'])>24*3600*showadvdate ){
						mysql_query("update zzcms_textadv set gxsj='".date('Y-m-d H:i:s')."' where username='".$_COOKIE["UserName"]."'");
					}//如果上次修改广告词的时间至今天已大于广告显示期，那么就更新抢占时间，否则不更新，为了防止一个用户通过修改广告词功能长期霸占一个位置。
					echo "<script>alert('抢占成功，审核通过后，即可显示您的广告内容');";
					echo "location.replace('adv2.php')</script>";
				}
			}
		}
	}

}

if ($action=="modify"){
	switch (check_user_power("set_text_adv")){
		case "no";
			if (jifen=="Yes"){
				setAdv(1);
			}else{
				echo "<script>alert('你所在的用户组没有抢占广告位的权限！');history.back(-1)</script>";
			}
			break;
		case "yes";
			setAdv(0);
			break;
	}

}else{
	?>
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
					<div class="admintitle">抢占首页文字广告位置</div>
					<div class="box"> 注：抢占方式：先抢先得；每个用户只限抢占一个广告位。抢占成功后，广告位占用期限为 <b><?php echo showadvdate?></b> 天。到期后可重新参与抢占。
					</div>
					<div class="admintitle">广告抢占区</div>
					<?php
					$n=1;
					$rs=mysql_query("select * from zzcms_ad where bigclassname='首页' and smallclassname='抢占' order by xuhao asc,id asc");
					$row=mysql_num_rows($rs);
					if (!$row){
						echo "暂无信息";
					}else{
						?>
						<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
							<tr>
								<?php while($row=mysql_fetch_array($rs)){ ?>
									<td width="25%" height="50"   class="border" ><?php echo "A".$n?>
										<a href='<?php echo $row["link"]?>' target='_blank'><?php echo $row["title"]?></a>
										<?php
										if ($row["elite"]==1){
											echo "<div><input name=\"Submit\" type=\"button\"  disabled value=\"收费广告位，不可抢占\"></div>";
										}else{
											if (time()-strtotime($row['sendtime'])>24*3600*showadvdate){
												?>
												<form name="form1" method="post" action="">
													<input name="action" type="hidden" id="action" value="modify">
													<input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
													<?php if ($row["nextuser"]<>""){//如果审核没被通过，且被删除后，相对应的nextuser值同时也被删。
														echo  $row["nextuser"]."抢得此位置，广告内容正在审核中";
													}else{
														?>
														<input name="Submit" type="submit"  value="抢占这个位置">
														<?php
													}
													?>
												</form>
												<?php
											}else{
												?>
												<div><input name="Submit" type="button"  disabled value="<?php echo sprintf("%.2f",((24*3600*showadvdate-(time()-strtotime($row['sendtime'])))/(24*3600))) ?>天后可抢占"></div>
												<?php
											}
										}
										?>
									</td>
									<?php
									if ($n % 4==0){
										echo "</tr>";
									}
									$n=$n+1;
								}
								?>
						</table>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	</body>
	</html>
	<?php
}
mysql_close($conn);
?>