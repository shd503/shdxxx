<?php
/**
 * 功能：框架显示支付页面 (全集成好 方便快捷)
 * 版本：1.0
 * 修改日期：2016-12-11
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究接口使用，只是提供一个参考。
 * ============================
 */
if (empty($parameter)) exit('不支持直接访问 表单请提交至codepay.php');

$codepayFrame = new CodepaySubmit($codepay_config);

$codepay_frame_url =  getApiHost() . "creat_order/?";
$codepay_frame_url .= $codepayFrame->buildRequestParaToString($parameter);
function is_weixin()
{ //微信浏览器需要使用ajax加载
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}

if (is_weixin()) { //兼容微信浏览器 用ajax方式
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>码支付</title>
        <script src="./js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
    <div id="showPage" class="showPage">加载中...</div>
    <script>
        $(document).ready(function () {
            htmlobj = $.ajax({url: "<?php echo $codepay_frame_url?>", async: false});
            $("#showPage").html(htmlobj.responseText);
        });

    </script>


    </body>
    </html>
    <?php
} else {
    echo '<iframe src="' . $codepay_frame_url . '" width="100%" height="100%" frameborder="no" border="0" scrolling="no" allowtransparency="yes"></iframe>';
}
?>