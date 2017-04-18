<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie oldie ie6" lang="zh">
<![endif]-->
<!--[if IE 7]>
<html class="ie oldie ie7" lang="zh">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="zh">
<![endif]-->
<!--[if IE 9]>
<html class="ie ie9" lang="zh">
<![endif]-->
<!--[if gt IE 10]><!-->
<html lang="zh">
<!--<![endif]-->
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>	
	
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">

	<!-- No Baidu Siteapp-->
	<meta http-equiv="Cache-Control" content="no-siteapp"/>

	<!-- HTML5 shim for IE8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<![endif]-->
	<link rel="icon" href="/public/images/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/public/images/favicon.ico" type="image/x-icon">
	
	<link type="text/css" rel="stylesheet" href="/public/home/css/common.css"/>
	<link type="text/css" rel="stylesheet" href="/public/home/css/login.css"/>
	<link type="text/css" rel="stylesheet" href="/public/home/css/layer.css"/>

	<meta name="keywords" content="<?php echo ($site_seo_keywords); ?>"/>
	<meta name="description" content="<?php echo ($site_seo_description); ?>"/>
	
	  <script>
        var YB_JS_CONF = window.YB_JS_CONF || {};
        YB_JS_CONF.hdType = '1080p';
        YB_JS_CONF.apiConf = {"login_api":{"getLoginUserInfo":"./index.php?m=user&a=getLoginUserInfo"},"follow_api":"./index.php?m=user&a=follow_"};
  	  </script> 
	
		<!-- 环信私信功能start -->
		<!--sdk-->
		<script src="/public/home/hxChat/js/strophe.js"></script>
		<script src="/public/home/hxChat/js/easemob.im-1.1.1.js"></script>
		<script src="/public/home/hxChat/js/easemob.im.shim.js"></script><!--兼容老版本(1.0.7含以前版本)sdk需引入此文件-->

		<!--config-->
		<script src="/public/home/hxChat/js/easemob.im.config.js"></script>

		<!--demo-->
		<script src="/public/home/hxChat/js/jquery-1.11.1.js"></script><!--此非jquery原生库，已经做过修改，环信功能必须调用-->
		<script src="/public/home/hxChat/js/bootstrap.js"></script>
		<link rel="stylesheet" href="/public/home/hxChat/css/webim.css" />

		<script type="text/javascript" src="/public/home/hxChat/js/webim.js"></script>

		<!-- 环信私信功能end -->
<title><?php echo ($site_name); ?></title>
</head>
<body style="background-color:#f3f3f3">
	<div id="doc-hd" class="header double">
		<div class="topbar">
			<div class="container clearfix">
				<div class="hd-logo">
					<a href="#" class="links"></a>
				</div>
				<ul class="hd-nav">
					<li class="item"><a href="./" <?php if($current == 'index'): ?>class="current"<?php endif; ?> >首页</a></li>
<!-- 					<li class="item"><a href="#"  <?php if($current == 'follow'): ?>class="current"<?php endif; ?> >我的关注</a></li> -->
					<li class="item"><a href="./index.php?m=Category&a=index&cat=2"  <?php if($current == '2'): ?>class="current"<?php endif; ?> >女神驾到</a></li>
					<li class="item"><a href="./index.php?m=Category&a=index&cat=1"  <?php if($current == '1'): ?>class="current"<?php endif; ?> >国民男神</a></li>
					
				</ul>
				<div class="hd-login">
				  <?php if(!$user): ?><div class="no-login">
						<i class="icon-avatar"></i>
						<a href="###" class="tologin">登录/注册</a>
						<i class="icon-level"></i>
						<i class="icon-more"></i>
					</div>
					<?php else: ?>
					<div class="already-login">
						<a class="link" href="#"><i class="icon-avatar"><img src="<?php echo ($user['avatar']); ?>" alt=""/></i><span class="nickname"><?php echo ($user['user_nicename']); ?></span></a>
						<i class="icon-level"></i>
						<i class="icon-more"></i>
						<div class="userinfo">
							<div class="userinfo_up">
							</div>
							<div class="userinfo_down">
								<div class="userinfo_name">
									 <div class="live">
										<a href="./<?php echo ($user['id']); ?>">我的直播</a>
									</div>
									<div class="live">
										<a href="./index.php?m=Personal&a=index">个人中心</a>
									</div>									
									<div class="logout">
										【退出登录】
									</div>
								</div>
							</div>
						</div>
					</div><?php endif; ?>
					<div class="huajiaodou">
					  <?php if(!$user): ?><a ></a> 
					    <?php else: ?>
						 <a class="btn-huajiaodou" href="./index.php?m=Payment&a=index" target="_blank">充值</a><?php endif; ?>
						<!-- <a class="btn-huajiaodou" href="http://www.huajiao.com/economic/pc/cash.html" target="_blank">提现</a> -->
					</div> 
				</div>
				
				<div class="search-bar">
					<div class="search-hd">
					</div>
					<div class="search-bd">
						<form class="search-form" action="index.php?m=Index&a=translate" target="_top" method="post" name="search-form">
							<div class="search-input-wrap">
								<input  class="search-input" name="keyword" id="keyword" placeholder="请输入用户名或用户ID"/>
								<input type="submit" class="search-submit-btn"/>
							</div>
						</form>
					</div>
					<div class="search-ft">
						<div id="suggest-container" class="suggest-container" style="display:none;">
							<div class="suggest-bd">
							</div>
							<div class="suggest-ft">
							</div>
						</div>
					</div>
				</div>
				<!--
下线时将下面div元素的style改为"display:none;"
上线时将下面div元素的style改为"display:block;"X35
图片尺寸120X35
-->
				<!-- <div id="top-header-position" class="top-header-position" style="display:none;">
					<a target="_blank" href="#"><img src="http://p0.qhimg.com/t0135077f9010b04266.jpg"/></a>
				</div> -->
			</div>
		</div>
	</div>


<link type="text/css" rel="stylesheet" href="/public/home/css/common.css"/>
<link type="text/css" rel="stylesheet" href="/public/home/css/Personal.css"/>
<link type="text/css" rel="stylesheet" href="/public/home/css/font-awesome.min.css"/>
<div class="headers">
  <div class="container" style="padding-top:20px">
    <div class="hersleft">
			<a href="index.php?m=Personal&a=photo" style="display:inline-block;height:88px">
				<img src="<?php echo ($info['avatar']); ?>" alt="" class="herszhezhao">
				<i class="herszhezhao">
				</i>
			</a>
		</div>
		<div class="hersright">
			<div style="display:black" id="datas">
				<div>
					<span><?php echo ($info['user_nicename']); ?></span>
					<i class="dianji" id="dianji"></i>
				</div>
				<p title="<?php echo ($info['user_login']); ?>">个人账号：<?php echo ($info['user_login']); ?></p>
			</div>
			<div style="display:none" id="modify">
				<input id="name" placeholder="请输入新昵称">
				<p>
					<span class="hersbaocun" >保存</span>
					<span class="hersquxiao">取消</span>
				</p>
			</div>
		</div>
  </div>
</div>
<div class="container">
  <div class="Firstfloor">
		<div class="Leftlayout">
			<ul id="accordion" class="accordion">
	    <li>
	      <a class="homepage"  href="index.php?m=Personal&a=index"><!-- <i class="fa fa-paint-brush"></i> -->我的首页
		  </a>
		</li>
		<li <?php if($personal == 'Set'): ?>class="gangkaishi open"<?php else: ?>class="gangkaishi"<?php endif; ?>>
			<div class="link" >账号设置<i class="fa fa-chevron-down"></i></div>
			<ul <?php if($personal == 'Set'): ?>class="submenu pedisplay"<?php else: ?>class="submenu"<?php endif; ?>>
				<li><a href="index.php?m=Personal&a=modify">基本资料</a></li>
				<li><a href="index.php?m=Personal&a=photo">修改头像</a></li>
				<li><a href="index.php?m=Personal&a=updatepass">修改密码</a></li>
			</ul>
		</li>
		<li <?php if($personal == 'follow'): ?>class="gangkaishi open"<?php else: ?>class="gangkaishi"<?php endif; ?>>
			<div class="link">我的社交<i class="fa fa-chevron-down"></i></div>
			<ul <?php if($personal == 'follow'): ?>class="submenu pedisplay"<?php else: ?>class="submenu"<?php endif; ?>>
				<li><a href="index.php?m=Personal&a=follow">我的关注</a></li>
				<li><a href="index.php?m=Personal&a=fans">我的粉丝</a></li>
				<li><a href="index.php?m=Personal&a=namelist">我的黑名单</a></li>
				<li><a href="index.php?m=Personal&a=admin">我的管理员</a></li>
				<li><a href="index.php?m=Personal&a=live">我的直播</a></li>
			</ul>
		</li>
		<li <?php if($personal == 'card'): ?>class="gangkaishi open"<?php else: ?>class="gangkaishi"<?php endif; ?>>
			<div class="link">我的认证<i class="fa fa-chevron-down"></i></div>
			<ul <?php if($personal == 'card'): ?>class="submenu pedisplay"<?php else: ?>class="submenu"<?php endif; ?>>
				<li><a href="index.php?m=Personal&a=card">我要认证</a></li>
				<li><a href="index.php?m=Personal&a=exchange">提现中心</a></li>
			</ul>
		</li>
	</ul>
		</div>
		<div class="rightlayout">
			<div class="jiben">
				<h3>修改密码</h3>
				<div id="fpost"  method="post">
					<div class="form-ctr">
						<label class="label">当前密码：</label>
					
							<input class="jiebankuangd" type="password" id="oldpass" name="oldpass" placeholder="当前密码" value="">
						
					</div>
					<div class="form-ctr">
						<label class="label">新密码：</label>
							<input type="password" name="newpass" id="newpass" class="jiebankuangd" value="" placeholder="新密码" >
					</div>
					<div class="form-ctr">
						<label class="label">确认密码：</label>
							<input class="jiebankuangd" type="password" id="repass" name="repass" placeholder="确认密码" value="">						
					</div>
					<div class="form-ctr UC-mt">
						<div class="ctr">
							<a class="baocunj" onclick="Personal.updatepass()">保存</a>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>
	<div id="doc-ft">
		<div class="container">
			<p class="footer">
				泰安云豹网络科技有限公司 地址：山东省泰安市泰山区万达广场8号楼2405 电话：0538-8270220
			</p>
			<p class="footer">
				Copyright©  2012-2016, ICP备15017218号-1
			</p>
		</div>
	</div>
		
	 <!--  <script src="/public/home/js/jquery.1.10.2.js"></script>  -->
		<script src="http://yunbaolivein.oss-cn-hangzhou.aliyuncs.com/yunbaozhibo/jquery.1.10.2.js"></script> 
		<script src="http://yunbaolivein.oss-cn-hangzhou.aliyuncs.com/yunbaozhibo/jquery.lazyload.min.js"></script> 
<!-- 	  <script src="/public/home/js/jquery.lazyload.min.js"></script> -->
		<script type="text/javascript">
			window._DATA = window._DATA || {};
			window._DATA.user = <?php echo ($userinfo); ?>;
		</script> 
		<script type="text/javascript" src="/public/home/js/login.js"></script> 
		<script type="text/javascript" src="/public/home/js/layer.js"></script> 


<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
$(function()
{
	  /* 时间控件 */
     $("input.js-date").datePicker();
}
)
</script>
<script src="/public/js/jquery.js"></script>
<script>
$(function(){
  //打开上传视频窗口
  $('.dianji').click(function()
	{
		$("#datas").css('display','none');
		$("#modify").css('display','block');
  });  
	$('.hersquxiao').click(function()
	{
		$("#modify").css('display','none');
		$("#datas").css('display','block');
  });
  $('.hersbaocun').click(function()
	{
	  var name=$("#name").val();
	  if(name!=""&&name!="请输入新昵称")
		{ 
			if(name.length>8)
			{
				layer.alert('昵称最多为八位', 
				{
					skin: 'layui-layer-molv' //样式类名
					,closeBtn: 0,
					shift: 5,
					icon: 2,
				}, function(){
				layer.closeAll();
				});
			}
			else
			{
				 $.getJSON("/index.php/Personal/edit_name/name/"+name+"/", {},
        function(data)
				{
					if(data["state"]==0)
					{
					 	layer.alert('修改完成', 
						{
							skin: 'layui-layer-molv' //样式类名
							,closeBtn: 0,
							shift: 5,
							icon: 1
						}, function(){
							window.location.href="";
						});
					}
				});
			}
    }
	  else
	  {
			layer.alert('昵称不能为空', 
			{
				skin: 'layui-layer-molv' //样式类名
				,closeBtn: 0,
				shift: 5,
				icon: 2,
			}, function(){
			 layer.closeAll();
			});
	  }      
  });
	})
</script>  
<script src="/public/js/wind.js"></script>	
<script type="text/javascript" src="/public/js/datePicker/datePicker.js"></script>
<script type="text/javascript" src="/public/home/js/Personal.js"></script>  
</body>
</html>