<?php
include("inc/fixed.php");
function showlabel($str){
global $b;//zsshow需要从zs/class.php获取$b；zxshow从s/class.php获取$b；
$str=fixed($str);//把显示固定标签代码分离出去了
if (strpos($str,"{@zsshow.")!==false) {
	$n=count(explode("{@zsshow.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zsshow.","}");
	$str=str_replace("{@zsshow.".$mylabel."}",zsshow($mylabel,$b),$str);
	}	
}
if (strpos($str,"{@zsclass.")!==false) {
	$n=count(explode("{@zsclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zsclass.","}");
	$str=str_replace("{@zsclass.".$mylabel."}",zsclass($mylabel),$str);
	}
}
if (strpos($str,"{@dlclass.")!==false) {
	$n=count(explode("{@dlclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@dlclass.","}");
	$str= str_replace("{@dlclass.".$mylabel."}",dlclass($mylabel),$str);
	}
}
if (strpos($str,"{@dlshow.")!==false) {
	$n=count(explode("{@dlshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@dlshow.","}");
	$str= str_replace("{@dlshow.".$mylabel."}",dlshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@zxshow.")!==false) {
	$n=count(explode("{@zxshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zxshow.","}");
	$str=str_replace("{@zxshow.".$mylabel."}",zxshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@zxclass.")!==false) {
	$n=count(explode("{@zxclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zxclass.","}");
	$str=str_replace("{@zxclass.".$mylabel."}",zxclass($mylabel),$str);
	}
}
if (strpos($str,"{@helpshow.")!==false) {
	$n=count(explode("{@helpshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@helpshow.","}");
	$str=str_replace("{@helpshow.".$mylabel."}",helpshow($mylabel),$str);
	}
}
if (strpos($str,"{@linkshow.")!==false) {
	$n=count(explode("{@linkshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@linkshow.","}");
	$str=str_replace("{@linkshow.".$mylabel."}",linkshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@linkclass.")!==false) {
	$n=count(explode("{@linkclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@linkclass.","}");
	$str=str_replace("{@linkclass.".$mylabel."}",linkclass($mylabel),$str);
	}
}
if (strpos($str,"{@adshow.")!==false) {
	$n=count(explode("{@adshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@adshow.","}");
	$str=str_replace("{@adshow.".$mylabel."}",adshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@aboutshow.")!==false) {
	$n=count(explode("{@aboutshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@aboutshow.","}");
	$str=str_replace("{@aboutshow.".$mylabel."}",aboutshow($mylabel),$str);
	}
}
return $str;
}


function writecache($channel,$classid,$labelname,$str){//$classid,$labelname 这两个参数在外部函数的参数里，没有在函数内部无法通过global获取到。
global $siteskin,$provincezm;
	if ($classid!='empty' && $classid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$classid."-".$labelname.".txt";
	}elseif($provincezm<>''){//area.php中调用zs,dl,company三个频道中用到这个条件。
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$provincezm."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/".$channel)) {mkdir(zzcmsroot."cache/".$siteskin."/".$channel,0777,true);}
	//echo zzcmsroot."cache/".$siteskin."/".$channel;
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);	
}

function zsshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."cache/".$siteskin."/zs/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."cache/".$siteskin."/zs/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/zsshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zsshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
$bigclassid=$f[1];
	if ($classid <> "") {//不为空的情况是嵌套在zsclass中时，接收的大类值。
	$bigclassid = $classid; //使大类值等于接收到的值
	$smallclassid = "empty"; //以下有条件判断，此处必设值
	}else{
	$bigclassid =$f[1];
	$smallclassid = $f[2];
	}
$groupid =$f[3];$pic =$f[4];$flv =$f[5];$elite = $f[6];$numbers = $f[7];$orderby =$f[8];$titlenum = $f[9];$row = $f[10];$start =$f[11];$mids = $f[12];
$mids = str_replace("show.php?id={#id}", "/zs/show.php?id={#id}",$mids);
	if (whtml == "Yes") {
	$mids = str_replace("/zs/show.php?id={#id}", "/zs/show-{#id}.htm",$mids);
	}
	if(sdomain=="Yes" ){
	$mids = str_replace("/zs/show-{#id}.htm","http://{#editor}.".substr(siteurl,strpos(siteurl,".")+1),$mids);
	}
$ends = $f[13];
$sql = "select id,proname,prouse,sendtime,img,flv,hit,tz,shuxing_value,bigclasszm,editor from zzcms_main where passed=1 ";
	if ( $bigclassid <> "empty") {$sql = $sql . " and bigclasszm='" . $bigclassid . "'";}
	if ( $smallclassid <> "empty") {$sql = $sql . " and smallclasszm='" . $smallclassid . "'";}
	if ( $groupid <> 0) {$sql = $sql . " and groupid>=$groupid ";}    
	if ( $pic == 1) {$sql = $sql . " and img is not null and img<>'/image/nopic.gif'";}
	if ( $flv == 1) {$sql = $sql . " and flv is not null and flv<>'' ";} 	    
	if ( $elite == 1) {$sql = $sql . " and elite>0";}
	//if ( $province != '') {$sql = $sql . " and province='$province'";}
	if ( $orderby == "hit") {$sql = $sql . " order by hit desc limit 0,$numbers ";
	}elseif ($orderby == "id") {$sql = $sql . " order by id desc limit 0,$numbers ";
	}elseif ($orderby == "sendtime") {$sql = $sql . " order by sendtime desc limit 0,$numbers ";
	}elseif ($orderby == "rand") {
	$rs=mysql_query($sql);
	$r=mysql_num_rows($rs);
		if (!$r){
		$shuijishu=0;
		}else{
		$shuijishu=rand(1,$r-$numbers);
		if ($shuijishu<0){$shuijishu=0;}
		}
	$sql = $sql . " limit $shuijishu,$numbers";
	}
//echo $sql;
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao=1;
$n = 1;
$mids2='';
while($r=mysql_fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#hit}", $r["hit"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#imgbig}",$r["img"],str_replace("{#img}",getsmallimg($r["img"]),str_replace("{#id}", $r["id"],str_replace("{#proname}",cutstr($r["proname"],$titlenum),$mids)))))));
	$mids2 =str_replace("{#editor}", $r["editor"],$mids2);
	$mids2 =str_replace("{#prouse}", cutstr($r["prouse"],$titlenum*5),$mids2);
	$mids2 =str_replace("{#flv}", $r["flv"],$mids2);
	$mids2 =str_replace("{#tz}", $r["tz"],$mids2);
	$mids2 =str_replace("{#bigclasszm}", $r["bigclasszm"],$mids2);//如排行页用来区分不同类别
	
	$shuxing_value = explode("|||",$r["shuxing_value"]);
	for ($a=0; $a< count($shuxing_value);$a++){
	$mids2=str_replace("{#shuxing".$a."}",$shuxing_value[$a],$mids2);
	}
	if ($n==1){
	$mids2=str_replace("display:none","",$mids2);
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
writecache("zs",$classid,$labelname,$str);
}	
return $str;
}//end if file_exists($fpath)==true
}//end if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time)
}

function zsclass($labelname){
global $siteskin;//取外部值，供演示模板用
if (!isset($siteskin)){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/zsclass/".$labelname.".txt";
if (file_exists($fpath)==true){
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$startnumber= $f[1];$numbers = $f[2];$row = $f[3];$start = $f[4];$mids = $f[5];
if ( whtml == "Yes"){
$mids = str_replace("zs.php?b={#classid}", "{#classid}",$mids);
$mids = str_replace("class.php?b={#classid}", "{#classid}.htm",$mids);
}
$ends = $f[6];
$sql ="select * from zzcms_zsclass where parentid='A' and isshow=1 order by xuhao limit $startnumber,$numbers ";
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$i = 1;
$mylabel1="";
$mids3='';
if (count(explode("{@zsshow.",$mids))==2) {
	$mylabel1=strbetween($mids,"{@zsshow.","}");
}
$mylabel2="";
if (count(explode("{@zsshow.",$mids))==3) {
	$mylabel1=strbetween($mids,"{@zsshow.","}");
	$mids2 = str_replace("{@zsshow." . $mylabel1 . "}", "",$mids); //把第一个标签换空,方可找出第二个标签
	$mylabel2=strbetween($mids2,"{@zsshow.","}");
}
while($r=mysql_fetch_array($rs)){	
$zssmallclass_num=strbetween($mids,"{#zssmallclass:","}");
$mids3=$mids3.str_replace("{#zssmallclass:".$zssmallclass_num."}",showzssmallclass($r["classzm"],"",$zssmallclass_num,$zssmallclass_num),str_replace("{@zsshow." . $mylabel2 . "}", zsshow($mylabel2,$r["classzm"]),str_replace("{@zsshow." . $mylabel1 . "}", zsshow($mylabel1,$r["classzm"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classzm"],$mids)))));
$mids3=str_replace("{#i}", $i,$mids3);//类别标签中序号用i，内容标签中用n,以区别开，这样在内容标签中可以调用i
//$str=$str . $mids;
	if ( $row <> "" && $row > 0){
		if ($i % $row == 0) {$mids3 = $mids3 . "</tr>";}
	}
$i = $i + 1;
}
$str = $start.$mids3 . $ends;
}
$str=showlabel($str);//在招商类别标签中加，以招商类别名为分类名的，不同的广告。如{#showad:1,0,no,no,no,0,0,0,招商分类间,{#classid}}
return $str;
}
}

function dlshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/dl/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/dl/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{

$fpath=zzcmsroot."/template/".$siteskin."/label/dlshow/".$labelname.".txt";
if (file_exists($fpath)==true){
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> "") {
$b = $classid;
}else{
$b = $f[1];
}
$numbers = $f[2];$orderby =$f[3];$titlenum = $f[4];$row = $f[5];$start =$f[6];$mids = $f[7];
$mids = str_replace("show.php?id={#id}", "/dl/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/dl/show.php?id={#id}", "/dl/show-{#id}.htm",$mids);}
$ends = $f[8];
$sql = "select id,cp,sendtime,dlsname,tel,saver from zzcms_dl where passed=1 ";
if ( $b <> "empty") {
$sql = $sql ." and bigclassid='$b' ";
}
	if ( $orderby == "hit") {$sql = $sql . " order by hit desc";
	}elseif ($orderby == "id") {$sql = $sql . " order by id desc";
	}elseif ($orderby = "sendtime") {$sql = $sql . " order by sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql;
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao = 1;
$n = 1;
$mids2='';
while($r=mysql_fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#name}", $r["dlsname"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#id}", $r["id"],str_replace("{#cp}",cutstr($r["cp"],$titlenum),$mids)))));
	$mids2=str_replace("{#mobile}",str_replace(substr($r['tel'],3,4),"****",$r['tel']),$mids2);
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<a class=xuhao1>".addzero($xuhao,2)."</a>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<a class=xuhao2>".addzero($xuhao,2)."</a>",$mids2);
	}
	if (strpos($mids,'{#cpimg}')!==false || strpos($mids,'{#cpimgbig}')!==false){
		$sqln = "select id,proname,img,editor from zzcms_main where editor='".$r['saver']."' ";
		$rsn=mysql_query($sqln);
		$rown= mysql_num_rows($rsn);//返回记录数
		if ($rown){
		$rown=mysql_fetch_array($rsn);
		if (sdomain=="Yes"){$mids2= str_replace("{#zturl}","http://".$rown['editor'].".".substr(siteurl,strpos(siteurl,".")+1),$mids2);}
		if (whtml == "Yes") {$mids2 = str_replace("{#zturl}","/zs/show-".$rown['id'].".htm",$mids2);}//需要从company目录转到zt}
		$mids2 = str_replace("{#zturl}","/zs/show.php?id=".$rown['id'],$mids2);//需要从company目录转到zt
		$mids2=str_replace("{#cpname}", $rown['proname'],$mids2);
		$mids2=str_replace("{#cpimg}", getsmallimg($rown['img']),$mids2);
		$mids2=str_replace("{#cpimgbig}", $rown['img'],$mids2);
		}
	}
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	writecache("dl",$classid,$labelname,$str);
}
return $str;
}
}
}

function zxshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用,这里的$b为了接收zsclass下大类值
if (!$siteskin){$siteskin=siteskin;}
if ($sid!=0){
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$bid."-".$sid."-".$labelname.".txt";
}elseif ($bid!='empty' && $bid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$bid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/zxshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zxshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($bid <> "") {
$bid = $bid;
}else{
$bid= $f[1];
}
if ($sid <> 0) {
$sid = $sid;
}else{
$sid = $f[2];
}
$pic =$f[3];$elite = $f[4];$numbers = $f[5];$orderby =$f[6];$titlenum = $f[7];$cnum = $f[8];$row = $f[9];$start =$f[10];$mids = $f[11];
$mids = str_replace("show.php?id={#id}", "/zx/show.php?id={#id}",$mids);//需要从company目录转到zt
	if (whtml == "Yes") {
	$mids = str_replace("/zx/show.php?id={#id}", "/zx/show-{#id}.htm",$mids);
	$mids = str_replace("/zx/zx.php?b={#bigclassid}&s={#smallclassid}","/zx/{#bigclassid}/{#smallclassid}",$mids);
	$mids = str_replace("/zx/zx.php?b={#bigclassid}","/zx/{#bigclassid}",$mids);
	}
$ends = $f[12];
$sql = "select id,bigclassid,bigclassname,smallclassid,smallclassname,title,link,sendtime,img,editor,hit,content,elite from zzcms_zx where passed=1 ";
if ($b<>'' && is_numeric($b)==false){//接收的zsclass大类值
 $sql = $sql . " and bigclassname='".$b."' ";
	if ($sid<>'empty'){
	$sql = $sql . " and smallclassid='".$sid."' ";//小类不为空时，调用小类，用于zsclass下显示同名大类资讯下的小类资讯
	}
}else{
	if ($bid == 0) {//当大类为0时，取所有显示大类的信息
	$sql = $sql . "and bigclassid in (select classid from zzcms_zxclass where isshowininfo=1 and parentid=0) ";
	}else{
    	if ($bid <> 0) {$sql = $sql . " and bigclassid=".$bid."";}
    	if ($sid <> 0) {$sql = $sql . " and smallclassid=".$sid."";}
	}
}	
 	if ($pic == 1) {$sql = $sql . " and img is not null and img <>''";}
    if ($elite == 1){$sql = $sql . " and elite>0";}
	//$sql = $sql . " order by elite desc,";
	$sql = $sql . " order by ";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;
$xuhao = 1;
$mids2='';
while($r=mysql_fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids)); 
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($r["link"]<>''){//当为外链时
		if (whtml=="Yes"){
		$mids2=str_replace("/zx/show-{#id}.htm",$r["link"],$mids2);
		}else{
		$mids2=str_replace("/zx/show.php?id={#id}",$r["link"],$mids2);
		}
	}
	$mids2=str_replace("{#bigclassname}", $r["bigclassname"],str_replace("{#bigclassid}", $r["bigclassid"],$mids2));
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	$mids2=str_replace("{#smallclassid}", $r["smallclassid"],$mids2);
	$mids2=str_replace("{#smallclassname}", $r["smallclassname"],$mids2);
	$mids2=str_replace("{#hit}", $r["hit"],$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	//if ($r["elite"]>0){
	//$mids2 =str_replace("{#title}" ,cutstr($r["title"],$titlenum)."<img alt='置顶' src='/image/ding.gif' border='0'>",$mids2) ;
	//}else{
	//$mids2 =str_replace("{#title}" ,cutstr($r["title"],$titlenum),$mids2) ;
	//}
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	if ($sid!=0){
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$bid."-".$sid."-".$labelname.".txt";
	}elseif ($bid!='empty' && $bid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$bid."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/zx")) {mkdir(zzcmsroot."cache/".$siteskin."/zx");}
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);
}
return $str;
}
}
}

function zxclass($labelname){
global $b,$siteskin;
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/zxclass/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zxclass/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$startnumber = $f[1];$numbers = $f[2];$row = $f[3];$start = $f[4];$mids = $f[5];

$mids = str_replace("zx.php?b={#bigclassid}","/zx/zx.php?b={#bigclassid}",$mids);//后有小类的同样会被转换前面加/

if ( whtml == "Yes"){
$mids = str_replace("/zx/zx.php?b={#bigclassid}&s={#smallclassid}","/zx/{#bigclassid}/{#smallclassid}",$mids);
$mids = str_replace("/zx/zx.php?b={#bigclassid}","{#bigclassid}",$mids);
}
$ends = $f[6];
if ($b<>""){
$sql ="select * from zzcms_zxclass where  parentid=".$b." order by xuhao limit $startnumber,$numbers ";
}else{
$sql ="select * from zzcms_zxclass where  isshowininfo=1 and parentid=0 order by xuhao limit $startnumber,$numbers ";
}
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$i = 1;
$mids3='';
$mylabel1="";
$mylabel2="";
if (count(explode("{@zxshow.",$mids))==2) {
	$mylabel1=strbetween($mids,"{@zxshow.","}");
}
if (count(explode("{@zxshow.",$mids))==3) {
	$mylabel1=strbetween($mids,"{@zxshow.","}");
	$mids2 = str_replace("{@zxshow." . $mylabel1 . "}", "",$mids); //把第一个标签换空,方可找出第二个标签
	$mylabel2=strbetween($mids2,"{@zxshow.","}");
}
while($r=mysql_fetch_array($rs)){
if ($b<>""){//父类不为空，调出的classid为小类
$mids3=$mids3.str_replace("{@zxshow." . $mylabel1 . "}", zxshow($mylabel1,$b,$r["classid"]),$mids);//注意这里用首次替换已把$mids赋值给$mids3了，	
$mids3=str_replace("{@zxshow." . $mylabel2 . "}", zxshow($mylabel2,$b,$r["classid"]),$mids3);//这里替换$mids3里的内容
$mids3=str_replace("{#classname}",$r["classname"],$mids3);
$mids3=str_replace("{#bigclassid}",$b,$mids3);
$mids3=str_replace("{#smallclassid}",$r["classid"],$mids3);
}else{//父类为空，只调出的为大类就行了
$mids3=$mids3.str_replace("{@zxshow." . $mylabel1 . "}", zxshow($mylabel1,$r["classid"],0),$mids);	
$mids3=str_replace("{@zxshow." . $mylabel2 . "}", zxshow($mylabel2,$r["classid"],0),$mids3);
$mids3=str_replace("{#classname}",$r["classname"],$mids3);
$mids3=str_replace("{#bigclassid}",$r["classid"],$mids3);
}
$mids3=str_replace("{#i}", $i,$mids3);//类别标签中序号用i，内容标签中用n,以区别开，这样在内容标签中可以调用i
//$str=$str . $mids;
	if ( $row <> "" && $row > 0){
		if ($i % $row == 0) {$mids3 = $mids3 . "</tr>";}
	}
$i = $i + 1;
}
$str = $start .$mids3. $ends;
}
return $str;
}
}

function helpshow($labelname){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/helpshow/".$labelname.".txt";
if (file_exists($fpath)==true){
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$elite = $f[1];$numbers = $f[2];$orderby =$f[3];$titlenum = $f[4];$cnum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("help.php#{#id}", "/one/help.php#{#id}",$mids);//需要从company目录转到zt
	if (whtml == "Yes") {
	$mids = str_replace("/one/help.php#{#id}", "/help.htm#{#id}",$mids);
	}
$ends = $f[9];
$sql = "select id,title,sendtime,img,content,elite from zzcms_help where classid=1";
    if ($elite == 1){$sql = $sql . " and elite>0";}
	//$sql = $sql . " order by elite desc,";
	$sql = $sql . " order by ";
	if ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;
$xuhao = 1;
$mids2='';
while($r=mysql_fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids));   
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($cnum==0){
	$mids2=str_replace("{#content}",$r["content"],$mids2);
	}else{
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	}
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function linkshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/linkshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/linkshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid<>""){
$bigclassid=$classid;
}else{
$bigclassid=$f[1];
}
$pic =$f[2];$elite = $f[3];$numbers = $f[4];$titlenum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];$ends = $f[9];
$sql = "select * from zzcms_link where passed=1 ";
if ($bigclassid <> 0 ){$sql = $sql ." and bigclassid=" . $bigclassid . "";}
if ($pic == 1) {$sql = $sql . " and logo is not null and logo <>''";}
if ($elite == 1){$sql = $sql . " and elite>0";}
$sql = $sql . " limit 0,$numbers ";
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2 ='';
$n = 1;
$xuhao=1;
while($r=mysql_fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#url}",$r["url"],str_replace("{#logo}", $r["logo"],str_replace("{#sitename}",cutstr($r["sitename"],$titlenum),$mids)));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<a class=xuhao1>".addzero($xuhao,2)."</a>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<a class=xuhao2>".addzero($xuhao,2)."</a>",$mids2);
	}
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function linkclass($labelname){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/linkclass/".$labelname.".txt";
if (file_exists($fpath)==true){
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$startnumber=$f[1];$numbers = $f[2];$row = $f[3];$start = $f[4];$mids = $f[5];
if ( whtml == "Yes"){
$mids = str_replace("link.php?b={#classid}", "/one/link/{#classid}",$mids);
}
$ends = $f[6];
$sql ="select * from zzcms_linkclass  order by xuhao limit $startnumber,$numbers ";
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$i = 1;
$mylabel1="";
$mids3='';
if (count(explode("{@linkshow.",$mids))==2) {
	$mylabel1=strbetween($mids,"{@linkshow.","}");
}
$mylabel2="";
if (count(explode("{@linkshow.",$mids))==3) {
	$mylabel1=strbetween($mids,"{@linkshow.","}");
	$mids2 = str_replace("{@linkshow." . $mylabel1 . "}", "",$mids); //把第一个标签换空,方可找出第二个标签
	$mylabel2=strbetween($mids2,"{@linkshow.","}");
}
while($r=mysql_fetch_array($rs)){	
$mids3=$mids3.str_replace("{@linkshow." . $mylabel2 . "}", linkshow($mylabel2,$r["bigclassid"]),str_replace("{@linkshow." . $mylabel1 . "}", linkshow($mylabel1,$r["bigclassid"]),str_replace("{#classname}",$r["bigclassname"],str_replace("{#classid}",$r["bigclassid"],$mids))));
//$str=$str . $mids;
	if ( $row <> "" && $row > 0){
		if ($i % $row == 0) {$mids3 = $mids3 . "</tr>";}
	}
$i = $i + 1;
}
$str = $start.$mids3.$ends;
}
return $str;
}
}

function adshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/adshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/adshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($b){//自动获取外部大类值的情况
$bid = $b;//大类用外部的值
$sid = $f[2];//小类用指定的类别名，用户招商分类页，自动根据大类参数调用相应大类下的小类，小类名要相同
}elseif ($bid <> "" && $sid<>""){//套在adclass里面使用时
$bid = $bid;
$sid = $sid;
}else{
$bid = $f[1];
$sid = $f[2];
}
$numbers = $f[3];$titlenum = $f[4];$row = $f[5];$start =$f[6];$mids = $f[7];$ends = $f[8];
$sql= "select * from zzcms_ad where bigclassname='".$bid."' and smallclassname='".$sid."' ";
if (isshowad_when_timeend=="No"){
$sql=$sql. "and endtime>= '".date('Y-m-d H:i:s')."' ";
}
$sql=$sql. "order by xuhao asc,id asc";
$sql=$sql." limit 0,$numbers ";
//echo $sql;
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2='';
$n = 1;
while($r=mysql_fetch_array($rs)){
$mids2 =$mids2 .str_replace("{#link}", $r["link"],str_replace("{#n}", addzero($n,2),str_replace("{#title}",cutstr($r["title"],$titlenum),$mids)));
	$mids2 =str_replace("{#width}",$r["imgwidth"],$mids2);
	$mids2 =str_replace("{#height}",$r["imgheight"],$mids2);
	$mids2 =str_replace("{#titlecolor}",$r["titlecolor"],$mids2);
	if (($n + 4) % 8 == 0 || ($n + 5) % 8 == 0 ||  ($n + 6) % 8 == 0 ||  ($n + 7) % 8 == 0){
	$mids2 =str_replace("{#style}","textad1",$mids2);
	}else{
	$mids2 =str_replace("{#style}","textad2",$mids2);
	}
	if (strpos($labelname,"flash")!==false || strpos($labelname,"Flash")!==false){//没有加新参数，命名时焦点广告名里要有flash
	//焦点flash不支持远程，只能用相对路经，这样才能同时在www.或是没有www.两种域名下显示
	$mids2 = str_replace("{#img}",$r["img"],$mids2);
	}else{
	$mids2 = str_replace("{#img}",siteurl.$r["img"],$mids2);//当展厅开二级域名的情况下，前面必须得加网址
	}
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function aboutshow($labelname){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."cache/".$siteskin."/about/".$labelname.".txt";
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."template/".$siteskin."/label/aboutshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/aboutshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$id=$f[1];$titlenum = $f[2];$contentnum = $f[3];$row = $f[4];$start =$f[5];$mids = $f[6];$ends = $f[7];
$sql = "select * from zzcms_about  ";
if ($id <> 0 ){$sql = $sql ."where id='" . $id . "'";}
$sql = $sql ." order by id asc";
//echo $sql;
$rs=mysql_query($sql);
$r=mysql_num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2 ='';
$n = 1;
while($r=mysql_fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#title}",cutstr($r["title"],$titlenum),$mids);
	$mids2=str_replace("{#content}", cutstr($r["content"],$contentnum),$mids2);
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	writecache("about",'',$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time)
}
?>