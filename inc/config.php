<?php
define('sqldb','zzcms8');//数据库名
define('sqluser','root');//用户名
define('sqlpwd','');//密码
define('sqlhost','localhost');//连接服务器,本机填(local)，外地填IP地址
define('zzcmsver','Powered By <a target=_blank style=font-weight:bold href=http://www.zzcms.net><font color=#FF6600 face=Arial>ZZ</font><font color=#025BAD face=Arial>CMS8.0</font></a>');//版本
define('sitename','zzcms') ;//网站名称
define('siteurl','http://localhost') ;//网站地址
define('logourl','http://localhost/image/dianjialogo.png') ;//Logo地址
define('icp','豫icp备07007271号') ;//icp备案号
define('webmasteremail','357856668@qq.com') ;//站长信箱
define('kftel','0371-86137281') ;//联系电话
define('kfmobile','13838064112') ;//手机
define('kfqq','357856668') ;//QQ
define('sitecount','<script language=javascript type=text/javascript src=http://js.users.51.la/713776.js></script>') ;//网站统计代码
define('opensite','Yes') ;//网站运行状态
define('showwordwhenclose','网站正在维护中……') ;//关闭网站原因
define('openuserreg','Yes') ;//注册用户状态
define('openuserregwhy','网站暂时关闭注册功能，明天开放！') ;//关闭注册用户原因
define('isaddinfo','Yes') ;//是否允许未审核的用户发布信息
define('pagesize_ht','50');//管理员后台每页显示信息数
define('pagesize_qt','20');//前台每页显示信息数
define('whendlsave','No') ;//当有代理或求购留言是否打开在线发邮件功能
define('whenuserreg','Yes') ;//当新用户注册时是否打开在线发邮件功能
define('whenmodifypassword','Yes') ;//当用户修改密码时是否开发在线发邮件功能
define('smtpserver','smtp.126.com') ;//邮件服务器
define('sender','ggyyxxcom@126.com') ;//发送邮件的地址
define('smtppwd','') ;//email密码
define('sendsms','Yes') ;//发手机短信开关
define('smsusername','lmf0371') ;//SMS用户名
define('smsuserpass','') ;//SMS密码
define('apikey_mobile_msg','apikey_mobile_msg') ;//apikey
define('isshowcontact','No') ;//是否公开代理商联系方式
define('liuyanysnum','1'); //延时时间
define('wordsincomane','') ;//公司名称中必填行业性关键字
define('lastwordsincomane','') ;//必填公司类型性关键字
define('nowordsincomane','a|b|c|d|e|f|g|h|i|g|k|l|m|n|o|p|q|r|s|t|u|v|w|x|w|z|A|B|C|D|E|F|G|H|I|G|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|1|2|3|4|5|6|7|8|9|0') ;//公司名称中禁用关键字
define('stopwords','得普利麻|易瑞沙|益赛普|赫赛汀|日达仙|百泌达|多吉美|拜科奇|赛美维|施多宁|派罗欣|妥塞敏|格列卫|特罗凯|手机窃听器|手枪') ;//网站禁用关键字
define('allowrepeatreg','Yes') ;//是否允许重复注册用户
define('showdlinzs','No') ;//招商信息内是否显示代理留言数
define('zsliststyle','list') ;//招商列表页默认显示格式
define('siteskin','red2') ;//网站电脑端模板
define('siteskin_mobile','m') ;//网站手机端模板
define('siteskin_usercenter','1') ;//用户中心样式
define('checksqlin','No') ;//是否开启防SQL注入功能
define('cache_update_time','0') ;//缓存更新周期
define('shuxing_name','shuxing_name') ;//招商更多属性设置
define('checkistrueemail','No') ;//用户注册时是否开启邮箱验证功能
define('usedvbbs','') ;//是否启用动网论坛
define('sdomain','No') ;//用户展厅页是否启用二级域名
define('whtml','No') ;//是否使用生成HTML页功能
define('isshowad_when_timeend','') ;//到期的广告是否还让显示
define('showadtext','广告已到期了') ;//到期的广告前台显示语
define('qiangad','Yes') ;//是否开通抢占广告位功能
define('showadvdate','15') ;//广告位置占用时间
define('duilianadisopen','Yes') ;//是否打开对联广告
define('flyadisopen','Yes') ;//是否打开漂浮广告
define('jifen','Yes') ;//是否启用积分功能
define('jifen_bilu','1') ;//1元等于多少积分
define('jf_reg','50') ;//注册时获取积分值
define('jf_login','20') ;//登录时获取积分值
define('jf_addreginfo','10') ;      //完善注册信息获取积分值
define('jf_lookmessage','50') ;  //查看代理留言时扣除的积分值
define('jf_look_dl','50') ;  //查看代理商信息库时扣除的积分值
define('jf_set_adv','10') ; //抢占首页广告位扣除的积分值
define('maximgsize','20000') ;  //图片文件大小限制,单位K
define('maxflvsize','20') ;  //视频文件大小限制,单位M
define('upfiletype','gif|jpg|swf|xls|flv') ;//允许的上传文件类型
define('shuiyin','No') ;//是否启用水印功能
define('addimgXY','right') ;//水印文字位置
define('syurl','uploadfiles/2014-07/20140721223830783.jpg') ;//水印图片地址
define('alipay_partner','2088002168041280') ;//合作者身份ID
define('alipay_key','g6m9go08qiag25d6bvb1uvrtkdpqral7') ;//安全检验码
define('alipay_seller_email','lzy0393@126.com') ;//签约支付宝账号或卖家支付宝帐户
define('tenpay_bargainor_id','1210032601') ;//财富通商户号
define('tenpay_key','5cc08461639a8b7fd5302a194deef7c0') ;//密钥
define('qqlogin','No') ;//是否开启QQ登录功能
define('qq_oauth_consumer_key','') ;//ID
define('qq_oauth_consumer_secret','') ;//KEY
define('qq_callback_url','') ;//返回页地址
define('bbs_set','No') ;//是否开启同步论坛功能
define('dl_liuyan_set','No') ;//是否显示代理留言页面
define('background_set','No') ;//是否显示页面背景设置(用户发商机页面)
?>