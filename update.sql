ALTER TABLE `wp_follow` ADD COLUMN `mTime`  int(10) NOT NULL COMMENT '����ʱ��' AFTER `experience`;
ALTER TABLE `wp_ucenter_app` MODIFY COLUMN `sys_login`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'ͬ����¼' AFTER `auth_key`;

CREATE TABLE `wp_import` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`attach`  int(10) UNSIGNED NOT NULL COMMENT '�ϴ��ļ�' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_qr_code` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`qr_code`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��ά��' ,
`addon`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��ά���������' ,
`aim_id`  int(10) UNSIGNED NOT NULL COMMENT '��������IDֵ' ,
`cTime`  int(10) NOT NULL COMMENT '����ʱ��' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Token' ,
`action_name`  char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'QR_SCENE' COMMENT '��ά������' ,
`extra_text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '�ı���չ' ,
`extra_int`  int(10) NULL DEFAULT NULL COMMENT '������չ' ,
`request_count`  int(10) NOT NULL DEFAULT 0 COMMENT '������' ,
`scene_id`  int(10) NOT NULL DEFAULT 0 COMMENT '����ID' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_smalltools` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`tooltype`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '��������' ,
`keyword`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ' �ؼ��� ' ,
`cTime`  int(10) NOT NULL COMMENT '����ʱ��' ,
`toolname`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��������' ,
`tooldes`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��������' ,
`toolnum`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '����Ψһ���' ,
`toolstate`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '����״̬' ,
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
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`groupname`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��������' ,
`groupdata`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��������Դ' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;

CREATE TABLE `wp_youaskservice_keyword` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`msgkeyword`  varchar(555) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��Ϣ�ؼ���' ,
`msgkeyword_type`  char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '3' COMMENT '�ؼ�������' ,
`msgkfaccount`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�Ӵ��Ŀͷ���Ա' ,
`cTime`  int(10) NOT NULL COMMENT '����ʱ��' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`msgstate`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '�ؼ���״̬' ,
`zjnum`  int(10) NOT NULL COMMENT 'ת�Ӵ���' ,
`zdtype`  char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT 'ָ������' ,
`kfgroupid`  int(10) NOT NULL DEFAULT 0 COMMENT '�ͷ�����id' ,
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
`name`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�ͷ��ǳ�' ,
`token`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`userName`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�ͷ��ʺ�' ,
`userPwd`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�ͷ�����' ,
`endJoinDate`  int(11) NOT NULL COMMENT '�ͷ�����ʱ��' ,
`status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '�ͷ�����״̬' ,
`state`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '�ͷ�״̬' ,
`isdelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '�Ƿ�ɾ��' ,
`kfid`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�ͷ����' ,
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
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����' ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'token' ,
`worker`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '�ͷ�����' ,
`openid`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'openid' ,
`opercode`  int(10) NOT NULL COMMENT '�Ự״̬' ,
`time`  int(10) NOT NULL COMMENT 'ʱ��' ,
`text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '��Ϣ' ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0;
