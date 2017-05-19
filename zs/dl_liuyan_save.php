<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/mail_class.php");
include ("../3/mobile_msg/inc.php");
//include ("../inc/top2.php");
//include ("../inc/bottom.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="../template/<?php echo $siteskin?>/style.css" rel="stylesheet" type="text/css">
<body>
<div class="main" >
<?php
//echo sitetop();
//if ($_POST['token'] != $_SESSION['token'] || $_POST['token']=='' ){    
//showmsg('非法提交','back');
//}else{
//unset($_SESSION['token']);
//}开启二级域名时不能用这段验证加了下面的双验证

$saver=trim($_POST["fbr"]);
$rs=mysql_query("select proname from zzcms_main where editor='".$saver."'");
$row=mysql_fetch_array($rs);
$cp=$row["proname"];//取得商机名

$content=rtrim($_POST["contents"]);
$dlsname=trim($_POST["name"]);
$tel=trim($_POST["tel"]);
$email=trim($_POST["email"]);

if(!preg_match("/^[\x7f-\xff]+$/",$dlsname)){
showmsg('姓名只能用中文','back');
}

if(!preg_match("/1[3458]{1}\d{9}$/",$tel) && !preg_match('/^400(\d{3,4}){2}$/',$tel) && !preg_match('/^400(-\d{3,4}){2}$/',$tel) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$tel)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
showmsg('电话号码不正确','back');
}

$rs=mysql_query("select groupid from zzcms_user where username='".$saver."' ");
$row=mysql_fetch_array($rs);
$rs=mysql_query("select * from zzcms_dl where dlsname='$dlsname' and tel='$tel' and saver='$saver'");
$row=mysql_num_rows($rs);
//if ($row){
//echo "<script>alert('您已留过言了！');history.back(-1)<//script>";
//}else{
if ($content<>''){
mysql_query("insert into zzcms_dl(cp,content,dlsname,tel,email,saver,sendtime)values('$cp','$content','$dlsname','$tel','$email','$saver','".date('Y-m-d H:i:s')."')");
}

$rsn=mysql_query("select id,username,sex,email,mobile,somane from zzcms_user where username='".$saver."'");
$rown=mysql_fetch_array($rsn);
$id=$rown["id"];//供返回展厅首页用	
if (whendlsave=="Yes"){
	$fbr_email=$rown["email"];
	$dstmobile=$rown["mobile"];
	$somane=$rown["somane"];
	$sex=$rown["sex"];
		if ($sex==1){
		$sex="先生";
		}elseif($sex==0){
		$sex=="女士";
		}
	$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
	//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
	$to = $fbr_email; //收件人
	$subject = "有人在".sitename."上给您留言想要代理".$cp;
	$body= "<table width='100%'><tr><td style='font-size:14px;line-height:25px'>".$somane.$sex. "：<br>&nbsp;&nbsp;&nbsp;&nbsp;您好！<br>有人在".sitename."上给您留言，想要代理$cp；以下是部分信息：<hr>";
	$body=$body . "留&nbsp;言&nbsp;人：".$dlsname."<br>代理产品：".$cp."<br>代理区域：".$city."<br>留言时间：".date('Y-m-d H:i:s')."<br><a href='".siteurl."/user/login.php' target='_blank'><b>登录网站查看详情</b></a><br><br><br><br><a href='".siteurl."' target='_blank'><img src='".logourl."' border='0'></a>";
	$body=$body . "</td></tr></table>";
	
	$fp="../template/".siteskin."/email.htm";
	$f= fopen($fp,'r');
	$strout = fread($f,filesize($fp));
	fclose($f);
	$strout=str_replace("{#body}",$body,$strout) ;
	$strout=str_replace("{#siteurl}",siteurl,$strout) ;
	$strout=str_replace("{#logourl}",logourl,$strout) ;
	$body=$strout;
	
	$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML 
	//echo "发送失败原因：".$this->smtp->logs;
	if (sendsms=="Yes"){
	$msg='有人在'.sitename.'留言要代理您发布的产品，请登录网站查看详情，网址：'.siteurl;
	$msg = iconv("UTF-8","GBK",$msg);
	$result = sendSMS($smsusername,$smsuserpass,$dstmobile,$msg,$apikey);
	echo $result."<br>";
	}
}
showmsg('成功提交',$_SERVER['HTTP_REFERER']);//当在展厅首页留言时，会改变当前页地址
session_write_close();
//}
?>