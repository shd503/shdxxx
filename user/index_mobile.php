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
  <title>用户中心</title>
  <?php
  //接收通过此页跳转页的代码
  $gotopage="";
  $canshu="";
  if (isset($_GET["gotopage"])){
    $gotopage=$_GET["gotopage"];
  }
  if (isset($_GET["canshu"])){
    $canshu=$_GET["canshu"];
  }
  if (isset($_GET["b"])){
    $b=$_GET["b"];
  }
  if (isset($_GET["s"])){
    $s=$_GET["s"];
  }
  ?>
  <form action="<?php echo $gotopage;?>" method='post' name='gotopage' target='_self' >
    <input type='hidden' name='canshu' value='<?php echo $canshu;?>' />
  </form>
  <?php
  /* $sql="select * from zzcms_user where username='".@$username."'";
   $rs=mysql_query($sql);
   $row=mysql_fetch_array($rs);
  if ($row["content"]=="" || $row["content"]=="该公司暂无简介信息"){
     echo "<script>location.href='daohang_company.php'</script>";
   }*/
  ?>
  <SCRIPT>
    function gotopage(){
      document.gotopage.submit();
    }
  </SCRIPT>
</head>

<body  <?php if ($gotopage<>""){echo "onLoad='gotopage()'";}?>  >
<div class="main">
  <?php
  include ("top_mobile.php");
  ?>
  <div class="pagebody">
    <div class="left">
      <?php
      $sql="select * from zzcms_message where sendto='' or  sendto='".@$username."'  order by id desc";
      $rs=mysql_query($sql);
      $row=mysql_num_rows($rs);
      if($row){
        $str="<div class='admintitle'>系统信息</div>";
        while ($row=mysql_fetch_array($rs)){
          $str=$str."<div class='border' style='margin:1px;padding:8px'>";
          $str=$str."<div style='font-weight:bold' title='发送时间'>".$row["sendtime"]."</div>";
          $str=$str.$row["content"];
          $str=$str."</div>";
        }
        echo $str;
      }
      ?>
      <div class="content">
        <div class="admintitle">用户信息</div>
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <td width="20%" height="50" align="right" bgcolor="#FFFFFF" class="border2">注册时间：</td>
            <td width="80%" bgcolor="#FFFFFF" class="border2">
              <?php
              $sql="select * from zzcms_user where username='".@$username."'";
              $rs=mysql_query($sql);
              $row=mysql_fetch_array($rs);
              echo "<b>".@$username ."</b><br>".$row["regdate"];
              ?> </td>
          </tr>
          <!--<tr>
            <td height="50" align="right" bgcolor="#FFFFFF" class="border">您的金币：</td>
            <td bgcolor="#FFFFFF" class="border"><b><?php /*echo $row["totleRMB"]*/?>个</b><br>
              说明： <a href="/one/help.php#1032" target="_blank">关于金币</a></td>
          </tr>-->
          <tr>
            <td height="50" align="right" bgcolor="#FFFFFF" class="border2">登录次数：</td>
            <td bgcolor="#FFFFFF" class="border2"><b><?php echo $row["logins"]?>次</b><br>
              提示：若感到登录次数不对，那么请及时 <a href="managepwd.php" target="_self">[更换登录密码]</a> </td>
          </tr>
          <!--<tr>
            <td height="50" align="right" bgcolor="#FFFFFF" class="border">上次登录IP：<br></td>
            <td bgcolor="#FFFFFF" class="border"><b>
                <?php /*if ($row["showloginip"]<>"") {echo $row['showloginip'] ;}else{ echo "空" ;}*/?>
              </b><br>
              提示：若并没有用此IP登录过网站，那么请及时 <a href="managepwd.php" target="_self">[更换登录密码]</a>
            </td>
          </tr>
          <tr>
            <td height="50" align="right" bgcolor="#FFFFFF" class="border2">上次登录时间：</td>
            <td bgcolor="#FFFFFF" class="border2"><b><?php /*echo $row["showlogintime"]*/?>

              </b><br>
              提示：若在以上时间并没有登录过网站，那么请及时 <a href="managepwd.php" target="_self">[更换登录密码]</a></td>
          </tr>-->
        </table>
        <?php
        $sql="select id from zzcms_dl where saver='".@$username."' and looked=0 and del=0 and passed=1";
        $rs=mysql_query($sql);
        $row=mysql_num_rows($rs);
        if($row){
          ?>
          <script>
            if(confirm("有新的代理商留言要查看么？")){
              window.location.href="dls_message_manage.php"
            }
          </script>
          <div class="box">有<b><?php echo $row ?></b> 条新的代理商留言。[ <a href='dls_message_manage.php'>查看</a> ]  </div>
          <embed src=/image/sound.swf loop=false hidden=true volume=50 autostart=true width=0 height=0  name=foobar mastersound=mastersound></embed>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php
mysql_close($conn);
?>
</body>
</html>
</body>
</html>