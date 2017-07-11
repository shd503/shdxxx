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
<div class="admintitle">代理管理员信息管理</div>
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
    mysql_close($conn);
    ?>
</table>
</body>
</html>