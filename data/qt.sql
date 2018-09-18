/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : qt

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2018-09-18 11:40:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qt_channel
-- ----------------------------
DROP TABLE IF EXISTS `qt_channel`;
CREATE TABLE `qt_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '频道名称',
  `status` int(1) NOT NULL,
  `path` varchar(255) NOT NULL COMMENT '访问路径',
  `weight` int(10) NOT NULL COMMENT '比重',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键字',
  `description` text COMMENT '描述',
  `delete` int(1) NOT NULL DEFAULT '0' COMMENT '1=删除',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qt_channel
-- ----------------------------
INSERT INTO `qt_channel` VALUES ('1', '文章', '0', 'article', '1', '内容, 文章', '内容文章', '0', '2018-05-11 16:42:44', '2018-05-11 16:47:57');
INSERT INTO `qt_channel` VALUES ('2', 'test11', '0', 'test', '12', 'test', 'testestest', '0', '2018-09-17 16:20:57', '2018-09-17 17:16:52');
INSERT INTO `qt_channel` VALUES ('3', 'test11112', '0', 't2', '0', 't2', '1112223333213213', '0', '2018-09-17 16:21:48', '2018-09-17 17:16:42');
INSERT INTO `qt_channel` VALUES ('4', '1212333', '0', '1212', '1212', '1212', '1212', '0', '2018-09-17 17:18:57', '2018-09-18 11:13:53');
INSERT INTO `qt_channel` VALUES ('5', '331', '0', '33', '33', '33', '33', '1', '2018-09-17 17:19:08', '2018-09-17 17:26:30');

-- ----------------------------
-- Table structure for qt_user
-- ----------------------------
DROP TABLE IF EXISTS `qt_user`;
CREATE TABLE `qt_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL DEFAULT '0' COMMENT '判断是否登录的session_id',
  `role_id` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '角色id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '默认是正常状态,0为禁止',
  `delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除 1正常 2已删除',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名称',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(16) NOT NULL DEFAULT '' COMMENT '邮箱',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `address` varchar(16) NOT NULL DEFAULT '' COMMENT '地址',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 1男2女',
  `register_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=手机号 2=微信 3=qq',
  `register_account` varchar(16) NOT NULL DEFAULT '' COMMENT '注册账号',
  `register_source` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '注册来源:1=PC, 2=IOS, 3=Android, 4=后台添加,5=webapp',
  `register_ip` varchar(100) NOT NULL DEFAULT '0' COMMENT '注册ip',
  `login_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '登录方式:0未知1网站,2APP,3微信,4,Android,5iOS,6QQ登录 ',
  `login_device_id` varchar(32) NOT NULL DEFAULT '0' COMMENT 'App最后登录的设备ID',
  `login_app_version` varchar(16) NOT NULL DEFAULT '0' COMMENT 'App最后登录的版本号',
  `login_mobile_models` varchar(64) NOT NULL DEFAULT '0' COMMENT 'App最后登录的手机型号',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_last_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_last_ip` varchar(100) NOT NULL DEFAULT '0' COMMENT '最后登陆ip',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE,
  KEY `register_ip` (`register_ip`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `delete` (`delete`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of qt_user
-- ----------------------------
