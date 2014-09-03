<?php

namespace Addons\ScoreDetail;
use Common\Controller\Addon;

/**
 * 积分查询插件
 * @author 淡然
 * QQ:9585216
 */

    class ScoreDetailAddon extends Addon{

        public $info = array(
            'name'=>'ScoreDetail',
            'title'=>'积分查询',
            'description'=>'用于粉丝查询积分总额及明细',
            'status'=>1,
            'author'=>'淡然',
            'version'=>'1.11',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/ScoreDetail/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/ScoreDetail/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }