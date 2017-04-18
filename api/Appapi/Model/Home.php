<?php
session_start();
class Model_Home extends Model_Common {
	/* 轮播 */
	public function getSlide(){

		$rs=DI()->notorm->slide
			->select("slide_pic,slide_url")
			->where("slide_status='1' and slide_cid='0' ")
			->order("listorder asc")
			->fetchAll();
		foreach($rs as $k=>$v){
			$rs[$k]['slide_pic']=$this->get_upload_path($v['slide_pic']);
		}				

		return $rs;				
	}

	/* 热门 */
    public function getHot($p) {

		$pnum=50;
		$start=($p-1)*$pnum;
		$where=" l.islive= '1' and u.ishot='1'";

		/* if($p!=1){
			$endtime=$_SESSION['new_starttime'];
			$where.=" and starttime < {$endtime}";
		} */
		$prefix= DI()->config->get('dbs.tables.__default__.prefix');
		
		$result=DI()->notorm->users_live
					->queryAll("select l.uid,l.avatar,l.avatar_thumb,l.user_nicename,l.title,l.city,l.stream,l.pull,l.thumb from {$prefix}users_live l left join {$prefix}users u on l.uid=u.id where {$where} order by u.isrecommend desc,l.starttime desc limit {$start},{$pnum}");

		foreach($result as $k=>$v){
			$nums=DI()->redis->hget("livenums",$v['stream']);
			if(!$nums || $nums<0){
				$nums=0;
			}
			$result[$k]['nums']=(string)$nums;
			
			if(!$v['thumb']){
				$result[$k]['thumb']=$v['avatar'];
			}
		}	
		/* if($result){
			$last=array_slice($result);
			$_SESSION['new_starttime']=$last['starttime'];
		} */
		
		return $result;
    }
	
		/* 关注列表 */
    public function getFollow($uid,$p) {
		$result=array();
		$pnum=50;
		$start=($p-1)*$pnum;
		
		$touid=DI()->notorm->users_attention
				->select("touid")
				->where('uid=?',$uid)
				->fetchAll();
		$where=" islive='1' ";					
		if($p!=1){
			$endtime=$_SESSION['follow_starttime'];
			$where.=" and starttime < {$endtime}";
		}					
		if($touid){
			$touids=array_column($touid,"touid");
			$touidss=implode(",",$touids);
			$where.=" and uid in ({$touidss})";
			$result=DI()->notorm->users_live
					->select("uid,avatar,avatar_thumb,user_nicename,title,city,stream,pull,thumb")
					->where($where)
					->order("starttime desc")
					->limit($start,$pnum)
					->fetchAll();
		}	
		foreach($result as $k=>$v){
			$nums=DI()->redis->hget("livenums",$v['stream']);
			if(!$nums || $nums<0){
				$nums=0;
			}
			$result[$k]['nums']=(string)$nums;
			
			if(!$v['thumb']){
				$result[$k]['thumb']=$v['avatar'];
			}
		}	

		if($result){
			$last=array_slice($result);
			$_SESSION['follow_starttime']=$last['starttime'];
		}

		return $result;					
    }
		
		/* 最新 */
    public function getNew($lng,$lat,$p) {
		$pnum=50;
		$start=($p-1)*$pnum;
		$where=" islive='1' ";

		if($p!=1){
			$endtime=$_SESSION['new_starttime'];
			$where.=" and starttime < {$endtime}";
		}
		
		$result=DI()->notorm->users_live
				->select("uid,avatar,avatar_thumb,user_nicename,title,city,stream,lng,lat,pull,thumb")
				->where($where)
				->order("starttime desc")
				->limit($start,$pnum)
				->fetchAll();	
		foreach($result as $k=>$v){
			$nums=DI()->redis->hget("livenums",$v['stream']);
			if(!$nums || $nums<0){
				$nums=0;
			}
			$result[$k]['nums']=(string)$nums;
			
			if(!$v['thumb']){
				$result[$k]['thumb']=$v['avatar'];
			}
			$distance='好像在火星';
			if($lng && $lat && $v['lat'] && $v['lng']){
				$distance=$this->getDistance($lat,$lng,$v['lat'],$v['lng']);
			}else if($v['city']){
				$distance=$v['city'];	
			}
			
			$result[$k]['distance']=$distance;
			unset($result[$k]['lng']);
			unset($result[$k]['lat']);
		}		
		if($result){
			$last=array_slice($result);
			$_SESSION['new_starttime']=$last['starttime'];
		}

		return $result;
    }
		
		/* 搜索 */
    public function search($uid,$key,$p) {
		$pnum=50;
		$start=($p-1)*$pnum;
		$where=' user_type="2" and ( id=? or user_nicename like ? ) and id!=?';
		if($p!=1){
			$id=$_SESSION['search'];
			$where.=" and id < {$id}";
		}
		
		$result=DI()->notorm->users
				->select("id,user_nicename,avatar,sex,signature,consumption")
				->where($where,$key,'%'.$key.'%',$uid)
				->order("id desc")
				->limit($start,$pnum)
				->fetchAll();
		foreach($result as $k=>$v){
			$result[$k]['level']=(string)$this->getLevel($v['consumption']);
			$result[$k]['isattention']=(string)$this->isAttention($uid,$v['id']);
			$result[$k]['avatar']=$this->get_upload_path($v['avatar']);
			unset($result[$k]['consumption']);
		}				
		
		if($result){
			$last=array_slice($result);
			$_SESSION['search']=$last['id'];
		}
		
		return $result;
    }
	
	
	
		/*获取城市列表*/
	public function getCityList(){	
		$province		=	DI()->notorm->region->select('id,areaname as provincename,parentid')->where('parentid=0')->fetchAll();
		$pids 			=	'';
		$cids 			=	'';			
		foreach($province as $v){
			$pids 	 	.=	$v['id'].',';
		}
		$pids 			 = trim($pids,',');				
		$sql 			=	"select id,parentid,areaname as cityname,parentid from cmf_region where parentid in ({$pids})";		
		$city			=	DI()->notorm->region->queryAll($sql);		
		foreach($city as $v){
			$cids 	 	.=	$v['id'].',';
		}
		$cids 			=  trim($cids,',');
		$sql 			=	"select id,parentid,areaname,parentid from cmf_region where parentid in ({$cids})";
		$area 			=	DI()->notorm->region->queryAll($sql);
		foreach ($city as $key => $value) {
			$data[$key] 		=	$value;
			foreach ($area as $k => $val) {
				if($value['id']==$val['parentid']){
					$data[$key]['area'][]		=	$val;	
				}
			}		
		}	
		
		foreach ($province as $key => $value) {
			$result[$key] 		=	$value;
			foreach ($data as $k => $val) {
				if($value['id']==$val['parentid']){
					$result[$key]['city'][]		=	$val;	
				}
			}		
		}
		return $result;		

	}
	
	
	

}
