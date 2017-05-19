<?php 
include("../inc/config.php");
$str="<link href='/web_style.css' rel='stylesheet' type='text/css'>";
$str=$str."<table width=100% border=0 cellpadding=0 cellspacing=0 class=pagetop ><tr>";
$str=$str."<td width=33% height=60> <a href=".siteurl."><img src=".logourl." border=0 onload='javascript:if(this.width>220) this.width=220;'></a></td>";
$str=$str."<td width=67%>";
$str=$str."<div class=nav>";
$str=$str."<ul>";
$str=$str."<li class=current><a href='/index.htm'>网站首页</a></li>";
$str=$str."<li><a href='/zs/fushixiebao.html'>服饰鞋包</a></li>";
$str=$str."<li><a href='/zs/teshecanyin.html'>特色餐饮</a></li>";
$str=$str."<li><a href='/zs/meirongyangsheng.html'>美容养生 </a></li>";
$str=$str."<li><a href='/zs/wangju.html'>饰品玩具</a></li>";
$str=$str."<li><a href='/zs/jiajuzhuangshi.html'>家居装饰</a></li>";
$str=$str."<li><a href='/zs/jienenghuanbao.html'>节能环保</a></li>";
$str=$str."<li><a href='/zs/xinruilianshuo.html'>新锐连锁</a></li>";
$str=$str."<li><a href='/zs/wangluofuwu.html'>网络服务</a></li>";
$str=$str."<li><a href='/zs/order.php'>排 行 榜</a></li>";	
$str=$str."</ul>";
$str=$str."</div>";
$str=$str."</td>";
$str=$str."  </tr>";
$str=$str."</table>";
echo 'document.write("'.$str.'");';
?>
