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
<style>
input{
<<<<<<< HEAD
  width:50px;
=======
  width:500px;
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
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
<<<<<<< HEAD
			<li><a>充值设置</a></li>
		</ul>
		
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('ChargeSetting/set_post');?>">
=======
			<li><a>网站信息</a></li>
			<li><a>APP版本管理</a></li>
			<li><a>分享设置</a></li>
			<li><a>PC推流设置</a></li>
		</ul>
		
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Config/set_post');?>">
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
			<input type="hidden" name="post['id']" value="1">
			<div class="js-tabs-content">
				<!-- 网站信息 -->
				<div>
					<fieldset>
						<div class="control-group">
<<<<<<< HEAD
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
=======
							<label class="control-label">网站标题</label>
							<div class="controls">				
								<input type="text" name="post[sitename]" value="<?php echo ($config['sitename']); ?>">网站标题
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">网站域名</label>
							<div class="controls">				
								<input type="text" name="post[site]" value="<?php echo ($config['site']); ?>"> 网站域名，http:// 开头  尾部不带 /
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">接口域名</label>
							<div class="controls">				
								<input type="text" name="post[site_url]" value="<?php echo ($config['site_url']); ?>"> 接口访问域名
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">钻石名称</label>
							<div class="controls">				
								<input type="text" name="post[name_coin]" value="<?php echo ($config['name_coin']); ?>">用户充值得到的虚拟币名称
							</div>
						</div><div class="control-group">
							<label class="control-label">映票名称</label>
							<div class="controls">				
								<input type="text" name="post[name_votes]" value="<?php echo ($config['name_votes']); ?>">主播获得的虚拟票名称
							</div>
						</div><div class="control-group">
							<label class="control-label">金光一闪提示</label>
							<div class="controls">				
									<input type="text" name="post[enter_tip_level]" value="<?php echo ($config['enter_tip_level']); ?>"> 用户等级大于该值时，进入房间有金光一闪效果
							</div>
						</div><div class="control-group">
							<label class="control-label">IOS上架控制</label>
							<div class="controls">				
								<label class="radio inline"><input type="radio" value="0" name="post[ios_shelves]" <?php if(($config['ios_shelves']) == "0"): ?>checked="checked"<?php endif; ?>>隐藏</label>
								<label class="radio inline"><input type="radio" value="1" name="post[ios_shelves]" <?php if(($config['ios_shelves']) == "1"): ?>checked="checked"<?php endif; ?>>显示</label>
								<label class="checkbox inline"></label>
							</div>
						</div>
					</fieldset>
				</div>
				<!-- APP版本管理 -->
				<div>
					<fieldset>
						<div class="control-group">
							<label class="control-label">APK版本号</label>
							<div class="controls">				
								<input type="text" name="post[apk_ver]" value="<?php echo ($config['apk_ver']); ?>"> 安卓APP最新的版本号，请勿随意修改
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">APK下载链接</label>
							<div class="controls">				
								<input type="text" name="post[apk_url]" value="<?php echo ($config['apk_url']); ?>"> 安卓最新版APK下载链接
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">IPA版本号</label>
							<div class="controls">				
								<input type="text" name="post[ipa_ver]" value="<?php echo ($config['ipa_ver']); ?>"> IOS APP最新的版本号，请勿随意修改
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">IPA下载链接</label>
							<div class="controls">				
								<input type="text" name="post[ipa_url]" value="<?php echo ($config['ipa_url']); ?>"> IOS最新版IPA下载链接
							</div>
						</div>
					<div class="control-group">
						<label class="control-label">二维码下载链接</label>
						<div class="controls">
								<div >
									<input type="hidden" name="post[qr_url]" id="thumb" value="<?php echo ($config['qr_url']); ?>">
									<a href="javascript:void(0);" onclick="flashuploadcut('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','','','');return false;">
									  <?php if($config['qr_url'] != ''): ?><img src="<?php echo ($config['qr_url']); ?>" id="thumb_preview" width="135" style="cursor: hand" />
										<?php else: ?>
										    <img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb_preview" width="135" style="cursor: hand" /><?php endif; ?>
									</a>
									<input type="button" class="btn btn-small" onclick="$('#thumb_preview').attr('src','/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png');$('#thumb').val('');return false;" value="取消图片">
								</div>
							<span class="form-required"></span>
						</div>
					</div>
						
					</fieldset>
				</div>
				<!-- 分享设置 -->
				<div>
					<fieldset>
						<div class="control-group">
							<label class="control-label">微信推广域名</label>
							<div class="controls">				
								<input type="text" name="post[wx_siteurl]" value="<?php echo ($config['wx_siteurl']); ?>"> http:// 开头 参数值为用户ID
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">分享标题</label>
							<div class="controls">				
								<input type="text" name="post[share_title]" value="<?php echo ($config['share_title']); ?>"> 分享标题
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">分享话术</label>
							<div class="controls">				
								<input type="text" name="post[share_des]" value="<?php echo ($config['share_des']); ?>"> 分享话术
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">AndroidAPP下载链接</label>
							<div class="controls">				
								<input type="text" name="post[app_android]" value="<?php echo ($config['app_android']); ?>"> 分享用Android APP 下载链接
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">IOSAPP下载链接</label>
							<div class="controls">				
								<input type="text" name="post[app_ios]" value="<?php echo ($config['app_ios']); ?>"> 分享用IOS APP 下载链接
							</div>
						</div>
						<div class="control-group">
					
				</div>
						
					</fieldset>
				</div>
				<!-- PC推流设置 -->
				<div>
					<fieldset>
						<div class="control-group">
							<label class="control-label">推流分辨率宽度</label>
							<div class="controls">				
								<input type="text" name="post[live_width]" value="<?php echo ($config['live_width']); ?>">PC主播端flash分辨路宽度
							</div>
						</div><div class="control-group">
							<label class="control-label">推流分辨率高度</label>
							<div class="controls">				
								<input type="text" name="post[live_height]" value="<?php echo ($config['live_height']); ?>">PC主播端flash分辨路高度
							</div>
						</div><div class="control-group">
							<label class="control-label">关键帧</label>
							<div class="controls">				
								<input type="text" name="post[keyframe]" value="<?php echo ($config['keyframe']); ?>">PC主播端flash关键帧（推荐15-30）
							</div>
						</div><div class="control-group">
							<label class="control-label">fps帧数</label>
							<div class="controls">				
								<input type="text" name="post[fps]" value="<?php echo ($config['fps']); ?>">PC主播端flash FPS帧数（推荐30）
							</div>
						</div><div class="control-group">
							<label class="control-label">品质</label>
							<div class="controls">				
								<input type="text" name="post[quality]" value="<?php echo ($config['quality']); ?>">PC主播端flash 画面品质（推荐90-100）
							</div>
						</div>
						
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
					</fieldset>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('SAVE');?></button>
<<<<<<< HEAD
				<a class="btn" href="<?php echo U('chargeSetting/index');?>"><?php echo L('BACK');?></a>
=======
				<a class="btn" href="<?php echo U('user/index');?>"><?php echo L('BACK');?></a>
>>>>>>> 44957bbe60877878268fbcc85720e0bd31ebe8bc
			</div>
		</form>
	</div>
	<script src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
</body>
</html>