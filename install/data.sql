DROP TABLE IF EXISTS `zzcms_about`;
CREATE TABLE `zzcms_about` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` longtext,
  `link` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_admin`;
CREATE TABLE `zzcms_admin` (
  `id` int(11) NOT NULL auto_increment,
  `groupid` int(11) default NULL,
  `admin` varchar(255) default NULL,
  `pass` varchar(255) default NULL,
  `logins` int(11) default '0',
  `loginip` varchar(255) default NULL,
  `lastlogintime` datetime default NULL,
  `showloginip` varchar(255) default NULL,
  `showlogintime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_login_times`;
CREATE TABLE `zzcms_login_times` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) default NULL,
  `count` int(11) default '0',
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_admingroup`;
CREATE TABLE `zzcms_admingroup` (
  `id` int(11) NOT NULL auto_increment,
  `groupname` varchar(255) default NULL,
  `config` varchar(1000) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_admingroup` values('1','超级管理员','zs#zsclass#zskeyword#dl#zh#zhclass#zx#zxclass#zxpinglun#zxtag#pp#job#jobclass#special#specialclass#adv#advclass#advtext#userreg#usernoreg#userclass#usergroup#guestbook#licence#badusermessage#fankui#uploadfiles#sendmessage#sendmail#sendsms#announcement#helps#bottomlink#friendlink#siteconfig#label#adminmanage#admingroup');
replace into `zzcms_admingroup` values('2','管理员(演示用)','zs#zskeyword#dl#zh#zx#zxpinglun#zxtag#pp#job#special#userreg#usernoreg#usergroup#guestbook#licence#badusermessage#fankui#sendmessage#sendmail#sendsms');

DROP TABLE IF EXISTS `zzcms_bad`;
CREATE TABLE `zzcms_bad` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `ip` varchar(255) default NULL,
  `dose` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `lockip` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_dl`;
CREATE TABLE `zzcms_dl` (
  `id` int(11) NOT NULL auto_increment,
  `cp` varchar(255) default NULL,
  `content` varchar(1000) default NULL,
  `dlsname` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `tel` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `editor` varchar(255) default NULL,
  `saver` varchar(255) default NULL,
  `ip` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `looked` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  `del` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_help`;
CREATE TABLE `zzcms_help` (
  `id` int(11) NOT NULL auto_increment,
  `classid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `elite` tinyint(4) default '0',
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_licence`;
CREATE TABLE `zzcms_licence` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_link`;
CREATE TABLE `zzcms_link` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default '0',
  `sitename` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `content` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `logo` varchar(255) default NULL,
  `elite` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_linkclass`;
CREATE TABLE `zzcms_linkclass` (
  `bigclassid` int(11) NOT NULL auto_increment,
  `bigclassname` varchar(255) default NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bigclassid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
replace into `zzcms_linkclass` values('1','合作网站','0');
replace into `zzcms_linkclass` values('2','友链网站','0');

DROP TABLE IF EXISTS `zzcms_looked_dls`;
CREATE TABLE `zzcms_looked_dls` (
  `id` int(11) NOT NULL auto_increment,
  `dlsid` int(11) default NULL,
  `username` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_looked_dls_number_oneday`;
CREATE TABLE `zzcms_looked_dls_number_oneday` (
  `id` int(11) NOT NULL auto_increment,
  `looked_dls_number_oneday` int(11) default NULL,
  `username` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_main`;
CREATE TABLE `zzcms_main` (
  `id` int(4) NOT NULL auto_increment,
  `proname` varchar(255) NOT NULL,
  `prouse` text,
  `procompany` varchar(255) default NULL,
  `tz` varchar(255) default NULL,
  `shuxing_value` text,
  `sm` text,
  `xuhao` int(4) default NULL,
  `bigclasszm` varchar(255) default NULL,
  `smallclasszm` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `flv` varchar(255) default NULL,
  `province` varchar(25) default NULL,
  `city` varchar(25) default NULL,
  `xiancheng` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `editor` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `hit` int(11) default '0',
  `elite` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  `userid` int(11) default '0',
  `comane` varchar(255) default NULL,
  `renzheng` tinyint(4) default '0',
  `groupid` int(11) default '1',
  `phone` varchar(255) default NULL,
  `mobile` varchar(255) default NULL,
  `qq` varchar(255) default NULL,
  `bodybg` varchar(255) default NULL,
  `bodybgrepeat` varchar(50) default NULL,
  `swf` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE  `zzcms_main` ADD INDEX (  `province` ,  `city` ,  `xiancheng` ) ;

DROP TABLE IF EXISTS `zzcms_message`;
CREATE TABLE `zzcms_message` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `sendtime` datetime default NULL,
  `sendto` varchar(50) NOT NULL,
  `looked` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_ad`;
CREATE TABLE `zzcms_ad` (
  `id` int(11) NOT NULL auto_increment,
  `xuhao` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `titlecolor` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `agentadmin` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassname` varchar(50) default NULL,
  `username` varchar(50) default NULL,
  `nextuser` varchar(50) default NULL,
  `elite` tinyint(4) NOT NULL default '0',
  `img` varchar(255) default NULL,
  `imgwidth` int(11) default NULL,
  `imgheight` int(11) default NULL,
  `starttime` datetime default NULL,
  `endtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

replace into `zzcms_ad` values('1','0','90后小伙卖鞋 火了！','','#','2012-01-06 22:31:38','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('2','0','在家开网店 购物商城','','#','2012-01-06 22:31:58','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('3','0','一台电脑，挣钱快！','','#','2012-01-06 22:32:18','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('4','0','10元火锅 24小时热卖','','#','2012-01-06 22:32:29','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('5','0','9元女装 开一店送一店','','#','2012-01-06 22:32:38','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('6','0','8元汉堡套餐 大优惠','','#','2012-01-06 22:32:48','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('7','0','特色石锅鱼 客源不断','','#','2012-01-06 22:32:59','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('8','0','2元甜品 5平米街头店','','#','2012-01-06 22:35:44','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('9','0','学车王 轻松办驾校','','#','2012-01-06 22:35:53','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('10','0','上品红酒 原装进口！','','#','2012-01-06 22:36:02','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('11','0','小型鱼火锅 新型财富！','','#','2012-01-06 22:36:12','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('12','0','手工酸奶，现做现卖　赚','','#','2012-01-06 22:36:21','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('13','0','6元煲仔饭 好吃赚的快','','#','2012-01-06 22:36:31','展示页','A','',NULL,'0','','100','100','2012-01-22 00:00:00','2013-01-21 00:00:00');
replace into `zzcms_ad` values('14','0','辣有道','','#','2012-01-08 22:28:15','首页','A','',NULL,'0','/uploadfiles/2012-01/20120124222759132.gif','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('15','0','2','','#','2012-01-08 22:28:31','首页','A','',NULL,'0','/uploadfiles/2012-01/20120124222829339.gif','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('16','0','3','','#','2012-01-08 22:28:40','首页','A','',NULL,'0','/uploadfiles/2012-01/20120124222837365.gif','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('17','0','4','','#','2012-01-08 22:28:52','首页','A','',NULL,'0','/uploadfiles/2012-01/20120124222849773.gif','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('18','0','5','','#','2012-01-08 22:29:04','首页','A','',NULL,'0','/uploadfiles/2012-01/20120124222902599.gif','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('20','0','时尚MR卷,好吃不贵！','','#','2012-01-08 22:38:42','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('21','0','时尚MR卷,好吃不贵！','','#','2012-01-08 22:38:52','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('22','0','七彩面条，演绎成功！','','#','2012-01-08 22:38:59','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('23','0','西班牙美食，人人追捧!','','#','2012-01-08 22:39:08','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('24','0','米堡百米长队 停不了嘴','','#','2012-01-08 22:39:16','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('25','0','新式烧烤，排名等位！','','#','2012-01-08 22:50:26','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('26','0','玉饰小超市 全民爱玉！','','#','2012-01-08 22:50:39','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('27','0','迷你小火锅，鱼汁鱼味!','','#','2012-01-08 22:50:50','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('28','0','休闲食品，排队开店！','','#','2012-01-08 22:51:01','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('29','0','生态美味，食客排队！','','#','2012-01-08 22:51:11','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('30','0','小虎队DIY学生用品！','','#','2012-01-08 22:54:01','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('31','0','特色鱼火锅 食客新诱惑','','#','2012-01-08 22:54:15','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('32','0','儿童乐园，孩子都爱！','','#','2012-01-08 22:54:42','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('33','0','街头甜品 舌尖美味!','','#','2012-01-08 22:54:52','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('34','0','麻辣香锅引领美食热潮','','#','2012-01-08 22:55:02','首页','A','',NULL,'0','','120','50','2012-01-24 00:00:00','2013-01-23 00:00:00');
replace into `zzcms_ad` values('35','0','7','','#','2013-06-16 16:29:25','首页','A','',NULL,'0','/uploadfiles/2013-07/20130702162909742.gif','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('36','0','8','','#','2013-06-16 16:29:50','首页','A','',NULL,'0','/uploadfiles/2013-07/20130702162945256.gif','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('37','0','9','','#','2013-06-16 16:30:02','首页','A','',NULL,'0','/uploadfiles/2013-07/20130702162959797.gif','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('38','0','10','','#','2013-06-16 16:30:13','首页','A','',NULL,'0','/uploadfiles/2013-07/20130702163010327.gif','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('39','0','11','','#','2013-06-16 16:30:24','首页','A','',NULL,'0','/uploadfiles/2013-07/20130702163020704.gif','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('41','0','汽车美容 一站式连锁店','','#','2000-06-16 16:57:33','首页','A','',NULL,'0','','120','50','2013-07-02 00:00:00','2014-07-02 00:00:00');
replace into `zzcms_ad` values('42','0','三元合作 意大利冰淇淋','','#','2000-06-16 16:57:45','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('43','0','优惑女装 品牌服饰！','','#','2000-06-16 16:57:54','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('44','0','百米长队，带馅猪排！','','#','2000-06-16 16:58:01','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('45','0','手工冰淇淋 百米排长队','','#','2000-06-16 16:58:08','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('46','0','温碧霞教你做面膜！','','#','2000-06-16 16:59:02','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('47','0','祖传卤味，店店排队！','','#','2000-06-16 16:59:09','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('48','0','稀奇古怪,搞笑玩具专卖','','#','2000-06-16 16:59:19','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('49','0','蒸出来的美食 健康营养','','#','2000-06-16 16:59:26','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('50','0','比比Q 快餐连锁店！','','#','2000-06-16 16:59:34','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('51','0','健康养生 选择御膳缘！','','#','2000-06-16 17:00:51','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('52','0','家居饰品店 温馨您的家','','#','2000-06-16 17:00:58','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('53','0','美味薯条 现做现卖！','','#','2000-06-16 17:01:07','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('54','0','排骨大包 祖传手艺！','','#','2000-06-16 17:01:15','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('55','0','档口小吃 自己开店！','','#','2000-06-16 17:01:22','首页','A','',NULL,'0','','120','50','2000-07-02 00:00:00','2001-07-02 00:00:00');
replace into `zzcms_ad` values('56','0','a','','#','2013-06-23 21:32:29','首页','A','',NULL,'0','/uploadfiles/1990-01/19900124213130950.gif','120','50','2013-07-02 00:00:00','2023-07-11 00:00:00');
replace into `zzcms_ad` values('57','0','b','','#','2013-06-23 21:32:40','首页','A','',NULL,'0','/uploadfiles/2013-07/20130709213239911.gif','120','50','2013-07-09 00:00:00','2014-07-09 00:00:00');
replace into `zzcms_ad` values('58','0','c','','#','2013-06-23 21:32:48','首页','A','',NULL,'0','/uploadfiles/2013-07/20130709213247618.gif','120','50','2013-07-09 00:00:00','2014-07-09 00:00:00');
replace into `zzcms_ad` values('59','0','d','','#','2013-06-23 21:32:55','首页','A','',NULL,'0','/uploadfiles/2013-07/20130709213254230.gif','120','50','2013-07-09 00:00:00','2014-07-09 00:00:00');
replace into `zzcms_ad` values('60','0','e','','#','2013-06-23 21:34:46','首页','A','',NULL,'0','/uploadfiles/2013-07/20130709213443541.gif','120','50','2013-07-09 00:00:00','2014-07-09 00:00:00');

DROP TABLE IF EXISTS `zzcms_adclass`;
CREATE TABLE `zzcms_adclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(255) NOT NULL,
  `parentid` varchar(255) NOT NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_adclass` values('1','A','展示页','0');
replace into `zzcms_adclass` values('2','A','首页','0');
replace into `zzcms_adclass` values('3','free','free','0');

DROP TABLE IF EXISTS `zzcms_pay`;
CREATE TABLE `zzcms_pay` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `dowhat` varchar(255) default NULL,
  `RMB` int(11) default '0',
  `mark` varchar(255) default NULL,
  `sendtime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_pinglun`;
CREATE TABLE `zzcms_pinglun` (
  `id` int(11) NOT NULL auto_increment,
  `about` int(11) default '0',
  `content` varchar(255) default NULL,
  `face` varchar(50) default NULL,
  `username` varchar(50) default NULL,
  `ip` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_tagzx`;
CREATE TABLE `zzcms_tagzx` (
  `id` int(11) NOT NULL auto_increment,
  `xuhao` int(11) default '0',
  `keyword` varchar(50) default NULL,
  `url` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_tagzs`;
CREATE TABLE `zzcms_tagzs` (
  `id` int(11) NOT NULL auto_increment,
  `keyword` varchar(50) default NULL,
  `url` varchar(255) default NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_textadv`;
CREATE TABLE `zzcms_textadv` (
  `id` int(11) NOT NULL auto_increment,
  `adv` varchar(255) default NULL,
  `company` varchar(255) NOT NULL,
  `advlink` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `username` varchar(50) default NULL,
  `gxsj` datetime default NULL,
  `newsid` int(11) NOT NULL default '0',
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `adv` (`adv`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_user`;
CREATE TABLE `zzcms_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passwordtrue` varchar(255) NOT NULL,
  `qqid` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `agentadmin` varchar(255) default NULL,
  `sex` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `content` longtext,
  `province` varchar(25) default NULL,
  `city` varchar(25) default NULL,
  `xiancheng` varchar(25) default NULL,
  `address` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `flv` varchar(255) default NULL,
  `somane` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `mobile` varchar(255) default NULL,
  `fox` varchar(255) default NULL,
  `qq` varchar(255) default NULL,
  `regdate` datetime default NULL,
  `loginip` varchar(255) default NULL,
  `logins` int(11) NOT NULL default '0',
  `homepage` varchar(255) default NULL,
  `lastlogintime` datetime default NULL,
  `lockuser` tinyint(4) NOT NULL default '0',
  `groupid` int(11) NOT NULL default '1',
  `initRMB` int(11) NOT NULL default '0',
  `totleRMB` int(11) NOT NULL default '0',
  `startdate` datetime default NULL,
  `enddate` datetime default NULL,
  `showloginip` varchar(255) default NULL,
  `showlogintime` datetime default NULL,
  `elite` tinyint(4) NOT NULL default '0',
  `renzheng` tinyint(4) NOT NULL default '0',
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_usergroup`;
CREATE TABLE `zzcms_usergroup` (
  `id` int(11) NOT NULL auto_increment,
  `groupid` int(11) NOT NULL default '1',
  `groupname` varchar(255) NOT NULL,
  `grouppic` varchar(255) NOT NULL,
  `RMB` int(11) NOT NULL default '0',
  `looked_dls_number_oneday` int(11) NOT NULL default '0',
  `config` varchar(1000) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_usergroup` values('1','1','普通会员','/image/level1.gif','0','0','');
replace into `zzcms_usergroup` values('2','2','vip会员','/image/level2.gif','0','1','');
replace into `zzcms_usergroup` values('3','3','高级会员','/image/level3.gif','232','0','');

DROP TABLE IF EXISTS `zzcms_usermessage`;
CREATE TABLE `zzcms_usermessage` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `sendtime` datetime default NULL,
  `reply` varchar(1000) default NULL,
  `replytime` datetime default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_usernoreg`;
CREATE TABLE `zzcms_usernoreg` (
  `id` int(11) NOT NULL auto_increment,
  `usersf` varchar(50) default NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `kind` int(11) NOT NULL default '0',
  `somane` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `checkcode` varchar(255) default NULL,
  `regdate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zsclass`;
CREATE TABLE `zzcms_zsclass` (
  `classid` int(11) NOT NULL auto_increment,
  `parentid` varchar(255) NOT NULL default 'A',
  `classname` varchar(255) NOT NULL,
  `classzm` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL default '0',
  `xuhao` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  `isshow` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zx`;
CREATE TABLE `zzcms_zx` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassid` int(11) default NULL,
  `smallclassname` varchar(50) default NULL,
  `title` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `laiyuan` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  `elite` tinyint(4) default '0',
  `groupid` int(11) default '1',
  `jifen` int(11) default '0',
  `skin` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zxclass`;
CREATE TABLE `zzcms_zxclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(50) default NULL,
  `parentid` int(11) default '0',
  `xuhao` int(11) default '0',
  `isshowforuser` tinyint(4) default '1',
  `isshowininfo` tinyint(4) default '1',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  `skin` varchar(255) default NULL,
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8