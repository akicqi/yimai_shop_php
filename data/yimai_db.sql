-- MySQL dump 10.13  Distrib 5.5.28, for Win32 (x86)
--
-- Host: localhost    Database: yimai
-- ------------------------------------------------------
-- Server version	5.5.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ym_admin`
--

DROP TABLE IF EXISTS `ym_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `a_username` varchar(20) NOT NULL COMMENT '管理员账号',
  `a_password` char(50) DEFAULT NULL,
  `a_email` varchar(50) NOT NULL COMMENT '管理员邮箱',
  `getpasstime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `a_username` (`a_username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_admin`
--

LOCK TABLES `ym_admin` WRITE;
/*!40000 ALTER TABLE `ym_admin` DISABLE KEYS */;
INSERT INTO `ym_admin` VALUES (7,'akic4','c274356a86dab629a36523a0bcae7ec8a9676f24','584747429@qq.com',1432045135),(10,'admin','8df9a490a7ad3d2997fdc88f734665a3d6885574','23523525@qq.com',0),(12,'akic3','2894d58dcbf0c10089caa6e4c61fe103684e29df','1577011161@qq.com',1432055505),(13,'akic5','2d2354db1accba75d297ce358ee373954dd72f2a','624816868@qq.com',0);
/*!40000 ALTER TABLE `ym_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_cart`
--

DROP TABLE IF EXISTS `ym_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_cart` (
  `u_id` int(11) NOT NULL COMMENT '用户ID',
  `g_id` int(11) NOT NULL COMMENT '购物车内商品的id',
  `sess_id` char(36) DEFAULT NULL COMMENT 'session的ID',
  `c_name` varchar(20) NOT NULL COMMENT '购物车内商品的名字',
  `c_price` decimal(10,2) DEFAULT NULL COMMENT '购物车内商品价格',
  `c_number` int(11) DEFAULT NULL COMMENT '购物车内商品的数量',
  `g_code` char(10) DEFAULT '',
  PRIMARY KEY (`u_id`,`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_cart`
--

LOCK TABLES `ym_cart` WRITE;
/*!40000 ALTER TABLE `ym_cart` DISABLE KEYS */;
INSERT INTO `ym_cart` VALUES (1,41,'h65786jqskvekvqlf0gqhs64g2','婴贝儿',48.00,3,'YM000006'),(2,1,'c1hov8efq1v5mhi7heqdbndaj6','钢铁是怎样',100.00,1,'YM000000'),(2,2,'1dhpji4jauo9nag5re97au8k71','清凉的夏',50.00,1,'YM000001'),(2,3,'1dhpji4jauo9nag5re97au8k71','叠加式哑铃',68.00,1,'YM000002'),(5,41,'l1bnaddlj5ju8vbefbgdj79755','婴贝儿',48.00,1,'YM000006'),(7,41,'5drcharaplpbjhv89cch8gq3q3','婴贝儿',48.00,4,'YM000006'),(8,42,'2mbac0qvptavsjvohqie8qi8b6','五香葵瓜子',5.00,1,'YM000007'),(8,45,'2mbac0qvptavsjvohqie8qi8b6','劳力士',29999.00,1,'YM000010'),(8,47,'2mbac0qvptavsjvohqie8qi8b6','三开式双门冰箱',499.00,1,'YM000012');
/*!40000 ALTER TABLE `ym_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_category`
--

DROP TABLE IF EXISTS `ym_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(20) NOT NULL COMMENT '商品名称',
  `c_goods` int(11) DEFAULT NULL COMMENT '商品库存',
  `c_parent_id` int(11) DEFAULT '0' COMMENT '商品分类父类id：0表示顶级分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_category`
--

LOCK TABLES `ym_category` WRITE;
/*!40000 ALTER TABLE `ym_category` DISABLE KEYS */;
INSERT INTO `ym_category` VALUES (1,'图书音像',2,0),(2,'图书',1,1),(3,'音乐',1,1),(4,'百货',0,0),(5,'运动健康',0,4),(6,'服装',2,4),(7,'家居',4,4),(8,'美妆',6,4),(9,'母婴',1,4),(10,'食品',0,4),(11,'手机数码',10,4),(12,'家具首饰',3,4),(13,'手表饰品',12,4),(14,'鞋包',8,4),(15,'家电',1,4),(16,'电脑办公',2,4),(17,'玩具文具',1,4),(19,'度娘',1,1);
/*!40000 ALTER TABLE `ym_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_goods`
--

DROP TABLE IF EXISTS `ym_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名字',
  `g_code` char(10) DEFAULT NULL COMMENT '货号：具有唯一性',
  `c_id` int(11) NOT NULL DEFAULT '1' COMMENT '商品分类',
  `g_inv` int(10) unsigned DEFAULT '100' COMMENT '商品库存',
  `g_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `g_bar_price` decimal(10,2) DEFAULT '88.00' COMMENT '商品特价',
  `g_is_offer` tinyint(4) DEFAULT '0' COMMENT '商品是否是特价商品',
  `g_is_hot` tinyint(4) DEFAULT '0' COMMENT '热销商品',
  `g_brand` varchar(20) DEFAULT NULL COMMENT '商品品牌',
  `g_desc` text COMMENT '商品描述',
  `g_image` varchar(50) DEFAULT NULL COMMENT '商品图片的路径：原图',
  `g_thumb` varchar(50) DEFAULT NULL COMMENT '商品图片：缩略图',
  `g_water` varchar(50) DEFAULT NULL COMMENT '商品图片：水印',
  `g_sort` int(11) DEFAULT '50' COMMENT '商品排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `g_code` (`g_code`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_goods`
--

LOCK TABLES `ym_goods` WRITE;
/*!40000 ALTER TABLE `ym_goods` DISABLE KEYS */;
INSERT INTO `ym_goods` VALUES (41,'婴贝儿','YM000006',4,0,48.00,1.00,0,0,'母婴直营','','','','',50),(42,'五香葵瓜子','YM000007',4,0,5.00,1.00,0,0,'食品直营','','','','',50),(43,'iPhone6','YM000008',2,0,5299.00,1.00,0,0,'手机直营','','','','',50),(44,'3D壁钟','YM000009',1,0,3888.00,1.00,0,0,'家具直营','','','','',50),(45,'劳力士','YM000010',2,0,29999.00,1.00,0,0,'手机直营','','','','',50),(47,'三开式双门冰箱','YM000012',4,0,499.00,1.00,0,0,'鞋包直营','','','','',50),(48,'名牌钢笔','YM000013',4,0,199.00,1.00,0,0,'玩具文具直营','','','','',50),(55,'键盘','YM000018',16,100,100.00,88.00,0,0,'',NULL,'','','',50),(57,'衣服','YM000020',6,100,100.00,88.00,0,0,'',NULL,'','','',50),(58,'鼠标垫','YM000021',11,100,30.00,88.00,0,0,'',NULL,'','','',50),(59,'雨伞','YM000022',7,100,50.00,88.00,0,0,'',NULL,'','','',50),(61,'星巴克','YM000001',3,20,20.00,88.00,0,0,'星巴克',NULL,'20150519161641CAmKDE.jpg','','',50);
/*!40000 ALTER TABLE `ym_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_guestbook`
--

DROP TABLE IF EXISTS `ym_guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_guestbook` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `g_name` varchar(10) NOT NULL COMMENT '用户姓名',
  `g_send_message` text,
  `g_send_text` text COMMENT '用户留言的内容',
  `g_send_time` int(11) DEFAULT NULL,
  `g_is_replay` int(11) DEFAULT '0',
  `g_text_replay` text,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_guestbook`
--

LOCK TABLES `ym_guestbook` WRITE;
/*!40000 ALTER TABLE `ym_guestbook` DISABLE KEYS */;
INSERT INTO `ym_guestbook` VALUES (5,'alice',NULL,'哈哈',NULL,1,'dggdgf'),(7,'alice',NULL,'哈哈',NULL,1,'d'),(8,'alice',NULL,'哈哈',NULL,1,'你有病啊？'),(9,'alice',NULL,'哈哈',NULL,1,'要死啦'),(11,'去屎吧',NULL,'哈哈',NULL,1,'韩国的？'),(12,'去屎吧',NULL,'哈哈',NULL,0,NULL),(13,'去屎吧',NULL,'哈哈',NULL,0,NULL),(14,'该死的留言板',NULL,'哈哈',NULL,1,'我和你没仇'),(15,'该死的留言板',NULL,'哈哈',NULL,0,NULL),(32,'江文','啊啊啊啊啊啊','阿迪',NULL,0,NULL),(33,'nini','nii','nin',NULL,0,NULL),(34,'akic','akic','akic',NULL,0,NULL),(35,'aaa','aa','aa',NULL,0,NULL),(36,'咪咪','我的货呢','用空运吗',NULL,0,NULL);
/*!40000 ALTER TABLE `ym_guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_news`
--

DROP TABLE IF EXISTS `ym_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `n_title` varchar(30) DEFAULT NULL COMMENT '新闻标题',
  `n_content` text COMMENT '新闻内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_news`
--

LOCK TABLES `ym_news` WRITE;
/*!40000 ALTER TABLE `ym_news` DISABLE KEYS */;
INSERT INTO `ym_news` VALUES (1,'猪八戒爱上孙悟空','<h1>&nbsp;&nbsp;&nbsp;<strong>&nbsp; &nbsp;&nbsp;&nbsp;猪八戒爱上孙悟空啦！</strong></h1>\r\n\r\n<p><span class=\"marker\"><strong>&nbsp;</strong><em>消息来自新浪网:</em></span></p>\r\n'),(4,'蛇精男','<ol>\r\n	<li>\r\n	<h3>【15岁<em>蛇精男</em><span class=\"marker\"><strong>刘梓晨</strong></span>PK韩安冉Abby李蒽熙Danae】近日,刘梓晨的一组照片在网上热传,看了15岁<em>蛇精男</em>刘梓晨照片,瞬间觉得韩安冉Abby李蒽熙Danae美爆了。</h3>\r\n	</li>\r\n	<li>瞬间觉得韩安冉Abby李蒽熙Danae美爆了。<img alt=\"\" src=\"/admin/upload/images/2015/05/19/20150519154026yxzLyU.jpg\" style=\"height:240px; width:240px\" /></li>\r\n</ol>\r\n');
/*!40000 ALTER TABLE `ym_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_order_goods`
--

DROP TABLE IF EXISTS `ym_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_id` char(10) NOT NULL COMMENT '订单订单id',
  `g_id` int(11) NOT NULL COMMENT '该订单的商品ID',
  `g_code` char(10) NOT NULL COMMENT '该订单商品的货号',
  `o_name` varchar(20) NOT NULL COMMENT '订单内商品的名字',
  `o_price` decimal(10,2) NOT NULL COMMENT '订单内商品的价格',
  `o_number` int(11) NOT NULL COMMENT '订单内商品的数量',
  `o_comment` text COMMENT '用户备注',
  `o_is_pay` int(11) DEFAULT '0' COMMENT '用户是否支付',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_order_goods`
--

LOCK TABLES `ym_order_goods` WRITE;
/*!40000 ALTER TABLE `ym_order_goods` DISABLE KEYS */;
INSERT INTO `ym_order_goods` VALUES (1,'2',1,'YM000000','钢铁是怎样',100.00,1,'',1),(2,'6',41,'YM000006','婴贝儿',48.00,1,'',1),(3,'7',41,'YM000006','婴贝儿',48.00,1,'',1),(4,'8',43,'YM000008','iPhone6',5299.00,1,'',1),(5,'9',41,'YM000006','婴贝儿',48.00,1,'',1),(6,'10',43,'YM000008','iPhone6',5299.00,1,'',1),(7,'11',42,'YM000007','五香葵瓜子',5.00,1,'',1);
/*!40000 ALTER TABLE `ym_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_order_info`
--

DROP TABLE IF EXISTS `ym_order_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_order_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '该订单的用户id',
  `i_number` char(10) NOT NULL COMMENT '该订单的订单号',
  `i_name` varchar(20) NOT NULL COMMENT '接收人姓名',
  `i_phone` char(11) NOT NULL COMMENT '接收人电话',
  `i_address` varchar(50) NOT NULL COMMENT '接收人地址',
  `status` int(11) DEFAULT '0' COMMENT '订单状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `i_number` (`i_number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_order_info`
--

LOCK TABLES `ym_order_info` WRITE;
/*!40000 ALTER TABLE `ym_order_info` DISABLE KEYS */;
INSERT INTO `ym_order_info` VALUES (1,1,'0000000001','江文','18280933905','广东省广州市天河区棠东毓桂大街一巷29号',1),(2,1,'0000000002','江文','18280933905','广东省广州市天河区棠东毓桂大街一巷29号',1),(3,1,'0000000003','ada','15088138276','广东省广州市天河区asdasd',1),(6,4,'0000000004','akic','15088138276','广东省广州市天河区arq',0),(7,4,'0000000005','asdas','15088138276','广东省广州市天河区asdad',0),(8,4,'0000000006','1sfr','12345678901','广东省广州市天河区',0),(9,4,'0000000007','akk','15088138276','广东省广州市天河区aa',0),(10,6,'0000000008','jason','13167890345','广东省广州市天河区棠东韵达',0),(11,9,'0000000009','咪咪','18677577631','广东省广州市天河区广东',0);
/*!40000 ALTER TABLE `ym_order_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_session`
--

DROP TABLE IF EXISTS `ym_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_session` (
  `sess_id` char(36) NOT NULL COMMENT 'sessionID',
  `sess_content` text COMMENT 'session内容',
  `sess_expire` int(11) DEFAULT NULL COMMENT 'session最后更新时间',
  PRIMARY KEY (`sess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_session`
--

LOCK TABLES `ym_session` WRITE;
/*!40000 ALTER TABLE `ym_session` DISABLE KEYS */;
INSERT INTO `ym_session` VALUES ('02s78b731jtpsljkp4eg1cb7d3','',1432088999),('041v51u4i8fhn9697t26b4ovm6','captcha|s:4:\"b3Tr\";userreset|s:2:\"12\";u_id|s:2:\"12\";',1432053950),('08d41ev9s42tj5ojqa07h9p0o2','uri|s:25:\"/index.php?act=view&id=42\";captcha|s:4:\"nRdw\";user_id|s:1:\"9\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"9\";s:4:\"g_id\";s:2:\"42\";s:7:\"sess_id\";s:26:\"08d41ev9s42tj5ojqa07h9p0o2\";s:6:\"c_name\";s:15:\"五香葵瓜子\";s:7:\"c_price\";s:4:\"5.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000007\";}totalPrice|s:1:\"5\";orderNumber|s:10:\"0000000009\";orderId|s:2:\"11\";',1432090574),('12plf4632it9cer8o3n90il8t2','captcha|s:4:\"VtDM\";',1432054123),('15hcmcputs251i6grj58otpl80','captcha|s:4:\"7SFc\";userreset|s:2:\"12\";',1432054611),('1a6ed2f7qm8j6478fqtm3bng65','',1432088048),('22j6h7an2m94d43dg2lpcp0c87','captcha|s:4:\"sJL8\";u_id|s:1:\"7\";gettId|s:2:\"13\";uri|s:31:\"/yimai/index.php?act=view&id=41\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"22j6h7an2m94d43dg2lpcp0c87\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000006\";}totalPrice|s:2:\"48\";orderNumber|s:10:\"0000000005\";orderId|s:1:\"7\";',1432055438),('28nq0m4kogv5eh8ig196b1a5v4','uri|s:25:\"/index.php?act=view&id=45\";captcha|s:4:\"9XiV\";',1432090575),('2mbac0qvptavsjvohqie8qi8b6','uri|s:25:\"/index.php?act=view&id=47\";captcha|s:4:\"7e8m\";user_id|s:1:\"8\";',1432090358),('2sejopvvasnfl8ps2spmv13rn0','captcha|s:4:\"EGcP\";u_id|s:1:\"7\";id|s:1:\"2\";gettId|s:2:\"13\";',1432052586),('49b48j7ojoj6gfj4v84rkpme76','uri|s:25:\"/index.php?act=view&id=42\";',1432084944),('4hlu81uc2s79hm2lupjtabc7m2','',1432088396),('55q5veohqml6a8k2k8ve09b6k7','',1432087791),('5drcharaplpbjhv89cch8gq3q3','uri|s:26:\"/index.php?act=view&id=41#\";captcha|s:4:\"wwtv\";user_id|s:1:\"7\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"7\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"5drcharaplpbjhv89cch8gq3q3\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"3\";s:6:\"g_code\";s:8:\"YM000006\";}',1432090352),('65abc7bv6s33dbrja77qs8s182','captcha|s:4:\"fUnm\";u_id|s:1:\"7\";id|s:1:\"2\";gettId|s:2:\"13\";',1432090299),('66vfg9ata1l40gqi2lp15ghtd4','uri|s:25:\"/index.php?act=view&id=41\";',1432089529),('790bgciv02qjq7dun10uu5ipa3','captcha|s:4:\"r6mx\";uri|s:31:\"/yimai/index.php?act=view&id=41\";u_id|s:1:\"7\";id|s:1:\"3\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"790bgciv02qjq7dun10uu5ipa3\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000006\";}totalPrice|s:2:\"48\";orderNumber|s:10:\"0000000004\";orderId|s:1:\"6\";',1432049520),('8almvvkejvcon27ptnqhjb1fb5','uri|s:25:\"/index.php?act=view&id=41\";captcha|s:4:\"36ky\";',1432089032),('8fg5hhv54966lfhfe4eda5lv22','captcha|s:4:\"uH3e\";userreset|s:2:\"12\";',1432054580),('aku2r8n54kohuk8dh98mq7l866','uri|s:25:\"/index.php?act=view&id=41\";captcha|s:4:\"zK3E\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"aku2r8n54kohuk8dh98mq7l866\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000006\";}',1432085766),('anmoq9huvutnod2olhmfd70ag5','',1432085144),('arnjdu9vj8is4lkrrr189bfnr1','captcha|s:4:\"A7iJ\";u_id|s:1:\"7\";gettId|s:2:\"13\";',1432089515),('asvfm7aofr1i49uh3b4nc6hkv6','captcha|s:4:\"nyfc\";',1432090573),('bn5rg485ig2acg8gldretuitr4','captcha|s:4:\"UJvj\";u_id|s:1:\"7\";gettId|s:2:\"13\";uri|s:31:\"/yimai/index.php?act=view&id=41\";',1432084479),('cmna8tkfc9o4it7fbgglj773m1','captcha|s:4:\"tt2p\";u_id|s:1:\"7\";gettId|s:2:\"13\";',1432087488),('cpqpm2qi7t440i1ffo2dkosad3','gettId|s:2:\"13\";',1432085885),('d5n83hhd0jnoemt38hkukq3p87','captcha|s:4:\"5mPs\";u_id|s:1:\"7\";gettId|s:2:\"12\";',1432048377),('e6u9em9grat1rl62ic6s7lfen3','captcha|s:4:\"yUx5\";',1432054067),('ehuef37rfc81everqve3a2jvu1','captcha|s:4:\"2inf\";',1432055510),('gavn584m5l7luhbkke2q6m86u3','captcha|s:4:\"Jxnq\";uri|s:25:\"/index.php?act=view&id=43\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"43\";s:7:\"sess_id\";s:26:\"gavn584m5l7luhbkke2q6m86u3\";s:6:\"c_name\";s:7:\"iPhone6\";s:7:\"c_price\";s:7:\"5299.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000008\";}totalPrice|s:4:\"5299\";orderNumber|s:10:\"0000000006\";orderId|s:1:\"8\";',1432089289),('gfhjms4c958a70fmi8dms5nhn5','uri|s:25:\"/index.php?act=view&id=43\";captcha|s:4:\"E3g7\";user_id|s:1:\"6\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"6\";s:4:\"g_id\";s:2:\"43\";s:7:\"sess_id\";s:26:\"gfhjms4c958a70fmi8dms5nhn5\";s:6:\"c_name\";s:7:\"iPhone6\";s:7:\"c_price\";s:7:\"5299.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000008\";}totalPrice|s:4:\"5299\";orderNumber|s:10:\"0000000008\";orderId|s:2:\"10\";',1432090574),('hiad6jc1k696uv13mo430f78t1','',1432085070),('hp04hj0a53e7qipp01vld8vav7','uri|s:25:\"/index.php?act=view&id=41\";captcha|s:4:\"CzbA\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"hp04hj0a53e7qipp01vld8vav7\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"3\";s:6:\"g_code\";s:8:\"YM000006\";}',1432088783),('hqntf03lnsok121snbrefrmn33','captcha|s:4:\"usfd\";userreset|s:2:\"12\";u_id|s:1:\"7\";gettId|s:2:\"13\";id|s:1:\"4\";',1432055066),('j55sp3tpctq83mmqp0hib5cv41','uri|s:25:\"/index.php?act=view&id=44\";captcha|s:4:\"vRW8\";',1432089286),('l1bnaddlj5ju8vbefbgdj79755','captcha|s:4:\"P1tY\";user_id|s:1:\"5\";uri|s:25:\"/index.php?act=view&id=41\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"5\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"l1bnaddlj5ju8vbefbgdj79755\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000006\";}',1432090065),('mrvm4q0nq64bn2up69n5musea7','uri|s:25:\"/index.php?act=view&id=41\";captcha|s:4:\"fPVR\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"43\";s:7:\"sess_id\";s:26:\"gavn584m5l7luhbkke2q6m86u3\";s:6:\"c_name\";s:7:\"iPhone6\";s:7:\"c_price\";s:7:\"5299.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000008\";}u_id|s:1:\"7\";gettId|s:2:\"13\";',1432089321),('qaug9uiarjh09l2dqujhc0enj0','uri|s:25:\"/index.php?act=view&id=41\";captcha|s:4:\"AVDx\";user_id|s:1:\"4\";orderGoods|a:7:{s:4:\"u_id\";s:1:\"4\";s:4:\"g_id\";s:2:\"41\";s:7:\"sess_id\";s:26:\"qaug9uiarjh09l2dqujhc0enj0\";s:6:\"c_name\";s:9:\"婴贝儿\";s:7:\"c_price\";s:5:\"48.00\";s:8:\"c_number\";s:1:\"1\";s:6:\"g_code\";s:8:\"YM000006\";}totalPrice|s:2:\"48\";orderNumber|s:10:\"0000000007\";orderId|s:1:\"9\";',1432090223),('qisskil05fo1l0ijeadha4ovc2','captcha|s:4:\"d6CH\";uri|s:25:\"/index.php?act=view&id=43\";u_id|s:1:\"7\";gettId|s:2:\"13\";',1432086079),('r5j737fnv6n6e38hci14f2mfr5','captcha|s:4:\"g4dm\";userreset|s:2:\"12\";u_id|s:2:\"12\";',1432054866),('r7bmom5dsvg51uhvbku4kp13i3','',1432087817),('s6ckpp3srq1jdcjgm7ddhlnkl2','',1432088687),('u8mql38s0369clt36g0gjlspp1','captcha|s:4:\"KKl5\";',1432054529),('ubqtfsldsh6tvfgm6djal8c666','uri|s:25:\"/index.php?act=view&id=43\";captcha|s:4:\"cTjq\";',1432090504),('v2pu8qm5j116d5od7b36h7g5m7','',1432087741),('vnqbvqlogobcr2ua24f784je57','userreset|s:2:\"12\";captcha|s:4:\"hBRN\";',1432055525);
/*!40000 ALTER TABLE `ym_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ym_user`
--

DROP TABLE IF EXISTS `ym_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ym_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '设置id为主键并自增长',
  `u_username` varchar(20) NOT NULL COMMENT '用户名，具有唯一性',
  `u_password` char(32) NOT NULL COMMENT '用户名密码，采用md5加密',
  `u_name` varchar(10) DEFAULT NULL,
  `u_sex` tinyint(4) DEFAULT NULL,
  `u_Email` varchar(50) DEFAULT NULL COMMENT '用户邮件',
  `u_number` char(11) DEFAULT NULL,
  `u_address` varchar(100) DEFAULT NULL,
  `u_headportrait` varchar(25) DEFAULT NULL COMMENT '用户头像',
  `u_time` int(11) DEFAULT NULL COMMENT '用户出身日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_Email` (`u_Email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ym_user`
--

LOCK TABLES `ym_user` WRITE;
/*!40000 ALTER TABLE `ym_user` DISABLE KEYS */;
INSERT INTO `ym_user` VALUES (2,'qw','6bdcbb606161c47eab0615ff6e13313f','詹',0,'qwe','qw','eqw','',2000122),(3,'akic','','akic',0,'124124@qq.com','3356416','gdgasga','20150519232038WvBOWB.jpg',2000122),(4,'akic2','5f59ba7958e1dfce21ca57ebc6caa8c0','akic',0,'1414141@qq.com','251252352','dsqre','241414.jpg',322512),(5,'admin','5f86a9d014a82f0964d0a91b3909725d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'jason','0db5f83b7de3c136a67caa6190c06a8b',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'1132','3fdc15257463ff0ae74cfb61686469e2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'admin1','59a0118589314e4d2484fa398c4509e5',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'mimi','0db5f83b7de3c136a67caa6190c06a8b',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ym_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-20 10:56:16
