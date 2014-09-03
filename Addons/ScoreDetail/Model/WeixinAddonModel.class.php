<?php
        	
namespace Addons\ScoreDetail\Model;
use Home\Model\WeixinModel;
        	
/**
 * ScoreDetail的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig( 'ScoreDetail' ); // 获取后台插件的配置参数
		$reply = $config['reply'];

		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		$param ['token'] = get_token ();
		$param ['openid'] = get_openid ();
		$url = addons_url ( 'ScoreDetail://ScoreDetail/lists', $param );
		$score = $this->getScore();

		$reply = str_replace('[积分余额]', $score, $reply);
		$reply = str_replace('[明细链接]', $url, $reply);
		$this->replyText($reply);
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
        	