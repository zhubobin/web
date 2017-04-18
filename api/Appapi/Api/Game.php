<?php
session_start();
class Api_Game extends Api_Common {
	public function getRules() {
		return array(
			'Jinhua' => array(
        'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
				'stream' => array('name' => 'stream', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '流名'),
				'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
        ),
				'endGame' => array(
					'liveuid' => array('name' => 'liveuid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '主播ID'),
					'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
					'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
					'type' => array('name' => 'type', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '结束类型，正常结束为1 主播关闭为2')
        ),
				'JinhuaBet' => array(
					'uid' => array('name' => 'uid', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
					'gameid' => array('name' => 'gameid', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '游戏ID'),
					'token' => array('name' => 'token', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => 'token'),
					'coin'=>array('name' => 'coin', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '下注金额'),
					'grade'=>array('name' => 'grade', 'type' => 'string', 'min' => 0, 'require' => true, 'desc' => '牌的序号 1 2 3分别代表三幅'),
        ),
		);
	}
	public function Jinhua() {
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$domain = new Domain_Game();
		$info=$domain->Jinhua();
		$liveuid=$this->liveuid;
		$stream=$this->stream;
		$token=$this->token;
		$time=time();
		$record=$domain->record($liveuid,$stream,$token,"jinhuaGame",$time);
		if($record==700)
		{
			$rs['code'] = 700;
			$rs['msg'] = 'Token错误或已过期，请重新登录';
			return $rs;
		}
		if($record==1000)
		{
			$rs['code'] = 1000;
			$rs['msg'] = '本轮游戏还未结束';
			return $rs;
		}
		if($record==1001)
		{
			$rs['code'] = 1001;
			$rs['msg'] = '游戏开启失败';
			return $rs;
		}
		$Jinhuatoken=$stream."_jinhua_".$time;
	 	$BetToken="JinhuaCoin_".$record['id']."_".$record['starttime'];
		DI()->redis  -> set($Jinhuatoken."_Game",json_encode($info));	
		$data=array("one"=>'0',"two"=>'0',"three"=>'0');
		DI()->redis  -> set($BetToken,json_encode($data));
		$rs['info']['time']="30";
		$rs['info']['Jinhuatoken']=$Jinhuatoken;
		$rs['info']['gameid']=$record['id'];
		return $rs;
	}
	public function endGame()
	{
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$liveuid=$this->liveuid;
		$gameid=$this->gameid;
		$token=$this->token;
		$type=$this->type;
		$domain = new Domain_Game();
		$checkToken=$this->checkToken($liveuid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = 'Token错误或已过期，请重新登录';
			return $rs;
		}
		$info=$domain->endGame($liveuid,$gameid,$type);
		/* $rs['info']=$info; */
		return $rs;	
	}
	public function JinhuaBet()
	{
		$rs = array('code' => 0, 'msg' => '', 'info' => array());
		$uid=$this->uid;
		$gameid=$this->gameid;
		$token=$this->token;
		$coin=$this->coin;
		$domain = new Domain_Game();
		$checkToken=$this->checkToken($uid,$token);
		if($checkToken==700){
			$rs['code'] = $checkToken;
			$rs['msg'] = 'Token错误或已过期，请重新登录';
			return $rs;
		}
		$info=$domain->JinhuaBet($uid,$gameid,$coin,"jinhuaGame");
		if($info==1000)
		{
			$rs['code'] = 1000;
			$rs['msg'] = '你的余额不足，无法下注';
			return $rs;
		}
		if($info==1001)
		{
			$rs['code'] = 1001;
			$rs['msg'] = '本轮游戏已经结束';
			return $rs;
		}
		if($info==1002)
		{
			$rs['code'] = 1002;
			$rs['msg'] = '下注失败';
			return $rs;
		}
		$one='0';$two='0';$three='0';
		$BetToken="JinhuaCoin_".$gameid."_".$info['gametime']; 
		$BetRedis=DI()->redis  -> Get($BetToken);
		$BetRedis=json_decode($BetRedis,1);
	 	if($grade==1){
			$one=(string)$coin+$BetRedis['one'];
		}else if($grade==2){
			$two=(string)$coin+$BetRedis['two'];
		}else{
			$three=(string)$coin+$BetRedis['three'];
		} 
		$data=array("one"=>$one,"two"=>$two,"three"=>$three);
		DI()->redis  -> set($BetToken,json_encode($data));
		$rs['info']['uid']=$info['uid'];
		$rs['info']['coin']=$info['coin'];
		/* $rs['info']['gameid']=$info['gameid']; */
		return $rs;
	}
}