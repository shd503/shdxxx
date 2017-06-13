<?php
function showpage_admin(){
global $page,$totlepage,$totlenum,$page_size,$shenhe,$b,$s,$kind,$keyword,$showwhat;
$cs="";
if ($shenhe!=''){$cs=$cs."&shenhe=".$shenhe;}
if ($keyword!=''){$cs=$cs."&keyword=".$keyword;}
if ($b!=''){$cs=$cs."&b=".$b;}
if ($s!=''){$cs=$cs."&s=".$s;}
if ($kind<>''){$cs=$cs."&kind=".$kind;}
if ($showwhat<>''){$cs=$cs."&showwhat=".$showwhat;}

$str="页次：<strong><font color=#CC0033>".$page."</font>/".$totlepage."　</strong> ";
$str=$str." <strong>".$page_size."</strong>条/页　共<strong>".$totlenum."</strong>条";		 
 
if ($page!=1){
$str=$str."【<a href=?page=1".$cs.">首页</a>】";
$str=$str."【<a href=?page=".($page-1).$cs.">上一页</a>】";
}else{
$str=$str."【首页】【上一页】";
}
if ($page!=$totlepage){
$str=$str."【<a href=?page=".($page+1).$cs.">下一页</a>】";
$str=$str."【<a href=?page=".$totlepage.$cs.">尾页</a>】";
}else{
$str=$str."【下一页】【尾页】";
}
return $str;
}

function showpage($b='no'){
global $page,$totlepage,$totlenum,$page_size,$bigclassid;
$str="页次：<strong><font color=#CC0033>".$page."</font>/".$totlepage."　</strong> ";
$str=$str." <strong>".$page_size."</strong>条/页　共<strong>".$totlenum."</strong>条";		 
  
if ($page!=1){
	if ($b=="yes"){
	$str=$str."<a href=?page=1&bigclassid=".$bigclassid.">【首页】</a> ";
	$str=$str."<a href=?page=".($page-1)."&bigclassid=".$bigclassid.">【上一页】</a> ";
	}else{
	$str=$str."<a href=?page=1>【首页】</a> ";
	$str=$str."<a href=?page=".($page-1).">【上一页】</a> ";
	}
}else{
$str=$str."【首页】【上一页】";
}
if ($page!=$totlepage){
	if ($b=="yes"){
	$str=$str."<a href=?page=".($page+1)."&bigclassid=".$bigclassid.">【下一页】</a> ";
	$str=$str."<a href=?page=".$totlepage."&bigclassid=".$bigclassid.">【尾页】</a>";
	}else{	
	$str=$str."<a href=?page=".($page+1).">【下一页】</a> ";
	$str=$str."<a href=?page=".$totlepage.">【尾页】</a>";
	}
}else{
$str=$str."【下一页】【尾页】";
}
return $str;
}

function showpage1(){
global $page,$totlepage,$totlenum,$page_size,$keyword,$yiju,$szm;
$str="";
$cs='';
if ($keyword!=''){$cs=$cs."&keyword=".$keyword;}
if ($yiju!=''){$cs=$cs."&yiju=".$yiju;}
if ($szm!=''){$cs=$cs."&szm=".$szm;}
$str=$str."<a><nobr>共".$totlenum."条</nobr></a>";
		if ($page<>1) {
			$str=$str . "<a href='?page=1".$cs."'>1...</a>";
			$str=$str . "<a href='?page=".($page-1).$cs."'>上一页</a>";
		}
		if ($page <10){
        $StartNum = 1;
        }else{
        $StartNum = $page-5;
        }
        $EndNum = $StartNum+9;
        if ($EndNum > $totlepage ){
        $EndNum = $totlepage;
        }
   for($a=$StartNum; $a<$EndNum;$a++){
        if ($a==$page){
        $str=$str . "<span>".$a."</span>";
        }else{
        $str=$str . "<a href='?page=".$a.$cs."'>".$a."</a>";
		}
	}
		if ($page<>$totlepage) {
			$str=$str . "<a href='?page=".($page+1).$cs."'>下一页</a>";
			$str=$str . "<a href='?page=".$totlepage.$cs."'>...".$totlepage."</a>";
		}
		return $str;
}

function showpage2($channel){
global $b,$s,$page,$totlepage,$totlenum,$page_size;
$str="<form name='formpage' action='/".$channel."/".$channel.".php' method='get' target='_self' onsubmit='return checkpage();'>";
		if ($page<>1){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/1.htm'>1...</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page-1).".htm'>上一页</a>";
				}
				elseif ($b<>"") {
				$str= "<a href='/".$channel."/".$b."/1.htm'>1...</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".($page-1).".htm'>上一页</a>";
				}else{
				$str=$str . "<a href='/".$channel."/1.htm'>1...</a>";
				$str=$str . "<a href='/".$channel."/".($page-1).".htm'>上一页</a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=1&b=".$b."&s=".$s."'>1...</a>";
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."&s=".$s."'>上一页</a>";
				}elseif($b<>''){
				$str=$str . "<a href='?page=1&b=".$b."' title='转到第一页'>第一页</a>";
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."' title='转到上一页'>上一页</a>";
				}else{
				$str=$str . "<a href='?page=1&b=".$b."'>1...</a>";
				$str=$str . "<a href='?page=".($page-1)."&b=".$b."'>上一页</a>";
				}
			}
		}
		
		if ($page <10) {
        $StartNum = 1;
        }else{
        $StartNum = $page-5;
        }
        $EndNum = $StartNum+9;
        if ($EndNum > $totlepage) {
        $EndNum = $totlepage;
        }
   for($a=$StartNum; $a<=$EndNum;$a++){
        if ($a==$page) {
		$str=$str . "<span>".$a."</span>";
        }else{
			if (whtml=="Yes") {
				if ($s<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".$a.".htm'>".$a."</a>";
				}elseif($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".$a.".htm'>".$a."</a>";
				}else{
				$str=$str . "<a href='/".$channel."/".$a.".htm'>".$a."</a>";
				}
			}else{
				if ($s<>"") {
				$str=$str . "<a href='?page=".$a."&b=".$b."&s=".$s."'>".$a."</a>";
				}elseif($b<>""){
        		$str=$str . "<a href='?page=".$a."&b=".$b."'>".$a."</a>";
				}else{
				$str=$str . "<a href='?page=".$a."'>".$a."</a>";
				}
			}
		}
	}
	
		if ($page<>$totlepage ){
			if (whtml=="Yes") {
				if ($s<>"") {
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".($page+1).".htm'>下一页</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$s."/".$totlepage.".htm'>...".$totlepage."</a>";
				}elseif ($b<>""){
				$str=$str . "<a href='/".$channel."/".$b."/".($page+1).".htm'>下一页</a>";
				$str=$str . "<a href='/".$channel."/".$b."/".$totlepage.".htm'>...".$totlepage."</a>";
				}else{
				$str=$str . "<a href='/".$channel."/".($page+1).".htm'>下一页</a>";
				$str=$str . "<a href='/".$channel."/".$totlepage.".htm'>...".$totlepage."</a>";
				}
			}else{
				if ($s<>""){
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."&s=".$s."'>下一页</a>";
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."&s=".$s."'>...".$totlepage."</a>";
				}elseif ($b<>""){
				$str=$str . "<a href='?page=".($page+1)."&b=".$b."' title='转到下一页'>></a>";
				$str=$str . "<a href='?page=".$totlepage."&b=".$b."' title='转到第".$totlepage."页'>>></a>";
				}else{
				$str=$str . "<a href='?page=".($page+1)."' title='转到下一页'>下一页</a>";
				$str=$str . "<a href='?page=".$totlepage."' title='转到第".$totlepage."页'>".$totlepage."</a>";
				}
			}
		}
$str=$str."<input name='page' type='text' maxlength='10' value='$page' class='biaodanfy'/>";
$str=$str."<input type='submit'name='submit' value='跳转' class='button'/>";
$str=$str."<input name='b' type='hidden' value='$b'/><input name='s' type='hidden' value='$s'/>";
$str=$str."</form>";	
return $str;
}
?>