<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="style/<?php echo siteskin_usercenter?>/style_mobile.css" rel="stylesheet" type="text/css">
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
<div class="main">
    <?php
    include("top_mobile.php");
    ?>
    <div class="pagebody">
<!--        <div class="left">-->
            <?php
            $sql="select * from zzcms_main where editor='" .$username. "'";
            $rs = mysql_query($sql);
            $row = mysql_fetch_array($rs);
            ?>
            <div class="content">
                <div class="admintitle">发商机</div>
                <form action="zssave_mobile.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="30%" align="right" class="border2" >项目<font color="#FF0000">*</font>：</td>
                            <td  class="border" > <input name="name" type="text" id="name" class="biaodan" value="<?php echo $row["proname"]?>" size="25" maxlength="40" >
                                <br>
                                (只能写产品名称)</td>
                        </tr>
                        <tr>
                            <td align="right"  class="border2" ><br>类别<font color="#FF0000">*</font>：</td>
                            <td class="border2" > <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                    <tr>
                                        <td> <fieldset class="fieldsetstyle">
                                                <legend>所属大类</legend>
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
                                                echo "<fieldset class='fieldsetstyle'><legend>所属小类</legend>";
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
                            <td align="right" class="border2" >简介<font color="#FF0000">*</font>：</td>
                            <td class="border2" > <textarea name="gnzz" cols="30" rows="4" id="gnzz"><?php echo $row["prouse"]?></textarea>            </td>
                        </tr>

                        <tr>
                            <td align="right" class="border2">所在地区：</td>
                            <td class="border2"><select name="province" id="province"></select>
                                <select name="city" id="city"></select>
                                <select name="xiancheng" id="xiancheng"></select>
                                <script src="/js/area_mobile.js"></script>
                                <?php
                                $sqln="select province,city,xiancheng from zzcms_user where username='" .$username. "'";
                                $rsn=mysql_query($sqln);
                                $rown=mysql_fetch_array($rsn);
                                ?>
                                <script type="text/javascript">
                                    new PCAS('province', 'city', 'xiancheng', '<?php echo $rown['province']?>', '<?php echo $rown["city"]?>', '<?php echo $rown["xiancheng"]?>');
                                </script></td>

                        </tr>
                        <tr>
                            <td align="right" class="border2">具体地址：</td>
                            <td class="border2"> <input name="address" type="text" id="address"  class="biaodan" value="<?php echo $row["address"]?>" size="25" maxlength="40" ></tr>
                        <?php
/*                        if (shuxing_name!=''){
                            $shuxing_name = explode("|",shuxing_name);
                            $shuxing_value = explode("|||",$row["shuxing_value"]);
                            for ($i=0; $i< count($shuxing_name);$i++){
                                */?><!--
                                <tr>
                                    <td align="right" class="border" ><?php /*echo $shuxing_name[$i]*/?>：</td>
                                    <td class="border" ><input name="sx[]" type="text" value="<?php /*echo @$shuxing_value[$i]*/?>" size="40" class="biaodan"></td>
                                </tr>
                                --><?php
/*                            }
                        }
                        */?>
                        <tr>
                            <td align="right" class="border" >说明<font color="#FF0000">*</font>：</td>
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
                                <script type="text/javascript" src="/3/kindeditor-4.1.10/kindeditor.js" ></script>
                                <script type="text/javascript" src="/3/kindeditor-4.1.10/lang/zh_CN.js" ></script>
                                <script type="text/javascript">
                                    KindEditor.ready(function(K) {
                                        window.editor = K.create('#sm', {
                                            designMode:true,
                                            cssPath : '.3/kindeditor-4.1.10/plugins/code/prettify.css',
                                            uploadJson : '/3/kindeditor-4.1.10/php/upload_json.php',
                                            fileManagerJson : '/3/kindeditor-4.1.10/php/file_manager_json.php',
                                            allowFileManager : true,
                                            resizeType : 0,
                                            allowImageRemote : false,
                                            width : '100%',
                                            height : '100%',
                                            items : ['source','bold','italic','underline','forecolor','image','|', 'fullscreen', 'undo', 'redo',  'copy', 'paste','baidumap'],

                                            afterCreate:function() {this.sync();},
                                            afterBlur : function(){this.sync();}//需要添加的

                                        });
                                        prettyPrint();

                                    });

                                </script>	</td>
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
                                                echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击更换";
                                            }else{
                                                echo "<input name='Submit2' type='button'  value='上传图片'/>";
                                            }
                                            ?>                  </td>
                                    </tr>
                                </table></td>
                        </tr>

                        <tr>
                            <td align="center" class="border2" >&nbsp;</td>
                            <td class="border2" > <input name="cpid" type="hidden" id="cpid" value="<?php echo $row["id"] ?>">

                                <input name="Submit" type="submit" class="buttons" value="保存修改结果"></td>
                        </tr>

                    </table>
                </form>
            </div>
<!--        </div>-->
    </div>
</div>
</body>
</html>