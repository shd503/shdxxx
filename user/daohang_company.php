<?php
include("../inc/conn.php");
include("check.php");
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title></title>
    <link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
//本页用于初次注册本站的公司用户来完善公司信息（公司简介及公司形象图片信息）
if (isset($_REQUEST['action'])){
    $action=$_REQUEST['action'];
}else{
    $action="";
}
if ($action=="modify") {
    $province=trim($_POST["province"]);
    $city=trim($_POST["city"]);
    $xiancheng=trim($_POST["xiancheng"]);
    $address=$_POST["address"];
    $phone=$_POST["phone"];
    $homepage=$_POST["homepage"];
    $personalpage=$_POST["personalpage"];
    $content=rtrim($_POST["content"]);
    $oldcontent=rtrim($_POST["oldcontent"]);
    $img=$_POST["img"];
    $sex=$_POST["sex"];
    $mobile=$_POST["mobile"];
    $qq=$_POST["qq"];
    mysql_query("update zzcms_user set content='$content',img='$img',province='$province',city='$city',xiancheng='$xiancheng',sex='$sex',mobile='$mobile',address='$address',qq='$qq',phone='$phone',homepage='$homepage',personalpage='$personalpage' where username='".$username."'");
    if ($oldcontent=="" || $oldcontent=="该公司暂无简介信息" || $oldcontent=="暂无简介信息"){//只有第一次完善时加分，修改信息不计分，这里需要加验证，不许改为空，防止刷分
        mysql_query("update zzcms_user set totleRMB=totleRMB+".jf_addreginfo." where username='".$username."'");
        mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','完善注册信息','+".jf_addreginfo."','+".jf_addreginfo."','".date('Y-m-d H:i:s')."')");
        echo "<script>alert('成功完善了注册信息，获得".jf_addreginfo."金币')</script>";
    }
    echo"<script language=JavaScript>alert('开始发布商机');location.href='zs.php'</script>";
}else{
    ?>
    <script src="/js/gg.js" type="text/javascript"></script>
    <script language = "JavaScript">
        function CheckForm(){
            if (document.myform.province.value==""){
                alert("请选择公司所在省份！");
                document.myform.province.focus();
                return false;
            }
            if (document.myform.city.value==""){
                alert("请选择公司所在城市！");
                document.myform.city.focus();
                return false;
            }
            if (document.myform.content.value==""){
                alert("请填写公司简介！");
                document.myform.content.focus();
                return false;
            }
            if (document.myform.content.value=="该公司暂无简介信息"){
                alert("请填写公司简介！");
                document.myform.content.focus();
                return false;
            }
            return true;
        }
    </SCRIPT>
    </head>
    <body>
    <div class="main">
        <?php
        include("top.php");
        ?>
        <div class="pagebody" >
            <div class="left">
                <?php
                include("left.php");
                ?>
            </div>
            <div class="right">
                <div class="content">
                    <div class="admintitle">完善注册信息</div>
                    <?php
                    $sql="select * from zzcms_user where username='" .$username. "'";
                    $rs=mysql_query($sql);
                    $row=mysql_fetch_array($rs);

                    if ($row['logins']==0){
                        echo "<div class='box'>您好！<b>".$username."</b>恭喜您成为本站注册会员！<br>请完善您的店家简介信息，以便生成您店家的展厅页面。 </div>";
                    }else{
                        echo "<div class='box'> <font color='#FF0000'><strong>提示：</strong>店家简介信息尚未填写！<br>请完善您的店家简介信息，以提高店家诚信度。</font></div>";
                    }
                    ?>

                    <FORM name="myform" action="?action=modify" method="post" onSubmit="return CheckForm();">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                        <tr>
                                            <td align="right" class="border2">店家所在地： </td>
                                            <td class="border2"><select name="province" id="province"></select>
                                                <select name="city" id="city"></select>
                                                <select name="xiancheng" id="xiancheng"></select>
                                                <script src="/js/area.js"></script>
                                                <script type="text/javascript">
                                                    new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
                                                </script>            </td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border">店家地址：</span></td>
                                            <td class="border"> <input name="address" id="address" tabindex="4" class="biaodan" value="<?php echo $row['address']?>" size="50" maxlength="50">                  </td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border2">电话：</td>
                                            <td class="border2"><input name="phone" id="phone" class="biaodan" value="<?php echo $row['phone']?>" tabindex="12" size="50" maxlength="50" /></td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border2">本站地址：</td>
                                            <td class="border2"> <input name="homepage" id="homepage" class="biaodan" value="<?php if ($row["homepage"]<>'') { echo  $row["homepage"] ;}else{ echo siteurl.getpageurlzs($row['username']);}?>" tabindex="5" size="50" maxlength="100"></td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border2">店家网址：</td>
                                            <td class="border2"> <input name="personalpage" id="personalpage" class="biaodan" value="<?php if ($row["personalpage"]<>'') { echo  $row["personalpage"] ;}?>" tabindex="5" size="50" maxlength="100"></td>
                                        </tr>
                                        <tr>
                                            <td width="17%" align="right" class="border2">店家简介：
                                                <input name="oldcontent" type="hidden" id="oldcontent" value="<?php echo $row["content"]?>"></td>
                                            <td width="83%" class="border2"> <textarea name="content" tabindex="7" cols="80" rows="10" id="content"><?php echo $row["content"]?></textarea>                  </td>
                                        </tr>
                                        <tr>
                                            <td height="50" align="right" class="border">上传店家形象图片：</span><br>
                                                （不要超过<?php echo maximgsize?>K）
                                                <input name="img" type="hidden" id="img" value="/image/nopic.gif" tabindex="8"></td>
                                            <td height="50" class="border"><table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                                    <tr align="center" bgcolor="#FFFFFF">
                                                        <td id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> <input name="Submit2" type="button"  value="上传图片" /></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="border2">联系人性别：</td>
                                            <td class="border2"> <input name="sex" type="radio" tabindex="9" value="1" <?php if ($row["sex"]==1) { echo 'checked';}?>/>
                                                先生
                                                <input name="sex" type="radio" tabindex="10" value="0" <?php if ($row["sex"]==0) { echo 'checked';}?> />
                                                女士</td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border">联系人QQ：</span></td>
                                            <td class="border"> <input name="qq" id="qq" class="biaodan" value="<?php echo $row['qq']?>" tabindex="11" size="30" maxLength="50"></td>
                                        </tr>
                                        <tr >
                                            <td align="right" class="border2">联系人手机：</td>
                                            <td class="border2"> <input name="mobile" id="mobile" class="biaodan" value="<?php echo $row['mobile']?>" tabindex="12" size="30" maxLength="50"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">&nbsp;</td>
                                            <td class="border"> <input name="Submit"  type="submit" class="buttons" id="Submit" value="填好了，提交信息！" tabindex="13">                  </td>
                                        </tr>
                                    </table>

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
    <?php
}
mysql_close($conn);
?>