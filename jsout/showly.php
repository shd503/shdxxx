﻿<?php
$fbr=trim($_REQUEST["fbr"]);
$str="<script src='/js/qt.js'></script>\n";
$str=$str."<link href='/web_style.css' rel='stylesheet' type='text/css'>";
$str=$str."<form action='/zs/dl_liuyan_save.php' method='post' name='ly' onSubmit='return CheckForms();' target='_self'>\n";

$str=$str."<table width=100% border=0 cellpadding=5 cellspacing=0 bgcolor=#dddddd class='liuyanbg'>\n\n";
$str=$str."<tr bgcolor=#FFFFFF>\n" ;
$str=$str."<td width=147 align=right >联 系 人 <font color=#FF0000>*</font></td>\n";
$str=$str."<td width=817 class='bgcolor1'> <input name=name type=text id=name size=30 maxlength=50 /> \n";
$str=$str."<input name=fbr type=hidden id=fbr  value='".$fbr."' />\n";
$str=$str."</td>\n";
$str=$str."</tr>\n";
$str=$str."<tr bgcolor=#FFFFFF>\n" ;
$str=$str."<td width=147 align=right class=bgcolor1>联系电话/手机 <font color=#FF0000>*</font></td>\n";
$str=$str."<td class='bgcolor1'> <input name='tel' type='text' id='tel' onblur='CheckNum()' size='30' maxlength='50' /> \n";
$str=$str."</td>\n";
$str=$str."</tr>\n";
$str=$str."<tr bgcolor=#FFFFFF> \n";
$str=$str."<td width=147 align=right class=bgcolor1>电子邮箱：</td>\n";
$str=$str."<td class='bgcolor1'> <input name=email type=text id=email size=30 maxlength=50 /> \n";
$str=$str."</td>\n";
$str=$str."</tr>\n";
$str=$str."<tr bgcolor=#FFFFFF>\n";
$str=$str."<td align=right class=bgcolor1>留言内容 <font color=#FF0000>*</font></td>\n";
$str=$str."<td class='bgcolor1'><table width=100% border=0 cellspacing=0 cellpadding=0>\n";
$str=$str."<tr bgcolor=#FFFFFF>\n";
$str=$str."<td width='35%'><textarea  name='content' cols=40 rows=5>我对这个产品感兴趣，请与我联系。</textarea></td>\n";
$str=$str."<td width='65%'><input name='chcontent' type='checkbox' id='chcontent1' onclick=showinfo('content',1) value='我对这个产品感兴趣，请与我联系。' /> \n";
$str=$str."<label for='chcontent1' id='content1'> 我对这个产品感兴趣，请与我联系。</label>\n";
$str=$str."<br /> <input name='chcontent' type='checkbox' id='chcontent2' onclick=showinfo('content',2); value='代理价零售价是多少？' /> \n";
$str=$str."<label for='chcontent2'  id='content2'>代理价零售价是多少？</label>\n";
$str=$str."<br /> <input name='chcontent' type='checkbox' id='chcontent3' onclick=showinfo('content',3); value='请寄给我详细资料。' />\n"; 
$str=$str."<label for='chcontent3'  id='content3'>请寄给我详细资料。</label>\n";
$str=$str."<br /> <input name='chcontent' type='checkbox' id='chcontent4' onclick=showinfo('content',4); value='请寄给我样品。' /> \n";
$str=$str."<label for='chcontent4'  id='content4'>请寄给我样品。</label> </td>\n";
$str=$str."</tr>\n";
$str=$str."</table></td>\n";
$str=$str."</tr>\n";
$str=$str."<tr bgcolor=#FFFFFF><td colspan=2>\n";
$str=$str." <div id=tjxx style=text-align:center;padding:10px;display:> \n";
$str=$str."<input type=submit name=tj value=填好了，提交 onClick='showloading()'>\n";
$str=$str."</div>\n";
$str=$str."<div id='loading' style='text-align:center;padding:10px;display:none'>正传送数据，请稍候……</div>\n";
$str=$str."</td></tr>\n";
$str=$str."</table> \n";
$str=$str."</form>\n";
echo 'document.write("'.$str.'");'; 
?>