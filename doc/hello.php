<?php 
	include 'common.php';
	header('Content-type:text/html;charset=utf8');
	$url 		=	$_GET['url'];
	$fun 		=	$_GET['fun'];

	$info 		=	json_decode(httpGet($url),1);

	if($fun=='getBaseInfo'){
		$str 	=	"状态码: {$info['ret']}  返回信息:  {$info[0]['msg']}<br/>
		返回数据: <br/>";
		
		foreach ($info['data']['info'][0] as $key => $value) {
			$temp	.=	$key.' : '.$value .'<br/>';
		}
		
		echo $str.$temp.'字段解释  id(用户id);user_nicename(用户昵称);avatar(用户头像);avatar_thumb(头像缩略图)<br/>
		sex(性别；0：保密，1：男；2：女);signature(签名);coin(金币);votes(映票数量);consumption(消费累计);votestotal (映票累计数量);province(省份);city(城市);birthday(生日);level(等级);lives();fans(粉丝)';
	}else if($fun=='updateFields'){
		$str 	=	"状态码: {$info['data']['code']}  返回信息:  {$info['data']['msg']}<br/>";
		echo $str;

	}else if($fun=='getCityList'){
		$str 	=	"状态码: {$info['data']['code']}  返回信息:  {$info['data']['msg']}<br/>";
		foreach ($info['data']['info'][0] as $key => $value) {	
				$temp	.=	' 城市名'.' : '.$value['region_name'] .'<br/>';				
		}
		echo $str.$temp;
	}
?>