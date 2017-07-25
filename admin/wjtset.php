<?php
error_reporting(0); //加新参数后配置文件中，不用加同名空参数了
include("admin.php");
if (isset($_POST["action"])){
    $action=$_POST["action"];
}else{
    $action="";
}
?>
    <html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="admintitle">文件头设置</td>
        </tr>
    </table>
    <?php
    if(checkadminhaspower("siteconfig") =="no") {
        echo "没有操作权限！页面不显示！";
        return;
    }
    
    if ($action=="saveconfig") {
        checkadminisdo("siteconfig");
        saveconfig();
    }else{
        showconfig();
    }

    function showconfig(){
    ?>
    <form method="POST" action="?" id="form1" name="form1">
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr>
                <td width="30%" align="right" class="border">首页</td>
                <td width="70%" class="border">title<br> <input name="sitetitle" type="text" id="sitetitle2" value="<?php echo sitetitle?>" size="50" maxlength="255">
                    <br>
                    keywords<br> <input name="sitekeyword" type="text" id="sitekeyword4" value="<?php echo sitekeyword?>" size="50" maxlength="255">
                    <br>
                    description<br> <input name="sitedescription" type="text" id="sitedescription" value="<?php echo sitedescription?>" size="50" maxlength="255">      </td>
            </tr>
            <tr>
                <td align="right" class="border">招商列表页</td>
                <td class="border"> title<br> <input name="zslisttitle" type="text" id="zslisttitle2" value="<?php echo zslisttitle?>" size="50" maxlength="255">
                    <br>
                    keywords<br> <input name="zslistkeyword" type="text" id="zslistkeyword2" value="<?php echo zslistkeyword?>" size="50" maxlength="255">
                    <br>
                    description<br> <input name="zslistdescription" type="text" id="zslistdescription2" value="<?php echo zslistdescription?>" size="50" maxlength="255"></td>
            </tr>
            <tr>
                <td align="right" class="border">招商信息页</td>
                <td class="border"> title<br> <input name="zsshowtitle" type="text" id="zsshowtitle2" value="<?php echo zsshowtitle?>" size="50" maxlength="255">
                    <br>
                    keywords<br> <input name="zsshowkeyword" type="text" id="zsshowkeyword2" value="<?php echo zsshowkeyword?>" size="50" maxlength="255">
                    <br>
                    description<br> <input name="zsshowdescription" type="text" id="zsshowdescription2" value="<?php echo zsshowdescription?>" size="50" maxlength="255">      </td>
            </tr>
            <tr>
                <td align="right" class="border">资讯列表页</td>
                <td class="border">title<br> <input name="zxlisttitle" type="text" id="zxlisttitle2" value="<?php echo zxlisttitle?>" size="50" maxlength="255">
                    <br>
                    keywords<br> <input name="zxlistkeyword" type="text" id="zxlistkeyword2" value="<?php echo zxlistkeyword?>" size="50" maxlength="255">
                    <br>
                    description<br> <input name="zxlistdescription" type="text" id="zxlistdescription2" value="<?php echo zxlistdescription?>" size="50" maxlength="255">      </td>
            </tr>
            <tr>
                <td align="right" class="border">资讯信息页</td>
                <td class="border">title<br> <input name="zxshowtitle" type="text" id="zxshowtitle2" value="<?php echo zxshowtitle?>" size="50" maxlength="255">
                    <br>
                    keywords<br> <input name="zxshowkeyword" type="text" id="zxshowkeyword2" value="<?php echo zxshowkeyword?>" size="50" maxlength="255">
                    <br>
                    description<br> <input name="zxshowdescription" type="text" id="zxshowdescription2" value="<?php echo zxshowdescription?>" size="50" maxlength="255">      </td>
            </tr>
            <tr>
                <td align="right" class="border">&nbsp;</td>
                <td class="border"> <input name="submit" type="submit" class="buttons" value=" 保存设置 " >
                    <input name="action" type="hidden" id="action" value="saveconfig"></td>
            </tr>
        </table>
        <?php
        }
        ?>
    </form>
    </body>
    </html>
<?php
function SaveConfig(){
    $fpath="../inc/wjt.php";
    $fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
    $fcontent="<" . "?php\r\n";

    $fcontent=$fcontent. "define('sitetitle','". trim($_POST['sitetitle'])."') ;//SiteKeywords\n";
    $fcontent=$fcontent. "define('sitekeyword','". trim($_POST['sitekeyword'])."') ;//SiteKeywords\n";
    $fcontent=$fcontent. "define('sitedescription','". trim($_POST['sitedescription'])."') ;//sitedescription\n";
    $fcontent=$fcontent. "define('zslisttitle','". trim($_POST['zslisttitle'])."') ;//zslisttitle\n";
    $fcontent=$fcontent. "define('zslistkeyword','". trim($_POST['zslistkeyword'])."') ;//zslistkeyword\n";
    $fcontent=$fcontent. "define('zslistdescription','". trim($_POST['zslistdescription'])."') ;//zslistdescription\n";
    $fcontent=$fcontent. "define('zsshowtitle','". trim($_POST['zsshowtitle'])."') ;//zsshowtitle\n";
    $fcontent=$fcontent. "define('zsshowkeyword','". trim($_POST['zsshowkeyword'])."') ;//zsshowkeyword\n";
    $fcontent=$fcontent. "define('zsshowdescription','". trim($_POST['zsshowdescription'])."') ;//zsshowdescription\n";

    $fcontent=$fcontent. "define('zxlisttitle','". trim($_POST['zxlisttitle'])."') ;//zxlisttitle\n";
    $fcontent=$fcontent. "define('zxlistkeyword','". trim($_POST['zxlistkeyword'])."') ;//zxlistkeyword\n";
    $fcontent=$fcontent. "define('zxlistdescription','". trim($_POST['zxlistdescription'])."') ;//zxlistdescription\n";
    $fcontent=$fcontent. "define('zxshowtitle','". trim($_POST['zxshowtitle'])."') ;//zxshowtitle\n";
    $fcontent=$fcontent. "define('zxshowkeyword','". trim($_POST['zxshowkeyword'])."') ;//zxshowkeyword\n";
    $fcontent=$fcontent. "define('zxshowdescription','". trim($_POST['zxshowdescription'])."') ;//zxshowdescription\n";

    $fcontent=$fcontent. "?" . ">";
    fputs($fp,$fcontent);//把替换后的内容写入文件
    fclose($fp);
    echo  "<script>alert('设置成功');location.href='?'</script>";
}
?>