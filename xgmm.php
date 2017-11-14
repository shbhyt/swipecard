<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link href="assets/css/bootstrap.css" rel="stylesheet">
<meta charset="UTF-8">
<title>修改密碼</title>
<style type="text/css">
	form{
		text-align: center;
	}
</style>
<script type="text/javascript">
	function alter() {
		
		var oldpassword=document.getElementById("oldpassword").value;
		var newpassword=document.getElementById("newpassword").value;
		var assertpassword=document.getElementById("assertpassword").value;
		var regex=/^[/s]+$/;

		if(regex.test(oldpassword)||oldpassword.length==0){
			alert("舊密碼格式不对");
			return false;
		}
		if(regex.test(newpassword)||newpassword.length==0) {
			alert("新密碼格式不对");
			return false;
		}
		if (assertpassword != newpassword||assertpassword==0) {
			alert("兩次密碼輸入不一致");
			return false;
		}
		return true;

	}
</script> 
</head>
<body>
	
	<form  action="alter_password.php" method="post" class="form-horizontal" onsubmit="return alter(this);">
		<!--用户名<input type="text" name="username" id ="username" /><br/>--> 
		請輸入舊密碼：<input type="password" name="oldpassword" id ="oldpassword"/><br/> 
		請輸入新密碼：<input type="password" name="newpassword" id="newpassword"/><br/> 
		確認新密碼：<input type="password" name="assertpassword" id="assertpassword"/><br/> 
		<input type="submit" value="修改密碼">
	</form>
</body>
</html>