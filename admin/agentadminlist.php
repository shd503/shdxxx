<?php
include("admin.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" src="/js/gg.js"></script>
    <?php

    //checkadminisdo("adminmanage");改密码要用此页，所以在DEL时判断
    if (isset($_REQUEST["action"])){
        $action=$_REQUEST["action"];
    }else{
        $action="";
    }

    if (isset($_SESSION["admin"])) {
        $agentadmin=$_SESSION["admin"];
    }

    /* if ($action=="del" ){
         checkadminisdo("adminmanage");
         mysql_query("delete from zzcms_admin where id='".$_GET["id"]."'");
         echo  "<script>alert('删除成功');location.href='?'</script>";
     }*/

    $sql="select * from zzcms_admin where admin='".$agentadmin."' order by id desc";
    $rs = mysql_query($sql);
    ?>
    <script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<div class="admintitle">推广员信息管理</div>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr>
        <td width="5%" align="center" class="border">ID</td>
        <td width="10%" align="center" class="border">用户名</td>
        <td width="10%" align="center" class="border">所属用户组</td>
        <td width="5%" align="center" class="border">登录次数</td>
        <td width="10%" align="center" class="border">上次登录IP</td>
        <td width="10%" align="center" class="border">上次登录时间</td>
        <td width="10%" align="center" class="border">操 作</td>
    </tr>
    <?php
    while($row= mysql_fetch_array($rs)){
        ?>
        <tr onMouseOver="this.bgColor='#E8E8E8'" onMouseOut="this.bgColor='#FFFFFF'" bgcolor="#FFFFFF">
            <td align="center"><?php echo $row["id"]?></td>
            <td align="center"><?php echo $row["admin"]?></td>
            <td align="center">

                <?php
                $rsn=mysql_query("select groupname from zzcms_admingroup where id='".$row['groupid']."'");
                $r=mysql_num_rows($rsn);
                if ($r){
                    $r=mysql_fetch_array($rsn);
                    echo $r["groupname"];
                }
                ?><br>
                <a href="admingroupmodify.php?id=<?php echo $row["groupid"]?>">查看此组权限</a></td>
            <td align="center"><?php echo $row["logins"]?></td>
            <td align="center"><?php echo $row["showloginip"]?></td>
            <td align="center"><?php echo $row["showlogintime"]?></td>
            <td align="center">
                <a href="adminpwd.php?admins=<?php echo $row["admin"]?>">修改密码</a>
            </td>
        </tr>
        <?php
    }
//    mysql_close($conn);
    ?>
</table>
<?php
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;


$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$keyword2=isset($_REQUEST["keyword2"])?$_REQUEST["keyword2"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'regdate';


?>
<div ><br><br></div>
<div class="admintitle">下级推广员信息查看</div>
<form name="form1" method="post" action="?">
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td class="border">
                <input name="kind" id="username" type="radio" value="username" <?php if ($kind=="username") { echo "checked";}?> >
                <label for="username">按下级推广员</label>

                <input type="radio" name="kind" value="regdate" id="regdate" <?php if ($kind=="regdate") { echo "checked";}?>>
                <label for="regdate">按注册日期</label>

                <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>" size="25" maxlength="255"> --
                <input name="keyword2" type="text" id="keyword2" value="<?php echo $keyword2?>" size="25" maxlength="255">
                <input type="submit" name="Submit2" value="查询">
            </td>
        </tr>

    </table>
</form>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
//$sql="select count(*) as total from zzcms_user where id<>0  ";
$sql="select count(*) as total from zzcms_user user,zzcms_admin admin where admin.admin=user.agentadmin and admin.parent='".$agentadmin."'";
$sql2='';


if ($keyword<>"") {
    switch ($kind){
        case "username";
            $sql2=$sql2. " and username like '%".$keyword."%' ";
            break;

        case "regdate";
            if($keyword2<>"") {
                $sql2=$sql2. " and regdate between '".$keyword."' and '".$keyword2."'";
            }else{
                $sql2=$sql2. " and regdate like '%".$keyword."%'";
            }
            break;
        default:
            $sql2=$sql2. " and username like '%".$keyword."%'";
    }
}

$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];

$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_user user,zzcms_admin admin where admin.admin=user.agentadmin and admin.parent='".$agentadmin."'";
$sql=$sql .$sql2;
$sql=$sql . " order by user.regdate  desc limit $offset,$page_size";

$rs = mysql_query($sql);
if(!$totlenum){
    echo "暂无信息";
}else{

?>

<table width="100%" border="0" cellpadding="2" cellspacing="1">
    <tr class="title">
        <td width="8%" align="center" class="border">用户名</td>
        <td width="10%" align="center" class="border">公司名称</td>
        <td width="4%" align="center" class="border">注册时间</td>
        <td width="3%" align="center" class="border">初始支付</td>
        <td width="5%" align="center" class="border">下级推广员</td>

    </tr>
    <?php
    while($row = mysql_fetch_array($rs)){
        ?>
        <tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'">
            <td align="left">
                <?php
                echo str_replace($keyword,"<font color=red>".$keyword."</font>",$row["username"]);

                ?>
            </td>
            <td>
                <?php if ($row["comane"]<>"") {
                    echo  str_replace($keyword,"<font color=red>".$keyword."</font>",$row["comane"]);
                }else{
                    echo  "个人用户";
                }
                ?>
            </td>

            <td align="center" title="<?php echo $row["regdate"]?>"><?php echo date("Y-m-d H:i:s",strtotime($row["regdate"]))?></td>
            <td align="center"><?php echo $row["initRMB"]?></td>
            <td align="center"><?php echo $row["agentadmin"]?></td>

        </tr>
        <?php
    }
    ?>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
    <tr>
        <td height="30" align="center">	页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong>
            <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
            <?php

            if ($page<>1) {
                echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=1'>首页</a>】 ";
                echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】 ";
            }else{
                echo "【首页】【上一页】";
            }
            if ($page<>$totlepage) {
                echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】 ";
                echo "【<a href='?px=".$px."&usersf=".$usersf."&kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】 ";
            }else{
                echo "【下一页】【尾页】";
            }
            ?>
        </td>
    </tr>
</table>
<?php
}
mysql_close($conn);
?>
</body>
</html>