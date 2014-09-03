<?php

namespace Addons\ScoreDetail\Controller;
use Home\Controller\AddonsController;

class ScoreDetailController extends AddonsController{

	function lists(){

		//查询数据
		$map ['token'] = get_token();
		$map ['uid'] = $this->getUid();
		$name = 'credit_data';
		$page = I ( 'p', 1, 'intval' ); // 默认显示第一页数据
		$row = 50;
		$data = M( $name )->where ( $map )->order ( 'id DESC' )->page ( $page, $row )->select ();
		
		// 获取相关的用户信息
		$names = getSubByKey ( $data, 'credit_name' );
		$names = array_filter ( $names );
		$names = array_unique ( $names );
		if (! empty ( $names )) {
			$cond ['name'] = array (
					'in',
					$names 
			);
			$credit_config = M ( 'credit_config' )->distinct(true)->where ( $cond )->field ( 'name,title' )->select ();
			foreach ( $credit_config as $cc ) {
				$cnames [$cc ['name']] = $cc;
			}
			foreach ( $data as &$vo ) {
				$vo ['title'] = $cnames [$vo ['credit_name']] ['title'];
			}
		}

		$this->assign ( 'list_data', $data );
		$this->meta_title = '积分明细';
		$this->assign('total', $this->getScore());
		//$this->display ( T ( 'Addons://ScoreDetail@ScoreDetail/lists' ) );
		$this->display ();
	}

	//获取用户ID
	private function getUid()
	{
		$uid = -1;
		$map['openid']=get_openid ();
		$map['token']=get_token ();
		$follow = M('follow')->where($map)->select();
		if($follow)
		{
			$uid = $follow[0]['id'];
		}
		return $uid;
	}

	//获得用户积分
	private function getScore()
	{
		$score = 0;
		$map['openid']=get_openid ();
		$map['token']=get_token ();
		$follow = M('follow')->where($map)->select();
		if($follow)
		{
			$score = $follow[0]['score'];
		}
		return $score;
	}
}
