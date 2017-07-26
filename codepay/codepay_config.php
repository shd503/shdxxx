<?php
/**
 * Created by CodePay.
 * 配置文件 
 * 版本：1.0
 * 修改日期：2016/12/11
 *
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究接口使用，只是提供一个参考。
 *
 * 注意：UTF-8编码不要在记事本下编辑 否则会出现一些奇葩的问题 正确方法应在开发工具打开编辑
 */
include("../inc/config.php");
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//codepay平台的ID，由纯数字组成的字符串，查看地址：https://codepay.fateqq.com/admin/#/dataSet.html
error_reporting(E_ALL & ~E_NOTICE); //过滤脚本提醒
date_default_timezone_set('PRC'); //时区设置 解决某些机器报错
$codepay_config['id'] = '10960';
/**
 * MD5密钥，安全检验码，由数字和字母组成字符串，需要跟服务端一致
 * 设置地址：https://codepay.fateqq.com/admin/#/dataSet.html
 * 该值非常重要 请不要泄露 否则会影响支付的安全。 如泄露请重新到云端设置
 */
$codepay_config['key'] = 'g4bBVr0qZQ39tyITsVIIKBZwZRGojzBB';

//字符编码格式 目前支持 gbk GB2312 或 utf-8 保证跟文档编码一致 建议使用utf-8
$codepay_config['chart'] = strtolower('utf-8');
header('Content-type: text/html; charset=' . $codepay_config['chart']);

//是否启用免挂机模式 1为启用. 未开通请勿更改否则资金无法及时到账
$codepay_config['act'] = '0'; //认证版则开启

/**订单支付页面显示方式
 * 1: GET框架云端支付 (默认简单 兼容性强 自动升级 1分钟可集成)
 * 2: POST表单到云端支付 (简单 兼容性强 自动升级)
 * 3：自定义开发模式 (复杂 需要一定开发能力 手动升级)
 * 4：高级模式(复杂 需要较强的开发能力 手动升级)
 */
$codepay_config['page'] = 3; //支付页面展示方式：GET框架云端支付 享受免集成 免升级

//支付页面风格样式 仅针对$codepay_config['page'] 参数为 1或2 才会有用。
$codepay_config['style'] = 1; //暂时保留的功能 后期会生效 留意官网发布的风格编号


//二维码超时设置  单位：秒
$codepay_config['outTime'] = 360;//360秒=6分钟 最小值60  不建议太长 否则会影响其他人支付

//最低金额限制
$codepay_config['min'] = 0.01;

//启用支付宝官方接口 会员版授权后生效
$codepay_config['pay_type'] = 1;

//二维码本地实现 传入http://baidu.com 会加载http://baidu.com/?money=1&tag=0&type=1
// qrcode.php 为我们的演示控制二维码程序
//$codepay_config['qrcode_url'] = "";
$codepay_config['qrcode_url'] = siteurl."/codepay/qrcode.php";

/**
 * 同步通知设置：
 * 同步通知用户关闭网页后则不会通知 通知地址公开的
 * 返回的参数通过MD5加密处理 返回target参数为get 则为同步通知数据
 * 设置通知地址不能附带任何参数，否则您需要自行验证签名或自行在验证数据签名前将$_GET['同步地址中的参数名']去掉
 * 以下为设置同步地址：(绝对路径)
 * http://你的域名/codepay/return.php
 */
$codepay_config['return_url'] = ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1 || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['REQUEST_URI']) . '/return.php';

//$codepay_config['return_url'] = "http://localhost/user/zs.php";

/**
 * 异步通知设置：
 * 设置异步通知也可以到软件或者码支付云端设置。 如留空则会启用云端默认的通知地址
 * (异步通知可保证通知的可靠性及保密性 不传入仅在云端设置后则仅您与云端知道 安全级别更高)
 */

$codepay_config['notify_url'] = ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1 || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['REQUEST_URI']) . '/notify.php';


/**
 * 以下为控制是否开启调试模式 会使用测试数据进行充值示范。需要访问install.php安装数据后才生效
 */
define('ROOT_PATH', dirname(__FILE__)); //这是程序目录常量
define('DEBUG', true);  //调试模式启用
define('LOG_PATH', ROOT_PATH . '/log.txt');  //日志文件路径 建议写入到非web目录 比如c:/log.txt 因为WEB目录任何人可访问
define('DB_PREFIX', 'codepay');  //测试数据表前缀 主要是订单记录表前缀 删除该行将停用测试数据

/**
 * 以下全部设置为充值示范接口中的相关设置 为了了解码支付接口的相关实现并不是通用的
 *
 * 以下为MYSQL数据库的配置 主要用于测试数据充值业务demo 不是必要安装。相关参数在安装后自动生成。
 */
define('DB_HOST', 'dianjia123.com'); //数据库服务器地址
define('DB_USER', 'root');  //数据库用户名
define('DB_PWD', 'wodemysql123');//数据库密码
define('DB_NAME', 'zzcms8');  //数据库名称
define('DB_PORT', '3306');  //数据库端口

define('DB_AUTOCOMMIT', false);  //默认false使用事物回滚 不自动提交只对InnoDB有效。
define('DB_ENCODE', $codepay_config['chart'] == 'utf-8' ? 'utf8' : $codepay_config['chart']);  //数据库编码


/**
 * 以下为MYSQL数据库的配置 修改下面表名,字段 即可实现简单的充值业务 为附带部分可跳过。
 */
define('DB_USERTABLE', 'zzcms_user');  //充值用户所在数据库表名
define('DB_INITMONEY', 'initRMB');   //初次充值金额字段名
define('DB_USERMONEY', 'totleRMB');  //充值用户所在表中的金额字段名
//define('DB_USERID', 'user');  //充值用户所在表中的ID字段名
define('DB_USERNAME', 'username');  //充值用户名的字段名 根据用户名转换为id

?>