<?php
/**
 * 会员等级
 */
namespace Appapi\Controller;
use Common\Controller\HomebaseController;
class LevelController extends HomebaseController {
	
	function index(){
		       
		$uid=I("uid");
		
		$Experlevel=M("experlevel");
         
		$experience=M("users")->where("id='$uid'")->getField("consumption");

		$level=$Experlevel->where("level_up>='$experience'")->order("levelid asc")->find();
		$level2=$Experlevel->where("level_up<='$experience'")->order("levelid desc")->find();

		$cha=$level['level_up']+1-$experience;
		if($level2){
			$min=$level2['level_up'];
		}else{
			$min=0;
		}

		$rate=floor(($experience-$min)/($level['level_up']+1-$min)*100);

		$this->assign("experience",$experience);
		$this->assign("level",$level);
		$this->assign("cha",$cha);
		$this->assign("rate",$rate);
        
		$this->display();
	    
	}


}