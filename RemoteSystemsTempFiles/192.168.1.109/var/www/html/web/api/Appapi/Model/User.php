<?php

class Model_User extends Model_Common {
	/* 用户全部信息 */
	public function getBaseInfo($uid) {
		$usersauth=DI()->notorm->users_auth
				->select("status,alipay")
				->where('uid=?',$uid)
				->fetchOne();
		$info=DI()->notorm->users
				->select("id,memberid,user_nicename,avatar,avatar_thumb,sex,signature,score,coin,cuckoo,income,votes,guzi,consumption,votestotal,province,city,area,birthday")
				->where('id=?  and user_type="2"',$uid)
				->fetchOne();
		$sql 	=	"SELECT a.`avatar_thumb`,b.`touid` FROM cmf_users a INNER JOIN (SELECT uid,touid FROM cmf_users_coinrecord WHERE uid={$uid} order by totalcoin limit 3) b ON a.`id`=b.`touid`";
		$touList =DI()->notorm->users_coinrecord->queryAll($sql);
		$info['touList']=!empty($touList)?$touList:'没有数据';			
		$info['avatar']=$this->get_upload_path($info['avatar']);
		$info['avatar_thumb']=$this->get_upload_path($info['avatar_thumb']);						
		$info['level']=$this->getLevel($info['consumption']);
		$info['lives']=$this->getLives($uid);
		$info['follows']=$this->getFollows($uid);
		$info['fans']=$this->getFans($uid);
		$info['alipay'] = "0";
		$info['status'] = "0";
		
		$provinceinfo =DI()->notorm->region
				->select("areaname")
				->where('id=?',$info['province'])
				->fetchOne();
		
		$cityinfo =DI()->notorm->region
		->select("areaname")
		->where('id=?',$info['city'])
		->fetchOne();
		
		$areainfo =DI()->notorm->region
		->select("areaname")
		->where('id=?',$info['area'])
		->fetchOne();
		
		$info['province'] = $provinceinfo['areaname'];
		$info['city'] = $cityinfo['areaname'];
		$info['area'] = $areainfo['areaname'];
		
		if($usersauth){
			$info['alipay'] = $usersauth['alipay'];
			$info['status'] = $usersauth['status'];
		} else {
			$info['flag'] = 1;
		}
		
		return $info;
	}	
	

	public function getTouidList($uid,$p,$type) {
		$pnum=20;
		$start=($p-1)*$pnum;
	
		if($type==1){
			$day 	=	strtotime("2017-04-10");
			$today 	=	date('Ymd',$day);
			$sql 	=	"SELECT a.`avatar_thumb`,a.`consumption`,a.`cuckoo`,a.`user_nicename`,b.`touid` FROM cmf_users a INNER JOIN (SELECT uid,touid FROM cmf_users_coinrecord WHERE uid={$uid} and from_unixtime(addtime,'%Y%m%d')={$today} order by totalcoin) b ON a.`id`=b.`touid` limit {$start},{$pnum}";	
			
		}else{
			$sql 	=	"SELECT a.`avatar_thumb`,a.`consumption`,a.`cuckoo`,a.`user_nicename`,b.`touid` FROM cmf_users a INNER JOIN (SELECT uid,touid FROM cmf_users_coinrecord WHERE uid={$uid} order by totalcoin) b ON a.`id`=b.`touid` limit {$start},{$pnum}";	
		}
	

		$touList =DI()->notorm->users_coinrecord->queryAll($sql);		
		
		$domain = new Domain_Common();

		foreach ($touList as $key => $value) {

			$touList[$key]['no'] 	   = $key+1+$start; 
			$touList[$key]['isattent'] = $domain->isAttention($uid,$value['touid']);
			$touList[$key]['level']    = $this->getLevel($value['consumption']);		
		}
		$info 	=	$touList;
		return $info;
	}
	
	public function getBaseInfos($uid) {
		$info=DI()->notorm->users
		->select("guzi")
		->where('uid=?',$uid)
		->fetchOne();
		return $info;
	}
	
	/*public function getLevels($uid) {
			
		$experienceinfo=DI()->notorm->users->select("consumption")->where("id=?",$uid)->fetchOne();
		$experience = $experienceinfo['consumption'];
		
		$level=DI()->notorm->experlevel->where("level_up>=?",$experience)->order("levelid asc")->fetchOne();
		$level2=DI()->notorm->experlevel->where("level_up<=?",$experience)->order("levelid desc")->fetchOne();
		
		$cha=$level['level_up']+1-$experience;
		if($level2){
			$min=$level2['level_up'];
		}else{
			$min=0;
		}
		
		//$rate=floor(($experience-$min)/($level['level_up']+1-$min)*100);
		
		$res['experience'] = $experience;
		$res['level'] = $level;
		$res['cha'] = $cha;
		//$res['rate'] = $rate;
		return $res;
	}*/
	
	/* 获取充值规则信息  */
	public function getExchangeRules(){
		$info = DI()->notorm->exchange_rules
					->select("id,cuckoo,guzi")
					->fetchAll();
		return $info;
	}
	
	public function getGuzi($uid) {
		$info=DI()->notorm->users
		->select("guzi")
		->where('id= ? ',$uid)
		->fetchOne();
		return $info;
	}
	
	/* 用户充值信息 */
	public function getRechargeList($uid) {
		$info=DI()->notorm->users_charge
				->select("id,uid,cuckoo,money,addtime")
				->where('uid=?',$uid)
				->fetchAll();	 				
		return $info;
	}
	
	/* 用户兑换信息 */
	public function getExchangeList($uid) {
		$info=DI()->notorm->users_exchange
		->select("id,uid,cuckoo,guzi,addtime")
		->where('uid=?',$uid)
		->fetchAll();
		return $info;
	}
			
	/* 判断昵称是否重复 */
	public function checkName($uid,$name){
		$isexist=DI()->notorm->users
					->select('id')
					->where('id!=? and user_nicename=?',$uid,$name)
					->fetchOne();
		if($isexist){
			return 0;
		}else{
			return 1;
		}
	}
	
	/* 修改信息 */
	public function userUpdate($uid,$fields){
		/* 清除缓存 */
		$this->delCache("userinfo_".$uid);
		
		return DI()->notorm->users
					->where('id=?',$uid)
					->update($fields);
	}

	/* 修改密码 */
	public function updatePass($uid,$oldpass,$pass){
		$userinfo=DI()->notorm->users
					->select("user_pass")
					->where('id=?',$uid)
					->fetchOne();
		$oldpass=$this->setPass($oldpass);							
		if($userinfo['user_pass']!=$oldpass){
			return 1003;
		}							
		$newpass=$this->setPass($pass);
		return DI()->notorm->users
					->where('id=?',$uid)
					->update( array( "user_pass"=>$newpass ) );
	}
	
	/* 我的钻石 */
	public function getBalance($uid){
		return DI()->notorm->users
				->select("coin")
				->where('id=?',$uid)
				->fetchOne();
	}
	
	/* 充值规则 3-31修改*/ 
	public function getChargeRulesOld(){

		$rules= DI()->notorm->charge_rules
				->select('id,coin,money,money_ios,product_id,give')
				->order('orderno asc')
				->fetchAll();

		return 	$rules;
	}
	
	/* 充值规则 */
	public function getChargeRules(){

		$rules= DI()->notorm->charge_rules
				->select('id,money,cuckoo')
				->where('orderno!=?',0)
				->order('id asc')
				->fetchAll();

		return 	$rules;
		
	}
	
	/* 获取消息记录  */
	public function getMessage($uid){
	
		$rules= DI()->notorm->message
		->select('id,uid,touid,content,addtime')
		->where('uid=?',$uid)
		->order('id asc')
		->fetchAll();
	
		return 	$rules;
	
	}
	
	/* 获取用户邀请记录  */
	public function getInviteList($uid,$p){
		$pnum=50;
		$start=($p-1)*$pnum;

		$rules= DI()->notorm->users_invite
		->where('uid=?',$uid)
		->limit($start,$pnum)
		->order('id asc')
		->fetchAll();
	
		return 	$rules;
	}
	
	/* 邀请好友  */
	public function setInvite($uid,$touid){
		return DI()->notorm->users_invite
		->insert(array("uid"=>$uid,"touid"=>$touid,"income"=>100,"addtime"=>time()));
	}
	
	/* 获取单页页面列表  */
	public function getPageList(){
	
		$rules= DI()->notorm->posts
		->select('id,post_title')
		->order('id asc')
		->fetchAll();
		
		return 	$rules;
	
	}
	
	/* 获取单页页面信息  */
	public function getPage($id){
	
		$rules= DI()->notorm->posts
		->select('id,post_title,post_content')
		->where('id=?',$id)
		->order('id asc')
		->fetchOne();
		
		return 	$rules;
	
	}
	
	/* 添加消息记录 */
	public function setMessage($uid,$touid,$content,$type){
		DI()->notorm->message
		->insert(array("uid"=>$uid,"touid"=>$touid,"content"=>$content,"type"=>$type,"status"=>1,"addtime"=>time()));
		return 1;
	}
	
	/* 充值记录 */
	public function setChargeInfo($id,$uid,$touid,$type){
		/*$info = DI()->notorm->charge_rules
					->select("*")
					->where('id=?',$id)
					->fetchOne();*/
		//if(!$info){
			DI()->notorm->users_charge
				->insert(array("uid"=>$uid,"touid"=>$touid,"money"=>$info['money'],"cuckoo"=>$info['cuckoo'],"orderno"=>$uid."_".$uid."_".date("YmdHis")."_".rand(999,9999),"addtime"=>time(),"type"=>$type));
			return 1;
		//}		 
	}
	
	/* 兑换记录 */
	public function setExchangeInfo($uid,$cuckoo,$guzi){
		
		DI()->notorm->users_exchange
		->insert(array("uid"=>$uid,"cuckoo"=>$cuckoo,"guzi"=>$guzi,"addtime"=>time()));
		
		DI()->notorm->users
		->where('id = ? ',$uid)
		->update(array('guzi' => new NotORM_Literal("guzi - {$guzi}"),'income' => new NotORM_Literal("income - {$guzi}")));
		
		return 1;
		
	}
	
	/* 兑换记录 */
	public function setAlipay($alipay,$mobile,$real_name){
		return DI()->notorm->users_auth
				->where('real_name = ? and mobile = ?',$real_name,$mobile)
				->update(array('alipay' => $alipay));
	}
	
	/* 用户认证  */
	public function setAuth($uid,$real_name,$mobile,$cer_no){
		$res = DI()->notorm->users_auth
		->where('uid = ?',$uid)->fetchOne();
		if($res){
			return DI()->notorm->users_auth
			->where('uid = ?',$uid)
			->update(array('real_name'=>$real_name,'mobile'=>$mobile,'cer_no'=>$cer_no,'status'=>1));
		} else {
			DI()->notorm->users_auth
			->insert(array('uid'=>$uid,'real_name'=>$real_name,'mobile'=>$mobile,'cer_no'=>$cer_no,'status'=>1));
			return 1;
		}
	}
	
	/* 我的收益 */
	public function getProfit($uid){
		$userprivate = DI()->notorm->config_private
				->select("cash_rate")
				->fetchOne();
		$info= DI()->notorm->users
				->select("votes,guzi,consumption")
				->where('id=?',$uid)
				->fetchOne();
		$level=$this->getLevel($info['consumption']);		
		//等级限制金额
		$limitcash=$this->getLevelSection($level);	
		
		$config=$this->getConfigPri();
		
		//提现比例
		$cash_rate=$config['cash_rate'];
		//剩余票数
		$votes=$info['votes'];
		//总可提现数
		$total=floor($votes/$cash_rate);
		
		$nowtime=time();
		//当天0点
		$today=date("Ymd",$nowtime);
		$today_start=strtotime($today)-1;
		//当天 23:59:59
		$today_end=strtotime("{$today} + 1 day");
		
		//已提现
		$hascash=DI()->notorm->users_cashrecord
					->where('uid=? and addtime>? and addtime<? and status!=2',$uid,$today_start,$today_end)
					->sum("money");
		if(!$hascash){
			$hascash=0;
		}		
		//今天可体现
		$todaycancash=$limitcash - $hascash;
		
		//今天能提
		if($todaycancash<$total){
			$todaycash=$todaycancash;
		}else{
			$todaycash=$total;
		}
		
		$rs=array(
			//"votes"=>$votes,
			//"guzi" => $votes,
			"guzi"=>$info['guzi'],
			"todaycash"=>$todaycash,
			"total"=>$total,
			"cash_rate"=>$userprivate['cash_rate']
		);
		return $rs;
	}	
	/* 提现  */
	public function setCash($uid,$money,$guzi){
		$isrz=DI()->notorm->users_auth
				->select("status")
				->where('uid=?',$uid)
				->fetchOne();
		if(!$isrz || $isrz['status']!=1){
			return 1003;
		}					
		$info= DI()->notorm->users
				->select("votes,consumption")
				->where('id=?',$uid)
				->fetchOne();
		$level=$this->getLevel($info['consumption']);		
		//等级限制金额
		$limitcash=$this->getLevelSection($level);	
		
		$config=$this->getConfigPri();
		
		//提现比例
		$cash_rate=$config['cash_rate'];
		/* 最低额度 */
		$cash_min=$config['cash_min'];
		//剩余票数
		$votes=$info['votes'];
		//总可提现数
		$total=floor($votes/$cash_rate);
		
		//已提现
		$nowtime=time();
		//当天0点
		$today=date("Ymd",$nowtime);
		$today_start=strtotime($today)-1;
		//当天 23:59:59
		$today_end=strtotime("{$today} + 1 day");
		
		$hascash =DI()->notorm->users_cashrecord
					->where('uid=? and addtime>? and addtime<? and status!=2',$uid,$today_start,$today_end)
					->sum("money");
		if(!$hascash){
			$hascash=0;
		}		
		//今天可体现
		$todaycancash=$limitcash - $hascash;
		
		//今天能提
		if($todaycancash<$total){
			$todaycash=$todaycancash;
		}else{
			$todaycash=$total;
		}
		
		if($todaycash==0){
			return 1001;
		}
		
		if($todaycash > $cash_min){
			return 1004;
		}
		
		if($money > $todaycash){
			return 1005;
		}
		
		$cashvotes=$todaycash*$cash_rate;
		
		$nowtime=time();
		
		$data=array(
			"uid"=>$uid,
			//"money"=>$todaycash,
			"money"=>$money,
			"votes"=>$cashvotes,
			"guzi"=>$guzi,
			"orderno"=>$uid.'_'.$nowtime.rand(100,999),
			"status"=>0,
			"addtime"=>$nowtime,
			"uptime"=>$nowtime,
		);
		
		$rs=DI()->notorm->users_cashrecord->insert($data);
		if($rs){
			/*DI()->notorm->users
				->where('id = ?', $uid)
				->update(array('votes' => new NotORM_Literal("votes - {$cashvotes}")) );*/
			DI()->notorm->users
			->where('id = ?', $uid)
			->update(array('guzi' => new NotORM_Literal("guzi - {$guzi}"),'income' => new NotORM_Literal("income - {$guzi}")) );
		}else{
			return 1002;
		}			
		return $rs;
		
	}
	
	/* 关注 */
	public function setAttent($uid,$touid){
		$isexist=DI()->notorm->users_attention
					->select("*")
					->where('uid=? and touid=?',$uid,$touid)
					->fetchOne();
		if($isexist){
			DI()->notorm->users_attention
				->where('uid=? and touid=?',$uid,$touid)
				->delete();
			return 0;
		}else{
			DI()->notorm->users_black
				->where('uid=? and touid=?',$uid,$touid)
				->delete();
			DI()->notorm->users_attention
				->insert(array("uid"=>$uid,"touid"=>$touid));
			return 1;
		}			 
	}	
	
	/* 拉黑 */
	public function setBlack($uid,$touid){
		$isexist=DI()->notorm->users_black
					->select("*")
					->where('uid=? and touid=?',$uid,$touid)
					->fetchOne();
		if($isexist){
			DI()->notorm->users_black
				->where('uid=? and touid=?',$uid,$touid)
				->delete();
			return 0;
		}else{
			DI()->notorm->users_attention
				->where('uid=? and touid=?',$uid,$touid)
				->delete();
			DI()->notorm->users_black
				->insert(array("uid"=>$uid,"touid"=>$touid));

			return 1;
		}			 
	}
	
	/* 关注列表 */
	public function getFollowsList($uid,$touid,$p){
		$pnum=50;
		$start=($p-1)*$pnum;
		$touids=DI()->notorm->users_attention
					->select("touid")
					->where('uid=?',$touid)
					->limit($start,$pnum)
					->fetchAll();
		foreach($touids as $k=>$v){
			$touids[$k]=$this->getUserInfo($v['touid']);
			if($uid==$touid){
				$isattent=1;
			}else{
				$isattent=$this->isAttention($uid,$v['touid']);
			}
			$touids[$k]['isattention']=$isattent;
		}						
		return $touids;
	}
	
	/* 粉丝列表 */
	public function getFansList($uid,$touid,$p){
		$pnum=50;
		$start=($p-1)*$pnum;
		$touids=DI()->notorm->users_attention
					->select("uid")
					->where('touid=?',$touid)
					->limit($start,$pnum)
					->fetchAll();
		foreach($touids as $k=>$v){
			$touids[$k]=$this->getUserInfo($v['uid']);
			$touids[$k]['isattention']=$this->isAttention($uid,$v['uid']);
		}						
		return $touids;
	}	

	/* 黑名单列表 */
	public function getBlackList($uid,$p){
		$pnum=50;
		$start=($p-1)*$pnum;
		$touids=DI()->notorm->users_black
					->select("touid")
					->where('uid=?',$uid)
					->limit($start,$pnum)
					->fetchAll();
		foreach($touids as $k=>$v){
			$touids[$k]=$this->getUserInfo($v['touid']);
		}						
		return $touids;
	}
	
	/* 我的积分列表 */
	public function getUserPoin($uid,$p,$touid){ 
		$pnum=50;
		$start=($p-1)*$pnum; 
		$touids=DI()->notorm->users_point
		->select('*')
		->where('uid=?',$uid)
		->limit($start,$pnum)
		->fetchAll(); 
		return $touids;
	}
	
	/* 直播记录 */
	public function getLiverecord($touid,$p){
		$pnum=50;
		$start=($p-1)*$pnum;
		$record=DI()->notorm->users_liverecord
					->select("id,uid,nums,starttime,endtime,title,city")
					->where('uid=?',$touid)
					->order("id desc")
					->limit($start,$pnum)
					->fetchAll();
		foreach($record as $k=>$v){
			$record[$k]['datestarttime']=date("Y年m月d日 H:i",$v['starttime']);
			$record[$k]['dateendtime']=date("Y年m月d日 H:i",$v['endtime']);
		}						
		return $record;						
	}	
	
		/* 个人主页 */
	public function getUserHome($uid,$touid){
		$info=$this->getUserInfo($touid);				

		$info['follows']=$this->NumberFormat($this->getFollows($touid));
		$info['fans']=$this->NumberFormat($this->getFans($touid));
		$info['isattention']=(string)$this->isAttention($uid,$touid);
		$info['isblack']=(string)$this->isBlack($uid,$touid);
		$info['isblack2']=(string)$this->isBlack($touid,$uid);
		
		/* 贡献榜前三 */
		$rs=array();
		$rs=DI()->notorm->users_coinrecord
				->select("uid,sum(totalcoin) as total")
				->where('touid=?',$touid)
				->group("uid")
				->order("total desc")
				->limit(0,3)
				->fetchAll();
		foreach($rs as $k=>$v){
			$userinfo=$this->getUserInfo($v['uid']);
			$rs[$k]['avatar']=$userinfo['avatar'];
		}		
		$info['contribute']=$rs;	
		
		/* 是否直播 */
		$info['islive']='1';
		$live=DI()->notorm->users_live
				->select("uid,avatar,avatar_thumb,user_nicename,title,city,stream,pull")
				->where('uid=? and islive="1"',$touid)
				->fetchOne();
		if(!$live){
			$live['uid']='';
			$live['avatar']='';
			$live['avatar_thumb']='';
			$live['user_nicename']='';
			$live['title']='';
			$live['city']='';
			$live['stream']='';
			$live['pull']='';
			$info['islive']='0';
		}
		$info['liveinfo']=$live;	

		/* 直播记录 */
		$record=array();
		$record=DI()->notorm->users_liverecord
					->select("id,uid,nums,starttime,endtime,title,city")
					->where('uid=?',$touid)
					->order("id desc")
					->limit(0,20)
					->fetchAll();
		foreach($record as $k=>$v){
			$record[$k]['datestarttime']=date("Y年m月d日 H:i",$v['starttime']);
			$record[$k]['dateendtime']=date("Y年m月d日 H:i",$v['endtime']);
		}		
		$info['liverecord']=$record;	
		return $info;
	}
	
	/* 贡献榜 */
	public function getContributeList($touid,$p){
		
		$pnum=50;
		$start=($p-1)*$pnum;

		$rs=array();
		$rs=DI()->notorm->users_coinrecord
				->select("uid,sum(totalcoin) as total")
				->where('touid=?',$touid)
				->group("uid")
				->order("total desc")
				->limit($start,$pnum)
				->fetchAll();
				
		foreach($rs as $k=>$v){
			$rs[$k]['userinfo']=$this->getUserInfo($v['uid']);
		}		
		
		return $rs;
	}
}
