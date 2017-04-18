<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Exchangerules/index');?>">规则列表</a></li>
			<li><a href="<?php echo U('Exchangerules/add');?>">规则添加</a></li>
		</ul>
		<!--<form class="well form-search" name="form1" method="post" action="">
		 兑换状态：
			<select class="select_2" name="status">
				<option value="">全部</option>
				<option value="0" <?php if($formget["status"] == '0'): ?>selected<?php endif; ?> >处理中</option>
				<option value="1" <?php if($formget["status"] == '1'): ?>selected<?php endif; ?> >兑换成功</option>			
				<option value="2" <?php if($formget["status"] == '2'): ?>selected<?php endif; ?> >拒绝兑换</option>			
			</select>
			提交时间：
			<input type="text" name="start_time" class="js-date date" value="<?php echo ($formget["start_time"]); ?>" style="width: 80px;" autocomplete="off">-
			<input type="text" class="js-date date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
			关键字： 
			<input type="text" name="keyword" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入会员id...">
			<input type="button" class="btn btn-primary" value="搜索" onclick="form1.action='<?php echo U('Exchange/index');?>';form1.submit();"/>
			<input type="button" class="btn btn-primary" style="background-color: #1dccaa;" value="导出" onclick="form1.action='<?php echo U('Exchange/export');?>';form1.submit();"/>
			<div class="admin_main">
			<a>当前兑换总咘谷豆：<?php echo ($Exchange['total']); ?></a>
			<?php if($cash['type'] == '0'): ?><a> 成功兑换咘谷豆：<?php echo ($Exchange['success']); ?></a>
				<a>待处理咘谷豆：<?php echo ($Exchange['fail']); ?></a><?php endif; ?>
		</div>
		</form>-->	
		
		<form method="post" class="js-ajax-form" >
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th align="center">ID</th>					
						<th>咘谷豆</th>
						<th>谷子</th>
						<th>提交时间</th>
						<th align="center"><?php echo L('ACTIONS');?></th>
					</tr>
				</thead>
				<tbody>
					<?php $status=array("0"=>"处理中","1"=>"兑换成功", "2"=>"拒绝兑换"); ?>
					<?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
						<td align="center"><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo['cuckoo']); ?></td>
						<td><?php echo ($vo['guzi']); ?></td>						
						<td><?php echo (date("Y-m-d H:i:s",$vo["addtime"])); ?></td>						
						<td align="center">	
						
						    <a href="<?php echo U('Exchangerules/edit',array('id'=>$vo['id']));?>" >编辑</a>  
						 	
							<!-- <a href="<?php echo U('Cash/del',array('id'=>$vo['id']));?>" class="js-ajax-dialog-btn" data-msg="您确定要删除吗？">删除</a>  -->
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo ($page); ?></div>

		</form>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>