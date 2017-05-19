<?php
include("inc/conn.php");
///*
$domain=$_SERVER['HTTP_HOST']; //取得用户所访问的域名全称
$domain2=substr($domain,0,strpos($domain,'.'));//取得地址栏中的二级域名
$domain_zhu=get_zhuyuming($domain);//针对www.为空的情况，判断$domain2<>$domainzhu
if ($domain<>str_replace("http://","",siteurl) && $domain2<>'www' && $domain<>'localhost:8080' && $domain<>'localhost' && $domain2<>$domainz && check_isip($domain)==false){//针对输入IP的情况is_numeric($domain2)
$url = siteurl."/zs/show.php?editor=".$domain2;//手机版如果用二级域名打开，cookie会失效，从而打开的是电脑版
$content=file_get_contents($url);
echo $content;
exit;
}
//*/

include("inc/top_index.php");
include("inc/bottom.php");
include("label.php");
include("zs/subzs.php");
include("inc/fly.php");
$fp=dirname(__FILE__)."/template/".$siteskin."/index.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$fso = fopen($fp,'r');
$strout = fread($fso,filesize($fp));
fclose($fso);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#pagetitle}",sitetitle,$strout);
$strout=str_replace("{#pagekeywords}",sitekeyword,$strout);
$strout=str_replace("{#pagedescription}",sitedescription,$strout);
$strout=str_replace("{#kfqq}",kfqq,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

if (flyadisopen=="Yes") {
$strout=str_replace("{#flyad}",showflyad("首页","漂浮广告"),$strout);
}else{
$strout=str_replace("{#flyad}","",$strout);
}
if (duilianadisopen=="Yes"){
$strout=str_replace("{#duilianad}",Showduilianad("首页","对联广告左侧","对联广告右侧"),$strout);
}else{
$strout=str_replace("{#duilianad}","",$strout);
}
echo  $strout;
?>