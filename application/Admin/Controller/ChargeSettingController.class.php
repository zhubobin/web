<?php
<<<<<<< HEAD
/* 
   扩展配置
 */

namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChargeSettingController extends AdminbaseController{
	
	protected $attribute;
	
	function _initialize() {
		parent::_initialize();
		$this->attribute = D("Common/Attribute");
	}
	
	function index(){
		$config=M("config_private")->find(1);

		$this->assign('config',$config);

		$this->display();
	}
	
=======

/**
 * 充值规则
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChargerSettingController extends AdminbaseController {

		
    function index(){
    	$rules=M("charge_rules");
    	$count=$rules->count();
    	$page = $this->page($count, 20);
    	$lists = $rules
				->where()
				->order("orderno asc")
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display();
    }		
		
	function del(){
		$id=intval($_GET['id']);
		if($id){
			$result=M("charge_rules")->where("id='{$id}'")->delete();				
				if($result){
						$this->success('删除成功');
				 }else{
						$this->error('删除失败');
				 }						
		}else{				
			$this->error('数据传入失败！');
		}								  
		$this->display();				
	}		
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
    //排序
    public function listorders() { 
		
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['orderno'] = $r;
<<<<<<< HEAD
            M("attribute")->where(array('id' => $key))->save($data);
=======
            M("charge_rules")->where(array('id' => $key))->save($data);
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
        }
				
        $status = true;
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
<<<<<<< HEAD
    }		
	
	function set_post(){
		if(IS_POST){
			
			 $config=I("post.post");
			
			/* $attribute2=M("attribute")->field("name,type")->where("type='editor' or type='checkbox'")->select();
			foreach( $attribute2 as $vo){
				 switch($vo['type']){
					case 'editor':
						$config[$vo['name']]=htmlspecialchars_decode($config[$vo['name']]);
						break;
					case 'checkbox':
						$config[$vo['name']]=implode(",",$config[$vo['name']]);
						break;
					default:
						
						break;
					 
				 }
				
			} */
				
				if (M("config_private")->where("id='1'")->save($config)!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
		
		}
	}
	
	function lists(){			
    	$attribute2=M("attribute");
    	$count=$attribute2->count();
    	$page = $this->page($count, 20);
    	$lists = $attribute2
    	->where()
    	->order("orderno asc")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display();
	}
	
    /**
     * 新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){

        $this->meta_title = '新增属性';
        $this->display('edit');
    }

    /**
     * 编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
        $id = I('get.id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }

        /*获取一条记录的详细数据*/
        $Model = M('Attribute');
        $data = $Model->field(true)->find($id);
        if(!$data){
            $this->error($Model->getError());
        }
   
        $this->assign('info', $data);
        $this->meta_title = '编辑属性';
        $this->display();
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('Attribute')->update();
        if(!$res){
            $this->error(D('Attribute')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功',U('Config/lists'));
        }
    }
    /**
     * 删除一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function delete(){
        $id = I('id');
        empty($id) && $this->error('参数错误！');

        $Model = D('Attribute');

        $info = $Model->getById($id);
        empty($info) && $this->error('该字段不存在！');

        //删除属性数据
        $res = $Model->delete($id);

        //删除表字段
        $Model->deleteField($info);
        if(!$res){
            $this->error(D('Attribute')->getError());
        }else{
            $this->success('删除成功');
        }
    }	
		public function state_hide()
		{
			$id = I('id');
			$res=M("attribute")->where("id=".$id)->setField("state", 1);
			if(!$res)
			{
				 $this->error(D('Attribute')->getError());
			}
			else
			{
				 $this->success('隐藏成功');
			}
		}
		public function state_display()
		{
			$id = I('id');
			$res=M("attribute")->where("id=".$id)->setField("state", 0);
			if(!$res)
			{
				 $this->error(D('Attribute')->getError());
			}
			else
			{
				 $this->success('开启显示');
			}
		}
}
=======
    }	
	
    function add(){
		$this->display();
    }	
	
	function do_add(){
		if(IS_POST){	
			$rules=M("charge_rules");
			$rules->create();
			$rules->addtime=time();
			 
			$result=$rules->add(); 
			if($result){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}				
    }		
    function edit(){
		$id=intval($_GET['id']);
		if($id){
			$rules	=M("charge_rules")->where("id='{$id}'")->find();
			$this->assign('rules', $rules);						
		}else{				
			$this->error('数据传入失败！');
		}								      	
    	$this->display();
    }		
	
	function do_edit(){
		if(IS_POST){			
			 $rules=M("charge_rules");
			 $rules->create();
			 $result=$rules->save(); 
			 if($result){
				  $this->success('修改成功');
			 }else{
				  $this->error('修改失败');
			 }
		}	
    }				
}
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
