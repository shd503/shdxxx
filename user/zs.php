<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
    <script src="/js/gg.js" type="text/javascript"></script>
    <script src="/js/swfobject.js" type="text/javascript"></script>
    <script language = "JavaScript">
        function CheckForm(){
            ischecked=false;
            for(var i=0;i<document.myform.bigclassid.length;i++){
                if(document.myform.bigclassid[i].checked==true)  {
                    ischecked=true ;
                }
            }
            if(document.myform.bigclassid.checked==true){
                ischecked=true ;
            }
            if (ischecked==false){
                alert("请选择类别！");
                return false;
            }
            if (document.myform.name.value==""){
                document.myform.name.focus();
                document.myform.name.value='此处不能为空';
                document.myform.name.select();
                document.myform.name.style.backgroundColor="FFCC00";
                return false;
            }
            if (document.myform.gnzz.value==""){
                document.myform.gnzz.focus();
                document.myform.gnzz.value='此处不能为空';
                document.myform.gnzz.select();
                document.myform.gnzz.style.backgroundColor="FFCC00";
                return false;
            }

            if (document.myform.sm.value==""){
                alert('说明不能为空');
                return false;
            }

            if (document.myform.flv.value != "")//这里输入框不为空
            {
                var FileType = "flv,swf";   //这里是允许的后缀名，注意要小写
                var FileName = document.myform.flv.value
                FileName = FileName.substring(FileName.lastIndexOf('.')+1, FileName.length).toLowerCase(); //这里把后缀名转为小写了，不然一个后缀名会有很多种大小写组合
                if (FileType.indexOf(FileName) == -1){
                    document.myform.flv.focus();
                    document.myform.flv.style.backgroundColor="FFCC00";
                    alert("请填写flv或swf格式的文件地址！");
                    return false;
                }
            }
        }
        function doClick_E(o){
            var id;
            var e;
            for(var i=1;i<=document.myform.bigclassid.length;i++){
                id ="E"+i;
                e = document.getElementById("E_con"+i);
                if(id != o.id){
                    e.style.display = "none";
                }else{
                    e.style.display = "block";
                }
            }
            if(id==0){
                document.getElementById("E_con1").style.display = "block";
            }
        }
    </script>
</head>
<body>

<?php
$sqlu="select initRMB from zzcms_user where username='" .$username. "'";
$rsu=mysql_query($sqlu);
$rowu=mysql_fetch_array($rsu);
$intiRMB=$rowu["initRMB"];
?>

<div class="main">
    <?php
    include("top.php");
    ?>
    <div class="pagebody">
        <div class="left">
            <?php
            include("left.php");
            ?>
        </div>
        <div class="right">
            <?php
            $sql="select * from zzcms_main where editor='" .$username. "'";
            $rs = mysql_query($sql);
            $row = mysql_fetch_array($rs);
            ?>
            <div class="content">
                <div class="admintitle">发商机</div>
                <form action="zssave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td align="right" class="border" >项目名称<font color="#FF0000">（必填）</font>：</td>
                            <td class="border" > <input name="name" type="text" id="name" class="biaodan" value="<?php echo $row["proname"]?>" size="60" maxlength="45" >
                                <br>
                                (只能写产品名称，不要写联系方式等其它内容，否则信息会直接被删除)</td>
                        </tr>
                        <tr>
                            <td width="18%" align="right" valign="top" class="border2" ><br>
                                所属类别 <font color="#FF0000">（必填）</font>：</td>
                            <td width="85%" class="border2" > <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                    <tr>
                                        <td> <fieldset class="fieldsetstyle">
                                                <legend>请选择所属大类</legend>
                                                <?php
                                                $sqlB = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
                                                $rsB = mysql_query($sqlB,$conn);
                                                $n=0;
                                                while($rowB= mysql_fetch_array($rsB)){
                                                    $n ++;
                                                    if ($row['bigclasszm']==$rowB['classzm']){
                                                        echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' checked/><label for='E$n'>$rowB[classname]</label>";
                                                    }else{
                                                        echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' /><label for='E$n'>$rowB[classname]</label>";
                                                    }
                                                }
                                                ?>
                                            </fieldset></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            $sqlB="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
                                            $rsB = mysql_query($sqlB,$conn);
                                            $n=0;
                                            while($rowB= mysql_fetch_array($rsB)){
                                                $n ++;
                                                if ($row["bigclasszm"]==$rowB["classzm"]) {
                                                    echo "<div id='E_con$n' style='display:block;'>";
                                                }else{
                                                    echo "<div id='E_con$n' style='display:none;'>";
                                                }
                                                echo "<fieldset class='fieldsetstyle'><legend>请选择所属小类</legend>";
                                                $sqlS="select * from zzcms_zsclass where parentid='$rowB[classzm]' order by xuhao asc";
                                                $rsS = mysql_query($sqlS,$conn);
                                                $nn=0;
                                                while($rowS= mysql_fetch_array($rsS)){
                                                    $nn ++;
                                                    if ($row['smallclasszm']==$rowS['classzm']){
                                                        echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' checked/>";
                                                    }else{
                                                        echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' />";
                                                    }
                                                    echo "<label for='radio$nn$n'>$rowS[classname]</label>";
                                                    if ($nn % 10==0) {
                                                        echo "<br/>";
                                                    }

                                                }
                                                echo "</fieldset>";
                                                echo "</div>";
                                            }
                                            ?>                  </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >简介<font color="#FF0000"> （必填）</font>：</td>
                            <td class="border2" > <textarea name="gnzz" cols="60" rows="4" id="gnzz"><?php echo $row["prouse"]?></textarea>            </td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >投资额度：</td>
                            <td class="border2" >
                                <select name="tz" id="tz" class="biaodan">
                                    <option value="1万以下" <?php if($row["tz"]=='1万以下'){ echo 'selected';}?>>1万以下</option>
                                    <option value="1-10万" <?php if($row["tz"]=='1-10万'){ echo 'selected';}?>>1-10万</option>
                                    <option value="10-20万" <?php if($row["tz"]=='10-20万'){ echo 'selected';}?>>10-20万</option>
                                    <option value="20-50万" <?php if($row["tz"]=='20-50万'){ echo 'selected';}?>>20-50万</option>
                                    <option value="50-100万" <?php if($row["tz"]=='50-100万'){ echo 'selected';}?>>50-100万</option>
                                    <option value="100万以上" <?php if($row["tz"]=='100万以上'){ echo 'selected';}?>>100万以上</option>
                                </select>			</td>
                        </tr>
                        <tr class="border" >
                            <td align="right" class="border2">所在地区：</td>
                            <td class="border2"><select name="province" id="province"></select>
                                <select name="city" id="city"></select>
                                <select name="xiancheng" id="xiancheng"></select>
                                <script src="/js/area.js"></script>
                                <?php
                                $sqln="select province,city,xiancheng from zzcms_user where username='" .$username. "'";
                                $rsn=mysql_query($sqln);
                                $rown=mysql_fetch_array($rsn);
                                ?>
                                <script type="text/javascript">
                                    new PCAS('province', 'city', 'xiancheng', '<?php echo $rown['province']?>', '<?php echo $rown["city"]?>', '<?php echo $rown["xiancheng"]?>');
                                </script></td>

                        </tr>
                        <tr class="border">
                            <td align="right" class="border2">具体地址：</td>
                            <td class="border2"> <input name="address" type="text" id="address"  class="biaodan" value="<?php echo $row["address"]?>" size="60" maxlength="60" ></tr>
                        <?php
                        if (shuxing_name!=''){
                            $shuxing_name = explode("|",shuxing_name);
                            $shuxing_value = explode("|||",$row["shuxing_value"]);
                            for ($i=0; $i< count($shuxing_name);$i++){
                                ?>
                                <tr>
                                    <td align="right" class="border" ><?php echo $shuxing_name[$i]?>：</td>
                                    <td class="border" ><input name="sx[]" type="text" value="<?php echo @$shuxing_value[$i]?>" size="60" class="biaodan"></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td align="right" class="border" >说明 <font color="#FF0000">（必填）</font>：</td>
                            <td class="border" >
			
<textarea name="sm"  id="sm">
<?php
$fp="../web/".$username."/index.htm";
if (file_exists($fp)) {
    $f = fopen($fp,'r');
    $sm = trim(fread($f,filesize($fp)));
    fclose($f);
    echo $sm;
}else{
    echo $row["sm"];
}
?></textarea>
                                <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
                                <script type="text/javascript">CKEDITOR.replace('sm');</script>	</td>
                        </tr>
                        <tr>
                            <td align="right" class="border" >封面图片：
                                <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"] ?>">
                                <input name="img"type="hidden" id="img" value="<?php echo $row["img"] ?>">            </td>
                            <td class="border" > <table height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                    <tr>
                                        <td width="120" align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)">
                                            <?php
                                            if($row["img"]<>""){
                                                echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
                                            }else{
                                                echo "<input name='Submit2' type='button'  value='上传图片'/>";
                                            }
                                            ?>                  </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="right" class="border" >上传视频：
                                <input name="oldflv" type="hidden" id="oldflv" value="<?php echo $row["flv"] ?>" />
                                <input name="flv" type="hidden" id="flv" value="<?php echo $row["flv"] ?>" /></td>
                            <td class="border" >
                                <?php
                                if (check_user_power("uploadflv")=="yes"){
                                    ?>
                                    <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                        <tr>
                                            <td align="center" bgcolor="#FFFFFF" id="container" onClick="openwindow('/uploadflv_form.php',400,300)">
                                                <?php
                                                if($row["flv"]<>""){
                                                    if (substr($row["flv"],-3)=="flv") {
                                                        ?>
                                                        <script type="text/javascript">
                                                            var s1 = new SWFObject("/image/player.swf","ply","200","200","9","#FFFFFF");
                                                            s1.addParam("allowfullscreen","true");
                                                            s1.addParam("allowscriptaccess","always");
                                                            s1.addParam("flashvars","file=<?php echo $row["flv"] ?>&autostart=false");
                                                            s1.write("container");
                                                        </script>
                                                        <?php
                                                    }elseif (substr($row["flv"],-3)=="swf") {
                                                        echo "<embed src='".$row["flv"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=200 height=200></embed>";
                                                    }
                                                    echo "<br/>点击重新上传视频";
                                                }else{
                                                    echo "<input name='Submit2' type='button'  value='上传视频'/>";
                                                }
                                                ?>                  </td>
                                        </tr>
                                    </table>
                                    <?php
                                }else{
                                    ?>
                                    <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                        <tr align="center" bgcolor="#FFFFFF">
                                            <td id="container" onClick="javascript:window.location.href='vip_add.php'">
                                                <p><img src="../image/jx.gif" width="48" height="48" /><br />
                                                    仅限收费会员</p>
                                                <p><span class='buttons'>现在审请？</span><br />
                                                </p></td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="admintitle" >SEO优化设置（如与产品名称相同，以下可以留空不填）</td>
                        </tr>
                        <tr>
                            <td align="right" class="border" >标题（title）:</td>
                            <td class="border" ><input name="title" type="text" id="title" class="biaodan" onBlur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["title"] ?>" size="60" maxlength="255"></td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >关键词（keywords）:</td>
                            <td class="border2" > <input name="keyword" type="text" id="keyword" class="biaodan" onBlur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["keywords"] ?>" size="60" maxlength="255">
                                (多个关键词以“,”隔开)</td>
                        </tr>
                        <tr>
                            <td align="right" class="border" >描述（description）:</td>
                            <td class="border" ><input name="discription" type="text" id="discription" class="biaodan" onBlur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["description"] ?>" size="60" maxlength="255">
                                (适当出现关键词，最好是完整的句子)</td>
                        </tr>
                        <tr>
                            <td align="center" class="border2" >&nbsp;</td>
                            <td class="border2" > <input name="cpid" type="hidden" id="cpid" value="<?php echo $row["id"] ?>">

                                <input name="Submit" type="submit" class="buttons" value="保存修改结果"></td>
                        </tr>
                        <?php
                        if (background_set == "Yes") {
                        ?>
                        <tr>
                            <td colspan="2" class="admintitle" >页面背景设置</td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >上传背景图片：
                                <input name="oldimg2" type="hidden" id="oldimg2" value="<?php echo $row["bodybg"] ?>">
                                <input name="img2" type="hidden" id="img2" value="<?php echo $row["bodybg"] ?>"/>			</td>
                            <td class="border2" >
                                <script type="text/javascript">
                                    function valueFormOpenwindow2(value){ //子页面引用此函数传回value值,上传图片用
//alert(value);
                                        document.getElementById("img2").value=value;
                                        document.getElementById("showimg2").innerHTML="<img src='"+value+"' width=120>";
                                    }
                                </script>
                                <table height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                    <tr>
                                        <td width="120" align="center" bgcolor="#FFFFFF" id="showimg2" onClick="openwindow('/uploadimg_form.php?imgid=2',400,300)">
                                            <?php
                                            if($row["bodybg"]<>""){
                                                echo "<img src='".$row["bodybg"]."' border=0 width=120 /><br>点击可更换图片";
                                            }else{
                                                echo "<input name='Submit2' type='button'  value='上传图片'/>";
                                            }
                                            ?>                </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >背景图片布局方式：</td>
                            <td class="border2" ><select name="bodybgrepeat" id="bodybgrepeat">
                                    <option value="no-repeat" <?php if($row["bodybgrepeat"]=='no-repeat'){ echo 'selected';}?>>不重复</option>
                                    <option value="repeat" <?php if($row["bodybgrepeat"]=='repeat'){ echo 'selected';}?>>重复</option>
                                    <option value="repeat-x" <?php if($row["bodybgrepeat"]=='repeat-x'){ echo 'selected';}?>>横向重复</option>
                                    <option value="repeat-y" <?php if($row["bodybgrepeat"]=='repeat-y'){ echo 'selected';}?>>纵向重复</option>
                                </select>            </td>
                        </tr>
                        <tr>
                            <td width="18%" align="right" class="border">banner动画效果设置：</td>

                            <td width="85%" height="210" valign="top" class="border">
                                <div id="Layer2" style="position:absolute; width:675px; height:200px; z-index:1; overflow: scroll;">
                                    <table width="95%" border="0" cellspacing="1" cellpadding="5">
                                        <tr>
                                            <?php
                                            $dir = opendir("../flash");
                                            $i=0;
                                            while(($file = readdir($dir))!=false){
                                                if ($file!="." && $file!="..") { //不读取. ..
                                                    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。
                                                    ?>
                                                    <td> <table width="120" border="0" cellpadding="5" cellspacing="1">
                                                            <tr>
                                                                <td align="center" <?php if($row["swf"]==$file){ echo"bgcolor='#FF0000'";}else{ echo "bgcolor='#FFF'";}?> >
                                                                    <embed src="/flash/<?php echo $file?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="120" height="120"></embed></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" bgcolor="#FFFFFF"> <input name="swf" type="radio" id="<?php echo $file?>" value="<?php echo $file?>" <?php if($row["swf"]==$file){ echo"checked";}?>/>
                                                                    <label for="<?php echo $file?>"><?php echo $file?></label></td>
                                                            </tr>
                                                        </table></td>
                                                    <?php
                                                    $i=$i+1;
                                                    if($i % 4==0 ){
                                                        echo"<tr>";
                                                    }
                                                }
                                            }
                                            closedir($dir)
                                            ?>
                                    </table>
                                </div></td></tr>
                        <tr>
                            <td class="border">&nbsp;</td>
                            <td  valign="top" class="border">
                                <input name="Submit22" type="submit" class="buttons" value="保存修改结果" />		    </td>
                        </tr>

                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2" class="admintitle" >支付(首次发布需要支付)</td>
                        </tr>
                        <tr>
                            <td align="right" class="border2" >支付：</td>
                            <td class="border2" >
                                <input type="button" class="buttons" onclick="window.location.href='/codepay/index.php'" value="微信支付">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>