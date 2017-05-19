<?php
include("../inc/conn.php");
$editor=$_REQUEST["editor"];
mysql_query("update zzcms_main set hit=hit+1 where editor='".$editor."'")
//echo 'document.write("'.$str.'");'; 
?>