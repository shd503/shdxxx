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
    <title>修改注册信息</title>
    <link href="style/<?php echo siteskin_usercenter?>/style_mobile.css" rel="stylesheet" type="text/css">
    <script src="/js/gg.js" type="text/javascript"></script>
    <script src="/js/swfobject.js" type="text/javascript"></script>
    <script>
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
            if (document.myform.content.value=="") {
                alert("请填写公司简介！");
                document.myform.content.focus();
                return false;
            }
            if (document.myform.content.value=="该公司暂无简介信息"){
                alert("请填写公司简介！");
                document.myform.content.focus();
                return false;
            }
//定义正则表达式部分
            var strP=/^\d+$/;
            if(!strP.test(document.myform.qq.value)  && document.myform.qq.value!="") {
                alert("QQ只能填数字！");
                document.myform.qq.focus();
                return false;
            }
            if (document.myform.flv.value != "")//这里输入框不为空
            {
                var FileType = "flv,swf";   //这里是允许的后缀名，注意要小写
                var FileName = document.myform.flv.value
                FileName = FileName.substring(FileName.lastIndexOf('.')+1, FileName.length).toLowerCase(); //这里把后缀名转为小写了，不然一个后缀名会有很多种大小写组合
                if (FileType.indexOf(FileName) == -1)
                {
                    document.myform.flv.focus();
                    document.myform.flv.style.backgroundColor="FFCC00";
                    alert("请填写flv或swf格式的文件地址！");
                    return false;
                }
            }
        }
    </script>
</head>
<body>
<?php
$founderr=0;
$errmsg="";
$sql="select * from zzcms_user where username='" .$username. "'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);

if (isset($_REQUEST['action'])){
    $action=$_REQUEST['action'];
}else{
    $action="";
}

if ($action=="modify") {
    $sex=trim($_POST["sex"]);
    $email=trim($_POST["email"]);
    $qq=trim($_POST["qq"]);
    if(!empty($_POST['qqid'])){
        $qqid=$_POST['qqid'][0];
    }else{
        $qqid="";
    }

    $homepage=trim($_POST["homepage"]);
    //comane=trim($_POST["qomane"])
    $content=rtrim($_POST["content"]);
    $img=trim($_POST["img"]);
    $oldimg=trim($_POST["oldimg"]);
    if (isset($_POST["flv"])){
        $flv=trim($_POST["flv"]);
    }else{
        $flv="";
    }
    if (isset($_POST["oldflv"])){
        $oldflv=trim($_POST["oldflv"]);
    }else{
        $oldflv="";
    }
    $province=trim($_POST["province"]);
    $city=trim($_POST["city"]);
    $xiancheng=trim($_POST["xiancheng"]);
    $somane=trim($_POST["somane"]);
    $address=trim($_POST["address"]);
    $mobile=trim($_POST["mobile"]);
    $fox=trim($_POST["fox"]);
    $sex=trim($_POST["sex"]);

    if ($content==""){//为防止输入空格
        $founderr=1;
        $errmsg=$errmsg . "<li>公司简介不能为空</li>";
    }

    $phone=trim($_POST["phone"]);
    if (allowrepeatreg=='no'){
        $rsn=mysql_query("select * from zzcms_user where phone='" . $phone . "' and username!='$username'");
        $r=mysql_num_rows($rsn);
        if ($r){
            $founderr=1;
            $errmsg=$errmsg . "<li>此电话号码已被使用！</li>";
        }
    }

    if ($founderr==1){
        WriteErrMsg($errmsg);
    }else{
        mysql_query("update zzcms_user set content='$content',img='$img',flv='$flv',province='$province',city='$city',xiancheng='$xiancheng',somane='$somane',sex='$sex',phone='$phone',mobile='$mobile',fox='$fox',address='$address',email='$email',qq='$qq',qqid='$qqid',homepage='$homepage' where username='".$username."'");
        if ($oldimg<>$img && $oldimg<>"/image/nopic.gif"){
            $f="../".$oldimg;
            if (file_exists($f)){
                unlink($f);
            }
            $fs="../".str_replace(".","_small.",$oldimg);
            if (file_exists($fs)){
                unlink($fs);
            }
        }
        if ($oldflv<>$flv){
            $f="../".$oldflv;
            if (file_exists($f)==true){
                unlink($f);
            }
        }
        mysql_query("Update zzcms_main set qq='$qq',phone='$phone',mobile='$mobile' where editor='" . $username . "'");
        echo "<SCRIPT language=JavaScript>alert('会员资料修改成功！');location.href='manage_mobile.php'</SCRIPT>";
    }
}else{
    ?>
    <div class="main">
        <?php
        include("top_mobile.php");
        ?>
        <div class="pagebody">
            <div class="left">
               <!-- <?php
/*                include("left.php");
                */?>
            </div>
            <div class="right">-->
                <div class="content">
                    <div class="admintitle">修改注册信息</div>
                    <FORM name="myform" action="?action=modify" method="post" onSubmit="return CheckForm()">
                        <table width=100% border=0 cellpadding=3 cellspacing=1>
                            <tr>
                                <td width="30%" align="right" class="border2">用户名：</td>
                                <td  class="border2"><?php echo $row["username"]?></td>
                            </tr>
                            <tr>
                                <td align="right" class="border2">姓名：</td>
                                <td class="border2"> <INPUT name="somane" class="biaodan" value="<?php echo $row["somane"]?>" size="25" maxLength="50"></td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">性别：</td>
                                <td class="border2"> <INPUT type="radio" value="1" name="sex" <?php if ($row["sex"]==1) { echo "CHECKED";}?>>
                                    男
                                    <INPUT type="radio" value="0" name="sex" <?php if ($row["sex"]==0) { echo "CHECKED";}?>>
                                    女</td>
                            </tr>
                            <tr>
                                <td align="right" class="border2">E-mail：</td>
                                <td class="border2"> <INPUT name="email" class="biaodan" value="<?php echo $row["email"]?>" size="25" maxLength="50">
                                </td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">QQ：</td>
                                <td class="border2"> <INPUT name="qq" id="qq" class="biaodan" value="<?php echo $row["qq"]?>" size="25" maxLength="50"></td>
                            </tr>
                            <tr>
                                <td align="right" class="border2">QQ绑定：</td>
                                <td class="border2">
                                    <?php if ($row["qqid"]<>"") { ?>
                                        <input name="qqid[]" type="checkbox" id="qqid" value="1" checked>
                                        (已绑定。点击可取消绑定)
                                        <?php
                                    }else{
                                        echo "未绑定QQ登录";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">手机：</td>
                                <td class="border2">
                                    <INPUT name="mobile" id="mobile" class="biaodan" value="<?php echo $row["mobile"]?>" size="25" maxLength="50"></td>
                            </tr>
                            <tr >
                                <td align="right" class="border">&nbsp;</td>
                                <td class="border">
                                    <input name="Submit2"   type="submit" class="buttons" id="Submit2" value="保存修改结果"></td>
                            </tr>
                        </table>
                        <div class="admintitle">修改公司信息</div>
                        <table width="100%" border="0" cellpadding="3" cellspacing="1">
                            <tr>
                                <td width="30%" align="right" class="border2">公司名称：</td>
                                <td class="border2"><?php echo $row["comane"]?></td>
                            </tr>
                            <tr class="border" >
                                <td align="right" class="border2">所在地区：</td>
                                <td class="border2"><select name="province" id="province">
                                    </select>
                                    <select name="city" id="city">
                                    </select>
                                    <select name="xiancheng" id="xiancheng">
                                    </select>
                                    <script src="/js/area_mobile.js"></script>
                                    <script type="text/javascript">
                                        new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
                                    </script></td>
                            </tr>
                            <tr>
                                <td align="right" class="border2">公司地址：</td>
                                <td class="border2"> <input name="address" id="address" class="biaodan" value="<?php echo $row["address"]?>" size="25" maxlength="50">
                                </td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">公司网站：</td>
                                <td class="border2"> <INPUT name="homepage" id="homepage" class="biaodan" value="<?php echo $row["homepage"]?>" size="25" maxLength="100"></td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">公司电话：</td>
                                <td class="border2"> <INPUT name="phone" class="biaodan" value="<?php echo $row["phone"]?>" size="25" maxLength="50"></td>
                            </tr>
                            <tr >
                                <td align="right" class="border2">公司传真：</td>
                                <td class="border2"> <INPUT name="fox" class="biaodan" value="<?php echo $row["fox"]?>" size="25" maxLength="50"></td>
                            </tr>
                            <tr>
                                <td align="right" class="border2">公司简介：</td>
                                <td class="border2"> <textarea name="content" cols="30" rows="8" id="content" class="biaodan" style="height:auto"><?php echo $row["content"]?></textarea>
                                </td>
                            </tr>
                            <!--<tr>
                                <td height="50" align="right" class="border"> 公司形象图片：<br> <font color="#666666">
                                        <input name="img" type="hidden" id="img" value="<?php /*echo $row["img"]*/?>">
                                        <input name="oldimg" type="hidden" id="oldimg" value="<?php /*echo $row["img"]*/?>">
                                    </font></td>
                                <td height="50" class="border"> <table width="200" height="200" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                        <tr>
                                            <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)">
                                                <?php
/*                                                if($row["img"]<>"" && $row["img"]<>"/image/nopic.gif"){
                                                    echo "<img src='".$row["img"]."' border=0 width=200 /><br>点击可更换图片";
                                                }else{
                                                    echo "<input name='Submit2' type='button'  value='上传图片'/>";
                                                }
                                                */?>
                                            </td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td align="right" class="border2" >公司形象视频上传：<font color="#666666">

                                        <input name="flv" type="hidden" id="flv" value="<?php /*echo $row["flv"]*/?>" />
                                        <input name="oldflv" type="hidden" id="oldflv" value="<?php /*echo $row["flv"]*/?>">
                                    </font></td>
                                <td class="border2" >
                                    <?php
/*                                    if (check_user_power("uploadflv")=="yes"){
                                        */?>
                                        <table width="200" height="200" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                            <tr>
                                                <td align="center" bgcolor="#FFFFFF" id="container" onClick="openwindow('/uploadflv_form.php',400,300)">
                                                    <?php
/*                                                    if($row["flv"]<>""){
                                                        if (substr($row["flv"],-3)=="flv") {
                                                            */?>
                                                            <script type="text/javascript">
                                                                var s1 = new SWFObject("/image/player.swf","ply","200","200","9","#FFFFFF");
                                                                s1.addParam("allowfullscreen","true");
                                                                s1.addParam("allowscriptaccess","always");
                                                                s1.addParam("flashvars","file=<?php /*echo $row["flv"] */?>&autostart=false");
                                                                s1.write("container");
                                                            </script>
                                                            <?php
/*                                                        }elseif (substr($row["flv"],-3)=="swf") {
                                                            echo "<embed src='".$row["flv"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=200 height=200></embed>";
                                                        }
                                                        echo "<br/>点击重新上传视频";
                                                    }else{
                                                        echo "<input name='Submit2' type='button'  value='添加视频'/>";
                                                    }

                                                    */?>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
/*                                    }else{
                                        */?>
                                        <table width="200" height="200" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                                            <tr align="center" bgcolor="#FFFFFF">
                                                <td id="container" onclick="javascript:window.location.href='vip_add.php'">
                                                    <p><img src="../image/jx.gif" width="48" height="48" /><br />
                                                        仅限收费会员</p>
                                                    <p><span class='buttons'>现在审请？</span><br />
                                                    </p></td>
                                            </tr>
                                        </table>
                                        <?php
/*                                    }
                                    */?>
                                </td>
                            </tr>-->
                            <tr>
                                <td class="border">&nbsp;</td>
                                <td height="40" class="border"> <input name=Submit   type=submit class="buttons" id="Submit" value="保存修改结果">
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
mysql_close($conn);
?>
</body>
</html>