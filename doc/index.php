<html>
<head>
	<meta charset="UTF-8">
	<title>接口文档</title>
	<script src="http://yunbaolivein.oss-cn-hangzhou.aliyuncs.com/yunbaozhibo/jquery.1.10.2.js"></script> 
</head>
<body>

	<h1 style="text-align: center">云豹直播手机直播程序API接口说明</h1>
	<div style="border: 1px solid gray;background: #C9C9C9;box-shadow: 2px 2px 2px  gray;">
		<ul>		
		<li>个人信息接口
			<ol>
				<li>请求地址：<input id="getBaseInfo" style="width:90%" type="text" value="http://192.168.1.109/api/public/?service=User.getBaseInfo&uid=5&token=d7949b31d9c922ceea63cacd1a08b46b"></li>
				<li>请求方式：GET</li>
				<li style="color: red">请求参数：uid(用户id)必填  tokon(授权token)必填</li>
				<li>返回信息：<input type="button" value="测试" onClick="testUrl('getBaseInfo')">
					<input type="button" value="关闭" onClick="closeInfo('getBaseInfo')">
				</li>
				<span class="getBaseInfo"></span>
			</ol>
		</li>
		<div style="height: 50px;"></div>
		<li>修改个人信息
			<ol>
				<li>请求地址：<input id="updateFields" style="width:90%" type="text" value="http://192.168.1.109/api/public/?service=User.updateFields&uid=5&token=d7949b31d9c922ceea63cacd1a08b46b&user_nicename=vivian&city=合肥"></li>
				<li>请求方式：GET</li>
				<li style="color: red">请求参数：uid(用户id)必填  tokon(授权token)必填 选填字段user_nicename(昵称) sex(性别；0：保密，1：男；2：女) birthday(2017-04-06) province(省份) city(城市) signature(签名)</li>
				<li>返回信息：<input type="button" value="测试" onClick="testUrl('updateFields')">
					<input type="button" value="关闭" onClick="closeInfo('updateFields')">
				</li>
				<span class="updateFields"></span>
			</ol>
		</li>
		<div style="height: 50px;"></div>
		<li>获取城市列表：
			<ol>
				<li>请求地址：<input id="getCityList" style="width:90%" type="text" value="http://192.168.1.109/api/public/?service=Home.getCityList&city=1"></li>
				<li>请求方式：GET</li>
				<li style="color: red">city(城市id)可填,如果不填,默认返回所有省列表</li>
				<li>返回信息：<input type="button" value="测试" onClick="testUrl('getCityList')">
					<input type="button" value="关闭" onClick="closeInfo('getCityList')">
				</li>
				<span class="getCityList"></span>
			</ol>
		</li>
	</ul>
	</div>
	<script>
		function closeInfo(obj){
			$('.'+obj).hide(200);
		}
		function testUrl(methodName){		
			 $.ajax({
             type: "GET",
             url: "hello.php",
             data: {url:$('#'+methodName).val(),'fun':methodName},   
             success: function(data){
                         $('.'+methodName).html(data).show();
                         console.log(data);
                      },

			 });
			
			/*var url 	=	document.getElementById(methodName).value;
			var xhr		=	new XMLHttpRequest();
			xhr.open('GET','hello.php?url="'+url+'"',true);
			xhr.send(null);
			xhr.onreadystatechange=function(){
				var tips 	=	document.getElementById('tips');
				if(this.readyState==4){
					tips.innerHTML=	this.responseText;
					
				}
			
			}*/
			
			
		}
	</script>
</body>
</html>