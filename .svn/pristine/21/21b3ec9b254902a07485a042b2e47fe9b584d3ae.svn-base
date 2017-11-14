<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>正在修改密码</title>
</head>
<body>
	<?php
	
	include("mysql_config.php");
	session_start();
	$username = $_SESSION['userName'];
    $oldpassword = $_REQUEST ["oldpassword"];
	$newpassword = $_REQUEST ["newpassword"];

    if($username=="")
    {
    ?>
    <script type="text/javascript">
		alert('請重新登入!!');
		top.location.href="Login.php";
	</script>
    <?php
    }
	else
    {
    	$dbusername = null;
    	$dbpassword = null;
    	$result_sql = "select UserID,Password from user_data where UserID ='$username'";
    	//echo $result_sql."<br>";
    	
    	$result = $mysqli->query($result_sql);
    	while($row = $result->fetch_row()){
    		$dbusername = $row [0];
    		$dbpassword = $row [1];
    	}
    	mysqli_free_result($result);
    	// echo $dbusername."<br>";
    
    	if ($oldpassword != $dbpassword) {
    		?>
    	<script type="text/javascript">
    		alert("舊密碼輸入錯誤!!");
    		window.location.href="xgmm.php";
    	</script>
    	<?php
    	}
        else
        {
        	$update_sql = "update  user_data set Password='$newpassword' where UserID='$username'";
        	$mysqli->query($update_sql);
            $mysqli->close();
        	?>
        	<script type="text/javascript">
        		alert("密碼修改成功");
                window.location.href="xgmm.php";
        	</script>
    <?php
        }
    }
    ?>
</body>
</html>