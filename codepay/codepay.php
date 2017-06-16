<?php
/**
 * 功能：接收网站参数 并创建订单
 * 版本：1.0
 * 修改日期：2016-12-11
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究接口使用，只是提供一个参考。
 *
 *
 *************************注意*****************
 * 如果您是软件版您必须制作并先上传收款码或者是金额的二维码。 否则提示无二维码
 * 如果还没上传或不想上传先测试 请使用免挂机模式进行测试(钱到平台账户 只能创建1元以下的订单)
 * 修改文件codepay_config.php中 $codepay_config['act']='1'
 * 1、支付宝二维码制作教程：https://codepay.fateqq.com/help/rknXG3lFx.html
 * 2、微信二维码制作教程：https://codepay.fateqq.com/help/ByLyU3bFl.html
 * 其他操作教程：https://codepay.fateqq.com/help/web/
 *
 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、开发文档中心：https://codepay.fateqq.com/apiword/
 *2、商户帮助中心：https://codepay.fateqq.com/help/
 *3、联系客服：https://codepay.fateqq.com/msg.html
 *如果想使用扩展功能,请按文档要求,自行添加到parameter数组即可。
 **********************************************
 */

//session_start(); //开启session
require_once("codepay_config.php"); //导入配置文件
require_once("includes/MysqliDb.class.php");//导入mysqli连接
require_once("includes/M.class.php");//导入mysqli操作类
require_once("lib/codepay_submit.class.php"); //导入自动提交类

/**
 * 一些防攻击的方法
 * 3秒内禁止刷新页面
 * 验证表单是否合法
 */

//$_SESSION["count"] += 1;
//if ($_SESSION["count"] > 20 || ($_SESSION["endTime"] + 3) > time()) {
//    $_SESSION["count"] = 0;
//    exit("您的操作太频繁请重试 <a href='../'>返回重试</a><script>setTimeout(function() {
//  history.back(-1)
//},3000);</script>");
//}
//$_SESSION["endTime"] = time();
//
//$salt = $_POST["salt"]; //验证表单合法性的参数
//
//if ($salt <> md5($_SESSION["uuid"])) exit('表单验证失败 请重新提交'); //防止跨站攻击


/**
 * 接收表单的数据 无需改动
 * 需要注意：pay_id 云端限制字符长度为100；太长会返回too long错误
 */

$user = $_POST['user'];//提交的用户名 当然可以直接取session中的ID或用户名

$price = (float)$_POST["price"]; //提交的价格

$type = (int)$_POST["type"]; //支付方式
if ($type < 1) $type = 1;
$param = ''; //自定义参数  可以留空 传递什么返回什么 用于区分游戏分区或用户身份


if ($price <= 0) $price = (float)$_POST["money"]; //如果没提供自定义输入金额则使用money参数

if ($price < $codepay_config['min']) exit('最低限制' . $codepay_config['min'] . '元'); //检查最低限制

$price = number_format($price, 2, '.', '');// 四舍五入只保留2位小数。

if (empty($codepay_config) || (int)$codepay_config['id'] <= 1) {
    exit('请修改配置文件codepay_config.php  或进入<a href="install.php">install.php</a> 安装码支付接口测试数据');
}


/**
 * 唯一标识处理
 * 调试模式使用的是将用户名从数据库转为ID
 * 测试数据只模拟处理充值 充值成功后访问user.php 查看是否充值成功。
 */
//if (defined('DEBUG') && DEBUG && defined('DB_PREFIX')&& defined('DB_USERID')&&defined('DB_USERID')) { //开启了调试模式 而且安装了测试数据、。 从表codepay_user获取用户ID值
//    // 正式上线 修改文件codepay_config.php为 define('DEBUG', false);
//    $m = new M();
//    $stmt = $m->prepare("select ".DB_USERID." from `" . DB_USERTABLE . "` where ".DB_USERNAME."=?");//预编译SQL语句
//    if (!$stmt) exit("没发现测试数据 请修改\$codepay_config['id']参数为1或空后 进入<a href='install.php'>install.php</a> 重新安装");
//    $stmt->bind_param('s', $user); //绑定参数防止SQL注入
//    $rs = $stmt->execute(); //执行SQL
//    $stmt->store_result();
//    $stmt->bind_result($pay_id); //将数据库中的ID值返回给$pay_id
//    $stmt->fetch();
//    $stmt->close();
//    if (empty($pay_id)) {
//        exit('需要充值的用户不存在 默认测试数据只有：admin用户');
//    }
//    $_SESSION['pay_id'] = $pay_id; //保存需要充值的ID到session中 为了同步通知 所用。
//
//} else { //这是正式的生产环境 适用于正式上线 传递的$pay_id 参数 自行更改
//    $pay_id = $_POST["user"]; //网站唯一标识 需要充值的用户名，用户ID或者自行创建订单 建议传递用户的ID
//}

$pay_id = $_POST["user"]; //网站唯一标识 需要充值的用户名，用户ID或者自行创建订单 建议传递用户的ID

if (empty($pay_id)) exit('需要充值的用户不能为空'); //唯一用户标识 不能为空 如果是登录状态可以直接取session中的ID或用户名

if ($codepay_config['pay_type'] == 1 && $type == 1) {
    $codepay_config["qrcode_url"] = ''; //官方接口 不能走本地化二维码 自动生成
}

/**
 * 这里可以自行创建站内订单将用户提交的数据保存到数据库生成订单号
 *
 * 嫌麻烦pay_id直接传送用户ID或用户名(中文用户名请确认编码一致)
 * 我们支持GBK,gb2312,utf-8 如发送中文遇到编码困扰无法解决 可以尽量使用UTF-8
 * 万能解决方法：base64或者urlencode加密后发送我们. 处理业务的时候转回来
 */
//构造要请求的参数数组，无需改动
$parameter = array(
    "id" => (int)$codepay_config['id'],//平台ID号
    "type" => $type,//支付方式
    "price" => (float)$price,//原价
    "pay_id" => $pay_id, //可以是用户ID,站内商户订单号,用户名
    "param" => $param,//自定义参数
    "act" => (int)$codepay_config['act'],//是否开启认证版的免挂机功能
    "outTime" => (int)$codepay_config['outTime'],//二维码超时设置
    "page" => (int)$codepay_config['page'],//付款页面展示方式
    "return_url" => $codepay_config["return_url"],//付款后附带加密参数跳转到该页面
    "notify_url" => $codepay_config["notify_url"],//付款后通知该页面处理业务
    "style" => (int)$codepay_config['style'],//付款页面风格
    "pay_type" => $codepay_config['pay_type'],//支付宝使用官方接口
    "qrcode_url" => $codepay_config['qrcode_url'],//本地化二维码
    "chart" => trim(strtolower($codepay_config['chart']))//字符编码方式
    //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
    //如"参数名"=>"参数值"
);

switch ((int)$codepay_config['page']) {
    case 1:
        //框架显示(简单 全集成好 自动升级)
        require_once("./html/codepay_frame_order.php");
        break;
    case 2:
        //POST请求云端(简单 全集成好 自动升级)
        echo '正在创建订单...';
        $codepaySubmit = new CodepaySubmit($codepay_config);
        echo $codepaySubmit->buildRequestForm($parameter, "post", "确认");
        break;
    case 3:
        //开发模式(难 可自行实现复杂功能 需要自行开发部分)
        require_once("./html/codepay_diy_order.php");
        break;
    case 4:
        //超级模式(复杂 可自行实现复杂功能 需要自行开发部分)
        require_once("./html/codepay_supper_order.php");
        break;
    default:
        require_once("./html/codepay_frame_order.php");
}

?>