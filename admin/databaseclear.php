<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function ConfirmClear(){
   if(confirm("初始化数据库后将不能恢复！确定初始化么？"))
     return true;
   else
     return false;
	 
}
function CheckAll(form){
for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
}
</script>
</head>
<body>
<div class="admintitle">初始化数据库</div>
<?php
if (!isset($_POST["action"])) {
?>
      <form name="form1" method="post" action="" onSubmit="return ConfirmClear();">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_main" value="zzcms_main">
              <label for="zzcms_main">zzcms_main(招商表) </label>
              <input name="table[]" type="checkbox" id="zzcms_zsclass" value="zzcms_zsclass">
              <label for="zzcms_zsclass">zzcms_zsclass(招商分类表) </label>
              </td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_dl" value="zzcms_dl">
              <label for="zzcms_dl">zzcms_dl(代理表) </label>
              <input name="table[]" type="checkbox" id="zzcms_looked_dls" value="zzcms_looked_dls">
              <label for="zzcms_looked_dls">zzcms_looked_dls(代理商查看记录表) </label>
              <input name="table[]" type="checkbox" id="zzcms_looked_dls_number_oneday" value="zzcms_looked_dls_number_oneday">
              <label for="zzcms_looked_dls_number_oneday">zzcms_looked_dls_number_oneday(记录用户每天查看代理数的表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_zx" value="zzcms_zx">
              <label for="zzcms_zx">zzcms_zx(资讯表) </label>
              <input name="table[]" type="checkbox" id="zzcms_zxclass" value="zzcms_zxclass">
              <label for="zzcms_zxclass">zzcms_zxclass(资讯分类表) </label>
              <input name="table[]" type="checkbox" id="zzcms_tagzx" value="zzcms_tagzx">
             <label for="zzcms_tagzx"> zzcms_tagzx(资讯标签表) </label>
              <input name="table[]" type="checkbox" id="zzcms_pinglun" value="zzcms_pinglun">
              <label for="zzcms_pinglun">zzcms_pinglun(资讯评论表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_licence" value="zzcms_licence">
             <label for="zzcms_licence"> zzcms_licence(资质表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_link" value="zzcms_link">
              <label for="zzcms_link">zzcms_link(友情链接表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_user" value="zzcms_user">
              <label for="zzcms_user">zzcms_user(注册用户表)</label> 
              <input name="table[]" type="checkbox" id="zzcms_usernoreg" value="zzcms_usernoreg">
              <label for="zzcms_usernoreg">zzcms_usernoreg(未激活帐户的用户表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_textadv" value="zzcms_textadv">
              <label for="zzcms_textadv">zzcms_textadv(待审广告表) </label>
              <input name="table[]" type="checkbox" id="zzcms_news" value="zzcms_news">
             <label for="zzcms_news"> zzcms_news(广告表) </label>
              <input name="table[]" type="checkbox" id="zzcms_newsclass" value="zzcms_newsclass">
              <label for="zzcms_newsclass">zzcms_newsclass(广告类别表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_pay" value="zzcms_pay">
              <label for="zzcms_pay">zzcms_pay(冲值记录表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_usersetting" value="zzcms_usersetting">
             <label for="zzcms_usersetting"> zzcms_usermessage(用户反馈表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_message" value="zzcms_message">
              <label for="zzcms_message">zzcms_message(站内短消息表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_bad" value="zzcms_bad">
              <label for="zzcms_bad">zzcms_bad(不良操作记录表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_about" value="zzcms_about">
              <label for="zzcms_about">zzcms_about(网站介绍表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
              <label for="chkAll">全选/取消</label>
              <input name="Submit24" type="submit" class="buttons" value="初始化数据库"> 
              <input name="action" type="hidden" id="action" value="clear"> </td>
          </tr>
        </table>
        </form>
<?php
}else{
checkadminisdo("siteconfig");
?>
<div class="border">
<?php
if(!empty($_POST['table'])){
    for($i=0; $i<count($_POST['table']);$i++){
	mysql_query("truncate ".trim($_POST['table'][$i])."");
	echo $table[$i]."表已被初始化<br>"; 
    }	
}
?>
</div>
<?php
}
?>		
</body>
</html>