<?php
$editor=trim($_REQUEST["editor"]);
if (isset($_COOKIE["zzcmseditor"])){
	if ($editor<>$_COOKIE["zzcmseditor"]){
	setcookie("zzcmseditor",$editor.",".$_COOKIE["zzcmseditor"],time()+3600*24*360,"/");//setcookie() 函数必须位于 <html> 标签之前。
	}else{
	setcookie("zzcmseditor",$editor,time()+3600*24*360,"/");
	}
}else{
setcookie("zzcmseditor",$editor,time()+3600*24*360,"/");
}
?>