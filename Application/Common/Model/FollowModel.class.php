<?php

namespace Common\Model;

use Think\Model;
use User\Api\UserApi;

/**
 * 粉丝操作
 */
class FollowModel extends Model {
	//增加$is_subscribe参数，配合WeixinController.class.php中的修改，实现对之前关注过的粉丝新录入follow和ucenter
	//by Mekal 2014-7-31
	function init_follow($openid,$is_subscribe = true) {
		$data ['token'] = get_token ();
		$data ['openid'] = $openid;
		
		$info = $this->where ( $data )->find ();

		if ($info) {
			if ($is_subscribe) {
				$save ['subscribe_time'] = $info ['subscribe_time'] = time ();
				$res = $this->where ( $data )->save ( $save );
			}
		} else {
			$data ['subscribe_time'] = time ();
			$uid = $this->get_uid_by_ucenter ( $data ['openid'], $data ['token'] );
			if ($uid > 0) {
				$data ['id'] = $uid;
				$res = $this->add ( $data );
			}
			
			$info = $data;
		}
		return $info;
	}
	// 自动初始化微信用户
	function get_uid_by_ucenter($openid, $token) {
		$info ['openid'] = $openid;
		$info ['token'] = $token;
		$res = M ( 'ucenter_member' )->where ( $info )->find ();
		
		if ($res)
			return $res ['id'];
		
		$email = time () . '@weiphp.cn';
		$nickname = uniqid().rand(01,99);
		
		/* 调用注册接口注册用户 */
		$User = new UserApi ();
		$uid = $User->register ( $nickname, '123456', $email, '', $openid, $token );
		
		return $uid;
	}
	
	/**
	 * 获取粉丝全部信息
	 */
	public function getFollowInfo($id) {
		static $_followInfo;
		if (isset ( $_followInfo [$id] )) {
			return $_followInfo [$id];
		}
		
		$_followInfo [$id] = $this->find ( $id );
		return $_followInfo [$id];
	}
}
?>
