<?php
//if( $_SERVER['HTTP_REFERER']==''){//禁止从外部直接打开
//header("Location:".$fromurl); exit;
//}

$sqlu="select initRMB from zzcms_user where username='" .$username. "'";
$rsu=mysql_query($sqlu);
$rowu=mysql_fetch_array($rsu);
$initRMB=$rowu["initRMB"];
?>

<script type="text/javascript">
	function disp(n){
		for (var i=0;i<8;i++){
			if (!document.getElementById("left"+i)) return;
			document.getElementById("left"+i).style.display="none";
		}
		document.getElementById("left"+n).style.display="";
	}
	function Confirmdeluser(){
		if(confirm("注销后将不能恢复！确定要注销帐户么？"))
			return true;
		else
			return false;
	}

	function ConfirmPay(){
		if(confirm("发布信息之前请先支付，否则无法发布！"))
			return true;
		else
			return false;
	}

</script>
<div id="left1" class="leftcontent">
	<div class="lefttitle"><img src="image/ico/ico4.gif" border=0> 商机管理</div>
	<div>
		<ul>
			<?php
			if ((int)$initRMB == 0 ) {
				?>
				<li><a href="zs.php" target="_self" onClick="return ConfirmPay();">商机管理</a></li>
				<?php
			}else{
				?>
				<li><a href="zs.php" target="_self">商机管理</a></li>
				<?php
			}
			?>

			<li><a href="dls_message_manage.php" target="_self" >代理留言</a>
				<?php
				$sql_left="select id from zzcms_dl where saver='".@$username."' and looked=0 and del=0 and passed=1";
				$rs_left=mysql_query($sql_left);
				$row_left=mysql_num_rows($rs_left);
				if($row_left){
					echo "<span class='buttons'>".$row_left."</span>";
				}
				?>
			</li>
			<li><a href="zxadd.php" target="_self" >发资讯</a> <a href="zxmanage.php" target="_self" >管理</a></li>
		</ul>
	</div>
</div>

<div id="left3" class="leftcontent">
	<div class="lefttitle"> <img src="image/ico/ico9.gif" width="12" height="16"> 抢广告位</div>
	<div>
		<ul>
			<li><a href="adv.php" target="_self">设置/更换广告词</a></li>
			<li><a href="adv2.php" target="_self">抢占广告位</a><img src="image/ico/ico6.gif" width="23" height="12"></li>
		</ul>
	</div>
</div>

<div id="left4"  class="leftcontent">
	<div class="lefttitle"><img src="image/ico/ico5.gif" width="16" height="16"> 资质管理</div>
	<div>
		<ul>
			<li><a href="licence_add.php" target="_self"> 资质证书添加</a></li>
			<li><a href="licence.php" target="_self" >资质证书管理</a></li>
		</ul>
	</div>
</div>

<div id="left5"  class="leftcontent">
	<div class="lefttitle"><img src="image/ico/ico7.gif" width="16" height="15"> 财务管理</div>
	<div>
		<ul>
			<!--<li><a href="/3/alipay/" target="_blank"> 用支付宝充值</a></li>
			<li><a href="/3/tenpay/" target="_blank"> 用财富通充值</a></li>-->
			<li><a href="/codepay/index.php" target="_blank"> 用微信充值</a></li>
			<li><a href="pay_manage.php" target="_self"> 我的财务记录</a></li>
		</ul></div></div>

<div id="left6"  class="leftcontent">
	<div class="lefttitle"><img src="image/ico/ico10.gif" width="16" height="16"> 用户设置</div>
	<div>
		<ul>
			<li><a href="vip_add.php" target="_self">会员自助升级</a></li>
			<li><a href="vip_xufei.php" target="_self">会员自助续费</a></li>
			<li><a href="manage.php" target="_self">修改注册信息</a></li>
			<li><a href="managepwd.php" target="_self">修改登录密码</a></li>
			<li><a href="/one/vipuser.php" target="_blank">查看我的权限</a></li>
			<li><a href="index.php" target="_self">查看帐号信息</a></li>
		</ul></div></div>

<div id="left7" class="leftcontent">
	<div class="lefttitle"><img src="image/ico/ico3.gif"> 需要帮助</div>
	<div>
		<ul>
			<li><a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=<?php echo kfqq?>&Site=<?php echo sitename?>&Menu=yes><img border="0" src=http://wpa.qq.com/pa?p=1:<?php echo kfqq ?>:4 alt="在线客服QQ"> 在线客服</a></li>
			<li><a href="#">电话： <?php echo kftel?></a></li>
			<li><a href="/one/help.php" target="_blank">常见问题解答</a></li>
			<li><a href="message.php">给管理员发信息</a></li>
		</ul>
	</div>
</div>