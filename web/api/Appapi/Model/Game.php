<?php
session_start();
class Model_Game extends Model_Common {
	public function record($liveuid,$stream,$token,$name,$time)
	{
		$userinfo=DI()->notorm->users
				->select("token,expiretime,coin")
				->where('id=?',$liveuid)
				->fetchOne();
		if($userinfo['token']!=$token || $userinfo['expiretime']<time()){
			return 700;				
		}
		$game=DI()->notorm->game
				->select("*")
				->where('stream=? and state=0',$stream)
				->fetchOne();
		if($game)
		{
			return 1000;			
		}
		$rs=DI()->notorm->game
				->insert(array("liveuid"=>$liveuid,"stream"=>$stream,'action'=>$name,'state'=>'0',"starttime"=>$time) );	
		if(!$rs)
		{
			return 1001;		
		}
		return $rs;		
	}
	public function endGame($liveuid,$gameid,$type)
	{
		$game=DI()->notorm->game
				->select("*")
				->where('id=? and state=0',$gameid)
				->fetchOne();
		if($game)
		{
			DI()->notorm->game
				->where('id = ? and liveuid =?', $gameid,$liveuid)
				->update(array('state' =>$type,'endtime' => time() ) );
			return 1000;
		}
		$sql = 'select uid,sum(coin) as gamecoin from cmf_users_gamerecord where gameid=:gameid group by uid';
		$params = array(':gameid' => $gameid);   
		$total=DI()->notorm->user->queryAll($sql, $params); 
		if($type==2 ||$type==3)
		{
			foreach( $total as $k=>$v){
				DI()->notorm->users
					->where('id = ?', $v['uid'])
					->update(array('coin' => new NotORM_Literal("coin + {$v['gamecoin']}")));
			}
		}else
		{
			foreach( $total as $k=>$v){
				$gamecoin=$v['gamecoin']*3;
				DI()->notorm->users
					->where('id = ?', $v['uid'])
					->update(array('coin' => new NotORM_Literal("coin + {$gamecoin}")));
			}
		}
		$BetToken="JinhuaCoin_".$gameid."_".$game['starttime']; 
		DI()->redis->delete($BetToken);
		return 1;
	}
	public function gameBet($uid,$gameid,$coin,$name)
	{
		$userinfo=DI()->notorm->users
			->select('coin')
			->where('id = ?', $uid)
			->fetchOne();	
		if($userinfo['coin']<$coin)
		{
			return 1000;
		}
		$game=DI()->notorm->game
				->select("*")
				->where('id=?',$gameid)
				->fetchOne();
		if(!$game ||$game['state']!="0")
		{
			return 1001;
		}
		$rs=DI()->notorm->users_gamerecord
				->insert(array("action"=>$name,"uid"=>$uid,'gameid'=>$gameid,'liveuid'=>$game['liveuid'],"coin"=>$coin,"addtime"=>time()) );
		if(!$rs)
		{
			return 1002;		
		}
		DI()->notorm->users
					->where('id = ?', $uid)
					->update(array('coin' => new NotORM_Literal("coin - {$coin}"),'consumption' => new NotORM_Literal("consumption + {$coin}")));
		$info=DI()->notorm->users
			->select('coin')
			->where('id = ?', $uid)
			->fetchOne();	
		$rs['coin']=$info['coin'];
		$rs['gametime']=$game['starttime'];
		return $rs;	
	}
}