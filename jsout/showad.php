<?php
include("../inc/conn.php");
$column=6;
$showborder="yes";
$showtitle="yes";
$n=1;
$tdwidth=floor(100/$column);//取整
//sql= "select * from zzcms_news where endtime>= '"&date()&"' "
$sql= "select * from zzcms_news where bigclassname='展示页' order by xuhao asc,id asc";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){             
$str="<table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor='#dddddd'><tr>";
while ($row=mysql_fetch_array($rs)){
		if (($n + 6) % 12 == 0 || ($n + 7) % 12 == 0 ||  ($n + 8) % 12 == 0 || ($n + 9) % 12 == 0 || ($n + 10) % 12 == 0 || ($n + 11) % 12 == 0){
    	$str=$str."<td width=".$tdwidth."%  class=textad1>";
		}else{
		$str=$str."<td width=".$tdwidth."%  class=textad2>";
		}
	if ($row["img"]<>"") {
		$str=$str. "<a href=".$row["link"]." target=_blank>";
		if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false) {
		$str=$str. "<img src=".siteurl.$row["img"]." height=".$row["imgheight"]." width=".$row["imgwidth"]." border=0 alt=".$row["title"]."/>";
		}elseif (substr($row["img"],-3)=="swf"){  
		$str=$str."<button disabled=disabled style=border-style: none; background-color: #FFFFFF; background-image: none;width:".$row["imgwidth"]."px >" ;
		$str=$str."<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0 width=".$row["imgwidth"]." height=".$row["imgheight"].">";
		$str=$str."<param name=movie value=".siteurl.$row["img"]." />";
    	$str=$str."<param name=quality value=high />" ;
		$str=$str."<param name=wmode value=Opaque />"; //必要参数否则在SWF文件上无法点击链接
		$str=$str."<embed src=".siteurl.$row["img"]." quality=high pluginspage=http://www.macromedia.com/go/getflashplayer type=application/x-shockwave-flash wmode=Opaque width=".$row["imgwidth"]." height=".$row["imgheight"]."></embed>";
		$str=$str."</object>" ;
		$str=$str."</button>";
		}
		if ($showtitle=="yes"){
		$str=$str."<br/><font color=#666666>".addzero($n,2)."-</font>".$row["title"];
		}
	$str=$str."</a>";	
	}else{	
		
		$str=$str. "<a href=".$row["link"]." target='_blank'>";	
		$str=$str."<font color=#666666>".addzero($n,2)."-</font>".$row["title"];
		$str=$str. "</a>";
	}           
    $str=$str."</td>";
	if ($n % $column==0) {
	$str=$str."</tr>";
	}
	$n=$n+1;
}
   $str=$str." </table>";
}
echo 'document.write("'.$str.'");'; 
?>