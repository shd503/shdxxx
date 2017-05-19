<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择产品类别！");
	document.myform.bigclassid.focus();
	return false;
  }
  if (document.myform.cpname.value==""){
    alert("产品名称不能为空！");
	document.myform.cpname.focus();
	return false;
  }
  if (document.myform.prouse.value==""){
    alert("产品特点不能为空！");
	document.myform.prouse.focus();
	return false;
  }
}
</script>   
<div class="admintitle">修改商机</div>
<form action="zs_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
<?php
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_main where id='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">名称 <font color="#FF0000">*</font></td>
      <td width="82%" class="border"> <input name="cpname" type="text" id="cpname" value="<?php echo $row["proname"]?>" size="45" maxlength="50">      </td>
    </tr>
    <tr> 
      <td width="18%" align="right" class="border"> 所属类别 <font color="#FF0000">*</font></td>
      <td class="border"> 
        <?php
$sqlS = "select * from zzcms_zsclass where parentid<>'A' order by xuhao asc";
$rsS=mysql_query($sqlS);
?>
        <script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($rowS = mysql_fetch_array($rsS)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($rowS["classname"])?>","<?php echo trim($rowS["parentid"])?>","<?php echo trim($rowS["classzm"])?>");
        <?php
        $count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;

function changelocation(locationid) {
    document.myform.smallclassid.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++){
            if (subcat[i][1] == locationid){ 
                document.myform.smallclassid.options[document.myform.smallclassid.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
    }
}</script> 
<select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sqlB = "select * from zzcms_zsclass where  parentid='A' order by xuhao asc";
    $rsB=mysql_query($sqlB);
	while($rowB = mysql_fetch_array($rsB)){
	?>
          <option value="<?php echo trim($rowB["classzm"])?>" <?php if ($rowB["classzm"]==$row["bigclasszm"]) { echo "selected";}?>><?php echo trim($rowB["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php
$sqlS="select * from zzcms_zsclass where parentid='" .$row["bigclasszm"]."' order by xuhao asc";
$rsS=mysql_query($sqlS);
while($rowS = mysql_fetch_array($rsS)){
?>
          <option value="<?php echo $rowS["classzm"]?>" <?php if ($rowS["classzm"]==$row["smallclasszm"]) { echo "selected";}?>><?php echo $rowS["classname"]?></option>
          <?php 
}
?>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border">特点<font color="#FF0000"> *</font></td>
      <td class="border"> <textarea name="prouse" cols="60" rows="3" id="prouse"><?php echo $row["prouse"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >投资额度 <font color="#FF0000">*</font></td>
      <td class="border" >
	  <select name="tz" id="tz">
                <option value="1万以下" <?php if($row["tz"]=='1万以下'){ echo 'selected';}?>>1万以下</option>
                <option value="1-10万" <?php if($row["tz"]=='1-10万'){ echo 'selected';}?>>1-10万</option>
                <option value="10-20万" <?php if($row["tz"]=='10-20万'){ echo 'selected';}?>>10-20万</option>
                <option value="20-50万" <?php if($row["tz"]=='20-50万'){ echo 'selected';}?>>20-50万</option>
                <option value="50-100万" <?php if($row["tz"]=='50-100万'){ echo 'selected';}?>>50-100万</option>
                <option value="100万以上" <?php if($row["tz"]=='100万以上'){ echo 'selected';}?>>100万以上</option>
            </select>	  </td>
    </tr>
    <tr class="border" >
      <td align="right" class="border">所在地区：</td>
      <td class="border">
	  <select name="province" id="province">
            </select>
              <select name="city" id="city">
              </select>
              <select name="xiancheng" id="xiancheng">
              </select>
              <script src="/js/area.js"></script>
              <script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
              </script>	   </td>
    </tr>
     <?php
	if (shuxing_name!=''){
	$shuxing_name = explode("|",shuxing_name);
	$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($i=0; $i< count($shuxing_name);$i++){
	?>
	<tr>
      <td align="right" class="border" ><?php echo $shuxing_name[$i]?>：</td>
      <td class="border" ><input name="sx[]" type="text" value="<?php echo @$shuxing_value[$i]?>" size="45"></td>
    </tr>
	<?php
	}
	}
	?>
	<tr> 
      <td align="right" class="border">产品说明：</td>
      <td class="border">

		<textarea name="sm" id="sm">
			<?php 
$fp="../web/".$row["editor"]."/index.htm";
if (file_exists($fp)) {			
$f = fopen($fp,'r');
$sm = fread($f,filesize($fp));
fclose($f);
echo $sm;
}else{
echo $row["sm"];
}
			
			?></textarea>	
 <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>	  </td>
    </tr>
    <tr> 
      <td align="right" class="border">封面图片： 
 <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>" size="45">      </td>
      <td class="border"> <table height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td width="120" align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
              <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  } 
				  ?>		    </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">视频地址：</td>
      <td class="border"> <input name="flv" type="text" id="flv" value="<?php echo $row["flv"]?>" size="45"></td>
    </tr>
    <tr> 
      <td align="right" class="border">发布人：</td>
      <td class="border"><input name="editor" type="text" id="editor" value="<?php echo $row["editor"]?>" size="45"> 
        <input name="oldeditor" type="hidden" id="oldeditor" value="<?php echo $row["editor"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($row["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr>
      <td align="right" class="border">推荐值：</td>
      <td class="border"><input name="elite" type="text" id="elite" value="<?php echo $row["elite"]?>" size="4" maxlength="3">
        (0-127之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit2" value="修 改"> <input name="cpid" type="hidden" id="cpid" value="<?php echo $row["id"]?>"> 
        <input name="sendtime" type="hidden" id="sendtime" value="<?php echo $row["sendtime"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>"></td>
    </tr>
	 <tr> 
      <td colspan="2" class="admintitle2">SEO设置</td>
    </tr>
	
    <tr>
      <td align="right" class="border" >标题（title）</td>
      <td class="border" ><input name="title" type="text" id="title" value="<?php echo $row["title"] ?>" size="60" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border" >关键词（keywords）</td>
      <td class="border" ><input name="keyword" type="text" id="keyword" value="<?php echo $row["keywords"] ?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr>
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="discription" type="text" id="discription" value="<?php echo $row["description"] ?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit2" value="修 改"></td>
    </tr>
  </table>
</form>
</body>
</html>