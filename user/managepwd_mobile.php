<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 transitional//EN" "http://www.w3.org/tr/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link href="style/<?php echo siteskin_usercenter?>/style_mobile.css" rel="stylesheet" type="text/css">
	<title>修改密码</title>
	<?php
	include "../inc/mail_class.php";
	include '../3/ucenter_api/config.inc.php';//集成ucenter
	include '../3/ucenter_api/uc_client/client.php';//集成ucenter
	include '../3/mobile_msg/inc.php';//集成ucenter
	?>
	<script>
		function CheckForm(){
			if (document.form1.oldpassword.value=="" ){
				alert("旧密码不能为空！");
				document.form1.oldpassword.focus();
				return false;
			}
			if (document.form1.password.value=="" ){
				alert("新密码不能为空！");
				document.form1.password.focus();
				return false;
			}
			if (document.form1.pwdconfirm.value=="" ){
				alert("确认新密码不能为空！");
				document.form1.pwdconfirm.focus();
				return false;
			}
			if (document.form1.password.value !=""){
				//创建正则表达式
				var re=/^[0-9a-zA-Z]{4,14}$/; //只输入数字和字母的正则
				if(document.form1.password.value.search(re)==-1)
				{
					alert("密码只能为字母和数字，字符介于4到14个。");
					document.form1.password.value="";
					document.form1.password.focus();
					return false;
				}
			}
			if (document.form1.password.value !="" && document.form1.pwdconfirm.value !=""){
				if (document.form1.password.value!=document.form1.pwdconfirm.value){
					alert ("两次密码输入不一致，请重新输入。");
					//document.form1.pass.value='';
					document.form1.pwdconfirm.value='';
					document.form1.pwdconfirm.focus();
					return false;
				}
			}
		}
	</script>
</head>
<body>
<?php
if (isset($_POST["action"])){
	$action=$_POST["action"];
}else{
	$action="";
}
$founderr=0;
if ($action=="modify") {
	$oldpassword=md5(trim($_POST["oldpassword"]));
	$password=md5(trim($_POST["password"]));
	$pwdconfirm=md5(trim($_POST["pwdconfirm"]));
	$sql="select * from zzcms_user where username='" . $username . "'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	if ($oldpassword<>$row["password"]){
		$founderr=1;
		$errmsg="<li>你输入的旧密码不对，没有权限修改！</li>";
	}
	if ($founderr==1){
		WriteErrMsg($errmsg);
	}else{
		mysql_query("update zzcms_user set password='$password' where username='".$username."'");
		if (whenmodifypassword=="Yes"){
			$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
			$to = $row['email']; //收件人
			$subject = "修改密码成功—".sitename;
			$body= "<table width='100%'><tr><td style='font-size:14px;line-height:25px'>".$username . "：<br>&nbsp;&nbsp;&nbsp;&nbsp;您好！<br>您的密码修改成功<br>用户名：".$username." 新密码为：".trim($_POST["password"])." &nbsp;&nbsp;<br>如非本人操作请及时登录网站修改你的密码。<a href='".siteurl."/user/login.php'>现在登录>>></a>";
			$body=$body."</td></tr></table>";

			$fp="../template/".siteskin."/email.htm";
			$f= fopen($fp,'r');
			$strout = fread($f,filesize($fp));
			fclose($f);
			$strout=str_replace("{#body}",$body,$strout) ;
			$strout=str_replace("{#siteurl}",siteurl,$strout) ;
			$strout=str_replace("{#logourl}",logourl,$strout) ;
			$body=$strout;
			$send=$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML

			$msg=$username."：您好！您的密码修改成功<br>用户名：".$username." 新密码为：".trim($_POST["password"])."<br>如非本人操作请及时登录网站修改你的密码。";
			$result = sendSMS(smsusername,smsuserpass,$row['mobile'],$msg,apikey_mobile_msg);//发手机短信
		}
		//集成ucenter	
		if (bbs_set=='Yes'){
			$ucresult = uc_user_edit($username, $_POST['oldpassword'], $_POST['password'], $row["email"]);
		}
		//end
		echo "<SCRIPT language=JavaScript>alert('成功修改密码！');history.go(-1)</SCRIPT>";
	}
}else{

	?>
	<div class="main">
		<?php
		include("top_mobile.php");
		?>
		<div class="pagebody">
			<div class="left">
			<!--	<?php
/*				include("left.php");
				*/?>
			</div>
			<div class="right">-->
				<div class="content">
					<div class="admintitle">修改密码</div>
					<form name="form1" action="?" method="post" onsubmit="return CheckForm()">
						<table width="100%" border="0" cellpadding="5" cellspacing="1">
							<tr>
								<td width="25%" align="right" class="border">用户名：</td>
								<td class="border"><?php echo $username ?></td>
							</tr>
							<tr>
								<td align="right" class="border2">旧密码：</td>
								<td class="border2">
									<INPUT  type="password" maxLength="16" size="30" name="oldpassword" class="biaodan">
								</td>
							</tr>
							<tr>
								<td align="right" class="border">新密码：</td>
								<td class="border">
									<INPUT  type="password" maxLength="16" size="30" name="password" class="biaodan">
								</td>
							</tr>
							<tr>
								<td align="right" class="border2">确认新密码：</td>
								<td class="border2">
									<INPUT name=pwdconfirm   type=password id="pwdconfirm" size="30" maxLength="16" class="biaodan">
									<input name="action" type="hidden" id="action" value="modify">
								</td>
							</tr>
							<tr>
								<td class="border">&nbsp; </td>
								<td class="border">
									<input name="Submit"   type="submit" class="buttons" id="Submit" value="保存修改结果">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
}
mysql_close($conn);
?>
</body>
</html>