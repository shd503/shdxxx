﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>上传图片</title>
  <script>
    function mysub()
    {
      esave.style.visibility="visible";
    }
  </script>
</head>
<base target=_self>
<body>

<form action="uploadimg.php" method="post" enctype="multipart/form-data" onSubmit="return mysub()" style="padding:10px" target="doaction">
  <div id="esave" style="position:absolute; top:0px; left:0px; z-index:10; visibility:hidden; width: 100%; height: 77px; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000;">
    <div align="center"><br />
      <img src="image/loading.gif" width="24" height="24" />正在上传中...请稍候！</div>
  </div>
  <input type="file" style="width:200px;" name="g_fu_image[]" />
  <input type="submit" name="Submit" value="提交" />
  <input name="noshuiyin" type="hidden" id="noshuiyin" value="<?php echo @$_GET['noshuiyin']?>" />
  <input name="imgid" type="hidden" id="imgid" value="<?php echo @$_GET['imgid']?>" />
</form>
<iframe style="display:none" name="doaction"></iframe>
</body>
</html>