<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE></TITLE>
<style type="text/css">
body { margin:0px; background:transparent; overflow:hidden; background:url("image/manage_leftbg.gif"); }
.left_color { text-align:right; }
.left_color a { color: #083772; text-decoration: none; font-size:12px; display:block !important; display:inline; width:175px !important; width:180px; text-align:right; background:url("image/manage_menubg.gif") right no-repeat; height:23px; line-height:23px; padding-right:10px; margin-bottom:2px;}
.left_color a:hover { color: #7B2E00;  background:url("image/manage_menubg_hover.gif") right no-repeat; }
img { float:none; vertical-align:middle; }
</style>
<script type="text/javascript">
<!--
	function disp(n){
		for (var i=0;i<12;i++)
		{
			if (!document.getElementById("left"+i)) return;			
			document.getElementById("left"+i).style.display="none";
		}
		document.getElementById("left"+n).style.display="";
	}	
//-->
</script>
</head>
<BODY>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #FFFFFF">
  <tr>
    <td valign="top" style="padding-top:10px;" class="left_color" id="menubar">
	<div id="left0" style="display:"> 
	 <a href="zs_manage.php" target="frmright">招商信息管理</a> 
	 <a href="tagmanage.php?tabletag=zzcms_tagzs" target="frmright">招商关键词管理</a>
	  <a href="dl_manage.php" target="frmright" >代理信息管理</a>
		<a href="zx_manage.php" target="frmright">资讯信息管理</a> 
         <a href="pinglun_manage.php" target="frmright">资讯评论管理</a> 
         <a href="tagmanage.php?tabletag=zzcms_tagzx" target="frmright">资讯标签管理 </a> 
	
		<a href="usermessage.php" target="frmright">网站返馈管理</a> 
		<a href="licence.php" target="frmright">资质证书管理</a> 
		<a href="linkmanage.php" target="frmright">友情链接管理</a> 
		<a href="help_manage.php?b=2" target="frmright">公告信息管理</a>
		<a href="help_manage.php?b=1" target="frmright">帮助信息管理</a>
     </div>	
      <div id="left1" style="display:none"> 
	  <a href="zs_manage.php" target="frmright">招商信息管理</a> 
	  <a href="tagmanage.php?tabletag=zzcms_tagzs" target="frmright">招商关键词管理</a>
	  <a href="dl_manage.php" target="frmright" >代理信息管理</a>
		<a href="zx_manage.php" target="frmright">资讯信息管理</a> 
         <a href="pinglun_manage.php" target="frmright">资讯评论管理</a> 
         <a href="tagmanage.php?tabletag=zzcms_tagzx" target="frmright">资讯标签管理 </a> 
	
		<a href="usermessage.php" target="frmright">网站返馈管理</a> 
		<a href="licence.php" target="frmright">资质证书管理</a> 
		<a href="linkmanage.php" target="frmright">友情链接管理</a> 
		<a href="help_manage.php?b=2" target="frmright">公告信息管理</a>
		<a href="help_manage.php?b=1" target="frmright">帮助信息管理</a>
      </div>
      <div id="left2" style="display:none"> <a href="zsclassmanage.php" target="frmright">招商类别管理</a> 
        <a href="zxclassmanage.php" target="frmright">资讯类别管理</a> <a href="adclass.php" target="frmright">广告类别管理</a> 
        <a href="classmanage.php?tablename=zzcms_linkclass" target="frmright">友情链接类别管理</a> </div>

      <div id="left3" style="display:none"> 
	  <a href="ad_add.php" target="frmright">添加广告</a>
	   <a href="ad_user_manage.php" target="frmright">审请的广告</a>
        <a href="ad_manage.php" target="frmright">广告管理</a>
		<a href="adclass.php" target="frmright">类别设置</a>
		<a href="siteconfig.php?#qiangad" target="frmright">广告设置</a>
	</div>

			
      <div id="left4" style="display:none"> <a href="usermanage.php" target="frmright">用户管理</a> 
        <a href="usergroupmanage.php" target="frmright">用户组管理</a> <a href="usernotreg.php" target="frmright">未进行邮箱验证的用户管理</a> 
        <a href="licence.php" target="frmright">用户资质证书管理</a> <a href="showbad.php" target="frmright">用户不良操作记录</a> 
        <a href="adminlist.php" target="frmright">管理员管理</a> <a href="admingroupmanage.php" target="frmright">管理员组管理</a> 
      </div>
			


<div id="left5" style="display:none"> 
			<a href="message_add.php" target="frmright">发站内短消息</a> 
			<a href="message_manage.php" target="frmright">站内短消息管理</a>
			<a href="sendmail.php" target="frmright">发E-mali</a> 
			<a href="siteconfig.php#sendmail" target="frmright">E-mali设置</a>
			<a href="sendsms.php" target="frmright">发手机短信</a>
			<a href="siteconfig.php#sendSms" target="frmright">手机短信设置</a>
</div>
			
			<div id="left6" style="display:none"> 
			<a href="siteconfig.php#siteskin" target="frmright">网站风格设置</a>
			<a href="siteconfig.php#SiteInfo" target="frmright">网站基本信息设置</a>
			<a href="siteconfig.php#SiteOpen" target="frmright">网站运行状态设置</a>
			<a href="siteconfig.php#SiteOption" target="frmright">网站功能参数设置</a>
            <a href="about_manage.php" target="frmright">网站底部链接管理</a> 
			<a href="siteconfig.php#stopwords" target="frmright">限制字符设置</a> 
            <a href="siteconfig.php#qiangad" target="frmright">广告设置</a>
			 <a href="siteconfig.php#sendmail" target="frmright">在线发邮件设置</a>
			 <a href="siteconfig.php#sendsms" target="frmright">在线发手机短信设置</a>
			 <a href="siteconfig.php#userjf" target="frmright">积分功能设置</a>
			 <a href="siteconfig.php#UpFile" target="frmright">上传文件选项设置</a>
			 <a href="siteconfig.php#addimage" target="frmright">添加水印功能设置</a>	 
			 <a href="siteconfig.php#alipay_set" target="frmright">在线支付接口设置</a>	 
            <a href="showbad.php" target="frmright">限制来访IP管理</a> 
			<a href="wjtset.php" target="frmright">文件头设置</a> 
			</div>
			<div id="left7" style="display:none">
			<a href="databaseclear.php" target="frmright">初始化数据库</a>
			<a href="data_back.htm" target="frmright">备份/还原数据库</a>
			</div>
			
			
      <div id="left8" style="display:none"> <a href="labelzsshow.php" target="frmright">招商内容标签</a> 
        <a href="labelclass.php?classname=zsclass" target="frmright">招商类别标签</a>	
        <a href="labeldlshow.php" target="frmright">代理内容标签</a> 

		<a href="labelzxshow.php" target="frmright">资讯内容标签</a> 
        <a href="labelclass.php?classname=zxclass" target="frmright">资讯类别标签</a> 
        <a href="labelcompanyshow.php" target="frmright">企业内容标签</a> 
		<a href="labeladshow.php" target="frmright">广告内容标签</a> 
        <a href="labelhelpshow.php" target="frmright">帮助内容标签</a>
		<a href="labellinkshow.php" target="frmright">友情链接内容标签</a> 
		<a href="labelclass.php?classname=linkclass" target="frmright">友情链接类别标签</a> 
		<a href="labelaboutshow.php" target="frmright">单页内容标签</a>
      </div>
			<div id="left9" style="display:none"> 
			<a href="template.php" target="frmright">网站模板管理</a>
			</div>
			<div id="left10" style="display:none"> 
			<a href="cachedel.php" target="frmright">清理网站缓存</a>
			<a href="cachedel.php" target="frmright">清理HTML页</a>
			</div>	
			
	<div id="left11" style="display:none"> 
        <a href="siteconfig.php#upfile" target="frmright">上传功能设置</a>
        <a href="siteconfig.php#addimage" target="frmright">添加水印功能设置</a>
        <a href="uploadfile_nouse.php" target="frmright"> 清理无用的上传文件</a> 
	</div>				
	</td>
 </tr>
</table>
</body>
</html>