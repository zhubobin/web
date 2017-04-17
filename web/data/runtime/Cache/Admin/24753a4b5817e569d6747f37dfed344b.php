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
	<div class="wrap">
		<ul class="nav nav-tabs">
			<!-- <li ><a href="<?php echo U('System/index');?>">消息列表</a></li> -->
			<li class="active"><a >发送消息</a></li>
		</ul>

			<fieldset>

				<div class="control-group">
					<label class="control-label">消息内容</label>
					<div class="controls">
						<input type="text" name="content"  value="" id="content">
						<span class="form-required">*</span>
					</div>
				</div>

				<!-- <div class="control-group">
					<label class="control-label">失败原因</label>
					<div class="controls">
						 <textarea name="reason" rows="2" cols="20" id="reason" class="inputtext" style="height: 100px; width: 500px;"><?php echo ($auth['reason']); ?></textarea>
						<span class="form-required">*</span>
					</div>
				</div> -->

			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">发送</button>
				<!-- <a class="btn" href="<?php echo U('System/index');?>"><?php echo L('BACK');?></a> -->
			</div>
	</div>

	<script src="/web/public/js/socket.io.js"></script>
<script type="text/javascript">

     var socket = new io("<?php echo ($config['chatserver']); ?>");
	 $(".js-ajax-submit").on("click",function(){
		
		var content=$.trim( $("#content").val() );
		if(!content){
			alert("内容不能为空");
			return !1;
		}
		$.ajax({
			url:'./index.php?g=admin&m=system&a=send',
			data:{content:content},
			type:'POST',
			dataType:'json',
			success:function(data){
				if(data.error==0){
					var data2 = {"token":"1234567","content":content};
					socket.emit("systemadmin",data2);
					alert("发送成功");
				}else{
					alert(data.msg);
				}
				 
			}
		})
	 
	 })

</script>	
</body>
</html>