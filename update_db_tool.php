<?php
set_time_limit ( 0 );
$prefix = C ( 'DB_PREFIX' );

$map ['name'] = 'SYSTEM_UPDATRE_VERSION';
$res = M ( 'config' )->where ( $map )->getField ( 'value' );

if ($res < 20140711) {
	$this->error ( '该补丁包需要先升级到7月11号发布补丁包版本再升级' );
	exit ();
}
if ($res >= 20140826) {
	$this->error ( '请不要重复执行数据库升级' );
	exit ();
}

unset ( $map );

$install_sql = './update.sql';
execute_sql_file ( $install_sql );

M ( 'config' )->where ( 'name="WEB_SITE_CLOSE"' )->setField ( 'extra', "0:关闭 \r\n1:开启" );
M ( 'config' )->where ( 'name="WEB_SITE_VERIFY"' )->setField ( 'extra', "0:关闭 \r\n1:开启" );

$modelArr = array (
		'Chat' => array (
				'config' => '{"tuling_key":"d812d695a5e0df258df952698faca6cc","tuling_url":"http:\\/\\/www.tuling123.com\\/openapi\\/api","simsim_key":"41250a68-3cb5-43c8-9aa2-d7b3caf519b1","simsim_url":"http:\\/\\/sandbox.api.simsimi.com\\/request.p","i9_url":"http:\\/\\/www.xiaojo.com\\/bot\\/chata.php","rand_reply":"\\u6211\\u4eca\\u5929\\u7d2f\\u4e86\\uff0c\\u660e\\u5929\\u518d\\u966a\\u4f60\\u804a\\u5929\\u5427\\r\\n\\u54c8\\u54c8~~\\r\\n\\u4f60\\u8bdd\\u597d\\u591a\\u554a\\uff0c\\u4e0d\\u8ddf\\u4f60\\u804a\\u4e86\\r\\n\\u867d\\u7136\\u4e0d\\u61c2\\uff0c\\u4f46\\u89c9\\u5f97\\u4f60\\u8bf4\\u5f97\\u5f88\\u5bf9"}' 
		),
		'Wecome' => array (
				'config' => '{"type":"1","title":"","description":"欢迎关注，请绑定帐号后体验更多功能","pic_url":"","url":""}' 
		) 
);
foreach ( $modelArr as $name => $save ) {
	$res = M ( 'addons' )->where ( "name='$name'" )->save ( $save );
	// dump ( $res );
	// lastsql ();
}

$sqlArr = array (
		0 => 'INSERT INTO wp_addons (`name`,`title`,`description`,`status`,`config`,`author`,`version`,`create_time`,`has_adminlist`,`type`,`cate_id`) VALUES (\'YouaskService\',\'你问我答客服系统\',\'一个支持你问我答,关键词制定客服的客服系统\',\'1\',\'null\',\'陌路生人\',\'0.1\',\'1403947448\',\'1\',\'1\',\'1\');' 
);
foreach ( $sqlArr as $vo ) {
	$res = M ()->execute ( $vo );
	// dump ( $res );
	// dump ( $vo );
}

$modelArr = array (
		'keyword' => array (
				'field_sort' => '{"1":["keyword","keyword_type","addon","aim_id","keyword_length","cTime","extra_text","extra_int"]}' 
		),
		'custom_menu' => array (
				'field_sort' => '{"1":["sort","pid","title","keyword","url"]}',
				'list_grid' => 'title:10%菜单名\r\nkeyword:10%关联关键词\r\nurl:50%关联URL\r\nsort:5%排序号\r\nid:10%操作:[EDIT]|编辑,[DELETE]|删除' 
		),
		'weisite_category' => array (
				'field_sort' => '{"1":["title","icon","url","is_show","status","sort","pid"]}',
				'list_grid' => 'title:15%分类标题\r\nicon|get_img-html:分类图片\r\nurl:30%外链 sort:10%排序号\r\nis_show|get_name_by_status:10%显示\r\nid:10%操作:[EDIT]|编辑,[DELETE]|删除' 
		),
		'weisite_cms' => array (
				'field_sort' => '{"1":["keyword","keyword_type","title","intro","cate_id","cover","content","sort"]}',
				'list_grid' => 'keyword:关键词\r\nkeyword_type|get_name_by_status:关键词类型\r\ntitle:标题\r\ncate_id:所属分类\r\nsort:排序号\r\nview_count:浏览数\r\nid:操作:[EDIT]&module_id=[pid]|编辑,[DELETE]|删除' 
		),
		'weisite_slideshow' => array (
				'list_grid' => 'title:标题\r\nimg:图片\r\nurl:链接地址\r\nis_show|get_name_by_status:显示\r\nsort:排序\r\nid:操作:[EDIT]&module_id=[pid]|编辑,[DELETE]|删除' 
		) 
);
foreach ( $modelArr as $name => $save ) {
	$res = M ( 'model' )->where ( "name='$name'" )->save ( $save );
	// dump ( $res );
	// lastsql ();
}

$sqlArr = array (
		0 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_user\',\'你问我答-客服工号\',\'0\',\'\',\'1\',\'{"1":["name","userName","userPwd","state","kfid"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'kfid:编号\r\nname:客服昵称\r\nuserName:客服帐号\',\'10\',\'name\',\'userName\',\'1403947253\',\'1404398415\',\'1\',\'MyISAM\');',
		1 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_logs\',\'你问我答-聊天记录管理\',\'0\',\'\',\'1\',\'{"1":["pid","openid","enddate","keyword","status"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'id:编号\r\nkeyword:回复内容\r\nenddate:回复时间\',\'10\',\'keyword\',\'\',\'1403947270\',\'1404060187\',\'1\',\'MyISAM\');',
		2 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_keyword\',\'你问我答-关键词指配\',\'0\',\'\',\'1\',\'{"1":["msgkeyword","msgkeyword_type","zdtype","msgstate"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'id:编号\r\nmsgkeyword:关键字\r\nmsgkeyword_type|get_name_by_status:匹配类型\r\nmsgkfaccount:指定的接待客服或分组\r\nmsgstate|get_name_by_status:状态\r\nid:操作:[EDIT]|编辑,[DELETE]|删除\',\'10\',\'msgkeyword\',\'\',\'1404399143\',\'1404493938\',\'1\',\'MyISAM\');',
		3 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_wechat_enddate\',\'youaskservice_wechat_enddate\',\'0\',\'\',\'1\',\'\',\'1:基础\',\'\',\'\',\'\',\'\',\'\',\'10\',\'\',\'\',\'1404026714\',\'1404026714\',\'1\',\'MyISAM\');',
		4 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_wechat_grouplist\',\'youaskservice_wechat_grouplist\',\'0\',\'\',\'1\',\'\',\'1:基础\',\'\',\'\',\'\',\'\',\'\',\'10\',\'\',\'\',\'1404027300\',\'1404027300\',\'1\',\'MyISAM\');',
		5 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_behavior\',\'youaskservice_behavior\',\'0\',\'\',\'1\',\'\',\'1:基础\',\'\',\'\',\'\',\'\',\'\',\'10\',\'\',\'\',\'1404033501\',\'1404033501\',\'1\',\'MyISAM\');',
		6 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'smalltools\',\'小工具-管理\',\'0\',\'\',\'1\',\'{"1":["keyword","toolname","tooldes","toolstate"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'id:编号\r\nkeyword:关键词\r\ntoolname:名称\r\ntooldes:描述\r\ntooltype|get_name_by_status:类型\r\ntoolstate|get_name_by_status:状态\',\'10\',\'toolname\',\'tooldes\',\'1404273263\',\'1404277639\',\'1\',\'MyISAM\');',
		7 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_group\',\'你问我答-客服分组\',\'0\',\'\',\'1\',\'{"1":["groupname"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'id:编号\r\ngroupname:分组名称\r\nid:操作:[EDIT]|编辑,[DELETE]|删除\',\'10\',\'groupname\',\'\',\'1404475456\',\'1404491410\',\'1\',\'MyISAM\');',
		8 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'youaskservice_wxlogs\',\'你问我答- 微信聊天记录\',\'0\',\'\',\'1\',\'\',\'1:基础\',\'\',\'\',\'\',\'\',\'\',\'10\',\'\',\'\',\'1406094050\',\'1406094093\',\'1\',\'MyISAM\');',
		9 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'qr_code\',\'二维码表\',\'0\',\'\',\'1\',\'{"1":["qr_code","addon","aim_id","cTime","extra_text","extra_int","scene_id","action_name"]}\',\'1:基础\',\'\',\'\',\'\',\'\',\'scene_id:事件KEY值\r\nqr_code|get_code_img:二维码\r\naction_name|get_name_by_status: 二维码类型\r\naddon:所属插件\r\naim_id:插件数据ID\r\ncTime|time_format:增加时间\r\nrequest_count|intval:请求数\r\nid:操作:[EDIT]|编辑,[DELETE]|删除\',\'10\',\'qr_code\',\'\',\'1388815871\',\'1406130247\',\'1\',\'MyISAM\');',
		10 => 'INSERT INTO wp_model (`name`,`title`,`extend`,`relation`,`need_pk`,`field_sort`,`field_group`,`attribute_list`,`template_list`,`template_add`,`template_edit`,`list_grid`,`list_row`,`search_key`,`search_list`,`create_time`,`update_time`,`status`,`engine_type`) VALUES (\'import\',\'导入数据\',\'0\',\'\',\'1\',\'\',\'1:基础\',\'\',\'\',\'\',\'\',\'\',\'10\',\'\',\'\',\'1407554076\',\'1407554076\',\'1\',\'MyISAM\');' 
);
foreach ( $sqlArr as $vo ) {
	$res = M ()->execute ( $vo );
	// dump ( $res );
	// dump ( $vo );
}
$models = M ( 'model' )->field ( 'id,name' )->select ();
foreach ( $models as $m ) {
	$model_ids [$m ['name']] = $m ['id'];
}

$insertArr = array (
		'youaskservice_wxlogs' => ' (\'opercode\',\'会话状态\',\'int(10) NOT NULL\',\'num\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094322\',\'1406094322\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'text\',\'消息\',\'text NOT NULL\',\'textarea\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094387\',\'1406094387\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'time\',\'时间\',\'int(10) NOT NULL\',\'datetime\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094341\',\'1406094341\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'openid\',\'openid\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094276\',\'1406094276\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'token\',\'token\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094177\',\'1406094177\',\'\',\'3\',\'\',\'regex\',\'get_token\',\'3\',\'function\'), (\'worker\',\'客服名称\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406094257\',\'1406094257\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'youaskservice_user' => ' (\'name\',\'客服昵称\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403959775\',\'1403947255\',\'\',\'0\',\'\',\'regex\',\'\',\'0\',\'function\'), (\'token\',\'token\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403959638\',\'1403947256\',\'\',\'3\',\'\',\'regex\',\'get_token\',\'3\',\'function\'), (\'userName\',\'客服帐号\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403959752\',\'1403947256\',\'\',\'3\',\'\',\'regex\',\'\',\'0\',\'function\'), (\'userPwd\',\'客服密码\',\'varchar(32) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403959722\',\'1403947257\',\'\',\'0\',\'\',\'regex\',\'\',\'0\',\'function\'), (\'endJoinDate\',\'客服加入时间\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403959825\',\'1403947257\',\'\',\'3\',\'\',\'regex\',\'time\',\'3\',\'function\'), (\'status\',\'客服在线状态\',\'tinyint(1) NOT NULL \',\'bool\',\'0\',\'\',\'0\',\'0:离线\r\n1:在线\',\'{$model_id}\',\'0\',\'1\',\'1404016782\',\'1403947258\',\'\',\'0\',\'\',\'regex\',\'\',\'0\',\'function\'), (\'state\',\'客服状态\',\'tinyint(2) NOT NULL\',\'bool\',\'0\',\'\',\'1\',\'0:停用\r\n1:启用\',\'{$model_id}\',\'0\',\'1\',\'1404016877\',\'1404016877\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'isdelete\',\'是否删除\',\'tinyint(2) NOT NULL\',\'bool\',\'0\',\'\',\'0\',\'0:正常\r\n1:已被删除\',\'{$model_id}\',\'0\',\'1\',\'1404016931\',\'1404016931\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'kfid\',\'客服编号\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404398387\',\'1404398387\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'youaskservice_logs' => ' (\'pid\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403947272\',\'1403947272\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'openid\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403947273\',\'1403947273\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'enddate\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403947273\',\'1403947273\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'keyword\',\'\',\'varchar(200) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403947274\',\'1403947274\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'status\',\'\',\'tinyint(1) NOT NULL \',\'string\',\'2\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1403947274\',\'1403947274\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'),',
		'youaskservice_wechat_enddate' => ' (\'openid\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404026716\',\'1404026716\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'enddate\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404026716\',\'1404026716\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'joinUpDate\',\'\',\'int(11) NOT NULL \',\'string\',\'0\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404026716\',\'1404026716\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'uid\',\'\',\'int(11) NOT NULL \',\'string\',\'0\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404026717\',\'1404026717\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'token\',\'\',\'varchar(40) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404026717\',\'1404026717\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'),',
		'youaskservice_wechat_grouplist' => ' (\'g_id\',\'\',\'varchar(20) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027302\',\'1404027302\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'nickname\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027302\',\'1404027302\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'sex\',\'\',\'tinyint(1) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027303\',\'1404027303\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'province\',\'\',\'varchar(20) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027303\',\'1404027303\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'city\',\'\',\'varchar(30) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027303\',\'1404027303\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'headimgurl\',\'\',\'varchar(200) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027304\',\'1404027304\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'subscribe_time\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027304\',\'1404027304\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'token\',\'\',\'varchar(30) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027305\',\'1404027305\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'openid\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027305\',\'1404027305\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'status\',\'\',\'tinyint(1) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404027305\',\'1404027305\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'),',
		'youaskservice_behavior' => ' (\'fid\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033503\',\'1404033503\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'token\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033503\',\'1404033503\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'openid\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033503\',\'1404033503\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'date\',\'\',\'varchar(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033504\',\'1404033504\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'enddate\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033504\',\'1404033504\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'model\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033504\',\'1404033504\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'num\',\'\',\'int(11) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033505\',\'1404033505\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'keyword\',\'\',\'varchar(60) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033505\',\'1404033505\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'), (\'type\',\'\',\'tinyint(1) NOT NULL \',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404033505\',\'1404033505\',\'\',\'0\',\'\',\'\',\'\',\'0\',\'\'),',
		'smalltools' => ' (\'tooltype\',\'工具类型\',\'tinyint(2) NOT NULL\',\'bool\',\'0\',\'\',\'2\',\'0:微信消息\r\n1:单独页面\',\'{$model_id}\',\'0\',\'1\',\'1404273343\',\'1404273343\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'keyword\',\' 关键词 \',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404273406\',\'1404273406\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'cTime\',\'创建时间\',\'int(10) NOT NULL\',\'datetime\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404273542\',\'1404273542\',\'\',\'3\',\'\',\'regex\',\'time\',\'3\',\'function\'), (\'toolname\',\'工具名称\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404273609\',\'1404273609\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'tooldes\',\'工具描述\',\'text NOT NULL\',\'textarea\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404273652\',\'1404273652\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'toolnum\',\'工具唯一编号\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'2\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404274841\',\'1404273757\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'toolstate\',\'工具状态\',\'tinyint(2) NOT NULL\',\'bool\',\'0\',\'\',\'1\',\'0:启用\r\n1:停用\',\'{$model_id}\',\'0\',\'1\',\'1404273809\',\'1404273809\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'token\',\'Token\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404273958\',\'1404273958\',\'\',\'3\',\'\',\'regex\',\'get_token\',\'3\',\'function\'),',
		'youaskservice_keyword' => ' (\'msgkeyword\',\'消息关键字\',\'varchar(555) NOT NULL\',\'string\',\'\',\'当用户发送的消息中含有关键字时,将自动转到分配的客服人员\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404399336\',\'1404399336\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'msgkeyword_type\',\'关键字类型\',\'char(50) NOT NULL\',\'select\',\'3\',\'选择关键字匹配的类型\',\'1\',\'0:完全匹配\r\n1:左边匹配\r\n2:右边匹配\r\n3:模糊匹配\',\'{$model_id}\',\'0\',\'1\',\'1404399466\',\'1404399466\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'msgkfaccount\',\'接待的客服人员\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404403340\',\'1404399587\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'cTime\',\'创建时间\',\'int(10) NOT NULL\',\'date\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404399629\',\'1404399629\',\'\',\'3\',\'\',\'regex\',\'time\',\'3\',\'function\'), (\'token\',\'token\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404399656\',\'1404399656\',\'\',\'3\',\'\',\'regex\',\'get_token\',\'3\',\'function\'), (\'msgstate\',\'关键字状态\',\'tinyint(2) NOT NULL\',\'bool\',\'1\',\'停用后用户将不会触发此关键词\',\'1\',\'0:停用\r\n1:启用\',\'{$model_id}\',\'0\',\'1\',\'1404399749\',\'1404399749\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'zjnum\',\'转接次数\',\'int(10) NOT NULL\',\'num\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404399784\',\'1404399784\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'zdtype\',\'指定类型\',\'char(10) NOT NULL\',\'radio\',\'0\',\'选择关键字匹配时是按指定人员或者指定客服组\',\'1\',\'0:指定客服人员\r\n1:指定客服组\',\'{$model_id}\',\'0\',\'1\',\'1404474672\',\'1404474672\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'kfgroupid\',\'客服分组id\',\'int(10) NOT NULL\',\'num\',\'0\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404474777\',\'1404474777\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'youaskservice_group' => ' (\'token\',\'token\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404485505\',\'1404475530\',\'\',\'3\',\'\',\'regex\',\'get_token\',\'3\',\'function\'), (\'groupname\',\'分组名称\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404475556\',\'1404475556\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'groupdata\',\'分组数据源\',\'text NOT NULL\',\'textarea\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1404476127\',\'1404476127\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'import' => ' (\'attach\',\'上传文件\',\'int(10) unsigned NOT NULL \',\'file\',\'\',\'支持xls,xlsx两种格式\',\'1\',\'\',\'{$model_id}\',\'1\',\'1\',\'1407554177\',\'1407554177\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'qr_code' => ' (\'qr_code\',\'二维码\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'1\',\'1\',\'1406127577\',\'1388815953\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'addon\',\'二维码所属插件\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'1\',\'1\',\'1406127594\',\'1388816207\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'aim_id\',\'插件表里的ID值\',\'int(10) unsigned NOT NULL \',\'num\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'1\',\'1\',\'1388816287\',\'1388816287\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'cTime\',\'创建时间\',\'int(10) NOT NULL\',\'datetime\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1388816392\',\'1388816392\',\'\',\'1\',\'\',\'regex\',\'time\',\'1\',\'function\'), (\'token\',\'Token\',\'varchar(255) NOT NULL\',\'string\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1391399528\',\'1391399528\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'action_name\',\'二维码类型\',\'char(30) NOT NULL\',\'select\',\'QR_SCENE\',\'QR_SCENE为临时,QR_LIMIT_SCENE为永久 \',\'1\',\'QR_SCENE:临时二维码\r\nQR_LIMIT_SCENE:永久二维码\',\'{$model_id}\',\'0\',\'1\',\'1406130162\',\'1393919686\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'extra_text\',\'文本扩展\',\'text NULL \',\'textarea\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1393919736\',\'1393919736\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'extra_int\',\'数字扩展\',\'int(10) NULL \',\'num\',\'\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1393919798\',\'1393919798\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'request_count\',\'请求数\',\'int(10) NOT NULL\',\'num\',\'0\',\'用户回复的次数\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1402547625\',\'1401938983\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'), (\'scene_id\',\'场景ID\',\'int(10) NOT NULL\',\'num\',\'0\',\'\',\'1\',\'\',\'{$model_id}\',\'0\',\'1\',\'1406127542\',\'1406127542\',\'\',\'3\',\'\',\'regex\',\'\',\'3\',\'function\'),',
		'follow' => ' (\'mTime\',\'更新时间\',\'int(10) NOT NULL\',\'datetime\',\'\',\'\',\'0\',\'\',\'{$model_id}\',\'0\',\'1\',\'1408939657\',\'1408939657\',\'\',\'3\',\'\',\'regex\',\'time\',\'3\',\'function\'),' 
);
foreach ( $insertArr as $model_name => $val ) {
	$val = str_replace ( '{$model_id}', $model_ids [$model_name], $val );
	$val = trim ( $val, ',' );
	$sql = 'INSERT INTO ' . $prefix . "attribute (`name`,`title`,`field`,`type`,`value`,`remark`,`is_show`,`extra`,`model_id`,`is_must`,`status`,`update_time`,`create_time`,`validate_rule`,`validate_time`,`error_info`,`validate_type`,`auto_rule`,`auto_time`,`auto_type`) VALUES $val";
	$res = M ()->execute ( $sql );
	// dump ( $res );
	// lastsql ();
}

$updateArr = array (
		'keyword' => array (
				'keyword' => array (
						'field' => 'varchar(100) NOT NULL ' 
				),
				'aim_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'token' => array (
						'field' => 'varchar(100) NOT NULL ',
						'auto_rule' => 'get_token' 
				),
				'keyword_length' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'keyword_type' => array (
						'field' => 'tinyint(2) NULL ' 
				),
				'extra_text' => array (
						'field' => 'text NULL ' 
				),
				'extra_int' => array (
						'field' => 'int(10) NULL ' 
				) 
		),
		'vote' => array (
				'picurl' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'vote_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'vote_option' => array (
				'vote_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'image' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'opt_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'order' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'vote_log' => array (
				'vote_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'user_id' => array (
						'field' => 'int(10) NOT NULL ' 
				) 
		),
		'member_public' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'group_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'card_member' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				) 
		),
		'update_version' => array (
				'version' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'download_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'suggestions' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				) 
		),
		'custom_menu' => array (
				'sort' => array (
						'field' => 'tinyint(4) NULL ' 
				),
				'url' => array (
						'field' => 'varchar(255) NULL ' 
				) 
		),
		'weisite_category' => array (
				'icon' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'token' => array (
						'field' => 'varchar(100) NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) NULL ' 
				) 
		),
		'weisite_cms' => array (
				'cate_id' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'cover' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'view_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'weisite_slideshow' => array (
				'img' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NULL ' 
				) 
		),
		'weisite_footer' => array (
				'url' => array (
						'field' => 'varchar(255) NULL ' 
				),
				'sort' => array (
						'field' => 'tinyint(4) NULL ' 
				),
				'icon' => array (
						'field' => 'int(10) unsigned NULL ' 
				) 
		),
		'custom_reply_news' => array (
				'cate_id' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'cover' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'view_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'custom_reply_text' => array (
				'view_count' => array (
						'field' => 'int(10) unsigned NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NULL ' 
				) 
		),
		'forms' => array (
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'forms_attribute' => array (
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'forms_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'forms_value' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'forms_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'survey' => array (
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'survey_question' => array (
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'survey_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'survey_answer' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'question_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'survey_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'exam' => array (
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'exam_question' => array (
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'exam_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'score' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'exam_answer' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'question_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'exam_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'score' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'test' => array (
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'test_question' => array (
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'test_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'test_answer' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'question_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'test_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'score' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'shop_product' => array (
				'img_1' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'img_2' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cate_id_1' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cate_id_2' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'market_price' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'discount_price' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'view_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'img_3' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'img_4' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'img_5' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'bug_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'common_category' => array (
				'icon' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'pid' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'shop_footer' => array (
				'url' => array (
						'field' => 'varchar(255) NULL ' 
				),
				'sort' => array (
						'field' => 'tinyint(4) NULL ' 
				),
				'icon' => array (
						'field' => 'int(10) unsigned NULL ' 
				) 
		),
		'credit_config' => array (
				'name' => array (
						'is_show' => '0',
						'is_must' => '0' 
				) 
		),
		'member_public_link' => array (
				'uid' => array (
						'field' => 'int(10) NULL ' 
				),
				'mp_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'coupon' => array (
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'end_img' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'num' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'max_num' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'credit_conditon' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'credit_bug' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'collect_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'view_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'sn_code' => array (
				'target_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'prize_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'scratch' => array (
				'cover' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'cTime' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'end_img' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'predict_num' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'max_num' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'credit_conditon' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'credit_bug' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'collect_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'view_count' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'prize' => array (
				'target_id' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'num' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'sort' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				),
				'img' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'addon_category' => array (
				'icon' => array (
						'field' => 'int(10) unsigned NOT NULL ' 
				) 
		),
		'common_category_group' => array (
				'token' => array (
						'field' => 'varchar(100) NOT NULL' 
				) 
		) 
);
foreach ( $updateArr as $model_name => $fields ) {
	unset ( $map );
	$map ['model_id'] = intval ( $model_ids [$model_name] );
	if (empty ( $map ['model_id'] ))
		continue;
	foreach ( $fields as $f => $v ) {
		$map ['name'] = $f;
		$res = M ( 'attribute' )->where ( $map )->save ( $v );
		// dump ( $res );
		// lastsql ();
	}
}

// ===========================================================

// 更新本地版本号
unset ( $map );
$map ['name'] = 'SYSTEM_UPDATRE_VERSION';
$res = M ( 'config' )->where ( $map )->setField ( 'value', 20140826 );
S ( 'DB_CONFIG_DATA', null );

$this->success ( '操作完成' );