<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>发布创业需求</title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});

function isNumber(String){ 
var Letters = "1234567890-";   //可以自己增加可输入值
var i;
var c;
if(String.charAt(0)=='-')
return   false;
if( String.charAt(String.length - 1) == '-' )
return   false;
for( i = 0; i<String.length;i ++ )
{ 
c=String.charAt( i );
if(Letters.indexOf( c )< 0)
return  false;
}
return  true;
}

function check_truename(){
if (document.myform.truename.value !=""){
	 //创建正则表达式
    var re=/^[\u4e00-\u9fa5]{2,10}$/; //只输入汉字的正则
    if(document.myform.truename.value.search(re)==-1){
	alert("联系人只能为汉字，字符介于2到10个。");
	document.myform.truename.value="";
	document.myform.truename.focus();
	}
}
}

function check_tel(){
if (document.myform.tel.value !=""){	
	var phone = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
	if(!phone.test(document.myform.tel.value)){
	alert("您的电话号码不正确！");
	document.myform.tel.focus();
	}
} 
}

function CheckForm(){
if (document.myform.cp.value==""){
    alert("请填写意向领域！");
	document.myform.cp.focus();
	return false;
  }
if (document.myform.city.value==""){
    alert("请填所在地！");
	document.myform.city.focus();
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
if (document.myform.yzm.value==""){
    alert("请输入验证问题的答案！");
	document.myform.yzm.focus();
	return false;
}
}
</SCRIPT>
</head>
<body>

<div class="main">
<?php
include("../inc/top2.php");
echo sitetop();
//访客地理位置
$cuestip=getip(); 
$cuest_city=getIPLoc_sina($cuestip); 
$cuest_city=str_replace('联通','',str_replace('网通','',str_replace('电信','',$cuest_city)));
?>
<div class="pagebody">
<div class="titles">发布创业需求</div>
<div class="content">
<form action="?" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="8" cellspacing="1">
    <tr> 
      <td align="right" class="border">意向投资领域<font color="#FF0000"> *</font></td>
      <td class="border"> <input name="cp" type="text" id="cp" size="45" maxlength="45" class="biaodan">      </td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border">所在地区 <font color="#FF0000">*</font></td>
            <td class="border">
			
			<input name="city" type="text" class="biaodan" id="city" value="<?php echo $cuest_city?>" size="45" maxlength="45" /></td>
    </tr>
	
    <tr> 
      <td align="right" class="border2">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border2">
<input name="truename" type="text" id="truename"  size="45" maxlength="255" onblur="check_truename()" class="biaodan"/></td>
    </tr>
    <tr> 
      <td align="right" class="border">手机 <font color="#FF0000">*</font></td>
      <td class="border"><input name="tel" type="text" id="tel"  size="45" maxlength="255" onblur="check_tel()" class="biaodan"/></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" size="45" maxlength="255" class="biaodan"/></td>
    </tr>
	
    <tr> 
    <td align="right" class="border2">答案 <font color="#FF0000">*</font></td>      
    <td class="border2">
	<input name="yzm" type="text" class="biaodan2" id="yzm" tabindex="10" value="" size="10" maxlength="50" style="width:60px"/>
    <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="看不清，点击换一张" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="发 布">
        <input name="action" type="hidden" id="action3" value="add"></td>
    </tr>
  </table>
</form>
<?php
if (isset($_POST["action"])){
$cp=$_POST["cp"];
$address=$_POST["city"];
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];

checkyzm($_POST["yzm"]);

if(!preg_match("/^[\x7f-\xff]+$/",$truename)){
showmsg('姓名只能用中文','back');
}

if(!preg_match("/1[3458]{1}\d{9}$/",$tel) && !preg_match('/^400(\d{3,4}){2}$/',$tel) && !preg_match('/^400(-\d{3,4}){2}$/',$tel) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$tel)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
showmsg('电话号码不正确','back');
}

if ($cp<>'' && $truename<>'' && $tel<>''){
$isok=mysql_query("Insert into zzcms_dl(cp,address,dlsname,tel,email,sendtime) values('$cp','$address','$truename','$tel','$email','".date('Y-m-d H:i:s')."')") ;
}  
if ($isok){
echo showmsg('发布成功。');
}else{
echo showmsg('发布失败！');
}

}	
?>
</div>
</div>
</div>
<?php
include("../inc/bottom.php");
session_write_close();
echo sitebottom();
?>
</body>
</html>