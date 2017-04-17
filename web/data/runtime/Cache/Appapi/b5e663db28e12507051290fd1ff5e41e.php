<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta content="telephone=no" name="format-detection" />
		<title>我的等级</title>
		<link href='/web/public/appapi/css/level.css' rel="stylesheet" type="text/css" >
	</head>
<body >

	<div class="main">
		<div class="level">
			<div class="level_val">
				<ul>
					<li>累计经验值：<span id="total"><?php echo ($experience); ?></span></li>
					<li>距离升级还差：<span id="next_diff"><?php echo ($cha); ?></span></li>
				</ul>
			</div>

			<div class="pie">
		        <div class="pie_left"><div class="left"></div></div>
		        <div class="pie_right"><div class="right"></div></div>
		        <div class="mask">
		         <div id="level"><?php echo ($level['levelid']); ?></div>
		         <div style="" id="mylevel">我的等级</div>
		         <div class="clear"></div> 
		        </div>
		  </div>
		</div>
		<div class="text">
			<h2>等级权益</h2>
			<p>1. 不同等级图标不同，越高越尊贵</p>
			<p>2. 你的身份一眼可见，尊贵显而易见</p>
			<h2 style="margin-top:30px">如何升级</h2>
			<p>1. 送礼物是升级最快的办法，送的越多升级越快！</p>
		</div>
	</div>
</body>

<script src="/web/public/js/jquery.js"></script>
<script>
$(document).ready(function() {
  var percent = 0.30;
	var pie_width = 134;
	var doc_width = $(document).width();
	if (doc_width < 360) {
		pie_width = Math.ceil(doc_width * percent);
		if (pie_width % 2 > 0) pie_width++;
	}
	$('.pie').css('width', pie_width+'px')
			 .css('height', pie_width+'px')
			 .css('background-size', pie_width+'px '+pie_width+'px')
			 .css('top', (200-pie_width)/2+'px ');


	$('.pie_left').css('width', pie_width+'px');
	$('.pie_left').css('height', pie_width+'px');
	$('.pie_right').css('width', pie_width+'px');
	$('.pie_right').css('height', pie_width+'px');
	$('.left').css('width', pie_width+'px');
	$('.left').css('height', pie_width+'px');
	$('.right').css('width', pie_width+'px');
	$('.right').css('height', pie_width+'px');

	$('.pie_right').css('clip', 'rect(0,auto,auto,'+(pie_width / 2)+'px)');
	$('.right').css('clip', 'rect(0,auto,auto,'+(pie_width / 2)+'px)');

	$('.pie_left').css('clip', 'rect(0,'+(pie_width / 2)+'px,auto,0)');
	$('.left').css('clip', 'rect(0,'+(pie_width / 2)+'px,auto,0)');

	$('.mask').css('width', (pie_width - 14)+'px');
	$('.mask').css('height', (pie_width - 14)+'px');
	$('.mask').css('line-height', (pie_width - 14)+'px');


    var num = Math.round(<?php echo ($rate); ?> * 3.6);

    //if (num == 0) num = 360;
    if (num <= 180) {
        $(this).find('.right').css('transform', 'rotate(' + num + 'deg)');
    } else {
        $(this).find('.right').css('transform', 'rotate(180deg)');
        $(this).find('.left').css('transform', 'rotate(' + (num - 180) + 'deg)');
    }
})
</script>
</body>
</html>