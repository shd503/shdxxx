﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<?php
include("../inc/conn.php");
?>
<link href="../template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.dzt {
	font-size: 14px;
	line-height: 25px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div class="main" style="width:960px">
<?php
include("../inc/top2.php");
echo sitetop();
?>
 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td> 
        <table width="100%" height="40" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="30" class="dzt">VIP会员与普通会员的权限比较</td>
          </tr>
          <tr> 
            <td> <?php
$sql="select * from zzcms_usergroup";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
echo "暂无信息";
}else{
?>
<div  class="bgcolor3" >
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                  <tr class="bgcolor2"> 
                    <td width="25%" align="right">权限比较</td>
                    <?php while ($row=mysql_fetch_array($rs)){?>
                    <td align="center" class="bold"><?php echo $row["groupname"]?> </td>
                    <?php
				  }
				  ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">查看代理商留言联系方式</td>
                    <?php 
				   mysql_data_seek($rs,0);
				   while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if (str_is_inarr($row["config"],'look_dls_liuyan')=='yes') { echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">打印代理留言</td>
                    <?php 
				   mysql_data_seek($rs,0);
				   while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if (str_is_inarr($row["config"],'dls_print')=='yes')  { echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">下载代理留言</td>
                    <?php
				  mysql_data_seek($rs,0);
				   while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                    <?php if (str_is_inarr($row["config"],'dls_download')=='yes'){ echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">每天能查看代理留言数</td>
                    <?php 
				  mysql_data_seek($rs,0);
				  while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if ($row["looked_dls_number_oneday"]==999) { echo  "不限制";} else {echo  $row["looked_dls_number_oneday"];}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">抢占广告位</td>
                    <?php 
				  mysql_data_seek($rs,0);
				  while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                    <?php if (str_is_inarr($row["config"],'set_text_adv')=='yes') { echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1">信息显示</td>
                    <?php 
				  mysql_data_seek($rs,0);
				  while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if ($row["groupid"]==1) { echo "按自然顺序显示";} else{ echo "优先显示";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1" >信息免审</td>
                    <?php
				   mysql_data_seek($rs,0);
				    while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if (str_is_inarr($row["config"],'passed')=='yes'){ echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1" >上传视频</td>
                    <?php
				   mysql_data_seek($rs,0);
				    while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if (str_is_inarr($row["config"],'uploadflv')=='yes'){ echo "<img src='/image/dui2.gif'>";} else{ echo "<img src='/image/error.gif'>";}?>
                    </td>
                    <?php } ?>
                  </tr>
                  <tr  bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
                    <td align="right" class="bgcolor1" >&nbsp;</td>
                    <?php 
				   mysql_data_seek($rs,0);
				   while ($row=mysql_fetch_array($rs)){?>
                    <td align="center"> 
                      <?php if ($row["groupid"]<>1) {?>
                      <form name="groupid" id="groupid" method="get" action="/user/index.php">
                        <input type="submit" name="Submit" value="购买(<?php echo $row["RMB"]?>元/年)" />
                        <input name="gotopage" type="hidden" id="gotopage" value="vip_add.php" />
                        <input name="canshu" type="hidden" id="canshu" value="<?php echo $row["groupid"]?>" />
                      </form>
                      <?php
					  }
					  ?>
                    </td>
                    <?php
					}
					?>
                  </tr>
                </table>
			  </div>
		    </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
<?php
}
include ('../inc/bottom_company.htm');
mysql_close($conn);
?>
</div>
</body>
</html>
