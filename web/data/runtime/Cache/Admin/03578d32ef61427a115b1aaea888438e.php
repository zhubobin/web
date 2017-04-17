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
	<link rel="stylesheet" type="text/css" href="/web/public/simpleboot/css/admin.css"/>
	<script src="/web/public/js/common.js"></script>
	<script src="/web/public/js/swfobject.js"></script>
	<script src="/web/public/js/socket.io.js"></script>
	<script src="/web/public/js/admin.js"></script>
	<div class="buyvip" id="buyvip"></div>
	<div class="dds-dialog-bg" id="ds-dialog-bg"></div>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a >监控</a></li>
		</ul>
		<form method="post" class="js-ajax-form" >
        <ul>
					<?php if(is_array($lists)): foreach($lists as $key=>$v): ?><li class="mytd">
					<span>开播时长:<?php  $times = time()-$v['showid']; $result = ''; $hour = floor($times/3600); $minute = floor(($times-3600 * $hour)/60); $second = floor((($times-3600 * $hour) - 60 * $minute) % 60); $result = $hour.':'.$minute.':'.$second; echo $result;?></span>
								<div  id="<?php echo $v['uid'];?>" style="margin-left: 5px;"></div><br>
								<span class="name">主播:<?php echo $v['userinfo']['user_nicename'];?></span>
								<span>房间号:<?php echo $v['uid'];?></span>
								<div>
									<a  onclick="closeRoom('<?php echo $v['uid'];?>')" class="full_btn mybtn">关闭</a>
									<a  onclick="fullRoom('<?php echo $v['uid'];?>')" class="full_btn mybtn">大屏</a>
								</div>
					</li>
	    		<script type="text/javascript">
							swfobject.embedSWF("/web/public/js/monitor.swf?roomId=<?php echo $v['stream'];?>&cdn=<?php echo ($config['pull_url']); ?>", "<?php echo ($v['uid']); ?>", 160, 230, "10.0", "", {},{wmode:"transparent", allowscriptaccess:"always"});	
					</script><?php endforeach; endif; ?>
				</ul>
			<div class="pagination"  style="clear:both"><?php echo ($page); ?></div>
		</form>
	</div>
<script type="text/javascript" src="/web/public/playback/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
     var socket = new io("<?php echo ($config['chatserver']); ?>");
    function closeRoom(roomId){
      var data2 = {"token":"1234567","roomnum":roomId};
			$.ajax({
				type: "get",
				async: false,
				url: './index.php?g=admin&m=Monitor&a=stopRoom',
				data:{uid:roomId},
				dataType: "jsonp",
				jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
				success: function(data){
					if(data.status !=0){
						alert(data.info);
					}else{
						socket.emit("superadminaction",data2);
						alert("房间已关闭");
					}
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					alert('关闭失败，请重试');
				}
			});
		}
</script>
</body>
</html>