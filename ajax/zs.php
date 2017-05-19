<?php
session_start();
include("../inc/conn.php");
$last = $_POST['last'];
$amount = $_POST['amount'];
$b=$_SESSION['zs_b'];
$s=$_SESSION['zs_s'];

if (isset($_COOKIE["pxzs"])){
	$px=$_COOKIE["pxzs"];
	}else{
	$px="sendtime";
	}

$sql="select * from zzcms_main where passed=1 ";

if ($b<>""){
$sql=$sql. "and bigclasszm='".$b."' ";
}

if ($s<>"") {
$sql=$sql." and smallclasszm ='".$s."'  ";	
}

$sql=$sql." order by groupid desc,elite desc,".$px." desc limit $last,$amount";

$rs = mysql_query($sql); 
while($row= mysql_fetch_array($rs)){

 $sayList[] = array(
    'title' => "<a href='".getpageurl("zs",$row["id"])."' class='bigbigword2'>".$row['proname']."</a>",
    'img' => "<img src='".getsmallimg($row["img"])."' onload='resizeimg(90,90,this)'>",
    'prouse' => cutstr($row['prouse'],40),
	'companyname' => "<a href='".getpageurl("zt",$row["userid"])."' target='_blank'>".$row["comane"]."</a>",
	'city' => $row["province"].$row["city"]
    );
}
echo json_encode($sayList);
?>