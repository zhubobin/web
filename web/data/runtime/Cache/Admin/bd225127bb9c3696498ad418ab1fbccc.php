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

	<link href="/web/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/web/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/web/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/web/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/web/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/web/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/web/public/js/jquery.js"></script>
    <script src="/web/public/js/wind.js"></script>
    <script src="/web/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
<style>
input{
  width:50px;
}
.form-horizontal textarea{
 width:500px;
}
.nav-tabs>.current>a{
    color: #95a5a6;
    cursor: default;
    background-color: #fff;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
}
.nav li
{
	cursor:pointer
}
.nav li:hover
{
	cursor:pointer
}
</style>


	<div class="wrap js-check-wrap">
		<!-- <ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Config/index');?>">设置</a></li>
			<li><a href="<?php echo U('Config/lists');?>">管理</a></li>
			<li><a href="<?php echo U('Config/add');?>">添加</a></li>
		</ul> -->
		<ul class="nav nav-tabs js-tabs-nav">
			<li><a>充值设置</a></li>
		</ul>
		
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('ChargeSetting/set_post');?>">
			<input type="hidden" name="post['id']" value="1">
			<div class="js-tabs-content">
				<!-- 网站信息 -->
				<div>
					<fieldset>
						<div class="control-group">
							<label class="control-label">充值比例</label>
							<div class="controls">				
								<input type="text" name="post[charge_rate]" value="<?php echo ($config['charge_rate']); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">提现比例</label>
							<div class="controls">				
								<input type="text" name="post[cash_rate]" value="<?php echo ($config['cash_rate']); ?>">%
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('SAVE');?></button>
				<a class="btn" href="<?php echo U('chargeSetting/index');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/web/public/js/common.js"></script>
	<script type="text/javascript" src="/web/public/js/content_addtop.js"></script>
</body>
</html>