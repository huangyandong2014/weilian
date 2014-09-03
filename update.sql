ALTER TABLE `wp_follow` ADD COLUMN `mTime`  int(10) NOT NULL COMMENT '更新时间' AFTER `experience`;
ALTER TABLE `wp_ucenter_app` MODIFY COLUMN `sys_login`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '同步登录' AFTER `auth_key`;

CREATE TABLE `wp_import` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`attach`  int(10) UNSIGNED NOT NULL COMMENT '上传文件' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_qr_code` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`qr_code`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '二维码' ,
`addon`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '二维码所属插件' ,
`aim_id`  int(10) UNSIGNED NOT NULL COMMENT '插件表里的ID值' ,
`cTime`  int(10) NOT NULL COMMENT '创建时间' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Token' ,
`action_name`  char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'QR_SCENE' COMMENT '二维码类型' ,
`extra_text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '文本扩展' ,
`extra_int`  int(10) NULL DEFAULT NULL COMMENT '数字扩展' ,
`request_count`  int(10) NOT NULL DEFAULT 0 COMMENT '请求数' ,
`scene_id`  int(10) NOT NULL DEFAULT 0 COMMENT '场景ID' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_smalltools` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`tooltype`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '工具类型' ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ' 关键词 ' ,
`cTime`  int(10) NOT NULL COMMENT '创建时间' ,
`toolname`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '工具名称' ,
`tooldes`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '工具描述' ,
`toolnum`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '工具唯一编号' ,
`toolstate`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '工具状态' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Token' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;


CREATE TABLE `wp_youaskservice_behavior` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`fid`  int(11) NOT NULL ,
`token`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`openid`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`date`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`enddate`  int(11) NOT NULL ,
`model`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`num`  int(11) NOT NULL ,
`keyword`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`type`  tinyint(1) NOT NULL ,
PRIMARY KEY (`id`),
INDEX `openid` (`openid`) USING BTREE 
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_group` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`groupname`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分组名称' ,
`groupdata`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分组数据源' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_keyword` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`msgkeyword`  varchar(555) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '消息关键字' ,
`msgkeyword_type`  char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '3' COMMENT '关键字类型' ,
`msgkfaccount`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接待的客服人员' ,
`cTime`  int(10) NOT NULL COMMENT '创建时间' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`msgstate`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '关键字状态' ,
`zjnum`  int(10) NOT NULL COMMENT '转接次数' ,
`zdtype`  char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '指定类型' ,
`kfgroupid`  int(10) NOT NULL DEFAULT 0 COMMENT '客服分组id' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_logs` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`pid`  int(11) NOT NULL ,
`openid`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`enddate`  int(11) NOT NULL ,
`keyword`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`status`  tinyint(1) NOT NULL DEFAULT 2 ,
PRIMARY KEY (`id`),
INDEX `pid` (`pid`) USING BTREE 
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_user` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服昵称' ,
`token`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`userName`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服帐号' ,
`userPwd`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服密码' ,
`endJoinDate`  int(11) NOT NULL COMMENT '客服加入时间' ,
`status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '客服在线状态' ,
`state`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '客服状态' ,
`isdelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`kfid`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服编号' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_wechat_enddate` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`openid`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`enddate`  int(11) NOT NULL ,
`joinUpDate`  int(11) NOT NULL DEFAULT 0 ,
`uid`  int(11) NOT NULL DEFAULT 0 ,
`token`  varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_wechat_grouplist` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`g_id`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`nickname`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`sex`  tinyint(1) NOT NULL ,
`province`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`city`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`headimgurl`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`subscribe_time`  int(11) NOT NULL ,
`token`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`openid`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`status`  tinyint(1) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_wxlogs` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`worker`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服名称' ,
`openid`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'openid' ,
`opercode`  int(10) NOT NULL COMMENT '会话状态' ,
`time`  int(10) NOT NULL COMMENT '时间' ,
`text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '消息' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;
