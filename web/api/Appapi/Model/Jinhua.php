<?php
class Model_Jinhua extends Model_Common {
	public function Jinhua() {
		 /* 花色	4表示黑桃 3表示红桃 2表示方片  1表示梅花 */
		/* 牌面 格式 花色-数字 14代表1(PS：请叫它A (jian))*/
		$cards=array('1-14','1-2','1-3','1-4','1-5','1-6','1-7','1-8','1-9','1-10','1-11','1-12','1-13','2-14','2-2','2-3','2-4','2-5','2-6','2-7','2-8','2-9','2-10','2-11','2-12','2-13','3-14','3-2','3-3','3-4','3-5','3-6','3-7','3-8','3-9','3-10','3-11','3-12','3-13','4-14','4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11','4-12','4-13');
		shuffle($cards);
		$card1=array_slice($cards,0,3);
		$card2=array_slice($cards,3,3);
		$card3=array_slice($cards,6,3);
		$Card_one=$this->Card($card1);
		$Card_two=$this->Card($card2);
		$Card_three=$this->Card($card3);
		$compare=$this->compare($Card_one,$Card_two,$Card_three);
		$card1[]=(string)$compare['one_bright'];
		$card1[]=$Card_one['name'];
		$card2[]=(string)$compare['two_bright'];
		$card2[]=$Card_two['name'];
		$card3[]=(string)$compare['three_bright'];
		$card3[]=$Card_three['name'];
		$rs[]=$card1;
		$rs[]=$card2;
		$rs[]=$card3;
		return $rs;
	}
	/*分析牌面 类型*/
	public function Card($deck)
	{
		$deck_rs=array();
		foreach($deck as $k=>$v){
			$carde=explode('-',$v);
			$deck_rs[$k]['color']=$carde[0];
			$deck_rs[$k]['brand']=$carde[1];
			$order[$k]=$carde[1];
			array_multisort($order, SORT_DESC,$deck_rs);
		}
	/* 	return $deck_rs; */
	 	$brand_one=$deck_rs[0]['brand'];
		$brand_two=$deck_rs[1]['brand'];
		$brand_three=$deck_rs[2]['brand'];
		$color_one=$deck_rs[0]['color'];
		$color_two=$deck_rs[1]['color'];
		$color_three=$deck_rs[2]['color'];
		$rs=array();
		$rs['val_one']=$brand_one;
		$rs['val_two']=$brand_two;
		$rs['val_three']=$brand_three;
		$rs['color']=0;
		$along=0;
		$people = array(array(14,3,2),array(14,2,3),array(3,2,14),array(3,14,2),array(2,14,3),array(2,3,14));
		if(in_array(array($brand_one,$brand_two,$brand_three),$people)){
			$along=1;
		}
		if($brand_one==$brand_two && $brand_two==$brand_three){	//豹子
			$rs['card']=6;
			$rs['name']="豹子";
		}else if($color_one==$color_two && $color_two==$color_three &&(($brand_one+2)==$brand_three || $along==1)){//同花顺
			$rs['color']=$color_three;
			$rs['card']=5;
			$rs['name']="同花顺";
		}else if($color_one==$color_two && $color_two==$color_three){	//同花
			$rs['color']=$color_three;
			$rs['card']=4;
			$rs['name']="同花";
		}else if(($brand_one+2)==$brand_three||$along==1){//顺子
			$rs['color']=$color_three;
			$rs['card']=3;
			$rs['name']="顺子";
		}else if($brand_one==$brand_two||$brand_two==$brand_three||$brand_one==$brand_three){//对子
			$rs['card']=2;
			$rs['name']="对子";
			if($brand_one==$brand_two)//1==2
			{
				$rs['val_one']=$brand_two;
				$rs['val_three']=$brand_three;
				$rs['color']=$color_three;
			}else if($brand_three==$brand_two){//2==3
				$rs['val_one']=$brand_three;
				$rs['val_three']=$brand_one;
				$rs['color']=$color_one;
			}else{//1==3
				$rs['val_one']=$brand_one;
				$rs['val_three']=$brand_two;
				$rs['color']=$color_two;
			}
		}else{//单张
			$rs['color']=$color_three;
			$rs['card']=1;
			$rs['name']="三足鼎立";
		}
			return $rs;
	}
	/**
	判断三副牌的类型大小 找出类型最大的牌
	val_one为三张牌中最大的那一张
	$rs['one_bright'] 是否为最大 0为否 1为是
	$null设置一个空数组 当只有2副牌 是相同是 传null 这个数组替代
	**/
	public function compare($one,$two,$three)
	{
		$rs=array();
		$null=array(
			"val_one"=>'0',
			"val_two"=>'0',
			"val_three"=>'0',
			"color"=>'0',
			"card"=>'0',
		);
		$rs['one_bright']=0;
		$rs['two_bright']=0;
		$rs['three_bright']=0;
		if($one['card']==$two['card']&&$two['card']==$three['card']){//三张牌的类型一致
				$belongTo=$this->belongTo($one['card'],$one,$two,$three,0);
				if($belongTo=="2"){
					$rs['two_bright']=1;
				}else if($belongTo=="1"){
					$rs['one_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
		}else if($one['card']==$two['card']){//一号牌与二号牌的类型一致
			if($one['card']<$three['card']){
				$rs['three_bright']=1;
			}else{
				$belongTo=$this->belongTo($one['card'],$one,$two,$null,1);
				if($belongTo==2){
					$rs['two_bright']=1;
				}else{
					$rs['one_bright']=1;
				}
			}
		}else if($one['card']==$three['card']){//一号牌与三号牌的类型一致
			if($one['card']<$two['card']){
				$rs['two_bright']=1;
			}else{
				$belongTo=$this->belongTo($one['card'],$one,$null,$three,1);
				if($belongTo==3){
					$rs['three_bright']=1;
				}else{
					$rs['one_bright']=1;
				}
			}
		}else if($two['card']==$three['card']){//二号牌与三号牌的类型一致
			if($two['card']<$one['card']){
				$rs['one_bright']=1;
			}else{
				$belongTo=$this->belongTo($one['card'],$null,$two,$three,1);
				if($belongTo==1){
					$rs['two_bright']=1;
				}else{
					$rs['one_bright']=2;
				}
			}
		}else{//三种牌的类型都不一致
			if($one['card']>$two['card'])
			{
				if($one['card']>$three['card']){
					$rs['one_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
			}else{
				if($two['card']>$three['card']){
					$rs['two_bright']=1;
				}else{
					$rs['three_bright']=1;
				}
			}
		}
		return $rs;
	}
	/**
	判断相同类型的牌
	val_one 为三张牌中最大的 那一张
	type 0代表三副牌的类型一致 1代表只有两副牌的类型一致
	**/
	public function belongTo($card,$one,$two,$three,$type)
	{
		$rs=array();
		if($card==1){//三副牌都是豹子比较
			$rs=$this->leopard_than($one,$two,$three);
		}else if($card==2){//三副牌都是同花顺比较
			$rs=$this->flush_than($one,$two,$three);
		}else if($card==3){//同花
			$rs=$this->flower_than($one,$two,$three);
		}else if($card==4){//顺子
			$rs=$this->along_than($one,$two,$three);
		}else if($card==5){//对子
			$rs=$this->sub_than($one,$two,$three);
		}else{//单张
			$rs=$this->single_than($one,$two,$three);
		}
		return $rs;
	}
	/**
	豹子比较
	**/
	public function leopard_than($one,$two,$three)
	{
		if($one['val_one']>$two['val_one']){
			if($one['val_one']>$three['val_one']){
				return 1;
			}else{
				return 3;
			}
		}else{
			if($two['val_one']>$three['val_one']){
				return 2;
			}else{
				return 3;
			}
		}
	}
	/**
	同花顺比较
	**/
	public function flush_than($one,$two,$three)
	{
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的牌面数字大小一致
			if($one['color']>$two['color'])
			{
				if($one['color']>$three['color']){
					return 1;
				}else{
					return 3;
				}
			}else{
				if($two['color']>$three['color']){
					return 2;
				}else{
					return 3;
				}
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的牌面大小一致
			if($two['val_one']>$three['val_one']){
				if($two['color']>$one['color'])
				{
					return 2;
				}else{
						return 1;
				}
			}else{
					return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌的牌面大小一致
			if($one['val_one']>$two['val_one']){
				if($one['color']>$three['color'])
				{
					return 1;
				}else{
					return 3;
				}
			}else{
					return 2;
			}
		}else if($two['val_one']==$three['val_one']){//二号牌和三号牌的牌面大小一致
			if($two['val_one']>$one['val_one']){
				if($two['color']>$three['color'])
				{
					return 2;
				}else{
					return 3;
				}
			}else{
				return 1;
			}
		}else{//三副牌的牌面大小均不一致
			if($one['val_one']>$two['val_one']){
				if($one['val_one']>$three['val_one']){
					return 1;
				}else{
					return 3;
				}
			}else{
				if($two['val_one']>$three['val_one']){
					return 2;
				}else{
					return 3;
				}
			}
		}
	}
	/**
	同花比较
	**/
	public function flower_than($one,$two,$three)
	{
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的第一张牌的牌面一致
			if($two['val_two']==$three['val_two']&&$one['val_two']==$three['val_two']){//三副牌的第二张牌的牌面一致
					//三副牌的第三张牌的牌面一致(一致用 花色比较  不一致比较大小)
					if($two['val_three']==$three['val_three']&&$one['val_three']==$three['val_three']){
						$common=$this->than($one['color'],$two['color'],$three['color']);
						return $common;
					}else if($two['val_three']==$one['val_three']){//一号牌和二号牌的第三张牌牌面一样
						if($two['val_three']>$three['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							return 3;
						}
					}else if($three['val_three']==$one['val_three']){//一号牌和三号牌的第三张牌牌面一样
						if($one['val_three']>$two['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							return 2;
						}
					}else if($two['val_three']==$three['val_three']){//二号牌和三号牌的第三张牌牌面一样
						if($two['val_three']>$one['val_three'])
						{
							if($two['color']>$three['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							return 1;
						}
					}else{//三副牌的第三张拍的牌面均不一致
						$common=$this->than($one['val_three'],$two['val_three'],$three['val_three']);
						return $common;
					}
			}else if($two['val_two']==$one['val_two']){//一号牌和二号牌的第二张牌牌面一样
				if($two['val_two']>$three['val_two'])
				{
					if($two['val_three']==$one['val_three'])
					{
						if($two['color']>$one['color'])
						{
							return 2;
						}else{
							return 1;
						}
					}else{
						if($two['val_three']>$one['val_three']){
							return 2;
						}else{
							return 1;
						}
					}
				}else{
					return 3;
				}
			}else if($three['val_two']==$one['val_two']){//一号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$two['val_two'])
				{
					if($three['val_three']==$one['val_three'])
					{
						if($three['color']>$one['color'])
						{
							return 3;
						}else{
							return 1;
						}
					}else{
						if($three['val_three']>$one['val_three']){
							return 3;
						}else{
							return 1;
						}
					}
				}else{
					return 2;
				}
			}else if($three['val_two']==$two['val_two']){//二号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$one['val_two'])
				{
					if($three['val_three']==$two['val_three'])
					{
						if($three['color']>$two['color'])
						{
							return 3;
						}else{
							return 2;
						}
					}else{
						if($three['val_three']>$two['val_three']){
							return 3;
						}else{
							return 2;
						}
					}
				}else{
					return 1;
				}
			}else{
				
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的第一张牌牌面一样
			if($two['val_one']>$three['val_one'])
			{
				if($two['val_two']==$one['val_two']){
						if($two['val_three']==$one['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							if($two['val_three']>$one['val_three'])
							{
								return 2;
							}else{
								return 1;
							}
						}
				}else{
					if($two['val_two']>$one['val_two'])
					{
						return 2;
					}else{
						return 1;
					}
				}
			}else{
				return 3;
			}
		}else if($three['val_one']==$one['val_one']){//一号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$one['val_two']){
						if($three['val_three']==$one['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							if($three['val_three']>$one['val_three'])
							{
								return 3;
							}else{
								return 1;
							}
						}
				}else{
					if($three['val_two']>$one['val_two'])
					{
						return 3;
					}else{
						return 1;
					}
				}
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$two['val_two']){
						if($three['val_three']==$two['val_three'])
						{
							if($three['color']>$two['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							if($three['val_three']>$two['val_three'])
							{
								return 3;
							}else{
								return 2;
							}
						}
				}else{
					if($three['val_two']>$two['val_two'])
					{
						return 3;
					}else{
						return 2;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}
	public function than($one,$two,$three)
	{
		if($one>$two)
		{
			if($one>$three){
				return 1;
			}else{
				return 3;
			}
		}else{
			if($two>$three){
				return 2;
			}else{
				return 3;
			}
		}
	}
	/**
	顺子比较
	流程 一次比较最大 如果三张牌相同 则比较嘴的牌的花色
	**/
	public function along_than($one,$two,$three)
	{
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one'])
		{
			$common=$this->than($one['color'],$two['color'],$three['color']);
			return $common;
		}else if($one['val_one']==$two['val_one']){//一号牌和二号牌牌面一直
			if($one['val_one']>$three['val_one'])
			{
				$common=$this->than($one['color'],$two['color'],0);
				return $common;
			}else{
				return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌牌面一直
			if($one['val_one']>$two['val_one'])
			{
				$common=$this->than($one['color'],0,$two['color']);
				return $common;
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌牌面一直
			if($two['val_one']>$one['val_one'])
			{
				$common=$this->than(0,$two['color'],$two['color']);
				return $common;
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}
	/*对子比较*/
	public function sub_than($one,$two,$three)
	{
			return 3;
		if($one['val_one']==$two['val_one']){//一号牌和二号牌牌面一致
			if($one['val_one']>$three['val_one']){
				if($one['val_three']==$two['val_three']){
					if($one['color']>$two['color']){
						return 1;
					}else{
						return 2;
					}
				}else{
					if($one['val_three']>$two['val_three']){
						return 1;
					}else{
						return 2;
					}
				}
			}else{
				return 3;
			}
		}else if($one['val_one']==$three['val_one']){//一号牌和三号牌牌面一致
			if($one['val_one']>$two['val_one']){
				if($one['val_three']==$three['val_three']){
					if($one['color']>$three['color']){
						return 1;
					}else{
						return 3;
					}
				}else{
					if($one['val_three']>$three['val_three']){
						return 1;
					}else{
						return 3;
					}
				}
			}else{
				return 2;
			}
		}else if($two['val_one']==$three['val_one']){//二号牌和三号牌牌面一致
			if($two['val_one']>$one['val_one']){
				if($two['val_three']==$three['val_three']){
					if($two['color']>$three['color']){
						return 2;
					}else{
						return 3;
					}
				}else{
					if($two['val_three']>$three['val_three']){
						return 2;
					}else{
						return 3;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}
	/**比较单张
	**/
	public function single_than($one,$two,$three)
	{
		if($two['val_one']==$three['val_one']&&$one['val_one']==$three['val_one']){//三副牌的第一张牌的牌面一致
			if($two['val_two']==$three['val_two']&&$one['val_two']==$three['val_two']){//三副牌的第二张牌的牌面一致
					//三副牌的第三张牌的牌面一致(一致用 花色比较  不一致比较大小)
					if($two['val_three']==$three['val_three']&&$one['val_three']==$three['val_three']){
						$common=$this->than($one['color'],$two['color'],$three['color']);
						return $common;
					}else if($two['val_three']==$one['val_three']){//一号牌和二号牌的第三张牌牌面一样
						if($two['val_three']>$three['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							return 3;
						}
					}else if($three['val_three']==$one['val_three']){//一号牌和三号牌的第三张牌牌面一样
						if($one['val_three']>$two['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							return 2;
						}
					}else if($two['val_three']==$three['val_three']){//二号牌和三号牌的第三张牌牌面一样
						if($two['val_three']>$one['val_three'])
						{
							if($two['color']>$three['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							return 1;
						}
					}else{//三副牌的第三张拍的牌面均不一致
						$common=$this->than($one['val_three'],$two['val_three'],$three['val_three']);
						return $common;
					}
			}else if($two['val_two']==$one['val_two']){//一号牌和二号牌的第二张牌牌面一样
				if($two['val_two']>$three['val_two'])
				{
					if($two['val_three']==$one['val_three'])
					{
						if($two['color']>$one['color'])
						{
							return 2;
						}else{
							return 1;
						}
					}else{
						if($two['val_three']>$one['val_three']){
							return 2;
						}else{
							return 1;
						}
					}
				}else{
					return 3;
				}
			}else if($three['val_two']==$one['val_two']){//一号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$two['val_two'])
				{
					if($three['val_three']==$one['val_three'])
					{
						if($three['color']>$one['color'])
						{
							return 3;
						}else{
							return 1;
						}
					}else{
						if($three['val_three']>$one['val_three']){
							return 3;
						}else{
							return 1;
						}
					}
				}else{
					return 2;
				}
			}else if($three['val_two']==$two['val_two']){//二号牌和三号牌的第二张牌牌面一样
				if($three['val_two']>$one['val_two'])
				{
					if($three['val_three']==$two['val_three'])
					{
						if($three['color']>$two['color'])
						{
							return 3;
						}else{
							return 2;
						}
					}else{
						if($three['val_three']>$two['val_three']){
							return 3;
						}else{
							return 2;
						}
					}
				}else{
					return 1;
				}
			}else{
				
			}
		}else if($two['val_one']==$one['val_one']){//一号牌和二号牌的第一张牌牌面一样
			if($two['val_one']>$three['val_one'])
			{
				if($two['val_two']==$one['val_two']){
						if($two['val_three']==$one['val_three'])
						{
							if($two['color']>$one['color'])
							{
								return 2;
							}else{
								return 1;
							}
						}else{
							if($two['val_three']>$one['val_three'])
							{
								return 2;
							}else{
								return 1;
							}
						}
				}else{
					if($two['val_two']>$one['val_two'])
					{
						return 2;
					}else{
						return 1;
					}
				}
			}else{
				return 3;
			}
		}else if($three['val_one']==$one['val_one']){//一号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$one['val_two']){
						if($three['val_three']==$one['val_three'])
						{
							if($three['color']>$one['color'])
							{
								return 3;
							}else{
								return 1;
							}
						}else{
							if($three['val_three']>$one['val_three'])
							{
								return 3;
							}else{
								return 1;
							}
						}
				}else{
					if($three['val_two']>$one['val_two'])
					{
						return 3;
					}else{
						return 1;
					}
				}
			}else{
				return 2;
			}
		}else if($three['val_one']==$two['val_one']){//二号牌和三号牌的第一张牌牌面一样
			if($two['val_one']>$one['val_one'])
			{
				if($three['val_two']==$two['val_two']){
						if($three['val_three']==$two['val_three'])
						{
							if($three['color']>$two['color'])
							{
								return 3;
							}else{
								return 2;
							}
						}else{
							if($three['val_three']>$two['val_three'])
							{
								return 3;
							}else{
								return 2;
							}
						}
				}else{
					if($three['val_two']>$two['val_two'])
					{
						return 3;
					}else{
						return 2;
					}
				}
			}else{
				return 1;
			}
		}else{
			$common=$this->than($one['val_one'],$two['val_one'],$three['val_one']);
			return $common;
		}
	}
}