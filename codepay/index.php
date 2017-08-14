<?php
/**
 * 充值示范页面 (主要兼容手机端 IE9以下布局是乱的)
 * Created by codepay.
 * Date: 2017/2/10
 * Time: 15:03
 */
error_reporting(E_ALL & ~E_NOTICE);
//session_start(); //开启session
require_once("codepay_config.php"); //导入配置文件
require_once("lib/codepay_core.function.php"); //导入所需函数库
require_once("lib/codepay_md5.function.php"); //导入MD5函数库
//$_SESSION["uuid"]=guid();//生成UUID 添加到网页表单 防止使用部分软件恶意提交订单
//$salt=md5($_SESSION["uuid"]); //这是用于表单防跨站提交
//$user = 'admin';  //这是默认的用户名
$user = trim($_COOKIE['UserName']);

if ((int)$codepay_config['id'] <= 1) { //未修改配置文件
    exit('<h3>您需要修改配置文件：codepay_config.php 或者安装码支付接口 才能显示该页面。 <a href="install.php">点击安装</a></h3>');
} ?>
<!DOCTYPE html>
<html>
<head><title>
        在线充值
    </title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link rel="stylesheet" type="text/css" href="css/userPay.css">

    <style>
        a:link {
            text-decoration: none;
        }

        　　 a:active {
            text-decoration: blink
        }

        　　 a:hover {
            text-decoration: underline;
        }

        　　 a:visited {
            text-decoration: none;
        }

        *, :after, :before {
            /* -webkit-box-sizing: border-box; */
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        button, html input[type=button], input[type=reset], input[type=submit] {
            -webkit-appearance: button;
            cursor: pointer;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="loadingPicBlock" style="max-width: 720px;margin:0 auto;" class="pay">
    <header class="g-header">

        <div class="head-r">
            <a href="/" class="z-HReturn" data-dismiss="modal" aria-hidden="true"><s></s><b>首页</b></a>
        </div>
    </header>

    <div class="g-Total gray9">请选择需要充值的金额</div>
    <section class="clearfix g-member">
        <div class="g-Recharge">
            <ul id="ulOption">
                <li money="1"><a href="javascript:;">任意金额<s></s></a></li>
                <li money="10"><a href="javascript:;">10元<s></s></a></li>
                <li money="20"><a href="javascript:;" class="z-sel">20元<s></s></a></li>
                <li money="50"><a href="javascript:;" >50元<s></s></a></li>
                <li money="100"><a href="javascript:;">100元<s></s></a></li>
                <li money="200"><a href="javascript:;">200元<s></s></a></li>
            </ul>
        </div>
        <form action="codepay.php" method="post">
            <article class="clearfix mt10 m-round g-pay-ment g-bank-ct">
                <ul id="ulBankList" >
                    <li class="gray6" style="width: 100%;padding: 0px 0px 0px 10px">您选择充值：<label class="input" style="border: 1px solid #EAEAEA;height: 15px;font-size:24px;">
                            <input type="text" name="price" id="price" placeholder="如：20" value="20"
                                   style="width: 72px;color: red;font-size:14px;">
                        </label> 元
                    </li>
                    <li class="gray6" style="width: 100%;padding: 0px 0px 0px 10px">充值用户名：<label class="input"
                                                                                                 style="border: 1px solid #EAEAEA;height: 15px;font-size:24px;">
                            <input type="text" name="user" id="user" placeholder="用户名" value="<?php echo $user; ?>"
                                   style="width: 80px;font-size:14px;">
                        </label></li>
                    <!--<li payType="1" class="gray9" type="codePay" style="width: 33%">
                        <a href="javascript:;" class="z-initsel"><img src="img/alipay.jpg"><s></s></a>

                    </li>-->
                    <li payType="3" class="gray9" type="codePay" style="width: 33%" >
                        <a href="javascript:;"  class="z-initsel"><img src="img/weixin.jpg"><s></s></a>

                    </li>
                   <!-- <li payType="2" class="gray9" type="codePay" style="width: 33%">
                        <a href="javascript:;"><img src="img/qqpay.jpg"><s></s></a>
                    </li>-->
                </ul>
            </article>
            <input type="hidden" id="pay_type" value="3" name="type">
            <input type="hidden" value="<?php echo $salt; ?>" name="salt">

            <div class="mt10 f-Recharge-btn">

                <button id="btnSubmit" type="submit" href="javascript:;" class="orgBtn">确认支付</button>
            </div>
        </form>
    </section>

    <input id="hidIsHttps" type="hidden" value="0"/>
    <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">

        $(function () {
            var c;
            var g = false;
            var a = null;
            var e = function () {
                $("#ulOption > li").each(function () {
                    var n = $(this);
                    n.click(function () {
                        g = false;
                        c = n.attr("money");
                        n.children("a").addClass("z-sel");
                        n.siblings().children().removeClass("z-sel").removeClass("z-initsel");
                        var needMoney = parseFloat(n.attr("money")).toFixed(2);
                        if (needMoney <= 0)needMoney = 0.01;
                        $("#price").val(needMoney);
                    })
                });
                $("#ulBankList > li").each(function (m) {
                    var n = $(this);
                    n.click(function () {
                        if (m < 2)return;
                        $("#pay_type").val(n.attr("payType"));
                        n.children("a").addClass("z-initsel");
                        n.siblings().children().removeClass("z-initsel");
                    })
                });

            };
            e()
        });

    </script>


</div>
</body>
</html>

